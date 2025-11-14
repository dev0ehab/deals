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

    'failed' => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
    'deleted' => 'تم حذف هذا الحساب.',
    'blocked' => 'تم حظر هذا الحساب.',
    'washer-blocked' => 'لا يمكن تسجيل الدخول لان تم حظر المغسلة التي تنتمي اليها',
    'washer-deleted' => 'لا يمكن تسجيل الدخول لان تم حذف المغسلة التي تنتمي اليها',
    'password' => 'كلمة المرور التي ادخلتها غير صحيحة!',
    'throttle' => 'عدد كبير جدا من محاولات الدخول. يرجى المحاولة مرة أخرى بعد :seconds ثانية.',
    'attributes' => [
        'code' => 'رمز التحقق',
        'token' => 'شفرة التحقق',
        'email' => 'البريد الالكتروني',
        'phone' => 'رقم الهاتف',
        'username' => 'البريد الالكترونى او رقم الهاتف',
        'password' => 'كلمة المرور',
    ],
    'messages' => [
        'forget-password-code-sent' => 'لقد تم ارسال رمز استعادة كلمة المرور على هاتفك الجوال',
        'email-verification-sent' => 'لقد تم ارسال رمز التفعيل على بريدك الالكتروني',
    ],
    'emails' => [
        'forget-password' => [
            'subject' => 'رمز التحقق لتسجيل الدخول',
            'greeting' => 'عزيزي :user',
            'line' => ":code  رمز التحقق الخاص بك",
            'time' => " صالح لمدة :minutes دقائق",
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
        'password-less' => [
            'subject' => 'رمز التحقق لتسجيل الدخول',
            'greeting' => 'عزيزي :user',
            'line' => ":code  رمز التحقق الخاص بك",
            'time' => " صالح لمدة :minutes دقائق",
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
        'reset-password' => [
            'subject' => 'استعادة كلمة المرور',
            'greeting' => 'عزيزي :user',
            'line' => 'تم تغيير كلمة المرور الخاصة بك',
            'footer' => 'شكراً لاستخدامك لتطبيقنا',
            'salutation' => 'مع تحيات فريق عمل :app',
        ],
    ],
    'register' => [
        'verification' => [
            'subject' => 'رمز التحقق',
            'greeting' => 'عزيزي :user',
            'line' => 'رمز التحقق الخاص بك ل :app هو :code',
            'footer' => 'شكرا لك على استخدام تطبيقنا!',
            'salutation' => 'مع تحيات فريق عمل, :app',
        ]
    ]
];
