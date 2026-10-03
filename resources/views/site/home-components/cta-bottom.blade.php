<section class="hp-cta-cinematic text-center">
    <!-- Cinematic Background Image with Overlay -->
    <div class="hp-cta-bg" style="background-image: url('{{ $homeMedia['ctaScene'] ?? asset('assets/images/home/cta.jpg') }}');">
        <div class="hp-cta-overlay"></div>
    </div>

    <div class="container hp-cta-container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                <span class="hp-badge-tag-alt text-brand-gold mb-3">جاهز للخطوة التالية؟</span>
                <h2 class="hp-cta-title">ابدأ الآن خلال دقائق وتحكم في مستقبلك المالي</h2>
                <p class="hp-cta-desc mb-5">
                    انضم إلى منصة {{ appName() }} اليوم واستفد من أحدث تقنيات التحليل، أدوات التنفيذ الاحترافية، وبيئة التداول المتكاملة التي صممت لتواكب تطلعاتك.
                </p>

                <div class="hp-cta-actions">
                    <a href="{{ route('register') }}" class="hp-btn-gold hp-btn-hero">افتح حساب حقيقي</a>
                    @auth
                        <a href="{{ route('site.trading') }}" class="hp-cta-demo-btn">لوحة التحكم</a>
                    @else
                        <a href="{{ route('demo.login') }}" class="hp-cta-demo-btn ms-lg-3">ابدأ بحساب تجريبي</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-cta-cinematic {
        position: relative;
        padding: 140px 0;
        overflow: hidden;
    }

    .hp-cta-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-attachment: scroll;
        z-index: 0;
    }

    .hp-cta-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(7, 9, 13, 0.58) 0%, rgba(7, 9, 13, 0.86) 100%);
    }

    .hp-cta-container {
        position: relative;
        z-index: 2;
    }

    .text-brand-gold {
        color: var(--lira-accent, #00e6a7) !important;
        justify-content: center;
    }

    .hp-cta-title {
        font-size: clamp(2.5rem, 4vw, 3.5rem);
        font-weight: 900;
        color: #ffffff;
        line-height: 1.25;
        margin-bottom: 24px;
        letter-spacing: -0.02em;
    }

    .hp-cta-desc {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.15rem;
        line-height: 1.8;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hp-cta-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .hp-cta-cinematic {
            padding: 90px 0;
        }
        .hp-cta-bg {
            background-attachment: scroll;
            background-position: center;
        }
        .hp-cta-actions {
            flex-direction: column;
            width: 100%;
        }
        .hp-cta-actions .hp-btn-gold,
        .hp-cta-actions .hp-cta-demo-btn,
        .hp-cta-actions form {
            width: 100%;
            margin-left: 0 !important;
        }
        .hp-cta-actions form button {
            width: 100%;
        }
    }
</style>

