<?php

namespace Modules\Accounts\Listeners;

use Illuminate\Support\Facades\Storage;
use Modules\Accounts\Events\VerificationCreated;


class SendVerificationCode
{
    public $verification;
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
     * @param VerificationCreated $event
     * @return void
     */
    public function handle(VerificationCreated $event)
    {
        $this->verification = $event->verification;


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


        /* @deprecated */
        Storage::disk('public')->append(
            'verification.txt',
            "The verification code for phone {$event->verification->username} is {$event->verification->code} generated at " . now()->toDateTimeString() . "\n"
        );
    }



    private function sendSms()
    {
        if (env("SMS_LIVE_MODE") && !$this->verification->parentable->hasVerifiedPhone()) {
            $this->verification->parentable->sendSmsVerificationNotification($this->verification->username, $this->verification->code);
        }
    }
    private function sendEmail()
    {
        if (!$this->verification->parentable->hasVerifiedEmail()) {
            // $this->verification->parentable->sendEmailVerificationNotifications($this->verification->code);
        }
    }
}
