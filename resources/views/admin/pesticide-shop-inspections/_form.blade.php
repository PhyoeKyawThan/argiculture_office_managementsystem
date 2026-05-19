@php
    $record = $inspection ?? null;
    $selectedInspector = old('inspector_staff_id', $record?->inspector_staff_id ?? $defaultInspectorId ?? null);
    $dash = __('messages.common.em_dash');
@endphp

<div class="space-y-8">
    <section>
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.inspections.shop_inspection_section') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label for="inspector_staff_id" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.inspector_dropdown') }}</label>
                <select name="inspector_staff_id" id="inspector_staff_id"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('inspector_staff_id') border-red-400 @enderror">
                    <option value="">{{ __('messages.inspections.use_linked_staff', ['dash' => $dash]) }}</option>
                    @foreach($inspectors as $inspector)
                        <option value="{{ $inspector->id }}" @selected($selectedInspector === $inspector->id)>{{ $inspector->name }}</option>
                    @endforeach
                </select>
                @error('inspector_staff_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="owner_name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.owner_name') }}</label>
                <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $record?->owner_name) }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('owner_name') border-red-400 @enderror">
                @error('owner_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="township" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.township') }}</label>
                <input type="text" name="township" id="township" value="{{ old('township', $record?->township ?? 'Hinthada') }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('township') border-red-400 @enderror">
                @error('township')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="shop_address" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.shop_address') }}</label>
                <textarea name="shop_address" id="shop_address" rows="3" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('shop_address') border-red-400 @enderror">{{ old('shop_address', $record?->shop_address) }}</textarea>
                @error('shop_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="inspection_date" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.inspection_date') }}</label>
                <input type="date" name="inspection_date" id="inspection_date"
                    value="{{ old('inspection_date', $record?->inspection_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required
                    max="{{ now()->format('Y-m-d') }}"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('inspection_date') border-red-400 @enderror">
                @error('inspection_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="bg-emerald-50/50 rounded-2xl border border-emerald-100 p-6">
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.inspections.compliance_criteria') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <label class="flex items-start gap-3 p-4 bg-white rounded-xl border border-emerald-100 cursor-pointer hover:border-emerald-300 transition">
                <input type="checkbox" name="is_registered_pesticide" value="1"
                    @checked(old('is_registered_pesticide', $record?->is_registered_pesticide ?? false))
                    class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>
                    <span class="block text-sm font-bold text-slate-800">{{ __('messages.inspections.registered') }}</span>
                    <span class="block text-xs text-slate-500 mt-0.5">{{ __('messages.inspections.reg_pesticide_desc') }}</span>
                </span>
            </label>
            <label class="flex items-start gap-3 p-4 bg-white rounded-xl border border-emerald-100 cursor-pointer hover:border-emerald-300 transition">
                <input type="checkbox" name="has_valid_retail_license" value="1" id="has_valid_retail_license"
                    @checked(old('has_valid_retail_license', $record?->has_valid_retail_license ?? false))
                    class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>
                    <span class="block text-sm font-bold text-slate-800">{{ __('messages.inspections.valid_license') }}</span>
                    <span class="block text-xs text-slate-500 mt-0.5">{{ __('messages.inspections.valid_license_desc') }}</span>
                </span>
            </label>
            <label class="flex items-start gap-3 p-4 bg-white rounded-xl border border-emerald-100 cursor-pointer hover:border-emerald-300 transition">
                <input type="checkbox" name="complies_with_pesticide_law" value="1"
                    @checked(old('complies_with_pesticide_law', $record?->complies_with_pesticide_law ?? false))
                    class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>
                    <span class="block text-sm font-bold text-slate-800">{{ __('messages.inspections.complies_law') }}</span>
                    <span class="block text-xs text-slate-500 mt-0.5">{{ __('messages.inspections.complies_law_desc') }}</span>
                </span>
            </label>
            <label class="flex items-start gap-3 p-4 bg-white rounded-xl border border-emerald-100 cursor-pointer hover:border-emerald-300 transition">
                <input type="checkbox" name="has_training_certificate" value="1"
                    @checked(old('has_training_certificate', $record?->has_training_certificate ?? false))
                    class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>
                    <span class="block text-sm font-bold text-slate-800">{{ __('messages.inspections.training') }}</span>
                    <span class="block text-xs text-slate-500 mt-0.5">{{ __('messages.inspections.training_desc') }}</span>
                </span>
            </label>
        </div>
        <div class="mt-4" id="license_expiry_wrap">
            <label for="license_expiry_date" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.license_expiry') }}</label>
            <input type="date" name="license_expiry_date" id="license_expiry_date"
                value="{{ old('license_expiry_date', $record?->license_expiry_date?->format('Y-m-d')) }}"
                class="w-full max-w-xs rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('license_expiry_date') border-red-400 @enderror">
            @error('license_expiry_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </section>

    <section>
        <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">{{ __('messages.inspections.notes_actions') }}</h2>
        <div class="grid gap-4">
            <div>
                <label for="raw_findings_notes" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.raw_findings') }}</label>
                <textarea name="raw_findings_notes" id="raw_findings_notes" rows="4"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('raw_findings_notes') border-red-400 @enderror">{{ old('raw_findings_notes', $record?->raw_findings_notes) }}</textarea>
                @error('raw_findings_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="action_taken" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.action_taken') }}</label>
                <input type="text" name="action_taken" id="action_taken" value="{{ old('action_taken', $record?->action_taken) }}"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('action_taken') border-red-400 @enderror">
                @error('action_taken')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="remarks" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inspections.remarks') }}</label>
                <textarea name="remarks" id="remarks" rows="3"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none @error('remarks') border-red-400 @enderror">{{ old('remarks', $record?->remarks) }}</textarea>
                @error('remarks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const licenseCheckbox = document.getElementById('has_valid_retail_license');
        const licenseWrap = document.getElementById('license_expiry_wrap');
        const licenseInput = document.getElementById('license_expiry_date');

        function syncLicenseField() {
            const show = licenseCheckbox && licenseCheckbox.checked;
            if (licenseWrap) licenseWrap.classList.toggle('hidden', !show);
            if (licenseInput) licenseInput.required = show;
        }

        if (licenseCheckbox) {
            licenseCheckbox.addEventListener('change', syncLicenseField);
            syncLicenseField();
        }
    });
</script>
@endpush
