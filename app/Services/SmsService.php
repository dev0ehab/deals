<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SmsService
{

    /**
     * @param string $phoneNumber
     * @param string $name
     * @param string $code
     * @return array
     */
    public function send(string $phoneNumber, string $name, string $code): array
    {
        $url = config('sms.general.sms_url');

        $phoneNumber = substr($phoneNumber, 1);
        $phoneNumber = "+966$phoneNumber";
        $data = [
            'api_id' => config('sms.general.api_id'),
            'api_password' => config('sms.general.api_password'),
            'sms_type' => config('sms.general.sms_type'),
            'encoding' => config('sms.general.encoding'),
            'sender_id' => config('sms.general.sender_id'),
            'phonenumber' => $phoneNumber,
            'templateid' => config('sms.general.templateid'),
            'V1' => $name,
            'V2' => $code
        ];
        $response = Http::get($url, $data);
        $response_status = $response->status();
        $response_body = $response->json();
        return [
            'status' => $response_status,
            'body' => $response_body
        ];
    }

    /**
     * @param string $phoneNumber
     * @param string $name
     * @param string $msg
     * @return array
     */
    public function sendDreams(string $phoneNumber, string $name, string $msg): array
    {
        return [] ;
        $url = config('sms.dreams.sms_url');
        $phoneNumber = substr($phoneNumber, 1);
        $phoneNumber = "966$phoneNumber";
        $data = [
            "user" => config('sms.dreams.sms_user_name'),
            "secret_key" => config('sms.dreams.sms_password'),
            "to" => $phoneNumber,
            "message" => $msg,
            "sender" => config('sms.dreams.sms_sender'),
            "date" => Carbon::now()->format('Y-m-d'),
            "time" => Carbon::now()->format('H:i:s'),
        ];

        $response = Http::get($url, $data);
        $response_status = $response->status();

        return [
            'status' => $response_status,
        ];
    }
}
