<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_delegation_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('security_delegation_id')
                ->constrained('security_delegations')
                ->cascadeOnDelete();

            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['security_delegation_id', 'permission_id'],
                'security_delegation_permission_unique'
            );

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_delegation_permissions');
    }
};