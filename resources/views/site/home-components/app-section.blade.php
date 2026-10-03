<section class="hp-app-showcase">
    <div class="container hp-app-container">
        <div class="row align-items-center">
            <div class="col-lg-5 order-2 order-lg-1 wow fadeInLeft">
                <div class="hp-app-content">
                    <span class="hp-badge-tag-alt mb-3">متوفرة على جميع الأجهزة</span>
                    <h2 class="hp-sec-title-clean mb-4">
                        سوقك المالي... دائماً في جيبك
                    </h2>
                    <p class="hp-section-desc-clean mb-5">
                        منصة {{ appName() }} مصممة لتعمل بمرونة مطلقة. سواء كنت تراقب المؤشرات عبر حاسوبك الشخصي أو تنفذ صفقات سريعة من هاتفك المحمول، ستحصل دائماً على نفس القوة والوضوح.
                    </p>

                    <div class="hp-app-features">
                        <div class="hp-app-feat-item">
                            <i class="fa-solid fa-mobile-screen"></i>
                            <span>تحديثات حية ومزامنة فورية</span>
                        </div>
                        <div class="hp-app-feat-item">
                            <i class="fa-brands fa-apple"></i>
                            <span>تجربة سلسة على جميع الأنظمة</span>
                        </div>
                    </div>

                    <div class="hp-app-ctas mt-5">
                        <a href="{{ route('register') }}" class="hp-btn-gold">ابدأ التداول الآن</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 offset-lg-1 order-1 order-lg-2 mb-5 mb-lg-0 wow fadeInRight" data-wow-delay=".15s">
                <div class="hp-app-visual">
                    <div class="hp-app-glow"></div>
                    <!-- If this image doesn't exist, we fallback to a generic placeholder or the user's available mockup -->
                    <img src="{{ asset('assets/images/app-devices-mockup.png') }}" onerror="this.src='https://placehold.co/800x600/101623/00e6a7?text=Trading+Platform'" alt="{{ appName() }} Devices" class="img-fluid hp-app-img">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-app-showcase {
        padding: 120px 0;
        background-color: #0d121c; /* Soft dark contrasting background */
        border-bottom: 1px solid #1f2937;
        position: relative;
        overflow: hidden;
    }

    .hp-app-container {
        position: relative;
        z-index: 2;
    }

    .hp-app-content {
        max-width: 500px;
    }

    .hp-app-features {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .hp-app-feat-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        background: rgba(15, 23, 35, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        color: #e2e8f0;
        font-weight: 600;
        font-size: 1.05rem;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
    }

    .hp-app-feat-item i {
        color: var(--lira-accent, #00e6a7);
        font-size: 1.25rem;
    }

    .hp-app-visual {
        position: relative;
        text-align: center;
    }

    .hp-app-glow {
        display: none;
    }

    .hp-app-img {
        position: relative;
        z-index: 1;
        transform: none;
    }

    @media (max-width: 991px) {
        .hp-app-showcase {
            padding: 80px 0;
        }
        .hp-app-content {
            margin: 0 auto;
            text-align: center;
        }
        .hp-app-features {
            align-items: center;
        }
        .hp-badge-tag-alt {
            margin-left: auto;
            margin-right: auto;
        }
        .hp-btn-gold {
            width: 100%;
        }
    }
</style>

