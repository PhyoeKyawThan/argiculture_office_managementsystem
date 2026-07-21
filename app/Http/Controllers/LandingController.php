<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use App\Models\Category;
use App\Models\LandingSection;
use App\Support\Feature;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $newsCategory = Category::where('slug', 'news')->first();

        return view('landing.index', [
            'hero' => LandingSection::activeByType('hero')->first(),
            'features' => LandingSection::activeByType('feature'),
            'stats' => LandingSection::activeByType('stat'),
            'cta' => LandingSection::activeByType('cta')->first(),
            'footer' => LandingSection::activeByType('footer')->first(),
            'latestNews' => Feature::enabled('content_news') && $newsCategory
                ? AgriculturalAnnouncement::published()
                    ->where('category_id', $newsCategory->id)
                    ->latest('published_at')
                    ->limit(3)
                    ->get()
                : collect(),
            'categories' => Category::with('children')->whereNull('parent_id')->get(),
        ]);
    }
}
