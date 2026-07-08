<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasFactory, Notifiable, HasRoles;


    // =========================
    // Fillable
    // =========================
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];


    // =========================
    // Hidden
    // =========================
    protected $hidden = [
        'password',
        'remember_token',
    ];


    // =========================
    // Casts
    // =========================
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // =========================
    // Filament Access Control
    // =========================
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive()
            && $this->hasAnyRole([
                'super-admin',
                'admin',
            ]);
    }


    // =========================
    // Status Helpers
    // =========================
    public function isActive(): bool
    {
        return $this->status === 'active';
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }


    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }


    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }


    // =========================
    // Default Status
    // =========================
    protected static function booted(): void
    {
        static::creating(function ($user) {

            if (!$user->status) {
                $user->status = 'active';
            }

        });
    }


    // =========================
    // Status Label
    // =========================
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {

            'active' => 'Active',

            'pending' => 'Pending',

            'suspended' => 'Suspended',

            'banned' => 'Banned',

            default => 'Inactive',

        };
    }


    // =========================
    // Status Color
    // =========================
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {

            'active' => 'success',

            'pending' => 'warning',

            'suspended' => 'danger',

            'banned' => 'gray',

            default => 'secondary',

        };
    }
}