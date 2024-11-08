<?php

namespace App\Filament\Resources\ParkAreaResource\Pages;

use App\Filament\Resources\ParkAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParkArea extends CreateRecord
{
    protected static string $resource = ParkAreaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
