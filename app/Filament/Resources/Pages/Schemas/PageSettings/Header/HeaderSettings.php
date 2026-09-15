<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

class HeaderSettings
{
    public static function schema(): array
    {
        return array_merge(
            HeaderCoreSettings::schema(),
            HeaderAppearance::schema(),
            HeaderBehavior::schema(),
            HeaderVisibility::schema(),
            HeaderItems::schema(),
            HeaderActionsSettings::schema(),
        );
    }
}