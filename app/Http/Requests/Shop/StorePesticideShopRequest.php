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

            'surrounding_agreements'                          => ['required', 'array'],
            'surrounding_agreements.location.village'         => ['required', 'string', 'max:255'],
            'surrounding_agreements.location.village_tract'   => ['required', 'string', 'max:255'],
            'surrounding_agreements.location.township'        => ['required', 'string', 'max:255'],
            'surrounding_agreements.location.region_state'    => ['required', 'string', 'max:255'],
            
            // 'surrounding_agreements.boundaries'               => ['required', 'array', 'size:4'],
            // 'surrounding_agreements.boundaries.*.name'        => ['required', 'string', 'max:255'],
            // 'surrounding_agreements.boundaries.*.nrc'         => ['required', 'string', 'max:100'],

            // 'surrounding_agreements_signatures'               => ['required', 'array', 'size:4'],
            // 'surrounding_agreements_signatures.store_front'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            // 'surrounding_agreements_signatures.store_end'     => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            // 'surrounding_agreements_signatures.store_south'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            // 'surrounding_agreements_signatures.store_north'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],

            'attachments'                 => ['required', 'array', 'size:4'],
            'attachments.card_front'      => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.card_back'       => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.certificate'     => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'attachments.ward_approval'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'signature'                   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            'created_at' => 'required|date',
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
            'surrounding_agreements.boundaries.store_front.name' => 'Store Front Neighbor Name',
            'surrounding_agreements_signatures.store_front'   => 'Store Front Neighbor Signature File',
        ];
    }
}