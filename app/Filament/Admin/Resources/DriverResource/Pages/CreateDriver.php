<?php

namespace App\Filament\Admin\Resources\DriverResource\Pages;

use App\Filament\Admin\Resources\DriverResource;
use App\Models\Bus;
use Filament\Resources\Pages\CreateRecord;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;

    protected function afterCreate(): void
    {
        // Get the bus_id from the form data
        $busId = $this->data['bus_id'] ?? null;

        if ($busId) {
            // Find the bus and associate it with the newly created driver
            $bus = Bus::find($busId);
            if ($bus) {
                $bus->driver()->associate($this->record);
                $bus->save();
            }
        }
    }
}
