<?php

namespace App\Filament\Company\Resources\PathResource\Pages;

use App\Filament\Company\Resources\PathResource;
use App\Models\Path;
use Filament\Resources\Pages\CreateRecord;

class CreatePath extends CreateRecord
{
    protected static string $resource = PathResource::class;

    protected function afterCreate(): void
    {
        $pathId = $this->record->id;

        $path = Path::find($pathId);

        $path->company_id = auth('company')->id();

        $path->save();
    }
}
