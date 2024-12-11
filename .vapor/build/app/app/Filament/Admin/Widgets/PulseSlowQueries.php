<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries as WidgetsPulseSlowQueries;

class PulseSlowQueries extends WidgetsPulseSlowQueries
{
    use HasWidgetShield;

    protected static ?int $sort = 98;
}
