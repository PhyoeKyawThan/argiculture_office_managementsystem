@php
    $item = $announcement ?? null;
    $categories = \App\Models\Category::orderBy('level')->orderBy('name')->get();

    $labelClass = 'block text-sm font-bold text-slate-700 mb-1.5';
    $inputClass = 'w-full rounded-xl border border-slate-200 px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition';
    $sectionClass = 'rounded-xl border border-emerald-100 bg-emerald-50/40 p-4 sm:p-5 space-y-4';
    $sectionTitleClass = 'text-xs font-black uppercase tracking-wider text-emerald-800';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <div class="lg:col-span-8">
        <label for="title" class="{{ $labelClass }}">{{ __('messages.announcements.title_field') }}</label>
        <input type="text" name="title" id="title" value="{{ old('title', $item?->title) }}" required
            class="{{ $inputClass }} text-base">
    </div>
    <div class="lg:col-span-4">
        <label for="slug" class="{{ $labelClass }}">{{ __('messages.announcements.slug_field') }}</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $item?->slug) }}"
            class="{{ $inputClass }} font-mono text-sm">
    </div>

    <div class="lg:col-span-8 flex flex-col">
        <label for="content" class="{{ $labelClass }}">{{ __('messages.announcements.content_field') }}</label>
        <textarea name="content" id="content" required rows="1"
            class="{{ $inputClass }} h-[200px] min-h-[200px] resize-none overflow-hidden leading-relaxed">{{ old('content', $item?->content) }}</textarea>
    </div>

    <div class="lg:col-span-4 space-y-4">
        <section class="{{ $sectionClass }}">
            <h3 class="{{ $sectionTitleClass }}">{{ __('messages.announcements.category_field') }}</h3>
            <div>
                <label for="category_id" class="{{ $labelClass }}">Category</label>
                <select name="category_id" id="category_id" required class="{{ $inputClass }}">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $item?->category_id) == $category->id)>
                            {{ $category->path }}
                        </option>
                    @endforeach
                </select>
            </div>
        </section>

        <section class="{{ $sectionClass }}">
            <h3 class="{{ $sectionTitleClass }}">{{ __('messages.announcements.image_field') }}</h3>
            @if($item?->featured_image_path)
                <img src="{{ $item->featuredImageUrl() }}" alt=""
                    class="w-full aspect-video object-cover rounded-xl border border-emerald-100">
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remove_featured_image" value="1"
                        class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    {{ __('messages.announcements.remove_image') }}
                </label>
            @endif
            <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/webp"
                class="w-full text-sm rounded-xl border border-dashed border-slate-300 bg-white px-4 py-3 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-emerald-800 hover:border-emerald-300 transition">
        </section>

        <section class="{{ $sectionClass }}">
            <h3 class="{{ $sectionTitleClass }}">{{ __('messages.announcements.publish_field') }}</h3>
            <div>
                <label for="published_at" class="{{ $labelClass }}">{{ __('messages.announcements.published_at_field') }}</label>
                <input type="datetime-local" name="published_at" id="published_at"
                    value="{{ old('published_at', $item?->published_at?->format('Y-m-d\TH:i')) }}"
                    class="{{ $inputClass }}">
            </div>
            <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700 rounded-xl border border-emerald-100 bg-white px-4 py-3">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item?->is_published ?? false))
                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                {{ __('messages.announcements.publish_field') }}
            </label>
        </section>
    </div>
</div>

<div class="mt-4 pt-4 border-t border-emerald-100 flex flex-wrap items-center gap-2">
    <button type="submit" class="px-4 py-2 bg-emerald-700 text-white text-sm font-bold rounded-xl hover:bg-emerald-800 transition">
        {{ $submitLabel ?? __('messages.common.save') }}
    </button>
    <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition">
        {{ __('messages.common.cancel') }}
    </a>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentTextarea = document.getElementById('content');
        const CONTENT_MIN_HEIGHT = 200;

        function autoResizeContent() {
            if (!contentTextarea) return;
            contentTextarea.style.height = CONTENT_MIN_HEIGHT + 'px';
            contentTextarea.style.height = Math.max(CONTENT_MIN_HEIGHT, contentTextarea.scrollHeight) + 'px';
        }

        if (contentTextarea) {
            contentTextarea.addEventListener('input', autoResizeContent);
            autoResizeContent();
        }
    });
</script>
@endpush