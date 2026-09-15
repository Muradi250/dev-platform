<?php

namespace App\Providers\Filament;








use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;

use Filament\Pages\Dashboard;

use Filament\Panel;
use Filament\PanelProvider;

use Filament\Support\Colors\Color;

use Filament\Widgets\AccountWidget;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

use Illuminate\Routing\Middleware\SubstituteBindings;

use Illuminate\Session\Middleware\StartSession;

use Illuminate\View\Middleware\ShareErrorsFromSession;



class AdminPanelProvider extends PanelProvider
{


    public function panel(Panel $panel): Panel
    {


        return $panel


            /*
            |--------------------------------------------------------------------------
            | Panel Identity
            |--------------------------------------------------------------------------
            */


            ->default()

            ->id('admin')

            ->path('admin')





            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */


          ->login()

->authGuard('web')

->renderHook(
    \Filament\View\PanelsRenderHook::TOPBAR_END,
    fn () => view('filament.admin.language-switcher')
)

  
          


            /*
            |--------------------------------------------------------------------------
            | Theme
            |--------------------------------------------------------------------------
            */


            ->colors([

                'primary' => Color::Amber,

            ])









            /*
            |--------------------------------------------------------------------------
            | Resources
            |--------------------------------------------------------------------------
            */


            ->discoverResources(

                in: app_path('Filament/Resources'),

                for: 'App\Filament\Resources'

            )







            /*
            |--------------------------------------------------------------------------
            | Pages
            |--------------------------------------------------------------------------
            */


            ->discoverPages(

                in: app_path('Filament/Pages'),

                for: 'App\Filament\Pages'

            )


            ->pages([

                Dashboard::class,

            ])









            /*
            |--------------------------------------------------------------------------
            | Widgets
            |--------------------------------------------------------------------------
            */


            ->discoverWidgets(

                in: app_path('Filament/Widgets'),

                for: 'App\Filament\Widgets'

            )


            ->widgets([

                AccountWidget::class,

            ])









            /*
            |--------------------------------------------------------------------------
            | Middleware
            |--------------------------------------------------------------------------
            */


            ->middleware([


                EncryptCookies::class,


                AddQueuedCookiesToResponse::class,


                StartSession::class,



                /*
                |--------------------------------------------------------------------------
                | Admin Language Switch
                |--------------------------------------------------------------------------
                */


                \App\Http\Middleware\SetAdminLocale::class,



                AuthenticateSession::class,


                ShareErrorsFromSession::class,


                PreventRequestForgery::class,


                SubstituteBindings::class,


            ])











            /*
            |--------------------------------------------------------------------------
            | Authentication Middleware
            |--------------------------------------------------------------------------
            */


            ->authMiddleware([

                Authenticate::class,

            ]);



    }


}