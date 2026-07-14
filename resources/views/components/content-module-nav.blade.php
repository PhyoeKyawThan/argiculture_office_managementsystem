@props([
    'context' => 'page',
    'modules' => [],
    'currentModule' => null,
    'currentSubType' => null,
    'categories' => [], 
])

@php
    $isDesktopHeader = $context === 'desktop-header';
    $isMobileDrawer = $context === 'mobile-drawer';
    $isPage = $context === 'page';
    
    if ($isDesktopHeader) {
        $itemBase = 'flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition';
        $itemIdle = 'text-emerald-200 hover:bg-emerald-800 hover:text-white';
        $itemActive = 'bg-emerald-800 text-white';
    } elseif ($isMobileDrawer) {
        $itemBase = 'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl text-sm font-semibold transition w-[calc(100%-1rem)]';
        $itemIdle = 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white';
        $itemActive = 'bg-emerald-800 text-white';
    }
@endphp

@if($isDesktopHeader)
    @foreach($categories as $category)
        @if($category->children->isNotEmpty())
            <div class="relative shrink-0" data-content-nav-dropdown>
                <a href="{{ route('news.index', ['category' => $category->slug]) }}"
                    class="{{ $itemBase }} {{ request('category') == $category->slug ? $itemActive : $itemIdle }}">
                    {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
                </a>
                <div data-content-nav-dropdown-panel
                    class="content-nav-dropdown-panel absolute left-0 top-full pt-1.5 hidden opacity-0 transition-opacity duration-200 ease-out z-[110] pointer-events-none">
                    <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 p-3 w-72 pointer-events-auto">
                        @foreach($category->children as $child)
                            <x-category-nav-item :category="$child" />
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('news.index', ['category' => $category->slug]) }}"
                class="{{ $itemBase }} {{ request('category') == $category->slug ? $itemActive : $itemIdle }} shrink-0">
                {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
            </a>
        @endif
    @endforeach

@elseif($isMobileDrawer)
    @foreach($categories as $category)
        @if($category->children->isNotEmpty())
            <div data-content-nav-accordion>
                <button type="button" data-content-nav-accordion-trigger
                    class="{{ $itemBase }} {{ $itemIdle }} justify-between">
                    <span>{{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 transition-transform duration-200 content-nav-chevron"></i>
                </button>
                <div data-content-nav-accordion-panel class="hidden mx-2 mb-1 rounded-xl bg-emerald-950/40 border border-emerald-800/50 overflow-hidden">
                    @foreach($category->children as $child)
                        <x-category-nav-item :category="$child" />
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ route('news.index', ['category' => $category->slug]) }}"
                class="{{ $itemBase }} {{ request('category') == $category->slug ? $itemActive : $itemIdle }}">
                {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
            </a>
        @endif
    @endforeach
@endif