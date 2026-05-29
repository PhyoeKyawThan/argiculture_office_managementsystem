<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AgriculturalAnnouncement extends Model
{
    public const CATEGORY_NEWS = 'news';

    public const CATEGORY_WEATHER = 'weather_alert';

    public const CATEGORY_TIP = 'farming_tip';

    public const CATEGORIES = [
        self::CATEGORY_NEWS,
        self::CATEGORY_WEATHER,
        self::CATEGORY_TIP,
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'category',
        'featured_image_path',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $announcement) {
            if (blank($announcement->slug) && filled($announcement->title)) {
                $announcement->slug = static::uniqueSlug($announcement->title, $announcement->id);
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function featuredImageUrl(): ?string
    {
        if (! $this->featured_image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->featured_image_path);
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug ?: Str::random(8);
    }
}
