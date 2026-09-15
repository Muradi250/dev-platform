<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TimelineBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            /*
            |--------------------------------------------------------------------------
            | Section Information
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.title')
                ->label('Section Title')
                ->placeholder('How It Works')
                ->helperText('Main heading displayed above the timeline.')
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Section Description')
                ->placeholder('Describe the process, workflow, or journey...')
                ->helperText('Optional supporting text displayed below the section title.')
                ->rows(3)
                ->maxLength(1000)
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Timeline Steps
            |--------------------------------------------------------------------------
            */

            Repeater::make('data.steps')
                ->label('Timeline Steps')
                ->addActionLabel('Add Timeline Step')
                ->helperText(
                    'Create and organize the stages of your process or workflow.'
                )
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | Step Identity
                    |--------------------------------------------------------------------------
                    */

                    TextInput::make('number')
                        ->label('Step Number')
                        ->placeholder('01')
                        ->helperText('Example: 01, 02, 03')
                        ->maxLength(10)
                        ->default(fn ($livewire, $state) => null),

                    Select::make('icon')
                        ->label('Icon')
                        ->options([
                            'rocket'       => '🚀 Rocket',
                            'users'        => '👥 Users',
                            'code'         => '💻 Code',
                            'database'     => '🗄️ Database',
                            'check-circle' => '✓ Check Circle',
                            'light-bulb'   => '💡 Light Bulb',
                            'shield'       => '🛡️ Shield',
                            'chart'        => '📈 Chart',
                            'settings'     => '⚙️ Settings',
                            'star'         => '⭐ Star',
                            'check'        => '✓ Check',
                        ])
                        ->searchable()
                        ->native(false)
                        ->placeholder('Select an icon'),

                    TextInput::make('title')
                        ->label('Step Title')
                        ->placeholder('Planning & Analysis')
                        ->helperText('The main title of this process step.')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Step Description')
                        ->placeholder(
                            'Explain what happens during this stage...'
                        )
                        ->rows(3)
                        ->maxLength(1500)
                        ->columnSpanFull(),

                    /*
                    |--------------------------------------------------------------------------
                    | Step Metadata
                    |--------------------------------------------------------------------------
                    */

                    TextInput::make('duration')
                        ->label('Duration')
                        ->placeholder('2–3 Days')
                        ->helperText('Optional. Example: 1 Week, 2–3 Days.')
                        ->maxLength(100),

                    TextInput::make('label')
                        ->label('Small Label')
                        ->placeholder('Phase 01')
                        ->helperText('Optional label displayed above the step title.')
                        ->maxLength(100),

                    /*
                    |--------------------------------------------------------------------------
                    | Step Link
                    |--------------------------------------------------------------------------
                    */

                    TextInput::make('url')
                        ->label('Step Link')
                        ->placeholder('/services/planning')
                        ->helperText('Optional URL for this timeline step.')
                        ->url()
                        ->maxLength(500)
                        ->columnSpanFull(),

                    /*
                    |--------------------------------------------------------------------------
                    | Step Appearance
                    |--------------------------------------------------------------------------
                    */

                    ColorPicker::make('color')
                        ->label('Step Color')
                        ->helperText('Optional custom color for this step.'),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->helperText('Disable this step without deleting it.')
                        ->default(true)
                        ->inline(false),

                ])
                ->columns(2)
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(20)
                ->collapsible()
                ->cloneable()
                ->reorderable()
                ->reorderableWithButtons()
                ->itemLabel(
                    fn (array $state): string =>
                        $state['number'] ?? null
                            ? ($state['number'] . ' — ' . ($state['title'] ?? 'New Step'))
                            : ($state['title'] ?? 'New Timeline Step')
                )
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}