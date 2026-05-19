@props(['variant' => 'dark'])

@php
    $locale = app()->getLocale();
@endphp

@if($variant === 'light')
    <div class="flex items-center gap-1 rounded-lg bg-slate-200/90 px-1.5 py-1 text-[11px] font-black uppercase tracking-wide border border-slate-300" role="navigation" aria-label="{{ __('messages.locale.language') }}">
        <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
            lang="en"
            class="px-2 py-0.5 rounded {{ $locale === 'en' ? 'bg-emerald-700 text-white shadow' : 'text-slate-700 hover:bg-slate-300' }}">{{ __('messages.locale.en') }}</a>
        <span class="text-slate-400 select-none">|</span>
        <a href="{{ route('locale.switch', ['locale' => 'my']) }}"
            lang="my"
            class="px-2 py-0.5 rounded {{ $locale === 'my' ? 'bg-emerald-700 text-white shadow' : 'text-slate-700 hover:bg-slate-300' }}">{{ __('messages.locale.my') }}</a>
    </div>
@else
    <div class="flex items-center gap-1 rounded-lg bg-emerald-800/40 px-1.5 py-1 text-[11px] font-black uppercase tracking-wide" role="navigation" aria-label="{{ __('messages.locale.language') }}">
        <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
            lang="en"
            class="px-2 py-0.5 rounded {{ $locale === 'en' ? 'bg-white text-emerald-900 shadow' : 'text-emerald-200 hover:text-white' }}">{{ __('messages.locale.en') }}</a>
        <span class="text-emerald-600 select-none">|</span>
        <a href="{{ route('locale.switch', ['locale' => 'my']) }}"
            lang="my"
            class="px-2 py-0.5 rounded {{ $locale === 'my' ? 'bg-white text-emerald-900 shadow' : 'text-emerald-200 hover:text-white' }}">{{ __('messages.locale.my') }}</a>
    </div>
@endif
