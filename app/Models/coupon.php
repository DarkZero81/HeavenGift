<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_percent', 'user_id', 'expires_at', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
