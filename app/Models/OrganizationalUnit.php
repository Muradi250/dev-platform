<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class OrganizationalUnit extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'organization_id',
        'parent_id',
        'name',
        'code',
        'type',
        'status',
        'head_name',
        'head_email',
        'head_phone',
        'location',
        'effective_from',
        'effective_until',
        'description',
        'settings',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'effective_from' => 'date',
            'effective_until' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $unit): void {
            $parentId = $unit->parent_id;

            if (blank($parentId)) {
                $unit->parent_id = null;
            } else {
                $visitedParentIds = [];

                while ($parentId !== null) {
                    if ($unit->exists && (string) $parentId === (string) $unit->getKey()) {
                        throw ValidationException::withMessages([
                            'parent_id' => 'An organizational unit cannot be its own ancestor.',
                        ]);
                    }

                    if (isset($visitedParentIds[$parentId])) {
                        throw ValidationException::withMessages([
                            'parent_id' => 'The organizational structure cannot contain a cycle.',
                        ]);
                    }

                    $visitedParentIds[$parentId] = true;
                    $parent = static::query()->find($parentId);

                    if (
                        ! $parent ||
                        (string) $parent->organization_id !== (string) $unit->organization_id
                    ) {
                        throw ValidationException::withMessages([
                            'parent_id' => 'The parent unit must belong to the same organization.',
                        ]);
                    }

                    $parentId = $parent->parent_id;
                }
            }

            if (
                $unit->effective_from
                && $unit->effective_until
                && $unit->effective_until->lt($unit->effective_from)
            ) {
                throw ValidationException::withMessages([
                    'effective_until' => 'The end date must be on or after the effective start date.',
                ]);
            }
        });

        static::deleting(function (self $unit): void {
            if ($unit->children()->exists() || $unit->employees()->exists()) {
                throw ValidationException::withMessages([
                    'organizational_unit' => 'Reassign or remove this unit’s child units and employees before deleting it.',
                ]);
            }
        });
    }

    /**
     * The organization this unit belongs to.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * The parent organizational unit.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            OrganizationalUnit::class,
            'parent_id'
        );
    }

    /**
     * The child organizational units.
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            OrganizationalUnit::class,
            'parent_id'
        );
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'organizational_unit_id');
    }

    /**
     * Return this unit's descendant IDs so parent selectors can prevent cycles.
     *
     * @return array<int, int>
     */
    public function descendantIds(bool $includeSelf = false): array
    {
        $unitsByParent = static::query()
            ->where('organization_id', $this->organization_id)
            ->whereNotNull('parent_id')
            ->get(['id', 'parent_id'])
            ->groupBy('parent_id');

        $descendantIds = [];
        $pendingIds = [$this->getKey()];

        while ($pendingIds !== []) {
            $parentId = array_pop($pendingIds);

            foreach ($unitsByParent->get($parentId, collect()) as $child) {
                if (isset($descendantIds[$child->getKey()])) {
                    continue;
                }

                $descendantIds[$child->getKey()] = (int) $child->getKey();
                $pendingIds[] = $child->getKey();
            }
        }

        if ($includeSelf) {
            $descendantIds[$this->getKey()] = (int) $this->getKey();
        }

        return array_values($descendantIds);
    }
}
