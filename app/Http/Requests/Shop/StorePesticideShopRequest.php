<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePesticideShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                            => ['required', 'string', 'max:255'],
            'township'                        => ['required', 'string', 'max:255'],
            'nrc'                             => ['required', 'string', 'max:50', Rule::unique('pesticide_shops', 'nrc')],
            'education'                       => ['required', 'string', 'max:255'],
            'stable_address'                  => ['required', 'string', 'max:500'],
            'requested_selling_address'       => ['required', 'string', 'max:500'],
            'building_type'                   => ['required', 'string', 'max:255'],
            'building_area'                   => ['required', 'string', 'max:255'],
            'from_restaurant_distance'        => ['required', 'string', 'max:255'],
            'retail_or_wholesale'             => ['required', Rule::in(['retail', 'wholesale'])],
            'has_emergency_preparedness_plan' => ['nullable', 'boolean'],

            'surrounding_agreement_attachment' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.formula' => ['required', 'string', 'max:255'],
            'items.*.type' => ['required', 'string', 'max:255'],
            'items.*.capacity' => ['required', 'string', 'max:255'],

            'attachments'                 => ['required', 'array', 'size:4'],
            'attachments.card_front'      => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.card_back'       => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.certificate'     => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.ward_approval'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'signature'                   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'has_emergency_preparedness_plan' => $this->has('has_emergency_preparedness_plan'),
        ]);
    }
    public function attributes(): array
    {
        return [
            'nrc'                                             => 'NRC Number',
            'attachments.card_front'                          => 'Training Card (Front)',
            'attachments.card_back'                           => 'Training Card (Back)',
            'attachments.certificate'                         => 'Pesticide Certificate',
            'attachments.ward_approval'                       => 'Ward Recommendation Letter',
            'surrounding_agreement_attachment'                => 'Surrounding Agreement Attachment',
            'items.*.name'                                    => 'Pesticide Name',
            'items.*.formula'                                 => 'Formula',
            'items.*.type'                                    => 'Pesticide Type',
            'items.*.capacity'                                => 'Capacity',
        ];
    }
}