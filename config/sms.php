<?php

return [
    'general' => [
        'api_id' => env('SMS_API_ID'),
        'api_password' => env('SMS_API_PASSWORD'),
        'sms_type' => 'T',
        'encoding' => 'T',
        'sender_id' => env('SMS_SENDER_ID'),
        'templateid' => '1028',
        'sms_url' => env('SMS_URL')
    ],

    'dreams' => [
        'sms_url' => env('SMS_URL'),
        'sms_user_name' => env('SMS_USERNAME'),
        'sms_password' => env('SMS_PASSWORD'),
        'sms_sender' => env('SMS_SENDER'),
    ],
];
