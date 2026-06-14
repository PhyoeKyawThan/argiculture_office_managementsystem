@props([
    'context' => 'page',
    'modules' => [],
    'currentModule' => null,
    'currentSubType' => null,
])

@php
    use App\Support\AgriculturalContentCatalog;

    $isDesktopHeader = $context === 'desktop-header';
    $isMobileDrawer = $context === 'mobile-drawer';
    $isPage = $context === 'page';

    $moduleIsActive = fn (string $key) => request()->routeIs('news.*')
        && ($currentModule ?? request('module', AgriculturalContentCatalog::MODULE_NEWS)) === $key;

    $subTypeIsActive = fn (?string $type) => ($currentSubType ?? request('sub_type')) === $type;

    if ($isDesktopHeader) {
        $itemBase = 'flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition';
        $itemIdle = 'text-emerald-200 hover:bg-emerald-800 hover:text-white';
        $itemActive = 'bg-emerald-800 text-white';
    } elseif ($isMobileDrawer) {
        $itemBase = 'flex items-center gap-3 px-4 py-3 mx-2 rounded-xl text-sm font-semibold transition w-[calc(100%-1rem)]';
        $itemIdle = 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white';
        $itemActive = 'bg-emerald-800 text-white';
    } else {
        $itemBase = 'px-3 py-2 rounded-full text-xs sm:text-sm font-bold transition whitespace-nowrap';
        $itemIdle = 'bg-white border border-emerald-200 text-emerald-800 hover:bg-emerald-50';
        $itemActive = 'bg-emerald-700 text-white border border-emerald-700';
    }

    $subLinkBase = $isDesktopHeader || $isMobileDrawer
        ? 'block px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-900 transition'
        : 'block px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-emerald-50 transition';
    $subLinkActive = 'bg-emerald-100 text-emerald-900 font-bold';
@endphp

