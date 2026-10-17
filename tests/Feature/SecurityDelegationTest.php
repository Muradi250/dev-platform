<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\SecurityDelegation;
use App\Models\User;
use App\Services\SecurityDelegationService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SecurityDelegationTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_effective_platform_delegations_grant_permissions(): void
    {
        $permission = Permission::create([
            'name' => 'users.view',
            'guard_name' => 'web',
        ]);
        $grantor = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);

        $active = $this->makeDelegation($grantor, $recipient, $permission);

        $this->assertTrue($recipient->checkPermissionTo('users.view'));
        $this->assertTrue(Gate::forUser($recipient)->allows('users.view'));
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'security.delegation.created',
            'model_id' => $active->getKey(),
        ]);
        $this->assertTrue($recipient->notifications()
            ->whereJsonContains('data->title', 'Security access delegated')
            ->exists());

        $active->revoke();
        $this->assertFalse($recipient->fresh()->checkPermissionTo('users.view'));
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'security.delegation.revoked',
            'model_id' => $active->getKey(),
        ]);
        $this->assertTrue($recipient->notifications()
            ->whereJsonContains('data->title', 'Delegated access revoked')
            ->exists());
    }

    public function test_scheduled_and_expired_delegations_do_not_grant_permissions(): void
    {
        $permission = Permission::create([
            'name' => 'pages.edit',
            'guard_name' => 'web',
        ]);
        $grantor = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);

        $scheduled = $this->makeDelegation($grantor, $recipient, $permission, [
            'starts_at' => now()->addHour(),
        ]);

        $this->assertFalse($recipient->checkPermissionTo('pages.edit'));
        $this->assertSame('pending', $scheduled->effective_status);

        $scheduled->update([
            'starts_at' => now()->subHour(),
            'expires_at' => now()->subSecond(),
        ]);

        $this->assertFalse($recipient->fresh()->checkPermissionTo('pages.edit'));
        $this->assertSame('expired', $scheduled->fresh()->effective_status);
    }

    public function test_organization_delegations_are_limited_to_their_scope(): void
    {
        $permission = Permission::create([
            'name' => 'organizations.view',
            'guard_name' => 'web',
        ]);
        $grantor = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);
        $organization = Organization::query()->create([
            'name' => 'North Office',
            'slug' => 'north-office',
            'code' => 'NORTH',
        ]);

        $this->makeDelegation($grantor, $recipient, $permission, [
            'organization_id' => $organization->getKey(),
        ]);

        $this->assertFalse($recipient->checkPermissionTo('organizations.view'));
        $this->assertTrue($recipient->hasPermissionInOrganization(
            'organizations.view',
            (int) $organization->getKey(),
        ));
        $this->assertFalse($recipient->hasPermissionInOrganization(
            'organizations.view',
            (int) $organization->getKey() + 1,
        ));
    }

    public function test_child_delegations_cannot_outlive_or_outgrant_the_parent(): void
    {
        $permission = Permission::create([
            'name' => 'users.edit',
            'guard_name' => 'web',
        ]);
        $grantor = User::factory()->create(['status' => 'active']);
        $intermediate = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);

        $parent = $this->makeDelegation($grantor, $intermediate, $permission, [
            'expires_at' => now()->addHour(),
        ]);
        $child = $this->makeDelegation($intermediate, $recipient, $permission, [
            'parent_delegation_id' => $parent->getKey(),
            'expires_at' => now()->addMinutes(30),
        ]);

        $this->assertTrue($recipient->checkPermissionTo('users.edit'));

        $parent->revoke();

        $this->assertFalse($recipient->fresh()->checkPermissionTo('users.edit'));
        $this->assertSame('expired', $child->fresh()->effective_status);
    }

    public function test_users_cannot_delegate_permissions_they_do_not_hold(): void
    {
        $permission = Permission::create([
            'name' => 'roles.delete',
            'guard_name' => 'web',
        ]);
        $actor = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);

        try {
            app(SecurityDelegationService::class)->validate($actor, [
                'delegated_to_user_id' => $recipient->getKey(),
                'status' => 'active',
                'permissions' => [$permission->getKey()],
            ]);
            $this->fail('Expected a delegation validation exception.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('permissions', $exception->errors());
        }
    }

    public function test_only_the_grantor_or_owner_can_edit_a_delegation(): void
    {
        $permission = Permission::create([
            'name' => 'users.create',
            'guard_name' => 'web',
        ]);
        $grantor = User::factory()->create(['status' => 'active']);
        $recipient = User::factory()->create(['status' => 'active']);
        $otherUser = User::factory()->create(['status' => 'active']);
        $delegation = $this->makeDelegation($grantor, $recipient, $permission);

        $this->expectException(AuthorizationException::class);

        app(SecurityDelegationService::class)->validate($otherUser, [
            'delegated_to_user_id' => $recipient->getKey(),
            'status' => 'active',
            'permissions' => [$permission->getKey()],
        ], $delegation);
    }

    private function makeDelegation(
        User $grantor,
        User $recipient,
        Permission $permission,
        array $attributes = [],
    ): SecurityDelegation {
        $delegation = SecurityDelegation::query()->create([
            'delegated_by_user_id' => $grantor->getKey(),
            'delegated_to_user_id' => $recipient->getKey(),
            'status' => 'active',
            ...$attributes,
        ]);
        $delegation->permissions()->sync([$permission->getKey()]);

        return $delegation;
    }
}
