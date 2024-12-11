<?php

namespace App\Filament\Company\Resources\TripResource\Pages;

use App\Filament\Company\Resources\TripResource;
use App\Models\Trip;
use Filament\Resources\Pages\CreateRecord;

class CreateTrip extends CreateRecord
{
    protected static string $resource = TripResource::class;

    protected function afterCreate(): void
    {
        $tripId = $this->record->id;

        $trip = Trip::find($tripId);

        $trip->company_id = auth('company')->id();

        $trip->save();
    }
}
