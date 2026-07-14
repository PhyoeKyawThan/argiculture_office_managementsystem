<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->query('category');

        $announcements = AgriculturalAnnouncement::published()
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->inCategory($categorySlug);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $allCategories = Category::with('children')->get();
        $categories = Category::buildTree($allCategories, null);
        $category = Category::get()->where('slug', '=', $categorySlug)->first();
        $module = config('app.locale') === 'en' ? $category->name : $category->name_mm;
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
        $announcement->load('author:id,name');
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('news.show', compact('announcement', 'categories'));
    }
}