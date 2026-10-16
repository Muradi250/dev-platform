<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\OrganizationalUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrganizationStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizational_units_cannot_have_a_parent_from_another_organization(): void
    {
        $organization = $this->createOrganization('north');
        $otherOrganization = $this->createOrganization('south');
        $parent = $this->createUnit($otherOrganization, 'parent');

        $this->expectException(ValidationException::class);

        $this->createUnit($organization, 'child', $parent->id);
    }

    public function test_organizational_unit_hierarchies_cannot_contain_cycles(): void
    {
        $organization = $this->createOrganization('central');
        $parent = $this->createUnit($organization, 'parent');
        $child = $this->createUnit($organization, 'child', $parent->id);

        $this->expectException(ValidationException::class);

        $parent->parent_id = $child->id;
        $parent->save();
    }

    public function test_employee_unit_must_belong_to_the_selected_organization(): void
    {
        $organization = $this->createOrganization('east');
        $otherOrganization = $this->createOrganization('west');
        $unit = $this->createUnit($otherOrganization, 'unit');

        $this->expectException(ValidationException::class);

        Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-001',
            'first_name' => 'Test',
            'last_name' => 'Employee',
        ]);
    }

    private function createOrganization(string $code): Organization
    {
        return Organization::create([
            'name' => ucfirst($code) . ' Organization',
            'slug' => $code . '-organization',
            'code' => strtoupper($code),
            'type' => 'organization',
            'status' => 'active',
            'default_locale' => 'en',
        ]);
    }

    private function createUnit(
        Organization $organization,
        string $code,
        ?int $parentId = null,
    ): OrganizationalUnit {
        return OrganizationalUnit::create([
            'organization_id' => $organization->id,
            'parent_id' => $parentId,
            'name' => ucfirst($code),
            'code' => strtoupper($code),
            'type' => 'department',
            'status' => 'active',
        ]);
    }
}
