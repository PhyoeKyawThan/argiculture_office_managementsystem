@extends(auth()->check() && auth()->user()->isFarmer() ? 'farmer.layouts.app' : 'landing.layout')

@section('title', $announcement->title)

@section('content')
    <article class="max-w-3xl mx-auto px-0 py-4 sm:py-6">
        <a href="{{ route('news.index', ['module' => $announcement->module]) }}" class="text-sm font-bold text-emerald-700 mb-6 inline-block">{{ __('messages.common.back_to_list') }}</a>

        <header class="mb-6">
            <div class="flex flex-wrap gap-2 mb-2">
                <span class="text-xs font-black uppercase tracking-wider text-emerald-600">{{ __('messages.content.modules.'.$announcement->module.'.label') }}</span>
                @if($announcement->sub_type)
                    <span class="text-xs font-black uppercase tracking-wider text-slate-500">{{ __('messages.content.sub_types.'.$announcement->sub_type) }}</span>
                @endif
            </div>
            <h1 class="text-3xl font-black text-emerald-900 mt-2">{{ $announcement->title }}</h1>
            <p class="text-sm text-slate-500 mt-3">
                {{ $announcement->published_at?->format('M j, Y') }}
                @if($announcement->author)
                    · {{ __('messages.announcements.by_author', ['name' => $announcement->author->name]) }}
                @endif
            </p>
        </header>

        @if($announcement->featured_image_path)
            <img src="{{ $announcement->featuredImageUrl() }}" alt="" class="w-full rounded-2xl border border-emerald-100 mb-8 max-h-[420px] object-cover">
        @endif

        <div class="bg-white rounded-2xl border border-emerald-100 p-6 sm:p-8 shadow-sm text-slate-800 leading-relaxed whitespace-pre-line">
            {{ $announcement->content }}
        </div>
    </article>
@endsection
