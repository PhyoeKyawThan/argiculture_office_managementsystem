@extends('admin.layouts.root')

@section('title', 'Create Category')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-emerald-900">အမျိုးအစားအသစ်ဖန်တီးရန်</h1>
        <p class="text-slate-600 mt-1"></p>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">Category Name</label>
                    <input type="text" name="name" class="w-full rounded-sm py-2 border border-slate-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">အမျိုးအစားအမည်</label>
                    <input type="text" name="name_mm" class="w-full rounded-sm py-2 border border-slate-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-emerald-900 mb-2">Slug</label>
                    <input type="text" name="slug" class="w-full rounded-sm py-2 border border-slate-300 focus:ring-emerald-500 focus:border-emerald-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-emerald-900 mb-2">Parent Category </label>
                <select name="parent_id" class="w-full border border-slate-300 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">-- Root Level (No Parent) --</option>
                    @foreach($allCategories as $category)
                        <option value="{{ $category->id }}">
                            {{ str_repeat('— ', $category->level - 1) }} {{ config('app.locale') === 'en' ? $category->name : $category->name_mm }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-2"></p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition">ပယ်ဖျက်ရန်</a>
                <button type="submit" class="px-6 py-2 rounded-xl font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition">ဖန်တီးရန်</button>
            </div>
        </form>
    </div>
@endsection