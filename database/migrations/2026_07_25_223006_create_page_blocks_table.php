<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ساخت جدول بخش‌های صفحات Public Site
     *
     * هر صفحه از چند Block تشکیل می‌شود.
     *
     * مثال:
     *
     * Home Page
     *
     *  |
     *  |-- Hero Block
     *  |-- Services Block
     *  |-- Team Block
     *  |-- FAQ Block
     *
     */
    public function up(): void
    {
        Schema::create('page_blocks', function (Blueprint $table) {


            // شناسه اصلی Block
            $table->id();



            /*
             |------------------------------------------------------------
             | ارتباط با صفحه اصلی
             |------------------------------------------------------------
             |
             | هر Block متعلق به یک Page است.
             |
             | مثال:
             |
             | page_id = 1
             |
             | یعنی این Block برای صفحه Home است.
             |
             */

            $table->foreignId('page_id')
                  ->constrained()
                  ->cascadeOnDelete();



            /*
             |------------------------------------------------------------
             | نوع Block
             |------------------------------------------------------------
             |
             | مشخص می‌کند این بخش چه چیزی است.
             |
             | مثال:
             |
             | hero
             | services
             | team
             | faq
             |
             */

            $table->string('type');



            /*
             |------------------------------------------------------------
             | اطلاعات Block
             |------------------------------------------------------------
             |
             | اطلاعات هر Block به صورت JSON ذخیره می‌شود.
             |
             | مثال Hero:
             |
             | {
             |   "title":"Welcome",
             |   "description":"Business Platform",
             |   "button":"Start Now"
             | }
             |
             */

            $table->json('data');



            /*
             |------------------------------------------------------------
             | ترتیب نمایش
             |------------------------------------------------------------
             |
             | مدیر سایت می‌تواند ترتیب بخش‌ها را تغییر دهد.
             |
             | مثال:
             |
             | 1 - Hero
             | 2 - Services
             | 3 - Team
             |
             */

            $table->integer('sort_order')
                  ->default(0);



            /*
             |------------------------------------------------------------
             | فعال یا غیرفعال بودن Block
             |------------------------------------------------------------
             |
             | بدون حذف کردن Block می‌توان آن را مخفی کرد.
             |
             */

            $table->boolean('is_active')
                  ->default(true);



            // created_at و updated_at
            $table->timestamps();

        });
    }


    /**
     * حذف جدول هنگام rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('page_blocks');
    }
};