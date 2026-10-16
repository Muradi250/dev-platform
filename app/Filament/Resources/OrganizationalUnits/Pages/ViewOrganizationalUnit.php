<?php

namespace App\Filament\Resources\OrganizationalUnits\Pages;

use App\Filament\Resources\Concerns\StreamsProfilePdf;
use App\Filament\Resources\OrganizationalUnits\OrganizationalUnitResource;
use App\Models\OrganizationalUnit;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewOrganizationalUnit extends ViewRecord
{
    use StreamsProfilePdf;

    protected static string $resource = OrganizationalUnitResource::class;

    protected string $view = 'filament.resources.organizational-units.pages.organizational-unit-profile';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getViewData(): array
    {
        /** @var OrganizationalUnit $unit */
        $unit = $this->getRecord()->load([
            'organization',
            'parent',
            'children' => fn ($query) => $query->orderBy('name'),
            'employees' => fn ($query) => $query->orderBy('first_name')->orderBy('last_name')->limit(10),
        ])->loadCount([
            'children',
            'employees',
            'employees as active_employees_count' => fn ($query) => $query->where('status', 'active'),
        ]);

        $organizationLogoUrl = filled($unit->organization?->logo)
            && Storage::disk('public')->exists($unit->organization->logo)
                ? Storage::disk('public')->url($unit->organization->logo)
                : null;

        $ancestors = [];
        $parent = $unit->parent;
        $visitedIds = [$unit->getKey() => true];

        while ($parent && ! isset($visitedIds[$parent->getKey()])) {
            $visitedIds[$parent->getKey()] = true;
            $ancestors[] = $parent;
            $parent = $parent->parent;
        }

        return [
            'unit' => $unit,
            'ancestors' => array_reverse($ancestors),
            'organizationLogoUrl' => $organizationLogoUrl,
            'editUrl' => $this->getResourceUrl('edit'),
            'issuedAt' => now()->timezone(
                $unit->organization?->timezone ?: config('app.timezone')
            ),
        ];
    }

    public function downloadPdf(): StreamedResponse
    {
        $unit = $this->getRecord();
        return $this->streamProfilePdf(
            $this->view,
            $this->getViewData(),
            "organizational-unit-profile-{$unit->getKey()}.pdf",
        );
    }
}
