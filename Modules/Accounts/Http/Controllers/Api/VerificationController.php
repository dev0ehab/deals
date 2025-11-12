<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Http\Requests\Api\VerificationRequest;
use Modules\Accounts\Http\Requests\Api\VerifyRequest;
use Modules\Support\Traits\ApiTrait;

class VerificationController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Send or resend the verification code.
     *
     * @param VerifyRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function send(VerifyRequest $request): JsonResponse
    {
        $user = User::where(function (Builder $query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();


        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }


        $verification = Verification::updateOrCreate([
            'parentable_id' => $user->id,
            'parentable_type' => $user->getMorphClass(),
            'username' => $request->username,
        ], [
            // 'code' => random_int(1111, 9999),
            'code' => 1234,
            'updated_at' => now(),
        ]);

        event(new VerificationCreated($verification, $request->username_type));

        return $this->sendSuccess(trans('accounts::verification.sent'));
    }

    /**
     * Verify the user's phone number.
     *
     * @param VerificationRequest $request
     * @return JsonResponse
     */
    public function verify(VerificationRequest $request)
    {
        $verification = Verification::where([
            'username' => $request->username,
            'code' => $request->code,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('accounts::verification.invalid'));
        }
        $user = $verification->parentable;

        $response = [
            'success' => true,
            'data' => $user->getResource(),
            'token' => $user->createToken('MyApp')->plainTextToken,
            'message' => trans('accounts::verification.is_verified')
        ];

        $user->update(["{$request->username_type}_verified_at" => now()]);
        $verification->delete();

        return response()->json($response);
    }
}
