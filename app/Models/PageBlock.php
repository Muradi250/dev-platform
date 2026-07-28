<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PageBlock extends Model
{
    use HasFactory;



    /*
    |--------------------------------------------------------------------------
    | ستون‌های قابل ذخیره
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'page_id',

        'type',

        'data',

        'sort_order',

        'is_active',

    ];



    /*
    |--------------------------------------------------------------------------
    | تبدیل داده‌ها
    |--------------------------------------------------------------------------
    |
    | data در دیتابیس JSON است.
    | Laravel آن را به Array تبدیل می‌کند.
    |
    */

    protected $casts = [

        'data' => 'array',

        'is_active' => 'boolean',

    ];



    /*
    |--------------------------------------------------------------------------
    | ارتباط با Page
    |--------------------------------------------------------------------------
    |
    | هر Block متعلق به یک Page است.
    |
    */

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

}