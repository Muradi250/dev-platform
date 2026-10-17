<?php

namespace App\Filament\Resources\SecurityDelegations\Pages;

use App\Filament\Resources\SecurityDelegations\SecurityDelegationResource;
use App\Services\SecurityDelegationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSecurityDelegation extends CreateRecord
{
    protected static string $resource = SecurityDelegationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        app(SecurityDelegationService::class)->validate(
            Auth::user(),
            $data,
        );

        $data['delegated_by_user_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        app(SecurityDelegationService::class)->logPermissionSnapshot($this->getRecord());
    }
}
