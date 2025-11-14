<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Vendors\Http\Requests\Api\VerificationRequest;
use Modules\Vendors\Http\Requests\Api\VerifyRequest;
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
        $vendor = Vendor::where(function (Builder $query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();


        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }


        $verification = Verification::updateOrCreate([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'username' => $request->username,
        ], [
            // 'code' => random_int(1111, 9999),
            'code' => 1234,
            'updated_at' => now(),
        ]);

        event(new VerificationCreated($verification, $request->username_type));

        return $this->sendSuccess(trans('vendors::verification.sent'));
    }

    /**
     * Verify the vendor's phone number.
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
            return $this->sendError(trans('vendors::verification.invalid'));
        }
        $vendor = $verification->parentable;

        $response = [
            'success' => true,
            'data' => $vendor->getResource(),
            'token' => $vendor->createToken('MyApp')->plainTextToken,
            'message' => trans('vendors::verification.is_verified')
        ];

        $vendor->update(["{$request->username_type}_verified_at" => now()]);
        $verification->delete();

        return response()->json($response);
    }
}
