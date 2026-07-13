<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('name_mm', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('parent_id'), function ($query) use ($request) {
                $query->where('parent_id', $request->parent_id);
            })
            ->orderBy('level')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $allCategories = Category::where('level', '<', 5)->get();
        return view('admin.categories.create', compact('allCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_mm' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $parent = Category::find($request->parent_id);
        $validated['level'] = $parent ? $parent->level + 1 : 1;

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category Created!');
    }

    public function edit(Category $category)
    {
        $allCategories = Category::where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_mm' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $parent = Category::find($request->parent_id);
        $validated['level'] = $parent ? $parent->level + 1 : 1;

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category Updated!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category Deleted!');
    }
}