<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('stock', '>', 0);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $products = $query->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Calculate average rating
        $averageRating = $product->reviews->avg('rating');

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'average_rating' => round($averageRating, 1),
                'reviews_count' => $product->reviews->count()
            ]
        ]);
    }

    public function search($query)
    {
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
