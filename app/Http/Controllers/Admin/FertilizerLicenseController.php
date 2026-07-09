<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFertilizerLicenseStatusRequest;
use App\Models\FertilizerDistributionLicense;
use App\Notifications\LicenseStatusUpdatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FertilizerLicenseController extends Controller
{
    public function index(Request $request): View
    {
        $licenses = FertilizerDistributionLicense::query()
            ->with(['user:id,name,email', 'items'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->string('search') . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('applicant_name', 'like', $term)
                        ->orWhere('shop_name', 'like', $term)
                        ->orWhere('nrc_number', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.fertilizer-licenses.index', compact('licenses'));
    }

    public function show(FertilizerDistributionLicense $fertilizer_license): View
    {
        $fertilizer_license->load(['user:id,name,email', 'items']);

        return view('admin.fertilizer-licenses.show', [
            'license' => $fertilizer_license,
        ]);
    }

    public function updateStatus(UpdateFertilizerLicenseStatusRequest $request, FertilizerDistributionLicense $fertilizer_license): RedirectResponse
    {
        $previousStatus = $fertilizer_license->status;
        $newStatus = $request->string('status')->toString();

        $fertilizer_license->update([
            'status' => $newStatus,
        ]);

        if (
            in_array($previousStatus, [FertilizerDistributionLicense::STATUS_PENDING, FertilizerDistributionLicense::STATUS_ALLOWED], true)
            && in_array($newStatus, [FertilizerDistributionLicense::STATUS_SENDING_TO_REGIONAL_DEPARTMENT, FertilizerDistributionLicense::STATUS_CANCELLED], true)
            && $fertilizer_license->user
        ) {
            $fertilizer_license->user->notify(new LicenseStatusUpdatedNotification($fertilizer_license, $previousStatus));
        }

        return back()->with('success', 'Fertilizer license status updated successfully.');
    }
}