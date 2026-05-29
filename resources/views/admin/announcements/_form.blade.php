@php $item = $announcement ?? null; @endphp
<div class="grid gap-4 max-w-2xl">
    <div>
        <label for="title" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.title_field') }}</label>
        <input type="text" name="title" id="title" value="{{ old('title', $item?->title) }}" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
    <div>
        <label for="slug" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.slug_field') }}</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $item?->slug) }}"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
    </div>
    <div>
        <label for="category" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.category_field') }}</label>
        <select name="category" id="category" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
            @foreach(\App\Models\AgriculturalAnnouncement::CATEGORIES as $category)
                <option value="{{ $category }}" @selected(old('category', $item?->category) === $category)>
                    {{ __('messages.announcements.categories.'.$category) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="content" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.content_field') }}</label>
        <textarea name="content" id="content" rows="12" required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('content', $item?->content) }}</textarea>
    </div>
    <div>
        <label for="featured_image" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.image_field') }}</label>
        @if($item?->featured_image_path)
            <img src="{{ $item->featuredImageUrl() }}" alt="" class="w-full max-h-48 object-cover rounded-xl mb-2 border border-emerald-100">
            <label class="flex items-center gap-2 text-sm text-slate-600 mb-2">
                <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-slate-300 text-emerald-600">
                {{ __('messages.announcements.remove_image') }}
            </label>
        @endif
        <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/webp"
            class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5">
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label for="published_at" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.announcements.published_at_field') }}</label>
            <input type="datetime-local" name="published_at" id="published_at"
                value="{{ old('published_at', $item?->published_at?->format('Y-m-d\TH:i')) }}"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 pt-8">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item?->is_published ?? false))
                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            {{ __('messages.announcements.publish_field') }}
        </label>
    </div>
</div>
