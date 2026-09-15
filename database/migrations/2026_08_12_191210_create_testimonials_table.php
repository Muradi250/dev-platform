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
        Schema::create('testimonials', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Customer Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('avatar')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Testimonial Content
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('message');

            /*
            |--------------------------------------------------------------------------
            | Moderation
            |--------------------------------------------------------------------------
            |
            | pending  = Waiting for admin review
            | approved = Published on website
            | rejected = Rejected by admin
            |
            */

            $table->string('status')
                ->default('pending')
                ->index();

            $table->boolean('featured')
                ->default(false)
                ->index();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Language
            |--------------------------------------------------------------------------
            |
            | en = English
            | fa = Persian
            | ps = Pashto
            |
            */

            $table->string('locale', 5)
                ->default('en')
                ->index();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};