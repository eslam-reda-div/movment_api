<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('ASSET_PREFIX', '').'/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(env('ASSET_PREFIX', '').'/livewire/livewire.js', $handle);
});

Route::group(['middleware' => ['admin']], function () {
    Route::mailweb();
});

Route::redirect('/', '/company');
