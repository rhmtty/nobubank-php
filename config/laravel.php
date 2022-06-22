<?php

return [

    /**
     * API mode
     * Available: "production" , "development"
     */
    'mode'   => env('NOBU_MODE', 'development'),

    /**
     * Development credentials
     */
    'development'   => [
        'base_url'      => 'http://uatmerchant.nobubank.com:2104/',
        'login'         => env('NOBU_DEV_LOGIN', ''),
        'password'      => env('NOBU_DEV_PASSWORD', ''),
        'merchant_id'   => env('NOBU_DEV_MERCHANT_ID', ''),
        'store_id'      => env('NOBU_DEV_STORE_ID', ''),
        'secret_key'    => env('NOBU_DEV_SECRET_KEY', ''),
    ],

    /**
     * Production credentials
     */
    'production'    => [
        'base_url'      => '',
        'login'         => env('NOBU_LOGIN', ''),
        'password'      => env('NOBU_PASSWORD', ''),
        'merchant_id'   => env('NOBU_MERCHANT_ID', ''),
        'store_id'      => env('NOBU_STORE_ID', ''),
        'secret_key'    => env('NOBU_SECRET_KEY', ''),
    ]

];