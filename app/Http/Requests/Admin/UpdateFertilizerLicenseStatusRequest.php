<?php

namespace App\Http\Requests\Admin;

use App\Models\FertilizerDistributionLicense;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFertilizerLicenseStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(FertilizerDistributionLicense::STATUSES)],
            'cancelled_reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}