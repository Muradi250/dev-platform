<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_logger_persists_audit_fields_and_context(): void
    {
        $actor = User::factory()->create([
            'is_owner' => true,
            'status' => 'active',
        ]);

        $this->actingAs($actor);

        ActivityLogger::log(
            action: 'security.policy.changed',
            description: 'A security policy was changed.',
            context: ['policy' => 'login', 'enabled' => true],
        );

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $actor->getKey(),
            'action' => 'security.policy.changed',
            'category' => 'security',
            'module' => 'security',
            'description' => 'A security policy was changed.',
        ]);

        $log = ActivityLog::query()
            ->where('action', 'security.policy.changed')
            ->sole();

        $this->assertSame([
            'policy' => 'login',
            'enabled' => true,
        ], $log->context);
    }

    public function test_activity_log_index_and_detail_pages_render_for_panel_owner(): void
    {
        $actor = User::factory()->create([
            'is_owner' => true,
            'status' => 'active',
        ]);
        $log = ActivityLog::query()->create([
            'user_id' => $actor->getKey(),
            'action' => 'security.policy.changed',
            'description' => 'Policy changed for audit page check.',
            'category' => 'security',
            'severity' => 'warning',
            'module' => 'security',
            'ip_address' => '192.0.2.10',
            'user_agent' => 'ActivityLogFeatureTest/1.0',
            'context' => ['policy' => 'login', 'enabled' => true],
        ]);

        $this->actingAs($actor);

        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $this->get(route('filament.admin.resources.activity-logs.index'))
            ->assertOk()
            ->assertSee('fi-topbar-database-notifications-btn')
            ->assertSee('corporate-header-admin-icon')
            ->assertSee('corporate-header-workspace-icon')
            ->assertSee('corporate-header-role-icon')
            ->assertSee('corporate-header-context')
            ->assertSee('Admin session active')
            ->assertSee(now()->format('M d, Y'))
            ->assertSee('admin-panel-footer')
            ->assertSee('Admin workspace')
            ->assertSee((string) now()->year);

        $this->get(route('filament.admin.resources.activity-logs.view', [
            'record' => $log,
        ]))
            ->assertOk()
            ->assertSee('Policy changed for audit page check.')
            ->assertSee('ActivityLogFeatureTest/1.0')
            ->assertSee('192.0.2.10')
            ->assertSee('policy');
    }

    public function test_security_navigation_groups_have_icons(): void
    {
        $groups = Filament::getPanel('admin')
            ->getNavigationGroups();

        $this->assertSame(
            [
                'Access & Security' => 'heroicon-o-shield-check',
                'Security & Audit' => 'heroicon-o-clipboard-document-check',
            ],
            collect($groups)
                ->filter(fn ($group): bool => $group instanceof NavigationGroup)
                ->mapWithKeys(fn (NavigationGroup $group): array => [
                    $group->getLabel() => $group->getIcon(),
                ])
                ->all(),
        );
    }

    public function test_admin_panel_uses_database_notifications_in_the_topbar(): void
    {
        $panel = Filament::getPanel('admin');

        $this->assertTrue($panel->hasDatabaseNotifications());
    }

    public function test_admin_sidebar_is_collapsible_on_desktop(): void
    {
        $this->assertTrue(
            Filament::getPanel('admin')->isSidebarCollapsibleOnDesktop(),
        );
    }
}
