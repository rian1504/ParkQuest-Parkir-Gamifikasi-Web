<?php

namespace App\Filament\Resources\ParkAreaResource\Pages;

use App\Filament\Resources\ParkAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParkArea extends EditRecord
{
    protected static string $resource = ParkAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
