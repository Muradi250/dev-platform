<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizational_units', function (Blueprint $table) {
            $table->string('head_name')->nullable();
            $table->string('head_email')->nullable();
            $table->string('head_phone', 50)->nullable();
            $table->string('location')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('organizational_units', function (Blueprint $table) {
            $table->dropColumn([
                'head_name',
                'head_email',
                'head_phone',
                'location',
                'effective_from',
                'effective_until',
            ]);
        });
    }
};
