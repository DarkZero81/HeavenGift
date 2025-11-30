<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\cartitem;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected function getCartForRequest($request)
    {
        if (Auth::check()) {
            $cart = cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'active']);
            session()->put('cart_id', $cart->id);
            return $cart;
        }

        $cartId = session('cart_id');
        if ($cartId) {
            $cart = cart::find($cartId);
            if ($cart) return $cart;
        }

        $cart = cart::create(['status' => 'active']);
        session()->put('cart_id', $cart->id);
        return $cart;
    }

    public function index(Request $request)
    {
        $cart = $this->getCartForRequest($request);
        $cart->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $cart = $this->getCartForRequest($request);
        $product = product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $item = cartitem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
        if ($item) {
            $item->quantity += $quantity;
            $item->price = $product->price;
            $item->save();
        } else {
            cartitem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item = cartitem::findOrFail($itemId);
        $item->quantity = $request->quantity;
        $product = product::findOrFail($item->product_id);
        $item->price = $product->price;
        $item->save();
        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove(Request $request, $itemId)
    {
        $item = cartitem::findOrFail($itemId);
        $item->delete();
        return redirect()->route('cart.index')->with('success', 'Item removed');
    }

    public function clear(Request $request)
    {
        $cart = $this->getCartForRequest($request);
        foreach ($cart->items as $item) {
            $item->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}
