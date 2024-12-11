<?php

use App\Events\BusLocationUpdated;
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

// make route for test bordcasting
Route::get('/test-broadcast', function () {
    broadcast(new BusLocationUpdated('9843-8534-4563-5345', 1.0, 2.0));
    return 'Broadcasted';
});

Route::get('/test-broadcast-lisen', function () {
    return view('test-broadcast-queue');
});
