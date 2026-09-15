<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class Typography
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | FONT FAMILIES
            |--------------------------------------------------------------------------
            */

            Section::make('Font Families')
                ->description(
                    'Define the primary and heading fonts used across the public page.'
                )
                ->icon('heroicon-o-language')
                ->schema([

                    Select::make('settings.theme.typography.font_family')
                        ->label('Body Font')
                        ->helperText(
                            'Primary font used for paragraphs, navigation, labels, and general page content.'
                        )
                        ->options([
                            'Inter' => 'Inter',
                            'Arial' => 'Arial',
                            'Helvetica' => 'Helvetica',
                            'system-ui' => 'System UI',
                            'Tahoma' => 'Tahoma',
                            'Verdana' => 'Verdana',
                            'Georgia' => 'Georgia',
                        ])
                        ->placeholder('Use default font')
                        ->native(false),

                    Select::make('settings.theme.typography.heading_font')
                        ->label('Heading Font')
                        ->helperText(
                            'Font used for page titles, headings, and prominent text.'
                        )
                        ->options([
                            'Inter' => 'Inter',
                            'Arial' => 'Arial',
                            'Helvetica' => 'Helvetica',
                            'system-ui' => 'System UI',
                            'Tahoma' => 'Tahoma',
                            'Verdana' => 'Verdana',
                            'Georgia' => 'Georgia',
                        ])
                        ->placeholder('Use body font')
                        ->native(false),

                ])
                ->columns(2),


            /*
            |--------------------------------------------------------------------------
            | BASE TYPOGRAPHY
            |--------------------------------------------------------------------------
            */

            Section::make('Base Typography')
                ->description(
                    'Control the general size, weight, and readability of page text.'
                )
                ->icon('heroicon-o-document-text')
                ->schema([

                    Select::make('settings.theme.typography.base_font_size')
                        ->label('Base Font Size')
                        ->helperText(
                            'Default font size used as the foundation for page typography.'
                        )
                        ->options([
                            '14px' => 'Small — 14px',
                            '15px' => 'Compact — 15px',
                            '16px' => 'Default — 16px',
                            '17px' => 'Comfortable — 17px',
                            '18px' => 'Large — 18px',
                        ])
                        ->default('16px')
                        ->native(false),

                    Select::make('settings.theme.typography.body_weight')
                        ->label('Body Font Weight')
                        ->helperText(
                            'Default font weight used for normal page content.'
                        )
                        ->options([
                            '300' => 'Light',
                            '400' => 'Regular',
                            '500' => 'Medium',
                            '600' => 'Semibold',
                        ])
                        ->default('400')
                        ->native(false),

                    Select::make('settings.theme.typography.line_height')
                        ->label('Body Line Height')
                        ->helperText(
                            'Controls vertical spacing between lines of body text.'
                        )
                        ->options([
                            '1.25' => 'Tight',
                            '1.375' => 'Compact',
                            '1.5' => 'Normal',
                            '1.625' => 'Relaxed',
                            '1.75' => 'Comfortable',
                            '2' => 'Loose',
                        ])
                        ->default('1.625')
                        ->native(false),

                    Select::make('settings.theme.typography.letter_spacing')
                        ->label('Letter Spacing')
                        ->helperText(
                            'Controls the spacing between individual characters.'
                        )
                        ->options([
                            '-0.025em' => 'Tight',
                            '0' => 'Normal',
                            '0.025em' => 'Slight',
                            '0.05em' => 'Wide',
                            '0.075em' => 'Extra Wide',
                        ])
                        ->default('0')
                        ->native(false),

                ])
                ->columns(2),


            /*
            |--------------------------------------------------------------------------
            | HEADING TYPOGRAPHY
            |--------------------------------------------------------------------------
            */

            Section::make('Heading Typography')
                ->description(
                    'Control the visual weight and spacing of headings throughout the page.'
                )
                ->icon('heroicon-o-bars-3-bottom-left')
                ->schema([

                    Select::make('settings.theme.typography.heading_weight')
                        ->label('Heading Font Weight')
                        ->helperText(
                            'Default weight applied to page headings and titles.'
                        )
                        ->options([
                            '400' => 'Regular',
                            '500' => 'Medium',
                            '600' => 'Semibold',
                            '700' => 'Bold',
                            '800' => 'Extra Bold',
                            '900' => 'Black',
                        ])
                        ->default('700')
                        ->native(false),

                    Select::make('settings.theme.typography.heading_line_height')
                        ->label('Heading Line Height')
                        ->helperText(
                            'Controls vertical spacing between heading lines.'
                        )
                        ->options([
                            '1' => 'Tight',
                            '1.1' => 'Compact',
                            '1.2' => 'Normal',
                            '1.25' => 'Relaxed',
                            '1.375' => 'Comfortable',
                        ])
                        ->default('1.2')
                        ->native(false),

                    Select::make('settings.theme.typography.heading_letter_spacing')
                        ->label('Heading Letter Spacing')
                        ->helperText(
                            'Controls character spacing across headings.'
                        )
                        ->options([
                            '-0.05em' => 'Very Tight',
                            '-0.025em' => 'Tight',
                            '0' => 'Normal',
                            '0.025em' => 'Slight',
                            '0.05em' => 'Wide',
                        ])
                        ->default('-0.025em')
                        ->native(false),

                ])
                ->columns(3),

        ];
    }
}