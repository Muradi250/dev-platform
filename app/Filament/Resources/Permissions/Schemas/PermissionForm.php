<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Permission Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('users.view'),

                TextInput::make('guard_name')
                    ->label('Guard Name')
                    ->default('web')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}