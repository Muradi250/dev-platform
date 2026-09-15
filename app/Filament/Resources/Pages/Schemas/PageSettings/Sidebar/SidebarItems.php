<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class SidebarItems
{
    public static function schema(): array
    {
        return [

            Section::make('Sidebar Navigation')
                ->icon('heroicon-o-bars-3')
                ->description(
                    'Build and manage the sidebar navigation structure. Add links, icons, badges, and control how each item behaves.'
                )
                ->schema([

                    Repeater::make('settings.sidebar.items')
                        ->label('Navigation Items')
                        ->helperText(
                            'Create, reorder, duplicate, or disable navigation items. The order here determines the order displayed on the public sidebar.'
                        )
                        ->schema([

                            /*
                            |--------------------------------------------------------------------------
                            | BASIC INFORMATION
                            |--------------------------------------------------------------------------
                            */

                            Section::make('Item Information')
                                ->icon('heroicon-o-link')
                                ->description(
                                    'Define the label, destination, and visual icon for this navigation item.'
                                )
                                ->schema([

                                    TextInput::make('label')
                                        ->label('Item Label')
                                        ->placeholder('Example: Dashboard')
                                        ->helperText(
                                            'The text displayed to visitors in the sidebar.'
                                        )
                                        ->required()
                                        ->maxLength(100),

                                    TextInput::make('url')
                                        ->label('Destination URL')
                                        ->placeholder('/dashboard')
                                        ->helperText(
                                            'Enter an internal path, full URL, or page anchor such as #contact.'
                                        )
                                        ->required()
                                        ->maxLength(500)
                                        ->default('#'),

                                    Select::make('icon')
                                        ->label('Navigation Icon')
                                        ->helperText(
                                            'Select the icon that represents this navigation item.'
                                        )
                                        ->options([
                                            'home' => 'Home',
                                            'dashboard' => 'Dashboard',
                                            'user' => 'User',
                                            'users' => 'Users',
                                            'profile' => 'Profile',
                                            'settings' => 'Settings',
                                            'document' => 'Document',
                                            'folder' => 'Folder',
                                            'calendar' => 'Calendar',
                                            'clock' => 'Clock',
                                            'mail' => 'Email',
                                            'bell' => 'Notifications',
                                            'search' => 'Search',
                                            'chart' => 'Analytics',
                                            'briefcase' => 'Briefcase',
                                            'book' => 'Book',
                                            'lock' => 'Lock',
                                            'help' => 'Help',
                                            'info' => 'Information',
                                            'star' => 'Star',
                                            'heart' => 'Heart',
                                            'arrow' => 'Arrow',
                                        ])
                                        ->searchable()
                                        ->native(false)
                                        ->default('arrow'),

                                ])
                                ->columns(2)
                                ->collapsible(),

                            /*
                            |--------------------------------------------------------------------------
                            | ITEM BEHAVIOR
                            |--------------------------------------------------------------------------
                            */

                            Section::make('Item Behavior')
                                ->icon('heroicon-o-cursor-arrow-rays')
                                ->description(
                                    'Control visibility and link behavior for this navigation item.'
                                )
                                ->schema([

                                    Toggle::make('active')
                                        ->label('Active')
                                        ->helperText(
                                            'Show this navigation item on the public sidebar.'
                                        )
                                        ->default(true),

                                    Toggle::make('new_tab')
                                        ->label('Open in New Tab')
                                        ->helperText(
                                            'Open the destination in a new browser tab when selected.'
                                        )
                                        ->default(false),

                                ])
                                ->columns(2)
                                ->collapsible(),

                            /*
                            |--------------------------------------------------------------------------
                            | BADGE
                            |--------------------------------------------------------------------------
                            */

                            Section::make('Badge')
                                ->icon('heroicon-o-tag')
                                ->description(
                                    'Optionally display a small status or notification badge beside this navigation item.'
                                )
                                ->schema([

                                    Toggle::make('badge_enabled')
                                        ->label('Enable Badge')
                                        ->helperText(
                                            'Display a badge beside the navigation item.'
                                        )
                                        ->default(false)
                                        ->live(),

                                    TextInput::make('badge')
                                        ->label('Badge Text')
                                        ->placeholder('New')
                                        ->helperText(
                                            'Short text such as New, 3, Beta, or Updated.'
                                        )
                                        ->maxLength(30)
                                        ->visible(
                                            fn ($get): bool =>
                                                (bool) $get('badge_enabled')
                                        ),

                                    Select::make('badge_style')
                                        ->label('Badge Style')
                                        ->helperText(
                                            'Choose the visual status style of the badge.'
                                        )
                                        ->options([
                                            'default' => 'Default',
                                            'success' => 'Success',
                                            'warning' => 'Warning',
                                            'danger' => 'Danger',
                                            'info' => 'Information',
                                        ])
                                        ->default('default')
                                        ->native(false)
                                        ->visible(
                                            fn ($get): bool =>
                                                (bool) $get('badge_enabled')
                                        ),

                                ])
                                ->columns(2)
                                ->collapsible(),

                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Add Sidebar Item')
                        ->columns(1)
                        ->collapsible()
                        ->cloneable()
                        ->reorderable()
                        ->itemLabel(
                            fn (array $state): ?string =>
                                $state['label'] ?? 'Sidebar Item'
                        ),

                ])
                ->columns(1)
                ->collapsible(),

        ];
    }
}
