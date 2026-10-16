<?php

namespace App\Filament\Resources\Organizations\Pages;

use App\Filament\Resources\Concerns\StreamsProfilePdf;
use App\Filament\Resources\Organizations\OrganizationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewOrganization extends ViewRecord
{
    use StreamsProfilePdf;

    protected static string $resource = OrganizationResource::class;

    protected string $view = 'filament.resources.organizations.pages.organization-profile';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getViewData(): array
    {
        /** @var Model&\App\Models\Organization $organization */
        $organization = $this->getRecord()->loadCount([
            'memberships as active_members_count' => fn ($query) => $query->where('status', 'active'),
            'organizationalUnits as organizational_units_count',
            'employees as employees_count',
        ]);

        $logoUrl = filled($organization->logo)
            && Storage::disk('public')->exists($organization->logo)
                ? Storage::disk('public')->url($organization->logo)
                : null;

        return [
            'organization' => $organization,
            'logoUrl' => $logoUrl,
            'editUrl' => $this->getResourceUrl('edit'),
            'issuedAt' => now()->timezone($organization->timezone ?: config('app.timezone')),
        ];
    }

    public function downloadPdf(): StreamedResponse
    {
        $organization = $this->getRecord();
        return $this->streamProfilePdf(
            $this->view,
            $this->getViewData(),
            "organization-profile-{$organization->getKey()}.pdf",
        );
    }
}
