@extends('admin.layouts.root')

@section('content')
<div>
    <a href="{{ route('admin.categories.create') }}">Add New Category</a>
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
    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg">Filter</button>
    <a href="{{ route('admin.categories.index') }}" class="text-gray-500 py-2">Clear</a>
</form>

<div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden">
    <table class="w-full text-left">
        <tbody>
            @foreach($categories as $category)
                @include('admin.categories._row', ['category' => $category])
            @endforeach
        </tbody>
    </table>
</div>
@endsection