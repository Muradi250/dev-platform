<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class SidebarVisibility
{
    public static function schema(): array
    {
        return [

            Section::make('Sidebar Visibility')
                ->icon('heroicon-o-eye')
                ->description(
                    'Control the responsive visibility, display mode, and conditional rendering of the sidebar across different devices and page states.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | DEVICE VISIBILITY
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Device Visibility')
                        ->icon('heroicon-o-computer-desktop')
                        ->description(
                            'Choose which device sizes should display the sidebar.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.show_on_desktop')
                                ->label('Show on Desktop')
                                ->helperText(
                                    'Display the sidebar on desktop and large-screen devices.'
                                )
                                ->default(true),

                            Toggle::make('settings.sidebar.show_on_tablet')
                                ->label('Show on Tablet')
                                ->helperText(
                                    'Display the sidebar on tablet-sized devices.'
                                )
                                ->default(true),

                            Toggle::make('settings.sidebar.show_on_mobile')
                                ->label('Show on Mobile')
                                ->helperText(
                                    'Allow the sidebar to be displayed on mobile devices.'
                                )
                                ->default(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | RESPONSIVE MODE
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Responsive Mode')
                        ->icon('heroicon-o-device-tablet')
                        ->description(
                            'Define how the sidebar should behave on mobile and tablet screens.'
                        )
                        ->schema([

                            Select::make('settings.sidebar.mobile_mode')
                                ->label('Mobile Display Mode')
                                ->helperText(
                                    'Choose how the sidebar is presented on mobile devices.'
                                )
                                ->options([
                                    'drawer' => 'Slide-in Drawer',
                                    'static' => 'Static Sidebar',
                                    'hidden' => 'Hidden',
                                ])
                                ->default('drawer')
                                ->native(false)
                                ->required(),

                            Select::make('settings.sidebar.tablet_mode')
                                ->label('Tablet Display Mode')
                                ->helperText(
                                    'Choose how the sidebar is presented on tablet devices.'
                                )
                                ->options([
                                    'static' => 'Static Sidebar',
                                    'drawer' => 'Slide-in Drawer',
                                    'hidden' => 'Hidden',
                                ])
                                ->default('static')
                                ->native(false)
                                ->required(),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | CONDITIONAL VISIBILITY
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Conditional Visibility')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->description(
                            'Automatically control sidebar visibility based on its content and the current output mode.'
                        )
                        ->schema([

                            Toggle::make('settings.sidebar.hide_when_empty')
                                ->label('Hide When Empty')
                                ->helperText(
                                    'Automatically hide the sidebar when there are no active navigation items.'
                                )
                                ->default(true),

                            Toggle::make('settings.sidebar.hide_on_print')
                                ->label('Hide When Printing')
                                ->helperText(
                                    'Remove the sidebar from printed versions of the page.'
                                )
                                ->default(true),

                        ])
                        ->columns(2)
                        ->collapsible(),

                ])
                ->collapsible(),

        ];
    }
}
