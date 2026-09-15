<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Layout;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class TemplateSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Page Type
            |--------------------------------------------------------------------------
            */

            Section::make('Page Type')
                ->description(
                    'Define the purpose and functional category of this page.'
                )
                ->schema([

                    Select::make('settings.page.type')
                        ->label('Page Type')
                        ->options([
                            'default' => 'Default Page',
                            'landing' => 'Landing Page',
                            'module' => 'Module Page',
                            'about' => 'About Page',
                            'contact' => 'Contact Page',
                            'dashboard' => 'Dashboard Page',
                            'content' => 'Content Page',
                        ])
                        ->default('default')
                        ->native(false),

                ])
                ->columns(1),


            /*
            |--------------------------------------------------------------------------
            | Design Style
            |--------------------------------------------------------------------------
            */

            Section::make('Design Style')
                ->description(
                    'Choose the visual design language of this page. The style changes the visual presentation without adding or changing content blocks.'
                )
                ->schema([

                    Select::make('settings.design.style')
                        ->label('Design Style')
                        ->options([
                            'modern' => 'Modern',
                            'professional' => 'Professional',
                            'corporate' => 'Corporate',
                            'saas' => 'SaaS',
                            'minimal' => 'Minimal',
                            'creative' => 'Creative',
                            'editorial' => 'Editorial',
                        ])
                        ->default('professional')
                        ->native(false),

                ])
                ->columns(1),

        ];
    }
}
