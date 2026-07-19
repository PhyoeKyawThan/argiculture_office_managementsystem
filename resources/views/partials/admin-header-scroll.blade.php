<script>
(function () {
    const SCROLL_THRESHOLD = 20;
    const header = document.getElementById('adminHeader');
    const menuBtn = document.getElementById('adminNavMenuBtn');
    const closeBtn = document.getElementById('adminNavMenuClose');
    const overlay = document.getElementById('adminNavOverlay');
    const drawer = document.getElementById('adminNavDrawer');

    if (!header) {
        return;
    }

    let isScrolled = false;
    let isDrawerOpen = false;
    let scrollTimer = null;

    function closeDropdowns() {
        document.getElementById('userMenu')?.classList.add('hidden');
        document.getElementById('notificationMenu')?.classList.add('hidden');
    }

    function openDrawer() {
        if (!overlay || !drawer || !menuBtn) {
            return;
        }

        isDrawerOpen = true;
        overlay.classList.remove('hidden');
        requestAnimationFrame(function () {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
        });
        drawer.classList.remove('-translate-x-full');
        drawer.setAttribute('aria-hidden', 'false');
        menuBtn.setAttribute('aria-expanded', 'true');
        document.body.classList.add('overflow-hidden');
        closeDropdowns();

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function closeDrawer() {
        if (!overlay || !drawer || !menuBtn) {
            return;
        }

        isDrawerOpen = false;
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100', 'pointer-events-auto');
        drawer.classList.add('-translate-x-full');
        drawer.setAttribute('aria-hidden', 'true');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('overflow-hidden');

        window.setTimeout(function () {
            if (!isDrawerOpen) {
                overlay.classList.add('hidden');
            }
        }, 300);
    }

    function applyScrollState() {
        const currentScrollY = window.scrollY;
        const next = currentScrollY > SCROLL_THRESHOLD;

        if (next !== isScrolled) {
            isScrolled = next;
            header.dataset.scrolled = isScrolled ? 'true' : 'false';

            if (!isScrolled && isDrawerOpen) {
                closeDrawer();
            }
        }
    }

    function handleScroll() {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function() {
            applyScrollState();
            scrollTimer = null;
        }, 50);
    }

    if (menuBtn && overlay && drawer) {
        menuBtn.addEventListener('click', function (event) {
            event.stopPropagation();

            if (isDrawerOpen) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });

        closeBtn?.addEventListener('click', closeDrawer);
        overlay.addEventListener('click', closeDrawer);

        drawer.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeDrawer);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isDrawerOpen) {
                closeDrawer();
            }
        });
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    applyScrollState();
})();
</script>
