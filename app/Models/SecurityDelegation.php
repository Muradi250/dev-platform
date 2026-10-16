<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
            \Spatie\Permission\Models\Permission::class,
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
}