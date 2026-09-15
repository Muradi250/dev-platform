<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class FooterVisibility
{
    public static function schema(): array
    {
        return [
            Section::make('Footer Visibility')
                ->description('Control where the footer is visible.')
                ->schema([
                    Toggle::make('settings.footer.visibility.desktop')
                        ->label('Show on Desktop')
                        ->default(true),

                    Toggle::make('settings.footer.visibility.tablet')
                        ->label('Show on Tablet')
                        ->default(true),

                    Toggle::make('settings.footer.visibility.mobile')
                        ->label('Show on Mobile')
                        ->default(true),

                    Toggle::make('settings.footer.visibility.homepage')
                        ->label('Show on Homepage')
                        ->default(true),

                    Toggle::make('settings.footer.visibility.inner_pages')
                        ->label('Show on Inner Pages')
                        ->default(true),
                ])
                ->columns(2),
        ];
    }
}
