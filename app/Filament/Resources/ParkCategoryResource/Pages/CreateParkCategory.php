<?php

namespace App\Filament\Resources\ParkCategoryResource\Pages;

use App\Filament\Resources\ParkCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParkCategory extends CreateRecord
{
    protected static string $resource = ParkCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
