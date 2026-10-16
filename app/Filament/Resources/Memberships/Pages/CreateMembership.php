<?php

namespace App\Filament\Resources\Memberships\Pages;

use App\Filament\Resources\Memberships\MembershipResource;
use App\Models\Membership;
use App\Services\OrganizationInvitationService;
use Filament\Resources\Pages\CreateRecord;
use LogicException;
use Illuminate\Support\Str;

class CreateMembership extends CreateRecord
{
    protected static string $resource = MembershipResource::class;

    private ?string $invitationToken = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (filled($data['invite_email'] ?? null)) {
            $this->invitationToken = Str::random(64);

            return [
                ...$data,
                'user_id' => null,
                'invite_email' => strtolower(trim($data['invite_email'])),
                'status' => 'invited',
                'joined_at' => null,
                'invitation_token_hash' => hash('sha256', $this->invitationToken),
                'invited_at' => now(),
                'invitation_expires_at' => now()->addDays(7),
            ];
        }

        return [
            ...$data,
            'invite_email' => null,
            'status' => 'active',
            'joined_at' => $data['joined_at'] ?? now(),
        ];
    }

    protected function afterCreate(): void
    {
        if ($this->invitationToken === null || ! $this->record instanceof Membership) {
            if ($this->invitationToken !== null) {
                throw new LogicException('The created invitation record is unavailable.');
            }

            return;
        }

        app(OrganizationInvitationService::class)->send(
            $this->record,
            $this->invitationToken,
        );
    }
}
