@extends('admin.layouts.root')

@section('title', __('messages.inquiries.admin_title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.inquiries.admin_title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.inquiries.admin_subtitle') }}</p>
            @if($pendingCount > 0)
                <p class="text-amber-700 text-sm font-bold mt-2">{{ __('messages.inquiries.pending_queue', ['count' => $pendingCount]) }}</p>
            @endif
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.inquiries.search_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none min-w-[200px] flex-1">
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.inquiries.all_statuses') }}</option>
            <option value="pending" @selected(request('status') === 'pending')>{{ __('messages.inquiries.status_pending') }}</option>
            <option value="answered" @selected(request('status') === 'answered')>{{ __('messages.inquiries.status_answered') }}</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inquiries.title_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inquiries.farmer') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inquiries.status_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inquiries.submitted') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-emerald-50/50 {{ $inquiry->isPending() ? 'bg-amber-50/30' : '' }}">
                        <td class="px-4 py-3 font-semibold max-w-xs">{{ $inquiry->title }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $inquiry->farmer?->name }}</div>
                            <div class="text-xs text-slate-500">{{ $inquiry->farmer?->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase {{ $inquiry->isAnswered() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $inquiry->isAnswered() ? __('messages.inquiries.status_answered') : __('messages.inquiries.status_pending') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600 whitespace-nowrap">{{ $inquiry->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.view') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">{{ __('messages.inquiries.no_admin_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $inquiries->links() }}</div>
@endsection
