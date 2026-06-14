<script>
    document.addEventListener('DOMContentLoaded', function () {
        const SHOW_DELAY = 80;
        const HIDE_DELAY = 180;

        function positionFixedPanel(wrapper, panel) {
            const trigger = wrapper.querySelector('a[href], [data-content-nav-dropdown-trigger]');
            if (!trigger) return;

            const rect = trigger.getBoundingClientRect();
            panel.style.position = 'fixed';
            panel.style.top = ''.concat(rect.bottom + 4, 'px');
            panel.style.left = ''.concat(rect.left, 'px');
            panel.style.zIndex = '110';
        }

        function resetPanelPosition(panel) {
            panel.style.position = '';
            panel.style.top = '';
            panel.style.left = '';
            panel.style.zIndex = '';
        }

        document.querySelectorAll('[data-content-nav-dropdown]').forEach(function (wrapper) {
            const panel = wrapper.querySelector('[data-content-nav-dropdown-panel]');
            const trigger = wrapper.querySelector('[data-content-nav-dropdown-trigger]');
            const useFixed = wrapper.hasAttribute('data-content-nav-dropdown-fixed');
            let showTimer = null;
            let hideTimer = null;

            if (!panel) return;

            function openPanel() {
                clearTimeout(hideTimer);

                if (useFixed) {
                    positionFixedPanel(wrapper, panel);
                }

                panel.classList.remove('hidden', 'pointer-events-none', 'opacity-0');
                panel.classList.add('opacity-100');
            }

            function closePanel() {
                panel.classList.add('opacity-0', 'pointer-events-none');
                hideTimer = setTimeout(function () {
                    panel.classList.add('hidden');
                    if (useFixed) {
                        resetPanelPosition(panel);
                    }
                }, 200);
            }

            function scheduleOpen() {
                clearTimeout(hideTimer);
                showTimer = setTimeout(openPanel, SHOW_DELAY);
            }

            function scheduleClose() {
                clearTimeout(showTimer);
                hideTimer = setTimeout(closePanel, HIDE_DELAY);
            }

            wrapper.addEventListener('mouseenter', scheduleOpen);
            wrapper.addEventListener('mouseleave', scheduleClose);
            panel.addEventListener('mouseenter', function () {
                clearTimeout(hideTimer);
            });
            panel.addEventListener('mouseleave', scheduleClose);

            if (useFixed) {
                window.addEventListener('scroll', closePanel, { passive: true });
                window.addEventListener('resize', function () {
                    if (!panel.classList.contains('hidden')) {
                        positionFixedPanel(wrapper, panel);
                    }
                });
            }

            if (trigger) {
                trigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (panel.classList.contains('hidden')) {
                        openPanel();
                    } else {
                        closePanel();
                    }
                });
            }
        });

        document.querySelectorAll('[data-content-nav-accordion]').forEach(function (accordion) {
            const trigger = accordion.querySelector('[data-content-nav-accordion-trigger]');
            const panel = accordion.querySelector('[data-content-nav-accordion-panel]');
            const chevron = accordion.querySelector('.content-nav-chevron') || trigger?.querySelector('[data-lucide="chevron-down"]');

            if (!trigger || !panel) return;

            trigger.addEventListener('click', function () {
                const expanded = trigger.getAttribute('aria-expanded') === 'true';
                trigger.setAttribute('aria-expanded', expanded ? 'false' : 'true');
                panel.classList.toggle('hidden', expanded);
                if (chevron) {
                    chevron.style.transform = expanded ? '' : 'rotate(180deg)';
                }
            });
        });

        if (window.lucide) window.lucide.createIcons();
    });
</script>
