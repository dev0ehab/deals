<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    public function send(string $phone, string $code) : void
    {
        $token = config('services.whatsapp.token');
        $channelId = config('services.whatsapp.channelId');

        // Adjust Phone Number
        $phone = substr($phone, 1);
        $phone = '966' . $phone;

        $data = [
            "phone" =>  "{$phone}",
            "channelId" =>  93287,
            "templateName" =>  "authentication",
            "languageCode" =>  "ar",
            "text" =>  "رمز التحقق الخاص بك لتغير رقم الهاتف في تطبيق عقار محمد الأصيفر هو =>  {{1}}",
            "parameters" =>  [
                "{$code}"
            ],
            "tags" =>  [
                "api",
                "test"
            ]
        ];

        $data = json_encode($data);

        $response = Http::withBody($data, 'application/json')
        ->withToken($token)
            ->post('https://imapi.bevatel.com/whatsapp/api/message');
    }
}



// api_id:API63006360631
// api_password:green@100
// sms_type:T
// encoding:T
// sender_id:Atlobs
// phonenumber:+966549350972
// templateid:1028
// V1:test
// V2:1125
