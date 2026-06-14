<?php

namespace App\Http\Controllers;

use App\Models\AgriculturalAnnouncement;
use App\Support\AgriculturalContentCatalog;
use App\Support\Feature;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $module = $request->string('module')->toString() ?: AgriculturalContentCatalog::MODULE_NEWS;

        abort_unless(AgriculturalContentCatalog::isValidModule($module), 404);
        abort_unless(Feature::enabled(AgriculturalContentCatalog::featureKeyForModule($module)), 404);

        $subType = $request->string('sub_type')->toString() ?: null;

        if ($subType && ! AgriculturalContentCatalog::isValidSubType($module, $subType)) {
            abort(404);
        }

        $announcements = AgriculturalAnnouncement::published()
            ->forModule($module)
            ->when($subType, fn ($q) => $q->forSubType($subType))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $enabledModules = AgriculturalContentCatalog::enabledModules();

        return view('news.index', compact('announcements', 'module', 'subType', 'enabledModules'));
    }

    public function show(AgriculturalAnnouncement $announcement): View
    {
        abort_unless(
            $announcement->is_published
            && $announcement->published_at
            && $announcement->published_at->lte(now()),
            404
        );

        abort_unless(Feature::enabled(AgriculturalContentCatalog::featureKeyForModule($announcement->module)), 404);

        $announcement->load('author:id,name');
        $enabledModules = AgriculturalContentCatalog::enabledModules();

        return view('news.show', compact('announcement', 'enabledModules'));
    }
}
