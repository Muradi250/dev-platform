<?php

namespace App\Filament\Resources\SecurityDelegations\Pages;

use App\Filament\Resources\SecurityDelegations\SecurityDelegationResource;
use App\Models\User;
use App\Services\SecurityDelegationService;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSecurityDelegation extends EditRecord
{
    protected static string $resource = SecurityDelegationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            Action::make('revoke')
                ->label('Revoke')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Revoke Security Delegation')
                ->modalDescription(
                    'This will revoke the delegated security authority.'
                )
                ->modalSubmitActionLabel('Revoke Delegation')
                ->visible(fn (): bool => $this->canManageCurrentRecord())
                ->action(function (): void {
                    $actor = Auth::user();

                    abort_unless($actor instanceof User, 403);
                    app(SecurityDelegationService::class)->authorizeManager(
                        $actor,
                        $this->getRecord(),
                    );
                    $this->getRecord()->revoke();
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        app(SecurityDelegationService::class)->validate(
            Auth::user(),
            $data,
            $this->getRecord(),
        );

        return $data;
    }

    private function canManageCurrentRecord(): bool
    {
        $actor = Auth::user();
        $record = $this->getRecord();

        return $actor instanceof User
            && app(SecurityDelegationService::class)->canManage($actor, $record)
            && ! in_array($record->effective_status, ['revoked', 'expired'], true);
    }

    protected function afterSave(): void
    {
        app(SecurityDelegationService::class)->logPermissionSnapshot($this->getRecord());
    }
}
