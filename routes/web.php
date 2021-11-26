<?php

use Illuminate\Support\Facades\Route;
use Pabloleone\ArtisanUi\Http\Middleware\Enabled;

Route::group(['before' => 'csrf', 'middleware' => [Enabled::class, 'web']], function() {
    Route::get(
        config('artisan-ui.url'),
        'Pabloleone\ArtisanUi\Http\Controllers\Artisan@main'
    )->name('artisan-ui.main');
    Route::post(
        config('artisan-ui.url'),
        'Pabloleone\ArtisanUi\Http\Controllers\Artisan@execute'
    )->name('artisan-ui.execute');
});
