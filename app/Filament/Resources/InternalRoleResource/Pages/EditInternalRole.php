<?php

namespace App\Filament\Resources\InternalRoleResource\Pages;

use App\Filament\Resources\InternalRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternalRole extends EditRecord
{
    protected static string $resource = InternalRoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
