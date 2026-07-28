<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;



class PagesTable
{

    public static function configure(Table $table): Table
    {

        return $table


            /*
            |--------------------------------------------------------------------------
            | ستون‌های لیست صفحات
            |--------------------------------------------------------------------------
            */

            ->columns([


                /*
                |------------------------------------------------------------------
                | نام صفحه
                |------------------------------------------------------------------
                */

                TextColumn::make('title')
                    ->label('Page Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),




                /*
                |------------------------------------------------------------------
                | آدرس صفحه
                |------------------------------------------------------------------
                */

                TextColumn::make('slug')
                    ->label('URL')
                    ->searchable(),




                /*
                |------------------------------------------------------------------
                | زبان صفحه
                |------------------------------------------------------------------
                */

                BadgeColumn::make('locale')
                    ->label('Language')
                    ->formatStateUsing(fn ($state) => match($state){

                        'en' => 'English',

                        'fa' => 'فارسی',

                        'ps' => 'پښتو',

                        default => $state,

                    }),





                /*
                |------------------------------------------------------------------
                | وضعیت انتشار
                |------------------------------------------------------------------
                */

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([

                        'success' => 'published',

                        'warning' => 'draft',

                    ])
                    ->formatStateUsing(fn ($state) => match($state){

                        'published' => 'Published',

                        'draft' => 'Draft',

                        default => $state,

                    }),





                /*
                |------------------------------------------------------------------
                | تعداد Block ها
                |------------------------------------------------------------------
                */

                TextColumn::make('blocks_count')
                    ->label('Blocks')
                    ->counts('blocks')
                    ->formatStateUsing(
                        fn ($state) => $state . ' Blocks'
                    ),





                /*
                |------------------------------------------------------------------
                | تاریخ ساخت
                |------------------------------------------------------------------
                */

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),


            ])




            /*
            |--------------------------------------------------------------------------
            | فیلترها
            |--------------------------------------------------------------------------
            */

            ->filters([

                //

            ])




            /*
            |--------------------------------------------------------------------------
            | عملیات روی هر صفحه
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ])




            /*
            |--------------------------------------------------------------------------
            | عملیات گروهی
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);

    }

}