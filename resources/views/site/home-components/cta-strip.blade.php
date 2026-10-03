{{-- § 6  PROMO STRIP — Premium Email Capture --}}
<section class="hp-premium-promo">
    <div class="container">
        <div class="hp-promo-card wow fadeInUp">
            
            <div class="hp-promo-text">
                <h3>🎁 عرض خاص لك!</h3>
                <p>سجّل بريدك الإلكتروني واحصل على عرض ترحيبي حصري من {{ appName() }} لتبدأ تداولك بميزة إضافية.</p>
            </div>
            
            <div>
                <form class="hp-promo-inline-form" action="{{ route('register') }}" method="GET">
                    <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني..." dir="ltr" required>
                    <button type="submit" class="hp-btn-gold">ابدأ الآن</button>
                </form>
                <div class="text-muted small mt-3 px-2">
                    <i class="fa-solid fa-lock me-1"></i> معلوماتك الخاصة مشفرة وآمنة تماماً.
                </div>
            </div>
            
        </div>
    </div>
</section>
