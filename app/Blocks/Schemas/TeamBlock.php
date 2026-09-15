<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TeamBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            /*
            |--------------------------------------------------------------------------
            | Team Section
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.eyebrow')
                ->label('Eyebrow')
                ->placeholder('Our Team')
                ->maxLength(100)
                ->columnSpanFull(),

            TextInput::make('data.title')
                ->label('Section Title')
                ->placeholder('Meet Our Team')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Section Description')
                ->placeholder('Meet the people behind our platform and products.')
                ->rows(4)
                ->maxLength(1000)
                ->columnSpanFull(),

            Select::make('data.columns')
                ->label('Desktop Columns')
                ->options([
                    2 => '2 Columns',
                    3 => '3 Columns',
                    4 => '4 Columns',
                ])
                ->default(3)
                ->native(false)
                ->required(),

            Select::make('data.card_style')
                ->label('Card Style')
                ->options([
                    'glass' => 'Glass',
                    'clean' => 'Clean',
                    'bordered' => 'Bordered',
                    'minimal' => 'Minimal',
                ])
                ->default('glass')
                ->native(false)
                ->required(),

            /*
            |--------------------------------------------------------------------------
            | Team Members
            |--------------------------------------------------------------------------
            */

            Repeater::make('data.members')
                ->label('Team Members')
                ->schema([

                    FileUpload::make('image')
                        ->label('Profile Photo')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('180')
                        ->directory('blocks/team')
                        ->disk('public')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->columnSpanFull(),

                    TextInput::make('name')
                        ->label('Full Name')
                        ->placeholder('John Doe')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('position')
                        ->label('Position')
                        ->placeholder('Chief Executive Officer')
                        ->maxLength(255),

                    TextInput::make('department')
                        ->label('Department')
                        ->placeholder('Management')
                        ->maxLength(255),

                    Textarea::make('bio')
                        ->label('Biography')
                        ->placeholder('A short introduction about this team member.')
                        ->rows(4)
                        ->maxLength(1000)
                        ->columnSpanFull(),

                    TextInput::make('linkedin')
                        ->label('LinkedIn URL')
                        ->placeholder('https://linkedin.com/in/username')
                        ->url()
                        ->maxLength(500),

                    TextInput::make('website')
                        ->label('Personal Website')
                        ->placeholder('https://example.com')
                        ->url()
                        ->maxLength(500),

                    Toggle::make('featured')
                        ->label('Featured Member')
                        ->default(false)
                        ->inline(false),

                    Toggle::make('visible')
                        ->label('Visible')
                        ->default(true)
                        ->inline(false),

                ])
                ->columns(2)
                ->defaultItems(3)
                ->minItems(1)
                ->maxItems(20)
                ->addActionLabel('Add Team Member')
                ->reorderable()
                ->collapsible()
                ->cloneable()
                ->itemLabel(function (array $state): ?string {
                    return $state['name'] ?? 'Team Member';
                })
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}
