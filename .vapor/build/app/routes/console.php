<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('db:export', function () {
    Artisan::call('db:export');
})->purpose('Export the database');
