<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_name' => ['required', 'string', 'max:200'],
            'owner_name' => ['required', 'string', 'max:200'],
            'license_number' => ['required', 'string', 'max:100', 'unique:pesticide_shops,license_number'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:pesticide_shops,email', 'unique:users,email'],
            'address' => ['required', 'string', 'max:500'],
            'township' => ['nullable', 'string', 'max:100'],
            'region' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'shop_name' => __('messages.shop_reg.shop_name'),
            'owner_name' => __('messages.shop_reg.owner_name'),
            'license_number' => __('messages.shop_reg.license_number'),
            'phone' => __('messages.shop_reg.phone'),
            'email' => __('messages.shop_reg.email'),
            'address' => __('messages.shop_reg.address'),
            'township' => __('messages.shop_reg.township'),
            'region' => __('messages.shop_reg.region'),
        ];
    }
}
