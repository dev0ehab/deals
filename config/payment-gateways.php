<?php

use App\Services\PaymentGateways\MyfatoorahService;
use App\Services\PaymentGateways\PaypalService;
use App\Services\PaymentGateways\StripeService;
use App\Services\PaymentGateways\TapService;
use App\Services\PaymentGateways\VapulusService;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services (Payment Gateways)
    |--------------------------------------------------------------------------
    |
    |
    */


    'myfatoorah' => [
        'base_uri' => env('MYFATOORAH_BASE_URI'),
        'app_key' => env('MYFATOORAH_APP_KEY'),
        'class' => MyfatoorahService::class,
    ],

    'paypal' => [
        'base_uri' => env('PAYPAL_BASE_URI'),
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'class' => PaypalService::class,
        'plans' => [
            'monthly' => env('PAYPAL_MONTHLY_PLAN'),
            'yearly' => env('PAYPAL_YEARLY_PLAN'),
        ]
    ],

    'stripe' => [
        'base_uri' => env('STRIPE_BASE_URI'),
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'class' => StripeService::class,
        'plans' => [
            'monthly' => env('STRIPE_MONTHLY_PLAN'),
            'yearly' => env('STRIPE_YEARLY_PLAN'),
        ]
    ],


    'tap' => [
        'base_uri' => env('TAP_BASE_URI'),
        'secret_key' => env('TAP_SECRET_KEY'),
        'public_key' => env('TAP_PUBLIC_KEY'),
        'class' => TapService::class,
    ],

    'vapulus' => [
        'base_uri' => env('VAPULUS_BASE_URI'),
        'app_id' => env('VAPULUS_APP_ID'),
        'password' => env('VAPULUS_PASSWORD'),
        'hash' => env('VAPULUS_HASH'),
        'class' => VapulusService::class,
    ],
];
