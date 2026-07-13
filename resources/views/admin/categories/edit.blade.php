@extends('admin.layouts.root')

@section('title', 'Edit Category')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">Edit Category</h1>
        <p class="text-slate-600 mt-1">Update the details for "{{ $category->name }}".</p>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="w-full rounded-xl border-emerald-100 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">Category Name (MM)</label>
                    <input type="text" name="name_mm" value="{{ old('name_mm', $category->name_mm ) }}"
                        class="w-full rounded-xl border-emerald-100 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                        class="w-full rounded-xl border-emerald-100 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-emerald-900 mb-2">Parent Category</label>
                <select name="parent_id"
                    class="w-full rounded-xl border-emerald-100 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Root Level (No Parent) --</option>
                    @foreach($allCategories as $parent)
                        <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                            {{ str_repeat('— ', $parent->level - 1) }} {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-2">Updating the parent will automatically recalculate the category
                    level.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-2 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 rounded-xl font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition">Update
                    Category</button>
            </div>
        </form>
    </div>
@endsection