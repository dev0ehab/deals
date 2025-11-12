<?php

return [

    /*
     * The module name.
     */
    'name' => 'Accounts',

    /*
     * The firebase project id for password less authentication.
     */
//    'firebase_project_id' => env('FIREBASE_PROJECT_ID'),

    /*
         * The sms configuration.
         */
    'sms_api_key' => config('services.smsKey.Key'),
    'sms_site' => config('services.smsKey.site'),
    'sms_title' => config('services.smsKey.title'),
];
