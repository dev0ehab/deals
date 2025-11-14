<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Requests\Api\LoginRequest;
use Modules\Vendors\Http\Requests\Api\SocialLoginRequest;
use Modules\Vendors\Http\Requests\Api\VerifyRequest;
use Modules\Support\Traits\ApiTrait;

class LoginController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $vendor = Vendor::where(function ($query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        if ($vendor->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('vendors::auth.blocked'));
        }

        if (!Hash::check($request->password, $vendor->password)) {
            return $this->sendError(trans('vendors::vendors.messages.password'));
        }


        $this->checkVerification($vendor, $request->all());

        event(new Login('sanctum', $vendor, false));

        $vendor->last_login_at = Carbon::now()->toDateTimeString();
        $vendor->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($vendor->device_token === null || $vendor->device_token != $request->device_token) {
            $vendor->device_token = $request->device_token;
        }

        $vendor->push();

        $response = [
            'success' => true,
            'data' => $vendor->getResource(),
            'token' => $vendor->createToken('MyApp')->plainTextToken,
            'message' => 'success',
        ];

        return response()->json($response);
    }

    /**
     * Handle a socialLogin request to the application.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function socialLogin(SocialLoginRequest $request)
    {
        $vendor = Vendor::where($request->social_type . '_id', $request->social_id)->first();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        if ($vendor->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('vendors::auth.blocked'));
        }

        event(new Login('sanctum', $vendor, false));

        $vendor->last_login_at = Carbon::now()->toDateTimeString();
        $vendor->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($vendor->device_token === null || $vendor->device_token != $request->device_token) {
            $vendor->device_token = $request->device_token;
        }

        $vendor->push();

        $response = [
            'success' => true,
            'data' => $vendor->getResource(),
            'token' => $vendor->createToken('MyApp')->plainTextToken,
            'message' => 'success',
        ];

        return response()->json($response);
    }


    public function unauthenticated()
    {
        return $this->sendError(__('You are unauthenticated, please login'));
    }



    private function checkVerification($vendor, $requestArray)
    {
        $username_type = $requestArray['username_type'];
        if ((!$vendor->hasVerifiedPhone() && $username_type == 'phone') || (!$vendor->hasVerifiedEmail() && $username_type == 'email')) {

            $verificationController = new VerificationController();
            $verifyRequest = new VerifyRequest([
                'username' => $requestArray['username'],
                'username_type' => $username_type
            ]);

            $verify = $verificationController->send($verifyRequest);

            auth()->logout();
            $data = $vendor->getResource();
            throw new HttpResponseException($this->sendResponse($data, trans("vendors::verification.{$username_type}_not_verified")));
        }
    }
}
