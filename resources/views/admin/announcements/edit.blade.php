@extends('admin.layouts.root')

@section('title', __('messages.announcements.edit_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.announcements.edit_title') }}</h1>
        <p class="text-slate-600 text-sm font-mono mt-1">{{ $announcement->slug }}</p>
    </div>
    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" enctype="multipart/form-data" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.announcements._form', ['announcement' => $announcement])
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800">{{ __('messages.common.save') }}</button>
            <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2.5 text-slate-600 font-bold">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
