<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'organization_id',
        'invite_email',
        'role',
        'status',
        'joined_at',
        'invitation_token_hash',
        'invited_at',
        'invitation_expires_at',
        'accepted_at',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
            'invited_at' => 'datetime',
            'invitation_expires_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    /**
     * The user who owns this membership.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The organization this membership belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}