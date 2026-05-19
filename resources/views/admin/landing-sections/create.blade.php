@extends('admin.layouts.root')

@section('title', __('messages.landing_sections.add_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.landing_sections.add_title') }}</h1>
    </div>
    <form method="POST" action="{{ route('admin.landing-sections.store') }}" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm max-w-2xl">
        @csrf
        @include('admin.landing-sections._form')
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition">{{ __('messages.common.create') }}</button>
            <a href="{{ route('admin.landing-sections.index') }}" class="px-5 py-2.5 text-slate-600 font-bold hover:text-slate-900">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
