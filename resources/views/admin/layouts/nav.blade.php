@php
    $u = auth()->user();
    $variant = $variant ?? 'bar';

    $barLink = fn (bool $active) => 'admin-nav-link px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 flex items-center gap-2.5 '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white');

    $drawerLink = fn (bool $active) => 'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl text-sm font-semibold transition '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white');

    $navLink = $variant === 'drawer' ? $drawerLink : $barLink;
    $iconClass = $variant === 'drawer' ? 'w-5 h-5 shrink-0' : 'admin-nav-icon w-4 h-4 shrink-0';
    $navClass = $variant === 'drawer'
        ? 'flex flex-col gap-0.5'
        : 'flex flex-wrap items-center gap-x-3 gap-y-2 lg:gap-x-4';
@endphp

<nav class="{{ $navClass }}" aria-label="{{ __('messages.nav.main_menu') }}">
    <a href="{{ route('admin.dashboard.index') }}" class="{{ $navLink(request()->routeIs('admin.dashboard.index')) }}">
        <i data-lucide="layout-dashboard" class="{{ $iconClass }}"></i>
        {{ __('messages.nav.dashboard') }}
    </a>

    @if($u && $u->isBackOffice())
        @if(\App\Support\Feature::enabled('staff_management'))
            <a href="{{ route('admin.staff.index') }}" class="{{ $navLink(request()->routeIs('admin.staff.*')) }}">
                <i data-lucide="users" class="{{ $iconClass }}"></i>
                {{ __('messages.nav.staff') }}
            </a>
        @endif
        @if(\App\Support\Feature::enabled('shop_inspections'))
            <a href="{{ route('admin.pesticide-shop-inspections.index') }}" class="{{ $navLink(request()->routeIs('admin.pesticide-shop-inspections.*')) }}">
                <i data-lucide="clipboard-check" class="{{ $iconClass }}"></i>
                {{ __('messages.nav.inspections') }}
            </a>
        @endif
        @if(\App\Support\Feature::enabled('farmer_inquiries'))
            <a href="{{ route('admin.inquiries.index') }}" class="{{ $navLink(request()->routeIs('admin.inquiries.*')) }}">
                <i data-lucide="message-circle-question" class="{{ $iconClass }}"></i>
                {{ __('messages.nav.inquiries') }}
            </a>
        @endif
        <a href="{{ route('admin.announcements.index') }}" class="{{ $navLink(request()->routeIs('admin.announcements.*')) }}">
            <i data-lucide="newspaper" class="{{ $iconClass }}"></i>
            {{ __('messages.nav.announcements') }}
        </a>
        @if(\App\Support\Feature::enabled('shop_registration'))
            <a href="{{ route('admin.pesticide-shops.index') }}" class="{{ $navLink(request()->routeIs('admin.pesticide-shops.*')) }}">
                <i data-lucide="store" class="{{ $iconClass }}"></i>
                {{ __('messages.nav.shop_registrations') }}
            </a>
        @endif
    @endif

    @if($u && $u->isAdmin())
        <a href="{{ route('admin.feature-settings.edit') }}" class="{{ $navLink(request()->routeIs('admin.feature-settings.*')) }}">
            <i data-lucide="toggle-right" class="{{ $iconClass }}"></i>
            {{ __('messages.nav.features') }}
        </a>
        @if(\App\Support\Feature::enabled('landing_cms'))
            <a href="{{ route('admin.landing-sections.index') }}" class="{{ $navLink(request()->routeIs('admin.landing-sections.*')) }}">
                <i data-lucide="layout-template" class="{{ $iconClass }}"></i>
                {{ __('messages.nav.landing_page') }}
            </a>
        @endif
        <a href="{{ route('admin.users.index') }}" class="{{ $navLink(request()->routeIs('admin.users.*')) }}">
            <i data-lucide="shield" class="{{ $iconClass }}"></i>
            {{ __('messages.nav.users') }}
        </a>
    @endif

    <a href="{{ route('landing.home') }}" target="_blank"
        @class([
            $navLink(false),
            'admin-nav-link px-4 py-2.5 rounded-lg text-sm font-medium shrink-0 text-emerald-100 hover:bg-emerald-800 hover:text-white flex items-center gap-2.5' => $variant === 'bar',
        ])>
        <i data-lucide="external-link" class="{{ $iconClass }}"></i>
        {{ __('messages.nav.view_site') }}
    </a>
</nav>
