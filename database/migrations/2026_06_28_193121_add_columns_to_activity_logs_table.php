<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('action');

            $table->text('description')->nullable();

            $table->string('model_type')->nullable();

            $table->unsignedBigInteger('model_id')->nullable();

            $table->string('ip_address')->nullable();

            $table->text('user_agent')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'action',
                'description',
                'model_type',
                'model_id',
                'ip_address',
                'user_agent',
            ]);

        });
    }
};