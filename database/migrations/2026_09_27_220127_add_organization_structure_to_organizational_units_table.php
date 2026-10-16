<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The organizational_units table is created with this structure by
        // the preceding create_organizational_units_table migration.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The table is owned by create_organizational_units_table.
    }
};
