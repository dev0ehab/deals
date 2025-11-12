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
    'has_account' => 'This phone number already has an account.',
    'blocked' => 'This account has been blocked.',
    'password' => 'The password you entered is incorrect.',
    'old_password' => 'The password you entered is incorrect.',
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
        'forget-password-code-sent-phone' => 'The reset password code was sent to your phone number.',
        'forget-password-code-sent-email' => 'The reset password code was sent to your email.',
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
        // 'new-account-password' => [
        //     'subject' => 'New Account Login Details',
        //     'greeting' => 'Dear :user',
        //     'email' => "Email :email",
        //     'password' => "Password :password",
        //     'footer' => 'Thank you for using our application!',
        //     'salutation' => 'Regards, :app',
        // ],


        'new-account-password' => [
            'greeting' => 'Dear :user',
            'email' => "Email : :email",
            'password' => "Password : :password",
            'subject' => 'Your account password has been updated successfully.',
            'line' => 'Your password has been reset successfully. Your new password is :password',
            'footer' => 'We advise you to keep this information in a safe place, and not to share it with anyone.

            To proceed:
            You can log in to your account using your new password

        If you need any assistance or have any queries, please feel free to contact us.

        Best regards,',
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
