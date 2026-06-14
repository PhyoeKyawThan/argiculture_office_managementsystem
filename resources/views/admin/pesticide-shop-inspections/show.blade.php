@extends('admin.layouts.root')

@section('title', $inspection->owner_name)

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-1">
                {{ __('messages.inspections.township_line', ['township' => $inspection->township]) }}</p>
            <h1 class="text-3xl font-black text-emerald-900">{{ $inspection->owner_name }}</h1>
            <p class="text-slate-600 mt-1">
                {{ __('messages.inspections.inspected_prefix', ['date' => $inspection->inspection_date->format('M j, Y')]) }}
                @if($inspection->inspector)
                    · {{ $inspection->inspector->name }}
                @endif
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.pesticide-shop-inspections.edit', $inspection) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition text-sm">
                <i data-lucide="pencil" class="w-4 h-4"></i> {{ __('messages.common.edit') }}
            </a>
            <form action="{{ route('admin.pesticide-shop-inspections.destroy', $inspection) }}" method="POST"
                onsubmit="return confirm(@json(__('messages.inspections.confirm_delete')))">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 border border-red-200 text-red-700 font-bold rounded-xl hover:bg-red-50 transition text-sm">
                    <i data-lucide="trash-2" class="w-4 h-4"></i> {{ __('messages.common.delete') }}
                </button>
            </form>
            <a href="{{ route('admin.pesticide-shop-inspections.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-slate-600 font-bold rounded-xl border border-emerald-100 hover:bg-white transition text-sm">
                {{ __('messages.common.back_to_list') }}
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-6">
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">
                {{ __('messages.inspections.shop_details') }}</h2>
            <dl class="grid gap-3 text-sm">
                <div>
                    <dt class="text-slate-500">{{ __('messages.inspections.address') }}</dt>
                    <dd class="font-semibold">{{ $inspection->shop_address }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">{{ __('messages.inspections.township') }}</dt>
                    <dd class="font-semibold">{{ $inspection->township }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">{{ __('messages.inspections.inspector') }}</dt>
                    <dd class="font-semibold">{{ $inspection->inspector?->name ?? __('messages.common.em_dash') }}</dd>
                </div>
                @if($inspection->license_expiry_date)
                    <div>
                        <dt class="text-slate-500">{{ __('messages.inspections.license_expires') }}</dt>
                        <dd class="font-semibold">{{ $inspection->license_expiry_date->format('M j, Y') }}</dd>
                    </div>
                @endif
            </dl>
        </section>
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">
                {{ __('messages.inspections.compliance') }}</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex items-center justify-between">
                    <span>{{ __('messages.inspections.registered') }}</span>
                    @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->is_registered_pesticide, 'label' => __('messages.inspections.badge_registered')])
                </li>
                <li class="flex items-center justify-between">
                    <span>{{ __('messages.inspections.valid_license') }}</span>
                    @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->has_valid_retail_license, 'label' => __('messages.inspections.badge_license')])
                </li>
                <li class="flex items-center justify-between">
                    <span>{{ __('messages.inspections.complies_law') }}</span>
                    @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->complies_with_pesticide_law, 'label' => __('messages.inspections.badge_law')])
                </li>
                <li class="flex items-center justify-between">
                    <span>{{ __('messages.inspections.training') }}</span>
                    @include('admin.pesticide-shop-inspections._compliance-badge', ['compliant' => $inspection->has_training_certificate, 'label' => __('messages.inspections.badge_training')])
                </li>
            </ul>
        </section>
    </div>

    @if($inspection->raw_findings_notes || $inspection->action_taken || $inspection->remarks)
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">
                {{ __('messages.inspections.notes_actions') }}</h2>
            <dl class="grid gap-4 text-sm">
                @if($inspection->raw_findings_notes)
                    <div>
                        <dt class="text-slate-500 mb-1">{{ __('messages.inspections.findings') }}</dt>
                        <dd class="font-medium text-slate-800 whitespace-pre-line">{{ $inspection->raw_findings_notes }}</dd>
                    </div>
                @endif
                @if($inspection->action_taken)
                    <div>
                        <dt class="text-slate-500 mb-1">{{ __('messages.inspections.action_taken') }}</dt>
                        <dd class="font-semibold">{{ $inspection->action_taken }}</dd>
                    </div>
                @endif
                @if($inspection->remarks)
                    <div>
                        <dt class="text-slate-500 mb-1">{{ __('messages.inspections.remarks') }}</dt>
                        <dd class="text-slate-700 whitespace-pre-line">{{ $inspection->remarks }}</dd>
                    </div>
                @endif
            </dl>
        </section>
    @endif
    @if($inspection->photos)
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-4">
                {{ __('messages.inspections.photos') }}</h2>
            <div class="flex flex-wrap gap-4">
                @foreach($inspection->photos as $photo)
                    <img src="{{ asset('storage/' . $photo) }}" alt="Inspection Photo" class="rounded-lg shadow-md">
                @endforeach
            </div>
        </section>
    @endif
@endsection