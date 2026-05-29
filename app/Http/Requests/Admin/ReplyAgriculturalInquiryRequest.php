<?php

namespace App\Http\Requests\Admin;

use App\Models\AgriculturalInquiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReplyAgriculturalInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        return [
            'answer_body' => ['required', 'string', 'max:10000'],
            'status' => ['required', Rule::in(AgriculturalInquiry::STATUSES)],
        ];
    }

    public function attributes(): array
    {
        return [
            'answer_body' => __('messages.inquiries.answer_field'),
            'status' => __('messages.inquiries.status_field'),
        ];
    }
}
