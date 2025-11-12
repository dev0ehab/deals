<?php

namespace Modules\Accounts\Listeners;

use Illuminate\Support\Facades\Storage;
use Modules\Accounts\Events\ResetPasswordCreated;


class SendResetPasswordCode
{
    public $resetPasswordCode;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ResetPasswordCreated $event
     * @return void
     */
    public function handle(ResetPasswordCreated $event)
    {

        $this->resetPasswordCode = $event->resetPasswordCode;


        switch ($event->username_type) {
            case 'phone':
                $this->sendSms();
                break;
            case 'email':
                $this->sendEmail();
                break;

            default:
                # code...
                break;
        }

        $event->resetPasswordCode->user->sendSmsResetPasswordNotification($event->resetPasswordCode->code);

        /* @deprecated */
        Storage::disk('public')->append(
            'resetPassword.txt',
            "The reset password code for phone {$event->resetPasswordCode->username} is {$event->resetPasswordCode->code} generated at " . now()->toDateTimeString() . "\n"
        );
    }




    private function sendSms()
    {
        if (env("SMS_LIVE_MODE")) {
            $this->resetPasswordCode->user->sendSmsResetPasswordNotification($this->resetPasswordCode->code);
        }
    }
    private function sendEmail()
    {
        // $this->resetPasswordCode->parentable->sendEmailVerificationNotifications($this->resetPasswordCode->code);
    }
}
