<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.shop.title') }} · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50 min-h-screen font-sans">
    <header class="bg-emerald-900 text-white px-4 sm:px-6 py-4 flex items-center justify-between gap-3">
        <span class="font-bold text-lg">{{ __('messages.shop.title') }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-emerald-200 hover:text-white font-semibold">{{ __('messages.auth.sign_out') }}</button>
        </form>
    </header>
    <main class="max-w-3xl mx-auto p-6 sm:p-8">
        <h1 class="text-2xl font-black text-emerald-900 mb-2">{{ __('messages.shop.welcome', ['name' => auth()->user()->name]) }}</h1>
        <p class="text-slate-600 mb-6">{{ __('messages.shop.portal_desc') }}</p>

        @if($shop = auth()->user()->pesticideShop)
            <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm space-y-3 text-sm">
                <h2 class="text-lg font-black text-emerald-900">{{ $shop->shop_name }}</h2>
                <p><span class="font-bold text-slate-500">{{ __('messages.shop_reg.license_number') }}:</span> {{ $shop->license_number }}</p>
                <p><span class="font-bold text-slate-500">{{ __('messages.shop_reg.address') }}:</span> {{ $shop->address }}</p>
                <p><span class="font-bold text-slate-500">{{ __('messages.shop_reg.phone') }}:</span> {{ $shop->phone }}</p>
                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-black uppercase bg-emerald-100 text-emerald-800">{{ __('messages.shop_reg.statuses.approved') }}</span>
            </div>
        @endif
    </main>
</body>
</html>
