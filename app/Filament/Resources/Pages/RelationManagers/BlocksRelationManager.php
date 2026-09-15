<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use App\Blocks\BlockTypes;
use App\Blocks\BlockSchema;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class BlocksRelationManager extends RelationManager
{
    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    protected static string $relationship = 'blocks';


    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    public function form(Schema $schema): Schema
    {
        return $schema

            ->components([

                /*
                |--------------------------------------------------------------------------
                | Block Type
                |--------------------------------------------------------------------------
                */

                Select::make('type')

                    ->label('Block Type')

                    ->options(
                        BlockTypes::all()
                    )

                    ->searchable()

                    ->live()

                    ->required()

                    ->afterStateUpdated(
                        function (
                            Select $component,
                            callable $set
                        ): void {

                            /*
                            |--------------------------------------------------------------------------
                            | Clear previous block data
                            |--------------------------------------------------------------------------
                            */

                            $set('data', []);

                            /*
                            |--------------------------------------------------------------------------
                            | Initialize Dynamic Schema
                            |--------------------------------------------------------------------------
                            |
                            | This is important for Filament 5.
                            |
                            | When the type changes, the dynamic schema
                            | must be initialized immediately.
                            |
                            */

                            $component
                                ->getContainer()
                                ->getComponent('dynamicBlockSchema')
                                ->getChildSchema()
                                ->fill();

                        }
                    ),


                /*
                |--------------------------------------------------------------------------
                | Sort Order
                |--------------------------------------------------------------------------
                */

                TextInput::make('sort_order')

                    ->label('Sort Order')

                    ->numeric()

                    ->default(0),


                /*
                |--------------------------------------------------------------------------
                | Active
                |--------------------------------------------------------------------------
                */

                Toggle::make('is_active')

                    ->label('Active')

                    ->default(true),


                /*
                |--------------------------------------------------------------------------
                | Dynamic Block Schema
                |--------------------------------------------------------------------------
                */

                Group::make()

                    ->schema(
                        function (Get $get): array {

                            return BlockSchema::make(
                                $get('type')
                            );

                        }
                    )

                    ->key('dynamicBlockSchema')

                    ->columnSpanFull(),

            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('type')
                    ->label('Block')
                    ->searchable(),

                TextColumn::make('sort_order')
                    ->label('Order'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

            ])

            ->headerActions([

                CreateAction::make(),

            ])

            ->actions([

                EditAction::make(),

                DeleteAction::make(),

            ])

            ->defaultSort(
                'sort_order'
            );
    }
}