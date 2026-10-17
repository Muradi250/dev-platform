<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SetAdminLocale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $adminCss = Css::make(
            'admin',
            Vite::asset('resources/css/filament/admin.css'),
        );

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
            ->databaseNotifications()

            /*
            |--------------------------------------------------------------------------
            | Corporate Header
            |--------------------------------------------------------------------------
            */

            ->renderHook(
                PanelsRenderHook::TOPBAR_LOGO_AFTER,
                fn () => view('filament.admin.corporate-brand')
            )

            ->renderHook(
                PanelsRenderHook::PAGE_START,
                fn () => view('filament.admin.corporate-header')
            )

            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn () => view('filament.admin.footer')
            )

            /*
            |--------------------------------------------------------------------------
            | Admin Language Switch
            |--------------------------------------------------------------------------
            */

            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
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

            ->assets([
                $adminCss,
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

            ->navigationGroups([
                NavigationGroup::make('Access & Security')
                    ->icon('heroicon-o-shield-check'),
                NavigationGroup::make('Security & Audit')
                    ->icon('heroicon-o-clipboard-document-check'),
            ])
            ->sidebarCollapsibleOnDesktop()

            /*
            |--------------------------------------------------------------------------
            | Pages
            |--------------------------------------------------------------------------
            */

            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\Filament\Pages'
            )

            ->pages([])

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

                SetAdminLocale::class,

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
