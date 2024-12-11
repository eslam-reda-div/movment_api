<?php

namespace App\Filament\Company\Resources\PathResource\Pages;

use App\Filament\Company\Resources\PathResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPath extends EditRecord
{
    protected static string $resource = PathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
