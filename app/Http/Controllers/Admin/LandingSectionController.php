<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLandingSectionRequest;
use App\Http\Requests\Admin\UpdateLandingSectionRequest;
use App\Models\LandingSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingSectionController extends Controller
{
    public function index(Request $request): View
    {
        $sections = LandingSection::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->orderBy('type')
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.landing-sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.landing-sections.create');
    }

    public function store(StoreLandingSectionRequest $request): RedirectResponse
    {
        LandingSection::create($request->validated());

        return redirect()
            ->route('admin.landing-sections.index')
            ->with('success', __('messages.flash.landing_created'));
    }

    public function edit(LandingSection $landing_section): View
    {
        return view('admin.landing-sections.edit', ['section' => $landing_section]);
    }

    public function update(UpdateLandingSectionRequest $request, LandingSection $landing_section): RedirectResponse
    {
        $landing_section->update($request->validated());

        return redirect()
            ->route('admin.landing-sections.index')
            ->with('success', __('messages.flash.landing_updated'));
    }

    public function destroy(LandingSection $landing_section): RedirectResponse
    {
        $landing_section->delete();

        return redirect()
            ->route('admin.landing-sections.index')
            ->with('success', __('messages.flash.landing_deleted'));
    }
}
