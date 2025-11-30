<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // eager load product counts for display in the index view
        // allow the user to control how many items appear per page via `?per_page=`
        $perPage = (int) request()->input('per_page', 20);
        $allowed = [10, 20, 50, 100];
        if (! in_array($perPage, $allowed)) {
            $perPage = 20;
        }

        // optional filter: ?is_active=1 or ?is_active=0
        $isActiveFilter = request()->query('is_active', null);

        // optional search: ?q=term
        $q = trim((string) request()->query('q', ''));

        $query = Category::withCount('products');
        if ($isActiveFilter !== null && in_array($isActiveFilter, ['0', '1'], true)) {
            $query->where('is_active', (bool) $isActiveFilter);
        }

        if ($q !== '') {
            $query->where('name', 'like', '%' . $q . '%');
        }

        $categories = $query->paginate($perPage)->withQueryString();

        // totals for header badges (not affected by current filter)
        $total = Category::count();
        $activeCount = Category::where('is_active', true)->count();
        $inactiveCount = Category::where('is_active', false)->count();

        // If AJAX request, return only the table partial for faster updates
        if ($request->ajax()) {
            return view('admin.categories._table', compact('categories', 'q'));
        }

        return view('admin.categories.index', compact('categories', 'total', 'activeCount', 'inactiveCount', 'q'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'image' => 'nullable|image']);
        $data = $request->only('name');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category created');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255', 'image' => 'nullable|image']);
        $data = $request->only('name');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted');
    }
}
