<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'name_mm', 'slug', 'parent_id', 'level'];

    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->parent_id) {
                $parent = Category::findOrFail($category->parent_id);
                if ($parent->level >= 5) {
                    throw new \Exception("Hierarchy depth limit of 5 exceeded.");
                }
                $category->level = $parent->level + 1;
            } else {
                $category->level = 1;
            }
        });
    }
    public function getPathAttribute()
    {
        return $this->parent ? $this->parent->path . ' > ' . $this->name : $this->name;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}