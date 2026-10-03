<section id="invest-options" class="hp-invest-styles">
    <div class="container">
        <div class="hp-section-heading text-center wow fadeInUp">
            <span class="hp-badge-tag-alt">مسارات الاستثمار الذكي</span>
            <h2 class="hp-sec-title-clean">اختر الطريقة التي تتناسب مع أهدافك</h2>

        </div>

        <div class="hp-clean-grid">
            <article class="hp-clean-card glow-card wow fadeInUp" data-wow-delay=".1s">
                <span class="hp-clean-number">01</span>

                <div class="hp-clean-header">
                    <div class="hp-clean-icon" style="color: #60a5fa;">
                        <x-niro-icon name="signals" />
                    </div>
                </div>

                <div class="hp-clean-body">
                    <h3 class="hp-clean-title">تداول تلقائي</h3>
                    <p class="hp-clean-desc">
                        دع الأنظمة الذكية تدير صفقاتك وتحلل الأسواق نيابة عنك على مدار الساعة، مع متابعة سهلة وواضحة
                        للأداء.
                    </p>
                </div>

                <div class="hp-clean-footer">
                    <span>متابعة 24/7</span>
                    <span>إشارات ذكية</span>
                    <span>استجابة فورية</span>
                </div>
            </article>

            <article class="hp-clean-card glow-card wow fadeInUp" data-wow-delay=".2s">
                <span class="hp-clean-number">02</span>

                <div class="hp-clean-header">
                    <div class="hp-clean-icon" style="color: var(--lira-accent, #00e6a7);">
                        <x-niro-icon name="portfolio" />
                    </div>
                </div>

                <div class="hp-clean-body">
                    <h3 class="hp-clean-title">محافظ استثمارية</h3>
                    <p class="hp-clean-desc">
                        استثمر أموالك ضمن باقات واستراتيجيات جاهزة ومدروسة حسب مستوى المخاطرة المفضل لديك، مع عرض شفاف
                        للأداء بالكامل.
                    </p>
                </div>

                <div class="hp-clean-footer">
                    <span>تنويع محسوب</span>
                    <span>مخاطرة مرئية</span>
                    <span>نمو مستدام</span>
                </div>
            </article>

            <article class="hp-clean-card glow-card wow fadeInUp" data-wow-delay=".3s">
                <span class="hp-clean-number">03</span>

                <div class="hp-clean-header">
                    <div class="hp-clean-icon" style="color: #34d399;">
                        <x-niro-icon name="markets" />
                    </div>
                </div>

                <div class="hp-clean-body">
                    <h3 class="hp-clean-title">تداول بنفسك</h3>
                    <p class="hp-clean-desc">
                        تحكم كامل بجميع صفقاتك في الوقت الحقيقي مع أدوات ومؤشرات احترافية للتحليل الفني وتجربة تداول
                        عالمية.
                    </p>
                </div>

                <div class="hp-clean-footer">
                    <span>لوحة احترافية</span>
                    <span>تحليل فوري</span>
                    <span>تنفيذ مباشر</span>
                </div>
            </article>
        </div>
    </div>
</section>

<style>
    .hp-invest-styles {
        padding: 120px 0;
        background-color: transparent;
        position: relative;
        z-index: 1;
    }

    .hp-section-heading {
        max-width: 800px;
        margin: 0 auto 64px;
    }

    .hp-badge-tag-alt {
        display: block;
        color: var(--lira-accent, #00e6a7);
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 16px;
        letter-spacing: 1px;
    }

    .hp-sec-title-clean {
        font-size: clamp(2rem, 3.5vw, 3rem);
        line-height: 1.3;
        font-weight: 800;
        color: #f8fafc;
        margin-bottom: 24px;
        letter-spacing: -0.01em;
    }

    .hp-section-desc-clean {
        font-size: clamp(1rem, 1.5vw, 1.1rem);
        line-height: 1.8;
        color: #94a3b8;
    }

    .hp-clean-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }

    .hp-clean-card {
        background: rgba(15, 23, 35, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 18px;
        padding: 44px 32px;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.14);
    }

    .hp-clean-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 230, 167, 0.18);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.18);
    }

    .hp-clean-number {
        position: absolute;
        top: 24px;
        left: 24px;
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        font-family: monospace;
    }

    .hp-clean-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start;

    }

    .hp-clean-icon {
        font-size: 2.5rem;
        margin-bottom: 24px;
    }

    .hp-clean-icon .niro-icon {
        width: 42px;
        height: 42px;
        color: currentColor;
    }

    .hp-clean-body {
        flex-grow: 1;
    }

    .hp-clean-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #f8fafc;
        margin-bottom: 16px;
    }

    .hp-clean-desc {
        font-size: 1rem;
        line-height: 1.7;
        color: #94a3b8;
    }

    .hp-clean-footer {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 32px;
        border-top: 1px solid #1f2937;
    }

    .hp-clean-footer span {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
    }

    @media (max-width: 1024px) {
        .hp-clean-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hp-clean-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .hp-invest-styles {
            padding: 52px 0;
        }

        .hp-section-heading {
            margin: 0 auto 28px;
        }

        .hp-clean-card {
            padding: 20px 16px;
            border-radius: 16px;
        }

        .hp-clean-icon {
            font-size: 1.7rem;
            margin-bottom: 12px;
        }

        .hp-clean-title {
            font-size: 1.18rem;
            margin-bottom: 10px;
        }

        .hp-clean-number {
            top: 16px;
            left: 16px;
            font-size: 0.92rem;
        }

        .hp-clean-desc {
            font-size: 0.88rem;
            line-height: 1.75;
        }

        .hp-clean-footer {
            margin-top: 18px;
            padding-top: 14px;
            gap: 8px;
        }

        .hp-clean-footer span {
            font-size: 0.74rem;
        }

        .hp-badge-tag-alt {
            font-size: 0.78rem;
            margin-bottom: 10px;
            letter-spacing: 0.4px;
        }

        .hp-sec-title-clean {
            font-size: 1.45rem;
            line-height: 1.4;
            margin-bottom: 0;
        }

        .hp-section-desc-clean {
            font-size: 0.85rem;
            line-height: 1.6;
        }
    }

    @media (max-width: 575.98px) {
        .hp-invest-styles {
            padding: 44px 0;
        }

        .hp-clean-card {
            padding: 18px 14px;
        }

        .hp-clean-header {
            margin-top: 4px;
        }

        .hp-clean-title {
            font-size: 1.08rem;
        }

        .hp-clean-desc {
            font-size: 0.84rem;
            line-height: 1.7;
        }

        .hp-clean-footer {
            margin-top: 16px;
            padding-top: 12px;
        }
    }
</style>
