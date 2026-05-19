@extends('admin.layouts.root')

@section('title', __('messages.users.edit_title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">{{ __('messages.users.edit_title') }}</h1>
        <p class="text-slate-600 text-sm">{{ $user->email }}</p>
    </div>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm max-w-xl">
        @csrf
        @method('PUT')
        @include('admin.users._form', ['user' => $user, 'roles' => $roles])
        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 text-white font-bold rounded-xl hover:bg-emerald-800 transition">{{ __('messages.common.save') }}</button>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-slate-600 font-bold hover:text-slate-900">{{ __('messages.common.cancel') }}</a>
        </div>
    </form>
@endsection
