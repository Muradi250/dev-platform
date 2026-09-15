<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Publishing;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class PublishingSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Publishing Status')
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('published')
                        ->required()
                        ->native(false),
                ]),
        ];
    }
}