<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Add System Owner Flag
    |--------------------------------------------------------------------------
    |
    | این ستون مشخص می‌کند که آیا کاربر مالک اصلی سیستم است یا خیر.
    |
    | فقط یک کاربر باید مقدار true داشته باشد.
    |
    | Owner از تمام Roleها بالاتر است.
    |
    */

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | System Owner
            |--------------------------------------------------------------------------
            |
            | false = کاربر عادی
            | true  = مالک سیستم
            |
            */

            $table->boolean('is_owner')
                  ->default(false)
                  ->after('status');

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Rollback
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('is_owner');

        });
    }
};