@if($isPage)
    {{-- Page: sub-type filter only (module switching is in the top navbar) --}}
    @if($currentModule && AgriculturalContentCatalog::moduleHasSubTypes($currentModule))
        <div class="mb-6 flex justify-center px-2" role="navigation" aria-label="{{ __('messages.announcements.sub_type_field') }}">
            {{-- Desktop: filter dropdown --}}
            <div class="hidden md:block relative z-10" data-content-nav-dropdown>
                <button type="button" data-content-nav-dropdown-trigger
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-emerald-200 rounded-xl text-sm font-bold text-emerald-900 shadow-sm hover:border-emerald-300 transition min-w-[12rem] justify-between">
                    <span class="truncate">
                        @if($currentSubType)
                            {{ __('messages.content.sub_types.'.$currentSubType) }}
                        @else
                            {{ __('messages.content.all_sub_types') }}
                        @endif
                    </span>
                    <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 text-emerald-600"></i>
                </button>
                <div data-content-nav-dropdown-panel
                    class="content-nav-dropdown-panel absolute left-1/2 -translate-x-1/2 top-full pt-2 hidden opacity-0 transition-opacity duration-200 ease-out z-30 pointer-events-none">
                    <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 p-3 w-72 pointer-events-auto">
                        <a href="{{ route('news.index', ['module' => $currentModule]) }}"
                            class="{{ $subLinkBase }} {{ ! $currentSubType ? $subLinkActive : '' }} font-semibold">
                            {{ __('messages.content.all_sub_types') }}
                        </a>
                        <div class="grid grid-cols-2 gap-0.5 mt-2 pt-2 border-t border-emerald-50">
                            @foreach(AgriculturalContentCatalog::subTypesFor($currentModule) as $type)
                                <a href="{{ route('news.index', ['module' => $currentModule, 'sub_type' => $type]) }}"
                                    class="{{ $subLinkBase }} {{ $subTypeIsActive($type) ? $subLinkActive : '' }}">
                                    {{ __('messages.content.sub_types.'.$type) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- Mobile: accordion --}}
            <div class="md:hidden w-full max-w-md" data-content-nav-accordion>
                <button type="button" data-content-nav-accordion-trigger
                    class="w-full flex items-center justify-between gap-2 px-4 py-3 bg-white border border-emerald-200 rounded-xl text-sm font-bold text-emerald-900 shadow-sm"
                    aria-expanded="false">
                    <span class="truncate text-left">
                        {{ __('messages.content.filter_sub_types') }}:
                        @if($currentSubType)
                            {{ __('messages.content.sub_types.'.$currentSubType) }}
                        @else
                            {{ __('messages.common.all') }}
                        @endif
                    </span>
                    <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 transition-transform duration-200 content-nav-chevron"></i>
                </button>
                <div data-content-nav-accordion-panel class="hidden mt-2 bg-white rounded-2xl border border-emerald-100 p-2 shadow-sm">
                    <a href="{{ route('news.index', ['module' => $currentModule]) }}"
                        class="{{ $subLinkBase }} {{ ! $currentSubType ? $subLinkActive : '' }} font-semibold">
                        {{ __('messages.common.all') }}
                    </a>
                    <div class="grid grid-cols-2 gap-0.5 mt-1 pt-1 border-t border-emerald-50">
                        @foreach(AgriculturalContentCatalog::subTypesFor($currentModule) as $type)
                            <a href="{{ route('news.index', ['module' => $currentModule, 'sub_type' => $type]) }}"
                                class="{{ $subLinkBase }} {{ $subTypeIsActive($type) ? $subLinkActive : '' }}">
                                {{ __('messages.content.sub_types.'.$type) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

@elseif($isDesktopHeader)
    @foreach($modules as $moduleKey)
        @php $active = $moduleIsActive($moduleKey); @endphp
        @if(AgriculturalContentCatalog::moduleHasSubTypes($moduleKey))
            <div class="relative shrink-0" data-content-nav-dropdown data-content-nav-dropdown-fixed>
                <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
                    class="{{ $itemBase }} {{ $active ? $itemActive : $itemIdle }}">
                    {{ __('messages.content.modules.'.$moduleKey.'.label') }}
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 opacity-70"></i>
                </a>
                <div data-content-nav-dropdown-panel
                    class="content-nav-dropdown-panel absolute left-0 top-full pt-1.5 hidden opacity-0 transition-opacity duration-200 ease-out z-[110] pointer-events-none">
                    <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100 p-3 w-72 pointer-events-auto">
                        <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
                            class="{{ $subLinkBase }} font-semibold {{ $active && ! ($currentSubType ?? request('sub_type')) ? $subLinkActive : '' }}">
                            {{ __('messages.common.all') }}
                        </a>
                        <div class="grid grid-cols-2 gap-0.5 mt-2 pt-2 border-t border-emerald-50">
                            @foreach(AgriculturalContentCatalog::subTypesFor($moduleKey) as $type)
                                <a href="{{ route('news.index', ['module' => $moduleKey, 'sub_type' => $type]) }}"
                                    class="{{ $subLinkBase }} {{ $active && $subTypeIsActive($type) ? $subLinkActive : '' }}">
                                    {{ __('messages.content.sub_types.'.$type) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
                class="{{ $itemBase }} {{ $active ? $itemActive : $itemIdle }} shrink-0">
                {{ __('messages.content.modules.'.$moduleKey.'.label') }}
            </a>
        @endif
    @endforeach

@elseif($isMobileDrawer)
    @foreach($modules as $moduleKey)
        @php $active = $moduleIsActive($moduleKey); @endphp
        @if(AgriculturalContentCatalog::moduleHasSubTypes($moduleKey))
            <div data-content-nav-accordion>
                <button type="button" data-content-nav-accordion-trigger
                    class="{{ $itemBase }} {{ $active ? $itemActive : $itemIdle }} justify-between"
                    aria-expanded="{{ $active ? 'true' : 'false' }}">
                    <span>{{ __('messages.content.modules.'.$moduleKey.'.label') }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 transition-transform duration-200 content-nav-chevron"></i>
                </button>
                <div data-content-nav-accordion-panel class="{{ $active ? '' : 'hidden' }} mx-2 mb-1 rounded-xl bg-emerald-950/40 border border-emerald-800/50 overflow-hidden">
                    <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
                        class="block px-4 py-2.5 text-sm font-semibold text-emerald-100 hover:bg-emerald-800/50 {{ $active && ! ($currentSubType ?? request('sub_type')) ? 'bg-emerald-800/60' : '' }}">
                        {{ __('messages.common.all') }}
                    </a>
                    @foreach(AgriculturalContentCatalog::subTypesFor($moduleKey) as $type)
                        <a href="{{ route('news.index', ['module' => $moduleKey, 'sub_type' => $type]) }}"
                            class="block px-4 py-2 text-sm text-emerald-200/90 hover:bg-emerald-800/50 hover:text-white {{ $subTypeIsActive($type) ? 'bg-emerald-800/60 font-bold text-white' : '' }}">
                            {{ __('messages.content.sub_types.'.$type) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
                class="{{ $itemBase }} {{ $active ? $itemActive : $itemIdle }}">
                {{ __('messages.content.modules.'.$moduleKey.'.label') }}
            </a>
        @endif
    @endforeach
@endif
