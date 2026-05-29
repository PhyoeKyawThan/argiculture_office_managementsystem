<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.app.brand')) · {{ __('messages.app.agriculture_office') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="bg-emerald-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between gap-3">
            <a href="{{ route('landing.home') }}" class="flex items-center gap-2 shrink-0">
                <span class="p-1.5 rounded-lg bg-emerald-800/60">
                    <i data-lucide="leaf" class="w-6 h-6 text-emerald-200"></i>
                </span>
                <span class="text-xl font-bold tracking-tight">{{ __('messages.app.brand') }}</span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3 text-sm flex-wrap justify-end">
                @include('components.locale-switcher')
                <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-lg text-emerald-100 hover:bg-emerald-800 font-semibold whitespace-nowrap hidden sm:inline">{{ __('messages.nav.news') }}</a>
                @auth
                    @if(auth()->user()->isBackOffice())
                        <a href="{{ route('admin.dashboard.index') }}" class="px-3 sm:px-4 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.nav.dashboard') }}</a>
                    @elseif(auth()->user()->isShop())
                        <a href="{{ route('shop.dashboard') }}" class="px-3 sm:px-4 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.common.shop') }}</a>
                    @elseif(auth()->user()->isFarmer())
                        <a href="{{ route('farmer.dashboard') }}" class="px-3 sm:px-4 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.nav.farmer_portal') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 sm:px-4 py-2 text-emerald-200 hover:text-white font-medium whitespace-nowrap">{{ __('messages.auth.sign_out') }}</button>
                    </form>
                @else
                    <a href="{{ route('farmer.register') }}" class="px-3 sm:px-4 py-2 rounded-lg border border-emerald-600 hover:bg-emerald-800 font-semibold transition whitespace-nowrap hidden sm:inline">{{ __('messages.auth.farmer_register') }}</a>
                    <a href="{{ route('login') }}" class="px-3 sm:px-4 py-2 rounded-lg border border-emerald-700 hover:bg-emerald-800 font-semibold transition whitespace-nowrap">{{ __('messages.auth.sign_in_title') }}</a>
                @endauth
            </div>
        </div>
    </header>

    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>
