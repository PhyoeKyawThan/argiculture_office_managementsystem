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
        <a href="{{ route('admin.inquiries.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.inquiries.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="message-circle-question" class="w-4 h-4"></i>
            {{ __('messages.nav.inquiries') }}
        </a>
        <a href="{{ route('admin.announcements.index') }}"
            class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 {{ request()->routeIs('admin.announcements.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} transition-all flex items-center gap-2.5">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            {{ __('messages.nav.announcements') }}
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
    @endif

    <a href="{{ route('landing.home') }}" target="_blank"
        class="px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 text-emerald-100 hover:bg-emerald-800 hover:text-white transition-all flex items-center gap-2.5">
        <i data-lucide="external-link" class="w-4 h-4"></i>
        {{ __('messages.nav.view_site') }}
    </a>
</nav>
