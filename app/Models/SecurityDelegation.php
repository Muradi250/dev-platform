<?php

namespace App\Models;

use App\Services\ActivityLogger;
use DateTimeInterface;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class SecurityDelegation extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'delegated_by_user_id',
        'delegated_to_user_id',
        'parent_delegation_id',
        'organization_id',
        'status',
        'starts_at',
        'expires_at',
        'revoked_at',
        'reason',
        'metadata',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (self $delegation): void {
            ActivityLogger::log(
                'security.delegation.created',
                'A security delegation was created.',
                $delegation,
                $delegation->auditContext(),
                severity: 'warning',
                icon: 'heroicon-o-shield-check',
            );

            $delegation->sendRecipientNotification(revoked: false);
        });

        static::updated(function (self $delegation): void {
            ActivityLogger::log(
                $delegation->wasChanged('status') && $delegation->status === 'revoked'
                    ? 'security.delegation.revoked'
                    : 'security.delegation.updated',
                $delegation->wasChanged('status') && $delegation->status === 'revoked'
                    ? 'A security delegation was revoked.'
                    : 'A security delegation was updated.',
                $delegation,
                [
                    ...$delegation->auditContext(),
                    'changed_fields' => array_keys($delegation->getChanges()),
                ],
                severity: 'warning',
                icon: 'heroicon-o-shield-check',
            );

            if ($delegation->wasChanged('status') && $delegation->status === 'revoked') {
                $delegation->sendRecipientNotification(revoked: true);
            }
        });
    }

    public function scopeEffectiveAt(Builder $query, ?DateTimeInterface $at = null): Builder
    {
        $at ??= now();

        return $query
            ->where('status', 'active')
            ->whereNull('revoked_at')
            ->where(fn (Builder $query) => $query
                ->whereNull('starts_at')
                ->orWhere('starts_at', '<=', $at))
            ->where(fn (Builder $query) => $query
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', $at));
    }

    public function isEffectiveAt(?DateTimeInterface $at = null, array $visited = []): bool
    {
        $at ??= now();

        if (
            in_array($this->getKey(), $visited, true)
            || $this->status !== 'active'
            || $this->revoked_at !== null
            || ($this->starts_at !== null && $this->starts_at->gt($at))
            || ($this->expires_at !== null && ! $this->expires_at->gt($at))
        ) {
            return false;
        }

        if ($this->parent_delegation_id === null) {
            return true;
        }

        $parent = $this->parentDelegation;

        return $parent !== null
            && (string) $parent->delegated_to_user_id === (string) $this->delegated_by_user_id
            && ($parent->organization_id === null
                || (string) $parent->organization_id === (string) $this->organization_id)
            && $parent->isEffectiveAt($at, [...$visited, $this->getKey()]);
    }

    public function grantsPermission(int $permissionId, ?DateTimeInterface $at = null, array $visited = []): bool
    {
        if (
            in_array($this->getKey(), $visited, true)
            || ! $this->isEffectiveAt($at, $visited)
            || ! $this->permissions()->whereKey($permissionId)->exists()
        ) {
            return false;
        }

        if ($this->parent_delegation_id === null) {
            return true;
        }

        return $this->parentDelegation?->grantsPermission(
            $permissionId,
            $at,
            [...$visited, $this->getKey()],
        ) ?? false;
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === 'revoked' || $this->revoked_at !== null) {
            return 'revoked';
        }

        if ($this->status === 'expired' || ($this->expires_at !== null && ! $this->expires_at->isFuture())) {
            return 'expired';
        }

        if ($this->status === 'pending' || ($this->starts_at !== null && $this->starts_at->isFuture())) {
            return 'pending';
        }

        return $this->isEffectiveAt() ? 'active' : 'expired';
    }

    /**
     * The user who delegated the authority.
     */
    public function delegatedByUser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'delegated_by_user_id'
        );
    }

    /**
     * The user who received the authority.
     */
    public function delegatedToUser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'delegated_to_user_id'
        );
    }

    /**
     * The parent delegation in the delegation chain.
     */
    public function parentDelegation(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'parent_delegation_id'
        );
    }

    /**
     * Delegations created from this delegation.
     */
    public function childDelegations(): HasMany
    {
        return $this->hasMany(
            self::class,
            'parent_delegation_id'
        );
    }

    /**
     * The organization context of this delegation.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Permissions granted by this delegation.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'security_delegation_permissions',
            'security_delegation_id',
            'permission_id'
        );
    }

    /**
     * Revoke this delegation without deleting its record.
     *
     * Returns false if the delegation has already been revoked.
     */
    public function revoke(): bool
    {
        return DB::transaction(function (): bool {
            $delegation = self::query()
                ->lockForUpdate()
                ->findOrFail($this->getKey());

            if ($delegation->status === 'revoked') {
                return false;
            }

            $delegation->status = 'revoked';
            $delegation->revoked_at = now();
            $delegation->save();

            $this->refresh();

            return true;
        });
    }

    private function auditContext(): array
    {
        return [
            'delegation_id' => $this->getKey(),
            'delegated_by_user_id' => $this->delegated_by_user_id,
            'delegated_to_user_id' => $this->delegated_to_user_id,
            'organization_id' => $this->organization_id,
            'parent_delegation_id' => $this->parent_delegation_id,
            'status' => $this->status,
        ];
    }

    private function sendRecipientNotification(bool $revoked): void
    {
        $recipient = $this->delegatedToUser()->firstOrFail();

        $notification = Notification::make()
            ->title($revoked
                ? 'Delegated access revoked'
                : ($this->effective_status === 'pending'
                    ? 'Security access scheduled'
                    : 'Security access delegated'))
            ->body($revoked
                ? "Delegation #{$this->getKey()} has been revoked."
                : "A security delegation (#{$this->getKey()}) has been assigned to you.")
            ->icon('heroicon-o-shield-check')
            ->iconColor($revoked ? 'danger' : 'warning')
            ->actions([
                Action::make('view')
                    ->label('Review delegation')
                    ->url(route('filament.admin.resources.security-delegations.view', [
                        'record' => $this->getKey(),
                    ]))
                    ->markAsRead(),
            ]);

        $notification->sendToDatabase($recipient);
    }
}
