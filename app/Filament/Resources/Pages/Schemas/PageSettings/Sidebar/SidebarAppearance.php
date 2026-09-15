<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class SidebarAppearance
{
    public static function schema(): array
    {
        return [

            Section::make('Sidebar Appearance')
                ->icon('heroicon-o-swatch')
                ->description(
                    'Design the visual identity of the sidebar, including colors, typography, icons, navigation states, borders, spacing, and interactive effects.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | VISUAL STYLE
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Visual Style')
                        ->icon('heroicon-o-sparkles')
                        ->description(
                            'Choose the overall visual treatment and theme of the sidebar.'
                        )
                        ->schema([

                            Select::make(
                                'settings.sidebar.appearance.style'
                            )
                                ->label('Sidebar Style')
                                ->helperText(
                                    'Choose the visual style that best matches your page design.'
                                )
                                ->options([
                                    'solid' => 'Solid',
                                    'glass' => 'Glass',
                                    'transparent' => 'Transparent',
                                    'gradient' => 'Gradient',
                                ])
                                ->default('glass')
                                ->native(false)
                                ->live()
                                ->required(),

                            Select::make(
                                'settings.sidebar.appearance.theme'
                            )
                                ->label('Visual Theme')
                                ->helperText(
                                    'Select the color theme used by the sidebar.'
                                )
                                ->options([
                                    'dark' => 'Dark',
                                    'light' => 'Light',
                                    'auto' => 'Auto',
                                ])
                                ->default('dark')
                                ->native(false),

                            ColorPicker::make(
                                'settings.sidebar.appearance.background_color'
                            )
                                ->label('Background Color')
                                ->helperText(
                                    'Primary background color of the sidebar.'
                                )
                                ->default('#111827'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.background_secondary_color'
                            )
                                ->label('Secondary Background')
                                ->helperText(
                                    'Secondary color used for gradients and advanced background effects.'
                                )
                                ->default('#1E293B'),

                            TextInput::make(
                                'settings.sidebar.appearance.background_opacity'
                            )
                                ->label('Background Opacity')
                                ->helperText(
                                    'Set the background transparency from 0 to 100.'
                                )
                                ->default('88')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->maxLength(3),

                            TextInput::make(
                                'settings.sidebar.appearance.blur'
                            )
                                ->label('Glass Blur')
                                ->helperText(
                                    'Blur amount used by the Glass visual style. Example: 12px, 18px or 24px.'
                                )
                                ->default('18px')
                                ->maxLength(20),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | TYPOGRAPHY & COLORS
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Typography & Colors')
                        ->icon('heroicon-o-pencil-square')
                        ->description(
                            'Control the text hierarchy and navigation color system.'
                        )
                        ->schema([

                            ColorPicker::make(
                                'settings.sidebar.appearance.text_color'
                            )
                                ->label('Text Color')
                                ->helperText(
                                    'Default color used for sidebar navigation text.'
                                )
                                ->default('#D1D5DB'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.heading_color'
                            )
                                ->label('Heading Color')
                                ->helperText(
                                    'Color used for sidebar headings and section titles.'
                                )
                                ->default('#FFFFFF'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.muted_text_color'
                            )
                                ->label('Muted Text Color')
                                ->helperText(
                                    'Used for secondary or less prominent text.'
                                )
                                ->default('#94A3B8'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.link_color'
                            )
                                ->label('Link Color')
                                ->default('#D1D5DB'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.link_hover_color'
                            )
                                ->label('Link Hover Color')
                                ->helperText(
                                    'Text color displayed when a navigation item is hovered.'
                                )
                                ->default('#FFFFFF'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.link_hover_background'
                            )
                                ->label('Link Hover Background')
                                ->helperText(
                                    'Background color displayed when hovering over a navigation item.'
                                )
                                ->default('#FFFFFF1A'),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | ACTIVE ITEM
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Active Navigation')
                        ->icon('heroicon-o-check-circle')
                        ->description(
                            'Customize how the currently active navigation item is highlighted.'
                        )
                        ->schema([

                            ColorPicker::make(
                                'settings.sidebar.appearance.active_color'
                            )
                                ->label('Active Text Color')
                                ->default('#FFFFFF'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.active_background'
                            )
                                ->label('Active Background')
                                ->default('#4F46E5'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.active_border_color'
                            )
                                ->label('Active Border Color')
                                ->default('#6366F1'),

                            Select::make(
                                'settings.sidebar.appearance.active_indicator'
                            )
                                ->label('Active Indicator')
                                ->helperText(
                                    'Choose how the active navigation item should be visually identified.'
                                )
                                ->options([
                                    'none' => 'None',
                                    'left' => 'Left Indicator',
                                    'right' => 'Right Indicator',
                                    'border' => 'Border',
                                    'glow' => 'Glow',
                                ])
                                ->default('left')
                                ->native(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | ICONS
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Icons')
                        ->icon('heroicon-o-squares-2x2')
                        ->description(
                            'Configure the appearance and color system of sidebar navigation icons.'
                        )
                        ->schema([

                            ColorPicker::make(
                                'settings.sidebar.appearance.icon_color'
                            )
                                ->label('Icon Color')
                                ->default('#94A3B8'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.icon_background'
                            )
                                ->label('Icon Background')
                                ->default('#FFFFFF0D'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.icon_active_color'
                            )
                                ->label('Active Icon Color')
                                ->default('#FFFFFF'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.icon_active_background'
                            )
                                ->label('Active Icon Background')
                                ->default('#4F46E5'),

                            Select::make(
                                'settings.sidebar.appearance.icon_style'
                            )
                                ->label('Icon Style')
                                ->helperText(
                                    'Choose the visual treatment applied to sidebar icons.'
                                )
                                ->options([
                                    'soft' => 'Soft',
                                    'filled' => 'Filled',
                                    'minimal' => 'Minimal',
                                    'glass' => 'Glass',
                                ])
                                ->default('soft')
                                ->native(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | BADGES
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Badges')
                        ->icon('heroicon-o-tag')
                        ->description(
                            'Customize notification and status badges displayed beside navigation items.'
                        )
                        ->schema([

                            ColorPicker::make(
                                'settings.sidebar.appearance.badge_background'
                            )
                                ->label('Badge Background')
                                ->default('#4F46E5'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.badge_text_color'
                            )
                                ->label('Badge Text Color')
                                ->default('#FFFFFF'),

                            Select::make(
                                'settings.sidebar.appearance.badge_style'
                            )
                                ->label('Badge Style')
                                ->options([
                                    'solid' => 'Solid',
                                    'soft' => 'Soft',
                                    'outline' => 'Outline',
                                    'glass' => 'Glass',
                                ])
                                ->default('soft')
                                ->native(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | BORDERS & SHAPE
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Borders & Shape')
                        ->icon('heroicon-o-square-3-stack-3d')
                        ->description(
                            'Define borders, corner radius, and depth for the sidebar container.'
                        )
                        ->schema([

                            ColorPicker::make(
                                'settings.sidebar.appearance.border_color'
                            )
                                ->label('Border Color')
                                ->default('#374151'),

                            Select::make(
                                'settings.sidebar.appearance.border_style'
                            )
                                ->label('Border Style')
                                ->options([
                                    'none' => 'None',
                                    'solid' => 'Solid',
                                    'dashed' => 'Dashed',
                                    'dotted' => 'Dotted',
                                ])
                                ->default('solid')
                                ->native(false),

                            TextInput::make(
                                'settings.sidebar.appearance.border_width'
                            )
                                ->label('Border Width')
                                ->helperText(
                                    'Example: 1px or 2px.'
                                )
                                ->default('1px')
                                ->maxLength(20),

                            Select::make(
                                'settings.sidebar.appearance.border_radius'
                            )
                                ->label('Border Radius')
                                ->options([
                                    'none' => 'None',
                                    'sm' => 'Small',
                                    'md' => 'Medium',
                                    'lg' => 'Large',
                                    'xl' => 'Extra Large',
                                    '2xl' => '2XL',
                                    '3xl' => '3XL',
                                ])
                                ->default('2xl')
                                ->native(false),

                            Select::make(
                                'settings.sidebar.appearance.shadow'
                            )
                                ->label('Shadow')
                                ->options([
                                    'none' => 'None',
                                    'sm' => 'Small',
                                    'md' => 'Medium',
                                    'lg' => 'Large',
                                    'xl' => 'Extra Large',
                                    '2xl' => '2XL',
                                ])
                                ->default('xl')
                                ->native(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | SPACING
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Spacing & Layout')
                        ->icon('heroicon-o-arrows-pointing-out')
                        ->description(
                            'Fine-tune the internal spacing and shape of sidebar navigation items.'
                        )
                        ->schema([

                            TextInput::make(
                                'settings.sidebar.appearance.padding'
                            )
                                ->label('Inner Padding')
                                ->helperText(
                                    'Space between the sidebar edges and its content. Example: 16px, 20px or 24px.'
                                )
                                ->default('20px')
                                ->maxLength(50),

                            TextInput::make(
                                'settings.sidebar.appearance.item_gap'
                            )
                                ->label('Navigation Item Gap')
                                ->helperText(
                                    'Space between navigation items. Example: 6px or 8px.'
                                )
                                ->default('6px')
                                ->maxLength(20),

                            TextInput::make(
                                'settings.sidebar.appearance.item_radius'
                            )
                                ->label('Navigation Item Radius')
                                ->helperText(
                                    'Corner radius applied to individual navigation items. Example: 10px or 12px.'
                                )
                                ->default('12px')
                                ->maxLength(20),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | INTERACTION & EFFECTS
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Interaction & Effects')
                        ->icon('heroicon-o-bolt')
                        ->description(
                            'Control hover behavior, visual effects, and icon animations.'
                        )
                        ->schema([

                            Toggle::make(
                                'settings.sidebar.appearance.hover_effect'
                            )
                                ->label('Enable Hover Effect')
                                ->helperText(
                                    'Add a subtle visual response when visitors hover over navigation items.'
                                )
                                ->default(true),

                            Toggle::make(
                                'settings.sidebar.appearance.glow_effect'
                            )
                                ->label('Enable Glow Effect')
                                ->helperText(
                                    'Add a soft glow to active sidebar elements.'
                                )
                                ->default(false),

                            Toggle::make(
                                'settings.sidebar.appearance.icon_animation'
                            )
                                ->label('Animate Icons')
                                ->helperText(
                                    'Enable subtle icon animation during navigation interaction.'
                                )
                                ->default(false),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | HEADER
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Sidebar Header')
                        ->icon('heroicon-o-window')
                        ->description(
                            'Configure the dedicated header area displayed above sidebar navigation.'
                        )
                        ->schema([

                            Toggle::make(
                                'settings.sidebar.appearance.show_header'
                            )
                                ->label('Show Sidebar Header')
                                ->helperText(
                                    'Display a dedicated header area above the navigation items.'
                                )
                                ->default(true)
                                ->live(),

                            ColorPicker::make(
                                'settings.sidebar.appearance.header_background'
                            )
                                ->label('Header Background')
                                ->default('#FFFFFF08'),

                            ColorPicker::make(
                                'settings.sidebar.appearance.header_border_color'
                            )
                                ->label('Header Border Color')
                                ->default('#FFFFFF12'),

                        ])
                        ->columns(2)
                        ->collapsible(),

                    /*
                    |--------------------------------------------------------------------------
                    | ADVANCED
                    |--------------------------------------------------------------------------
                    */

                    Section::make('Advanced Styling')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->description(
                            'Advanced options for glass effects and custom CSS integration.'
                        )
                        ->schema([

                            Toggle::make(
                                'settings.sidebar.appearance.use_backdrop_filter'
                            )
                                ->label('Enable Backdrop Filter')
                                ->helperText(
                                    'Enable backdrop blur and filtering effects. Recommended for the Glass style.'
                                )
                                ->default(true),

                            TextInput::make(
                                'settings.sidebar.appearance.custom_class'
                            )
                                ->label('Custom CSS Class')
                                ->helperText(
                                    'Optional CSS class for advanced custom styling. Do not include the dot (.) prefix.'
                                )
                                ->maxLength(200),

                        ])
                        ->columns(2)
                        ->collapsible(),

                ])
                ->collapsible(),

        ];
    }
}
