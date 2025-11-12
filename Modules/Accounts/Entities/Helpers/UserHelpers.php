<?php

namespace Modules\Accounts\Entities\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Entities\Verification;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Notifications\EmailResetPasswordNotification;
use Modules\Accounts\Notifications\EmailVerificationNotification;
use App\Services\SmsService;
use Illuminate\Support\Facades\Http;
use Modules\Addresses\Transformers\AddressesResource;

trait UserHelpers
{
    /**
     * Determine whether the user type is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->type === User::ADMIN_TYPE);
    }

    /**
     * Determine whether the user type is admin.
     *
     * @return bool
     */
    public function isVendor()
    {
        return $this->belongs_to_vendor;
    }


    /**
     * Determine whether the user type is admin.
     *
     * @return bool
     */
    public function isCompany()
    {
        return $this->hasRole("company");
    }

    /**
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return ($this->phone_verified_at != null);
    }

    /**
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ($this->email_verified_at != null);
    }

    /**
     * Set the user type.
     *
     * @return $this
     */
    public function setType($type)
    {
        if (in_array($type, array_keys(trans('accounts::users.types')))) {
            $this->forceFill([
                'type' => $type,
            ])->save();
        }

        return $this;
    }

    /**
     * Set the user type.
     *
     * @return $this
     */
    public function setVerified(): self
    {
        $this->forceFill([
            'email_verified_at' => Carbon::now(),
        ])->save();

        return $this;
    }

    /**
     * Determine whether the user can access dashboard.
     *
     * @return bool
     */
    public function canAccessDashboard()
    {
        return $this->isAdmin() || $this->can_access;
    }

    /**
     * The user profile image url.
     *
     */
    public function getAvatar()
    {
        return $this->getFirstMediaUrl('avatars');
    }

    /**
     * @return User
     */
    public function block()
    {
        return $this->forceFill(['blocked_at' => Carbon::now()]);
    }

    /**
     * @return User
     */
    public function unblock()
    {
        return $this->forceFill(['blocked_at' => null]);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . " " . $this->last_name;
    }

    /**
     * @return AddressesResource
     */
    public function getMainAddressAttribute()
    {
        return new AddressesResource($this->addresses()->where('is_default', 1)->first());
    }


    /**
     * @return mixed
     */
    public function getVerificationCode()
    {
        return Verification::where([
            'parentable_id' => $this->id,
            'parentable_type' => $this->getMorphClass(),
            'username' => $this->phone,
        ])->first()?->code ?? "";
    }


    /*
     *
     * send verification sms to user
     *
     * */




    /**
     * send verification sms to user
     * @param $phone
     * @param $code
     */
    public function sendSmsVerificationNotification($phone, $code): void
    {
        $greetings = trans('accounts::auth.register.verification.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('accounts::auth.register.verification.line', [
            'code' => $code,
            'app' => Config::get('app.name'),
        ]);
        $footer = trans('accounts::auth.register.verification.footer');
        $salutation = trans('accounts::auth.register.verification.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        if (request('test_mode') != 1 || !request('test_mode')) {
            $smsService = app(SmsService::class);
            $response = $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    /**
     * @param $phone
     * @param $code
     * @return void
     */
    public function sendSmsVerificationNotificationWA($phone, $code)
    {
        $token = config('services.whatsapp.token');
        $channelId = config('services.whatsapp.channelId');

        // Adjust Phone Number
        $phone = substr($phone, 1);
        $phone = '966' . $phone;

        $data = [
            "phone" => "{$phone}",
            "channelId" => 93287,
            "templateName" => "authentication",
            "languageCode" => "ar",
            "text" => "رمز التحقق الخاص بك لتسجيل الدخول الى تطبيق عقار محمد الأصيفر هو =>  {{1}}",
            "parameters" => [
                "{$code}"
            ],
            "tags" => [
                "api",
                "test"
            ]
        ];

        $data = json_encode($data);

        $response = Http::withBody($data, 'application/json')
            ->withToken($token)
            ->post('https://imapi.bevatel.com/whatsapp/api/message');
    }


    /*
     *
     * send Reset Password sms to user
     *
     * */


    /**
     * @return void
     */
    public function sendEmailVerificationNotifications($code): void
    {
        $this->notify(new EmailVerificationNotification($code));
    }

    /**
     * @return void
     */
    public function sendEmailResetPasswordNotification($code): void
    {
        $this->notify(new EmailResetPasswordNotification($code));
    }

    /**
     * send reset password sms
     * @param $code
     */
    public function sendSmsResetPasswordNotification($code): void
    {
        $greetings = trans('accounts::auth.emails.forget-password.greeting', [
            'user' => $this->name,
        ]);

        $line = trans('accounts::auth.emails.forget-password.line', [
            'code' => $code,
            'minutes' => ResetPasswordCode::EXPIRE_DURATION / 60,
        ]);

        $footer = trans('accounts::auth.emails.forget-password.footer');

        $salutation = trans('accounts::auth.emails.forget-password.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . ' ' . $line . ' ' . $footer . ' ' . $salutation;

        $phone = $this->phone;

        if (request('test_mode') != 1 || !request('test_mode')) {
            $smsService = app(SmsService::class);
            $smsService->sendDreams($phone, $this->name, $message);
        }
    }

    /**
     * send reset password sms
     * @param $password
     */
    public function sendSmsNewPasswordNotification($password): void
    {
        $greetings = trans('deliveries::auth.emails.new-password.greeting', [
            'user' => $this->name,
        ]);
        $line = trans('deliveries::auth.emails.new-password.line', ['password' => $password]);
        $footer = trans('deliveries::auth.emails.new-password.footer');
        $salutation = trans('deliveries::auth.emails.new-password.salutation', [
            'app' => Config::get('app.name'),
        ]);

        $message = $greetings . " " . $line . " " . $footer . " " . $salutation;
        $phone = $this->phone;

        if (env('SMS_LIVE_MODE')) {
            $smsService = app(SmsService::class);
            $smsService->sendDreams($phone, $this->name, $message);
        }
    }


    public function getHasSocialIdentifier(): bool
    {
        return  $this->facebook_id || $this->google_id || $this->apple_id;
    }
}
