@extends('admin.layouts.root')

@section('title', __('messages.announcements.add_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.announcements.add_title') }}</h1>
    </div>
    <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
        @csrf
        @include('admin.announcements._form')
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800">{{ __('messages.common.create') }}</button>
            <a href="{{ route('admin.announcements.index') }}" class="px-5 py-2.5 text-slate-600 font-bold">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
