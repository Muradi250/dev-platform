<?php

namespace App\Blocks;


/*
|--------------------------------------------------------------------------
| Block Types
|--------------------------------------------------------------------------
|
| لیست مرکزی تمام Block های Page Builder
|
|--------------------------------------------------------------------------
*/


class BlockTypes
{


    public static function all(): array
    {


        return [


            'hero' => 'Hero',

            'text' => 'Text',

            'image' => 'Image',

            'gallery' => 'Gallery',

            'cards' => 'Cards',

            'features' => 'Features',

            'statistics' => 'Statistics',

            'cta' => 'CTA',

            'faq' => 'FAQ',

            'team' => 'Team',

            'testimonials' => 'Testimonials',

            'video' => 'Video',

            'contact' => 'Contact',

            'html' => 'HTML',

            'divider' => 'Divider',


            /*
            |--------------------------------------------------------------------------
            | New Enterprise Blocks
            |--------------------------------------------------------------------------
            */


            'logo_cloud' => 'Logo Cloud',

            'pricing' => 'Pricing',

            'timeline' => 'Timeline / Process',


        ];

    }


}