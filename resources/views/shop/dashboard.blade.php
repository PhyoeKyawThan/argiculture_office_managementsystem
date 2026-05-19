<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.shop.title') }} · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-emerald-50 min-h-screen font-sans">
    <header class="bg-emerald-900 text-white px-6 py-4 flex items-center justify-between">
        <span class="font-bold text-lg">{{ __('messages.shop.title') }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-emerald-200 hover:text-white font-semibold">{{ __('messages.auth.sign_out') }}</button>
        </form>
    </header>
    <main class="max-w-3xl mx-auto p-8">
        <h1 class="text-2xl font-black text-emerald-900 mb-2">{{ __('messages.shop.welcome', ['name' => auth()->user()->name]) }}</h1>
        <p class="text-slate-600">{{ __('messages.shop.portal_desc') }}</p>
    </main>
</body>
</html>
