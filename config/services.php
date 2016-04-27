<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1657402167852948',
        'client_secret' => 'bd47d385be03b110b5a57ee249517c21',
        'redirect' => 'https://www.evangelsenglish.com/fbcallback',
    ],

    'google' => [
        'client_id' => '872662012321-2a300brmje1lhj09chjpcjn29pb6h2mt.apps.googleusercontent.com',
        'client_secret' => 'LhTaJCFeSStRO0-ykzyLjYBA',
        'redirect' => 'https://www.evangelsenglish.com/ggcallback',
    ]

];
