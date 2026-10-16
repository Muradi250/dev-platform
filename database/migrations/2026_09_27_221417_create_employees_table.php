<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Organization
            |--------------------------------------------------------------------------
            */

            $table->foreignId('organization_id');

            /*
            |--------------------------------------------------------------------------
            | User Account
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Organizational Unit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('organizational_unit_id');

            /*
            |--------------------------------------------------------------------------
            | Employee Identity
            |--------------------------------------------------------------------------
            */

            $table->string('employee_number', 50);

            $table->string('first_name');

            $table->string('last_name');

            /*
            |--------------------------------------------------------------------------
            | Employment
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('active')
                ->index();

            $table->string('job_title')
                ->nullable();

            $table->string('employment_type', 30)
                ->default('full_time');

            /*
            |--------------------------------------------------------------------------
            | Employment Dates
            |--------------------------------------------------------------------------
            */

            $table->date('joined_at')
                ->nullable();

            $table->date('ended_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Extensible Settings
            |--------------------------------------------------------------------------
            */

            $table->json('settings')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Indexes & Constraints
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'organization_id',
                'employee_number',
            ]);

            $table->index([
                'organization_id',
                'organizational_unit_id',
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};