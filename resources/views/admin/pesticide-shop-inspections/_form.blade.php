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
                <label class="block text-sm font-bold text-slate-700 mb-1">
                    {{ __('messages.inspections.photos') ?? 'Inspection Photos' }}
                    <span class="text-xs font-normal text-slate-400 font-mono">({{ __('messages.inspections.max_photos_limit', ['count' => 2]) ?? 'Max 2 photos, up to 5MB each' }})</span>
                </label>
                
                <div class="relative flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-xl p-6 bg-slate-50 hover:bg-slate-100/50 hover:border-emerald-300 transition-colors group @error('photos') border-red-300 bg-red-50/10 @enderror">
                    <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    
                    <svg class="w-8 h-8 text-slate-400 group-hover:text-emerald-500 transition-colors mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>

                    <p class="text-sm text-slate-600 font-semibold group-hover:text-emerald-700 transition-colors" id="file-upload-text">
                        {{ __('messages.inspections.click_to_upload') ?? 'Click to upload files' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1 font-medium" id="file-counter-text">No files selected</p>
                </div>

                @error('photos')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('photos.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div>
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
            </div> --}}
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

        // --- Photo Counter Handling ---
        const photoInput = document.getElementById('photos');
        const fileText = document.getElementById('file-upload-text');
        const fileCounter = document.getElementById('file-counter-text');

        if (photoInput) {
            photoInput.addEventListener('change', function () {
                const count = this.files.length;
                if (count > 2) {
                    alert('You can only select up to 2 photos.');
                    this.value = ''; // Reset files selection
                    fileText.textContent = "Click to upload files";
                    fileCounter.textContent = "No files selected";
                    return;
                }

                if (count > 0) {
                    fileText.textContent = "Files ready to upload";
                    fileCounter.textContent = `${count} file(s) selected`;
                } else {
                    fileText.textContent = "Click to upload files";
                    fileCounter.textContent = "No files selected";
                }
            });
        }
    });
</script>
@endpush