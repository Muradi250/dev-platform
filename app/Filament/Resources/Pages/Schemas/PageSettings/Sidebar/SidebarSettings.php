<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class SidebarSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Sidebar Configuration')
                ->icon('heroicon-o-rectangle-group')
                ->description(
                    'Configure the sidebar structure, placement, appearance, behavior, visibility, navigation, and header.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | GENERAL
                    |--------------------------------------------------------------------------
                    */

                    Section::make('General')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->description(
                            'Define the core behavior and layout of the page sidebar.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.enabled')
                                ->label('Enable Sidebar')
                                ->helperText(
                                    'Enable the sidebar and make its navigation available on the public page.'
                                )
                                ->default(false)
                                ->live(),

                            Select::make('settings.sidebar.position')
                                ->label('Sidebar Position')
                                ->helperText(
                                    'Choose which side of the page the sidebar should appear on.'
                                )
                                ->options([
                                    'left' => 'Left',
                                    'right' => 'Right',
                                ])
                                ->default('right')
                                ->native(false)
                                ->required(),

                            Select::make('settings.sidebar.width')
                                ->label('Sidebar Width')
                                ->helperText(
                                    'Control the desktop width of the sidebar.'
                                )
                                ->options([
                                    'sm' => 'Small — 224px',
                                    'md' => 'Medium — 256px',
                                    'lg' => 'Large — 288px',
                                    'xl' => 'Extra Large — 320px',
                                ])
                                ->default('md')
                                ->native(false)
                                ->required(),

                            Toggle::make('settings.sidebar.sticky')
                                ->label('Sticky Sidebar')
                                ->helperText(
                                    'Keep the sidebar visible while the visitor scrolls through the page.'
                                )
                                ->default(false),

                            Toggle::make('settings.sidebar.collapsible')
                                ->label('Collapsible Sidebar')
                                ->helperText(
                                    'Allow visitors to collapse and expand the sidebar when supported by the selected layout.'
                                )
                                ->default(false)
                                ->live(),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | APPEARANCE
                    |--------------------------------------------------------------------------
                    */

                    ...SidebarAppearance::schema(),

                    /*
                    |--------------------------------------------------------------------------
                    | BEHAVIOR
                    |--------------------------------------------------------------------------
                    */

                    ...SidebarBehavior::schema(),

                    /*
                    |--------------------------------------------------------------------------
                    | VISIBILITY
                    |--------------------------------------------------------------------------
                    */

                    ...SidebarVisibility::schema(),

                    /*
                    |--------------------------------------------------------------------------
                    | NAVIGATION ITEMS
                    |--------------------------------------------------------------------------
                    */

                    ...SidebarItems::schema(),

                ])
                ->collapsible(),

        ];
    }
}