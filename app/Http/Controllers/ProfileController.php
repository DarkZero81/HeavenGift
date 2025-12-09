<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // إضافة الاستيراد هنا

class ProfileController extends Controller
{
    /**
     * عرض معلومات الملف الشخصي للمستخدم.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * تحديث معلومات ملف المستخدم الشخصي.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. التحقق من صحة البيانات
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

            // قواعد التحقق للصورة:
            // يجب أن يكون ملف صورة بحد أقصى 2 ميجابايت
            'profile_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            // يجب أن يكون رابط صالح
            'profile_image_url' => ['nullable', 'url', 'max:255'],
        ]);

        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ];

        // 2. معالجة تحديث الصورة
        if ($request->hasFile('profile_image_file')) {
            // أ. تم رفع ملف جديد:

            // حذف الصورة القديمة إذا كانت مخزنة محلياً
            if ($user->profile_photo_url && !filter_var($user->profile_photo_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            // تخزين الملف الجديد في مجلد 'profile-photos'
            $path = $request->file('profile_image_file')->store('profile-photos', 'public');
            $updateData['profile_photo_url'] = $path;
        } elseif (!empty($validatedData['profile_image_url'])) {
            // ب. تم إدخال رابط صورة:

            // حذف الصورة القديمة إذا كانت مخزنة محلياً
            if ($user->profile_photo_url && !filter_var($user->profile_photo_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            $updateData['profile_photo_url'] = $validatedData['profile_image_url'];
        }
        // ملاحظة: إذا ترك المستخدم كلا الحقلين فارغين، ستبقى الصورة كما هي.

        // 3. تحديث كلمة المرور إذا تم إدخالها
        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        // 4. حفظ التغييرات في قاعدة البيانات
        $user->update($updateData);

        // 5. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }
}
