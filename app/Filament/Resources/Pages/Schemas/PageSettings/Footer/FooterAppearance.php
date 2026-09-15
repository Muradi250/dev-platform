<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class FooterAppearance
{
    public static function schema(): array
    {
        return [
            Section::make('Footer Appearance')
                ->description('Customize the visual appearance and layout of the footer.')
                ->schema([
                    Select::make('settings.footer.appearance.layout')
                        ->label('Footer Layout')
                        ->options([
                            'full' => 'Full Width',
                            'container' => 'Container',
                        ])
                        ->default('container')
                        ->native(false),

                    Select::make('settings.footer.appearance.alignment')
                        ->label('Content Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                        ])
                        ->default('left')
                        ->native(false),

                    ColorPicker::make('settings.footer.appearance.background_color')
                        ->label('Background Color')
                        ->default('#111827'),

                    ColorPicker::make('settings.footer.appearance.text_color')
                        ->label('Text Color')
                        ->default('#D1D5DB'),

                    ColorPicker::make('settings.footer.appearance.heading_color')
                        ->label('Heading Color')
                        ->default('#FFFFFF'),

                    ColorPicker::make('settings.footer.appearance.link_color')
                        ->label('Link Color')
                        ->default('#D1D5DB'),

                    ColorPicker::make('settings.footer.appearance.link_hover_color')
                        ->label('Link Hover Color')
                        ->default('#FFFFFF'),

                    Select::make('settings.footer.appearance.border_style')
                        ->label('Top Border')
                        ->options([
                            'none' => 'None',
                            'solid' => 'Solid',
                            'dashed' => 'Dashed',
                            'dotted' => 'Dotted',
                        ])
                        ->default('none')
                        ->native(false),

                    ColorPicker::make('settings.footer.appearance.border_color')
                        ->label('Border Color')
                        ->default('#374151'),

                    TextInput::make('settings.footer.appearance.padding_top')
                        ->label('Padding Top')
                        ->placeholder('40px')
                        ->maxLength(20),

                    TextInput::make('settings.footer.appearance.padding_bottom')
                        ->label('Padding Bottom')
                        ->placeholder('40px')
                        ->maxLength(20),

                    TextInput::make('settings.footer.appearance.custom_class')
                        ->label('Custom CSS Class')
                        ->placeholder('my-footer')
                        ->maxLength(100),
                ])
                ->columns(2),
        ];
    }
}
