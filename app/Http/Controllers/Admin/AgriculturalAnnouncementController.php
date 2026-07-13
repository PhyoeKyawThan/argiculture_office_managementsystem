<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgriculturalAnnouncementRequest;
use App\Http\Requests\Admin\UpdateAgriculturalAnnouncementRequest;
use App\Models\AgriculturalAnnouncement;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AgriculturalAnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $announcements = AgriculturalAnnouncement::query()
            ->with(['author:id,name', 'category:id,name,name_mm'])
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('published'), function ($query) use ($request) {
                if ($request->string('published') === 'yes') {
                    $query->where('is_published', true);
                } elseif ($request->string('published') === 'no') {
                    $query->where('is_published', false);
                }
            })
            ->latest('published_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('level')->get();
        return view('admin.announcements.create', compact('categories'));
    }

    public function store(StoreAgriculturalAnnouncementRequest $request): RedirectResponse
    {
        $data = $this->payloadFromRequest($request);
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('featured_image')) {
            $data['featured_image_path'] = $request->file('featured_image')->store('announcements', 'public');
        }

        $announcement = AgriculturalAnnouncement::create($data);

        return redirect()->route('admin.announcements.edit', $announcement)
            ->with('success', __('messages.flash.announcement_created'));
    }

    public function edit(AgriculturalAnnouncement $announcement): View
    {
        $categories = Category::orderBy('level')->get();
        return view('admin.announcements.edit', compact('announcement', 'categories'));
    }

    public function update(UpdateAgriculturalAnnouncementRequest $request, AgriculturalAnnouncement $announcement): RedirectResponse
    {
        $data = $this->payloadFromRequest($request, $announcement);

        if ($request->boolean('remove_featured_image') && $announcement->featured_image_path) {
            Storage::disk('public')->delete($announcement->featured_image_path);
            $data['featured_image_path'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($announcement->featured_image_path) {
                Storage::disk('public')->delete($announcement->featured_image_path);
            }
            $data['featured_image_path'] = $request->file('featured_image')->store('announcements', 'public');
        }

        $announcement->update($data);
        return redirect()->route('admin.announcements.index')
            ->with('success', __('messages.flash.announcement_updated'));
    }

    public function destroy(AgriculturalAnnouncement $announcement): RedirectResponse
    {
        if ($announcement->featured_image_path) {
            Storage::disk('public')->delete($announcement->featured_image_path);
        }
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
            ->with('success', __('messages.flash.announcement_deleted'));
    }

    private function payloadFromRequest($request, ?AgriculturalAnnouncement $announcement = null): array
    {
        $data = $request->safe()->only(['title', 'slug', 'content', 'category_id', 'published_at']);
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && empty($data['published_at'])) $data['published_at'] = now();
        if (! $data['is_published']) $data['published_at'] = $data['published_at'] ?? null;
        if (blank($data['slug'] ?? null) && filled($data['title'])) {
            $data['slug'] = AgriculturalAnnouncement::uniqueSlug($data['title'], $announcement?->id);
        }
        return $data;
    }
}