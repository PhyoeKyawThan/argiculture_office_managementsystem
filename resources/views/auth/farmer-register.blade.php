<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.auth.farmer_register_title') }} · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>
<body class="bg-emerald-50 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="w-full max-w-md">
        <div class="flex justify-center mb-6">
            @include('components.locale-switcher', ['variant' => 'light'])
        </div>
        <a href="{{ route('landing.home') }}" class="flex items-center justify-center gap-2 mb-8 text-emerald-900">
            <i data-lucide="sprout" class="w-8 h-8"></i>
            <span class="text-2xl font-black">{{ __('messages.app.brand') }}</span>
        </a>
        <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-8">
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
    <script>document.addEventListener('DOMContentLoaded', () => window.lucide?.createIcons());</script>
</body>
</html>
