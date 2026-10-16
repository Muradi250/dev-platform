<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('legal_type', 50)->nullable();
            $table->string('registration_number', 100)->nullable();
            $table->string('tax_id', 100)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 30)->nullable();
            $table->string('primary_contact_name')->nullable();
            $table->string('primary_contact_email')->nullable();
            $table->string('primary_contact_phone', 50)->nullable();
            $table->string('timezone', 64)->default('UTC');
            $table->char('currency', 3)->default('USD');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'legal_type',
                'registration_number',
                'tax_id',
                'address_line_1',
                'address_line_2',
                'country',
                'region',
                'city',
                'postal_code',
                'primary_contact_name',
                'primary_contact_email',
                'primary_contact_phone',
                'timezone',
                'currency',
            ]);
        });
    }
};
