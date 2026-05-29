@extends('farmer.layouts.app')

@section('title', __('messages.inquiries.show_title'))

@section('content')
    <div class="mb-4">
        <a href="{{ route('farmer.inquiries.index') }}" class="text-sm font-bold text-emerald-700">{{ __('messages.common.back_to_list') }}</a>
    </div>

    <article class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm mb-4">
        <div class="flex items-start justify-between gap-2 mb-3">
            <h1 class="text-xl font-black text-emerald-900">{{ $inquiry->title }}</h1>
            <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $inquiry->isAnswered() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ $inquiry->isAnswered() ? __('messages.inquiries.status_answered') : __('messages.inquiries.status_pending') }}
            </span>
        </div>
        <p class="text-xs text-slate-500 mb-4">{{ __('messages.inquiries.submitted') }}: {{ $inquiry->created_at->format('M j, Y g:i A') }}</p>
        <div class="prose prose-sm max-w-none text-slate-700 whitespace-pre-line">{{ $inquiry->description }}</div>
        @if($inquiry->attachment_path)
            <div class="mt-4 pt-4 border-t border-emerald-50">
                <a href="{{ $inquiry->attachmentUrl() }}" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700">
                    <i data-lucide="paperclip" class="w-4 h-4"></i>
                    {{ $inquiry->attachment_original_name ?? __('messages.common.download') }}
                </a>
            </div>
        @endif
    </article>

    @if($inquiry->isAnswered() && $inquiry->answer_body)
        <section class="bg-emerald-50 rounded-2xl border border-emerald-200 p-5">
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-800 mb-2">{{ __('messages.inquiries.expert_reply') }}</h2>
            @if($inquiry->responder)
                <p class="text-xs text-slate-600 mb-3">{{ $inquiry->responder->name }} · {{ $inquiry->answered_at?->format('M j, Y g:i A') }}</p>
            @endif
            <div class="text-slate-800 whitespace-pre-line leading-relaxed">{{ $inquiry->answer_body }}</div>
        </section>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-900 font-medium">
            {{ __('messages.inquiries.waiting_reply') }}
        </div>
    @endif
@endsection
