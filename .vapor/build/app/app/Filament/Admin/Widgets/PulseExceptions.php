<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions as WidgetsPulseExceptions;

class PulseExceptions extends WidgetsPulseExceptions
{
    use HasWidgetShield;

    protected static ?int $sort = 95;
}
