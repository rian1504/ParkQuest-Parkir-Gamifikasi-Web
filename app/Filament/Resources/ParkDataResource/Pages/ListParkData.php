<?php

namespace App\Filament\Resources\ParkDataResource\Pages;

use App\Filament\Resources\ParkDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkData extends ListRecords
{
    protected static string $resource = ParkDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
