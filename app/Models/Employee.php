<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'organizational_unit_id',
        'employee_number',
        'first_name',
        'last_name',
        'photo',
        'work_email',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'status',
        'job_title',
        'employment_type',
        'joined_at',
        'ended_at',
        'description',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
            'ended_at' => 'date',
            'settings' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $employee): void {
            $unit = OrganizationalUnit::query()->find($employee->organizational_unit_id);

            if (
                ! $unit ||
                (string) $unit->organization_id !== (string) $employee->organization_id
            ) {
                throw ValidationException::withMessages([
                    'organizational_unit_id' => 'The organizational unit must belong to the selected organization.',
                ]);
            }

            if ($employee->joined_at && $employee->ended_at && $employee->ended_at->lt($employee->joined_at)) {
                throw ValidationException::withMessages([
                    'ended_at' => 'The end date must be on or after the join date.',
                ]);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'organizational_unit_id'
        );
    }

    public function getPhotoUrlAttribute(): ?string
    {
        $photo = $this->getAttribute('photo');

        if (! is_string($photo) || $photo === '') {
            return null;
        }

        $disk = Storage::disk('public');

        return $disk->exists($photo) ? $disk->url($photo) : null;
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}