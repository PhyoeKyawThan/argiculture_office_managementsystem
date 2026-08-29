@extends('shop.layouts.root')

@section('title', $editing ?? false ? __('messages.shop.application_form.edit_fertilizer_application') : __('messages.shop.application_form.fertilizer_license_application'))

@section('breadcumb')
    <a href="{{ route('shop.dashboard') }}" class="hover:underline">{{ __('messages.shop.dashboard') }}</a>
    <span>&middot;</span>
    <span>{{ $editing ?? false ? __('messages.shop.application_form.edit_fertilizer_application') : __('messages.shop.application_form.fertilizer_license_application') }}</span>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-6 sm:py-8 px-0 sm:px-4">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-700">{{ __('messages.shop.portal_desc') }}
            </p>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mt-2">
                {{ $editing ?? false ? __('messages.shop.application_form.edit_fertilizer_application') : __('messages.shop.application_form.fertilizer_distribution_license_application') }}
            </h1>
            <p class="text-sm text-slate-600 mt-2 max-w-3xl">{{ __('messages.shop.application_form.fertilizer_desc') }}</p>
        </div>

        @if($latestLicense && !($editing ?? false))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 rounded-3xl p-5 text-sm text-emerald-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-black text-base">{{ __('messages.shop.application_form.most_recent_submission') }}</p>
                        <p class="text-emerald-700 mt-1">
                            {{ $latestLicense->application_date?->format('M j, Y') ?? __('messages.shop.application_form.no_date') }}
                            ·
                            {{ ucfirst(str_replace('_', ' ', $latestLicense->status)) }}
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full bg-white text-emerald-800 font-black text-xs uppercase tracking-wider border border-emerald-100">{{ $latestLicense->items->count() }}
                        {{ __('messages.shop.application_form.items') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-800">
                <p class="font-bold mb-2">{{ __('messages.common.error_title') }}</p>
                <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ $editing ?? false ? route('shop.fertilizer-licenses.update', $latestLicense) : route('shop.fertilizer-licenses.store') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($editing ?? false)
                @method('PUT')
            @endif
            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-6">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="application_date">{{ __('messages.shop.application_form.application_date') }}</label>
                        <input type="date" name="application_date" id="application_date"
                            value="{{ old('application_date', ($latestLicense->application_date ?? now())->toDateString()) }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('application_date') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="applicant_name">{{ __('messages.shop.application_form.applicant_name') }}</label>
                        <input type="text" name="applicant_name" id="applicant_name"
                            value="{{ old('applicant_name', $latestLicense->applicant_name ?? auth()->user()->name) }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('applicant_name') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="shop_name">{{ __('messages.shop.application_form.shop_name') }}</label>
                        <input type="text" name="shop_name" id="shop_name"
                            value="{{ old('shop_name', $latestLicense->shop_name ?? '') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('shop_name') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="nrc_number">{{ __('messages.shop.application_form.nrc_number') }}</label>
                        <div class="flex flex-wrap gap-2 items-center">
                            <select id="state-number"
                                class="rounded-xl border border-slate-200 px-3 py-3 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                @foreach (['၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉', '၁၀', '၁၁', '၁၂', '၁၃', '၁၄'] as $nrc_code)
                                    <option value="{{ $nrc_code }}" {{ old('state_number', $nrcState) === $nrc_code ? 'selected' : '' }}>{{ $nrc_code }}</option>
                                @endforeach
                            </select>
                            <span class="text-slate-400">/</span>

                            <select id="district"
                                class="rounded-xl border border-slate-200 px-3 py-3 bg-white focus:ring-2 focus:ring-emerald-500 outline-none min-w-[120px]"
                                data-old-value="{{ old('district_old_val', $nrcDistrict) }}">
                                <option value="" selected>{{ __('messages.shop.select_nrc_code_first') }}</option>
                            </select>
                            <input type="hidden" name="district_old_val" id="district_old_val"
                                value="{{ old('district_old_val', $nrcDistrict) }}">

                            <select id="naing"
                                class="rounded-xl border border-slate-200 px-3 py-3 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                @foreach(['နိုင်', 'ပြု', 'ဧည့်'] as $status_type)
                                    <option value="{{ $status_type }}" {{ old('naing_old_val', $nrcNaing) === $status_type ? 'selected' : '' }}>({{ $status_type }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="naing_old_val" id="naing_old_val"
                                value="{{ old('naing_old_val', $nrcNaing) }}">

                            <input type="text" id="nrc_number" placeholder="၁၂၃၄၅၆" maxlength="6"
                                value="{{ old('nrc_serial_val', $nrcSerial) }}" required
                                class="flex-1 min-w-[150px] rounded-xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <input type="hidden" name="nrc_serial_val" id="nrc_serial_val"
                                value="{{ old('nrc_serial_val', $nrcSerial) }}">

                            <input type="hidden" name="nrc_number" id="nrc"
                                value="{{ old('nrc_number', $latestLicense->nrc_number ?? '') }}"
                                class="@error('nrc_number') border-red-400 @enderror">
                        </div>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="education_level">{{ __('messages.shop.application_form.education_level') }}</label>
                        <input type="text" name="education_level" id="education_level"
                            value="{{ old('education_level', $latestLicense->education_level ?? '') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('education_level') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="work_experience">{{ __('messages.shop.application_form.work_experience') }}</label>
                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 bg-slate-50">
                            <input type="checkbox" name="work_experience" id="work_experience" value="1"
                                @checked(old('work_experience', $latestLicense->work_experience ?? false))
                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span
                                class="text-sm text-slate-700">{{ __('messages.shop.application_form.have_experience') }}</span>
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="township">{{ __('messages.shop.application_form.township') }}</label>
                        <input type="text" name="township" id="township" value="{{ old('township', $latestLicense->township ?? '') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="permanent_address">{{ __('messages.shop.application_form.permanent_address') }}</label>
                        <textarea name="permanent_address" id="permanent_address" rows="3"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('permanent_address', $latestLicense->permanent_address ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="distribution_location_address">{{ __('messages.shop.application_form.distribution_location') }}</label>
                        <textarea name="distribution_location_address" id="distribution_location_address" rows="3"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('distribution_location_address', $latestLicense->distribution_location_address ?? '') }}</textarea>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="building_type">{{ __('messages.shop.application_form.building_type') }}</label>
                        <input type="text" name="building_type" id="building_type"
                            value="{{ old('building_type', $latestLicense->building_type ?? '') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="building_dimensions">{{ __('messages.shop.application_form.building_dimensions') }}</label>
                        <input type="text" name="building_dimensions" id="building_dimensions"
                            value="{{ old('building_dimensions', $latestLicense->building_dimensions ?? '') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            {{ __('messages.shop.application_form.fertilizer_items') }}
                        </h2>
                        <p class="text-sm text-slate-500">{{ __('messages.shop.application_form.add_items_desc') }}</p>
                    </div>
                    <button type="button" id="addFertilizerRow"
                        class="px-4 py-2.5 rounded-xl bg-emerald-100 text-emerald-900 font-bold text-sm hover:bg-emerald-200 transition">{{ __('messages.shop.application_form.add_row') }}</button>
                </div>
                <div id="fertilizerRows" class="space-y-4"></div>
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            {{ __('messages.shop.application_form.nrc_attachments') }}
                        </h2>
                        <p class="text-sm text-slate-500">{{ __('messages.shop.application_form.upload_nrc_desc') }}</p>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach(['front' => __('messages.shop.application_form.front_nrc'), 'back' => __('messages.shop.application_form.back_nrc')] as $side => $label)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1"
                                for="attachment_nrc_{{ $side }}">{{ $label }}</label>
                            @if($editing ?? false && data_get($latestLicense->attachment_nrc, $side))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . data_get($latestLicense->attachment_nrc, $side)) }}"
                                        alt="{{ $label }}"
                                        class="w-full max-h-32 object-contain rounded-xl border border-slate-200 bg-white">
                                </div>
                            @endif
                            <input type="file" name="attachment_nrc[{{ $side }}]" id="attachment_nrc_{{ $side }}"
                                accept="image/*"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                            @if($editing ?? false && data_get($latestLicense->attachment_nrc, $side))
                                <p class="text-xs text-slate-400 mt-1">{{ __('messages.common.optional') }}</p>
                            @endif
                        </div>
                    @endforeach
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1"
                            for="township_recommendation_letter">{{ __('messages.shop.application_form.recommendation_letter') }}</label>
                        @if($editing ?? false && $latestLicense->township_recommendation_letter)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $latestLicense->township_recommendation_letter) }}"
                                    alt="{{ __('messages.shop.application_form.recommendation_letter') }}"
                                    class="w-full max-h-32 object-contain rounded-xl border border-slate-200 bg-white">
                            </div>
                        @endif
                        <input type="file" name="township_recommendation_letter" id="township_recommendation_letter"
                            accept="image/*"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                        @if($editing ?? false && $latestLicense->township_recommendation_letter)
                            <p class="text-xs text-slate-400 mt-1">{{ __('messages.common.optional') }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">တင်ပြသည့်ရက်စွဲ</label>
                        <input type="date" name="created_at" value="{{ $latestLicense ? $latestLicense->created_at?->format('Y-m-d') : '' }}"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none bg-white focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pb-6">
                <a href="{{ route('shop.dashboard') }}"
                    class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.common.cancel') }}</a>
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-emerald-700 text-white font-black hover:bg-emerald-800">{{ $editing ?? false ? __('messages.common.update') : __('messages.common.submit') }}</button>
            </div>
        </form>
    </div>

    <template id="fertilizerRowTemplate">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-4" data-fertilizer-row>
            <div class="flex items-center justify-between gap-3">
                <h3 class="font-black text-slate-900">{{ __('messages.shop.application_form.fertilizer_item') }}</h3>
                <button type="button" class="text-sm font-bold text-red-600 hover:text-red-700"
                    data-remove-row>{{ __('messages.common.remove') }}</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-xs font-bold text-slate-500 mb-1">{{ __('messages.shop.application_form.fertilizer_name') }}</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][fertilizer_name]"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-slate-500 mb-1">{{ __('messages.shop.application_form.chemical_formula') }}</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][chemical_formula]"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-slate-500 mb-1">{{ __('messages.shop.application_form.fertilizer_type') }}</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][fertilizer_type]"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-slate-500 mb-1">{{ __('messages.shop.application_form.packaging_size') }}</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][packaging_size]"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label
                        class="block text-xs font-bold text-slate-500 mb-1">{{ __('messages.shop.application_form.weight_volume') }}</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][weight_volume]"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>
        </div>
    </template>
