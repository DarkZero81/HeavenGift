<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;

class StripePaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('pay', ['stripeKey' => config('services.stripe.key')]);
    }

    public function processPayment(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|string',
            'email' => 'required|email',
        ]);

        // تهيئة Stripe بالمفتاح السري
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // إنشاء PaymentIntent بدون تأكيد فوري
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // بالسنتات
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'receipt_email' => $request->email,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
            ]);

            // تأكيد الدفع
            $confirmedIntent = $paymentIntent->confirm();

            // تحديث الحالة بعد التأكيد
            $status = $confirmedIntent->status;

            // حفظ السجل في قاعدة البيانات
            Payment::create([
                'payment_intent_id' => $confirmedIntent->id,
                'amount' => $request->amount,
                'currency' => 'usd',
                'status' => $status,
                'email' => $request->email,
            ]);

            // إرجاع استجابة JSON بناءً على الحالة
            if ($status === 'succeeded') {
                return response()->json([
                    'url' => route('payment.success', ['id' => $confirmedIntent->id])
                ]);
            } else {
                return response()->json([
                    'error' => 'فشل الدفع: ' . ($confirmedIntent->last_payment_error->message ?? 'الدفع لم يُكتمل')
                ], 400);
            }
        } catch (\Exception $e) {
            // إرجاع أي خطأ كـ JSON لتجنب إعادة HTML
            return response()->json([
                'error' => 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->query('id');

        // البحث عن الدفع باستخدام payment_intent_id
        $payment = Payment::where('payment_intent_id', $paymentId)->first();

        if (!$payment) {
            abort(404, 'الدفع غير موجود');
        }

        return view('payment-success', compact('payment'));
    }
}
