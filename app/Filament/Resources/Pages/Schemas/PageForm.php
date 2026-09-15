<?php

namespace App\Filament\Resources\Pages\Schemas;

/*
|--------------------------------------------------------------------------
| Page Settings - General
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\General\GeneralSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Template & Layout
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Layout\TemplateSettings;
use App\Filament\Resources\Pages\Schemas\PageSettings\Layout\LayoutSettings;
use App\Filament\Resources\Pages\Schemas\PageSettings\Layout\ContainerSettings;
use App\Filament\Resources\Pages\Schemas\PageSettings\Layout\WidthSettings;
use App\Filament\Resources\Pages\Schemas\PageSettings\Layout\SpacingSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Header
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Header\HeaderSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Navigation
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Navigation\NavigationSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Sidebar
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Sidebar\SidebarSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Theme
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Theme\ThemeSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Responsive
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Responsive\ResponsiveSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Access
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Access\AccessSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - SEO
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\SEO\SeoSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Publishing
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Publishing\PublishingSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Advanced
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Advanced\AdvancedSettings;

/*
|--------------------------------------------------------------------------
| Page Settings - Footer
|--------------------------------------------------------------------------
*/

use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\FooterSettings;
use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\FooterItems;
use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\FooterVisibility;
use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\FooterAppearance;
use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\FooterBehavior;
use App\Filament\Resources\Pages\Schemas\PageSettings\Footer\BrandSocialSettings;

/*
|--------------------------------------------------------------------------
| Filament Schema Components
|--------------------------------------------------------------------------
*/

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

/*
|--------------------------------------------------------------------------
| Page Form
|--------------------------------------------------------------------------
*/

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Page Builder Tabs
                |--------------------------------------------------------------------------
                */

                Tabs::make('Page Builder')
                    ->tabs([

                        /*
                        |--------------------------------------------------------------------------
                        | General
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('General')
                            ->schema(
                                GeneralSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Template & Layout
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Template & Layout')
                            ->schema([
                                ...TemplateSettings::schema(),
                                ...LayoutSettings::schema(),
                                ...ContainerSettings::schema(),
                                ...WidthSettings::schema(),
                                ...SpacingSettings::schema(),
                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | Header
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Header')
                            ->schema(
                                HeaderSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Navigation
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Navigation')
                            ->schema(
                                NavigationSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Sidebar & Info
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Sidebar & Info')
                            ->schema(
                                SidebarSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Footer
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Footer')
                            ->schema([
                                ...FooterSettings::schema(),
                                ...FooterItems::schema(),
                                ...FooterVisibility::schema(),
                                ...FooterAppearance::schema(),
                                ...FooterBehavior::schema(),
                                ...BrandSocialSettings::schema(),
                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | Theme
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Theme')
                            ->schema(
                                ThemeSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Responsive
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Responsive')
                            ->schema(
                                ResponsiveSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Access
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Access')
                            ->schema(
                                AccessSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | SEO
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('SEO')
                            ->schema(
                                SeoSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Publishing
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Publishing')
                            ->schema(
                                PublishingSettings::schema()
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | Advanced
                        |--------------------------------------------------------------------------
                        */

                        Tab::make('Advanced')
                            ->schema(
                                AdvancedSettings::schema()
                            ),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}