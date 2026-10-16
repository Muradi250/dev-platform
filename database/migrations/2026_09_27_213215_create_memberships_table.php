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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id');

            $table->foreignId('organization_id');

            /*
            |--------------------------------------------------------------------------
            | Membership State
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('active')
                ->index();

            $table->timestamp('joined_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Constraints
            |--------------------------------------------------------------------------
            |
            | A user can have only one membership record per organization.
            |
            */

            $table->unique([
                'user_id',
                'organization_id',
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};