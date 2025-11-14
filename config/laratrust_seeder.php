<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'super_admin' => [
            'roles'          => 'c,r,u,d,s',
            'admins'         => 'c,r,u,d,s,b',
            'users'          => 'c,r,u,d,s,b,rt,re,f',
            'vendors'        => 'c,r,u,d,s,b,rt,re,f',
            'settings'       => 'c,r,u,d,s',
            'notifications'  => 'c,r,u,d,s',
            'services'       => 'c,r,u,d,s',
            'attributes'     => 'c,r,u,d,s',
            'categories'     => 'c,r,u,d,s',
            'areas'          => 'c,r,u,d,s',
            'features'       => 'c,r,u,d,s',
            'products'       => 'c,r,u,d,s',
            'coupons'        => 'c,r,u,d,s',
            'sections'       => 'c,r,u,d,s',
            'f_a_qs'         => 'c,r,u,d,s',
            // 'payments'       => 'r,u,s',
            'orders'         => 'r,u,s',
            'advertisements' => 'c,r,u,d,s',
            'contactus'      => 'r,d,s',
        ],
    ],

    'permissions_map' => [
        'c'  => 'create',
        'r'  => 'read',
        'u'  => 'update',
        'd'  => 'delete',
        's'  => 'show',
        'b'  => 'block',
        'dl' => 'download',
        'so' => 'sort',
        'rt' => 'readTrashed',
        're' => 'restore',
        'f'  => 'forceDelete',
        'a'  => 'attach',
        'st' => 'status',
    ]
];
