<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePesticideShopInspectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        return [
            'inspector_staff_id' => ['nullable', 'uuid', Rule::exists('staff', 'id')],
            'owner_name' => ['required', 'string', 'max:255'],
            'shop_address' => ['required', 'string'],
            'township' => ['required', 'string', 'max:100'],
            'inspection_date' => ['required', 'date', 'before_or_equal:today'],
            'is_registered_pesticide' => ['sometimes', 'boolean'],
            'has_valid_retail_license' => ['sometimes', 'boolean'],
            'license_expiry_date' => [
                Rule::requiredIf(fn() => $this->boolean('has_valid_retail_license')),
                'nullable',
                'date',
            ],
            'complies_with_pesticide_law' => ['sometimes', 'boolean'],
            'has_training_certificate' => ['sometimes', 'boolean'],
            'raw_findings_notes' => ['nullable', 'string'],
            'photos' => ['nullable', 'array', 'max:2'], 
            'photos.*' => ['file', 'image', 'max:5120'],
            // 'action_taken' => ['nullable', 'string', 'max:255'],
            // 'remarks' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_registered_pesticide' => $this->boolean('is_registered_pesticide'),
            'has_valid_retail_license' => $this->boolean('has_valid_retail_license'),
            'complies_with_pesticide_law' => $this->boolean('complies_with_pesticide_law'),
            'has_training_certificate' => $this->boolean('has_training_certificate'),
        ]);
    }
}
