@extends('admin.layouts.root')

@section('title', __('messages.announcements.add_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.announcements.add_title') }}</h1>
    </div>
    <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl border border-emerald-100 p-6 sm:p-8 shadow-sm">
        @csrf
        @include('admin.announcements._form', ['submitLabel' => __('messages.common.create')])
    </form>
@endsection
