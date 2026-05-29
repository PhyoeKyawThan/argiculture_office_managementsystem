<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $announcements = AgriculturalAnnouncement::published()
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('announcements'));
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

        return view('news.show', compact('announcement'));
    }
}
