@extends('shop.layouts.root')

@section('title', 'Fertilizer License Application')

@section('breadcumb')
    <a href="{{ route('shop.dashboard') }}" class="hover:underline">{{ __('messages.shop.dashboard') }}</a>
    <span>&middot;</span>
    <span>Fertilizer License Application</span>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto py-6 sm:py-8 px-0 sm:px-4">
        <div class="mb-8">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-700">Shop Portal</p>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mt-2">Fertilizer Distribution License Application</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-3xl">Submit your license application with NRC attachments and fertilizer items in one place. You can add or remove items before submitting.</p>
        </div>

        @if($latestLicense)
            <div class="mb-6 bg-emerald-50 border border-emerald-100 rounded-3xl p-5 text-sm text-emerald-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-black text-base">Most recent submission</p>
                        <p class="text-emerald-700 mt-1">{{ $latestLicense->application_date?->format('M j, Y') ?? 'No application date recorded' }} · {{ ucfirst(str_replace('_', ' ', $latestLicense->status)) }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-white text-emerald-800 font-black text-xs uppercase tracking-wider border border-emerald-100">{{ $latestLicense->items->count() }} items</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-800">
                <p class="font-bold mb-2">Please review the errors below.</p>
                <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shop.fertilizer-licenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-6">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="application_date">Application Date</label>
                        <input type="date" name="application_date" id="application_date" value="{{ old('application_date', now()->toDateString()) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('application_date') border-red-400 @enderror">
                        @error('application_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="applicant_name">Applicant Name</label>
                        <input type="text" name="applicant_name" id="applicant_name" value="{{ old('applicant_name', auth()->user()->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('applicant_name') border-red-400 @enderror">
                        @error('applicant_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="shop_name">Shop Name</label>
                        <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('shop_name') border-red-400 @enderror">
                        @error('shop_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="nrc_number">NRC Number</label>
                        <input type="text" name="nrc_number" id="nrc_number" value="{{ old('nrc_number') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('nrc_number') border-red-400 @enderror">
                        @error('nrc_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="education_level">Education Level</label>
                        <input type="text" name="education_level" id="education_level" value="{{ old('education_level') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('education_level') border-red-400 @enderror">
                        @error('education_level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="work_experience">Work Experience</label>
                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 bg-slate-50">
                            <input type="checkbox" name="work_experience" id="work_experience" value="1" @checked(old('work_experience')) class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-slate-700">I have relevant fertilizer distribution experience</span>
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="permanent_address">Permanent Address</label>
                        <textarea name="permanent_address" id="permanent_address" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('permanent_address') border-red-400 @enderror">{{ old('permanent_address') }}</textarea>
                        @error('permanent_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="distribution_location_address">Distribution Location Address</label>
                        <textarea name="distribution_location_address" id="distribution_location_address" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('distribution_location_address') border-red-400 @enderror">{{ old('distribution_location_address') }}</textarea>
                        @error('distribution_location_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="building_type">Building Type</label>
                        <input type="text" name="building_type" id="building_type" value="{{ old('building_type') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('building_type') border-red-400 @enderror">
                        @error('building_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1" for="building_dimensions">Building Dimensions</label>
                        <input type="text" name="building_dimensions" id="building_dimensions" value="{{ old('building_dimensions') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('building_dimensions') border-red-400 @enderror">
                        @error('building_dimensions')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Fertilizer Items</h2>
                        <p class="text-sm text-slate-500">Add each fertilizer product you want to distribute.</p>
                    </div>
                    <button type="button" id="addFertilizerRow" class="px-4 py-2.5 rounded-xl bg-emerald-100 text-emerald-900 font-bold text-sm hover:bg-emerald-200 transition">Add Row</button>
                </div>

                <div id="fertilizerRows" class="space-y-4"></div>

                @error('fertilizer_license_items')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">NRC Attachments</h2>
                        <p class="text-sm text-slate-500">Upload both front and back images.</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    @foreach(['front' => 'Front NRC Image', 'back' => 'Back NRC Image'] as $side => $label)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1" for="attachment_nrc_{{ $side }}">{{ $label }}</label>
                            <input type="file" name="attachment_nrc[{{ $side }}]" id="attachment_nrc_{{ $side }}" accept="image/*" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none @error('attachment_nrc.' . $side) border-red-400 @enderror">
                            @error('attachment_nrc.' . $side)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pb-6">
                <a href="{{ route('shop.dashboard') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50">Cancel</a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 text-white font-black hover:bg-emerald-800 shadow-lg shadow-emerald-700/10">Submit Application</button>
            </div>
        </form>
    </div>

    <template id="fertilizerRowTemplate">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-4" data-fertilizer-row>
            <div class="flex items-center justify-between gap-3">
                <h3 class="font-black text-slate-900">Fertilizer Item</h3>
                <button type="button" class="text-sm font-bold text-red-600 hover:text-red-700" data-remove-row>Remove</button>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Fertilizer Name</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][fertilizer_name]" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Chemical Formula</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][chemical_formula]" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Fertilizer Type</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][fertilizer_type]" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Packaging Size</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][packaging_size]" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 mb-1">Weight / Volume</label>
                    <input type="text" name="fertilizer_license_items[__INDEX__][weight_volume]" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
            </div>
        </div>
    </template>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rowsContainer = document.getElementById('fertilizerRows');
            const addButton = document.getElementById('addFertilizerRow');
            const template = document.getElementById('fertilizerRowTemplate').innerHTML;
            const oldItems = @json(old('fertilizer_license_items', []));

            function renderRow(index, preset = {}) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = template.replaceAll('__INDEX__', String(index));
                const row = wrapper.firstElementChild;

                row.querySelectorAll('input').forEach(function (input) {
                    const keyMatch = input.name.match(/\[(.*?)\]$/);
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
            } else {
                renderRow(0);
            }

            addButton?.addEventListener('click', function () {
                renderRow(rowsContainer.querySelectorAll('[data-fertilizer-row]').length);
            });
        });
    </script>
@endsection