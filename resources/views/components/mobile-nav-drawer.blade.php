@props([
    'id' => 'mobileNav',
    'title' => '',
])

<div id="{{ $id }}Overlay"
    class="fixed inset-0 bg-black/50 z-[60] hidden md:hidden transition-opacity"
    aria-hidden="true"></div>

<aside id="{{ $id }}Drawer"
    class="fixed top-0 right-0 z-[70] h-full w-[min(100vw,20rem)] bg-emerald-900 text-white shadow-2xl translate-x-full transition-transform duration-300 ease-out md:hidden flex flex-col"
    aria-label="{{ $title }}"
    aria-hidden="true">
    <div class="flex items-center justify-between gap-3 p-4 border-b border-emerald-800/80 shrink-0">
        <span class="font-bold truncate">{{ $title }}</span>
        <button type="button" id="{{ $id }}Close" class="p-2 rounded-lg hover:bg-emerald-800 shrink-0" aria-label="{{ __('messages.nav.close_menu') }}">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto py-2">
        {{ $slot }}
    </div>
</aside>
