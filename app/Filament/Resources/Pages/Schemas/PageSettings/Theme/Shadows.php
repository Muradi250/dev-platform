<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class Shadows
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | GLOBAL SHADOW
            |--------------------------------------------------------------------------
            */

            Section::make('Global Shadow')
                ->description(
                    'Define the default shadow intensity used by general elevated elements.'
                )
                ->icon('heroicon-o-sparkles')
                ->schema([

                    Select::make('settings.theme.shadows.default')
                        ->label('Default Shadow')
                        ->helperText(
                            'Base shadow applied to elements that do not have a specific shadow setting.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                            '2xl' => '2XL',
                        ])
                        ->default('md')
                        ->native(false),

                ])
                ->columns(1),


            /*
            |--------------------------------------------------------------------------
            | COMPONENT SHADOWS
            |--------------------------------------------------------------------------
            */

            Section::make('Component Shadows')
                ->description(
                    'Control the shadow intensity of common interface components.'
                )
                ->icon('heroicon-o-cube')
                ->schema([

                    Select::make('settings.theme.shadows.card')
                        ->label('Card Shadow')
                        ->helperText(
                            'Shadow applied to cards, panels, and content surfaces.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                            '2xl' => '2XL',
                        ])
                        ->default('sm')
                        ->native(false),

                    Select::make('settings.theme.shadows.button')
                        ->label('Button Shadow')
                        ->helperText(
                            'Shadow applied to primary and interactive buttons.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                        ])
                        ->default('none')
                        ->native(false),

                    Select::make('settings.theme.shadows.dropdown')
                        ->label('Dropdown Shadow')
                        ->helperText(
                            'Shadow applied to dropdown menus and floating navigation elements.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                            '2xl' => '2XL',
                        ])
                        ->default('lg')
                        ->native(false),

                    Select::make('settings.theme.shadows.modal')
                        ->label('Modal Shadow')
                        ->helperText(
                            'Shadow applied to modal dialogs and large floating surfaces.'
                        )
                        ->options([
                            'none' => 'None',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                            '2xl' => '2XL',
                        ])
                        ->default('2xl')
                        ->native(false),

                ])
                ->columns(2),


            /*
            |--------------------------------------------------------------------------
            | NAVIGATION & SPECIAL ELEMENTS
            |--------------------------------------------------------------------------
            */

            Section::make('Navigation & Special Elements')
                ->description(
                    'Control shadows for navigation and other prominent page elements.'
                )
                ->icon('heroicon-o-window')
                ->schema([

                    Select::make('settings.theme.shadows.header')
                        ->label('Header Shadow')
                        ->helperText(
                            'Shadow applied below the public header when elevation is enabled.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                        ])
                        ->default('sm')
                        ->native(false),

                    Select::make('settings.theme.shadows.footer')
                        ->label('Footer Shadow')
                        ->helperText(
                            'Shadow applied to the footer when it visually overlaps or separates from content.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                        ])
                        ->default('none')
                        ->native(false),

                    Select::make('settings.theme.shadows.sidebar')
                        ->label('Sidebar Shadow')
                        ->helperText(
                            'Shadow applied to the sidebar when it is visually separated from the main content.'
                        )
                        ->options([
                            'none' => 'None',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                        ])
                        ->default('md')
                        ->native(false),

                ])
                ->columns(3),

        ];
    }
}