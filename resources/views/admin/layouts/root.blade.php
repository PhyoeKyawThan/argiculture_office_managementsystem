<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.app.brand') }} | @yield('title', __('messages.app.office_management'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>

<body class="bg-emerald-50 text-slate-900 font-sans min-h-screen">

    @php $u = auth()->user(); @endphp

    <header class="bg-emerald-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Row 1: brand title + language + profile (above nav) --}}
            <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-3 py-3">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="p-1.5 rounded-lg bg-emerald-800/60 shrink-0">
                        <i data-lucide="leaf" class="w-6 h-6 text-emerald-200"></i>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-xl font-bold tracking-tight truncate">{{ __('messages.app.brand') }}</span>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-emerald-300/90 hidden sm:block">{{ __('messages.app.office_management') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 md:gap-3 shrink-0 ms-auto">
                    @include('components.locale-switcher')
                    @if($u)
                        <div class="hidden sm:flex flex-col items-end leading-tight text-end max-w-[10rem] md:max-w-xs">
                            <span class="text-sm font-bold truncate w-full">{{ $u->name }}</span>
                            <span class="text-[10px] uppercase tracking-widest text-emerald-300 truncate w-full">{{ __('messages.roles.' . $u->role) }}</span>
                        </div>
                        <div class="relative" id="userMenuWrap">
                            <button type="button" id="userMenuBtn"
                                class="flex items-center gap-2 pl-3 pr-1 py-1 border border-emerald-800 rounded-full hover:bg-emerald-800 transition-all">
                                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-black text-xs shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-emerald-300"></i>
                            </button>
                            <div id="userMenu"
                                class="hidden absolute right-0 mt-2 w-56 bg-white text-slate-700 rounded-2xl shadow-2xl border border-emerald-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-emerald-50">
                                    <div class="text-sm font-black">{{ $u->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $u->email }}</div>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 flex items-center gap-2">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> {{ __('messages.auth.sign_out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Row 2: main navigation (desktop) --}}
            <div class="hidden md:block border-t border-emerald-800/50 py-2.5">
                @include('admin.layouts.nav')
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 sm:p-8 relative">
        @include('admin.partials.alerts')
        @yield('content')
    </main>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) window.lucide.createIcons();

            const btn = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userMenu');
            if (btn && menu) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    const wrap = document.getElementById('userMenuWrap');
                    if (wrap && !wrap.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
