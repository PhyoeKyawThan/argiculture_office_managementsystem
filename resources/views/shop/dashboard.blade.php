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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex flex-col">
            @if($shop = auth()->user()->pesticideShop)
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4 flex flex-col h-full">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-50 pb-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">{{ $shop->name }}</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Submitted: {{ $shop->created_at->format('M j, Y') }}</p>
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
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">NRC Number</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->nrc }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">Township</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->township }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">Proposed Selling Address</span>
                            <span class="font-semibold text-slate-800 mt-0.5 inline-block">{{ $shop->requested_selling_address }}</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-50 flex items-center justify-between gap-4 mt-auto">
                        @if($shop->status === 'pending' || $shop->status === 'rejected')
                            <a href="{{ route('shop.licenseEditForm', $shop->id) }}" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-sm">Update &rarr;</a>
                        @else
                            <a href="{{ route('shop.licenseDownload', $shop->id) }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-sm">Download &rarr;</a>
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
            <div class="bg-white rounded-3xl border border-emerald-100 p-6 shadow-sm space-y-4 flex flex-col h-full">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-50 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">{{ __('messages.shop.fertilizer_application') }}</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Manage distribution applications.</p>
                    </div>
                    @if($latestFertilizerLicense)
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800">
                            {{ ucfirst(str_replace('_', ' ', $latestFertilizerLicense->status)) }}
                        </span>
                    @endif
                </div>

                @if($latestFertilizerLicense)
                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-slate-600 flex-grow">
                        <div>
                            <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">Applicant</span>
                            <span class="font-semibold text-slate-800">{{ $latestFertilizerLicense->applicant_name }}</span>
                        </div>
                        @if($latestFertilizerLicense->isCancelled() && $latestFertilizerLicense->cancelled_reason)
                            <div class="sm:col-span-2">
                                <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">{{ __('messages.fertilizer_license.cancelled_reason') }}</span>
                                <span class="font-semibold text-red-700">{{ $latestFertilizerLicense->cancelled_reason }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-slate-600 flex-grow">{{ __('messages.shop.no_application_fertilizer') }}</p>
                @endif

                <div class="pt-2 border-t border-slate-50 flex items-center justify-end mt-auto">
                    @if($latestFertilizerLicense)
                        <a href="{{ route('shop.fertilizer-licenses.edit', $latestFertilizerLicense) }}" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition">Update Application</a>
                    @else
                        <a href="{{ route('shop.fertilizer-licenses.create') }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition">
                            {{ __('messages.shop.to_fill_application') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection