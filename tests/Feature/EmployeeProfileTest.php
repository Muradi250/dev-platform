<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\OrganizationalUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_profile_fields_and_photo_are_saved_and_resolved(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('employees/photos/employee.png', 'image-content');
        [$organization, $unit] = $this->createOrganizationAndUnit();

        $employee = Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-001',
            'first_name' => 'Alex',
            'last_name' => 'Morgan',
            'photo' => 'employees/photos/employee.png',
            'work_email' => 'alex@example.test',
            'phone' => '+1 555 0100',
            'emergency_contact_name' => 'Sam Morgan',
            'emergency_contact_phone' => '+1 555 0101',
            'emergency_contact_relationship' => 'spouse',
        ]);

        $this->assertSame('Alex Morgan', $employee->full_name);
        $this->assertSame('alex@example.test', $employee->work_email);
        $this->assertSame(
            Storage::disk('public')->url('employees/photos/employee.png'),
            $employee->photo_url,
        );
    }

    public function test_employee_end_date_cannot_precede_join_date(): void
    {
        [$organization, $unit] = $this->createOrganizationAndUnit();

        $this->expectException(ValidationException::class);

        Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-002',
            'first_name' => 'Alex',
            'last_name' => 'Morgan',
            'joined_at' => '2025-02-01',
            'ended_at' => '2025-01-31',
        ]);
    }

    public function test_employee_profile_view_displays_photo_and_personnel_details(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('employees/photos/employee.png', 'image-content');
        [$organization, $unit] = $this->createOrganizationAndUnit();

        $employee = Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-003',
            'first_name' => 'Alex',
            'last_name' => 'Morgan',
            'photo' => 'employees/photos/employee.png',
            'work_email' => 'alex@example.test',
            'job_title' => 'Program Manager',
            'employment_type' => 'full_time',
        ])->load(['organization', 'organizationalUnit', 'user']);

        $html = view('filament.resources.employees.pages.employee-profile', [
            'employee' => $employee,
            'editUrl' => '/admin/employees/1/edit',
            'issuedAt' => now(),
        ])->render();

        $this->assertStringContainsString('Alex Morgan', $html);
        $this->assertStringContainsString('EMP-003', $html);
        $this->assertStringContainsString('Program Manager', $html);
        $this->assertStringContainsString('alex@example.test', $html);
        $this->assertStringContainsString(Storage::disk('public')->url('employees/photos/employee.png'), $html);
        $this->assertStringContainsString('Dev-Platform', $html);
        $this->assertStringContainsString('PEOPLE &amp; ORGANIZATION', $html);
        $this->assertStringContainsString('Download PDF', $html);
        $this->assertStringContainsString('window.print()', $html);
    }

    public function test_employee_profile_can_be_downloaded_as_a_pdf(): void
    {
        [$organization, $unit] = $this->createOrganizationAndUnit();
        $employee = Employee::create([
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'employee_number' => 'EMP-PDF-001',
            'first_name' => 'Alex',
            'last_name' => 'Morgan',
        ]);
        $owner = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($owner);

        Livewire::test(\App\Filament\Resources\Employees\Pages\ViewEmployee::class, [
            'record' => $employee->id,
        ])
            ->call('downloadPdf')
            ->assertFileDownloaded("employee-profile-{$employee->id}.pdf", contentType: 'application/pdf');
    }

    public function test_employee_create_form_saves_submitted_data(): void
    {
        Storage::fake('public');
        [$organization, $unit] = $this->createOrganizationAndUnit();
        $admin = User::factory()->create([
            'status' => 'active',
            'is_owner' => true,
        ]);

        $this->actingAs($admin);

        Livewire::test(\App\Filament\Resources\Employees\Pages\CreateEmployee::class)
            ->fillForm([
                'organization_id' => $organization->id,
                'organizational_unit_id' => $unit->id,
                'user_id' => $admin->id,
                'employee_number' => 'EMP-CREATE-001',
                'first_name' => 'Taylor',
                'last_name' => 'Jordan',
                'photo' => UploadedFile::fake()->image('employee.png'),
                'work_email' => 'taylor@example.test',
                'phone' => '+1 555 0102',
                'job_title' => 'Coordinator',
                'employment_type' => 'full_time',
                'status' => 'active',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('employees', [
            'organization_id' => $organization->id,
            'organizational_unit_id' => $unit->id,
            'user_id' => $admin->id,
            'employee_number' => 'EMP-CREATE-001',
            'first_name' => 'Taylor',
            'last_name' => 'Jordan',
            'work_email' => 'taylor@example.test',
            'phone' => '+1 555 0102',
        ]);

        $employee = Employee::query()->where('employee_number', 'EMP-CREATE-001')->firstOrFail();
        $this->assertNotNull($employee->photo);
        Storage::disk('public')->assertExists($employee->photo);
    }

    /**
     * @return array{Organization, OrganizationalUnit}
     */
    private function createOrganizationAndUnit(): array
    {
        $organization = Organization::create([
            'name' => 'North Organization',
            'slug' => 'north-organization',
            'code' => 'NORTH',
            'type' => 'organization',
            'status' => 'active',
            'default_locale' => 'en',
        ]);

        $unit = OrganizationalUnit::create([
            'organization_id' => $organization->id,
            'name' => 'Operations',
            'code' => 'OPS',
            'type' => 'department',
            'status' => 'active',
        ]);

        return [$organization, $unit];
    }
}
