<?php

namespace App\Filament\Resources\SecurityDelegations\Pages;

use App\Filament\Resources\SecurityDelegations\SecurityDelegationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSecurityDelegation extends ViewRecord
{
    protected static string $resource = SecurityDelegationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
