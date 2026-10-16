<?php

namespace App\Filament\Resources\SecurityDelegations\Pages;

use App\Filament\Resources\SecurityDelegations\SecurityDelegationResource;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

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
                ->visible(fn (): bool => $this->getRecord()->status !== 'revoked')
                ->action(function (): void {
                    $this->getRecord()->revoke();
                }),
        ];
    }
}
