<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $productId)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product'
            ], 400);
        }

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'approved' => false, // تحتاج موافقة المدير
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully and will be reviewed soon',
            'data' => $review
        ], 201);
    }

    public function userReviews(Request $request)
    {
        $reviews = $request->user()->reviews()
            ->with('product')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }
}
