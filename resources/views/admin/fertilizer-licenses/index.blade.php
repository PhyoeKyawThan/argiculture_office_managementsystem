@extends('admin.layouts.root')

@section('title', __('messages.fertilizer_license.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.fertilizer_license.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.fertilizer_license.index.subtitle') }}</p>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.fertilizer_license.index.search_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none min-w-[220px] flex-1">
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.fertilizer_license.index.all_statuses') }}</option>
            @foreach(\App\Models\FertilizerDistributionLicense::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ __('messages.fertilizer_license.statuses.' . $status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-[1100px]">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.applicant_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.shop_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.nrc_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.application_date_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.items_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.fertilizer_license.index.status_col') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.fertilizer_license.index.actions_col') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($licenses as $license)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-slate-900">{{ $license->applicant_name }}</div>
                            <div class="text-xs text-slate-500">{{ $license->user?->email ?? __('messages.fertilizer_license.index.guest_application') }}</div>
                        </td>
                        <td class="px-4 py-4 text-slate-700">{{ $license->shop_name ?? __('messages.common.em_dash') }}</td>
                        <td class="px-4 py-4 text-slate-700">{{ $license->nrc_number }}</td>
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">{{ $license->application_date?->format('M j, Y') ?? __('messages.common.em_dash') }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-slate-900">{{ $license->items->count() }}</div>
                            <div class="text-xs text-slate-500">{{ $license->items->pluck('fertilizer_name')->take(2)->implode(', ') ?: __('messages.fertilizer_license.index.no_items') }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-black uppercase tracking-wider
                                {{ $license->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($license->status === 'sending_to_regional_department' ? 'bg-blue-100 text-blue-800' : ($license->status === 'allowed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800')) }}">
                                {{ __('messages.fertilizer_license.statuses.' . $license->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right space-y-2 whitespace-nowrap">
                            <a href="{{ route('admin.fertilizer-licenses.show', $license) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200">
                                {{ __('messages.fertilizer_license.index.view_details') }}
                            </a>
                            <span class="text-slate-300 mx-1">|</span>
                            <form action="{{ route('admin.fertilizer-licenses.destroy', $license) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline" data-confirm data-confirm-message="@json(__('messages.fertilizer_license.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-500">{{ __('messages.fertilizer_license.index.no_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $licenses->links() }}</div>
@endsection