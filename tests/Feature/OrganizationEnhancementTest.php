<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\OrganizationInvitationNotification;
use App\Notifications\VerifyEmailNotification;
use App\Services\OrganizationInvitationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Tests\TestCase;

class OrganizationEnhancementTest extends TestCase
{
    use RefreshDatabase;

    public function test_organization_profile_fields_can_be_saved(): void
    {
        $organization = $this->createOrganization();

        $organization->update([
            'legal_type' => 'nonprofit',
            'registration_number' => 'REG-123',
            'tax_id' => 'TAX-123',
            'address_line_1' => '10 Main Street',
            'country' => 'Afghanistan',
            'city' => 'Kabul',
            'primary_contact_name' => 'Amina Example',
            'primary_contact_email' => 'contact@example.com',
            'timezone' => 'Asia/Kabul',
            'currency' => 'AFN',
        ]);

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'legal_type' => 'nonprofit',
            'registration_number' => 'REG-123',
            'tax_id' => 'TAX-123',
            'address_line_1' => '10 Main Street',
            'country' => 'Afghanistan',
            'city' => 'Kabul',
            'primary_contact_name' => 'Amina Example',
            'primary_contact_email' => 'contact@example.com',
            'timezone' => 'Asia/Kabul',
            'currency' => 'AFN',
        ]);
    }

    public function test_organization_profile_page_is_available_and_print_ready(): void
    {
        $organization = $this->createOrganization();
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner)
            ->get(route('filament.admin.resources.organizations.view', [
                'record' => $organization->id,
            ]))
            ->assertOk()
            ->assertSee('Organization Profile')
            ->assertSee('Download PDF')
            ->assertSee('Print / Save as PDF')
            ->assertSee('EXAMPLE')
            ->assertSee('Dev-Platform')
            ->assertSee('ORGANIZATION RECORD')
            ->assertSee('System-generated profile');
    }

    public function test_organization_profile_can_be_downloaded_as_a_pdf(): void
    {
        $organization = $this->createOrganization();
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\Organizations\Pages\ViewOrganization::class, [
            'record' => $organization->id,
        ])
            ->call('downloadPdf')
            ->assertFileDownloaded("organization-profile-{$organization->id}.pdf", contentType: 'application/pdf');
    }

    public function test_invitation_is_sent_with_a_signed_link_and_can_be_accepted(): void
    {
        Notification::fake();

        $organization = $this->createOrganization();
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'member@example.com',
            'role' => 'admin',
            'status' => 'invited',
        ]);

        app(OrganizationInvitationService::class)->send($membership, str_repeat('a', 64));

        $membership->refresh();
        Notification::assertSentOnDemand(
            OrganizationInvitationNotification::class,
            fn (OrganizationInvitationNotification $notification, array $channels, object $notifiable): bool =>
                $notifiable->routes['mail'] === 'member@example.com'
                && $channels === ['mail']
        );

        $user = User::factory()->create([
            'email' => 'member@example.com',
            'email_verified_at' => null,
        ]);
        $url = URL::temporarySignedRoute(
            'organization-invitations.show',
            now()->addHour(),
            ['token' => str_repeat('a', 64)],
        );

        $this->withSession(['url.intended' => $url])
            ->post('/en/login', [
                'email' => 'member@example.com',
                'password' => 'password',
            ])
            ->assertRedirect($url);

        $this->get($url)->assertOk();
        $this->post($url)->assertRedirect('/en/dashboard');

        $this->assertSame('active', $user->fresh()->status);
        Notification::assertSentTo($user, VerifyEmailNotification::class);
        $this->assertDatabaseHas('memberships', [
            'id' => $membership->id,
            'user_id' => $user->id,
            'invite_email' => null,
            'role' => 'admin',
            'status' => 'active',
            'invitation_token_hash' => null,
        ]);
    }

    public function test_invitation_cannot_be_accepted_by_another_email_address(): void
    {
        $organization = $this->createOrganization();
        $membership = Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'invited@example.com',
            'role' => 'member',
            'status' => 'invited',
            'invitation_token_hash' => hash('sha256', 'secret-token'),
            'invitation_expires_at' => now()->addDay(),
        ]);
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'is_owner' => true,
        ]);
        $url = URL::temporarySignedRoute(
            'organization-invitations.show',
            now()->addHour(),
            ['token' => 'secret-token'],
        );

        $this->actingAs($otherUser)->get($url)->assertForbidden();

        $this->assertNull($membership->fresh()->user_id);
    }

    public function test_invited_new_user_can_register_and_accept_the_invitation(): void
    {
        Notification::fake();

        $organization = $this->createOrganization();
        Membership::create([
            'organization_id' => $organization->id,
            'invite_email' => 'new-member@example.com',
            'role' => 'member',
            'status' => 'invited',
            'invitation_token_hash' => hash('sha256', 'new-member-token'),
            'invitation_expires_at' => now()->addDay(),
        ]);
        $url = URL::temporarySignedRoute(
            'organization-invitations.show',
            now()->addHour(),
            ['token' => 'new-member-token'],
        );

        $this->withSession(['url.intended' => $url])
            ->post('/en/register', [
                'name' => 'New Member',
                'email' => 'new-member@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect($url);

        $this->get($url)->assertOk();
        $this->post($url)->assertRedirect('/en/dashboard');

        $user = User::query()->where('email', 'new-member@example.com')->firstOrFail();

        $this->assertSame('active', $user->status);
        Notification::assertSentTo($user, VerifyEmailNotification::class);
        $this->assertDatabaseHas('memberships', [
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'role' => 'member',
            'status' => 'active',
        ]);
    }

    private function createOrganization(): Organization
    {
        return Organization::create([
            'name' => 'Example Organization',
            'slug' => 'example-organization',
            'code' => 'EXAMPLE',
            'type' => 'organization',
            'status' => 'active',
            'default_locale' => 'en',
        ]);
    }
}
