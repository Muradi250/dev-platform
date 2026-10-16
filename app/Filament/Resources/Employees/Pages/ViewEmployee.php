<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Concerns\StreamsProfilePdf;
use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewEmployee extends ViewRecord
{
    use StreamsProfilePdf;

    protected static string $resource = EmployeeResource::class;

    protected string $view = 'filament.resources.employees.pages.employee-profile';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getViewData(): array
    {
        /** @var Employee $employee */
        $employee = $this->getRecord()->load([
            'organization',
            'organizationalUnit',
            'user',
        ]);
        $organizationLogoUrl = filled($employee->organization?->logo)
            && Storage::disk('public')->exists($employee->organization->logo)
                ? Storage::disk('public')->url($employee->organization->logo)
                : null;

        return [
            'employee' => $employee,
            'organizationLogoUrl' => $organizationLogoUrl,
            'editUrl' => $this->getResourceUrl('edit'),
            'issuedAt' => now(),
        ];
    }

    public function downloadPdf(): StreamedResponse
    {
        $employee = $this->getRecord();
        return $this->streamProfilePdf(
            $this->view,
            $this->getViewData(),
            "employee-profile-{$employee->getKey()}.pdf",
        );
    }
}
