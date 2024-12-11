<?php

// app/Filament/Company/Widgets/TrackMap.php

namespace App\Filament\Company\Widgets;

use App\Filament\Company\Resources\BusResource;
use App\Filament\Company\Resources\DriverResource;
use App\Filament\Company\Resources\TripResource;
use App\Models\Bus;
use Filament\Widgets\Widget;

class TrackMap extends Widget
{
    protected static bool $isLazy = false;

    protected static string $view = 'filament.company.widgets.track-map';

    protected static ?int $sort = 99;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $title = null;

    public function getHeading(): string
    {
        return __('dashboard::dashboard.track_map.title');
    }

    public function getBuses()
    {
        $buses = Bus::with(['driver', 'activeTrip'])
            ->where('company_id', auth('company')->id())
            ->where('is_active', true)
            ->get();

        // Add the edit URLs to each bus
        return $buses->map(function ($bus) {
            $bus->edit_url = BusResource::getUrl('edit', ['record' => $bus]);

            if ($bus->driver) {
                $bus->driver->edit_url = DriverResource::getUrl('edit', ['record' => $bus->driver]);
            }

            if ($bus->activeTrip) {
                $bus->activeTrip->edit_url = TripResource::getUrl('edit', ['record' => $bus->activeTrip]);
            }

            return $bus;
        });
    }

    public function getMapCenter()
    {
        $buses = $this->getBuses();

        if ($buses->isEmpty()) {
            return [
                'lat' => (float) __('dashboard::dashboard.track_map.map.default_center.lat'),
                'lng' => (float) __('dashboard::dashboard.track_map.map.default_center.lng'),
            ];
        }

        return [
            'lat' => $buses->avg('latitude'),
            'lng' => $buses->avg('longitude'),
        ];
    }
}
