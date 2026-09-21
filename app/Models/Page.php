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

        'translation_group',

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


    /*
    |--------------------------------------------------------------------------
    | Translations
    |--------------------------------------------------------------------------
    |
    | تمام Pageهایی که متعلق به همین Translation Group هستند.
    |
    */

    public function translations(): HasMany
    {
        return $this->hasMany(
            Page::class,
            'translation_group',
            'translation_group'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Translation Helper
    |--------------------------------------------------------------------------
    |
    | یک Translation مشخص را بر اساس Locale پیدا می‌کند.
    |
    */

    public function translation(string $locale): ?Page
    {
        if (empty($this->translation_group)) {
            return null;
        }

        return $this->translations()
            ->where('locale', $locale)
            ->where('id', '!=', $this->id)
            ->first();
    }
}
