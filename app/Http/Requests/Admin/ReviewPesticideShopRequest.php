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
            'action' => ['required', Rule::in([PesticideShop::STATUS_APPROVED, PesticideShop::STATUS_REJECTED])],
            'rejection_reason' => [
                Rule::requiredIf(fn () => $this->input('action') === PesticideShop::STATUS_REJECTED),
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'action' => __('messages.shop_reg.review_action'),
            'rejection_reason' => __('messages.shop_reg.rejection_reason'),
        ];
    }
}
