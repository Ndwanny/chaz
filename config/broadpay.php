<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadpay / Lenco Payment Gateway
    |--------------------------------------------------------------------------
    | Zambia's Broadpay (Lenco) payment gateway supports MTN Money,
    | Airtel Money, Zamtel Kwacha, Visa, and Mastercard.
    |
    | Sandbox:  https://sandbox.broadpay.co.zm/api/v1
    | Live:     https://api.broadpay.co.zm/api/v1
    |--------------------------------------------------------------------------
    */

    'api_url'        => env('BROADPAY_API_URL', 'https://api.broadpay.co.zm/api/v1'),
    'merchant_id'    => env('BROADPAY_MERCHANT_ID', ''),
    'api_key'        => env('BROADPAY_API_KEY', ''),
    'webhook_secret' => env('BROADPAY_WEBHOOK_SECRET', ''),

];
