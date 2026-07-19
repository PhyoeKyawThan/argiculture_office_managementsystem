<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreFertilizerLicenseRequest;
use App\Http\Requests\Shop\UpdateFertilizerLicenseRequest;
use App\Models\FertilizerDistributionLicense;
use App\Models\User;
use App\Notifications\NewFertilizerLicenseNotification;
use App\Notifications\UpdateFertilizerLicenseNotification;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class FertilizerLicenseController extends Controller
{
    use HandlesFileUploads;

    public function create(): View
    {
        $latestLicense = auth()->user()
                ?->fertilizerDistributionLicenses()
            ->with('items')
            ->latest()
            ->first();

        return view('shop.fertilizer-licenses.apply', compact('latestLicense'));
    }

    public function store(StoreFertilizerLicenseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $frontPath = $this->uploadFile($request->file('attachment_nrc.front'), 'fertilizer-licenses/nrc');
        $backPath = $this->uploadFile($request->file('attachment_nrc.back'), 'fertilizer-licenses/nrc');
        $township_recommendation_letter = $this->uploadFile($request->file('township_recommendation_letter'), 'township_recommendation_letter');
        DB::transaction(function () use ($data, $frontPath, $backPath, $township_recommendation_letter, $request) {
            $license = FertilizerDistributionLicense::create([
                'user_id' => $request->user()?->id,
                'application_date' => $data['application_date'] ?? today()->toDateString(),
                'applicant_name' => $data['applicant_name'],
                'township' => $data['township'],
                'shop_name' => $data['shop_name'] ?? null,
                'nrc_number' => $data['nrc_number'],
                'education_level' => $data['education_level'] ?? null,
                'work_experience' => $request->boolean('work_experience'),
                'permanent_address' => $data['permanent_address'] ?? null,
                'distribution_location_address' => $data['distribution_location_address'] ?? null,
                'building_type' => $data['building_type'] ?? null,
                'building_dimensions' => $data['building_dimensions'] ?? null,
                'township_recommendation_letter' => $township_recommendation_letter,
                'attachment_nrc' => [
                    'front' => $frontPath,
                    'back' => $backPath,
                ],
                'status' => FertilizerDistributionLicense::STATUS_PENDING,
            ]);

            $license->items()->createMany(array_map(function (array $item) {
                return Arr::only($item, [
                    'fertilizer_name',
                    'chemical_formula',
                    'fertilizer_type',
                    'packaging_size',
                    'weight_volume',
                ]);
            }, $data['fertilizer_license_items']));
            $backOfficeUsers = User::query()
                ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
                ->get();

            Notification::send($backOfficeUsers, new NewFertilizerLicenseNotification($license));
        });
        return redirect()
            ->route('shop.dashboard')
            ->with('success', 'Fertilizer distribution license application submitted successfully.');
    }

    public function edit(FertilizerDistributionLicense $fertilizer_license): View
    {
        if ($fertilizer_license->user_id !== auth()->id()) {
            abort(403);
        }

        $fertilizer_license->load('items');
        $existingItems = $fertilizer_license->items->map(function ($i) {
            return [
                'fertilizer_name' => $i->fertilizer_name,
                'chemical_formula' => $i->chemical_formula,
                'fertilizer_type' => $i->fertilizer_type,
                'packaging_size' => $i->packaging_size,
                'weight_volume' => $i->weight_volume,
            ];
        });
        return view('shop.fertilizer-licenses.apply', [
            'latestLicense' => $fertilizer_license,
            'editing' => true,
            'existingItems' => $existingItems
        ]);
    }

    public function update(UpdateFertilizerLicenseRequest $request, FertilizerDistributionLicense $fertilizer_license): RedirectResponse
    {
        if ($fertilizer_license->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validated();

        $updateData = [
            'application_date' => $data['application_date'] ?? today()->toDateString(),
            'applicant_name' => $data['applicant_name'],
            'township' => $data['township'],
            'shop_name' => $data['shop_name'] ?? null,
            'nrc_number' => $data['nrc_number'],
            'education_level' => $data['education_level'] ?? null,
            'work_experience' => $request->boolean('work_experience'),
            'permanent_address' => $data['permanent_address'] ?? null,
            'distribution_location_address' => $data['distribution_location_address'] ?? null,
            'building_type' => $data['building_type'] ?? null,
            'building_dimensions' => $data['building_dimensions'] ?? null,
            'status' => FertilizerDistributionLicense::STATUS_PENDING,
        ];

        if ($request->hasFile('attachment_nrc.front')) {
            if (!empty($fertilizer_license->attachment_nrc['front'])) {
                $this->deleteFile($fertilizer_license->attachment_nrc['front']);
            }
            $updateData['attachment_nrc'] = array_merge($fertilizer_license->attachment_nrc ?? [], [
                'front' => $this->uploadFile($request->file('attachment_nrc.front'), 'fertilizer-licenses/nrc'),
            ]);
        }

        if ($request->hasFile('attachment_nrc.back')) {
            if (!empty($fertilizer_license->attachment_nrc['back'])) {
                $this->deleteFile($fertilizer_license->attachment_nrc['back']);
            }
            $updateData['attachment_nrc'] = array_merge($fertilizer_license->attachment_nrc ?? [], [
                'back' => $this->uploadFile($request->file('attachment_nrc.back'), 'fertilizer-licenses/nrc'),
            ]);
        }

        if ($request->hasFile('township_recommendation_letter')) {
            if (!empty($fertilizer_license->township_recommendation_letter)) {
                $this->deleteFile($fertilizer_license->township_recommendation_letter);
            }
            $updateData['township_recommendation_letter'] = $this->uploadFile($request->file('township_recommendation_letter'), 'township_recommendation_letter');
        }

        DB::transaction(function () use ($fertilizer_license, $data, $updateData) {
            $fertilizer_license->update($updateData);

            $fertilizer_license->items()->delete();
            $fertilizer_license->items()->createMany(array_map(function (array $item) {
                return Arr::only($item, [
                    'fertilizer_name',
                    'chemical_formula',
                    'fertilizer_type',
                    'packaging_size',
                    'weight_volume',
                ]);
            }, $data['fertilizer_license_items']));
        });

        $backOfficeUsers = User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->get();

        Notification::send($backOfficeUsers, new UpdateFertilizerLicenseNotification($fertilizer_license));

        return redirect()
            ->route('shop.dashboard')
            ->with('success', 'Fertilizer distribution license application updated successfully.');
    }
}