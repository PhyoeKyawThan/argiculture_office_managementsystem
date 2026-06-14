@extends('landing.layout')

@section('title', __('messages.auth.farmer_register_title'))

@section('content')
    <div class="flex items-center justify-center px-4 py-10 sm:py-16">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-6 sm:p-8">
                <h1 class="text-xl font-black text-slate-900 mb-1">{{ __('messages.auth.farmer_register_title') }}</h1>
                <p class="text-sm text-slate-500 mb-6">{{ __('messages.auth.farmer_register_subtitle') }}</p>

                @if($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('farmer.register.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.password') }}</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.users.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition">
                        {{ __('messages.auth.farmer_register') }}
                    </button>
                </form>
            </div>
            <p class="text-center text-sm text-slate-600 mt-6">
                {{ __('messages.auth.farmer_have_account') }}
                <a href="{{ route('login') }}" class="text-emerald-700 font-bold hover:underline">{{ __('messages.auth.farmer_sign_in') }}</a>
            </p>
        </div>
    </div>
@endsection
