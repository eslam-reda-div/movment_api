<?php

function requireRoutesRecursively($path)
{
    $files = glob($path.'/*.php');
    foreach ($files as $file) {
        require $file;
    }

    // Get all subdirectories
    $directories = glob($path.'/*', GLOB_ONLYDIR);
    foreach ($directories as $directory) {
        requireRoutesRecursively($directory);
    }
}

requireRoutesRecursively(base_path('routes/api'));
