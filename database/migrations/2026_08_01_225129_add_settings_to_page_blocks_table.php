<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    /*
    |--------------------------------------------------------------------------
    | Add Settings Column To Page Blocks
    |--------------------------------------------------------------------------
    |
    | هر Block دو نوع داده دارد:
    |
    | data:
    |   محتوای اصلی Block
    |   مثل عنوان، متن، عکس، دکمه
    |
    | settings:
    |   تنظیمات طراحی Block
    |   مثل رنگ، padding، background، animation
    |
    |--------------------------------------------------------------------------
    */


    public function up(): void
    {
        Schema::table('page_blocks', function (Blueprint $table) {


            $table->json('settings')
                ->nullable()
                ->after('data');


        });
    }



    /*
    |--------------------------------------------------------------------------
    | Remove Settings Column
    |--------------------------------------------------------------------------
    */


    public function down(): void
    {
        Schema::table('page_blocks', function (Blueprint $table) {


            $table->dropColumn('settings');


        });
    }

};