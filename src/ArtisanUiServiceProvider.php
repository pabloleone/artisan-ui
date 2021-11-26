<?php

namespace Pabloleone\ArtisanUi;

use Illuminate\Support\ServiceProvider;

class ArtisanUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'artisan-ui');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'artisan-ui');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/artisan-ui.php' => config_path('artisan-ui.php'),
            ], 'artisan-ui');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/artisan-ui'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/artisan-ui'),
            ], 'assets');*/

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/artisan-ui'),
            ], 'lang');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/artisan-ui.php', 'artisan-ui');

        // Register the main class to use with the facade
        $this->app->singleton('artisan-ui', function () {
            return new ArtisanUi;
        });
    }
}
