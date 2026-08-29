@extends('shop.layouts.root')

@section('title', __('messages.shop.title'))

@section('breadcumb')
    <span>{{ __('messages.shop.dashboard') }}</span>
@endsection

@section('content')
    <h1 class="text-2xl font-black text-emerald-900 mb-2">
        {{ __('messages.shop.welcome', ['name' => auth()->user()->name]) }}
    </h1>
    <p class="text-slate-600 mb-6">{{ __('messages.shop.portal_desc') }}</p>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6">
        <div class="flex flex-col">
            <div class="text-slate-800 text-xl font-bold py-2">{{ __('messages.shop.pesticide_application') }}</div>
            @if($shop = auth()->user()->pesticideShop)
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4 flex flex-col h-full">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-50 pb-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">{{ $shop->name }}</h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('messages.shop_dashboard.submitted') }}: {{ $shop->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                                    @if($shop->status === 'approved') bg-emerald-100 text-emerald-800
                                    @elseif($shop->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-amber-100 text-amber-800 @endif">
                            {{ __('messages.pesticide_shops.status_' . $shop->status) }}
                        </span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-slate-600 flex-grow">
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.nrc_number') }}</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->nrc }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.township') }}</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->township }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.proposed_selling_address') }}</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->requested_selling_address }}</span>
                        </div>
                    </div>
                        @if($shop->status === 'rejected' && $shop->rejection_reason)
                        <div class="grid sm_grid-cols-1 gap-4 text-md text-red-400 flex-grow p-4 bg-red-200 rounded-xl">
                            <span class="font-bold text-red-700 block text-md uppercase tracking-wide">{{ __('messages.shop_dashboard.rejection_reason') }}</span>
                            <p class="font-bold underline text-red-400">{{ $shop->rejection_reason }}</p>
                        </div>
                        @endif

                         @if($shop->status === 'approved')
                        <div class="grid sm_grid-cols-1 gap-4 text-md text-green-400 flex-grow p-4 bg-green-200 rounded-xl">
                            <p class="font-bold text-slate-800">တစ်လအတွင်း ကွင်းဆင်းစစ်ဆေးပါမည်။ကွင်းဆင်းစစ်ဆေးမှု့အောင်မြင်ပါက လိုင်စင်ထုတ်ပေးပါမည်။</p>
                        </div>
                        @endif

                    <div class="pt-2 border-t border-slate-50 flex items-center justify-between gap-4 mt-auto">
                        @if($shop->status === 'rejected')
                            <a href="{{ route('shop.licenseEditForm', $shop->id) }}" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-sm">{{ __('messages.common.update') }} &rarr;</a>
                        
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm text-center flex flex-col justify-center items-center h-full">
                    <h3 class="font-black text-slate-900">{{ __('messages.shop.no_application_pesticide') }}</h3>
                    <a href="{{ route('shop.licenseRegisterationForm') }}" class="mt-4 px-5 py-3 bg-emerald-700 text-white text-xs font-black rounded-xl">
                        {{ __('messages.shop.to_fill_application') }}</a>
                </div>
            @endif
        </div>

        <div class="flex flex-col">
            <div class="text-slate-800 text-xl font-bold py-2">{{ __('messages.shop.fertilizer_application') }}</div>
            <div class="bg-white rounded-3xl border border-emerald-100 p-6 shadow-sm space-y-4 flex flex-col h-full">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-50 pb-4">
                    <div>
                       
                    </div>
                    @if($latestFertilizerLicense)
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $latestFertilizerLicense->status == 'cancelled' ? ' bg-red-100' : ' bg-emerald-100' }} text-emerald-800">
                            {{ __('messages.fertilizer_license.statuses.'.$latestFertilizerLicense->status) }}
                        </span>
                    @endif
                </div>

                @if($latestFertilizerLicense)
                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-slate-600 flex-grow">
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.applicant') }}</span>
                            <span class="font-semibold text-slate-800">{{ $latestFertilizerLicense->applicant_name }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.nrc_number') }}</span>
                            <span class="font-semibold text-slate-800">{{ $latestFertilizerLicense->nrc_number }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.shop_dashboard.distribution_address') }}</span>
                            <span class="font-semibold text-slate-800">{{ $latestFertilizerLicense->distribution_location_address }}</span>
                        </div>
                        @if($latestFertilizerLicense->isCancelled() && $latestFertilizerLicense->cancelled_reason)
                            <div class="sm:col-span-2 bg-red-200 p-4 rounded-xl gap-4">
                                <span class="font-bold text-red-800 block text-xs uppercase tracking-wide">{{ __('messages.fertilizer_license.cancelled_reason') }}</span>
                                <span class="font-semibold text-red-700">{{ $latestFertilizerLicense->cancelled_reason }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <h3 class="font-black text-slate-900">{{ __('messages.shop.no_application_fertilizer') }}</h3>
                @endif

                <div class="bg-white rounded-3xl p-6 text-center flex flex-col justify-center items-center h-full">
                    @if($latestFertilizerLicense && $latestFertilizerLicense->status == 'cancelled')
                        <a href="{{ route('shop.fertilizer-licenses.edit', $latestFertilizerLicense) }}" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition">{{ __('messages.common.update') }}</a>
                    @elseif(!$latestFertilizerLicense)
                        <a href="{{ route('shop.fertilizer-licenses.create') }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition">
                            {{ __('messages.shop.to_fill_application') }}</a>
                            
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection