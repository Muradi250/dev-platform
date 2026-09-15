<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class StatisticsBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([
            TextInput::make('data.title')
                ->label('Section Title')
                ->placeholder('Platform Statistics')
                ->maxLength(255)
                ->columnSpanFull(),

            Repeater::make('data.statistics')
                ->label('Statistics Items')
                ->schema([
                    TextInput::make('value')
                        ->label('Value')
                        ->placeholder('10+')
                        ->helperText('Optional. Example: 10+, 500, 99.9%')
                        ->maxLength(50),

                    TextInput::make('label')
                        ->label('Label')
                        ->placeholder('Active Users')
                        ->helperText('Optional. Example: Active Users')
                        ->maxLength(255),

                    TextInput::make('icon')
                        ->label('Icon')
                        ->placeholder('users')
                        ->helperText('Optional. Leave empty if no icon is needed.')
                        ->maxLength(100),
                ])
                ->columns(3)
                ->defaultItems(4)
                ->minItems(0)
                ->addActionLabel('Add Statistic')
                ->reorderable()
                ->collapsible()
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}
