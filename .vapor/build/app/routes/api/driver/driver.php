<?php

use App\Http\Controllers\Driver\DriverController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'app/driver',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/get-bus', [DriverController::class, 'getBus']);
    Route::get('/get-all-trips', [DriverController::class, 'getAllTrips']);
    Route::get('/get-today-trips', [DriverController::class, 'getTodayTrips']);
    Route::get('/get-upcoming-trips', [DriverController::class, 'getUpcomingTrips']);
    Route::get('/get-upcoming-today-trips', [DriverController::class, 'getUpcomingTodayTrips']);
    Route::post('/start-trip', [DriverController::class, 'startTrip']);
    Route::post('/end-trip', [DriverController::class, 'endTrip']);
    Route::post('/update-bus-location', [DriverController::class, 'updateBusLocation']);
});
