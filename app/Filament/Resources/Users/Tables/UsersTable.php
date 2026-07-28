<?php

namespace App\Filament\Resources\Users\Tables;


use App\Models\User;


use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\IconColumn;


use Filament\Tables\Table;



class UsersTable
{


    public static function configure(Table $table): Table
    {


        return $table


            ->columns([



                /*
                |--------------------------------------------------------------------------
                | Name
                |--------------------------------------------------------------------------
                */

                TextColumn::make('name')

                    ->label('Name')

                    ->searchable()

                    ->sortable()

                    ->icon('heroicon-o-user')

                    ->weight('bold'),




                /*
                |--------------------------------------------------------------------------
                | Email
                |--------------------------------------------------------------------------
                */

                TextColumn::make('email')

                    ->label('Email')

                    ->searchable()

                    ->copyable()

                    ->icon('heroicon-o-envelope'),




                /*
                |--------------------------------------------------------------------------
                | Owner
                |--------------------------------------------------------------------------
                */

                IconColumn::make('is_owner')

                    ->label('Owner')

                    ->boolean()

                    ->trueIcon('heroicon-o-shield-check')

                    ->falseIcon('heroicon-o-user')

                    ->sortable(),




                /*
                |--------------------------------------------------------------------------
                | Roles
                |--------------------------------------------------------------------------
                */

                TextColumn::make('roles')

                    ->label('Roles')

                    ->formatStateUsing(fn(User $record) =>

                        $record->roles
                            ->pluck('name')
                            ->join(', ')

                    )

                    ->badge()

                    ->color(fn(User $record) =>


                        $record->is_owner

                            ? 'danger'


                            :

                        (
                            $record->roles
                                ->contains('name','super-admin')

                                ? 'warning'


                                :

                            (
                                $record->roles
                                    ->contains('name','admin')

                                    ? 'primary'

                                    : 'gray'
                            )

                        )

                    ),






                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                SelectColumn::make('status')

                    ->label('Status')

                    ->options([

                        'active' => 'Active',

                        'pending' => 'Pending',

                        'suspended' => 'Suspended',

                        'banned' => 'Banned',

                    ])


                    /*
                    |--------------------------------------------------------------------------
                    | Owner Protection
                    |--------------------------------------------------------------------------
                    */

                    ->disabled(fn(User $record) =>

                        $record->is_owner

                    )

                    ->sortable(),






                /*
                |--------------------------------------------------------------------------
                | Created
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')

                    ->label('Created')

                    ->dateTime()

                    ->sortable(),


            ])





            /*
            |--------------------------------------------------------------------------
            | Edit Action
            |--------------------------------------------------------------------------
            */

            ->recordActions([


                EditAction::make()

                    /*
                    Owner فقط خودش را Edit کند
                    */

                    ->hidden(fn(User $record) =>

                        $record->is_owner

                        &&

                        auth()->id() !== $record->id

                    ),


            ])







            /*
            |--------------------------------------------------------------------------
            | Bulk Delete Protection
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([


                BulkActionGroup::make([


                    DeleteBulkAction::make()


                        ->before(function ($records) {


                            if (

                                $records->contains(

                                    fn(User $user)

                                    => $user->is_owner

                                )

                            ) {


                                throw new \Exception(

                                    'System Owner account cannot be deleted.'

                                );

                            }


                        }),



                ]),


            ]);


    }


}