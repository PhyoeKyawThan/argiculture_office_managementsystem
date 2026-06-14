@php
    use App\Support\AgriculturalContentCatalog;

    $modules = $enabledModules ?? AgriculturalContentCatalog::enabledModules();
    $linkClass = ($activeClass ?? 'text-emerald-200 hover:bg-emerald-800 hover:text-white');
    $activeClass = $activeClass ?? 'bg-emerald-800 text-white';
@endphp

@foreach($modules as $moduleKey)
    @php
        $isActive = request()->routeIs('news.*') && request('module', AgriculturalContentCatalog::MODULE_NEWS) === $moduleKey;
        $classes = $itemClass ?? 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition';
    @endphp
    <a href="{{ route('news.index', ['module' => $moduleKey]) }}"
        class="{{ $classes }} {{ $isActive ? $activeClass : $linkClass }}">
        <i data-lucide="{{ __('messages.content.modules.'.$moduleKey.'.icon') }}" class="w-4 h-4"></i>
        {{ __('messages.content.modules.'.$moduleKey.'.label') }}
    </a>
@endforeach
