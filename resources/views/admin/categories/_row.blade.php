@php
    $isRoot = $category->level === 1;
@endphp

<tr class="{{ $isRoot ? 'bg-emerald-50/30' : '' }} border-t border-emerald-50 hover:bg-emerald-50/50 transition-colors">
    <td class="p-4" style="padding-left: {{ ($category->level - 1) * 30 + 16 }}px">
        <div class="flex items-center">
            @if(!$isRoot)
                <span class="mr-2 text-emerald-400">↳</span>
            @endif
            <span class="{{ $isRoot ? 'font-bold text-emerald-900 text-lg' : 'text-emerald-700' }}">
                {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
            </span>
        </div>
    </td>
    
    <td class="p-4 text-center text-emerald-600">{{ $category->level }}</td>

    <td class="p-4 text-center">
        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $isRoot ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }}">
            {{ $category->children_count }}
        </span>
    </td>

    <td class="p-4 flex justify-center gap-2">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
    </td>
</tr>

@foreach($category->children as $child)
    @include('admin.categories._row', ['category' => $child])
@endforeach