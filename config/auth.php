<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'user' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],

    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ]

];
