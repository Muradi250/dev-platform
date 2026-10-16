<?php

namespace App\Filament\Widgets;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\Widget;
use UnitEnum;

class DashboardModuleCards extends Widget
{
    protected string $view = 'filament.widgets.dashboard-module-cards';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $panel = Filament::getCurrentPanel();

        if (! $panel) {
            return ['groups' => []];
        }

        $components = [];

        foreach ($panel->getResources() as $resource) {
            $components[] = [
                'class' => $resource,
                'type' => 'resource',
            ];
        }

        foreach ($panel->getPages() as $page) {
            if (is_a($page, BaseDashboard::class, true)) {
                continue;
            }

            $components[] = [
                'class' => $page,
                'type' => 'page',
            ];
        }

        $groups = [];

        foreach ($components as $component) {
            $class = $component['class'];
            $type = $component['type'];

            if (! is_string($class) || ! class_exists($class)) {
                continue;
            }

            if (! method_exists($class, 'shouldRegisterNavigation')) {
                continue;
            }

            if (! $class::shouldRegisterNavigation()) {
                continue;
            }

            if ($type === 'resource') {
                if (! method_exists($class, 'canViewAny')) {
                    continue;
                }

                if (! $class::canViewAny()) {
                    continue;
                }
            }

            if (
                $type === 'page'
                && method_exists($class, 'canAccess')
                && ! $class::canAccess()
            ) {
                continue;
            }

            $navigationGroup = $class::getNavigationGroup();

            if ($navigationGroup instanceof BackedEnum) {
                $groupLabel = (string) $navigationGroup->value;
            } elseif ($navigationGroup instanceof UnitEnum) {
                $groupLabel = $navigationGroup->name;
            } elseif (is_string($navigationGroup)) {
                $groupLabel = trim($navigationGroup);
            } else {
                $groupLabel = '';
            }

            if ($groupLabel === '') {
                $groupLabel = 'General';
            }

            $label = $class::getNavigationLabel();

            $label = filled($label)
                ? (string) $label
                : class_basename($class);

            $url = $class::getUrl();

            if (! is_string($url) || $url === '') {
                continue;
            }

            $icon = $class::getNavigationIcon();

            $groups[$groupLabel][] = [
                'label' => $label,
                'url' => $url,
                'icon' => $icon ?: 'heroicon-o-squares-2x2',
                'type' => $type,
            ];
        }

        ksort($groups, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($groups as &$items) {
            usort(
                $items,
                static fn (array $a, array $b): int => strcasecmp(
                    (string) $a['label'],
                    (string) $b['label']
                )
            );
        }

        unset($items);

        return [
            'groups' => $groups,
        ];
    }
}
