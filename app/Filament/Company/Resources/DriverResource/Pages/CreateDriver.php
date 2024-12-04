<?php

namespace App\Filament\Company\Resources\DriverResource\Pages;

use App\Filament\Company\Resources\DriverResource;
use App\Models\Driver;
use Filament\Resources\Pages\CreateRecord;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;

    protected function afterCreate(): void
    {
        $driverId = $this->record->id;

        $driver = Driver::find($driverId);

        $driver->company_id = auth('company')->id();

        $driver->save();
    }
}
