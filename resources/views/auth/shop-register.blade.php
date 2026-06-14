@extends('landing.layout')

@section('title', __('messages.shop_reg.title'))

@section('content')
    <div class="flex items-center justify-center px-4 py-10 sm:py-16">
        <div class="w-full max-w-lg">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-6 sm:p-8">
                <h1 class="text-xl font-black text-slate-900 mb-1">{{ __('messages.shop_reg.title') }}</h1>
                <p class="text-sm text-slate-500 mb-6">{{ __('messages.shop_reg.subtitle') }}</p>

                @if(session('success'))
                    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('shop.register.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="shop_name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.shop_name') }}</label>
                        <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="owner_name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.owner_name') }}</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="license_number" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.license_number') }}</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.phone') }}</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.address') }}</label>
                        <textarea name="address" id="address" rows="2" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">{{ old('address') }}</textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="township" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.township') }}</label>
                            <input type="text" name="township" id="township" value="{{ old('township') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label for="region" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.shop_reg.region') }}</label>
                            <input type="text" name="region" id="region" value="{{ old('region') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition">
                        {{ __('messages.shop_reg.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
