<?php

namespace App\Filament\Resources\ParkDataResource\Pages;

use App\Filament\Resources\ParkDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParkData extends CreateRecord
{
    protected static string $resource = ParkDataResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
