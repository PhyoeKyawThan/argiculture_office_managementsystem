<?php

namespace App\Http\Requests\Shop;

use App\Models\PesticideShop;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePesticideShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pesticideShop = PesticideShop::find($this->route('id'));
        return $pesticideShop
            && $pesticideShop->user_id === auth()->id()
            && $pesticideShop->status !== 'approved';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'township' => 'required|string|max:255',
            'nrc' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'stable_address' => 'required|string|max:255',
            'requested_selling_address' => 'required|string',
            'building_type' => 'required|string|max:255',
            'building_area' => 'required|string|max:255',
            'from_restaurant_distance' => 'required|string|max:255',
            'retail_or_wholesale' => 'required|in:retail,wholesale',
            'has_emergency_preparedness_plan' => 'nullable|boolean',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'attachments.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surrounding_agreement_attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.formula' => 'required|string|max:255',
            'items.*.type' => 'required|string|max:255',
            'items.*.capacity' => 'required|string|max:255',
        ];
    }
}