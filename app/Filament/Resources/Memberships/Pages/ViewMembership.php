<?php

namespace App\Filament\Resources\Memberships\Pages;

use App\Filament\Resources\Concerns\StreamsProfilePdf;
use App\Filament\Resources\Memberships\MembershipResource;
use App\Models\Membership;
use App\Services\OrganizationInvitationService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewMembership extends ViewRecord
{
    use StreamsProfilePdf;

    protected static string $resource = MembershipResource::class;

    protected string $view = 'filament.resources.memberships.pages.membership-profile';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('resendInvitation')
                ->label('Resend invitation')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (Membership $record): bool => $record->status === 'invited')
                ->action(fn (Membership $record) => app(OrganizationInvitationService::class)->send($record)),
            Action::make('reinvite')
                ->label('Send invitation again')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (Membership $record): bool => $record->status === 'revoked'
                    && filled($record->invite_email))
                ->action(fn (Membership $record) => app(OrganizationInvitationService::class)->reinvite($record)),
            Action::make('revokeInvitation')
                ->label('Revoke invitation')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn (Membership $record): bool => $record->status === 'invited')
                ->action(fn (Membership $record) => app(OrganizationInvitationService::class)->revoke($record)),
        ];
    }

    protected function getViewData(): array
    {
        /** @var Membership $membership */
        $membership = $this->getRecord()->load([
            'organization',
            'user',
        ]);

        $organizationLogoUrl = filled($membership->organization?->logo)
            && Storage::disk('public')->exists($membership->organization->logo)
                ? Storage::disk('public')->url($membership->organization->logo)
                : null;

        return [
            'membership' => $membership,
            'organizationLogoUrl' => $organizationLogoUrl,
            'userAvatarUrl' => $membership->user?->getFilamentAvatarUrl(),
            'editUrl' => $this->getResourceUrl('edit'),
            'issuedAt' => now()->timezone(
                $membership->organization?->timezone ?: config('app.timezone')
            ),
        ];
    }

    public function downloadPdf(): StreamedResponse
    {
        $membership = $this->getRecord();
        return $this->streamProfilePdf(
            $this->view,
            $this->getViewData(),
            "membership-profile-{$membership->getKey()}.pdf",
        );
    }
}
