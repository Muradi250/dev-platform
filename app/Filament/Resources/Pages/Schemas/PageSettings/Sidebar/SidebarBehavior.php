<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class SidebarBehavior
{
    public static function schema(): array
    {
        return [

            Section::make('Sidebar Behavior')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->description(
                    'Configure how the sidebar moves, responds to user interaction, and behaves across different navigation states.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | ANIMATION
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Animation')
                        ->icon('heroicon-o-arrow-path')
                        ->description(
                            'Control sidebar transition effects and animation timing.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.animation')
                                ->label('Enable Animation')
                                ->helperText(
                                    'Animate the sidebar when it appears, disappears, opens, closes, or changes state.'
                                )
                                ->default(true)
                                ->live(),

                            Select::make('settings.sidebar.animation_type')
                                ->label('Animation Type')
                                ->helperText(
                                    'Choose the transition style used by the sidebar.'
                                )
                                ->options([
                                    'fade' => 'Fade',
                                    'slide' => 'Slide',
                                    'slide_up' => 'Slide Up',
                                    'slide_down' => 'Slide Down',
                                    'scale' => 'Scale',
                                ])
                                ->default('slide')
                                ->native(false)
                                ->visible(
                                    fn ($get): bool =>
                                        (bool) $get('settings.sidebar.animation')
                                ),

                            TextInput::make('settings.sidebar.animation_duration')
                                ->label('Animation Duration')
                                ->helperText(
                                    'CSS transition duration. Example: 200ms, 300ms or 500ms.'
                                )
                                ->default('300ms')
                                ->maxLength(20)
                                ->visible(
                                    fn ($get): bool =>
                                        (bool) $get('settings.sidebar.animation')
                                ),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | NAVIGATION INTERACTION
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Navigation Interaction')
                        ->icon('heroicon-o-hand-raised')
                        ->description(
                            'Define how navigation items respond to hover, active states, and anchor navigation.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.active_item')
                                ->label('Highlight Active Item')
                                ->helperText(
                                    'Visually identify the navigation item associated with the current page or section.'
                                )
                                ->default(true),

                            Toggle::make('settings.sidebar.smooth_scroll')
                                ->label('Smooth Scroll')
                                ->helperText(
                                    'Use smooth scrolling when sidebar links point to sections on the current page.'
                                )
                                ->default(true),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | MOBILE DRAWER
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Mobile Drawer')
                        ->icon('heroicon-o-device-phone-mobile')
                        ->description(
                            'Configure the sidebar experience on mobile devices.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.mobile_drawer')
                                ->label('Enable Mobile Drawer')
                                ->helperText(
                                    'Display the sidebar as a slide-in drawer on mobile screens.'
                                )
                                ->default(true)
                                ->live(),

                            Toggle::make('settings.sidebar.mobile_overlay')
                                ->label('Show Mobile Overlay')
                                ->helperText(
                                    'Display a backdrop overlay behind the mobile sidebar when it is open.'
                                )
                                ->default(true)
                                ->live(),

                            Toggle::make('settings.sidebar.close_on_navigation')
                                ->label('Close After Navigation')
                                ->helperText(
                                    'Automatically close the mobile sidebar after the visitor selects a navigation item.'
                                )
                                ->default(true),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | STATE MANAGEMENT
                    |--------------------------------------------------------------------------
                    */

                    Section::make('State Management')
                        ->icon('heroicon-o-circle-stack')
                        ->description(
                            'Control whether the sidebar remembers interaction state between visits.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.remember_state')
                                ->label('Remember Collapsed State')
                                ->helperText(
                                    'Remember whether the visitor collapsed or expanded the sidebar for future visits.'
                                )
                                ->default(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                ])
                ->collapsible(),

        ];
    }
}
