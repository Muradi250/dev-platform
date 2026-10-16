<?php

namespace App\Services;

use App\Models\Membership;
use App\Notifications\OrganizationInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LogicException;

class OrganizationInvitationService
{
    public function reinvite(Membership $membership): void
    {
        if ($membership->status !== 'revoked' || blank($membership->invite_email)) {
            throw new LogicException('Only revoked invitations with an email address can be sent again.');
        }

        DB::transaction(function () use ($membership): void {
            $membership->forceFill(['status' => 'invited'])->save();

            $this->send($membership);
        });
    }

    public function revoke(Membership $membership): void
    {
        if ($membership->status !== 'invited') {
            throw new LogicException('Only pending organization invitations can be revoked.');
        }

        $membership->forceFill([
            'status' => 'revoked',
            'invitation_token_hash' => null,
            'invitation_expires_at' => null,
        ])->save();
    }

    public function send(Membership $membership, ?string $token = null): void
    {
        if ($membership->status !== 'invited' || blank($membership->invite_email)) {
            throw new LogicException('Only pending organization invitations can be sent.');
        }

        $token ??= Str::random(64);
        $expiresAt = now()->addDays(7);

        $membership->forceFill([
            'invitation_token_hash' => hash('sha256', $token),
            'invited_at' => now(),
            'invitation_expires_at' => $expiresAt,
        ])->save();

        $invitationUrl = URL::temporarySignedRoute(
            'organization-invitations.show',
            $expiresAt,
            ['token' => $token],
        );

        Notification::route('mail', $membership->invite_email)->notify(
            new OrganizationInvitationNotification(
                $membership->organization->name,
                $membership->role,
                $invitationUrl,
                $expiresAt->toFormattedDateString(),
            )
        );
    }
}
