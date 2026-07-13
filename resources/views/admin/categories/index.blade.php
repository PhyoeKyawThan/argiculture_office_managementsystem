@extends('admin.layouts.root')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-emerald-900">{{ __('messages.nav.categories') }}</h1>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded-xl font-bold">{{ __('messages.category.add_category') }}</a>
    </div>
    <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4 flex gap-4">
        <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}"
            class="border border-emerald-200 rounded-lg px-4 py-2">

        <select name="parent_id" class="border border-emerald-200 rounded-lg px-4 py-2">
            <option value="">All Categories</option>
            <option value="0" {{ request('parent_id') == '0' ? 'selected' : '' }}>Root Categories</option>
            @foreach(\App\Models\Category::all() as $cat)
                <option value="{{ $cat->id }}" {{ request('parent_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg">Filter</button>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 py-2">Clear</a>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-emerald-50 text-emerald-800">
                <tr>
                    <th class="p-4">{{ __('messages.category.table.name') }}</th>
                    <th class="p-4">{{ __('messages.category.table.level') }}</th>
                    <th class="p-4">Parent ID</th>
                    <th class="p-4 text-center">{{ __('messages.common.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="border-t border-emerald-50 hover:bg-emerald-50/50">
                        <td class="p-4" style="padding-left: {{ ($category->level - 1) * 20 + 16 }}px">
                            {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
                        </td>
                        <td class="p-4">{{ $category->level }}</td>
                        <td class="p-4">{{ $category->parent_id ?? 'Root' }}</td>
                        <td class="p-4 flex justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-semibold">
                                {{ __('messages.common.edit') }}
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    {{ __('messages.common.delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection