<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class VideoBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            TextInput::make('data.title')
                ->label('Video Title')
                ->maxLength(255)
                ->columnSpanFull(),

            Textarea::make('data.description')
                ->label('Description')
                ->rows(5)
                ->columnSpanFull(),

            Select::make('data.provider')
                ->label('Video Provider')
                ->options([
                    'youtube' => 'YouTube',
                    'vimeo' => 'Vimeo',
                    'aparat' => 'Aparat',
                    'custom' => 'Custom Video',
                ])
                ->default('youtube')
                ->required()
                ->live(),

            TextInput::make('data.video_url')
                ->label('Video URL')
                ->placeholder('https://www.youtube.com/watch?v=... or https://www.aparat.com/v/...')
                ->url()
                ->required()
                ->columnSpanFull(),

            FileUpload::make('data.thumbnail')
                ->label('Video Thumbnail')
                ->image()
                ->disk('public')
                ->directory('blocks/videos')
                ->imagePreviewHeight('150')
                ->openable()
                ->downloadable()
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}