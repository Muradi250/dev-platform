<?php

return [

    'title' => 'ننوتل',

    'heading' => 'ننوتل',

    'actions' => [

        'register' => [
            'before' => 'یا',
            'label' => 'د حساب لپاره نوم لیکنه',
        ],

        'request_password_reset' => [
            'label' => 'پټنوم مو هېر شوی؟',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'بریښنالیک پته',
        ],

        'password' => [
            'label' => 'پټنوم',
        ],

        'remember' => [
            'label' => 'ما یاد وساته',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'ننوتل',
            ],

        ],

    ],

    'multi_factor' => [

        'heading' => 'خپل هویت تایید کړئ',

        'subheading' => 'د ننوتلو د دوام لپاره، خپل هویت تایید کړئ.',

        'form' => [

            'provider' => [
                'label' => 'څنګه غواړئ تایید وکړئ؟',
            ],

            'actions' => [

                'authenticate' => [
                    'label' => 'ننوتل تایید کړئ',
                ],

            ],

        ],

    ],

    'messages' => [

        'failed' => 'دا معلومات زموږ له ریکارډونو سره سمون نه خوري.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'د ننوتلو هڅې ډېرې شوې',
            'body' => 'مهرباني وکړئ په :seconds ثانیو کې بیا هڅه وکړئ.',
        ],

    ],

];
