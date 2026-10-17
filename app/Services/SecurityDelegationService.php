<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\SecurityDelegation;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\PermissionRegistrar;

class SecurityDelegationService
{
    public function canManage(User $actor, SecurityDelegation $delegation): bool
    {
        return $actor->isOwner()
            || (string) $delegation->delegated_by_user_id === (string) $actor->getKey();
    }

    public function authorizeManager(User $actor, SecurityDelegation $delegation): void
    {
        if (! $this->canManage($actor, $delegation)) {
            throw new AuthorizationException('You may only manage delegations you created.');
        }
    }

    public function logPermissionSnapshot(SecurityDelegation $delegation): void
    {
        $permissions = $delegation->permissions()
            ->orderBy('name')
            ->get(['permissions.id', 'permissions.name']);

        ActivityLogger::log(
            'security.delegation.permissions_assigned',
            'The permissions granted by a security delegation were saved.',
            $delegation,
            [
                'delegation_id' => $delegation->getKey(),
                'permission_ids' => $permissions->modelKeys(),
                'permission_names' => $permissions->pluck('name')->all(),
            ],
            severity: 'warning',
            icon: 'heroicon-o-key',
        );
    }

    public function validate(User $actor, array $data, ?SecurityDelegation $current = null): void
    {
        if ($current !== null) {
            $this->authorizeManager($actor, $current);

            if (in_array($current->effective_status, ['revoked', 'expired'], true)) {
                throw new AuthorizationException('Expired or revoked delegations cannot be edited.');
            }
        }

        $recipient = User::query()->find($data['delegated_to_user_id'] ?? null);

        if (
            $recipient === null
            || $recipient->isOwner()
            || ! $recipient->isActive()
            || (string) $recipient->getKey() === (string) $actor->getKey()
        ) {
            throw ValidationException::withMessages([
                'delegated_to_user_id' => 'Choose an active user other than yourself or the Platform Owner.',
            ]);
        }

        $status = $data['status'] ?? 'active';

        if (! in_array($status, ['active', 'pending'], true)) {
            throw ValidationException::withMessages([
                'status' => 'Delegations can only be created or edited as active or pending. Use Revoke to end a delegation.',
            ]);
        }

        if (
            filled($data['organization_id'] ?? null)
            && ! Organization::query()->whereKey($data['organization_id'])->exists()
        ) {
            throw ValidationException::withMessages([
                'organization_id' => 'Choose an existing organization.',
            ]);
        }

        $startsAt = filled($data['starts_at'] ?? null)
            ? Carbon::parse($data['starts_at'])
            : null;
        $expiresAt = filled($data['expires_at'] ?? null)
            ? Carbon::parse($data['expires_at'])
            : null;

        if ($startsAt !== null && $expiresAt !== null && ! $expiresAt->gt($startsAt)) {
            throw ValidationException::withMessages([
                'expires_at' => 'The expiration must be later than the start time.',
            ]);
        }

        $permissions = $data['permissions'] ?? [];
        $permissions = is_array($permissions) ? array_unique($permissions) : [];

        if ($permissions === []) {
            throw ValidationException::withMessages([
                'permissions' => 'Select at least one permission to delegate.',
            ]);
        }

        $parent = null;
        $parentId = $data['parent_delegation_id'] ?? null;

        if (filled($parentId)) {
            $parent = SecurityDelegation::query()->find($parentId);

            if (
                $parent === null
                || ($current !== null && (string) $parent->getKey() === (string) $current->getKey())
                || (string) $parent->delegated_to_user_id !== (string) $actor->getKey()
                || ! $parent->isEffectiveAt()
                || (
                    $parent->organization_id !== null
                    && (string) $parent->organization_id !== (string) ($data['organization_id'] ?? '')
                )
            ) {
                throw ValidationException::withMessages([
                    'parent_delegation_id' => 'Choose an effective delegation granted to you with a compatible scope.',
                ]);
            }

            if (
                ($parent->starts_at !== null && ($startsAt === null || $startsAt->lt($parent->starts_at)))
                || ($parent->expires_at !== null && ($expiresAt === null || $expiresAt->gt($parent->expires_at)))
            ) {
                throw ValidationException::withMessages([
                    'expires_at' => 'The child delegation must stay within its parent delegation validity period.',
                ]);
            }
        }

        $permissionModel = app(PermissionRegistrar::class)->getPermissionClass();
        $resolvedPermissions = [];

        foreach ($permissions as $permissionId) {
            $permission = $permissionModel::query()->find($permissionId);

            if ($permission === null) {
                throw ValidationException::withMessages([
                    'permissions' => 'One or more selected permissions do not exist.',
                ]);
            }

            $resolvedPermissions[] = $permission;
        }

        $organizationId = filled($data['organization_id'] ?? null)
            ? (int) $data['organization_id']
            : null;

        foreach ($resolvedPermissions as $permission) {
            $inheritedFromParent = $parent?->grantsPermission((int) $permission->getKey()) ?? false;

            if ($parent !== null && ! $inheritedFromParent) {
                throw ValidationException::withMessages([
                    'permissions' => 'A child delegation cannot grant permissions that are not present in its parent.',
                ]);
            }

            if ($actor->isOwner()) {
                continue;
            }

            $directlyHeld = $actor->hasPermissionTo($permission->name, $permission->guard_name);

            if (! $directlyHeld && ! $inheritedFromParent) {
                $heldInOrganization = $organizationId !== null
                    && $actor->hasPermissionInOrganization(
                        $permission->name,
                        $organizationId,
                        $permission->guard_name,
                    );

                if (! $heldInOrganization) {
                    throw ValidationException::withMessages([
                        'permissions' => 'You may only delegate permissions that you currently hold.',
                    ]);
                }

                throw ValidationException::withMessages([
                    'parent_delegation_id' => 'Select the source delegation when passing on delegated permissions.',
                ]);
            }
        }
    }
}
