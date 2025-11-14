<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Vendors\Http\Requests\Api\AuthenticableRequest;
use Modules\Vendors\Http\Requests\Api\PasswordUpdateRequest;
use Modules\Vendors\Http\Requests\Api\ProfileRequest;
use Modules\Vendors\Http\Requests\Api\VerifyAuthenticableRequest;
use Modules\Support\Traits\ApiTrait;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    public function __construct()
    {
        $this->middleware('isVendor');
    }

    /**
     * Display the authenticated vendor resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $vendor = auth()->user();

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }
        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the authenticated vendor profile.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function update(ProfileRequest $request)
    {
        $vendor = auth()->user();

        $data = $request->except('password');

        if (!$vendor) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        if (isset($data['email']) && $data['email'] != $vendor->email) {
            $data["email_verified_at"] = null;
        }

        if (isset($data['phone']) && $data['phone'] != $vendor->phone) {
            $data["phone_verified_at"] = null;
        }

        $vendor->update($data);

        if ($request->avatar && $request->avatar != null) {
            $vendor->addMediaFromBase64($request->avatar)
                ->usingFileName('avatar.png')
                ->toMediaCollection('avatars');
        }


        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the authenticated vendor profile.
     *
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $vendor = auth()->user();

        if ($request->password) {
            $vendor->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @return JsonResponse
     */
    public function exist(): JsonResponse
    {
        $vendor = auth()->user();
        if (!$vendor->exists()) {
            return $this->sendError(trans('vendors::auth.failed'));
        }

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function preferredLocale(Request $request): JsonResponse
    {
        $vendor = auth()->user();

        $vendor->preferred_locale = $request->preferred_locale;

        $vendor->push();

        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }

    public function logout(Request $request)
    {
        $vendor = auth()->user();
        //remove device token
        $vendor->update([
            'device_token' => null
        ]);

        $vendor->tokens()->delete();
        return $this->sendSuccess(__('You Have Signed Out Successfully'));
    }


    public function delete(Request $request)
    {
        $vendor = $request->user();

        if (!Hash::check($request->password, $vendor->password)) {
            return $this->sendError(trans('vendors::vendorss.messages.password'));
        }

        $vendor->forceDelete();

        return $this->sendSuccess(trans('vendors::vendorss.messages.request_delete'));
    }


    /**
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $vendor = auth()->user();

        if (!$vendor) {
            return $this->sendError('false');
        } else {
            return $this->sendSuccess('true');
        }
    }

    public function updateAuthenticable(AuthenticableRequest $request)
    {
        $vendor = Vendor::find(auth()->user()->id);


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

        $data = $vendor->getResource();

        return $this->sendResponse($data, trans('vendors::verification.sent'));
    }

    public function verifyAuthenticable(VerifyAuthenticableRequest $request)
    {
        $vendor = Vendor::find(auth()->user()->id);

        $verification = Verification::where([
            'parentable_id' => $vendor->id,
            'parentable_type' => $vendor->getMorphClass(),
            'code' => $request->code,
            'username' => $request->username,
        ])->first();

        if (!$verification || $verification->isExpired()) {
            return $this->sendError(trans('vendors::verification.invalid'));
        }

        $vendor->forceFill([
            $request->username_type => $verification->username,
        ])->save();

        $verification->delete();

        $data = $vendor->getResource();

        return $this->sendResponse($data, __('Phone updated successfully.'));
    }


    public function updateFcm(Request $request)
    {
        $vendor = auth()->user();
        $vendor->update($request->only('device_token', "order_notification"));
        $data = $vendor->getResource();
        return $this->sendResponse($data, 'success');
    }
}
