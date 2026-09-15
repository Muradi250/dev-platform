<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class Backgrounds
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | PAGE BACKGROUND
            |--------------------------------------------------------------------------
            */

            Section::make('Page Background')
                ->description(
                    'Define the main background of the public page.'
                )
                ->icon('heroicon-o-rectangle-stack')
                ->schema([

                    ColorPicker::make('settings.theme.backgrounds.page')
                        ->label('Page Background')
                        ->helperText(
                            'The primary background behind the entire page.'
                        )
                        ->default('#f8fafc')
                        ->hexColor(),

                ])
                ->columns(1),


            /*
            |--------------------------------------------------------------------------
            | CONTENT BACKGROUNDS
            |--------------------------------------------------------------------------
            */

            Section::make('Content Backgrounds')
                ->description(
                    'Control the backgrounds used by the main content and surface areas.'
                )
                ->icon('heroicon-o-squares-2x2')
                ->schema([

                    ColorPicker::make('settings.theme.backgrounds.content')
                        ->label('Content Background')
                        ->helperText(
                            'The background of the main content area.'
                        )
                        ->default('#ffffff')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.backgrounds.surface')
                        ->label('Surface Background')
                        ->helperText(
                            'Used for elevated surfaces such as cards and panels.'
                        )
                        ->default('#ffffff')
                        ->hexColor(),

                ])
                ->columns(2),


            /*
            |--------------------------------------------------------------------------
            | HEADER & FOOTER
            |--------------------------------------------------------------------------
            */

            Section::make('Header & Footer Backgrounds')
                ->description(
                    'Define independent background colors for the header and footer.'
                )
                ->icon('heroicon-o-window')
                ->schema([

                    ColorPicker::make('settings.theme.backgrounds.header')
                        ->label('Header Background')
                        ->helperText(
                            'Background used by the public header.'
                        )
                        ->default('#ffffff')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.backgrounds.footer')
                        ->label('Footer Background')
                        ->helperText(
                            'Background used by the public footer.'
                        )
                        ->default('#0f172a')
                        ->hexColor(),

                ])
                ->columns(2),

        ];
    }
}