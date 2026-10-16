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
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Organization
            |--------------------------------------------------------------------------
            |
            | Every organizational unit belongs to one organization.
            |
            */

            $table->foreignId('organization_id');

            /*
            |--------------------------------------------------------------------------
            | Hierarchy
            |--------------------------------------------------------------------------
            |
            | parent_id allows organizational units to form a hierarchical
            | structure such as:
            |
            | Finance
            | ├── Accounting
            | └── Accounts Payable
            |
            */

            $table->foreignId('parent_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Identity
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('code', 50);

            /*
            |--------------------------------------------------------------------------
            | Classification
            |--------------------------------------------------------------------------
            |
            | Examples:
            | department, division, team, branch, section
            |
            */

            $table->string('type', 50)
                ->default('department');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('active')
                ->index();

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
            |
            | Future organizational-unit configuration can be stored here
            | without continuously changing the core schema.
            |
            */

            $table->json('settings')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes & Constraints
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'organization_id',
                'code',
            ]);

            $table->index([
                'organization_id',
                'parent_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizational_units');
    }
};
