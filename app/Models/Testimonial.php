<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
        'name',
        'email',
        'company',
        'position',
        'avatar',
        'rating',
        'message',
        'status',
        'featured',
        'approved_at',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'featured' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Scope: approved testimonials.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: pending testimonials.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: rejected testimonials.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: featured testimonials.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    /**
     * Check whether testimonial is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check whether testimonial is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check whether testimonial is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}