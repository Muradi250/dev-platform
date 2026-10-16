<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\OrganizationalUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class OrganizationalUnitProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_unit_profile_is_branded_and_shows_hierarchy_lead_and_staff_counts(): void
    {
        $organization = $this->createOrganization();
        $parent = $this->createUnit($organization, [
            'name' => 'Operations',
            'code' => 'OPS',
        ]);
        $unit = $this->createUnit($organization, [
            'parent_id' => $parent->id,
            'name' => 'Field Team',
            'code' => 'FIELD',
            'type' => 'team',
            'head_name' => 'Casey Morgan',
            'head_email' => 'casey@example.test',
            'head_phone' => '+1 555 0105',
            'location' => 'Kabul Office',
            'effective_from' => '2025-01-01',
        ]);
        Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-UNIT-1',
            'first_name' => 'Jamie',
            'last_name' => 'Lee',
            'job_title' => 'Coordinator',
            'status' => 'active',
        ]);
        $this->createUnit($organization, [
            'parent_id' => $unit->id,
            'name' => 'Logistics',
            'code' => 'LOG',
            'type' => 'section',
        ]);

        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner)
            ->get(route('filament.admin.resources.organizational-units.view', ['record' => $unit]))
            ->assertOk()
            ->assertSee('Dev-Platform')
            ->assertSee('ORGANIZATION STRUCTURE')
            ->assertSee('Field Team')
            ->assertSee('Download PDF')
            ->assertSee('Operations')
            ->assertSee('Casey Morgan')
            ->assertSee('casey@example.test')
            ->assertSee('Jamie Lee')
            ->assertSee('1', false);
    }

    public function test_organizational_unit_profile_can_be_downloaded_as_a_pdf(): void
    {
        $organization = $this->createOrganization();
        $unit = $this->createUnit($organization, [
            'name' => 'Field Team',
            'code' => 'FIELD',
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\OrganizationalUnits\Pages\ViewOrganizationalUnit::class, [
            'record' => $unit->id,
        ])
            ->call('downloadPdf')
            ->assertFileDownloaded("organizational-unit-profile-{$unit->id}.pdf", contentType: 'application/pdf');
    }

    public function test_organizational_unit_form_creates_a_standard_unit(): void
    {
        $organization = $this->createOrganization();
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\OrganizationalUnits\Pages\CreateOrganizationalUnit::class)
            ->fillForm([
                'organization_id' => $organization->id,
                'name' => 'People Operations',
                'code' => 'PEOPLE-OPS',
                'type' => 'department',
                'status' => 'active',
                'head_name' => 'Riley Taylor',
                'head_email' => 'riley@example.test',
                'head_phone' => '+1 555 0106',
                'location' => 'North Office',
                'effective_from' => '2025-01-01',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('organizational_units', [
            'organization_id' => $organization->id,
            'name' => 'People Operations',
            'code' => 'PEOPLE-OPS',
            'head_name' => 'Riley Taylor',
            'head_email' => 'riley@example.test',
            'location' => 'North Office',
        ]);

        $unit = OrganizationalUnit::query()
            ->where('code', 'PEOPLE-OPS')
            ->firstOrFail();
        $this->assertSame('2025-01-01', $unit->effective_from->format('Y-m-d'));
    }

    public function test_parent_options_exclude_the_unit_and_its_descendants(): void
    {
        $organization = $this->createOrganization();
        $root = $this->createUnit($organization, ['name' => 'Root', 'code' => 'ROOT']);
        $child = $this->createUnit($organization, [
            'name' => 'Child',
            'code' => 'CHILD',
            'parent_id' => $root->id,
        ]);
        $grandchild = $this->createUnit($organization, [
            'name' => 'Grandchild',
            'code' => 'GRANDCHILD',
            'parent_id' => $child->id,
        ]);

        $this->assertEqualsCanonicalizing(
            [$child->id, $grandchild->id],
            $root->descendantIds(),
        );

        $this->assertEqualsCanonicalizing(
            [$child->id, $grandchild->id],
            $child->descendantIds(includeSelf: true),
        );
    }

    public function test_units_with_children_or_employees_cannot_be_deleted(): void
    {
        $organization = $this->createOrganization();
        $unit = $this->createUnit($organization, ['name' => 'Root', 'code' => 'ROOT']);
        $this->createUnit($organization, [
            'name' => 'Child',
            'code' => 'CHILD',
            'parent_id' => $unit->id,
        ]);

        try {
            $unit->delete();
            $this->fail('A unit with child units should not be deleted.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('organizational_unit', $exception->errors());
        }

        $employeeUnit = $this->createUnit($organization, ['name' => 'Staff', 'code' => 'STAFF']);
        Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $employeeUnit->id,
            'employee_number' => 'EMP-UNIT-2',
            'first_name' => 'Alex',
            'last_name' => 'Morgan',
        ]);

        try {
            $employeeUnit->delete();
            $this->fail('A unit with employees should not be deleted.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('organizational_unit', $exception->errors());
        }
    }

    public function test_unit_effective_end_date_cannot_precede_start_date(): void
    {
        $organization = $this->createOrganization();

        $this->expectException(ValidationException::class);

        $this->createUnit($organization, [
            'name' => 'Invalid unit',
            'code' => 'INVALID',
            'effective_from' => '2025-02-01',
            'effective_until' => '2025-01-31',
        ]);
    }

    private function createOrganization(): Organization
    {
        return Organization::create([
            'name' => 'North Organization',
            'slug' => 'north-organization',
            'code' => 'NORTH',
            'type' => 'organization',
            'status' => 'active',
            'default_locale' => 'en',
        ]);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createUnit(Organization $organization, array $attributes): OrganizationalUnit
    {
        return OrganizationalUnit::create([
            'organization_id' => $organization->id,
            'name' => 'Operations',
            'code' => 'OPS',
            'type' => 'department',
            'status' => 'active',
            ...$attributes,
        ]);
    }
}
