/*
|--------------------------------------------------------------------------
| Tailwind CSS Configuration
|--------------------------------------------------------------------------
|
| Tailwind CSS v3.4.19
|
|--------------------------------------------------------------------------
*/


/** @type {import('tailwindcss').Config} */

export default {


    content: [


        './resources/views/**/*.blade.php',

        './resources/js/**/*.js',

        './app/**/*.php',


    ],



    theme: {


        extend: {



            fontFamily: {


                sans: [


                    'Figtree',


                    'ui-sans-serif',


                    'system-ui',


                ],


            },


        },


    },



    plugins: [],


};