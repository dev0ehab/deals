<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\Api\LoginRequest;
use Modules\Accounts\Http\Requests\Api\SocialLoginRequest;
use Modules\Accounts\Http\Requests\Api\VerifyRequest;
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
        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->username);
            $query->orWhere('phone', $request->username);
        })->first();

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        if ($user->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('accounts::auth.blocked'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError(trans('accounts::users.messages.password'));
        }


        $this->checkVerification($user, $request->all());

        event(new Login('sanctum', $user, false));

        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($user->device_token === null || $user->device_token != $request->device_token) {
            $user->device_token = $request->device_token;
        }

        $user->push();

        $response = [
            'success' => true,
            'data' => $user->getResource(),
            'token' => $user->createToken('MyApp')->plainTextToken,
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
        $user = User::where($request->social_type . '_id', $request->social_id)->first();

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        if ($user->blocked_at) {
            auth()->logout();
            return $this->sendError(trans('accounts::auth.blocked'));
        }

        event(new Login('sanctum', $user, false));

        $user->last_login_at = Carbon::now()->toDateTimeString();
        $user->preferred_locale = $request->preferred_locale ?? app()->getLocale();

        if ($user->device_token === null || $user->device_token != $request->device_token) {
            $user->device_token = $request->device_token;
        }

        $user->push();

        $response = [
            'success' => true,
            'data' => $user->getResource(),
            'token' => $user->createToken('MyApp')->plainTextToken,
            'message' => 'success',
        ];

        return response()->json($response);
    }


    public function unauthenticated()
    {
        return $this->sendError(__('You are unauthenticated, please login'));
    }



    private function checkVerification($user, $requestArray)
    {
        $username_type = $requestArray['username_type'];
        if ((!$user->hasVerifiedPhone() && $username_type == 'phone') || (!$user->hasVerifiedEmail() && $username_type == 'email')) {

            $verificationController = new VerificationController();
            $verifyRequest = new VerifyRequest([
                'username' => $requestArray['username'],
                'username_type' => $username_type
            ]);

            $verify = $verificationController->send($verifyRequest);

            auth()->logout();
            $data = $user->getResource();
            throw new HttpResponseException($this->sendResponse($data, trans("accounts::verification.{$username_type}_not_verified")), 200);
        }
    }
}
