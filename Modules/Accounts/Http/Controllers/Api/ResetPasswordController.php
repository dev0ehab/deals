<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Accounts\Entities\ResetPasswordToken;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Events\ResetPasswordCreated;
use Modules\Accounts\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Accounts\Http\Requests\Api\ResetPasswordCodeRequest;
use Modules\Accounts\Http\Requests\Api\ResetPasswordRequest;
use Modules\Support\Traits\ApiTrait;

class ResetPasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Send forget password code to the user.
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forget(ForgetPasswordRequest $request): JsonResponse
    {
        $resetPasswordCode = ResetPasswordCode::updateOrCreate([
            'username' => $request->username,
            'type' => 'user',
        ], [
            'username' => $request->username,
            'type' => 'user',
            // 'code' => random_int(1000, 9999),
            'code' => 1234,
            'created_at' => Carbon::now()
        ]);

        event(new ResetPasswordCreated($resetPasswordCode , $request->username_type));

        return $this->sendSuccess(trans("accounts::auth.messages.forget-password-code-sent-$request->username_type"));
    }

    /**
     * Get the reset password token using verification code.
     *
     * @param ResetPasswordCodeRequest $request
     * @return JsonResponse
     */
    public function code(ResetPasswordCodeRequest $request): JsonResponse
    {
        $resetPasswordCode = ResetPasswordCode::where('username', $request->username)
            ->where('code', $request->code)
            ->where('type', 'user')
            ->first();

        $user = User::where(function (Builder $query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();

        if (!$resetPasswordCode || $resetPasswordCode->isExpired() || !$user) {
            return $this->sendError(trans('validation.exists', [
                'attribute' => trans('accounts::auth.attributes.code'),
            ]));
        }
        $resetPasswordCode->delete();
        $reset_token = ResetPasswordToken::forceCreate([
            'parentable_id' => $user->id,
            'parentable_type' => $user->getMorphClass(),
            'token' => $token = Str::random(80),
        ]);

        $data = $user->getResource();

        $data['reset_token'] = $reset_token->token;

        return $this->sendResponse($data, 'success');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $resetPasswordToken = ResetPasswordToken::where($request->only('token'))->first();

        if (!$resetPasswordToken || $resetPasswordToken->isExpired()) {
            return $this->sendError(trans('validation.exists', [
                'attribute' => trans('accounts::auth.attributes.token'),
            ]));
        }

        $user = $resetPasswordToken->parentable;


        $user->update([
            'password' => Hash::make($request->password),
        ]);

        event(new Login('sanctum', $user, false));

        $resetPasswordToken->delete();

        $data = $user->getResource();

        return $this->sendResponse($data, __('Password updated successfully.'));
    }
}
