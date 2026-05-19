<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingSection extends Model
{
    protected $fillable = [
        'slug',
        'type',
        'title',
        'subtitle',
        'body',
        'icon',
        'link_url',
        'link_label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(LandingSectionLog::class);
    }

    public static function activeByType(string $type)
    {
        return static::query()
            ->where('type', $type)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
