<section class="hp-cta-action-clean">
    <div class="container">
        <div class="hp-cta-action-wrapper wow fadeInUp">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hp-cta-action-text">
                        <span class="hp-badge-tag-alt mb-3">ابدأ رحلتك خلال دقائق</span>
                        <h2 class="hp-sec-title-clean mb-4">واجهة قوية، وخطوات بسيطة</h2>
                        <p class="hp-section-desc-clean mb-5">
                            تم تصميم {{ appName() }} لتكون مباشرة وفعالة. أنشئ حسابك الآن، واستمتع بتجربة تداول تجمع بين التكنولوجيا المتقدمة وسهولة الاستخدام المطلقة.
                        </p>
                        
                        <div class="hp-cta-action-buttons d-flex gap-3 flex-wrap">
                            <a href="{{ route('register') }}" class="hp-btn-gold">ابدأ الآن</a>
                            @auth
                                <a href="{{ route('site.trading') }}" class="hp-cta-demo-btn">لوحة التحكم</a>
                            @else
                                <a href="{{ route('demo.login') }}" class="hp-cta-demo-btn">تجربة الحساب التجريبي</a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-5 mt-5 mt-lg-0">
                    <div class="hp-cta-action-grid">
                        <div class="hp-cta-action-item">
                            <div class="hp-cta-action-icon"><x-niro-icon name="markets" /></div>
                            <div>
                                <h4 class="hp-cta-action-item-title">تنفيذ لحظي</h4>
                                <p class="hp-cta-action-item-desc">سرعة عالية في تنفيذ العمليات</p>
                            </div>
                        </div>
                        <div class="hp-cta-action-item">
                            <div class="hp-cta-action-icon"><x-niro-icon name="security" /></div>
                            <div>
                                <h4 class="hp-cta-action-item-title">حماية قصوى</h4>
                                <p class="hp-cta-action-item-desc">بيئة آمنة لبياناتك وأموالك</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-cta-action-clean {
        padding: 100px 0;
        background-color: #0d121c;
        border-bottom: 1px solid #1f2937;
    }

    .hp-cta-action-wrapper {
        padding: 60px;
        background: #111827;
        border: 1px solid #1f2937;
        border-radius: 32px;
        position: relative;
        overflow: hidden;
    }

    .hp-cta-action-grid {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .hp-cta-action-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .hp-cta-action-item:hover {
        background: rgba(0, 230, 167, 0.05);
        border-color: rgba(0, 230, 167, 0.1);
    }

    .hp-cta-action-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 230, 167, 0.1);
        color: var(--lira-accent, #00e6a7);
        font-size: 1.25rem;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .hp-cta-action-icon .niro-icon {
        width: 22px;
        height: 22px;
        color: currentColor;
    }

    .hp-cta-action-item-title {
        color: #f8fafc;
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.1rem;
    }

    .hp-cta-action-item-desc {
        color: #94a3b8;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    @media (max-width: 991px) {
        .hp-cta-action-wrapper {
            padding: 40px 24px;
        }
        .hp-cta-action-text {
            text-align: center;
        }
        .hp-cta-action-buttons {
            justify-content: center;
        }
    }
</style>

