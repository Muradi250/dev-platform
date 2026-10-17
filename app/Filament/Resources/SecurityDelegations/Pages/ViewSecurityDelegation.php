<?php

namespace App\Filament\Resources\SecurityDelegations\Pages;

use App\Filament\Resources\SecurityDelegations\SecurityDelegationResource;
use App\Models\SecurityDelegation;
use App\Models\User;
use App\Services\SecurityDelegationService;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewSecurityDelegation extends ViewRecord
{
    protected static string $resource = SecurityDelegationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(function (SecurityDelegation $record): bool {
                    $actor = Auth::user();

                    return $actor instanceof User
                        && app(SecurityDelegationService::class)->canManage($actor, $record)
                        && ! in_array($record->effective_status, ['revoked', 'expired'], true);
                }),
        ];
    }
}
