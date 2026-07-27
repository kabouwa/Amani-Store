<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],


    'sendit' => [
        'api' => env('SENDIT_API'),
        'public_key' => env('SENDIT_PUBLIC_KEY'),
        'private_key' => env('SENDIT_PRIVATE_KEY'),
        'pickup' => [
            'district_id' => env('SENDIT_PICKUP_DISTRICT_ID'),
            'name' => env('SENDIT_PICKUP_NAME'),
            'phone' => env('SENDIT_PICKUP_PHONE'),
            'address' => env('SENDIT_PICKUP_ADDRESS'),
        ]
    ]

];
