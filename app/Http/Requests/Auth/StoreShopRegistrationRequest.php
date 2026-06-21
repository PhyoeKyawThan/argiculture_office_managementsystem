<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreShopRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            // 'shop_name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            // 'phone' => ['required', 'string', 'max:30'],
            // 'address' => ['required', 'string', 'max:500'],
            // 'township' => ['nullable', 'string', 'max:100'],
            // 'region' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('messages.shop_reg.owner_name'),
            // 'shop_name' => __('messages.shop_reg.shop_name'),
            'email' => __('messages.shop_reg.email'),
            'password' => 'Password',
            // 'phone' => __('messages.shop_reg.phone'),
            // 'address' => __('messages.shop_reg.address'),
            // 'township' => __('messages.shop_reg.township'),
            // 'region' => __('messages.shop_reg.region'),
        ];
    }
}