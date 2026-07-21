<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Http\Requests\Admin\UpdateStaffRequest;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $staff = Staff::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->string('search') . '%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('name', 'like', $term)
                        ->orWhere('personal_no', 'like', $term);
                });
            })
            ->when($request->filled('region'), fn ($q) => $q->where('current_region', $request->string('region')))
            ->when($request->filled('office'), fn ($q) => $q->where('current_office', 'like', '%' . $request->string('office') . '%'))
            ->orderBy('personal_no')
            ->paginate(15)
            ->withQueryString();

        $regions = Staff::query()->distinct()->orderBy('current_region')->pluck('current_region');

        return view('admin.staff.index', compact('staff', 'regions'));
    }

    public function create(): View
    {
        return view('admin.staff.create');
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $staff = Staff::create($request->validated());

        return redirect()
            ->route('admin.staff.show', $staff)
            ->with('success', __('messages.flash.staff_created'));
    }

    public function show(Request $request, Staff $staff): View
    {
        $staff->load(['logs' => function ($query) use ($request) {
            $query->with('modifier')->latest();

            if ($request->filled('log_from')) {
                $query->whereDate('created_at', '>=', $request->date('log_from'));
            }

            if ($request->filled('log_to')) {
                $query->whereDate('created_at', '<=', $request->date('log_to'));
            }
        }]);

        return view('admin.staff.show', [
            'staff' => $staff,
            'logFrom' => $request->input('log_from'),
            'logTo' => $request->input('log_to'),
        ]);
    }

    public function edit(Staff $staff): View
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(UpdateStaffRequest $request, Staff $staff): RedirectResponse
    {
        $staff->update($request->validated());

        return redirect()
            ->route('admin.staff.show', $staff)
            ->with('success', __('messages.flash.staff_updated'));
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, __('messages.errors.staff_delete_forbidden'));
        }

        $staff->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', __('messages.flash.staff_deleted'));
    }
}
