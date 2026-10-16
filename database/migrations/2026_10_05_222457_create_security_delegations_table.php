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
        Schema::create('security_delegations', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Delegation Chain
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delegated_by_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('delegated_to_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('parent_delegation_id')
                ->nullable()
                ->constrained('security_delegations')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Organization Context
            |--------------------------------------------------------------------------
            */

            $table->foreignId('organization_id')
                ->nullable()
                ->constrained('organizations')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delegation State
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('active')
                ->index();

            /*
            |--------------------------------------------------------------------------
            | Validity
            |--------------------------------------------------------------------------
            */

            $table->timestamp('starts_at')
                ->nullable();

            $table->timestamp('expires_at')
                ->nullable();

            $table->timestamp('revoked_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit / Explanation
            |--------------------------------------------------------------------------
            */

            $table->text('reason')
                ->nullable();

            $table->json('metadata')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Storage Engine
            |--------------------------------------------------------------------------
            */

            $table->engine = 'InnoDB';

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'delegated_by_user_id',
                'status',
            ]);

            $table->index([
                'delegated_to_user_id',
                'status',
            ]);

            $table->index([
                'organization_id',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_delegations');
    }
};
