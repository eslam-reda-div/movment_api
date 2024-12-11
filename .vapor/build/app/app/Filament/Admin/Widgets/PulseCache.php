<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Dotswan\FilamentLaravelPulse\Widgets\PulseCache as WidgetsPulseCache;

class PulseCache extends WidgetsPulseCache
{
    use HasWidgetShield;

    protected static ?int $sort = 94;
}
