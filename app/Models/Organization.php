<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'type',
        'status',
        'default_locale',
        'description',
        'email',
        'phone',
        'website',
        'logo',
        'settings',
        'legal_type',
        'registration_number',
        'tax_id',
        'address_line_1',
        'address_line_2',
        'country',
        'region',
        'city',
        'postal_code',
        'primary_contact_name',
        'primary_contact_email',
        'primary_contact_phone',
        'timezone',
        'currency',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    /**
     * The memberships of this organization.
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * The organizational units of this organization.
     */
    public function organizationalUnits(): HasMany
    {
        return $this->hasMany(OrganizationalUnit::class);
    }

    /**
     * The employees of this organization.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}