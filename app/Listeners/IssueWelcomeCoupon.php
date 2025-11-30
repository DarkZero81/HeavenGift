<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Coupon;
use Illuminate\Support\Str;

class IssueWelcomeCoupon
{
    public function handle(Registered $event)
    {
        $user = $event->user;
        // create a one-time 10% coupon valid for 30 days
        Coupon::create([
            'code' => 'WELCOME-' . strtoupper(Str::random(6)),
            'discount_percent' => 10,
            'user_id' => $user->getAuthIdentifier(),
            'expires_at' => now()->addDays(30),
            'is_active' => true,
        ]);
    }
}
