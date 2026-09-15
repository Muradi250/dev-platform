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
    | Fillable Fields
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

        'settings',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    |
    | settings از JSON دیتابیس به Array تبدیل می‌شود.
    |
    */

    protected $casts = [

        'published_at' => 'datetime',

        'settings' => 'array',

    ];


    /*
    |--------------------------------------------------------------------------
    | Page Blocks
    |--------------------------------------------------------------------------
    |
    | هر Page می‌تواند چندین Block داشته باشد.
    |
    */

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class)
                    ->orderBy('sort_order');
    }


    /*
    |--------------------------------------------------------------------------
    | Page Creator
    |--------------------------------------------------------------------------
    |
    | مشخص می‌کند این Page توسط کدام User ساخته شده است.
    |
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}