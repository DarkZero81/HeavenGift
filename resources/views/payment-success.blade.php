<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الدفع بنجاح!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background: #f9f9f9;
        }

        .success-box {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2e7d32;
        }

        .info {
            margin-top: 1rem;
        }

        .info p {
            margin: 0.5rem 0;
        }
    </style>
</head>

<body>
    <div class="success-box">
        <h1>✅ تم الدفع بنجاح!</h1>
        <div class="info">
            <p><strong>المبلغ:</strong> {{ $payment->amount }} {{ strtoupper($payment->currency) }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $payment->email }}</p>
            <p><strong>معرف المعاملة:</strong> {{ $payment->payment_intent_id }}</p>
            <p><strong>الحالة:</strong> {{ $payment->status }}</p>
        </div>
        <br>
        <a href="{{ route('pay.form') }}" style="color: #1976d2;">← العودة لدفع آخر</a>
    </div>
</body>

</html>
اختياري) عرض رسالة خطأ في صفحة الدفع
لعرض أخطاء التحقق في صفحة pay.blade.php، أضف هذا الكود أعلى النموذج:
@if ($errors->any())
    <div class="error" style="color: red; margin-bottom: 1rem;">
        {{ $errors->first() }}
    </div>
@endif
