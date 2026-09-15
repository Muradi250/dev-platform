<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class CtaBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([
            Section::make('CTA Content')
                ->description('Define the main message and content of your call to action.')
                ->schema([
                    TextInput::make('data.eyebrow')
                        ->label('Eyebrow')
                        ->placeholder('Ready to Get Started?')
                        ->maxLength(100)
                        ->columnSpanFull(),

                    TextInput::make('data.title')
                        ->label('CTA Title')
                        ->placeholder('Take Your Business to the Next Level')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('data.description')
                        ->label('Description')
                        ->placeholder('Start managing your organization with a powerful and flexible business platform.')
                        ->rows(4)
                        ->maxLength(1000)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Primary Action')
                ->description('Configure the main CTA button.')
                ->schema([
                    Toggle::make('data.show_primary_button')
                        ->label('Show Primary Button')
                        ->default(true)
                        ->inline(false)
                        ->columnSpanFull(),

                    TextInput::make('data.button_text')
                        ->label('Button Text')
                        ->placeholder('Get Started')
                        ->maxLength(100),

                    TextInput::make('data.button_url')
                        ->label('Button URL')
                        ->placeholder('/register')
                        ->maxLength(500),

                    TextInput::make('data.button_icon')
                        ->label('Button Icon')
                        ->placeholder('arrow-right')
                        ->maxLength(50)
                        ->helperText('Optional icon name.'),

                    Toggle::make('data.button_new_tab')
                        ->label('Open in New Tab')
                        ->default(false)
                        ->inline(false),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Secondary Action')
                ->description('Optional secondary action displayed beside the primary button.')
                ->schema([
                    Toggle::make('data.show_secondary_button')
                        ->label('Show Secondary Button')
                        ->default(false)
                        ->inline(false)
                        ->columnSpanFull(),

                    TextInput::make('data.secondary_button_text')
                        ->label('Secondary Button Text')
                        ->placeholder('Explore Platform')
                        ->maxLength(100)
                        ->visible(fn ($get) => $get('data.show_secondary_button') === true),

                    TextInput::make('data.secondary_button_url')
                        ->label('Secondary Button URL')
                        ->placeholder('/features')
                        ->maxLength(500)
                        ->visible(fn ($get) => $get('data.show_secondary_button') === true),

                    TextInput::make('data.secondary_button_icon')
                        ->label('Secondary Button Icon')
                        ->placeholder('arrow-right')
                        ->maxLength(50)
                        ->helperText('Optional icon name.')
                        ->visible(fn ($get) => $get('data.show_secondary_button') === true),

                    Toggle::make('data.secondary_button_new_tab')
                        ->label('Open in New Tab')
                        ->default(false)
                        ->inline(false)
                        ->visible(fn ($get) => $get('data.show_secondary_button') === true),
                ])
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->columnSpanFull(),

            Section::make('CTA Appearance')
                ->description('Control the visual appearance of the CTA section.')
                ->schema([
                    Select::make('data.style')
                        ->label('CTA Style')
                        ->options([
                            'default' => 'Default',
                            'dark' => 'Dark',
                            'gradient' => 'Gradient',
                            'glass' => 'Glass',
                            'minimal' => 'Minimal',
                        ])
                        ->default('gradient')
                        ->required(),

                    Select::make('data.alignment')
                        ->label('Content Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                        ])
                        ->default('center')
                        ->required(),

                    Select::make('data.size')
                        ->label('CTA Size')
                        ->options([
                            'compact' => 'Compact',
                            'default' => 'Default',
                            'large' => 'Large',
                        ])
                        ->default('large')
                        ->required(),

                    Select::make('data.radius')
                        ->label('Corner Radius')
                        ->options([
                            'none' => 'None',
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                        ])
                        ->default('large')
                        ->required(),

                    Select::make('data.width')
                        ->label('Content Width')
                        ->options([
                            'narrow' => 'Narrow',
                            'default' => 'Default',
                            'wide' => 'Wide',
                            'full' => 'Full Width',
                        ])
                        ->default('default')
                        ->required(),

                    Select::make('data.shadow')
                        ->label('Shadow')
                        ->options([
                            'none' => 'None',
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                        ])
                        ->default('medium')
                        ->required(),

                    Toggle::make('data.show_icon')
                        ->label('Show CTA Icon')
                        ->default(true)
                        ->inline(false),

                    Toggle::make('data.show_pattern')
                        ->label('Show Decorative Pattern')
                        ->default(true)
                        ->inline(false),

                    Toggle::make('data.show_badge')
                        ->label('Show Status Badge')
                        ->default(false)
                        ->inline(false),

                    TextInput::make('data.badge')
                        ->label('Badge Text')
                        ->placeholder('Limited Time')
                        ->maxLength(50)
                        ->visible(fn ($get) => $get('data.show_badge') === true)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Background Settings')
                ->description('Configure the background and visual treatment of the CTA.')
                ->schema([
                    Select::make('data.background')
                        ->label('Background Type')
                        ->options([
                            'default' => 'Default',
                            'solid' => 'Solid',
                            'gradient' => 'Gradient',
                            'transparent' => 'Transparent',
                        ])
                        ->default('gradient')
                        ->required(),

                    Select::make('data.gradient')
                        ->label('Gradient Style')
                        ->options([
                            'indigo-purple' => 'Indigo / Purple',
                            'blue-cyan' => 'Blue / Cyan',
                            'purple-pink' => 'Purple / Pink',
                            'green-teal' => 'Green / Teal',
                            'orange-red' => 'Orange / Red',
                        ])
                        ->default('indigo-purple')
                        ->visible(fn ($get) => $get('data.background') === 'gradient')
                        ->columnSpanFull(),

                    Select::make('data.border')
                        ->label('Border')
                        ->options([
                            'none' => 'None',
                            'subtle' => 'Subtle',
                            'strong' => 'Strong',
                        ])
                        ->default('subtle')
                        ->required(),
                ])
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->columnSpanFull(),

            Section::make('Spacing')
                ->description('Control the spacing of the CTA section.')
                ->schema([
                    Select::make('data.padding')
                        ->label('Padding')
                        ->options([
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                            'extra-large' => 'Extra Large',
                        ])
                        ->default('large')
                        ->required(),

                    Select::make('data.margin_top')
                        ->label('Top Margin')
                        ->options([
                            'none' => 'None',
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                        ])
                        ->default('medium')
                        ->required(),

                    Select::make('data.margin_bottom')
                        ->label('Bottom Margin')
                        ->options([
                            'none' => 'None',
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                        ])
                        ->default('medium')
                        ->required(),
                ])
                ->columns(3)
                ->collapsible()
                ->collapsed()
                ->columnSpanFull(),
        ], self::commonSettings());
    }
}
