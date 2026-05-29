<?php

namespace App\Http\Requests\Farmer;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgriculturalInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isFarmer() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp,pdf'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('messages.inquiries.title_field'),
            'description' => __('messages.inquiries.description_field'),
            'attachment' => __('messages.inquiries.attachment_field'),
        ];
    }
}
