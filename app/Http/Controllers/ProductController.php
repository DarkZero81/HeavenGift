<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show(int $id)
    {
        // 1. تحميل المنتج والفئة فقط (إزالة eager loading لـ reviews لكي نتمكن من الترقيم بكفاءة)
        $product = Product::with('category')->findOrFail($id);

        // 2. جلب جميع التقييمات المعتمدة مرة واحدة لحساب الإحصائيات
        $allApprovedReviews = $product->reviews()->where('approved', true)->get();

        // حساب متوسط التقييم وإجمالي عدد المراجعات
        $averageRating = $allApprovedReviews->avg('rating') ?? 0;
        $reviewsCount = $allApprovedReviews->count();

        // حساب عدد كل تقييم (يتم باستخدام المجموعة التي تم جلبها)
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $allApprovedReviews->where('rating', $i)->count();
        }

        // 3. التقييمات المقبولة للعرض مع الترقيم (Pagination)
        // نستخدم latest() لترتيب الأحدث أولاً، و paginate(5) لعرض 5 تقييمات في كل صفحة
        $approvedReviews = $product->reviews()
            ->where('approved', true)
            ->latest() // لترتيب التقييمات من الأحدث
            ->paginate(5);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product',
            'averageRating',
            'reviewsCount',
            'ratingCounts',
            'approvedReviews', // الآن هو كائن Paginator
            'relatedProducts'
        ));
    }

    /**
     * Display a listing of products, optionally filtered by category.
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('stock', '>', 0);

        $selectedCategory = null;
        if ($request->filled('category')) {
            $selectedCategory = Category::find($request->get('category'));
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->getKey());
            }
        }

        $products = $query->latest()->paginate(6)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Search products based on query string.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2|max:255'
        ]);

        $searchQuery = trim($request->input('query'));

        // Search in product name and description (case-insensitive)
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->where(function ($q) use ($searchQuery) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchQuery) . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($searchQuery) . '%']);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Also search in category names (case-insensitive)
        $categoryProducts = Category::where('is_active', true)
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchQuery) . '%'])
            ->with(['products' => function ($q) {
                $q->where('stock', '>', 0);
            }])
            ->get()
            ->pluck('products')
            ->flatten()
            ->unique('id');

        // Combine and remove duplicates
        $allResults = $products->getCollection()->merge($categoryProducts)->unique('id');

        // Reset pagination with combined results
        $products->setCollection($allResults);

        return view('products.search', compact('products', 'searchQuery'));
    }
}
