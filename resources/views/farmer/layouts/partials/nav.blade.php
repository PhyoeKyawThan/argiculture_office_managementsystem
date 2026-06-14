@php
    use App\Support\AgriculturalContentCatalog;
    use App\Support\Feature;

    $drawerLink = fn (bool $active) => 'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl text-sm font-semibold transition '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white');

    $desktopLink = fn (bool $active) => 'flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold transition '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-200 hover:bg-emerald-800 hover:text-white');

    $modules = $enabledModules ?? AgriculturalContentCatalog::enabledModules();
@endphp

@if($context === 'desktop')
    <nav class="hidden md:flex flex-wrap items-center gap-1 mt-2 pt-2 border-t border-emerald-800/50 overflow-visible relative" aria-label="{{ __('messages.nav.main_menu') }}">
        <a href="{{ route('farmer.dashboard') }}" class="{{ $desktopLink(request()->routeIs('farmer.dashboard')) }}">
            <i data-lucide="home" class="w-4 h-4"></i>
            {{ __('messages.nav.dashboard') }}
        </a>
        @if(Feature::enabled('farmer_inquiries'))
            <a href="{{ route('farmer.inquiries.index') }}" class="{{ $desktopLink(request()->routeIs('farmer.inquiries.*')) }}">
                <i data-lucide="message-circle-question" class="w-4 h-4"></i>
                {{ __('messages.inquiries.title') }}
            </a>
        @endif
        <x-content-module-nav context="desktop-header" :modules="$modules" />
    </nav>
@else
    <nav class="flex flex-col gap-0.5" aria-label="{{ __('messages.nav.main_menu') }}">
        <a href="{{ route('farmer.dashboard') }}" class="{{ $drawerLink(request()->routeIs('farmer.dashboard')) }}">
            <i data-lucide="home" class="w-5 h-5"></i>
            {{ __('messages.nav.dashboard') }}
        </a>
        @if(Feature::enabled('farmer_inquiries'))
            <a href="{{ route('farmer.inquiries.index') }}" class="{{ $drawerLink(request()->routeIs('farmer.inquiries.*')) }}">
                <i data-lucide="message-circle-question" class="w-5 h-5"></i>
                {{ __('messages.inquiries.title') }}
            </a>
        @endif
        <x-content-module-nav context="mobile-drawer" :modules="$modules" />
    </nav>

    <div class="my-3 mx-4 border-t border-emerald-800/80"></div>

    <div class="flex flex-col gap-0.5 px-2">
        <a href="{{ route('landing.home') }}" class="{{ $drawerLink(request()->routeIs('landing.home')) }}">
            <i data-lucide="globe" class="w-5 h-5"></i>
            {{ __('messages.nav.public_site') }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full {{ $drawerLink(false) }}">
                <i data-lucide="log-out" class="w-5 h-5"></i>
                {{ __('messages.auth.sign_out') }}
            </button>
        </form>
    </div>
@endif
