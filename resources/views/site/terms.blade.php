@extends('layouts.site')

@section('title', 'اتفاقية الاستخدام - ' . env('APP_NAME'))

@section('content')
    <section class="lira-terms-page">
        <div class="container">
            <div class="lira-terms-hero">
                <div class="lira-terms-hero-copy">
                    <span class="lira-home-badge">{{ appName() }} LEGAL · TERMS OF USE</span>
                    <h1 class="lira-page-title">اتفاقية استخدام منصة {{ env('APP_NAME') }}</h1>
                    <p class="lira-page-subtitle">
                        باستخدامك للمنصة، فأنت تقر بمراجعة البنود التالية وفهمها والموافقة عليها بما يتوافق مع سياسات
                        الحساب، الإيداع، الأرباح، والالتزامات العامة داخل {{ appName() }}.
                    </p>
                </div>

                <div class="lira-hero-note">
                    <i class="fa-solid fa-file-shield"></i>
                    <div>
                        <strong>وثيقة تنظيم الاستخدام</strong>
                        <span>هذه الصفحة توضح الأساس التنظيمي للعلاقة بين المستخدم والمنصة.</span>
                    </div>
                </div>
            </div>

            <div class="lira-terms-summary">
                <div class="lira-terms-summary-item">
                    <span>الإيداع</span>
                    <strong>فترة تمهيد وتشغيل</strong>
                </div>

                <div class="lira-terms-summary-item">
                    <span>الالتزام</span>
                    <strong>حد أدنى 6 أشهر</strong>
                </div>

                <div class="lira-terms-summary-item">
                    <span>الأرباح</span>
                    <strong>حسب الخطة المعتمدة</strong>
                </div>

                <div class="lira-terms-summary-item">
                    <span>البيانات</span>
                    <strong>سياسة حماية وخصوصية</strong>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="lira-terms-card">
                        <div class="lira-terms-card-head">
                            <div class="lira-terms-card-icon">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div>
                                <h3>أولاً: الإيداع والاستخدام</h3>
                                <p>الضوابط الأساسية لتفعيل الحساب وبدء الاستفادة من المنصة.</p>
                            </div>
                        </div>

                        <div class="lira-terms-points">
                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">1</span>
                                <div>
                                    <h5>الإيداع الأولي</h5>
                                    <p>
                                        يتم تفعيل الحساب بعد فترة تمهيدية لتهيئة النظام تستغرق
                                        <strong>40 يوم عمل</strong>
                                        من تاريخ الإيداع. هذه الفترة مخصصة لضبط بيئة التشغيل ولا تُخصم من مدة الاستثمار.
                                    </p>
                                </div>
                            </div>

                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">2</span>
                                <div>
                                    <h5>مدة الالتزام</h5>
                                    <p>
                                        يتطلب الاشتراك في أي خطة التزامًا لا يقل عن
                                        <strong>6 أشهر</strong>
                                        من أجل استقرار العمليات. لا يمكن سحب رأس المال بالكامل قبل انتهاء هذه المدة.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lira-terms-card">
                        <div class="lira-terms-card-head">
                            <div class="lira-terms-card-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h3>ثانياً: الأرباح والسحب</h3>
                                <p>طريقة احتساب العوائد وضوابط تنفيذ السحب.</p>
                            </div>
                        </div>

                        <div class="lira-terms-points">
                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">3</span>
                                <div>
                                    <h5>آلية الأرباح</h5>
                                    <p>
                                        تُحتسب الأرباح وتُضاف بحسب الخطة المختارة، سواء كانت دورية بشكل يومي أو أسبوعي أو
                                        شهري، وفق ما هو موضح في تفاصيل كل باقة.
                                    </p>
                                </div>
                            </div>

                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">4</span>
                                <div>
                                    <h5>سياسة السحب</h5>
                                    <p>
                                        يحق للمستخدم سحب الأرباح المعلنة وفق السياسة المعتمدة. أما طلب سحب رأس المال قبل
                                        المدة المتفق عليها فيعد مخالفة لشروط الخطة.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lira-terms-card">
                        <div class="lira-terms-card-head">
                            <div class="lira-terms-card-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h3>ثالثاً: المخاطر وحدود المسؤولية</h3>
                                <p>المستخدم يقر بفهم طبيعة البيئة الاستثمارية وحدود مسؤولية المنصة.</p>
                            </div>
                        </div>

                        <div class="lira-terms-points">
                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">5</span>
                                <div>
                                    <h5>توضيح استثماري</h5>
                                    <p>
                                        الاستثمار بطبيعته ينطوي على مخاطر. النتائج السابقة لا تشكل ضمانًا للأداء المستقبلي،
                                        ولا تلتزم المنصة بعوائد ثابتة في حالات القوة القاهرة أو الظروف الاستثنائية.
                                    </p>
                                </div>
                            </div>

                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">6</span>
                                <div>
                                    <h5>المسؤولية الشخصية</h5>
                                    <p>
                                        قرار استخدام المنصة هو قرار شخصي من المستخدم. ولا تتحمل المنصة مسؤولية أي قرارات
                                        ناتجة عن تغيير الخطة أو محاولة الخروج المبكر خارج البنود المتفق عليها.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="lira-terms-card">
                        <div class="lira-terms-card-head">
                            <div class="lira-terms-card-icon">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <div>
                                <h3>رابعاً: السياسات العامة</h3>
                                <p>حماية البيانات وآلية تحديث السياسات مستقبلاً.</p>
                            </div>
                        </div>

                        <div class="lira-terms-points">
                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">7</span>
                                <div>
                                    <h5>حماية البيانات</h5>
                                    <p>
                                        تلتزم المنصة بحماية بيانات المستخدم وعدم مشاركتها مع أي جهة خارجية بما يخالف
                                        السياسات المعمول بها، مع اعتماد وسائل حماية مناسبة للبيانات والحساب.
                                    </p>
                                </div>
                            </div>

                            <div class="lira-terms-point">
                                <span class="lira-terms-point-index">8</span>
                                <div>
                                    <h5>التعديلات</h5>
                                    <p>
                                        تحتفظ المنصة بحق تحديث الشروط أو النسب أو السياسات بما يتناسب مع متغيرات السوق أو
                                        التشغيل، مع الإشارة إلى أي تغييرات جوهرية عند الحاجة.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="lira-terms-ack">
                        <div class="lira-terms-ack-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div>
                            <h4>إقرار المستخدم</h4>
                            <p>
                                ببدء استخدامك لمنصة <strong>{{ env('APP_NAME') }}</strong> فأنت تؤكد صحة بياناتك،
                                وتوافق على جميع البنود والسياسات المذكورة في هذه الصفحة باعتبارها جزءًا من شروط الاستخدام
                                المنظمة للحساب.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom_styles')
    <style>
        .lira-terms-page {
            padding: 56px 0 72px;
        }

        .lira-terms-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .lira-terms-hero-copy {
            max-width: 760px;
        }

        .lira-page-title {
            margin-bottom: 14px;
            color: var(--lira-text);
            font-size: clamp(1.9rem, 3vw, 3rem);
            line-height: 1.25;
            font-weight: 800;
        }

        .lira-page-subtitle {
            color: var(--lira-text-muted);
            font-size: 15px;
            line-height: 2;
            margin: 0;
            max-width: 760px;
        }

        .lira-hero-note {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-width: 280px;
        }

        .lira-hero-note i {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            flex: 0 0 auto;
        }

        .lira-hero-note strong {
            display: block;
            margin-bottom: 3px;
            font-size: 13px;
            color: var(--lira-text);
        }

        .lira-hero-note span {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-terms-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 26px;
        }

        .lira-terms-summary-item {
            padding: 16px;
            border-radius: 18px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                rgba(16, 20, 28, 0.92);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-terms-summary-item span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .lira-terms-summary-item strong {
            color: var(--lira-text);
            font-size: 14px;
        }

        .lira-terms-card {
            height: 100%;
            padding: 24px;
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                rgba(16, 20, 28, 0.92);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-terms-card-head {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
        }

        .lira-terms-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            font-size: 20px;
            flex: 0 0 auto;
        }

        .lira-terms-card-head h3 {
            margin: 0 0 6px;
            color: var(--lira-text);
            font-size: 1.08rem;
        }

        .lira-terms-card-head p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-terms-points {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .lira-terms-point {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.04);
        }

        .lira-terms-point-index {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            font-size: 12px;
            font-weight: 800;
            flex: 0 0 auto;
        }

        .lira-terms-point h5 {
            margin: 0 0 6px;
            color: var(--lira-accent);
            font-size: 14px;
            font-weight: 800;
        }

        .lira-terms-point p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 13px;
            line-height: 1.95;
        }

        .lira-terms-ack {
            margin-top: 8px;
            padding: 22px;
            border-radius: 24px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(0, 230, 167, 0.06);
            border: 1px solid rgba(0, 230, 167, 0.16);
        }

        .lira-terms-ack-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            font-size: 22px;
            flex: 0 0 auto;
        }

        .lira-terms-ack h4 {
            margin: 0 0 8px;
            color: var(--lira-text);
            font-size: 1.05rem;
        }

        .lira-terms-ack p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 2;
        }

        @media (max-width: 991.98px) {
            .lira-terms-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .lira-terms-page {
                padding: 34px 0 56px;
            }

            .lira-terms-summary {
                grid-template-columns: 1fr;
            }

            .lira-terms-card,
            .lira-terms-ack {
                padding: 18px;
                border-radius: 20px;
            }

            .lira-terms-card-head,
            .lira-terms-ack {
                align-items: flex-start;
            }
        }
    </style>
@endpush

