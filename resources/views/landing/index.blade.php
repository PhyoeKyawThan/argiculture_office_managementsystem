@extends('landing.layout')

@section('title', $hero?->title ?? __('messages.app.brand'))

@section('content')
    @if($hero)
        <section class="bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-950 text-white">
            <div class="max-w-6xl mx-auto px-4 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-emerald-300 text-sm font-bold uppercase tracking-widest mb-3">{{ $hero->subtitle }}</p>
                    <h1 class="text-4xl lg:text-5xl font-black tracking-tight mb-6">{{ $hero->title }}</h1>
                    <p class="text-emerald-100 text-lg leading-relaxed mb-8">{{ $hero->body }}</p>
                    @if($hero->link_url && $hero->link_label)
                        <a href="{{ $hero->link_url }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-emerald-900 rounded-xl font-bold hover:bg-emerald-50 transition shadow-lg">
                            @if($hero->icon)
                                <i data-lucide="{{ $hero->icon }}" class="w-5 h-5"></i>
                            @endif
                            {{ $hero->link_label }}
                        </a>
                    @endif
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="w-72 h-72 rounded-3xl bg-emerald-800/50 border border-emerald-700 flex items-center justify-center">
                        <i data-lucide="leaf" class="w-32 h-32 text-emerald-300/80"></i>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($features->isNotEmpty())
        <section class="max-w-6xl mx-auto px-4 py-16">
            <h2 class="text-2xl font-black text-emerald-900 mb-10 text-center">{{ __('messages.landing.platform_capabilities') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($features as $feature)
                    <article class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 hover:shadow-md transition">
                        @if($feature->icon)
                            <span class="inline-flex p-3 rounded-xl bg-emerald-100 text-emerald-800 mb-4">
                                <i data-lucide="{{ $feature->icon }}" class="w-6 h-6"></i>
                            </span>
                        @endif
                        <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $feature->title }}</h3>
                        @if($feature->subtitle)
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2">{{ $feature->subtitle }}</p>
                        @endif
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $feature->body }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if($stats->isNotEmpty())
        <section class="bg-emerald-900 text-white py-14">
            <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                @foreach($stats as $stat)
                    <div>
                        @if($stat->icon)
                            <i data-lucide="{{ $stat->icon }}" class="w-8 h-8 mx-auto text-emerald-300 mb-3"></i>
                        @endif
                        <div class="text-4xl font-black">{{ $stat->title }}</div>
                        <div class="text-emerald-300 font-semibold mt-1">{{ $stat->subtitle }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($cta)
        <section class="max-w-6xl mx-auto px-4 py-16">
            <div class="bg-white rounded-3xl border border-emerald-100 p-10 text-center shadow-sm">
                <h2 class="text-2xl font-black text-emerald-900 mb-3">{{ $cta->title }}</h2>
                @if($cta->body)
                    <p class="text-slate-600 mb-6 max-w-xl mx-auto">{{ $cta->body }}</p>
                @endif
                @if($cta->link_url && $cta->link_label)
                    <a href="{{ $cta->link_url }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-700 text-white rounded-xl font-bold hover:bg-emerald-800 transition">
                        @if($cta->icon)
                            <i data-lucide="{{ $cta->icon }}" class="w-5 h-5"></i>
                        @endif
                        {{ $cta->link_label }}
                    </a>
                @endif
            </div>
        </section>
    @endif

    @if(\App\Support\Feature::enabled('content_news') && $latestNews->isNotEmpty())
        <section class="max-w-6xl mx-auto px-4 py-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-emerald-900">{{ __('messages.farmer.latest_news') }}</h2>
                    <p class="text-slate-600 text-sm mt-1">{{ __('messages.announcements.public_subtitle') }}</p>
                </div>
                <a href="{{ route('news.index') }}" class="text-sm font-bold text-emerald-700 whitespace-nowrap">{{ __('messages.farmer.view_all_news') }}</a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestNews as $article)
                    <a href="{{ route('news.show', $article) }}"
                        class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                        @if($article->featured_image_path)
                            <img src="{{ $article->featuredImageUrl() }}" alt="" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-5 flex flex-col flex-1">
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-600">{{ config('app.locale') === 'en' ? $article->category->name : $article->category->name_mm }}</span>
                            <h3 class="font-bold text-slate-900 mt-1 mb-2 line-clamp-2">{{ $article->title }}</h3>
                            <time class="text-xs text-slate-500 mt-auto">{{ $article->published_at?->format('M j, Y') }}</time>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@section('footer')
    @if($footer)
        <p class="font-bold text-white mb-1">{{ $footer->title }}</p>
        <p>{{ $footer->body }}</p>
    @else
        <p>{{ __('messages.landing.footer_fallback') }}</p>
    @endif
@endsection
