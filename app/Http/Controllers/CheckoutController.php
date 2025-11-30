<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use App\Models\orderitem;
use App\Models\coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cartId = session('cart_id');
        $cart = $cartId ? cart::with('items.product')->find($cartId) : null;
        return view('checkout.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'required|string',
        ]);

        $cart = null;
        if (Auth::check()) {
            $cart = cart::where('user_id', Auth::id())->where('status', 'active')->with('items.product')->first();
        } else {
            $cartId = session('cart_id');
            $cart = $cartId ? cart::with('items.product')->find($cartId) : null;
        }

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += ($item->price * $item->quantity);
        }

        // apply coupon for logged in user if exists
        $appliedCoupon = null;
        if (Auth::check()) {
            $coupon = coupon::where('user_id', Auth::id())->where('is_active', true)->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->first();
            if ($coupon) {
                $discount = ($total * ($coupon->discount_percent / 100));
                $total = max(0, $total - $discount);
                $appliedCoupon = $coupon;
            }
        }

        $order = order::create([
            'user_id' => Auth::id() ?? null,
            'total' => $total,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
        ]);

        foreach ($cart->items as $item) {
            orderitem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // mark coupon used
        if ($appliedCoupon) {
            $appliedCoupon->is_active = false;
            $appliedCoupon->save();
        }

        // clear cart
        foreach ($cart->items as $item) {
            $item->delete();
        }
        $cart->status = 'ordered';
        $cart->save();

        return redirect()->route('checkout.thanks')->with('success', 'Order placed successfully');
    }

    public function thanks()
    {
        return view('checkout.thanks');
    }
}
