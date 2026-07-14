{{-- @props(['category'])

<div>
    <a href="{{ route('announcements.index', ['category' => $category->slug]) }}" 
       class="block px-3 py-2 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-900 transition rounded-lg">
        {{ $category->name }}
    </a>
    
    @if($category->children->isNotEmpty())
        <div class="ml-4 pl-2 border-l border-emerald-100">
            @foreach($category->children as $child)
                <x-category-item :category="$child" />
            @endforeach
        </div>
    @endif
</div> --}}