@php
    $isRoot = $category->level === 1;
@endphp

<tr class="{{ $isRoot ? 'bg-emerald-50/30' : '' }} border-t border-emerald-50 hover:bg-emerald-50/50 transition-colors">
    <td class="p-4" style="padding-left: {{ ($category->level - 1) * 30 + 16 }}px">
        <div class="flex items-center">
            @if(!$isRoot)
                <i data-lucide="corner-down-right" class="w-4 h-4 mr-2 text-emerald-400"></i>
            @endif
            <span class="{{ $isRoot ? 'font-bold text-emerald-900 text-lg' : 'text-emerald-700' }}">
                {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
            </span>
        </div>
    </td>
    
    <td class="p-4 text-emerald-600 font-bold">{{ $category->level }}</td>

    <td class="p-4">
        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $isRoot ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }}">
            {{ $category->children_count }}
        </span>
    </td>

    <td class="p-4 flex justify-end items-center gap-3">
        {{-- @if($category->level < 5)
            <a href="{{ route('admin.categories.create', ['parent_id' => $category->id]) }}" 
               class="text-emerald-600 hover:text-emerald-800 transition" title="Add Sub-category">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
            </a>
        @endif --}}

        <a href="{{ route('admin.categories.edit', $category->id) }}" 
           class="text-blue-600 hover:text-blue-800 transition" title="Edit">
            <i data-lucide="edit" class="w-5 h-5"></i>
        </a>
        
        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Delete" data-confirm data-confirm-message="@json(__('messages.common.confirm_delete'))" data-confirm-title="@json(__('messages.common.delete'))">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </form>
    </td>
</tr>

@foreach($category->children as $child)
    @include('admin.categories._row', ['category' => $child])
@endforeach