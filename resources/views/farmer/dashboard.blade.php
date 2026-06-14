@extends('farmer.layouts.app')

@section('title', __('messages.nav.dashboard'))

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-black text-emerald-900">{{ __('messages.farmer.welcome', ['name' => auth()->user()->name]) }}</h1>
        <p class="text-slate-600 text-sm mt-1">{{ __('messages.farmer.dashboard_subtitle') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white rounded-2xl border border-amber-100 p-4">
            <p class="text-xs font-bold uppercase text-amber-700">{{ __('messages.farmer.pending_questions') }}</p>
            <p class="text-3xl font-black text-amber-900 mt-1">{{ $pendingCount }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-emerald-100 p-4">
            <p class="text-xs font-bold uppercase text-emerald-700">{{ __('messages.farmer.answered_questions') }}</p>
            <p class="text-3xl font-black text-emerald-900 mt-1">{{ $answeredCount }}</p>
        </div>
    </div>

    @if(\App\Support\Feature::enabled('farmer_inquiries'))
        <a href="{{ route('farmer.inquiries.create') }}"
            class="flex items-center justify-center gap-2 w-full py-4 mb-8 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-2xl shadow-lg transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            {{ __('messages.farmer.ask_question') }}
        </a>
    @endif

    @if(\App\Support\Feature::enabled('farmer_inquiries'))
    <section class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-black text-emerald-900">{{ __('messages.farmer.my_questions') }}</h2>
            <a href="{{ route('farmer.inquiries.index') }}" class="text-sm font-bold text-emerald-700">{{ __('messages.farmer.view_all_questions') }}</a>
        </div>
        <div class="space-y-3">
            @forelse($recentInquiries as $inquiry)
                <a href="{{ route('farmer.inquiries.show', $inquiry) }}"
                    class="block bg-white rounded-2xl border border-emerald-100 p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-bold text-slate-900 line-clamp-2">{{ $inquiry->title }}</h3>
                        <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $inquiry->isAnswered() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $inquiry->isAnswered() ? __('messages.inquiries.status_answered') : __('messages.inquiries.status_pending') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">{{ $inquiry->created_at->format('M j, Y') }}</p>
                </a>
            @empty
                <p class="text-sm text-slate-500 bg-white rounded-2xl border border-emerald-100 p-4">{{ __('messages.inquiries.no_records') }}</p>
            @endforelse
        </div>
    </section>
    @endif

    <section>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-black text-emerald-900">{{ __('messages.farmer.latest_news') }}</h2>
            <a href="{{ route('news.index') }}" class="text-sm font-bold text-emerald-700">{{ __('messages.farmer.view_all_news') }}</a>
        </div>
        <div class="space-y-3">
            @forelse($latestNews as $article)
                <a href="{{ route('news.show', $article) }}"
                    class="block bg-white rounded-2xl border border-emerald-100 overflow-hidden hover:shadow-md transition">
                    @if($article->featured_image_path)
                        <img src="{{ $article->featuredImageUrl() }}" alt="" class="w-full h-36 object-cover">
                    @endif
                    <div class="p-4">
                        <span class="text-[10px] font-black uppercase text-emerald-600">{{ __('messages.content.modules.'.$article->module.'.label') }}</span>
                        <h3 class="font-bold text-slate-900 mt-1">{{ $article->title }}</h3>
                        <p class="text-xs text-slate-500 mt-2">{{ $article->published_at?->format('M j, Y') }}</p>
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-500 bg-white rounded-2xl border border-emerald-100 p-4">{{ __('messages.announcements.no_public_records') }}</p>
            @endforelse
        </div>
    </section>
@endsection
