@php $s = $section ?? null; @endphp
<div class="grid gap-4">
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label for="slug" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.slug') }}</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $s?->slug) }}" required
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label for="type" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.section_types') }}</label>
            <select name="type" id="type" required
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                @foreach(['hero', 'feature', 'stat', 'cta', 'footer'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $s?->type) === $type)>{{ __('messages.landing_sections.types.'.$type) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label for="title" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.title_col') }}</label>
            <input type="text" name="title" id="title" value="{{ old('title', $s?->title) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label for="subtitle" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.subtitle_field') }}</label>
            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $s?->subtitle) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
    </div>
    <div>
        <label for="body" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.body_field') }}</label>
        <textarea name="body" id="body" rows="4"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('body', $s?->body) }}</textarea>
    </div>
    <div class="grid sm:grid-cols-3 gap-4">
        <div>
            <label for="icon" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.lucide_icon') }}</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $s?->icon) }}" placeholder="{{ __('messages.landing_sections.icon_placeholder') }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label for="link_url" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.link_url') }}</label>
            <input type="text" name="link_url" id="link_url" value="{{ old('link_url', $s?->link_url) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label for="link_label" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.link_label') }}</label>
            <input type="text" name="link_label" id="link_label" value="{{ old('link_label', $s?->link_label) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4 items-end">
        <div>
            <label for="sort_order" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.landing_sections.sort_order') }}</label>
            <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $s?->sort_order ?? 0) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 pb-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $s?->is_active ?? true))
                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            {{ __('messages.landing_sections.active_public') }}
        </label>
    </div>
</div>
