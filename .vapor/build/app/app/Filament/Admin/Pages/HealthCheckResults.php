<?php

namespace App\Filament\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class HealthCheckResults extends BaseHealthCheckResults
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public function getHeading(): string
    {
        return __('dashboard::dashboard.health_check.heading');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.health_check.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard::dashboard.health_check.label');
    }
}
