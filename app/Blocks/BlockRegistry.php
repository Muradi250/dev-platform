<?php

namespace App\Blocks;


/*
|--------------------------------------------------------------------------
| Block Registry
|--------------------------------------------------------------------------
|
| اتصال Block Type ها به Schema های مربوطه
|
| Example:
|
| hero
|   ↓
| HeroBlock
|
|--------------------------------------------------------------------------
*/


class BlockRegistry
{


    public static function getSchema(string $type): array
    {


        return match ($type) {


            'hero' =>
                Schemas\HeroBlock::schema(),


            'text' =>
                Schemas\TextBlock::schema(),


            'image' =>
                Schemas\ImageBlock::schema(),


            'gallery' =>
                Schemas\GalleryBlock::schema(),


            'cards' =>
                Schemas\CardsBlock::schema(),


            'features' =>
                Schemas\FeaturesBlock::schema(),


            'statistics' =>
                Schemas\StatisticsBlock::schema(),


            'cta' =>
                Schemas\CtaBlock::schema(),


            'faq' =>
                Schemas\FaqBlock::schema(),


            'team' =>
                Schemas\TeamBlock::schema(),


            'testimonials' =>
                Schemas\TestimonialsBlock::schema(),


            'video' =>
                Schemas\VideoBlock::schema(),


            'contact' =>
                Schemas\ContactBlock::schema(),


            'html' =>
                Schemas\HtmlBlock::schema(),


            'divider' =>
                Schemas\DividerBlock::schema(),



            'logo_cloud' =>
                Schemas\LogoCloudBlock::schema(),


            'pricing' =>
                Schemas\PricingBlock::schema(),


            'timeline' =>
                Schemas\TimelineBlock::schema(),



            default => [],


        };


    }


}