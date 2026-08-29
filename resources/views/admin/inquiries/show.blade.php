@extends('admin.layouts.root')

@section('title', $inquiry->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-bold text-emerald-700">{{ __('messages.common.back_to_list') }}</a>
        <span class="text-slate-300 mx-2">|</span>
        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm font-bold text-red-600 hover:underline" data-confirm data-confirm-message="@json(__('messages.inquiries.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">{{ __('messages.common.delete') }}</button>
        </form>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <div class="flex items-start justify-between gap-2 mb-4">
                <h1 class="text-2xl font-black text-emerald-900">{{ $inquiry->title }}</h1>
                <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-bold uppercase {{ $inquiry->isAnswered() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $inquiry->isAnswered() ? __('messages.inquiries.status_answered') : __('messages.inquiries.status_pending') }}
                </span>
            </div>
            <dl class="grid gap-2 text-sm mb-4">
                <div><dt class="text-slate-500 inline">{{ __('messages.inquiries.farmer') }}:</dt> <dd class="inline font-semibold">{{ $inquiry->farmer?->name }} ({{ $inquiry->farmer?->email }})</dd></div>
                <div><dt class="text-slate-500 inline">{{ __('messages.inquiries.submitted') }}:</dt> <dd class="inline font-semibold">{{ $inquiry->created_at->format('M j, Y g:i A') }}</dd></div>
            </dl>
            <div class="text-slate-700 whitespace-pre-line leading-relaxed border-t border-emerald-50 pt-4">{{ $inquiry->description }}</div>
            @if($inquiry->attachment_path)
                <div class="mt-4">
                    <a href="{{ $inquiry->attachmentUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-emerald-700 font-bold text-sm">
                        <i data-lucide="paperclip" class="w-4 h-4"></i>
                        {{ $inquiry->attachment_original_name ?? __('messages.common.download') }}
                    </a>
                </div>
            @endif
        </section>

        <section class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h2 class="text-lg font-black text-emerald-900 mb-4">{{ __('messages.inquiries.expert_reply') }}</h2>
            <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="answer_body" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inquiries.answer_field') }}</label>
                    <textarea name="answer_body" id="answer_body" rows="10" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('answer_body') border-red-400 @enderror">{{ old('answer_body', $inquiry->answer_body) }}</textarea>
                    @error('answer_body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <input type="text" name="status" value="{{ \App\Models\AgriculturalInquiry::STATUS_ANSWERED }}" hidden />
                @if($inquiry->answered_at)
                    <p class="text-xs text-slate-500">{{ __('messages.inquiries.answered_at') }}: {{ $inquiry->answered_at->format('M j, Y g:i A') }}
                        @if($inquiry->responder) · {{ $inquiry->responder->name }} @endif
                    </p>
                @endif
                <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl">
                    {{ __('messages.inquiries.save_reply') }}
                </button>
            </form>
        </section>
    </div>
@endsection
