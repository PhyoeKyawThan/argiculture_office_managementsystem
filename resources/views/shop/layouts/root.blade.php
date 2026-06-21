<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.shop.title')) · {{ __('messages.app.brand') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-emerald-50 min-h-screen font-sans">
    <header class="bg-emerald-900 text-white px-4 sm:px-6 py-4 flex items-center justify-between gap-3">
        <span class="font-bold text-lg">{{ __('messages.shop.title') }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm text-emerald-200 hover:text-white font-semibold">{{ __('messages.auth.sign_out') }}</button>
        </form>
    </header>
    <main class="w-full h-full mx-auto p-6 sm:p-8">
        <div class="flex items-center gap-3 text-sm text-slate-500 mb-6">
            <a href="{{ route('landing.home') }}" class="hover:underline">{{ __('messages.shop.go_back_home') }}</a>
            <span>&middot;</span>
            @yield('breadcumb')
        </div>
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>