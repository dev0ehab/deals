<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\Api\RegisterRequest;
use Modules\Accounts\Http\Requests\Api\SocialRegisterRequest;
use Modules\Accounts\Http\Requests\Api\VerifyRequest;
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
        $user = User::create($data);

        $verificationController = new VerificationController();
        $verifyRequest = new VerifyRequest($request->only('username', 'username_type'));
        $verify = $verificationController->send($verifyRequest);

        if ($verify->getStatusCode() == 400) {
            return $this->sendError(data_get($verify->getOriginalContent(), 'message', 'error'));
        }


        return $this->sendResponse($user->getResource(), trans('accounts::verification.sent'));
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
        $user = User::where($request->social_type . '_id', $request->social_id)->first();

        if ($user) {

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

        } else {

            $data = $request->validated();
            $data[$request->social_type . "_id"] = $request->social_id;
            $user = User::create($data);
        }

        $response = [
            'message' => 'success',
            'success' => true,
            'data'    => $user->getResource(),
            'token'   => $user->createToken('MyApp')->plainTextToken,
        ];

        return response()->json($response);
    }
}
