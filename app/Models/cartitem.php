<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * Explicit table name: migrations create `cartitems` (no underscore).
     */
    protected $table = 'cartitems';
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
