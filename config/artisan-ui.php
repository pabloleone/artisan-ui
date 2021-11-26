<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Artisan UI Default URL
    |--------------------------------------------------------------------------
    |
    | This option controls the default URL the Artisan UI will be displayed on.
    |
    */

    'url' => env('ARTISAN_UI_URL', '/artisan-ui'),

    /*
    |--------------------------------------------------------------------------
    | Artisan UI Default Theme
    |--------------------------------------------------------------------------
    |
    | This option controls the default theme the Artisan UI will use to be
    | displayed.
    |
    */

    'theme' => env('ARTISAN_UI_THEME', 'laravel'),

    /*
    |--------------------------------------------------------------------------
    | Artisan UI Default Theme
    |--------------------------------------------------------------------------
    |
    | This option allows you to controls when to enable the Artisan UI.
    |
    */

    'enabled' => env('ARTISAN_UI_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Artisan UI Excluded Commands
    |--------------------------------------------------------------------------
    |
    | This option contains a list of commands that are excluded from Artisan UI.
    |
    */

    'excluded' => [
        'serve',
        'tinker',
        'queue:listen',
        'queue:monitor',
        'schedule:work',
        'queue:work',
        'sail:install'
    ]
];
