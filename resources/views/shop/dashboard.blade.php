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

    @if($shop = auth()->user()->pesticideShop)
        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-50 pb-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900">{{ $shop->name }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Submitted: {{ $shop->created_at->format('M j, Y') }}</p>
                </div>

                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                            @if($shop->status === 'approved') bg-emerald-100 text-emerald-800
                            @elseif($shop->status === 'rejected') bg-red-100 text-red-800
                            @else bg-amber-100 text-amber-800 @endif">
                    {{  __('messages.pesticide_shops.status_' . $shop->status) }}
                </span>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 text-sm text-slate-600">
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
                @if($shop->license)
                    <div class="sm:col-span-2">
                        <span class="font-bold text-slate-400 block text-xs uppercase tracking-wide">License Number</span>
                        <span class="font-semibold text-slate-800 mt-0.5 inline-block bg-blue-100 px-2 py-1 rounded">{{ $shop->license->license_number }}</span>
                    </div>
                @endif
            </div>

            @if($shop->status === 'rejected' && $shop->rejection_reason)
                <div class="p-4 bg-red-50 border border-red-100 rounded-2xl text-sm text-red-800">
                    <p class="font-bold mb-1">Rejection Reason Note from Agriculture Inspector:</p>
                    <p class="text-xs text-slate-700 bg-white/50 p-2.5 rounded-xl border border-red-200/40 mt-1">
                        {{ $shop->rejection_reason }}</p>
                </div>
            @endif

            <div class="pt-2 border-t border-slate-50 flex items-center justify-between gap-4">
                @if($shop->status === 'pending' || $shop->status === 'rejected')
                    <div class="text-xs text-slate-400">
                        @if($shop->status === 'pending')
                            <span class="text-amber-600 font-bold">※ Under Review:</span> You can modify your responses while the
                            application is pending review.
                        @else
                            <span class="text-red-600 font-bold">※ Action Required:</span> Please update and fix the elements requested
                            by the inspector.
                        @endif
                    </div>
                    <a href="{{ route('shop.licenseEditForm', $shop->id) }}"
                        class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-sm whitespace-nowrap">
                        Update Application Data &rarr;
                    </a>
                @else
                    <div class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-100/60 px-3 py-2 rounded-xl w-full">
                        ✔ {{ __('messages.shop_dashboard.approved_notice') }}
                    </div>
                    <a href="{{ route('shop.licenseDownload', $shop->id) }}"
                        class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-sm whitespace-nowrap">
                        Download License Certificate &rarr;
                    </a>
                @endif
            </div>

        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm text-center max-w-xl mx-auto space-y-4 my-6">
            <div
                class="h-12 w-12 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-2xl flex items-center justify-center mx-auto text-xl font-bold">
                ၇
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900">No Submitted Form 7 Applications Found</h3>
                <p class="text-xs text-slate-400 mt-1">You have not registered your pesticide shop details yet. Please complete
                    your profile layout to gain access to trading allocations.</p>
            </div>
            <a href="{{ route('shop.licenseRegisterationForm') }}"
                class="inline-block px-5 py-3 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-black rounded-xl transition shadow-md shadow-emerald-700/10">
                Complete Form 7 License Profile
            </a>
        </div>
    @endif
@endsection