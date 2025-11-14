<?php

namespace Modules\Vendors\Entities\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Notifications\EmailVerificationNotification;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Transformers\VendorsResource;

trait VendorHelpers
{
    /**
     * Determine whether the vendor is verified phone.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ($this->phone_verified_at != null);
    }


    /**
     * Verify vendor phone.
     *
     * @return $this
     */
    public function setVerified(): self
    {
        $this->forceFill([
            'phone_verified_at' => Carbon::now(),
        ])->save();

        return $this;
    }



    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }


    /**
     * Get the resource for vendor type.
     *
     * @return VendorsResource
     */
    public function getResource()
    {
        return new VendorsResource($this);
    }


    /**
     * Get the vendor's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        return $this->preferred_locale ?? app()->getLocale();
    }

    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param string|null $device
     * @return string
     */
    public function createTokenForDevice($device = null): string
    {
        $device = $device ?: 'Unknown Device';

        if ($this->currentAccessToken()) {
            return $this->currentAccessToken()->token;
        }

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }


    public function getAvatar()
    {
        return $this->getFirstMediaUrl('avatars');
    }


    /**
     * @return Vendor
     */
    public function block()
    {
        return $this->forceFill(['blocked_at' => Carbon::now()]);
    }

    /**
     * @return Vendor
     */
    public function unblock()
    {
        return $this->forceFill(['blocked_at' => null]);
    }

    public function getVerificationCode()
    {
        return Verification::where([
            'parentable_id' => $this->id,
            'parentable_type' => $this->getMorphClass(),
            'username' => $this->phone,
        ])->first()->code;
    }



    public function sendVerificationCode(): void
    {
        if (!$this || $this->email_verified_at || $this->phone_verified_at) {
            throw ValidationException::withMessages([
                'phone' => [trans('vendors::verification.verified')],
            ]);
        }

        $verification = Verification::updateOrCreate([
            'parentable_id' => $this->id,
            'parentable_type' => $this->getMorphClass(),
            'username' => $this->phone,
        ], [
            'code' => random_int(1111, 9999),
        ]);

        event(new VerificationCreated($verification));
    }


    /**
     * send verification sms to delivery
     * @param $phone
     * @param $code
     */
    public function sendSmsVerificationNotification($phone, $code): void
    {
        $greetings = trans('vendors::auth.register.verification.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('vendors::auth.register.verification.line', [
            'code' => $code,
            'app' => Config::get('app.name'),
        ]);
        $footer = trans('vendors::auth.register.verification.footer');
        $salutation = trans('vendors::auth.register.verification.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    /**
     *
     * send Reset Password sms to delivery
     *
     */


    /**
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification($this->verify->code));
    }


    /**
     * send reset password sms
     * @param $code
     */
    public function sendSmsResetPasswordNotification($code): void
    {
        $greetings = trans('vendors::auth.emails.forget-password.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('vendors::auth.emails.forget-password.line', [
            'code' => $code,
            'minutes' => ResetPasswordCode::EXPIRE_DURATION / 60,
        ]);
        $footer = trans('vendors::auth.emails.forget-password.footer');
        $salutation = trans('vendors::auth.emails.forget-password.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . " " . $line . " " . $footer . " " . $salutation;
        $phone = $this->phone;

        if (request('test_mode') != 1 || !request('test_mode')) {
            // $smsService = app(SmsService::class);
            // $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    public function hasPackage($washer = null, $size = null, $service = null): bool
    {
        return false;
    }


}
