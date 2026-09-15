<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class FeaturesBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            TextInput::make('data.eyebrow')
                ->label('Eyebrow')
                ->placeholder('Why Choose Us')
                ->maxLength(100),

            TextInput::make('data.title')
                ->label('Section Title')
                ->placeholder('Powerful Features for Modern Organizations')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Section Description')
                ->placeholder('Discover the powerful features that make your organization faster, smarter, and more efficient.')
                ->rows(4)
                ->maxLength(1000)
                ->columnSpanFull(),

            Select::make('data.columns')
                ->label('Desktop Columns')
                ->options([
                    2 => '2 Columns',
                    3 => '3 Columns',
                    4 => '4 Columns',
                    5 => '5 Columns',
                    6 => '6 Columns',
                ])
                ->default(3)
                ->required(),

            Select::make('data.card_style')
                ->label('Card Style')
                ->options([
                    'glass' => 'Glass',
                    'solid' => 'Solid',
                    'bordered' => 'Bordered',
                    'minimal' => 'Minimal',
                    'gradient' => 'Gradient',
                ])
                ->default('glass')
                ->required(),

            Select::make('data.icon_style')
                ->label('Icon Style')
                ->options([
                    'square' => 'Rounded Square',
                    'circle' => 'Circle',
                    'soft' => 'Soft',
                    'minimal' => 'Minimal',
                ])
                ->default('square'),

            Repeater::make('data.features')
                ->label('Features')
                ->schema([

                    TextInput::make('icon')
                        ->label('Icon')
                        ->placeholder('sparkles')
                        ->maxLength(100),

                    TextInput::make('title')
                        ->label('Feature Title')
                        ->placeholder('Powerful Automation')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('badge')
                        ->label('Badge')
                        ->placeholder('Popular')
                        ->maxLength(50),

                    Textarea::make('description')
                        ->label('Description')
                        ->placeholder('Automate repetitive tasks and keep your organization running efficiently.')
                        ->rows(4)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Toggle::make('featured')
                        ->label('Featured Feature')
                        ->default(false),

                    Toggle::make('visible')
                        ->label('Visible')
                        ->default(true),

                ])
                ->columns(2)
                ->defaultItems(6)
                ->minItems(1)
                ->maxItems(12)
                ->reorderable()
                ->collapsible()
                ->cloneable()
                ->itemLabel(
                    fn (array $state): ?string =>
                        $state['title'] ?? 'New Feature'
                )
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}
