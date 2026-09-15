<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class FooterBehavior
{
    public static function schema(): array
    {
        return [
            Section::make('Footer Behavior')
                ->description('Control how the footer behaves and interacts with visitors.')
                ->schema([
                    Toggle::make('settings.footer.behavior.sticky')
                        ->label('Sticky Footer')
                        ->default(false),

                    Toggle::make('settings.footer.behavior.back_to_top')
                        ->label('Show Back to Top')
                        ->default(true),

                    Select::make('settings.footer.behavior.back_to_top_position')
                        ->label('Back to Top Position')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                        ])
                        ->default('right')
                        ->native(false),

                    Toggle::make('settings.footer.behavior.show_copyright')
                        ->label('Show Copyright')
                        ->default(true),

                    Toggle::make('settings.footer.behavior.mobile_collapsible')
                        ->label('Collapse Columns on Mobile')
                        ->default(true),

                    Toggle::make('settings.footer.behavior.external_links_new_tab')
                        ->label('Open External Links in New Tab')
                        ->default(true),

                    Toggle::make('settings.footer.behavior.animation')
                        ->label('Enable Footer Animation')
                        ->default(false),

                    Select::make('settings.footer.behavior.animation_type')
                        ->label('Animation Type')
                        ->options([
                            'fade' => 'Fade',
                            'slide_up' => 'Slide Up',
                        ])
                        ->default('fade')
                        ->native(false),

                    TextInput::make('settings.footer.behavior.animation_duration')
                        ->label('Animation Duration')
                        ->placeholder('300ms')
                        ->maxLength(20),
                ])
                ->columns(2),
        ];
    }
}
