<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        return [
            'personal_no' => ['required', 'string', 'max:20', 'unique:staff,personal_no'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', 'date'],
            'first_joining_position' => ['required', 'string', 'max:255'],
            'first_joining_date' => ['required', 'date'],
            'current_position' => ['required', 'string', 'max:255'],
            'current_position_joining_date' => ['required', 'date'],
            'assigned_position' => ['required', 'string', 'max:255'],
            'assigned_region_first_joining_date' => ['required', 'date'],
            'current_region' => ['required', 'string', 'max:255'],
            'current_office' => ['required', 'string', 'max:255'],
            'current_branch' => ['required', 'string', 'max:255'],
            'education_level' => ['required', 'string', 'max:255'],
            'is_married' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_married' => $this->boolean('is_married'),
        ]);
    }
}
