<?php

return [
    'plural' => 'Accounts',
    'types' => [
        \Modules\Accounts\Entities\User::ADMIN_TYPE => 'Admin',
    ],
    'messages' => [
        'block' => 'This account is blocked,please check with your administration',
        'verified' => 'This account is not verified,we have sent you an sms with code',
        'password' => 'Password is incorrect, please enter the correct password',
        'request_delete' => 'This account is removed successfully',
    ],
];
