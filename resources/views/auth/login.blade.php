<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.auth.sign_in_title') }} · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="bg-emerald-50 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="w-full max-w-md">
        <div class="flex justify-center mb-6">
            @include('components.locale-switcher', ['variant' => 'light'])
        </div>
        <a href="{{ route('landing.home') }}" class="flex items-center justify-center gap-2 mb-8 text-emerald-900">
            <i data-lucide="leaf" class="w-8 h-8"></i>
            <span class="text-2xl font-black">{{ __('messages.app.brand') }}</span>
        </a>
        <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-8">
            <h1 class="text-xl font-black text-slate-900 mb-1">{{ __('messages.auth.sign_in_title') }}</h1>
            <p class="text-sm text-slate-500 mb-6">{{ __('messages.auth.sign_in_subtitle') }}</p>

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1">{{ __('messages.auth.password') }}</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    {{ __('messages.auth.remember_me') }}
                </label>
                <button type="submit"
                    class="w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition">
                    {{ __('messages.auth.sign_in') }}
                </button>
            </form>
        </div>
        <p class="text-center text-xs text-slate-500 mt-6">
            <a href="{{ route('landing.home') }}" class="text-emerald-700 font-semibold hover:underline">{{ __('messages.auth.back_home') }}</a>
        </p>
    </div>
    <script>document.addEventListener('DOMContentLoaded', () => window.lucide?.createIcons());</script>
</body>
</html>
