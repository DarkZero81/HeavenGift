<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_percent', 'user_id', 'expires_at', 'is_active', 'max_uses', 'used_count'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'max_uses' => 'integer',
        'used_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
