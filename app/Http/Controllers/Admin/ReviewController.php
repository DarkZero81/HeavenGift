<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $query = Review::with(['product', 'user']);

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if (request('status') === 'approved') {
            $query->where('approved', true);
        } elseif (request('status') === 'pending') {
            $query->where('approved', false);
        }

        // Rating filter
        if (request('rating')) {
            $query->where('rating', request('rating'));
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['product', 'user']);
        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($request->action === 'approve') {
            $review->update(['approved' => true]);
            return redirect()->back()->with('success', 'Review approved successfully!');
        }

        return redirect()->back()->with('error', 'Invalid action!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
