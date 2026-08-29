@props(['category'])

<div class="relative">
    <a href="{{ route('news.category', $category->slug) }}" 
       class="flex justify-between items-center px-4 py-2 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-900 {{ request('categorySlug') == $category->slug ? 'bg-emerald-50 text-emerald-900 font-bold' : '' }}">
        {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
        
        @if($category->children->isNotEmpty())
            <i data-lucide="chevron-right" class="w-4 h-4 text-emerald-600"></i>
        @endif
    </a>
    
    @if($category->children->isNotEmpty())
        <div id="submenu-{{ $category->id }}" class="absolute left-full top-0 w-48 bg-white shadow-xl border border-emerald-100 rounded-2xl p-2 hidden z-50">
            @foreach($category->children as $child)
                <x-category-nav-item :category="$child" />
            @endforeach
        </div>
        <script>
            (function() {
                const parentDiv = document.getElementById('submenu-{{ $category->id }}').parentElement;
                const childMenu = document.getElementById('submenu-{{ $category->id }}');

                parentDiv.addEventListener('mouseenter', () => {
                    childMenu.classList.remove('hidden');
                });

                parentDiv.addEventListener('mouseleave', () => {
                    childMenu.classList.add('hidden');
                });
            })();
        </script>
    @endif
</div>
