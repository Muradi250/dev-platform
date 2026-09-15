<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class HeaderBehavior
{
    public static function schema(): array
    {
        return [
            Section::make('Header Behavior')
                ->description('Control how the header behaves while scrolling the page.')
                ->schema([

                    Toggle::make('settings.header.behavior.sticky')
                        ->label('Sticky Header')
                        ->helperText('Keep the header at the top while scrolling.')
                        ->default(true)
                        ->live(),

                    Toggle::make('settings.header.behavior.hide_on_scroll')
                        ->label('Hide on Scroll')
                        ->helperText('Hide the header when scrolling down.')
                        ->default(false)
                        ->live(),

                    Toggle::make('settings.header.behavior.shrink_on_scroll')
                        ->label('Shrink on Scroll')
                        ->helperText('Reduce the header size after scrolling.')
                        ->default(false)
                        ->live(),

                    Select::make('settings.header.behavior.scroll_offset')
                        ->label('Scroll Offset')
                        ->helperText('The scroll distance before the behavior starts.')
                        ->options([
                            '0'   => '0 px',
                            '20'  => '20 px',
                            '40'  => '40 px',
                            '60'  => '60 px',
                            '80'  => '80 px',
                            '100' => '100 px',
                            '120' => '120 px',
                        ])
                        ->default('20')
                        ->native(false),

                ])
                ->columns(2),
        ];
    }
}
