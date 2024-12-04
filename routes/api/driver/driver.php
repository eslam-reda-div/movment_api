<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'app/driver'], function () {})->middleware('auth:sanctum');
