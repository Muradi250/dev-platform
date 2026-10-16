<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add metadata fields to activity logs.
     */
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('category', 100)->nullable();
            $table->string('severity', 30)->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('module', 100)->nullable();
            $table->json('context')->nullable();
        });
    }

    /**
     * Remove only the fields introduced by this migration.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'severity',
                'icon',
                'module',
                'context',
            ]);
        });
    }
};