<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * عرض معلومات ملف المستخدم الشخصي.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // التحقق من أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect('/login'); // أو أي صفحة تسجيل دخول مناسبة
        }

        // جلب بيانات المستخدم الحالي
        $user = Auth::user();

        // تمرير البيانات إلى صفحة العرض
        return view('profile', compact('user'));
    }
}
