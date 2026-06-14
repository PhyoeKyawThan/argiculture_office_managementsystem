<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use App\Models\LandingSection;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        return view('landing.index', [
            'hero' => LandingSection::activeByType('hero')->first(),
            'features' => LandingSection::activeByType('feature'),
            'stats' => LandingSection::activeByType('stat'),
            'cta' => LandingSection::activeByType('cta')->first(),
            'footer' => LandingSection::activeByType('footer')->first(),
            'latestNews' => AgriculturalAnnouncement::published()
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
