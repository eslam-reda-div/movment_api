<?php

namespace App\Filament\Admin\Resources\DriverResource\Pages;

use App\Filament\Admin\Resources\DriverResource;
use App\Models\Bus;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDriver extends EditRecord
{
    protected static string $resource = DriverResource::class;

    protected function afterSave(): void
    {
        $busId = $this->data['bus_id'] ?? null;

        // First, remove this driver from any existing bus
        $oldBus = Bus::where('driver_id', $this->record->id)->first();
        if ($oldBus) {
            $oldBus->driver()->dissociate();
            $oldBus->save();
        }

        // Then associate with new bus if provided
        if ($busId) {
            $newBus = Bus::findOrFail($busId);
            $newBus->driver()->associate($this->record);
            $newBus->save();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
