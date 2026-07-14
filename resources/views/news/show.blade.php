@extends(auth()->check() && auth()->user()->isFarmer() ? 'farmer.layouts.app' : 'landing.layout')

@section('title', $announcement->title)

@section('content')
    <article class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ route('news.index', ['category' => $announcement->category->slug]) }}" 
           class="text-sm font-bold text-emerald-700 mb-6 inline-flex items-center gap-1 hover:text-emerald-900">
            ← {{ __('messages.common.back_to_list') }}
        </a>

        <header class="mb-8">
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 rounded-lg">
                    {{ config('app.locale') === 'en' ? $announcement->category->name : $announcement->category->name_mm }}
                </span>
                @if($announcement->sub_type)
                    <span class="px-2 py-1 text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 rounded-lg">
                        {{ __('messages.content.sub_types.'.$announcement->sub_type) }}
                    </span>
                @endif
            </div>
            
            <h1 class="text-4xl font-black text-emerald-900">{{ $announcement->title }}</h1>
            
            <div class="flex items-center gap-4 text-sm text-slate-500 mt-4">
                <time>{{ $announcement->published_at?->format('M j, Y') }}</time>
                @if($announcement->author)
                    <span class="text-slate-300">|</span>
                    <span>{{ __('messages.announcements.by_author', ['name' => $announcement->author->name]) }}</span>
                @endif
            </div>
        </header>

        @if($announcement->featured_image_path)
            <figure class="mb-8">
                <img src="{{ $announcement->featuredImageUrl() }}" 
                     alt="{{ $announcement->title }}" 
                     class="w-full rounded-3xl border border-emerald-100 shadow-sm max-h-[420px] object-cover">
            </figure>
        @endif

        <div class="prose prose-emerald max-w-none bg-white rounded-3xl border border-emerald-100 p-8 shadow-sm">
            <div class="whitespace-pre-line text-slate-800 leading-relaxed">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>
    </article>
@endsection