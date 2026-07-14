<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'name_mm', 'slug', 'parent_id', 'level'];
    protected $appends = ['children_count'];
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
        if ($this->parent_id && !$this->relationLoaded('parent')) {
            $this->load('parent');
        }

        $name = config('app.locale') === 'en' ? $this->name : $this->name_mm;

        return $this->parent
            ? $this->parent->path . ' > ' . $name
            : $name;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function scopeWithRecursiveParents($query)
    {
        return $query->with('parent.parent.parent.parent');
    }

    public static function toTree()
    {
        return static::all()->groupBy('parent_id');
    }

    // public static function buildTree($categories, $parentId = null)
    // {
    //     $branch = collect();
    //     foreach ($categories as $category) {
    //         if ($category->parent_id == $parentId) {
    //             $children = static::buildTree($categories, $category->id);
    //             $category->setRelation('children', $children);
    //             $branch->push($category);
    //         }
    //     }
    //     return $branch;
    // }
    public static function buildTree($categories, $parentId = null)
    {
        $branch = collect();
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $children = static::buildTree($categories, $category->id);
                $category->setRelation('children', $children);
                $branch->push($category);
            }
        }
        return $branch;
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function getChildrenCountAttribute()
    {
        if ($this->relationLoaded('children')) {
            return $this->children->count();
        }
        return $this->children_count ?? 0;
    }
    public function getAllDescendantsAttribute()
    {
        $descendants = collect();
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendantsAttribute());
        }
        return $descendants;
    }
}