<?php

namespace App\Observers;

use App\Models\Staff;
use App\Models\StaffLog;
use Illuminate\Support\Facades\Auth;

class StaffObserver
{
    /**
     * Handle the Staff "created" event.
     */
    public function created(Staff $staff): void
    {
        StaffLog::create([
            'staff_id' => $staff->id,
            'action' => 'created',
            'changes' => ['initial_data' => $staff->only(['personal_no', 'name', 'current_position', 'current_branch'])],
            'user_id' => Auth::id(), // Tracks who logged it
        ]);
    }

    /**
     * Handle the Staff "updated" event.
     */
    public function updated(Staff $staff): void
    {
        $dirtyFields = $staff->getDirty();
        
        if (empty($dirtyFields)) {
            return;
        }

        $changes = [];
        foreach ($dirtyFields as $field => $newValue) {
            if (in_array($field, ['updated_at', 'created_at'])) continue;

            $changes[$field] = [
                'old' => $staff->getOriginal($field),
                'new' => $newValue
            ];
        }
        $action = 'updated_profile';
        
        if (array_key_exists('current_position', $changes)) {
            $action = 'promoted_demoted';
        } elseif (array_intersect_key(array_flip(['current_region', 'current_office', 'current_branch']), $changes)) {
            $action = 'transferred';
        }

        StaffLog::create([
            'staff_id' => $staff->id,
            'action' => $action,
            'changes' => $changes,
            'user_id' => Auth::id(),
        ]);
    }

    public function deleting(Staff $staff): void
    {
        StaffLog::create([
            'staff_id' => $staff->id,
            'action' => 'deleted',
            'changes' => $staff->only(['personal_no', 'name', 'current_position', 'current_branch']),
            'user_id' => Auth::id(),
        ]);
    }
}