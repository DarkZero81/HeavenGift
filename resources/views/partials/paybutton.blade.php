<style>
    /* From Uiverse.io by vinodjangid07 */
    .Btn {
        /* تم تغيير العرض ليناسب تصميمك */
        width: 100%;
        max-width: 250px;
        /* لجعله أصغر قليلاً من الحاوية */
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;

        /* ⭐️ التعديل على الألوان ⭐️ */
        background-color: var(--primary);
        /* برتقالي جذاب */
        color: var(--dark);
        /* نص غامق للتباين */

        border: none;
        font-weight: 700;
        /* جعل الخط أثقل */
        font-size: 1.1rem;
        gap: 8px;
        cursor: pointer;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        transition-duration: .3s;
        border-radius: 8px;
        /* مطابقة نمط الحدود في pay.blade.php */

        /* ⭐️ إضافة خاصية التوسيط ⭐️ */
        margin: 2rem auto 0 auto;
    }

    .svgIcon {
        width: 20px;
        /* زيادة حجم الأيقونة */
    }

    .svgIcon path {
        /* تغيير لون أيقونة البطاقة لتكون بنفس لون النص الداخلي */
        fill: var(--dark);
    }

    /* تغيير لون تأثير التمرير (الزر::before) */
    .Btn::before {
        width: 130px;
        height: 130px;
        position: absolute;
        content: "";
        background-color: var(--accent);
        /* تغيير اللون إلى الأصفر الذهبي */
        border-radius: 50%;
        left: -100%;
        top: 0;
        transition-duration: .3s;
        mix-blend-mode: difference;
    }

    .Btn:hover::before {
        transition-duration: .3s;
        transform: translate(100%, -50%);
        border-radius: 0;
    }

    .Btn:active {
        transform: translate(2px, 2px);
        transition-duration: .3s;
    }
</style>

<button class="Btn" type="submit" id="submit-button" onclick="{{ route('payment.success', 'success') }}">
    Pay Now
    <svg class="svgIcon" viewBox="0 0 576 512">
        <path
            d="M512 80c8.8 0 16 7.2 16 16v32H48V96c0-8.8 7.2-16 16-16H512zm16 144V416c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V224H528zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H248z">
        </path>
    </svg>
</button>
