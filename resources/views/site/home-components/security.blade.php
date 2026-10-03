<section class="hp-trust-section">
    <div class="container">
        <div class="hp-section-heading text-center wow fadeInUp">
            <span class="hp-badge-tag-alt">الأمان والموثوقية</span>
            <h2 class="hp-sec-title-clean">بيئة تداول محصنة، واضحة، ومصممة لراحة بالك</h2>
            <p class="hp-section-desc-clean mx-auto">
                الأمان في {{ appName() }} ليس مجرد إضافة، بل هو الأساس الذي بنيت عليه منصتنا. نحن نضمن لك شفافية كاملة
                لحركة أموالك، مصحوبة بأحدث تقنيات الإدارة والمخاطر.
            </p>
        </div>

        <div class="hp-trust-shell">
            <article class="hp-trust-overview wow fadeInUp">
                <div class="hp-trust-overview-head">
                    <span class="hp-trust-overview-kicker">حماية متقدمة</span>
                    <h3 class="hp-trust-overview-title">أساس تشغيلي ثابت لكل قرار وكل تنفيذ</h3>
                    <p class="hp-trust-overview-desc">
                        نعطي الأولوية لحماية البيانات، وضوح الأداء، والمتابعة اللحظية حتى تبقى تجربة التداول مركزة وسهلة
                        القراءة.
                    </p>
                </div>

                <div class="hp-trust-overview-list">
                    <div class="hp-trust-overview-row">
                        <span class="hp-trust-overview-icon">
                            <x-niro-icon name="security" />
                        </span>
                        <div>
                            <strong>تشفير SSL من الدرجة البنكية</strong>
                            <span>حماية للبيانات والعمليات على مدار الساعة.</span>
                        </div>
                    </div>
                    <div class="hp-trust-overview-row">
                        <span class="hp-trust-overview-icon">
                            <x-niro-icon name="status" />
                        </span>
                        <div>
                            <strong>حركة مالية واضحة</strong>
                            <span>متابعة دقيقة ومباشرة بدون تعقيد بصري أو تشغيلي.</span>
                        </div>
                    </div>
                    <div class="hp-trust-overview-row">
                        <span class="hp-trust-overview-icon">
                            <x-niro-icon name="markets" />
                        </span>
                        <div>
                            <strong>جاهزية لحظية</strong>
                            <span>تقارير سريعة تساعدك على قراءة الوضع فوراً.</span>
                        </div>
                    </div>
                </div>
            </article>

            <div class="hp-trust-grid">
                <article class="hp-trust-item wow fadeInUp" data-wow-delay=".05s">
                    <div class="hp-trust-item-icon">
                        <x-niro-icon name="signals" />
                    </div>
                    <h3 class="hp-trust-item-title">إدارة مخاطر ذكية وواضحة قبل كل تنفيذ</h3>
                    <p class="hp-trust-item-desc">رؤية أوضح لمستوى المخاطرة قبل اتخاذ القرار، ضمن تجربة مباشرة وسهلة الفهم.</p>
                </article>

                <article class="hp-trust-item wow fadeInUp" data-wow-delay=".12s">
                    <div class="hp-trust-item-icon">
                        <x-niro-icon name="portfolio" />
                    </div>
                    <h3 class="hp-trust-item-title">شفافية كاملة في الأداء والتوزيع المالي</h3>
                    <p class="hp-trust-item-desc">عرض منظم للأداء والتوزيع المالي حتى تظل الصورة واضحة في كل لحظة.</p>
                </article>

                <article class="hp-trust-item wow fadeInUp" data-wow-delay=".18s">
                    <div class="hp-trust-item-icon">
                        <x-niro-icon name="markets" />
                    </div>
                    <h3 class="hp-trust-item-title">تقارير لحظية عن الأرباح، الخسائر، وحالة السوق</h3>
                    <p class="hp-trust-item-desc">قراءة فورية للمتغيرات الأساسية لتبقى المتابعة مركزة وسريعة الاستيعاب.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-trust-section {
        padding: 120px 0;
        background: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .hp-trust-section .hp-section-heading {
        max-width: 760px;
        margin: 0 auto 44px;
    }

    .hp-trust-shell {
        display: grid;
        grid-template-columns: minmax(300px, 0.95fr) minmax(0, 1.25fr);
        gap: 24px;
        align-items: stretch;
    }

    .hp-trust-overview,
    .hp-trust-item {
        background: rgba(15, 23, 35, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 22px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.14);
    }

    .hp-trust-overview {
        padding: 30px;
        display: grid;
        gap: 26px;
    }

    .hp-trust-overview-kicker {
        display: inline-flex;
        align-items: center;
        min-height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        background: rgba(0, 230, 167, 0.08);
        border: 1px solid rgba(0, 230, 167, 0.16);
        color: var(--lira-accent, #00e6a7);
        font-size: 0.82rem;
        font-weight: 800;
    }

    .hp-trust-overview-title {
        margin: 14px 0 12px;
        color: #f8fafc;
        font-size: clamp(1.5rem, 2vw, 2rem);
        font-weight: 800;
        line-height: 1.5;
    }

    .hp-trust-overview-desc {
        margin: 0;
        color: #94a3b8;
        font-size: 0.98rem;
        line-height: 1.9;
    }

    .hp-trust-overview-list {
        display: grid;
        gap: 14px;
    }

    .hp-trust-overview-row {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 14px;
        align-items: start;
        padding: 16px 18px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .hp-trust-overview-icon,
    .hp-trust-item-icon {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .hp-trust-overview-icon .niro-icon,
    .hp-trust-item-icon .niro-icon {
        width: 22px;
        height: 22px;
    }

    .hp-trust-overview-row strong {
        display: block;
        color: #f8fafc;
        font-size: 0.98rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .hp-trust-overview-row span:last-child {
        display: block;
        color: #94a3b8;
        font-size: 0.88rem;
        line-height: 1.8;
    }

    .hp-trust-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .hp-trust-item {
        padding: 28px 24px;
        transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
    }

    .hp-trust-item:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 230, 167, 0.14);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
    }

    .hp-trust-item-title {
        margin: 18px 0 10px;
        color: #f8fafc;
        font-size: 1.05rem;
        line-height: 1.7;
        font-weight: 800;
    }

    .hp-trust-item-desc {
        margin: 0;
        color: #94a3b8;
        font-size: 0.92rem;
        line-height: 1.85;
    }

    @media (max-width: 1199px) {
        .hp-trust-shell {
            grid-template-columns: 1fr;
        }

        .hp-trust-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .hp-trust-section {
            padding: 78px 0;
        }

        .hp-trust-overview {
            padding: 24px 20px;
        }

        .hp-trust-grid {
            grid-template-columns: 1fr;
        }

        .hp-trust-item {
            padding: 22px 20px;
        }
    }
</style>
