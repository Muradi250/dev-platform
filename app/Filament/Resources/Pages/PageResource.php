<?php

namespace App\Filament\Resources\Pages;


use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;

use App\Filament\Resources\Pages\Schemas\PageForm;
use App\Filament\Resources\Pages\Tables\PagesTable;

use App\Filament\Resources\Pages\RelationManagers\BlocksRelationManager;

use App\Models\Page;

use BackedEnum;
use UnitEnum;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;



class PageResource extends Resource
{


    /*
    |--------------------------------------------------------------------------
    | مدل مربوط به این Resource
    |--------------------------------------------------------------------------
    |
    | این Resource جدول pages را مدیریت می‌کند.
    |
    */

    protected static ?string $model = Page::class;



    /*
    |--------------------------------------------------------------------------
    | آیکون نمایش در منوی Filament
    |--------------------------------------------------------------------------
    */

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleStack;



    /*
    |--------------------------------------------------------------------------
    | عنوان نمایشی رکورد
    |--------------------------------------------------------------------------
    |
    | این فیلد نام صفحه را در پنل نمایش می‌دهد.
    |
    | مثال:
    | Home
    | About
    | Services
    |
    */

    protected static ?string $recordTitleAttribute = 'title';



    /*
    |--------------------------------------------------------------------------
    | گروه منوی مدیریت
    |--------------------------------------------------------------------------
    |
    | بخش‌های مربوط به Public Website
    | در این گروه قرار می‌گیرند.
    |
    */

    protected static UnitEnum|string|null $navigationGroup = 'Website';



    /*
    |--------------------------------------------------------------------------
    | نام نمایش داده شده در منوی پنل
    |--------------------------------------------------------------------------
    */

    protected static ?string $navigationLabel = 'Website Pages';




    /*
    |--------------------------------------------------------------------------
    | فرم ایجاد و ویرایش صفحه
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }




    /*
    |--------------------------------------------------------------------------
    | جدول لیست صفحات
    |--------------------------------------------------------------------------
    */

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }




    /*
    |--------------------------------------------------------------------------
    | Relation Managers
    |--------------------------------------------------------------------------
    |
    | مدیریت بخش‌های داخلی هر صفحه
    |
    | مثال:
    |
    | Home Page
    |
    |   ├── Hero Block
    |   ├── Services Block
    |   ├── Team Block
    |   └── FAQ Block
    |
    */

    public static function getRelations(): array
    {
        return [

            BlocksRelationManager::class,

        ];
    }




    /*
    |--------------------------------------------------------------------------
    | صفحات داخلی Resource
    |--------------------------------------------------------------------------
    |
    | List
    | Create
    | Edit
    |
    */

    public static function getPages(): array
    {
        return [

            'index' => ListPages::route('/'),

            'create' => CreatePage::route('/create'),

            'edit' => EditPage::route('/{record}/edit'),

        ];
    }

}