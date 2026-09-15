<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;

class GalleryBlock extends BaseBlock
{
    /**
     * Gallery Block Schema
     *
     * Professional image gallery for:
     *
     * - Portfolio
     * - Product Screenshots
     * - Module Showcase
     * - Image Collections
     * - SaaS Landing Pages
     */
    public static function schema(): array
    {
        return array_merge([

            /*
            |--------------------------------------------------------------------------
            | Gallery Content
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.title')
                ->label('Gallery Title')
                ->placeholder('Our Latest Projects')
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Gallery Description')
                ->placeholder(
                    'Explore our latest work and projects.'
                )
                ->rows(4)
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Gallery Images
            |--------------------------------------------------------------------------
            */

            Repeater::make('data.images')
                ->label('Gallery Images')
                ->schema([

                    FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('blocks/gallery')
                        ->visibility('public')
                        ->imagePreviewHeight('180')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('title')
                        ->label('Image Title')
                        ->placeholder('Project Dashboard')
                        ->maxLength(255),

                    TextInput::make('alt')
                        ->label('Alt Text')
                        ->placeholder(
                            'Dashboard interface preview'
                        )
                        ->maxLength(255),

                    Textarea::make('description')
                        ->label('Image Description')
                        ->placeholder(
                            'A preview of the modern dashboard interface.'
                        )
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('caption')
                        ->label('Caption')
                        ->placeholder(
                            'Modern SaaS Dashboard'
                        )
                        ->maxLength(255),

                ])
                ->columns(2)
                ->defaultItems(3)
                ->minItems(1)
                ->collapsible()
                ->reorderable()
                ->cloneable()
                ->addActionLabel('Add Image')
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Gallery Layout
            |--------------------------------------------------------------------------
            */

            Select::make('data.layout')
                ->label('Gallery Layout')
                ->options([
                    'grid' => 'Grid',
                    'masonry' => 'Masonry',
                ])
                ->default('grid')
                ->native(false),

            Select::make('data.columns')
                ->label('Columns')
                ->options([
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                ])
                ->default('3')
                ->native(false),

            Select::make('data.gap')
                ->label('Image Gap')
                ->options([
                    'none' => 'None',
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                ])
                ->default('medium')
                ->native(false),

            /*
            |--------------------------------------------------------------------------
            | Image Ratio
            |--------------------------------------------------------------------------
            */

            Select::make('data.aspect_ratio')
                ->label('Image Aspect Ratio')
                ->options([
                    'auto' => 'Auto',
                    'square' => 'Square',
                    '4/3' => '4:3',
                    '3/2' => '3:2',
                    '16/9' => '16:9',
                ])
                ->default('4/3')
                ->native(false),

            /*
            |--------------------------------------------------------------------------
            | Image Fit
            |--------------------------------------------------------------------------
            */

            Select::make('data.object_fit')
                ->label('Image Fit')
                ->options([
                    'cover' => 'Cover',
                    'contain' => 'Contain',
                ])
                ->default('cover')
                ->native(false),

            /*
            |--------------------------------------------------------------------------
            | Image Style
            |--------------------------------------------------------------------------
            */

            Select::make('data.radius')
                ->label('Border Radius')
                ->options([
                    'none' => 'None',
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'full' => 'Full',
                ])
                ->default('medium')
                ->native(false),

            Select::make('data.shadow')
                ->label('Shadow')
                ->options([
                    'none' => 'None',
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                ])
                ->default('small')
                ->native(false),

            /*
            |--------------------------------------------------------------------------
            | Hover Effect
            |--------------------------------------------------------------------------
            */

            Select::make('data.hover')
                ->label('Hover Effect')
                ->options([
                    'none' => 'None',
                    'zoom' => 'Zoom',
                    'lift' => 'Lift',
                    'grayscale' => 'Grayscale',
                ])
                ->default('zoom')
                ->native(false),

            /*
            |--------------------------------------------------------------------------
            | Caption
            |--------------------------------------------------------------------------
            */

            Toggle::make('data.show_caption')
                ->label('Show Image Captions')
                ->default(true),

            /*
            |--------------------------------------------------------------------------
            | Image Loading
            |--------------------------------------------------------------------------
            */

            Toggle::make('data.lazy_loading')
                ->label('Lazy Loading')
                ->helperText(
                    'Load images only when they are close to the viewport.'
                )
                ->default(true),

            /*
            |--------------------------------------------------------------------------
            | Image Overlay
            |--------------------------------------------------------------------------
            */

            Toggle::make('data.overlay')
                ->label('Image Overlay')
                ->default(false),

            ColorPicker::make('data.overlay_color')
                ->label('Overlay Color')
                ->default('#000000'),

        ],

            /*
            |--------------------------------------------------------------------------
            | Common Settings
            |--------------------------------------------------------------------------
            */

            self::commonSettings()

        );
    }
}