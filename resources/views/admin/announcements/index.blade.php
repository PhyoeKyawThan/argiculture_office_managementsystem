@extends('admin.layouts.root')

@section('title', __('messages.announcements.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.announcements.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.announcements.subtitle') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('news.index') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-emerald-200 text-emerald-800 font-bold rounded-xl text-sm hover:bg-emerald-100">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                {{ __('messages.nav.view_site') }}
            </a>
            <a href="{{ route('admin.announcements.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl text-sm hover:bg-emerald-800">
                <i data-lucide="plus" class="w-4 h-4"></i>
                {{ __('messages.announcements.add') }}
            </a>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <select name="category" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.announcements.all_categories') }}</option>
            @foreach(\App\Models\AgriculturalAnnouncement::CATEGORIES as $category)
                <option value="{{ $category }}" @selected(request('category') === $category)>{{ __('messages.announcements.categories.'.$category) }}</option>
            @endforeach
        </select>
        <select name="published" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.announcements.all_published') }}</option>
            <option value="yes" @selected(request('published') === 'yes')>{{ __('messages.announcements.published_yes') }}</option>
            <option value="no" @selected(request('published') === 'no')>{{ __('messages.announcements.published_no') }}</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.announcements.title_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.announcements.category_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.announcements.published_at_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($announcements as $announcement)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-3 font-semibold">{{ $announcement->title }}</td>
                        <td class="px-4 py-3">{{ __('messages.announcements.categories.'.$announcement->category) }}</td>
                        <td class="px-4 py-3">
                            @if($announcement->is_published)
                                <span class="text-emerald-700 font-bold text-xs">{{ __('messages.common.published') }}</span>
                                <div class="text-slate-500 text-xs">{{ $announcement->published_at?->format('M j, Y') }}</div>
                            @else
                                <span class="text-slate-400 font-bold text-xs">{{ __('messages.common.draft') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.edit') }}</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline"
                                onsubmit="return confirm(@json(__('messages.announcements.confirm_delete')))">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline">{{ __('messages.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-500">{{ __('messages.announcements.no_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $announcements->links() }}</div>
@endsection
