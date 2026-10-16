<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'is_owner',
    ];

    /*
    |--------------------------------------------------------------------------
    | Hidden
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_owner' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Filament Access
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->isOwner()) {
            return true;
        }

        return $this->isActive()
            && $this->hasAnyRole([
                'super-admin',
                'admin',
            ]);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatar = $this->getAttribute('avatar');

        if (! is_string($avatar) || $avatar === '') {
            return null;
        }

        if (str_starts_with($avatar, 'avatars/')) {
            $disk = Storage::disk('public');

            return $disk->exists($avatar) ? $disk->url($avatar) : null;
        }

        $filename = basename($avatar);

        return is_file(public_path('uploads/avatars/' . $filename))
            ? asset('uploads/avatars/' . $filename)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Owner Check
    |--------------------------------------------------------------------------
    */

    public function isOwner(): bool
    {
        return (bool) $this->is_owner;
    }

    /*
    |--------------------------------------------------------------------------
    | Memberships
    |--------------------------------------------------------------------------
    |
    | A user can belong to multiple organizations through memberships.
    |
    */

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    public function sendEmailVerificationNotification()
    {
        $this->notify(
            new VerifyEmailNotification()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */

    public function sendPasswordResetNotification($token)
    {
        $locale = app()->getLocale();

        $url = url(
            route('password.reset', [
                'locale' => $locale,
                'token' => $token,
            ], false)
        );

        $this->notify(
            new class($url) extends ResetPassword {

                public function __construct(
                    protected string $resetUrl
                ) {}

                public function toMail($notifiable)
                {
                    return (new MailMessage)
                        ->subject(
                            __('auth.password_reset_subject')
                        )
                        ->line(
                            __('auth.password_reset_line')
                        )
                        ->action(
                            __('auth.password_reset_button'),
                            $this->resetUrl
                        );
                }
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Model Security Layer
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default User Status
        |--------------------------------------------------------------------------
        */

        static::creating(function ($user) {

            if (!$user->status) {
                $user->status = 'pending';
            }

            /*
            | اولین Owner سیستم
            */

            if ($user->is_owner) {
                $user->status = 'active';
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Protect Owner
        |--------------------------------------------------------------------------
        */

        static::updating(function ($user) {

            /*
            | Owner قابل تغییر نیست
            */

            if ($user->getOriginal('is_owner')) {
                $user->is_owner = true;
                $user->status = 'active';
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Prevent Delete Owner
        |--------------------------------------------------------------------------
        */

        static::deleting(function ($user) {

            if ($user->isOwner()) {
                throw new \Exception(
                    'System Owner cannot be deleted.'
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Status Label
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Status Color
    |--------------------------------------------------------------------------
    */

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
