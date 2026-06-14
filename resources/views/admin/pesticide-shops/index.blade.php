@extends('admin.layouts.root')

@section('title', __('messages.shop_reg.admin_title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.shop_reg.admin_title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.shop_reg.admin_subtitle') }}</p>
            @if($pendingCount > 0)
                <p class="text-amber-700 text-sm font-bold mt-2">{{ __('messages.shop_reg.pending_queue', ['count' => $pendingCount]) }}</p>
            @endif
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.shop_reg.search_placeholder') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none min-w-[200px] flex-1">
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.shop_reg.all_statuses') }}</option>
            @foreach(\App\Models\PesticideShop::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ __('messages.shop_reg.statuses.'.$status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-[640px]">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.shop_reg.shop_name') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.shop_reg.owner_name') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.shop_reg.license_number') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.shop_reg.status_field') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($shops as $shop)
                    <tr class="hover:bg-emerald-50/50 {{ $shop->isPending() ? 'bg-amber-50/30' : '' }}">
                        <td class="px-4 py-3 font-semibold">{{ $shop->shop_name }}</td>
                        <td class="px-4 py-3">{{ $shop->owner_name }}</td>
                        <td class="px-4 py-3">{{ $shop->license_number }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase
                                @if($shop->isApproved()) bg-emerald-100 text-emerald-800
                                @elseif($shop->isRejected()) bg-red-100 text-red-800
                                @else bg-amber-100 text-amber-800 @endif">
                                {{ __('messages.shop_reg.statuses.'.$shop->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.pesticide-shops.show', $shop) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.view') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">{{ __('messages.shop_reg.no_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $shops->links() }}</div>
@endsection
