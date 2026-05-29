@extends('farmer.layouts.app')

@section('title', __('messages.inquiries.new_title'))

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-black text-emerald-900">{{ __('messages.inquiries.new_title') }}</h1>
        <p class="text-sm text-slate-600 mt-1">{{ __('messages.inquiries.new_subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('farmer.inquiries.store') }}" enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm space-y-4">
        @csrf
        <div>
            <label for="title" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inquiries.title_field') }}</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('title') border-red-400 @enderror">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="description" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.inquiries.description_field') }}</label>
            <textarea name="description" id="description" rows="6" required
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="attachment" class="block text-sm font-bold text-slate-700 mb-1">
                {{ __('messages.inquiries.attachment_field') }}
                <span class="font-normal text-slate-500">({{ __('messages.common.optional') }})</span>
            </label>
            <input type="file" name="attachment" id="attachment" accept=".jpg,.jpeg,.png,.webp,.pdf"
                class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 @error('attachment') border-red-400 @enderror">
            <p class="text-xs text-slate-500 mt-1">{{ __('messages.inquiries.attachment_hint') }}</p>
            @error('attachment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl">
                {{ __('messages.common.submit') }}
            </button>
            <a href="{{ route('farmer.inquiries.index') }}" class="px-4 py-3 text-slate-600 font-bold rounded-xl border border-slate-200">
                {{ __('messages.common.cancel') }}
            </a>
        </div>
    </form>
@endsection
