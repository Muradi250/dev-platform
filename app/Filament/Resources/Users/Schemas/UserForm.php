<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),

                DateTimePicker::make('email_verified_at'),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => 
                        filled($state) ? bcrypt($state) : null
                    )
                    ->dehydrated(fn ($state) => filled($state)),

                TextInput::make('avatar')
                    ->maxLength(255),

                // ⭐ ROLE ASSIGNMENT (مهم ترین بخش)
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->helperText('Select user role (admin, user, super-admin)'),
            ]);
    }
}