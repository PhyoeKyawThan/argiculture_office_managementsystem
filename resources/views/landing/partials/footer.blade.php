<footer class="mt-auto bg-emerald-950 text-emerald-200 py-8">
    <div class="max-w-6xl mx-auto px-4 text-center text-sm">
        @hasSection('footer')
            @yield('footer')
        @else
            <p>{{ __('messages.landing.footer_fallback') }}</p>
        @endif
    </div>
</footer>
