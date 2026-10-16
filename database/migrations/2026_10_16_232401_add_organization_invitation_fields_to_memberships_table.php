<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();

            $table->string('invite_email')->nullable();
            $table->string('role', 30)->default('member');
            $table->string('invitation_token_hash', 64)->nullable()->unique();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('invitation_expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();

            $table->unique(['organization_id', 'invite_email']);
        });
    }

    public function down(): void
    {
        if (DB::table('memberships')->whereNull('user_id')->exists()) {
            throw new RuntimeException(
                'Cannot roll back organization invitations while invited memberships have no user account.'
            );
        }

        Schema::table('memberships', function (Blueprint $table) {
            $table->dropUnique(['organization_id', 'invite_email']);
            $table->dropUnique(['invitation_token_hash']);
            $table->dropColumn([
                'invite_email',
                'role',
                'invitation_token_hash',
                'invited_at',
                'invitation_expires_at',
                'accepted_at',
            ]);

            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
