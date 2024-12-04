<?php

namespace App\Filament\Company\Resources\BusResource\Pages;

use App\Filament\Company\Resources\BusResource;
use App\Models\Bus;
use Filament\Resources\Pages\CreateRecord;

class CreateBus extends CreateRecord
{
    protected static string $resource = BusResource::class;

    protected function afterCreate(): void
    {
        $busId = $this->record->id;

        $bus = Bus::find($busId);

        $bus->company_id = auth('company')->id();

        $bus->save();
    }
}
