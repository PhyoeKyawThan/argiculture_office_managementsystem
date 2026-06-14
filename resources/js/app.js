import { createIcons, icons } from 'lucide';

window.lucide = { createIcons, icons }; 

function initLucideIcons() {
    createIcons({ icons });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucideIcons);
} else {
    initLucideIcons();
}