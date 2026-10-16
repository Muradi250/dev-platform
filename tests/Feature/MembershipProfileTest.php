<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\OrganizationInvitationNotification;
use App\Services\OrganizationInvitationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MembershipProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_membership_profile_is_branded_and_shows_member_and_organization_details(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('organizations/logo.png', 'logo-content');
        Storage::disk('public')->put('avatars/member.png', 'avatar-content');

        $organization = $this->createOrganization([
            'logo' => 'organizations/logo.png',
            'description' => 'A member-focused organization.',
        ]);
        $user = User::factory()->create([
            'name' => 'Jordan Taylor',
            'email' => 'jordan@example.test',
            'avatar' => 'avatars/member.png',
        ]);
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'role' => 'admin',
            'status' => 'active',
            'joined_at' => now(),
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner)
            ->get(route('filament.admin.resources.memberships.view', ['record' => $membership]))
            ->assertOk()
            ->assertSee('Dev-Platform')
            ->assertSee('MEMBERSHIP RECORD')
            ->assertSee('Jordan Taylor')
            ->assertSee('jordan@example.test')
            ->assertSee('Example Organization')
            ->assertSee('Administrator')
            ->assertSee('Download PDF')
            ->assertSee(Storage::disk('public')->url('organizations/logo.png'))
            ->assertSee(Storage::disk('public')->url('avatars/member.png'))
            ->assertSee('Print / Save as PDF');
    }

    public function test_membership_profile_can_be_downloaded_as_a_pdf(): void
    {
        $organization = $this->createOrganization();
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'member@example.test',
            'role' => 'member',
            'status' => 'invited',
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\Memberships\Pages\ViewMembership::class, [
            'record' => $membership->id,
        ])
            ->call('downloadPdf')
            ->assertFileDownloaded("membership-profile-{$membership->id}.pdf", contentType: 'application/pdf');
    }

    public function test_invitation_membership_profile_displays_pending_invitee_and_expiration(): void
    {
        $organization = $this->createOrganization();
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'invitee@example.test',
            'role' => 'viewer',
            'status' => 'invited',
            'invited_at' => now()->subHour(),
            'invitation_expires_at' => now()->addDays(6),
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner)
            ->get(route('filament.admin.resources.memberships.view', ['record' => $membership]))
            ->assertOk()
            ->assertSee('invitee@example.test')
            ->assertSee('Invitation pending')
            ->assertSee('Viewer')
            ->assertSee('Invitation expires');
    }

    public function test_revoked_invitation_keeps_its_address_and_can_be_issued_again(): void
    {
        Notification::fake();

        $organization = $this->createOrganization();
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'reinvite@example.test',
            'role' => 'member',
            'status' => 'invited',
            'invitation_token_hash' => hash('sha256', 'old-token'),
            'invitation_expires_at' => now()->addDay(),
        ]);
        $service = app(OrganizationInvitationService::class);

        $service->revoke($membership);
        $membership->refresh();

        $this->assertSame('revoked', $membership->status);
        $this->assertSame('reinvite@example.test', $membership->invite_email);
        $this->assertNull($membership->invitation_token_hash);
        $this->assertNull($membership->invitation_expires_at);

        $service->reinvite($membership);
        $membership->refresh();

        $this->assertSame('invited', $membership->status);
        $this->assertSame('reinvite@example.test', $membership->invite_email);
        $this->assertNotNull($membership->invitation_token_hash);
        $this->assertTrue($membership->invitation_expires_at->isFuture());
        Notification::assertSentOnDemand(
            OrganizationInvitationNotification::class,
            fn (OrganizationInvitationNotification $notification, array $channels, object $notifiable): bool =>
                $notifiable->routes['mail'] === 'reinvite@example.test'
                && $channels === ['mail']
        );
    }

    public function test_membership_form_creates_an_active_membership_for_an_existing_user(): void
    {
        $organization = $this->createOrganization();
        $member = User::factory()->create([
            'name' => 'Existing Member',
            'email' => 'existing@example.test',
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\Memberships\Pages\CreateMembership::class)
            ->fillForm([
                'organization_id' => $organization->id,
                'user_id' => $member->id,
                'role' => 'member',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('memberships', [
            'organization_id' => $organization->id,
            'user_id' => $member->id,
            'invite_email' => null,
            'role' => 'member',
            'status' => 'active',
        ]);
    }

    public function test_membership_form_sends_invitation_and_creates_pending_membership(): void
    {
        Notification::fake();
        $organization = $this->createOrganization();
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\Memberships\Pages\CreateMembership::class)
            ->fillForm([
                'organization_id' => $organization->id,
                'invite_email' => ' NEW-MEMBER@example.test ',
                'role' => 'viewer',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('memberships', [
            'organization_id' => $organization->id,
            'user_id' => null,
            'invite_email' => 'new-member@example.test',
            'role' => 'viewer',
            'status' => 'invited',
        ]);

        Notification::assertSentOnDemand(
            OrganizationInvitationNotification::class,
            fn (OrganizationInvitationNotification $notification, array $channels, object $notifiable): bool =>
                $notifiable->routes['mail'] === 'new-member@example.test'
                && $channels === ['mail']
        );
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createOrganization(array $attributes = []): Organization
    {
        return Organization::create([
            'name' => 'Example Organization',
            'slug' => 'example-organization',
            'code' => 'EXAMPLE',
            'type' => 'organization',
            'status' => 'active',
            'default_locale' => 'en',
            ...$attributes,
        ]);
    }
}
