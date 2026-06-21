<?php

namespace App\Http\Requests\Admin;

use App\Models\PesticideShop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewPesticideShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|min:5',
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => __('messages.shop_reg.status'),
            'rejection_reason' => __('messages.shop_reg.rejection_reason'),
        ];
    }
}
