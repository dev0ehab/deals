<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Requests\Api\RegisterRequest;
use Modules\Vendors\Http\Requests\Api\SocialRegisterRequest;
use Modules\Vendors\Http\Requests\Api\VerifyRequest;
use Modules\Carts\Entities\Cart;
use Modules\Support\Traits\ApiTrait;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Handle a login request to the application.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->allWithHashedPassword();
        $data[$request->username_type] = $request->username;
        $vendor = Vendor::create($data);

        $verificationController = new VerificationController();
        $verifyRequest = new VerifyRequest($request->only('username', 'username_type'));
        $verify = $verificationController->send($verifyRequest);

        if ($verify->getStatusCode() == 400) {
            return $this->sendError(data_get($verify->getOriginalContent(), 'message', 'error'));
        }


        return $this->sendResponse($vendor->getResource(), trans('vendors::verification.sent'));
    }


    /**
     * Handle a login request to the application.
     *
     * @param SocialRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function socialRegister(SocialRegisterRequest $request)
    {
        $vendor = Vendor::where($request->social_type . '_id', $request->social_id)->first();

        if ($vendor) {

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

        } else {

            $data = $request->validated();
            $data[$request->social_type . "_id"] = $request->social_id;
            $vendor = Vendor::create($data);
        }

        $response = [
            'message' => 'success',
            'success' => true,
            'data'    => $vendor->getResource(),
            'token'   => $vendor->createToken('MyApp')->plainTextToken,
        ];

        return response()->json($response);
    }
}
