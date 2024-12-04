<?php

use App\Http\Controllers\Auth\AuthDriverController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth/driver'], function () {
    Route::post('/login', [AuthDriverController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthDriverController::class, 'logout']);
    });
});
