<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الدفع</title>

    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* تعريف متغيرات الألوان من home.css */
        :root {
            --primary: #FF6B00;
            /* برتقالي */
            --secondary: #50247A;
            /* بنفسجي غامق */
            --dark: #0F061E;
            /* غامق جداً */
            --light: #F8F9FA;
            /* فاتح */
            --accent: #FFD200;
            /* أصفر ذهبي */
        }

        /* الخلفية والتخطيط العام */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        /* حاوية الدفع الرئيسية (البطاقة) */
        .payment-container {
            max-width: 450px;
            width: 100%;
            background-color: var(--dark);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--accent);
            /* حدود بلون التركيز */
        }

        /* العنوان */
        h2 {
            text-align: center;
            color: var(--accent);
            margin-bottom: 1.5rem;
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 210, 0, 0.3);
            padding-bottom: 0.5rem;
        }

        /* مجموعات الحقول */
        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--light);
        }

        /* حقول الإدخال */
        input {
            padding: 0.75rem;
            width: 100%;
            border: 1px solid var(--secondary);
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #1a0f2b;
            /* لون خلفية أغمق للحقل */
            color: var(--light);
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 210, 0, 0.3);
        }

        /* عنصر البطاقة من Stripe */
        /* عنصر البطاقة من Stripe - تم تغيير الخلفية لتبدو أكثر وضوحاً */
        #card-element {
            padding: 0.75rem;
            border: 1px solid var(--accent);
            /* حدود بلون التركيز */
            border-radius: 8px;
            background-color: var(--secondary);
            /* لون بنفسجي غامق فاتح قليلاً */
            /* ضمان وضوح العنصر */
        }

        /* رسائل الخطأ */
        #card-errors {
            color: var(--accent);
            /* استخدام لون التركيز للأخطاء */
            margin-top: 1rem;
            font-weight: 500;
            text-align: center;
            background-color: #7a2424;
            /* خلفية حمراء داكنة */
            border: 1px solid #ff6b6b;
            padding: 0.75rem;
            border-radius: 8px;
            display: none;
            /* يتم إظهاره عبر JavaScript */
        }

        /* زر الدفع */
        .submit-btn {
            background-color: var(--primary);
            /* برتقالي جذاب */
            color: var(--dark);
            /* نص غامق للتباين */
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-top: 2rem;
            width: 100%;
        }

        .submit-btn:hover:not(:disabled) {
            background-color: var(--accent);
            /* يتغير لون الزر عند التمرير */
            transform: translateY(-3px);
            color: var(--dark);
        }

        .submit-btn:disabled {
            background-color: #ff9d5c;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2>إتمام عملية الدفع</h2>

        <form id="payment-form">
            <div class="form-group">
                <label for="email">E-mail </label>
                <input type="email" id="email" placeholder="Enter Your Email" required>
            </div>

            <div class="form-group">
                <label for="amount">المبلغ المطلوب دفعه</label>
                <input type="text" id="amount" value="150.00 ر.س" readonly>
            </div>

            <div class="form-group">
                <label for="card-element"> Cridet Card Info</label>
                <div id="card-element">
                </div>
            </div>

            <div id="card-errors" role="alert"></div>

            @include('partials.paybutton')

        </form>
    </div>


    <script>
        // إعداد Stripe (هذا الجزء مطلوب لتجربة الواجهة بشكل كامل)
        const stripe = Stripe('pk_test_XXXXXXXXXXXXXXXXXXXXXXXX'); // *ضع مفتاحك العام هنا*
        const elements = stripe.elements();

        // إنشاء عنصر البطاقة
        const card = elements.create('card', {
            style: {
                base: {
                    iconColor: 'var(--accent)',
                    color: 'var(--light)',
                    fontWeight: '500',
                    fontFamily: 'Segoe UI, Tahoma, Geneva, Verdana, sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4',
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
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.style.display = 'block';
            } else {
                displayError.textContent = '';
                displayError.style.display = 'none';
            }
        });

        // معالجة إرسال النموذج (هذا الجزء سيحتاج إلى ربط بالخادم في تطبيق Laravel)
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submit-button');

            // إيقاف الزر وعرض حالة التحميل
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner"></div>'; // يمكنك إضافة تصميم سبينر بسيط هنا إن أردت

            // في تطبيقك الفعلي، ستقوم هنا باستدعاء الخادم لإنشاء Payment Intent
            // ثم تأكيد الدفع باستخدام confirmCardPayment

            // محاكاة لعملية معالجة
            setTimeout(() => {
                // محاكاة النجاح أو الفشل
                alert('تم محاكاة إرسال بيانات الدفع. يجب الآن ربطها بـ Laravel.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'دفع الآن';
            }, 2000);
        });
    </script>
</body>

</html>
