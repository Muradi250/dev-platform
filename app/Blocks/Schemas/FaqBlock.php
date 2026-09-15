<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

class FaqBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            TextInput::make('data.eyebrow')
                ->label('Eyebrow')
                ->placeholder('Frequently Asked Questions')
                ->maxLength(100)
                ->columnSpanFull(),

            TextInput::make('data.title')
                ->label('Section Title')
                ->placeholder('Everything You Need to Know')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Section Description')
                ->placeholder('Find answers to the most common questions about our platform and services.')
                ->rows(4)
                ->maxLength(1000)
                ->columnSpanFull(),

            Select::make('data.columns')
                ->label('FAQ Columns')
                ->options([
                    '1' => '1 Column',
                    '2' => '2 Columns',
                ])
                ->default('1')
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
                    'circle' => 'Circle',
                    'rounded' => 'Rounded Square',
                    'soft' => 'Soft',
                    'minimal' => 'Minimal',
                ])
                ->default('circle')
                ->required(),

            Repeater::make('data.questions')
                ->label('Frequently Asked Questions')
                ->schema([

                    TextInput::make('question')
                        ->label('Question')
                        ->placeholder('How does the platform work?')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('badge')
                        ->label('Badge')
                        ->placeholder('Popular')
                        ->maxLength(50),

                    Textarea::make('answer')
                        ->label('Answer')
                        ->placeholder('Write a clear and helpful answer...')
                        ->required()
                        ->rows(5)
                        ->maxLength(3000)
                        ->columnSpanFull(),

                    Toggle::make('featured')
                        ->label('Featured Question')
                        ->default(false),

                    Toggle::make('visible')
                        ->label('Visible')
                        ->default(true),

                ])
                ->columns(2)
                ->defaultItems(5)
                ->minItems(1)
                ->reorderable()
                ->collapsible()
                ->cloneable()
                ->itemLabel(function (array $state): ?string {
                    return $state['question'] ?? 'New Question';
                })
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}
