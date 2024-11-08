<?php

namespace App\Filament\Resources\AvatarResource\Pages;

use App\Filament\Resources\AvatarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvatar extends EditRecord
{
    protected static string $resource = AvatarResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
