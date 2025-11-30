<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('user')->latest()->paginate(20);
        $users = User::where('is_admin', false)->get();

        return view('admin.coupons.index', compact('coupons', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_percent' => 'required|integer|min:1|max:100',
            'user_id' => 'nullable|exists:users,id',
            'expires_at' => 'nullable|date|after:today',
            'max_uses' => 'nullable|integer|min:1'
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_percent' => $request->discount_percent,
            'user_id' => $request->user_id,
            'expires_at' => $request->expires_at,
            'max_uses' => $request->max_uses,
            'is_active' => true
        ]);

        return redirect()->back()->with('success', 'تم إنشاء الكوبون بنجاح');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_percent' => 'required|integer|min:1|max:100',
            'user_id' => 'nullable|exists:users,id',
            'expires_at' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
            'is_active' => 'required|boolean'
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_percent' => $request->discount_percent,
            'user_id' => $request->user_id,
            'expires_at' => $request->expires_at,
            'max_uses' => $request->max_uses,
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'تم تحديث الكوبون بنجاح');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->back()->with('success', 'تم حذف الكوبون بنجاح');
    }
}
