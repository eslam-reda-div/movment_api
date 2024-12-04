<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage as WidgetsPulseUsage;

class PulseUsage extends WidgetsPulseUsage
{
    use HasWidgetShield;

    protected static ?int $sort = 96;
}
