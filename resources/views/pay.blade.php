@extends('layouts.app')

@section('title', 'الدفع عبر Stripe')

@section('styles')
    <link href="{{ asset('css/pay.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="payment-page">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://js.stripe.com/v3/"></script>

        {{-- المتغيرات المطلوبة: $stripeKey, $amount, $currency --}}

        <div class="payment-container">

            @if ($errors->any())
                <div id="card-errors" class="alert alert-danger" style="display: block;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2>إتمام عملية الدفع</h2>

            <form action="{{ route('pay.process') }}" method="POST" id="payment-form">
                @csrf

                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'test@example.com') }}"
                        placeholder="أدخل بريدك الإلكتروني" required>
                </div>

                <div class="form-group">
                    <label for="card-element">معلومات البطاقة</label>
                    <div id="card-element">
                        {{-- ستقوم Stripe بإنشاء حقول البطاقة هنا --}}
                    </div>
                </div>

                <div id="card-errors" role="alert"></div>

                <button type="submit" class="submit-btn" id="submit-button">
                    دفع الآن (<span id="amount-display">{{ $amount }}</span> {{ strtoupper($currency) }})
                </button>
            </form>
        </div>

        <script>
            const stripe = Stripe('{{ $stripeKey }}');
            const elements = stripe.elements();
            const form = document.getElementById('payment-form');
            const submitBtn = document.getElementById('submit-button');
            const cardErrors = document.getElementById('card-errors');
            const paymentFormUrl = form.getAttribute('action');

            // إنشاء عنصر البطاقة مع الأنماط المطلوبة
            const card = elements.create('card', {
                style: {
                    base: {
                        iconColor: '#FFD200',
                        color: '#FFFFFF',
                        fontWeight: '500',
                        fontFamily: 'Segoe UI, Tahoma, Geneva, Verdana, sans-serif',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#cccccc',
                        },
                    },
                    invalid: {
                        iconColor: '#FF6B6B',
                        color: '#FF6B6B',
                    },
                }
            });

            // تركيب عنصر البطاقة في واجهة المستخدم
            card.mount('#card-element');

            // التعامل مع الأخطاء الفورية في حقول البطاقة
            card.addEventListener('change', function(event) {
                if (event.error) {
                    cardErrors.textContent = event.error.message;
                    cardErrors.style.display = 'block';
                } else {
                    cardErrors.textContent = '';
                    cardErrors.style.display = 'none';
                }
            });

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<div class="spinner"></div>';
                cardErrors.style.display = 'none';
                cardErrors.textContent = '';

                const email = document.getElementById('email').value;
                const amount = {{ $amount }};

                try {
                    // إنشاء PaymentMethod على Stripe
                    const {
                        paymentMethod,
                        error
                    } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                        billing_details: {
                            email: email,
                        },
                    });

                    if (error) {
                        cardErrors.textContent = error.message;
                        cardErrors.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = `دفع الآن (${amount} {{ strtoupper($currency) }})`;
                        return;
                    }

                    // إرسال PaymentMethod ID والبيانات إلى خادم Laravel
                    const response = await fetch(paymentFormUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            _token: '{{ csrf_token() }}',
                            payment_method: paymentMethod
                                .id, // Fixed parameter name to match backend
                            amount: amount,
                            email: email
                        })
                    });

                    // التحقق مما إذا كان الرد JSON أم HTML (خطأ)
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('الخادم أعاد HTML بدلاً من JSON:', text);
                        cardErrors.textContent = 'حدث خطأ في الخادم. راجع وحدة التحكم للمزيد.';
                        cardErrors.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = `دفع الآن (${amount} {{ strtoupper($currency) }})`;
                        return;
                    }

                    const result = await response.json();

                    if (response.ok && result.url) {
                        window.location.href = result.url;

                    } else if (result.requires_action) {
                        const {
                            error: confirmError,
                            paymentIntent
                        } = await stripe.confirmCardPayment(
                            result.client_secret, {
                                payment_method: paymentMethod.id
                            }
                        );

                        if (confirmError) {
                            cardErrors.textContent = confirmError.message;
                            cardErrors.style.display = 'block';
                        } else if (paymentIntent.status === 'succeeded') {
                            window.location.href = result.url;
                            return;
                        }

                        submitBtn.disabled = false;
                        submitBtn.textContent = `دفع الآن (${amount} {{ strtoupper($currency) }})`;

                    } else {
                        cardErrors.textContent = result.error || 'حدث خطأ غير متوقع أثناء الدفع.';
                        cardErrors.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = `دفع الآن (${amount} {{ strtoupper($currency) }})`;
                    }

                } catch (e) {
                    console.error('خطأ في الواجهة:', e);
                    cardErrors.textContent = 'فشل الاتصال بالخادم. تحقق من اتصالك بالإنترنت.';
                    cardErrors.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = `دفع الآن (${amount} {{ strtoupper($currency) }})`;
                }
            });
        </script>
    </div>
@endsection
