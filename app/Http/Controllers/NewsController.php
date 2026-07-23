<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use App\Models\Category;
use App\Support\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request, $categorySlug = null): View
    {
        $category = null;

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                abort(404);
            }

            $module = str_replace('-', '_', $category->slug);
            if (!Feature::enabled('content_' . $module)) {
                abort(404);
            }
        }

        $announcements = AgriculturalAnnouncement::published()
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->inCategory($categorySlug);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $allCategories = Category::with('children')->get();
        $categories = Category::buildTree($allCategories, null);

        $module = $category 
            ? (config('app.locale') === 'en' ? $category->name : $category->name_mm) 
            : __('messages.nav.news');

        return view('news.index', compact('announcements', 'categories', 'categorySlug', 'module'));
    }

    public function show(AgriculturalAnnouncement $announcement): View
    {
        abort_unless(
            $announcement->is_published
            && $announcement->published_at
            && $announcement->published_at->lte(now()),
            404
        );

        $announcement->load('category.parent.parent.parent');
        $category = $announcement->category;

        while ($category && $category->parent_id) {
            $category = $category->parent;
        }

        if ($category) {
            $module = str_replace('-', '_', $category->slug);
            abort_unless(Feature::enabled('content_' . $module), 404);
        }

        $announcement->load('author:id,name');
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('news.show', compact('announcement', 'categories'));
    }
}