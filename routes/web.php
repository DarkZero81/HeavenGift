<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Controllers for Frontend ---
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// --- Controllers for Admin ---
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;


/*
|--------------------------------------------------------------------------
| Public & General Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home'); // تعديل: تم تسمية المسار باسم 'home' بدلاً من المسار التلقائي
Route::get("/wel", function () {
    return view("welcome");
});

// مسارات الموارد القياسية (Categories & Products)
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class)->only(['index', 'show']);

// Reviews
Route::post('products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Search
Route::get('search', [ProductController::class, 'search'])->name('products.search');

// Contact (استخدام Route::view أبسط لعرض صفحة ثابتة)
Route::view('contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('add', 'add')->name('add');
    Route::post('update/{id}', 'update')->name('update');
    Route::post('remove/{id}', 'remove')->name('remove');
    Route::post('clear', 'clear')->name('clear');
});

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/
Route::controller(CheckoutController::class)->group(function () {
    Route::get('checkout', 'checkout')->name('checkout.index');
    Route::post('checkout', 'store')->name('checkout.store');
    Route::get('checkout/thanks', 'thanks')->name('checkout.thanks');
});


/*
|--------------------------------------------------------------------------
| Payment Routes (Stripe)
|--------------------------------------------------------------------------
*/
Route::controller(StripePaymentController::class)->group(function () {
    Route::get('/pay', 'showPaymentForm')->name('pay.form');
    Route::post('/pay', 'processPayment')->name('payment.process');
    Route::get('/payment-success', 'paymentSuccess')->name('payment.success');
    Route::get('/payment-now', 'instantPayment')->name('payment.now');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes & User Profile
|--------------------------------------------------------------------------
*/

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('dashboard.home'); // تم تغيير الاسم لتجنب التكرار مع الجذر

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        // عرض الملف الشخصي ومعلومات المستخدم
        Route::get('/profile', 'show')->name('profile.show');
        Route::get('/userinfo', 'show')->name('userinfo');

        // تحديث الملف الشخصي (تم إزالة {user} لافتراض تحديث المستخدم الحالي)
        Route::put('/profile', 'update')->name('profile.update');
    });
});


/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->group(function () {
    // الداشبورد
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // مسارات الموارد للوحة التحكم
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);

    // مسارات الطلبات
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // مسارات الطلبات
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Coupons Management
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Reviews Management
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);

    // Payments Management
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->only(['index', 'show', 'destroy']);
    Route::get('/payments/create', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('payments.store');

    // Users Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');

    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});
