@extends('admin.layouts.root')

@section('title', $pesticideShop->shop_name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pesticide-shops.index') }}" class="text-sm font-bold text-emerald-700">{{ __('messages.common.back_to_list') }}</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <h1 class="text-2xl font-black text-emerald-900">{{ $pesticideShop->shop_name }}</h1>
                        <p class="text-slate-600 mt-1">{{ $pesticideShop->owner_name }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase
                        @if($pesticideShop->isApproved()) bg-emerald-100 text-emerald-800
                        @elseif($pesticideShop->isRejected()) bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{ __('messages.shop_reg.statuses.'.$pesticideShop->status) }}
                    </span>
                </div>

                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.license_number') }}</dt><dd class="font-semibold">{{ $pesticideShop->license_number }}</dd></div>
                    <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.phone') }}</dt><dd class="font-semibold">{{ $pesticideShop->phone }}</dd></div>
                    <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.email') }}</dt><dd class="font-semibold">{{ $pesticideShop->email }}</dd></div>
                    <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.submitted') }}</dt><dd class="font-semibold">{{ $pesticideShop->created_at->format('M j, Y H:i') }}</dd></div>
                    <div class="sm:col-span-2"><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.address') }}</dt><dd class="font-semibold">{{ $pesticideShop->address }}</dd></div>
                    @if($pesticideShop->township || $pesticideShop->region)
                        <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.township') }}</dt><dd class="font-semibold">{{ $pesticideShop->township ?: '—' }}</dd></div>
                        <div><dt class="font-bold text-slate-500">{{ __('messages.shop_reg.region') }}</dt><dd class="font-semibold">{{ $pesticideShop->region ?: '—' }}</dd></div>
                    @endif
                </dl>

                @if($pesticideShop->isRejected() && $pesticideShop->rejection_reason)
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-bold mb-1">{{ __('messages.shop_reg.rejection_reason') }}</p>
                        <p>{{ $pesticideShop->rejection_reason }}</p>
                    </div>
                @endif

                @if($pesticideShop->reviewed_at)
                    <p class="text-xs text-slate-500 mt-4">
                        {{ __('messages.shop_reg.reviewed_by', ['name' => $pesticideShop->reviewer?->name, 'date' => $pesticideShop->reviewed_at->format('M j, Y')]) }}
                    </p>
                @endif
            </div>
        </div>

        @if($pesticideShop->isPending())
            <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm h-fit">
                <h2 class="text-lg font-black text-emerald-900 mb-4">{{ __('messages.shop_reg.review_title') }}</h2>
                <form method="POST" action="{{ route('admin.pesticide-shops.update', $pesticideShop) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <button type="submit" name="action" value="approved"
                            class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition">
                            {{ __('messages.shop_reg.approve') }}
                        </button>
                    </div>
                    <div>
                        <label for="rejection_reason" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.rejection_reason') }}</label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('rejection_reason') }}</textarea>
                    </div>
                    <button type="submit" name="action" value="rejected"
                        class="w-full py-3 border border-red-200 text-red-700 hover:bg-red-50 font-bold rounded-xl transition">
                        {{ __('messages.shop_reg.reject') }}
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
