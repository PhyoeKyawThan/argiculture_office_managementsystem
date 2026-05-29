<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.farmer.portal')) · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="bg-emerald-50 text-slate-900 font-sans min-h-screen flex flex-col">
    <header class="bg-emerald-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-3xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2 min-w-0">
                    <span class="p-1.5 rounded-lg bg-emerald-800/60 shrink-0">
                        <i data-lucide="sprout" class="w-5 h-5 text-emerald-200"></i>
                    </span>
                    <span class="font-bold truncate">{{ __('messages.farmer.portal') }}</span>
                </a>
                <div class="flex items-center gap-2 shrink-0">
                    @include('components.locale-switcher')
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg hover:bg-emerald-800" title="{{ __('messages.auth.sign_out') }}">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-3xl w-full mx-auto px-4 py-6 pb-28">
        @include('admin.partials.alerts')
        @yield('content')
    </main>

    <nav class="fixed bottom-0 inset-x-0 bg-white border-t border-emerald-100 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] z-50 md:hidden">
        <div class="max-w-3xl mx-auto grid grid-cols-3 text-xs font-bold">
            <a href="{{ route('farmer.dashboard') }}"
                class="flex flex-col items-center gap-1 py-3 {{ request()->routeIs('farmer.dashboard') ? 'text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                {{ __('messages.nav.dashboard') }}
            </a>
            <a href="{{ route('farmer.inquiries.index') }}"
                class="flex flex-col items-center gap-1 py-3 {{ request()->routeIs('farmer.inquiries.*') ? 'text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="message-circle-question" class="w-5 h-5"></i>
                {{ __('messages.inquiries.title') }}
            </a>
            <a href="{{ route('news.index') }}"
                class="flex flex-col items-center gap-1 py-3 {{ request()->routeIs('news.*') ? 'text-emerald-700' : 'text-slate-500' }}">
                <i data-lucide="newspaper" class="w-5 h-5"></i>
                {{ __('messages.nav.news') }}
            </a>
        </div>
    </nav>

    @stack('scripts')
    <script>document.addEventListener('DOMContentLoaded', () => window.lucide?.createIcons());</script>
</body>
</html>
