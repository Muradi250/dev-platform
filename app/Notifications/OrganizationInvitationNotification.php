<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationInvitationNotification extends Notification
{
    public function __construct(
        private readonly string $organizationName,
        private readonly string $role,
        private readonly string $invitationUrl,
        private readonly string $expiresAt,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Invitation to join {$this->organizationName}")
            ->greeting('You have been invited')
            ->line("You have been invited to join {$this->organizationName} as a {$this->role}.")
            ->action('Accept invitation', $this->invitationUrl)
            ->line("This invitation expires on {$this->expiresAt}.")
            ->line('Sign in using the email address that received this invitation before accepting.');
    }
}
