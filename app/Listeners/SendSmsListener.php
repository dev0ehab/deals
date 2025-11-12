<?php

namespace App\Listeners;

use App\Events\OtpRegister;
use App\Services\SmsService;
use Illuminate\Support\Facades\Log;

class SendSmsListener
{
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
     * @param  \App\Providers\OtpSent  $event
     * @return void
     */
    public function handle(OtpRegister $event)
    {
        try {
            $smsService = app(SmsService::class);
            $response =  $smsService->send($event->user?->phone, $event->user->name, $event->otp->code);
            if (data_get($response, 'status') != 200 || data_get($response, 'body.status') != 'S') {
                Log::error('Failed to send OTP phone to user ' . $event->user->id . ': ' . $response['body']['message']);
                $event->otp->delete();
                $event->user->delete();
                session()->flash('error_otp_mail', 'There was an error sending the OTP to phone. Please try again later.');
            }
        } catch (\Throwable $th) {
            Log::error('Failed to send OTP phone to user ' . $event->user->id . ': ' . $th->getMessage());
            $event->otp->delete();
            $event->user->delete();
            session()->flash('error_otp_mail', 'There was an error sending the OTP to phone. Please try again later.');
        }
    }
}
