<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الدفع - Gift Haven</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #FF6B6B;
            --secondary: #4ECDC4;
            --dark: #292F36;
            --light: #F7FFF7;
            --accent: #FFE66D;
            --success: #6BCF7F;
            --warning: #FFA726;
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .payment-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .payment-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .payment-step {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 10px;
            font-weight: bold;
        }

        .payment-step.active {
            background: var(--accent);
            color: var(--dark);
        }

        .payment-step.completed {
            background: var(--success);
        }

        .payment-body {
            padding: 2rem;
        }

        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-method-card.selected {
            border-color: var(--primary);
            background: rgba(255, 107, 107, 0.05);
        }

        .payment-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 25px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-pay:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .security-badge {
            background: var(--success);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .card-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }

        .card-element-container {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .back-link {
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            color: var(--secondary);
        }

        @media (max-width: 768px) {
            .payment-body {
                padding: 1rem;
            }

            .payment-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <!-- رجوع للسلة -->
        <a href="{{ route('cart.index') }}" class="back-link">
            <i class="bi bi-arrow-right"></i>
            رجوع للسلة
        </a>

        <div class="payment-card">
            <!-- Header -->
            <div class="payment-header">
                <h1 class="h2 mb-4">
                    <i class="bi bi-credit-card me-2"></i>
                    إتمام عملية الدفع
                </h1>

                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="payment-step completed">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="mx-2">
                        <i class="bi bi-arrow-left text-light"></i>
                    </div>
                    <div class="payment-step completed">2</div>
                    <div class="mx-2">
                        <i class="bi bi-arrow-left text-light"></i>
                    </div>
                    <div class="payment-step active">3</div>
                </div>

                <p class="mb-0">الخطوة الأخيرة لتأكيد طلبك</p>
            </div>

            <!-- Body -->
            <div class="payment-body">
                <div class="row">
                    <!-- معلومات الطلب -->
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h3 class="mb-4">
                                <i class="bi bi-wallet2 me-2"></i>
                                اختر طريقة الدفع
                            </h3>

                            <!-- طرق الدفع -->
                            <div class="row">
                                <!-- البطاقة الائتمانية -->
                                <div class="col-md-6 mb-3">
                                    <div class="payment-method-card" id="cardMethod"
                                        onclick="selectPaymentMethod('card')">
                                        <div class="payment-icon">
                                            <i class="bi bi-credit-card-2-front"></i>
                                        </div>
                                        <h5>البطاقة الائتمانية</h5>
                                        <p class="text-muted mb-0">Visa, MasterCard, Mada</p>
                                    </div>
                                </div>

                                <!-- الدفع عند الاستلام -->
                                <div class="col-md-6 mb-3">
                                    <div class="payment-method-card" id="codMethod"
                                        onclick="selectPaymentMethod('cod')">
                                        <div class="payment-icon">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                        <h5>الدفع عند الاستلام</h5>
                                        <p class="text-muted mb-0">ادفع عند استلام طلبك</p>
                                    </div>
                                </div>

                                <!-- حوالة بنكية -->
                                <div class="col-md-6 mb-3">
                                    <div class="payment-method-card" id="bankMethod"
                                        onclick="selectPaymentMethod('bank')">
                                        <div class="payment-icon">
                                            <i class="bi bi-bank"></i>
                                        </div>
                                        <h5>حوالة بنكية</h5>
                                        <p class="text-muted mb-0">تحويل مباشر للبنك</p>
                                    </div>
                                </div>

                                <!-- محفظة إلكترونية -->
                                <div class="col-md-6 mb-3">
                                    <div class="payment-method-card" id="walletMethod"
                                        onclick="selectPaymentMethod('wallet')">
                                        <div class="payment-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                        <h5>محفظة إلكترونية</h5>
                                        <p class="text-muted mb-0">STC Pay, Apple Pay</p>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل البطاقة (تظهر عند اختيار البطاقة) -->
                            <div id="cardDetails" style="display: none;">
                                <div class="card p-4 mt-4 border-primary">
                                    <h5 class="mb-3">
                                        <i class="bi bi-credit-card me-2"></i>
                                        معلومات البطاقة
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">رقم البطاقة</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control card-input"
                                                    placeholder="1234 5678 9012 3456" maxlength="19" id="cardNumber">
                                                <span class="input-group-text">
                                                    <i class="bi bi-credit-card"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">تاريخ الانتهاء</label>
                                            <input type="text" class="form-control card-input" placeholder="MM/YY"
                                                maxlength="5" id="cardExpiry">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">CVV</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control card-input" placeholder="123"
                                                    maxlength="3" id="cardCvv">
                                                <span class="input-group-text">
                                                    <i class="bi bi-shield-lock"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">اسم حامل البطاقة</label>
                                        <input type="text" class="form-control card-input"
                                            placeholder="كما هو مكتوب على البطاقة" id="cardName">
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="saveCard">
                                        <label class="form-check-label" for="saveCard">
                                            حفظ معلومات البطاقة للمرة القادمة
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل التحويل البنكي -->
                            <div id="bankDetails" style="display: none;">
                                <div class="card p-4 mt-4 border-info">
                                    <h5 class="mb-3">
                                        <i class="bi bi-bank me-2"></i>
                                        معلومات التحويل البنكي
                                    </h5>

                                    <div class="alert alert-info">
                                        <h6>تفاصيل الحساب البنكي:</h6>
                                        <p class="mb-1"><strong>اسم البنك:</strong> البنك الأهلي السعودي</p>
                                        <p class="mb-1"><strong>رقم الحساب:</strong> SA12 3456 7890 1234 5678 9012
                                        </p>
                                        <p class="mb-1"><strong>اسم المستفيد:</strong> Gift Haven Store</p>
                                        <p class="mb-0"><strong>IBAN:</strong> SA03 8000 0000 6080 1016 7519</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">رقم التحويل</label>
                                        <input type="text" class="form-control"
                                            placeholder="أدخل رقم التحويل البنكي">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">تاريخ التحويل</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- معلومات الشحن -->
                        <div class="mt-4">
                            <h5 class="mb-3">
                                <i class="bi bi-truck me-2"></i>
                                عنوان الشحن
                            </h5>

                            <div class="card p-3">
                                <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                                <p class="mb-1">{{ $order->customer_address }}</p>
                                <p class="mb-1">الهاتف: {{ $order->customer_phone }}</p>
                                <p class="mb-0">البريد: {{ $order->customer_email }}</p>

                                <a href="{{ route('checkout.index') }}" class="btn btn-outline-primary btn-sm mt-2">
                                    <i class="bi bi-pencil me-1"></i>
                                    تعديل العنوان
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ملخص الطلب -->
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 20px;">
                            <div class="order-summary">
                                <h4 class="mb-4">
                                    <i class="bi bi-receipt me-2"></i>
                                    ملخص الطلب
                                </h4>

                                <!-- المنتجات -->
                                @foreach ($order->items as $item)
                                    <div class="order-item">
                                        <div>
                                            <h6 class="mb-1">{{ $item->name }}</h6>
                                            <small class="text-muted">الكمية: {{ $item->quantity }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div>${{ number_format($item->price * $item->quantity, 2) }}</div>
                                            <small class="text-muted">${{ number_format($item->price, 2) }}
                                                للواحد</small>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- التكاليف -->
                                <div class="order-item">
                                    <span>مجموع المنتجات</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="order-item">
                                    <span>الشحن</span>
                                    <span>
                                        @if ($shipping == 0)
                                            <span class="text-success">مجاني</span>
                                        @else
                                            ${{ number_format($shipping, 2) }}
                                        @endif
                                    </span>
                                </div>

                                @if ($discount > 0)
                                    <div class="order-item">
                                        <span>الخصم</span>
                                        <span class="text-success">-${{ number_format($discount, 2) }}</span>
                                    </div>
                                @endif

                                <!-- الإجمالي -->
                                <div class="order-item pt-3 border-top">
                                    <h5 class="mb-0">المجموع النهائي</h5>
                                    <h5 class="mb-0 total-amount">${{ number_format($total, 2) }}</h5>
                                </div>

                                <!-- الكوبون -->
                                <div class="mt-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="أدخل كود الخصم"
                                            id="couponCode">
                                        <button class="btn btn-outline-primary" onclick="applyCoupon()">
                                            تطبيق
                                        </button>
                                    </div>
                                    <div id="couponMessage" class="mt-2"></div>
                                </div>

                                <!-- شروط الخدمة -->
                                <div class="mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsCheck">
                                        <label class="form-check-label" for="termsCheck">
                                            أوافق على
                                            <a href="#" class="text-primary">شروط الخدمة</a>
                                            و
                                            <a href="#" class="text-primary">سياسة الخصوصية</a>
                                        </label>
                                    </div>
                                </div>

                                <!-- زر الدفع -->
                                <button class="btn btn-pay mt-4" id="payButton" onclick="processPayment()" disabled>
                                    <span id="payButtonText">
                                        <i class="bi bi-lock me-2"></i>
                                        ادفع الآن ${{ number_format($total, 2) }}
                                    </span>
                                    <span id="payButtonLoading" style="display: none;">
                                        <span class="loader me-2"></span>
                                        جاري المعالجة...
                                    </span>
                                </button>

                                <!-- الأمان -->
                                <div class="text-center mt-3">
                                    <div class="security-badge">
                                        <i class="bi bi-shield-check"></i>
                                        دفع آمن ومشفر
                                    </div>
                                </div>

                                <!-- طرق الدفع المدعومة -->
                                <div class="text-center mt-3">
                                    <small class="text-muted">مدعوم من:</small>
                                    <div class="mt-2">
                                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa"
                                            style="height: 30px;" class="me-2">
                                        <img src="https://img.icons8.com/color/48/000000/mastercard.png"
                                            alt="MasterCard" style="height: 30px;" class="me-2">
                                        <img src="https://img.icons8.com/color/48/000000/mada.png" alt="Mada"
                                            style="height: 30px;" class="me-2">
                                        <img src="https://img.icons8.com/color/48/000000/apple-pay.png"
                                            alt="Apple Pay" style="height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- معلومات الاتصال -->
        <div class="text-center mt-4 text-muted">
            <p class="mb-1">
                <i class="bi bi-headset me-1"></i>
                للاستفسارات: 9200 12345 |
                <i class="bi bi-envelope me-1 ms-3"></i>
                support@gifthaven.com
            </p>
            <p class="mb-0">
                <i class="bi bi-clock me-1"></i>
                خدمة العملاء متاحة 24/7
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // المتغيرات
        let selectedPaymentMethod = null;
        let couponApplied = false;

        // اختيار طريقة الدفع
        function selectPaymentMethod(method) {
            // إزالة التحديد السابق
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });

            // إخفاء جميع التفاصيل
            document.getElementById('cardDetails').style.display = 'none';
            document.getElementById('bankDetails').style.display = 'none';

            // التحديد الجديد
            document.getElementById(method + 'Method').classList.add('selected');
            selectedPaymentMethod = method;

            // إظهار التفاصيل المناسبة
            if (method === 'card') {
                document.getElementById('cardDetails').style.display = 'block';
            } else if (method === 'bank') {
                document.getElementById('bankDetails').style.display = 'block';
            }

            // تفعيل زر الدفع إذا تم قبول الشروط
            checkPaymentButton();
        }

        // تطبيق الكوبون
        function applyCoupon() {
            const couponCode = document.getElementById('couponCode').value.trim();
            const messageDiv = document.getElementById('couponMessage');

            if (!couponCode) {
                messageDiv.innerHTML = '<div class="alert alert-warning">الرجاء إدخال كود الخصم</div>';
                return;
            }

            // محاكاة API call
            fetch('{{ route('api.coupons.apply') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        couponApplied = true;
                        // تحديث السعر (في الواقع، ستعيد الAPI الأسعار الجديدة)
                        updateTotalPrice(data.discount);
                    } else {
                        messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        couponApplied = false;
                    }
                })
                .catch(error => {
                    messageDiv.innerHTML = '<div class="alert alert-danger">حدث خطأ في الاتصال</div>';
                });
        }

        // تحديث السعر (محاكاة)
        function updateTotalPrice(discount) {
            // في التطبيق الحقيقي، ستتلقى الأسعار من الخادم
            console.log('Discount applied:', discount);
        }

        // التحقق من تفعيل زر الدفع
        function checkPaymentButton() {
            const termsChecked = document.getElementById('termsCheck').checked;
            const payButton = document.getElementById('payButton');

            if (selectedPaymentMethod && termsChecked) {
                payButton.disabled = false;
            } else {
                payButton.disabled = true;
            }
        }

        // معالجة الدفع
        function processPayment() {
            if (!selectedPaymentMethod) {
                alert('الرجاء اختيار طريقة الدفع');
                return;
            }

            // إظهار المؤشر
            document.getElementById('payButtonText').style.display = 'none';
            document.getElementById('payButtonLoading').style.display = 'inline-flex';
            document.getElementById('payButton').disabled = true;

            // محاكاة عملية الدفع
            setTimeout(() => {
                // في التطبيق الحقيقي، هنا ستكون عملية الدفع الفعلية
                if (selectedPaymentMethod === 'card') {
                    processCardPayment();
                } else if (selectedPaymentMethod === 'cod') {
                    processCODPayment();
                } else {
                    processOtherPayment();
                }
            }, 2000);
        }

        // معالجة دفع البطاقة
        function processCardPayment() {
            const cardNumber = document.getElementById('cardNumber').value;
            const cardExpiry = document.getElementById('cardExpiry').value;
            const cardCvv = document.getElementById('cardCvv').value;
            const cardName = document.getElementById('cardName').value;

            // تحقق بسيط
            if (!cardNumber || !cardExpiry || !cardCvv || !cardName) {
                alert('الرجاء ملء جميع معلومات البطاقة');
                resetPaymentButton();
                return;
            }

            // محاكاة API الدفع
            fetch('{{ route('api.payment.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        method: 'card',
                        card_number: cardNumber,
                        card_expiry: cardExpiry,
                        card_cvv: cardCvv,
                        card_name: cardName,
                        amount: {{ $total }},
                        order_id: {{ $order->id }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route('checkout.success') }}?order=' + data.order_id;
                    } else {
                        alert('فشل عملية الدفع: ' + data.message);
                        resetPaymentButton();
                    }
                })
                .catch(error => {
                    alert('حدث خطأ في الاتصال');
                    resetPaymentButton();
                });
        }

        // معالجة الدفع عند الاستلام
        function processCODPayment() {
            fetch('{{ route('api.payment.cod') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: {{ $order->id }},
                        amount: {{ $total }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route('checkout.success') }}?order=' + data.order_id;
                    } else {
                        alert('حدث خطأ: ' + data.message);
                        resetPaymentButton();
                    }
                })
                .catch(error => {
                    alert('حدث خطأ في الاتصال');
                    resetPaymentButton();
                });
        }

        // معالجة طرق الدفع الأخرى
        function processOtherPayment() {
            window.location.href = '{{ route('checkout.success') }}?order={{ $order->id }}';
        }

        // إعادة تعيين زر الدفع
        function resetPaymentButton() {
            document.getElementById('payButtonText').style.display = 'inline-flex';
            document.getElementById('payButtonLoading').style.display = 'none';
            document.getElementById('payButton').disabled = false;
        }

        // تنسيق رقم البطاقة
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formatted = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = formatted.substring(0, 19);
        });

        // تنسيق تاريخ الانتهاء
        document.getElementById('cardExpiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value.substring(0, 5);
        });

        // تفعيل زر الدفع عند قبول الشروط
        document.getElementById('termsCheck').addEventListener('change', checkPaymentButton);

        // اختيار طريقة الدفع الافتراضية
        window.onload = function() {
            selectPaymentMethod('card');
        };
    </script>
</body>

</html>
