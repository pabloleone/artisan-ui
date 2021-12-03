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
        'serve', // The app is up and running already, is it?
        'tinker', // You don't want to play with this on the web!
        'queue:listen', // Workers are not yet supported, I'm afraid
        'queue:monitor', // Workers are not yet supported, I'm afraid
        'schedule:work', // Workers are not yet supported, I'm afraid
        'queue:work', // Workers are not yet supported, I'm afraid
        'sail:install', // This is a very sensitive command you wouldn't want to run easily
    ],

    /*
    |--------------------------------------------------------------------------
    | Artisan UI Output Decorators
    |--------------------------------------------------------------------------
    |
    | This option contains a list of decorators that are applied to the output
    | of the arisan commands.
    |
    */

    'decorators' => [
        // 'inspire' => Pabloleone\ArtisanUi\Models\Decorators\Inspire::class,
    ]
];
