@extends('admin.layouts.root')

@section('title', __('messages.staff.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.staff.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.staff.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.staff.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ __('messages.staff.add') }}
        </a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.staff.search_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        <select name="region" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.common.all_regions') }}</option>
            @foreach($regions as $region)
                <option value="{{ $region }}" @selected(request('region') === $region)>{{ $region }}</option>
            @endforeach
        </select>
        <input type="text" name="office" value="{{ request('office') }}" placeholder="{{ __('messages.staff.office_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm hover:bg-emerald-200 transition">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.staff.personal_no') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.staff.name') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.staff.position') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.staff.region_office') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($staff as $member)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-3 font-mono text-xs">{{ $member->personal_no }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $member->name }}</td>
                        <td class="px-4 py-3">{{ $member->current_position }}</td>
                        <td class="px-4 py-3 text-slate-600">
                            <div>{{ $member->current_region }}</div>
                            <div class="text-xs">{{ $member->current_office }}</div>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.staff.show', $member) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.view') }}</a>
                            <a href="{{ route('admin.staff.edit', $member) }}" class="text-slate-600 font-bold hover:underline">{{ __('messages.common.edit') }}</a>
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" class="inline"
                                    onsubmit="return confirm(@json(__('messages.staff.confirm_delete_staff')))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold hover:underline">{{ __('messages.common.delete') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">{{ __('messages.staff.no_staff_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $staff->links() }}</div>
@endsection
