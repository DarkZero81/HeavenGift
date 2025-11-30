<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);

        // حساب متوسط التقييم
        $averageRating = $product->reviews->avg('rating') ?? 0;
        $reviewsCount = $product->reviews->count();

        // حساب عدد كل تقييم
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $product->reviews->where('rating', $i)->count();
        }

        // التقييمات المقبولة فقط
        $approvedReviews = $product->reviews->where('approved', true);

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
            'approvedReviews',
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
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }
}
