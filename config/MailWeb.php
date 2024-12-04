<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Here you can change the setting for mail web
    | MAILWEB_LIMIT - limit the amount of messages stored in the db
    |
    */
    'MAILWEB_ENABLED' => env('MAILWEB_ENABLED', true),
    'MAILWEB_LIMIT' => env('MAILWEB_LIMIT', 20),
    'MAILWEB_SAMPLE_SECTION' => env('MAILWEB_SAMPLE_SECTION', true),
    'MAILWEB_RETURN' => [
        'APP_NAME' => env('MAILWEB_RETURN_APP_NAME'),
        'APP_URL' => env('MAILWEB_RETURN_APP_URL'),
    ],
];
