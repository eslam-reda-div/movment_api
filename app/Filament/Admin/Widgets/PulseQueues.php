<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues as WidgetsPulseQueues;

class PulseQueues extends WidgetsPulseQueues
{
    use HasWidgetShield;

    protected static ?int $sort = 97;
}
