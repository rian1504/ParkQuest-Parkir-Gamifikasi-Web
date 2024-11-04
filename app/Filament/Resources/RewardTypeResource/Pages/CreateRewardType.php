<?php

namespace App\Filament\Resources\RewardTypeResource\Pages;

use App\Filament\Resources\RewardTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRewardType extends CreateRecord
{
    protected static string $resource = RewardTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
