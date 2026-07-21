<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFeatureSettingsRequest;
use App\Models\Category;
use App\Models\FeatureSetting;
use App\Support\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureSettingController extends Controller
{
    public function edit(): View
    {
        $settings = FeatureSetting::query()
            ->whereIn('key', Feature::keys())
            ->orderBy('key')
            ->get()
            ->keyBy('key');

        $contentCategories = Category::whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.feature-settings.edit', compact('settings', 'contentCategories'));
    }

    public function update(UpdateFeatureSettingsRequest $request): RedirectResponse
    {
        foreach (Feature::keys() as $key) {
            FeatureSetting::query()->updateOrCreate(
                ['key' => $key],
                ['is_enabled' => $request->boolean('features.'.$key)]
            );
        }

        Feature::flush();

        return redirect()
            ->route('admin.feature-settings.edit')
            ->with('success', __('messages.flash.feature_settings_updated'));
    }
}
