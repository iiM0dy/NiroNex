{{-- Why Choose Us / Benefits Section - Data passed via $benefitsData from home.blade.php --}}
<section class="hp-benefits-section">
    <div class="container">
        <div class="hp-section-header text-center mb-4 wow fadeInUp">
            <span class="hp-badge-tag">⭐ لماذا {{ appName() }}؟</span>
            <h2 class="hp-section-title">لماذا يختار المتداولون {{ appName() }}؟</h2>
            <p class="hp-section-desc">مزايا حقيقية تجعل تجربتك في التداول مختلفة تماماً</p>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($benefitsData as $benefit)
            <div class="col-lg-3 col-md-4 col-6 wow fadeInUp" data-wow-delay=".{{ $loop->index + 1 }}s">
                <div class="hp-benefit-card">
                    <div class="hp-benefit-icon">
                        <i class="{{ $benefit['icon'] }}"></i>
                    </div>
                    <h5 class="hp-benefit-title">{{ $benefit['title'] }}</h5>
                    <p class="hp-benefit-desc">{{ $benefit['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
