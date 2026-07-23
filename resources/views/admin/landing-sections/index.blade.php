@extends('admin.layouts.root')

@section('title', __('messages.landing_sections.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.landing_sections.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.landing_sections.subtitle') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('landing.home') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-emerald-200 text-emerald-800 font-bold rounded-xl hover:bg-emerald-100 transition text-sm">
                <i data-lucide="external-link" class="w-4 h-4"></i> {{ __('messages.landing_sections.preview') }}
            </a>
            <a href="{{ route('admin.landing-sections.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> {{ __('messages.landing_sections.add') }}
            </a>
        </div>
    </div>

    <form method="GET" class="mb-6">
        <select name="type" onchange="this.form.submit()"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.landing_sections.all_types') }}</option>
            @foreach(['hero', 'feature', 'stat', 'cta', 'footer'] as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>{{ __('messages.landing_sections.types.'.$type) }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.landing_sections.slug') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.landing_sections.type') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.landing_sections.title_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.landing_sections.order') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.landing_sections.status') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($sections as $section)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-3 font-mono text-xs">{{ $section->slug }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase bg-emerald-100 text-emerald-800">{{ __('messages.landing_sections.types.'.$section->type) }}</span>
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $section->title }}</td>
                        <td class="px-4 py-3">{{ $section->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if($section->is_active)
                                <span class="text-emerald-700 font-bold text-xs">{{ __('messages.landing_sections.active') }}</span>
                            @else
                                <span class="text-slate-400 font-bold text-xs">{{ __('messages.landing_sections.hidden') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.landing-sections.edit', $section) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.edit') }}</a>
                            <form action="{{ route('admin.landing-sections.destroy', $section) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline" data-confirm data-confirm-message="@json(__('messages.landing_sections.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">{{ __('messages.landing_sections.no_sections') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $sections->links() }}</div>
@endsection
