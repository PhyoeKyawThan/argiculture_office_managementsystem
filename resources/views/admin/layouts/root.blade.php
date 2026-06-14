<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.app.brand') }} | @yield('title', __('messages.app.office_management'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-emerald-50 text-slate-900 font-sans min-h-screen">

    @php $u = auth()->user(); @endphp

    <header id="adminHeader" class="admin-header" data-scrolled="false">
        <div class="admin-header-inner">
            {{-- Brand + hamburger (left) --}}
            <div class="admin-header-brand flex items-center gap-1 sm:gap-2">
                <button type="button" id="adminNavMenuBtn"
                    class="admin-header-hamburger"
                    aria-label="{{ __('messages.nav.open_menu') }}"
                    aria-expanded="false"
                    aria-controls="adminNavDrawer">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <div class="admin-header-logo-wrap p-1.5 rounded-lg bg-emerald-800/60 shrink-0">
                    <i data-lucide="leaf" class="admin-header-logo-icon w-6 h-6 text-emerald-200"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="admin-header-title text-xl font-bold tracking-tight truncate">{{ __('messages.app.brand') }}</span>
                    <span class="admin-header-subtitle text-[11px] font-semibold uppercase tracking-wider text-emerald-300/90 hidden sm:block truncate">{{ __('messages.app.office_management') }}</span>
                </div>
            </div>

            {{-- Full navigation bar (desktop, hidden when scrolled) --}}
            <div class="admin-header-nav">
                @include('admin.layouts.nav', ['variant' => 'bar'])
            </div>

            {{-- Actions (right) --}}
            <div class="admin-header-actions flex items-center gap-2 md:gap-3 shrink-0">
                @include('components.locale-switcher')
                @include('admin.partials.notifications')
                @if($u)
                    <div class="admin-header-user-meta hidden sm:flex flex-col items-end leading-tight text-end max-w-[10rem] md:max-w-xs">
                        <span class="text-sm font-bold truncate w-full">{{ $u->name }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-emerald-300 truncate w-full">{{ __('messages.roles.' . $u->role) }}</span>
                    </div>
                    <div class="relative" id="userMenuWrap">
                        <button type="button" id="userMenuBtn"
                            class="flex items-center gap-2 pl-3 pr-1 py-1 border border-emerald-800 rounded-full hover:bg-emerald-800 transition-all duration-300 ease-in-out">
                            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-black text-xs shrink-0">
                                {{ strtoupper(substr($u->name, 0, 2)) }}
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-emerald-300"></i>
                        </button>
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-56 bg-white text-slate-700 rounded-2xl shadow-2xl border border-emerald-50 overflow-hidden z-50">
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
    </header>

    {{-- Slide-out navigation drawer --}}
    <div id="adminNavOverlay"
        class="admin-nav-overlay fixed inset-0 bg-black/50 z-[60] hidden opacity-0 pointer-events-none"
        aria-hidden="true"></div>

    <aside id="adminNavDrawer"
        class="admin-nav-drawer fixed top-0 left-0 z-[70] h-full w-[min(100vw,18rem)] bg-emerald-900 text-white shadow-2xl -translate-x-full flex flex-col"
        aria-label="{{ __('messages.nav.main_menu') }}"
        aria-hidden="true">
        <div class="flex items-center justify-between gap-3 p-4 border-b border-emerald-800/80 shrink-0">
            <span class="font-bold truncate">{{ __('messages.app.brand') }}</span>
            <button type="button" id="adminNavMenuClose"
                class="p-2 rounded-lg hover:bg-emerald-800 shrink-0 transition-colors"
                aria-label="{{ __('messages.nav.close_menu') }}">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-2">
            @include('admin.layouts.nav', ['variant' => 'drawer'])
        </div>
    </aside>

    <main class="max-w-7xl mx-auto p-6 sm:p-8 relative">
        @include('admin.partials.alerts')
        @yield('content')
    </main>

    @stack('scripts')

    @include('partials.admin-header-scroll')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const btn = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userMenu');
            if (btn && menu) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                    document.getElementById('notificationMenu')?.classList.add('hidden');
                });
                document.addEventListener('click', (e) => {
                    const wrap = document.getElementById('userMenuWrap');
                    if (wrap && !wrap.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }

            const notifBtn = document.getElementById('notificationMenuBtn');
            const notifMenu = document.getElementById('notificationMenu');
            if (notifBtn && notifMenu) {
                notifBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    notifMenu.classList.toggle('hidden');
                    document.getElementById('userMenu')?.classList.add('hidden');
                });
                document.addEventListener('click', (e) => {
                    const wrap = document.getElementById('notificationMenuWrap');
                    if (wrap && !wrap.contains(e.target)) {
                        notifMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
