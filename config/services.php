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
        'token' => env('POSTMARK_TOKEN'),
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

    'eps' => [
        'base_url' => env('EPS_BASE_URL', 'https://sandboxpgapi.eps.com.bd'),
        'merchant_id' => env('EPS_MERCHANT_ID'),
        'store_id' => env('EPS_STORE_ID'),
        'username' => env('EPS_USERNAME'),
        'password' => env('EPS_PASSWORD'),
        'hash_key' => env('EPS_HASH_KEY'),
        'currency' => env('EPS_CURRENCY', 'USD'),
        'payment_url' => env('EPS_PAYMENT_GATEWAY_URL', 'https://sandboxpg.eps.com.bd'),
        'success_url' => env('EPS_SUCCESS_URL'),
        'cancel_url' => env('EPS_CANCEL_URL'),
    ],

];
