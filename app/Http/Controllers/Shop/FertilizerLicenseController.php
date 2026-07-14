<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreFertilizerLicenseRequest;
use App\Models\FertilizerDistributionLicense;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        });

        return redirect()
            ->route('shop.dashboard')
            ->with('success', 'Fertilizer distribution license application submitted successfully.');
    }
}