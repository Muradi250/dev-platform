<?php

namespace App\Filament\Resources\Users\Schemas;


use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

use Filament\Schemas\Schema;



class UserForm
{


    public static function configure(Schema $schema): Schema
    {


        return $schema

            ->components([



                /*
                |--------------------------------------------------------------------------
                | Basic Information
                |--------------------------------------------------------------------------
                */


                TextInput::make('name')

                    ->label('Name')

                    ->required()

                    ->minLength(3)

                    ->maxLength(255)

                    ->validationMessages([

                        'required' => 'Name is required.',

                        'min' => 'Name must be at least 3 characters.',

                    ]),






                TextInput::make('email')

                    ->label('Email Address')

                    ->email()

                    ->required()

                    ->maxLength(255)


                    /*
                    | جلوگیری از ایمیل تکراری
                    */

                    ->unique(

                        table: 'users',

                        column: 'email',

                        ignoreRecord: true

                    )


                    ->validationMessages([

                        'unique' => 
                        'This email address is already registered.',

                    ]),







                DateTimePicker::make('email_verified_at')

                    ->label('Email Verified At'),







                /*
                |--------------------------------------------------------------------------
                | Password
                |--------------------------------------------------------------------------
                */


                TextInput::make('password')

                    ->label('Password')

                    ->password()


                    ->required(fn ($record) =>

                        $record === null

                    )


                    ->dehydrated(fn ($state) =>

                        filled($state)

                    )


                    ->dehydrateStateUsing(

                        fn ($state) =>

                            filled($state)

                                ? bcrypt($state)

                                : null

                    )


                    ->helperText(

                        'Leave empty to keep current password.'

                    ),







                /*
                |--------------------------------------------------------------------------
                | Avatar
                |--------------------------------------------------------------------------
                */


                TextInput::make('avatar')

                    ->label('Avatar')

                    ->maxLength(255),







                /*
                |--------------------------------------------------------------------------
                | Account Status
                |--------------------------------------------------------------------------
                */


                Select::make('status')

                    ->label('Account Status')

                    ->options([

                        'active' => 'Active',

                        'pending' => 'Pending',

                        'suspended' => 'Suspended',

                        'banned' => 'Banned',

                    ])

                    ->default('active')

                    ->required()


                    ->disabled(fn ($record) =>

                        $record?->is_owner

                    )


                    ->dehydrated(),







                /*
                |--------------------------------------------------------------------------
                | System Owner
                |--------------------------------------------------------------------------
                |
                | فقط مالک واقعی سیستم است.
                |
                */


                Toggle::make('is_owner')

                    ->label('System Owner')

                    ->disabled()

                    ->dehydrated(false)


                    ->helperText(

                        'System ownership is protected.'

                    ),







                /*
                |--------------------------------------------------------------------------
                | Roles
                |--------------------------------------------------------------------------
                |
                | Owner role cannot be changed.
                |
                */


                Select::make('roles')

                    ->label('Roles')

                    ->multiple()


                    ->relationship(

                        'roles',

                        'name'

                    )


                    ->preload()

                    ->searchable()

                    ->required()


                    ->disabled(fn ($record) =>

                        $record?->is_owner

                    )


                    ->dehydrated(fn ($record) =>

                        ! $record?->is_owner

                    )


                    ->helperText(fn ($record) =>


                        $record?->is_owner

                            ?

                        'Owner role is permanently protected.'

                            :

                        'Assign roles to this user.'

                    ),



            ]);

    }

}