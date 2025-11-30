<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with('items.product')
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'required|string',
            'coupon_code' => 'sometimes|string'
        ]);

        return DB::transaction(function () use ($request) {
            $user = $request->user();
            $cart = $user->activeCart();

            if (!$cart || $cart->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shopping cart is empty'
                ], 400);
            }

            // Calculate total
            $subtotal = 0;
            foreach ($cart->items as $item) {
                $subtotal += $item->price * $item->quantity;
            }

            // Apply coupon if provided
            $discount = 0;
            $coupon = null;

            if ($request->has('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                    })
                    ->first();

                if ($coupon) {
                    $discount = ($subtotal * ($coupon->discount_percent / 100));
                }
            }

            $total = max(0, $subtotal - $discount);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Mark coupon as used
            if ($coupon) {
                $coupon->update(['is_active' => false]);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->update(['status' => 'ordered']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order->load('items'),
                    'order_id' => $order->id
                ]
            ], 201);
        });
    }
}
