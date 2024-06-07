<?php

namespace App\Filament\Resources\StoresGroupResource\Pages;

use App\Filament\Resources\StoresGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStoresGroup extends EditRecord
{
    protected static string $resource = StoresGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
