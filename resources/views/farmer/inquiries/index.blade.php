@extends('farmer.layouts.app')

@section('title', __('messages.inquiries.title'))

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-emerald-900">{{ __('messages.inquiries.title') }}</h1>
            <p class="text-sm text-slate-600">{{ __('messages.inquiries.farmer_subtitle') }}</p>
        </div>
        <a href="{{ route('farmer.inquiries.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-700 text-white font-bold rounded-xl text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('messages.inquiries.new') }}
        </a>
    </div>

    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">{{ __('messages.inquiries.all_statuses') }}</option>
            <option value="pending" @selected(request('status') === 'pending')>{{ __('messages.inquiries.status_pending') }}</option>
            <option value="answered" @selected(request('status') === 'answered')>{{ __('messages.inquiries.status_answered') }}</option>
        </select>
    </form>

    <div class="space-y-3">
        @forelse($inquiries as $inquiry)
            <a href="{{ route('farmer.inquiries.show', $inquiry) }}"
                class="block bg-white rounded-2xl border border-emerald-100 p-4 hover:shadow-md transition">
                <div class="flex items-start justify-between gap-2">
                    <h2 class="font-bold text-slate-900">{{ $inquiry->title }}</h2>
                    <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $inquiry->isAnswered() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $inquiry->isAnswered() ? __('messages.inquiries.status_answered') : __('messages.inquiries.status_pending') }}
                    </span>
                </div>
                <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ $inquiry->description }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $inquiry->created_at->format('M j, Y g:i A') }}</p>
            </a>
        @empty
            <p class="text-center text-slate-500 py-10 bg-white rounded-2xl border border-emerald-100">{{ __('messages.inquiries.no_records') }}</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $inquiries->links() }}</div>
@endsection
