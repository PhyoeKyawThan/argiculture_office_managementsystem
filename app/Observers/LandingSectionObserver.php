<?php

namespace App\Observers;

use App\Models\LandingSection;
use App\Models\LandingSectionLog;
use Illuminate\Support\Facades\Auth;

class LandingSectionObserver
{
    public function created(LandingSection $section): void
    {
        LandingSectionLog::create([
            'landing_section_id' => $section->id,
            'action' => 'created',
            'changes' => ['initial_data' => $section->only([
                'slug', 'type', 'title', 'subtitle', 'is_active',
            ])],
            'user_id' => Auth::id(),
        ]);
    }

    public function updated(LandingSection $section): void
    {
        $dirtyFields = $section->getDirty();

        if (empty($dirtyFields)) {
            return;
        }

        $changes = [];
        foreach ($dirtyFields as $field => $newValue) {
            if (in_array($field, ['updated_at', 'created_at'])) {
                continue;
            }

            $changes[$field] = [
                'old' => $section->getOriginal($field),
                'new' => $newValue,
            ];
        }

        LandingSectionLog::create([
            'landing_section_id' => $section->id,
            'action' => 'updated',
            'changes' => $changes,
            'user_id' => Auth::id(),
        ]);
    }

    public function deleting(LandingSection $section): void
    {
        LandingSectionLog::create([
            'landing_section_id' => $section->id,
            'action' => 'deleted',
            'changes' => ['slug' => $section->slug, 'type' => $section->type],
            'user_id' => Auth::id(),
        ]);
    }
}
