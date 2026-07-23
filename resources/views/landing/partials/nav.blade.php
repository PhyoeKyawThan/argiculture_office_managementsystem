@php
    use App\Support\AgriculturalContentCatalog;
    use App\Support\Feature;

    $drawerLink = fn (bool $active) => 'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl text-sm font-semibold transition '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white');

    $desktopLink = fn (bool $active) => 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition '
        . ($active ? 'bg-emerald-800 text-white' : 'text-emerald-200 hover:bg-emerald-800 hover:text-white');

    $modules = $enabledModules ?? AgriculturalContentCatalog::enabledModules();
    $categories = collect($categories ?? []);
    $enabledCategories = $categories->filter(function ($category) use ($modules) {
        $module = str_replace('-', '_', $category->slug);
        return in_array($module, $modules);
    })->values();
@endphp

@if($context === 'desktop')
    <nav class="hidden md:flex flex-wrap items-center gap-1 pb-2.5 overflow-visible relative" aria-label="{{ __('messages.nav.main_menu') }}">
        <a href="{{ route('landing.home') }}" class="{{ $desktopLink(request()->routeIs('landing.home')) }}">
            <i data-lucide="home" class="w-4 h-4"></i>
            {{ __('messages.nav.home') }}
        </a>
        <x-content-module-nav context="desktop-header" :categories="$enabledCategories" />
    </nav>
@else
    <nav class="flex flex-col gap-0.5" aria-label="{{ __('messages.nav.main_menu') }}">
        <a href="{{ route('landing.home') }}" class="{{ $drawerLink(request()->routeIs('landing.home')) }}">
            <i data-lucide="home" class="w-5 h-5"></i>
            {{ __('messages.nav.home') }}
        </a>
        <x-content-module-nav context="mobile-drawer" :categories="$enabledCategories" />
    </nav>

    <div class="my-3 mx-4 border-t border-emerald-800/80"></div>

    <div class="flex flex-col gap-0.5 px-2">
        @auth
            @if(auth()->user()->isBackOffice())
                <a href="{{ route('admin.dashboard.index') }}" class="{{ $drawerLink(request()->routeIs('admin.*')) }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    {{ __('messages.nav.dashboard') }}
                </a>
            @elseif(auth()->user()->isShop())
                <a href="{{ route('shop.dashboard') }}" class="{{ $drawerLink(request()->routeIs('shop.*')) }}">
                    <i data-lucide="store" class="w-5 h-5"></i>
                    {{ __('messages.common.shop') }}
                </a>
            @elseif(auth()->user()->isFarmer())
                <a href="{{ route('farmer.dashboard') }}" class="{{ $drawerLink(request()->routeIs('farmer.*')) }}">
                    <i data-lucide="sprout" class="w-5 h-5"></i>
                    {{ __('messages.nav.farmer_portal') }}
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full {{ $drawerLink(false) }}">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    {{ __('messages.auth.sign_out') }}
                </button>
            </form>
        @else
            @if(Feature::enabled('farmer_registration'))
                <a href="{{ route('farmer.register') }}" class="{{ $drawerLink(request()->routeIs('farmer.register')) }}">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    {{ __('messages.auth.farmer_register') }}
                </a>
            @endif
            @if(Feature::enabled('shop_registration'))
                <a href="{{ route('shop.register') }}" class="{{ $drawerLink(request()->routeIs('shop.register')) }}">
                    <i data-lucide="store" class="w-5 h-5"></i>
                    {{ __('messages.shop_reg.title') }}
                </a>
            @endif
            @if(Feature::enabled('farmer_inquiries'))
                <a href="{{ route('login') }}" class="{{ $drawerLink(request()->routeIs('login')) }}">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    {{ __('messages.auth.sign_in_title') }}
                </a>
            @endif
        @endauth
    </div>
@endif
