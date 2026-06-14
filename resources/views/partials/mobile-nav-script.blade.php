<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initMobileNav(prefix) {
            const btn = document.getElementById(prefix + 'Btn');
            const overlay = document.getElementById(prefix + 'Overlay');
            const drawer = document.getElementById(prefix + 'Drawer');
            const closeBtn = document.getElementById(prefix + 'Close');

            if (!btn || !overlay || !drawer) {
                return;
            }

            function openNav() {
                overlay.classList.remove('hidden');
                drawer.classList.remove('translate-x-full');
                drawer.setAttribute('aria-hidden', 'false');
                btn.setAttribute('aria-expanded', 'true');
                document.body.classList.add('overflow-hidden');
                if (window.lucide) window.lucide.createIcons();
            }

            function closeNav() {
                overlay.classList.add('hidden');
                drawer.classList.add('translate-x-full');
                drawer.setAttribute('aria-hidden', 'true');
                btn.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
            }

            btn.addEventListener('click', openNav);
            closeBtn?.addEventListener('click', closeNav);
            overlay.addEventListener('click', closeNav);
            drawer.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeNav));

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !drawer.classList.contains('translate-x-full')) {
                    closeNav();
                }
            });
        }

        if (window.lucide) window.lucide.createIcons();
        initMobileNav('publicMobileNav');
        initMobileNav('farmerMobileNav');
    });
</script>
