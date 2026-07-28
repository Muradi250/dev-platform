<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Page extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | ستون‌هایی که اجازه ذخیره دارند
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'title',

        'slug',

        'status',

        'locale',

        'seo_title',

        'seo_description',

        'created_by',

        'published_at',

    ];



    /*
    |--------------------------------------------------------------------------
    | تبدیل خودکار داده‌ها
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'published_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | رابطه با Block ها
    |--------------------------------------------------------------------------
    |
    | هر Page چند Block دارد.
    |
    | مثال:
    |
    | Home Page
    |   |
    |   ├── Hero
    |   ├── Services
    |   └── FAQ
    |
    */

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class)
                    ->orderBy('sort_order');
    }



    /*
    |--------------------------------------------------------------------------
    | سازنده صفحه
    |--------------------------------------------------------------------------
    |
    | هر صفحه توسط یک User ساخته می‌شود.
    |
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}