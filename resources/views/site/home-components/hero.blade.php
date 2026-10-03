<section class="hp-hero">
    <div class="hp-hero-bg" aria-hidden="true">
        <video class="hp-hero-video" autoplay muted loop playsinline preload="auto"
            poster="{{ $homeMedia['heroPoster'] ?? asset('assets/images/home/hero.jpg') }}">
            <source src="{{ $homeMedia['heroVideo'] ?? asset('assets/video/home/hero-loop.mp4') }}" type="video/mp4">
        </video>
        <!-- A deep dark gradient overlay to ensure text contrast -->
        <div class="hp-hero-overlay"></div>
    </div>

    <div class="container hp-hero-container">
        <div class="hp-hero-content text-center wow fadeInUp" data-wow-duration="1.5s">

            <h1 class="hp-hero-title">
                ابدأ رحلتك في عالم التداول <span class="text-gold">الذكي</span> مع {{ appName() }}
            </h1>

            <p class="hp-hero-sub mx-auto">
                نوفر لك الأدوات الاحترافية والخبرات اللازمة لتحويل أهدافك المالية إلى واقع ملموس، عبر التكنولوجيا
                المتطورة وبيئات التداول الشفافة.
            </p>

            <div class="hp-cta-actions">
                @auth
                    <a href="{{ route('site.trading') }}" class="hp-btn-gold hp-btn-hero">الدخول إلى المنصة</a>
                @else
                    <a href="{{ route('register') }}" class="hp-btn-gold hp-btn-hero">افتح حساب حقيقي</a>
                    <a href="{{ route('demo.login') }}" class="hp-cta-demo-btn ms-lg-3">ابدأ بحساب تجريبي</a>
                @endauth
            </div>
        </div>
    </div>
</section>

<style>
    .hp-hero {
        position: relative;
        height: 100vh;
        height: 100dvh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 0;
        margin-top: calc(var(--lira-public-header-height, 92px) * -1);
        /* Pull up behind transparent header */
    }

    .hp-hero-container {
        position: relative;
        z-index: 2;
        /* Removed padding-top to make hero fill the screen completely */
    }

    .hp-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background-color: #07090d;
    }

    .hp-hero-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .hp-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(7, 9, 13, 0.28) 0%, rgba(7, 9, 13, 0.76) 58%, rgba(10, 15, 23, 0.95) 100%);
    }

    .hp-hero-content {
        max-width: 900px;
        margin: 0 auto;
    }

    .hp-hero-title {
        font-size: clamp(3rem, 6vw, 5rem);
        line-height: 1.15;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 24px;
        letter-spacing: -0.02em;
    }

    .hp-hero-sub {
        font-size: clamp(1.1rem, 2vw, 1.35rem);
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.7);
        max-width: 760px;
    }

    .hp-cta-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 24px;
    }

    @media (max-width: 767px) {
        .hp-hero-ctas,
        .hp-cta-actions {
            flex-direction: column;
            width: 100%;
            gap: 12px;
        }

        .hp-btn-gold,
        .hp-cta-demo-btn {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }
    }

    .hp-badge-tag {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 18px;
        border-radius: 100px;
        background: rgba(0, 230, 167, 0.1);
        border: 1px solid rgba(0, 230, 167, 0.2);
        color: var(--lira-accent, #00e6a7);
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .hp-btn-hero {
        min-height: 54px;
        padding: 0 34px;
        border-radius: 12px;
        font-size: 1.02rem;
        font-weight: 800;
        background: var(--lira-accent, #00e6a7);
        color: #0d1117 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(0, 230, 167, 0.82);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.14);
        transition: background-color 0.22s ease, border-color 0.22s ease, transform 0.22s ease, box-shadow 0.22s ease;
    }

    .hp-btn-hero:hover {
        transform: translateY(-1px);
        background: #14efb3;
        box-shadow: 0 9px 18px rgba(0, 0, 0, 0.16);
    }

    .hp-cta-demo-btn {
        min-height: 54px;
        padding: 0 34px;
        border-radius: 12px;
        font-size: 1.02rem;
        font-weight: 800;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        transition: background-color 0.22s ease, border-color 0.22s ease, transform 0.22s ease, box-shadow 0.22s ease;
    }

    .hp-cta-demo-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.14);
    }

    @media (max-width: 768px) {
        .hp-hero {
            height: auto;
            min-height: 100vh;
            min-height: 100dvh;
            padding: 92px 0 28px;
        }

        .hp-hero-ctas {
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .hp-cta-demo-btn,
        .hp-btn-hero {
            width: 100% !important;
            margin: 0 !important;
        }

        .hp-hero-container {
            padding-top: 8px;
        }

        .hp-hero-content {
            max-width: 100%;
        }

        .hp-hero-title {
            font-size: clamp(1.95rem, 8.8vw, 2.8rem);
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .hp-hero-sub {
            max-width: 100%;
            font-size: 0.9rem;
            line-height: 1.75;
        }

        .hp-btn-hero,
        .hp-cta-demo-btn {
            min-height: 48px;
            max-width: none;
            padding: 0 18px;
            font-size: 0.94rem;
            border-radius: 12px;
        }

        .hp-cta-actions {
            gap: 10px;
            margin-top: 16px;
        }
    }

    @media (max-width: 575.98px) {
        .hp-hero {
            padding: 86px 0 22px;
        }

        .hp-hero-title {
            font-size: clamp(1.72rem, 9.8vw, 2.2rem);
            line-height: 1.22;
        }

        .hp-hero-sub {
            font-size: 0.84rem;
            line-height: 1.72;
        }

        .hp-btn-hero,
        .hp-cta-demo-btn {
            min-height: 46px;
            font-size: 0.9rem;
        }
    }
</style>

