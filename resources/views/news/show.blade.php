@extends('landing.layout')

@section('title', $announcement->title)

@section('content')
    <article class="max-w-3xl mx-auto px-4 py-10">
        <a href="{{ route('news.index') }}" class="text-sm font-bold text-emerald-700 mb-6 inline-block">{{ __('messages.common.back_to_list') }}</a>

        <header class="mb-6">
            <span class="text-xs font-black uppercase tracking-wider text-emerald-600">{{ __('messages.announcements.categories.'.$announcement->category) }}</span>
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
