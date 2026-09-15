<?php

return [

    'title' => 'راجستر',

    'heading' => 'حساب جوړول',

    'actions' => [

        'login' => [
            'before' => 'یا',
            'label' => 'خپل حساب ته ننوتل',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'بریښنالیک پته',
        ],

        'name' => [
            'label' => 'نوم',
        ],

        'password' => [
            'label' => 'پټنوم',
            'validation_attribute' => 'پټنوم',
        ],

        'password_confirmation' => [
            'label' => 'د پټنوم تائید',
        ],

        'actions' => [

            'register' => [
                'label' => 'ثبت نام',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'د ثبت نام هڅې ډېرې شوې',
            'body' => 'مهرباني وکړئ په :seconds ثانیو کې بیا هڅه وکړئ.',
        ],

    ],

];
