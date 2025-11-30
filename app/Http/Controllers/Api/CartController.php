<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->activeCart();

        if (!$cart) {
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => [],
                    'total' => 0,
                    'items_count' => 0
                ]
            ]);
        }

        $cart->load('items.product');

        $total = 0;
        $itemsCount = 0;

        foreach ($cart->items as $item) {
            $total += $item->price * $item->quantity;
            $itemsCount += $item->quantity;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'cart_id' => $cart->id,
                'items' => $cart->items,
                'total' => $total,
                'items_count' => $itemsCount
            ]
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $user = $request->user();
        $cart = $user->activeCart() ?? Cart::create(['user_id' => $user->id, 'status' => 'active']);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Check stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity not available in stock'
            ], 400);
        }

        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity exceeds available stock'
                ], 400);
            }

            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        return $this->index($request);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($id);

        // Check if item belongs to user's cart
        if ($item->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check stock
        if ($item->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity not available in stock'
            ], 400);
        }

        $item->update(['quantity' => $request->quantity]);

        return $this->index($request);
    }

    public function remove(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);

        // Check if item belongs to user's cart
        if ($item->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $item->delete();

        return $this->index($request);
    }

    public function clear(Request $request)
    {
        $user = $request->user();
        $cart = $user->activeCart();

        if ($cart) {
            $cart->items()->delete();
        }

        return $this->index($request);
    }
}
