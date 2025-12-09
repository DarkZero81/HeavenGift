<?php

namespace App\Http\Controllers;

use App\Models\review;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $product = product::findOrFail($productId);
        review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'approved' => true, // <--- هذا هو التعديل الأساسي لظهوره فوراً
        ]);

        // تم تعديل رسالة النجاح
        return redirect()->route('products.show', $product->id)->with('success', 'تمت إضافة تقييمك بنجاح وسيظهر فوراً.');
    }
}
