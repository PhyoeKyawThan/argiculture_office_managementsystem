<?php

namespace App\Http\Requests\Admin;

use App\Support\AgriculturalContentCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgriculturalAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isBackOffice() ?? false;
    }

    public function rules(): array
    {
        $announcement = $this->route('announcement');

        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                'alpha_dash',
                Rule::unique('agricultural_announcements', 'slug')->ignore($announcement?->id),
            ],
            'content' => ['required', 'string', 'max:50000'],
            'module' => ['required', Rule::in(AgriculturalContentCatalog::modules())],
            'sub_type' => [
                Rule::requiredIf(fn () => AgriculturalContentCatalog::moduleHasSubTypes($this->input('module', ''))),
                'nullable',
                'string',
                Rule::in(AgriculturalContentCatalog::subTypesFor($this->input('module', ''))),
            ],
            'featured_image' => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['sometimes', 'boolean'],
            'remove_featured_image' => ['sometimes', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('messages.announcements.title_field'),
            'slug' => __('messages.announcements.slug_field'),
            'content' => __('messages.announcements.content_field'),
            'module' => __('messages.announcements.module_field'),
            'sub_type' => __('messages.announcements.sub_type_field'),
            'featured_image' => __('messages.announcements.image_field'),
            'published_at' => __('messages.announcements.published_at_field'),
            'is_published' => __('messages.announcements.publish_field'),
        ];
    }
}
