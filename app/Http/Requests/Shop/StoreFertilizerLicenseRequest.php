<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreFertilizerLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isShop() ?? false;
    }

    public function rules(): array
    {
        return [
            'application_date' => ['nullable', 'date'],
            'applicant_name' => ['required', 'string', 'max:255'],
            'shop_name' => ['nullable', 'string', 'max:255'],
            'nrc_number' => ['required', 'string', 'max:255'],
            'township' => ['required', 'string', 'max:255'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'work_experience' => ['nullable', 'boolean'],
            'permanent_address' => ['nullable', 'string'],
            'distribution_location_address' => ['nullable', 'string'],
            'building_type' => ['nullable', 'string', 'max:255'],
            'building_dimensions' => ['nullable', 'string', 'max:255'],
            'attachment_nrc' => ['required', 'array', 'size:2'],
            'attachment_nrc.front' => ['required', 'file', 'image', 'max:5120'],
            'attachment_nrc.back' => ['required', 'file', 'image', 'max:5120'],
            'township_recommendation_letter' =>  ['required', 'file', 'image', 'max:5120'],
            'fertilizer_license_items' => ['required', 'array', 'min:1'],
            'fertilizer_license_items.*.fertilizer_name' => ['required', 'string', 'max:255'],
            'fertilizer_license_items.*.chemical_formula' => ['nullable', 'string', 'max:255'],
            'fertilizer_license_items.*.fertilizer_type' => ['nullable', 'string', 'max:255'],
            'fertilizer_license_items.*.packaging_size' => ['nullable', 'string', 'max:255'],
            'fertilizer_license_items.*.weight_volume' => ['nullable', 'string', 'max:255'],
            'created_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'work_experience' => $this->boolean('work_experience'),
        ]);
    }
}