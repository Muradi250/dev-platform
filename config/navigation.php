<?php

return [

    'main' => [

        /*
        |--------------------------------------------------------------------------
        | Platform
        |--------------------------------------------------------------------------
        */

        [
            'title' => 'navigation.platform',
            'icon'  => 'grid',

            'children' => [

                [
                    'title' => 'navigation.overview',
                    'icon' => 'presentation',
                    'description' => 'navigation.overview_desc',
                ],

                [
                    'title' => 'navigation.architecture',
                    'icon' => 'layers',
                    'description' => 'navigation.architecture_desc',
                ],

                [
                    'title' => 'navigation.security',
                    'icon' => 'shield',
                    'description' => 'navigation.security_desc',
                ],

            ],

        ],



        /*
        |--------------------------------------------------------------------------
        | Modules Mega Menu
        |--------------------------------------------------------------------------
        */

       [
    'title' => 'navigation.modules',
    'icon' => 'grid',

    'children' => [

        [
            'title' => 'navigation.human_resources',
            'icon' => 'users',
        ],

        [
            'title' => 'navigation.finance',
            'icon' => 'wallet',
        ],

        [
            'title' => 'navigation.project_management',
            'icon' => 'briefcase',
        ],

        [
            'title' => 'navigation.operations',
            'icon' => 'settings',
        ],

        [
            'title' => 'navigation.inventory',
            'icon' => 'boxes',
        ],

        [
            'title' => 'navigation.documents',
            'icon' => 'file-text',
        ],

        [
            'title' => 'navigation.analytics',
            'icon' => 'presentation',
        ],
        [
    'title' => 'navigation.crm',
    'icon'  => 'handshake',
],

[
    'title' => 'navigation.procurement',
    'icon'  => 'wallet',
],

[
    'title' => 'navigation.compliance',
    'icon'  => 'shield',
],
        
         
    ],

],


        /*
        |--------------------------------------------------------------------------
        | Solutions
        |--------------------------------------------------------------------------
        */


        [

            'title'=>'navigation.solutions',

            'icon'=>'pointer',


            'children'=>[


                [
                    'title'=>'navigation.ngos',
                    'icon'=>'heart'
                ],


                [
                    'title'=>'navigation.enterprise',
                    'icon'=>'building'
                ],


                [
                    'title'=>'navigation.government',
                    'icon'=>'library'
                ],


            ],


        ],




        /*
        |--------------------------------------------------------------------------
        | Resources
        |--------------------------------------------------------------------------
        */


        [

            'title'=>'navigation.resources',

            'icon'=>'book',


            'children'=>[


                [
                    'title'=>'navigation.documentation',
                    'icon'=>'file'
                ],


                [
                    'title'=>'navigation.blog',
                    'icon'=>'newspaper'
                ],


                [
                    'title'=>'navigation.academy',
                    'icon'=>'book'
                ],


            ],


        ],




        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */


        [

            'title'=>'navigation.company',

            'icon'=>'building2',


            'children'=>[


                [
                    'title'=>'navigation.about',
                    'icon'=>'info'
                ],


                [
                    'title'=>'navigation.careers',
                    'icon'=>'briefcase'
                ],


                [
                    'title'=>'navigation.contact',
                    'icon'=>'mail'
                ],


            ],


        ],


    ],


];