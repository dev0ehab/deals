<?php

namespace Modules\Vendors\Http\Controllers\Api;

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
use Modules\Vendors\Entities\Vendor;
use Modules\Accounts\Events\ResetPasswordCreated;
use Modules\Vendors\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Vendors\Http\Requests\Api\ResetPasswordCodeRequest;
use Modules\Vendors\Http\Requests\Api\ResetPasswordRequest;
use Modules\Support\Traits\ApiTrait;

class ResetPasswordController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Send forget password code to the vendor.
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forget(ForgetPasswordRequest $request): JsonResponse
    {
        $resetPasswordCode = ResetPasswordCode::updateOrCreate([
            'username' => $request->username,
            'type' => 'vendor',
        ], [
            'username' => $request->username,
            'type' => 'vendor',
            // 'code' => random_int(1000, 9999),
            'code' => 1234,
            'created_at' => Carbon::now()
        ]);

        event(new ResetPasswordCreated($resetPasswordCode , $request->username_type));

        return $this->sendSuccess(trans("vendors::auth.messages.forget-password-code-sent-$request->username_type"));
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
            ->where('type', 'vendor')
            ->first();

        $vendor = Vendor::where(function (Builder $query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();

        if (!$resetPasswordCode || $resetPasswordCode->isExpired() || !$vendor) {
            return $this->sendError(trans('validation.exists', [
                'attribute' => trans('vendors::auth.attributes.code'),
            ]));
        }
        $resetPasswordCode->delete();
        $reset_token = ResetPasswordToken::forceCreate([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'token' => $token = Str::random(80),
        ]);

        $data = $vendor->getResource();

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
                'attribute' => trans('vendors::auth.attributes.token'),
            ]));
        }

        $vendor = $resetPasswordToken->parentable;


        $vendor->update([
            'password' => Hash::make($request->password),
        ]);

        event(new Login('sanctum', $vendor, false));

        $resetPasswordToken->delete();

        $data = $vendor->getResource();

        return $this->sendResponse($data, __('Password updated successfully.'));
    }
}
