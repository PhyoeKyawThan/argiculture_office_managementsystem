@extends('admin.layouts.root')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-emerald-900">Categories Management</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-700 transition">
        Add New Category
    </a>
</div>

<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6 flex gap-4">
    <select name="root_id" class="border border-emerald-200 rounded-lg px-4 py-2">
        <option value="">All Categories</option>
        @foreach($rootCategories as $cat)
            <option value="{{ $cat->id }}" {{ request('root_id') == $cat->id ? 'selected' : '' }}>
                {{ config('app.locale') === 'en' ? $cat->name : $cat->name_mm }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold">Filter</button>
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 py-2 hover:text-slate-800">Clear</a>
</form>

<div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm">
    <table class="w-full text-left">
        <thead class="bg-emerald-50 text-emerald-800 text-xs uppercase font-bold">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Level</th>
                <th class="px-6 py-4">Children(Sub Categories)</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-emerald-50">
            @foreach($categories as $category)
                @include('admin.categories._row', ['category' => $category])
            @endforeach
        </tbody>
    </table>
</div>
@endsection