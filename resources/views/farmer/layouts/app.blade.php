<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.farmer.portal')) · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50 text-slate-900 font-sans min-h-screen flex flex-col">
    <header class="site-header bg-emerald-900 text-white shadow-lg sticky top-0 z-[100] overflow-visible">
        <div class="max-w-3xl mx-auto px-4 py-3 relative overflow-visible">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2 min-w-0">
                    <span class="p-1.5 rounded-lg bg-emerald-800/60 shrink-0">
                        <i data-lucide="sprout" class="w-5 h-5 text-emerald-200"></i>
                    </span>
                    <span class="font-bold truncate">{{ __('messages.farmer.portal') }}</span>
                </a>

                <div class="flex items-center gap-1 shrink-0">
                    @include('components.locale-switcher')
                    @include('farmer.partials.notifications')
                    <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg hover:bg-emerald-800" title="{{ __('messages.auth.sign_out') }}">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                    <button type="button" id="farmerMobileNavBtn"
                        class="md:hidden p-2 rounded-lg hover:bg-emerald-800 transition"
                        aria-label="{{ __('messages.nav.open_menu') }}"
                        aria-expanded="false"
                        aria-controls="farmerMobileNavDrawer">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            @include('farmer.layouts.partials.nav', ['context' => 'desktop'])
        </div>
    </header>

    <x-mobile-nav-drawer id="farmerMobileNav" :title="__('messages.farmer.portal')">
        @include('farmer.layouts.partials.nav', ['context' => 'drawer'])
    </x-mobile-nav-drawer>

    <main class="flex-1 max-w-3xl w-full mx-auto px-4 py-6">
        @include('admin.partials.alerts')
        @yield('content')
    </main>

    @stack('scripts')
    @include('partials.mobile-nav-script')
    @include('partials.content-module-nav-script')
</body>
</html>
