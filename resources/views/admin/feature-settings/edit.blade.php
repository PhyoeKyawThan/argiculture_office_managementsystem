@extends('admin.layouts.root')

@section('title', __('messages.features.title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900 tracking-tight">{{ __('messages.features.title') }}</h1>
        <p class="text-slate-500 mt-1">{{ __('messages.features.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('admin.feature-settings.update') }}" class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-6 max-w-3xl">
        @csrf
        @method('PUT')

        <div class="space-y-8">
            <section>
                <h2 class="text-lg font-black text-emerald-900 mb-4">{{ __('messages.features.content_section') }}</h2>
                <div class="space-y-3">
                    @foreach($contentCategories as $category)
                        @php $module = str_replace('-', '_', $category->slug); @endphp
                        @php $key = str_replace(' ', '', 'content_'.$module); @endphp
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-emerald-50 hover:bg-emerald-50/50 cursor-pointer">
                            <input type="checkbox" name="features[{{ $key }}]" value="1"
                                @checked(old('features.'.$key, optional($settings->get($key))->is_enabled ?? true))
                                class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span>
                                <span class="block font-bold text-slate-900">{{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}</span>
                                <span class="block text-sm text-slate-500">{{ $category->description }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="text-lg font-black text-emerald-900 mb-4">{{ __('messages.features.registration_section') }}</h2>
                <div class="space-y-3">
                    @foreach(['farmer_inquiries', 'farmer_registration', 'shop_registration'] as $key)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-emerald-50 hover:bg-emerald-50/50 cursor-pointer">
                            <input type="checkbox" name="features[{{ $key }}]" value="1"
                                @checked(old('features.'.$key, optional($settings->get($key))->is_enabled ?? true))
                                class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="font-bold text-slate-900">{{ __('messages.features.keys.'.$key) }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="text-lg font-black text-emerald-900 mb-4">{{ __('messages.features.admin_section') }}</h2>
                <div class="space-y-3">
                    @foreach(['shop_inspections', 'staff_management', 'landing_cms'] as $key)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-emerald-50 hover:bg-emerald-50/50 cursor-pointer">
                            <input type="checkbox" name="features[{{ $key }}]" value="1"
                                @checked(old('features.'.$key, optional($settings->get($key))->is_enabled ?? true))
                                class="mt-1 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="font-bold text-slate-900">{{ __('messages.features.keys.'.$key) }}</span>
                        </label>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="mt-8 pt-6 border-t border-emerald-50">
            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition">
                {{ __('messages.common.save') }}
            </button>
        </div>
    </form>
@endsection
