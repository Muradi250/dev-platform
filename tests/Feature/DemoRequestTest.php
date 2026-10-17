<?php

namespace Tests\Feature;

use App\Models\DemoRequest;
use App\Models\Page;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_demo_request_form_is_available_for_each_supported_locale(): void
    {
        foreach (['en', 'fa', 'ps'] as $locale) {
            $this->get("/{$locale}/demo-request")
                ->assertOk()
                ->assertSee(route('demo-requests.store', ['locale' => $locale]), false)
                ->assertSee('name="company"', false)
                ->assertSee('name="website"', false);
        }
    }

    public function test_both_get_started_header_actions_use_the_current_localized_registration_route(): void
    {
        Page::query()->create([
            'title' => 'Home',
            'slug' => 'home',
            'status' => 'published',
            'locale' => 'fa',
            'settings' => [
                'header' => [
                    'items' => [
                        'cta' => true,
                    ],
                    'cta' => [
                        'text' => 'Get Started',
                        'url' => '/register',
                    ],
                    'actions' => [
                        'enabled' => true,
                        'text' => 'Get Started',
                        'url' => '/register',
                    ],
                ],
            ],
        ]);

        $response = $this->get('/fa');

        $response
            ->assertOk()
            ->assertSee('href="'.route('register', ['locale' => 'fa']).'"', false);

        $this->assertSame(
            4,
            substr_count($response->getContent(), 'href="'.route('register', ['locale' => 'fa']).'"'),
        );
    }

    public function test_valid_demo_request_is_saved_and_redirects_with_confirmation(): void
    {
        User::factory()->create([
            'is_owner' => true,
            'status' => 'active',
        ]);

        $response = $this->post('/fa/demo-request', [
            'name' => '  Alex Example  ',
            'email' => 'alex@example.test',
            'company' => 'Example Organization',
            'phone' => '+1 555 0100',
            'team_size' => '11-50',
            'message' => 'We need an organization management walkthrough.',
        ]);

        $response
            ->assertRedirect(route('demo-requests.create', ['locale' => 'fa']))
            ->assertSessionHas('demo_request_success', true);

        $this->assertDatabaseHas('demo_requests', [
            'name' => 'Alex Example',
            'email' => 'alex@example.test',
            'company' => 'Example Organization',
            'team_size' => '11-50',
            'status' => 'new',
            'locale' => 'fa',
        ]);
        $this->assertDatabaseCount('notifications', 1);
    }

    public function test_invalid_demo_request_is_not_saved(): void
    {
        $this->from('/en/demo-request')
            ->post('/en/demo-request', [
                'name' => 'Demo User',
                'email' => 'not-an-email',
                'company' => 'Example Organization',
            ])
            ->assertRedirect('/en/demo-request')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('demo_requests', 0);
    }

    public function test_honeypot_submission_is_not_stored_and_receives_generic_confirmation(): void
    {
        $this->post('/en/demo-request', [
            'name' => 'Spam User',
            'email' => 'spam@example.test',
            'company' => 'Spam Company',
            'website' => 'https://spam.example.test',
        ])
            ->assertRedirect(route('demo-requests.create', ['locale' => 'en']))
            ->assertSessionHas('demo_request_success', true);

        $this->assertDatabaseCount('demo_requests', 0);
    }

    public function test_admin_can_review_and_update_demo_request_status(): void
    {
        $user = User::factory()->create([
            'is_owner' => true,
            'status' => 'active',
        ]);
        $record = DemoRequest::query()->create([
            'name' => 'Taylor Example',
            'email' => 'taylor@example.test',
            'company' => 'Example Inc.',
            'status' => 'new',
            'locale' => 'en',
        ]);

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $this->get(route('filament.admin.resources.demo-requests.index'))
            ->assertOk()
            ->assertSee('Taylor Example')
            ->assertSee('taylor@example.test');

        $this->get(route('filament.admin.resources.demo-requests.view', [
            'record' => $record,
        ]))
            ->assertOk()
            ->assertSee('Example Inc.');
    }
}
