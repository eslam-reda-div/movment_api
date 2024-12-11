<?php

namespace App\Filament\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use GeoSot\FilamentEnvEditor\Pages\ViewEnv as BaseViewEnvEditor;

class ViewEnv extends BaseViewEnvEditor
{
    use HasPageShield;

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.env_editor.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard::dashboard.env_editor.label');
    }
}