@endsection

@section('scripts')
    <script>
        const nrc_formats = @json($nrc_formats);
        const stateNumberSelect = document.getElementById('state-number');
        const districtSelect = document.getElementById('district');
        const naingSelect = document.getElementById('naing');
        const nrcInput = document.getElementById('nrc_number');
        const hiddenNrcInput = document.getElementById('nrc');

        const oldDistrictTracker = document.getElementById('district_old_val');
        const oldNaingTracker = document.getElementById('naing_old_val');
        const oldSerialTracker = document.getElementById('nrc_serial_val');

        function mmToEn(mm) {
            const mmNumbers = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            return mm.split('').map(char => {
                const index = mmNumbers.indexOf(char);
                return index !== -1 ? index : char;
            }).join('');
        }

        function enToMm(en) {
            if (!en) return '';
            const mmNumbers = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            return en.split('').map(char => {
                const num = parseInt(char, 10);
                return (!isNaN(num) && char.trim() !== '') ? mmNumbers[num] : char;
            }).join('');
        }

        function updateFullNrcValue() {
            const state = stateNumberSelect.value;
            const district = districtSelect.value;
            const naing = naingSelect.value;
            const serial = nrcInput.value.trim();

            oldDistrictTracker.value = district;
            oldNaingTracker.value = naing;
            oldSerialTracker.value = serial;

            if (state && district && naing && serial) {
                hiddenNrcInput.value = `${state}/${district}(${naing})${serial}`;
            } else {
                hiddenNrcInput.value = '';
            }
        }

        function populateDistricts() {
            const selectedNrcCode = mmToEn(stateNumberSelect.value);
            const districts = nrc_formats.districts.filter(d => d.nrc_code === selectedNrcCode);

            districtSelect.innerHTML = '';
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.name_mm;
                option.textContent = district.name_mm;
                districtSelect.appendChild(option);
            });

            const cachedTarget = districtSelect.getAttribute('data-old-value');
            if (cachedTarget) {
                districtSelect.value = cachedTarget;
            }
            updateFullNrcValue();
        }

        document.addEventListener('DOMContentLoaded', function () {
            stateNumberSelect.addEventListener('change', () => {
                districtSelect.removeAttribute('data-old-value');
                populateDistricts();
            });
            districtSelect.addEventListener('change', updateFullNrcValue);
            naingSelect.addEventListener('change', updateFullNrcValue);
            nrcInput.addEventListener('input', function () {
                this.value = enToMm(this.value);
                updateFullNrcValue();
            });

            populateDistricts();

            const rowsContainer = document.getElementById('fertilizerRows');
            const addButton = document.getElementById('addFertilizerRow');
            const template = document.getElementById('fertilizerRowTemplate').innerHTML;
            const oldItems = @json(old('fertilizer_license_items', []));
            const existingItems = @json($existingItems ?? []);

            function renderRow(index, preset = {}) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = template.replaceAll('__INDEX__', String(index));
                const row = wrapper.firstElementChild;

                row.querySelectorAll('input').forEach(function (input) {
                    const keyMatch = input.name.match(/\[([^\]]+)\]$/);
                    const key = keyMatch ? keyMatch[1] : null;
                    if (key && Object.prototype.hasOwnProperty.call(preset, key)) {
                        input.value = preset[key] ?? '';
                    }
                });

                row.querySelector('[data-remove-row]')?.addEventListener('click', function () {
                    if (rowsContainer.querySelectorAll('[data-fertilizer-row]').length > 1) {
                        row.remove();
                    }
                });

                rowsContainer.appendChild(row);
            }

            if (Array.isArray(oldItems) && oldItems.length > 0) {
                oldItems.forEach(function (item, index) {
                    renderRow(index, item || {});
                });
            } else if (Array.isArray(existingItems) && existingItems.length > 0) {
                existingItems.forEach(function (item, index) {
                    renderRow(index, item || {});
                });
            } else {
                renderRow(0);
            }

            addButton?.addEventListener('click', function () {
                renderRow(rowsContainer.querySelectorAll('[data-fertilizer-row]').length);
            });
        });
    </script>
@endsection