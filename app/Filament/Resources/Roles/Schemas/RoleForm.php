<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make('Role Information')
                ->description('Define role name and access guard')
                ->schema([
                    TextInput::make('name')
                        ->label('Role Name')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Example: admin, manager, super-admin'),

                    TextInput::make('guard_name')
                        ->label('Guard Name')
                        ->default('web')
                        ->required()
                        ->disabled()
                        ->dehydrated(),
                ])
                ->columns(2),

            Section::make('Permissions')
                ->description('Assign permissions to this role')
                ->schema([
                    CheckboxList::make('permissions')
                        ->relationship('permissions', 'name')
                        ->searchable()
                        ->bulkToggleable()
                        ->columns(2),
                ]),
        ]);
    }
}