@php $u = auth()->user(); @endphp
<nav class="flex flex-wrap items-center gap-x-3 gap-y-2 lg:gap-x-4" aria-label="{{ __('messages.nav.main_menu') }}">
    <a href="{{ route('admin.dashboard.index') }}"
        class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.dashboard.index') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} flex items-center gap-2.5">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
        {{ __('messages.nav.dashboard') }}
    </a>

    @if($u && $u->isBackOffice())
        <a href="{{ route('admin.staff.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.staff.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="users" class="w-4 h-4"></i>
            {{ __('messages.nav.staff') }}
        </a>
        <a href="{{ route('admin.pesticide-shop-inspections.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.pesticide-shop-inspections.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="clipboard-check" class="w-4 h-4"></i>
            {{ __('messages.nav.inspections') }}
        </a>
    @endif

    @if($u && $u->isAdmin())
        <a href="{{ route('admin.landing-sections.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.landing-sections.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="layout-template" class="w-4 h-4"></i>
            {{ __('messages.nav.landing_page') }}
        </a>
        <a href="{{ route('admin.users.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.users.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="shield" class="w-4 h-4"></i>
            {{ __('messages.nav.users') }}
        </a>
        <a href="#"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 text-emerald-100/60 cursor-not-allowed flex items-center gap-2.5">
            <i data-lucide="user-check" class="w-4 h-4"></i>
            {{ __('messages.nav.farmers') }}
            <span class="ml-0.5 px-1.5 py-0.5 text-[9px] font-black bg-amber-400 text-amber-900 rounded-full">{{ __('messages.nav.soon') }}</span>
        </a>
    @endif

    <a href="{{ route('landing.home') }}" target="_blank"
        class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 text-emerald-100 hover:bg-emerald-800 hover:text-white transition-all flex items-center gap-2.5">
        <i data-lucide="external-link" class="w-4 h-4"></i>
        {{ __('messages.nav.view_site') }}
    </a>
</nav>
