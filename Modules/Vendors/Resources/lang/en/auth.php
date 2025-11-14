<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'deleted' => 'This account has been deleted.',
    'blocked' => 'This account has been blocked.',
    'washer-blocked' => 'Cannot log in because the Washer you belong to has been blocked',
    'washer-deleted' => 'Cannot log in because the Washer you belong to has been deleted',
    'password' => 'The password you entered is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'attributes' => [
        'code' => 'Verification Code',
        'token' => 'Verification Token',
        'email' => 'Email',
        'phone' => 'phone',
        'username' => 'Email Or Phone',
        'password' => 'Password',
    ],
    'messages' => [
        'forget-password-code-sent' => 'The reset password code was sent to your phone number.',
    ],
    'emails' => [
        'forget-password' => [
            'subject' => 'Reset Password',
            'greeting' => 'Dear :user',
            'line' => 'Your password recovery code is :code valid for :minutes minutes',
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ],
        'password-less' => [
            'subject' => 'Reset Password',
            'greeting' => 'Dear :user',
            'line' => "Your password recovery code is :code",
            'time' => " valid for :minutes minutes",
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ],
        'reset-password' => [
            'subject' => 'Reset Password',
            'greeting' => 'Dear :user',
            'line' => 'Your password has been reset successfully.',
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ],
    ],
    'register' => [
        'verification' => [
            'subject' => 'Verification code',
            'greeting' => 'Dear :user',
            'line' => ':code is your verification code for :app',
            'footer' => 'Thank you for using our application!',
            'salutation' => 'Regards, :app',
        ]
    ]
];
