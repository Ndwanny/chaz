<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lenco by Broadpay — Payment Gateway
    |--------------------------------------------------------------------------
    | Zambia's Lenco by Broadpay payment gateway supports MTN Money,
    | Airtel Money, Zamtel Kwacha, Visa, and Mastercard.
    |
    | API Docs: https://lenco-api.readme.io/v2.0/reference/introduction
    | Base URL: https://api.lenco.co/access/v2
    |--------------------------------------------------------------------------
    */

    'api_url'    => env('LENCO_API_URL', 'https://api.lenco.co/access/v2'),
    'api_key'    => env('LENCO_API_KEY', ''),   // Bearer token from Lenco dashboard
    'currency'   => env('LENCO_CURRENCY', 'ZMW'),
    'country'    => env('LENCO_COUNTRY', 'zm'),

];
