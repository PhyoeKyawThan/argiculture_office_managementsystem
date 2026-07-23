@extends('admin.layouts.root')

@section('title', __('messages.inspections.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.inspections.title') }}</h1>
            <p class="text-slate-600 text-sm mt-1">{{ __('messages.inspections.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.pesticide-shop-inspections.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i> {{ __('messages.inspections.new') }}
        </a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.inspections.search_owner') }}"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
        <select name="township" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.common.all_townships') }}</option>
            @foreach($townships as $township)
                <option value="{{ $township }}" @selected(request('township') === $township)>{{ $township }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm hover:bg-emerald-200 transition">{{ __('messages.common.filter') }}</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-[900px]">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inspections.date') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inspections.owner') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inspections.township') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">{{ __('messages.inspections.inspector') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-center" title="{{ __('messages.inspections.registered') }}">{{ __('messages.inspections.reg_short') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-center" title="{{ __('messages.inspections.valid_license') }}">{{ __('messages.inspections.lic_short') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-center" title="{{ __('messages.inspections.complies_law') }}">{{ __('messages.inspections.law_short') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-center" title="{{ __('messages.inspections.training') }}">{{ __('messages.inspections.trn_short') }}</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($inspections as $inspection)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $inspection->inspection_date->format('M j, Y') }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $inspection->owner_name }}</td>
                        <td class="px-4 py-3">{{ $inspection->township }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $inspection->inspector?->name ?? __('messages.common.em_dash') }}</td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->is_registered_pesticide, 'label' => __('messages.inspections.badge_registered')])
                        </td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->has_valid_retail_license, 'label' => __('messages.inspections.badge_license')])
                        </td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->complies_with_pesticide_law, 'label' => __('messages.inspections.badge_law')])
                        </td>
                        <td class="px-4 py-3 text-center">
                            @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->has_training_certificate, 'label' => __('messages.inspections.badge_training')])
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.pesticide-shop-inspections.show', $inspection) }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.common.view') }}</a>
                            <a href="{{ route('admin.pesticide-shop-inspections.edit', $inspection) }}" class="text-slate-600 font-bold hover:underline">{{ __('messages.common.edit') }}</a>
                            <form action="{{ route('admin.pesticide-shop-inspections.destroy', $inspection) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline" data-confirm data-confirm-message="@json(__('messages.inspections.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-slate-500">{{ __('messages.inspections.no_records') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $inspections->links() }}</div>
@endsection
