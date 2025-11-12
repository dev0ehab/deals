<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Http\Requests\Api\AuthenticableRequest;
use Modules\Accounts\Http\Requests\Api\PasswordUpdateRequest;
use Modules\Accounts\Http\Requests\Api\ProfileRequest;
use Modules\Accounts\Http\Requests\Api\VerifyAuthenticableRequest;
use Modules\Support\Traits\ApiTrait;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    public function __construct()
    {
        $this->middleware('isUser');
    }

    /**
     * Display the authenticated user resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }
        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the authenticated user profile.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->except('password');

        if (!$user) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        if (isset($data['email']) && $data['email'] != $user->email) {
            $data["email_verified_at"] = null;
        }

        if (isset($data['phone']) && $data['phone'] != $user->phone) {
            $data["phone_verified_at"] = null;
        }

        $user->update($data);

        if ($request->avatar && $request->avatar != null) {
            $user->addMediaFromBase64($request->avatar)
                ->usingFileName('avatar.png')
                ->toMediaCollection('avatars');
        }


        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the authenticated user profile.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = auth()->user();

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @return JsonResponse
     */
    public function exist(): JsonResponse
    {
        $user = auth()->user();
        if (!$user->exists()) {
            return $this->sendError(trans('accounts::auth.failed'));
        }

        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function preferredLocale(Request $request): JsonResponse
    {
        $user = auth()->user();

        $user->preferred_locale = $request->preferred_locale;

        $user->push();

        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        //remove device token
        $user->update([
            'device_token' => null
        ]);

        $user->tokens()->delete();
        return $this->sendSuccess(__('You Have Signed Out Successfully'));
    }


    public function delete(Request $request)
    {
        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError(trans('accounts::users.messages.password'));
        }

        $user->forceDelete();

        return $this->sendSuccess(trans('accounts::users.messages.request_delete'));
    }


    /**
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return $this->sendError('false');
        } else {
            return $this->sendSuccess('true');
        }
    }

    public function updateAuthenticable(AuthenticableRequest $request)
    {
        $user = User::find(auth()->user()->id);


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

        $data = $user->getResource();

        return $this->sendResponse($data, trans('accounts::verification.sent'));
    }

    public function verifyAuthenticable(VerifyAuthenticableRequest $request)
    {
        $user = User::find(auth()->user()->id);

        $verification = Verification::where([
            'parentable_id' => $user->id,
            'parentable_type' => $user->getMorphClass(),
            'code' => $request->code,
            'username' => $request->username,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('accounts::verification.invalid'));
        }

        $user->forceFill([
            $request->username_type => $verification->username,
        ])->save();

        $verification->delete();

        $data = $user->getResource();

        return $this->sendResponse($data, __('Phone updated successfully.'));
    }


    public function updateFcm(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('device_token', "order_notification"));
        $data = $user->getResource();
        return $this->sendResponse($data, 'success');
    }
}
