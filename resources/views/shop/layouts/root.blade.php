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
        <div class="flex items-center gap-2 sm:gap-3">
            @include('shop.partials.notifications')
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm text-emerald-200 hover:text-white font-semibold">{{ __('messages.auth.sign_out') }}</button>
            </form>
        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('shopNotificationMenuBtn');
            const menu = document.getElementById('shopNotificationMenu');

            if (!btn || !menu) {
                return;
            }

            btn.addEventListener('click', function (event) {
                event.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                const wrap = document.getElementById('shopNotificationMenuWrap');

                if (wrap && !wrap.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>