<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.app.brand')) · {{ __('messages.app.agriculture_office') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">
    <header class="site-header bg-emerald-900 text-white shadow-lg sticky top-0 z-[100] overflow-visible">
        <div class="max-w-6xl mx-auto px-4 relative overflow-visible">
            <div class="h-14 flex items-center justify-between gap-3">
                <a href="{{ route('landing.home') }}" class="flex items-center gap-2 shrink-0 min-w-0">
                    <span class="p-1.5 rounded-lg bg-emerald-800/60 shrink-0">
                        <i data-lucide="leaf" class="w-6 h-6 text-emerald-200"></i>
                    </span>
                    <span class="text-lg sm:text-xl font-bold tracking-tight truncate">{{ __('messages.app.brand') }}</span>
                </a>

                <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                    @include('components.locale-switcher')
                    <div class="hidden md:flex items-center gap-1 sm:gap-2 text-sm">
                        @auth
                            @if(auth()->user()->isBackOffice())
                                <a href="{{ route('admin.dashboard.index') }}" class="px-3 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.nav.dashboard') }}</a>
                            @elseif(auth()->user()->isShop())
                                <a href="{{ route('shop.dashboard') }}" class="px-3 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.common.shop') }}</a>
                            @elseif(auth()->user()->isFarmer())
                                <a href="{{ route('farmer.dashboard') }}" class="px-3 py-2 rounded-lg bg-emerald-800 hover:bg-emerald-700 font-semibold transition whitespace-nowrap">{{ __('messages.nav.farmer_portal') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-2 text-emerald-200 hover:text-white font-medium whitespace-nowrap">{{ __('messages.auth.sign_out') }}</button>
                            </form>
                        @else
                            @if(\App\Support\Feature::enabled('farmer_registration'))
                                <a href="{{ route('farmer.register') }}" class="px-3 py-2 rounded-lg border border-emerald-600 hover:bg-emerald-800 font-semibold transition whitespace-nowrap">{{ __('messages.auth.farmer_register') }}</a>
                            @endif
                            @if(\App\Support\Feature::enabled('shop_registration'))
                                <a href="{{ route('shop.register') }}" class="px-3 py-2 rounded-lg border border-emerald-600 hover:bg-emerald-800 font-semibold transition whitespace-nowrap">{{ __('messages.shop_reg.nav') }}</a>
                            @endif
                            <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg border border-emerald-700 hover:bg-emerald-800 font-semibold transition whitespace-nowrap">{{ __('messages.auth.sign_in_title') }}</a>
                        @endauth
                    </div>
                    <button type="button" id="publicMobileNavBtn"
                        class="md:hidden p-2 rounded-lg hover:bg-emerald-800 transition"
                        aria-label="{{ __('messages.nav.open_menu') }}"
                        aria-expanded="false"
                        aria-controls="publicMobileNavDrawer">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            @include('landing.partials.nav', ['context' => 'desktop', 'categories' => $categories ?? []])
        </div>
    </header>

    <x-mobile-nav-drawer id="publicMobileNav" :title="__('messages.app.brand')">
        @include('landing.partials.nav', ['context' => 'drawer', 'categories' => $categories ?? []])
    </x-mobile-nav-drawer>

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    @include('landing.partials.footer')

    @stack('scripts')
    @include('partials.mobile-nav-script')
    @include('partials.content-module-nav-script')
</body>
</html>
