<?php

namespace App\Http\Requests\Admin;

use App\Support\Feature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeatureSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'features' => ['required', 'array'],
            'features.*' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $features = [];

        foreach (Feature::keys() as $key) {
            $features[$key] = $this->boolean('features.'.$key);
        }

        $this->merge(['features' => $features]);
    }
}
