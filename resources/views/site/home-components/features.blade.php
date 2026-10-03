{{-- § 4  WHY CHOOSE US — 8 feature cards + 1 CTA card (matches PO Trade advantages grid) --}}
<section class="hp-features">
    <div class="container">
        <div class="hp-section-heading text-center wow fadeInUp">
            <h2 class="hp-sec-title">قرارات أذكى… نتائج أفضل</h2>
            <p class="hp-section-desc">استفد من مؤشرات وإشارات مبنية على تحليل بيانات دقيق، لتبقى خطوة أمام السوق وتتداول بثقة أعلى.</p>
        </div>

        <div class="row g-3">
            @foreach($featuresData as $feat)
            <div class="col-lg-3 col-md-4 col-6 wow fadeInUp" data-wow-delay=".{{ $loop->index + 1 }}s">
                <a href="{{ $feat['url'] ?? '#' }}" class="hp-feat-card">
                    <div class="hp-feat-icon"><i class="{{ $feat['icon'] }}"></i></div>
                    <div class="hp-feat-title">{{ $feat['title'] }}</div>
                    <p class="hp-feat-desc">{{ $feat['desc'] }}</p>
                </a>
            </div>
            @endforeach
            {{-- Inline CTA card (mirrors PO Trade "Trade in one click" card) --}}
            <div class="col-lg-3 col-md-4 col-6 wow fadeInUp" data-wow-delay=".9s">
                <div class="hp-feat-cta-card">
                    <h4>تداول بنقرة واحدة</h4>
                    <a href="{{ route('register') }}" class="hp-btn-gold">ابدأ التداول</a>
                </div>
            </div>
        </div>
    </div>
</section>
