@extends(backendView('layouts.site'))

@section('title', appName())
@section('meta_description', 'NiroNex هي منصة تداول ذكية مدعومة بالذكاء الاصطناعي لإدارة الحسابات بأمان، والإيداع والسحب، وأدوات التداول الآلي.')

@php
    $homeMedia = [
        'heroVisual' => asset('assets/images/new-images/IMG_0545.webp'),
        'modeVisual' => asset('assets/images/home/ttest.webp'),
        'modeSectionVisual' => asset('assets/images/new-images/tarding-chart1.webp'),
        'modeAiVisual' => asset('assets/images/home/niro-mode-ai.webp'),
        'modeVaultVisual' => asset('assets/images/home/niro-mode-vault.webp'),
        'modeTradeVisual' => asset('assets/images/home/niro-mode-trade.webp'),
        'trustVisual' => asset('assets/images/home/security-png.webp'),
        'platformVisual' => asset('assets/images/new-images/IMG_0549.webp'),
        'ctaScene' => asset('assets/images/new-images/sec-4.webp'),
    ];

    $marketStrip = [
        ['symbol' => 'EUR/USD', 'price' => '1.0924', 'change' => '+0.12%', 'direction' => 'up'],
        ['symbol' => 'GBP/USD', 'price' => '1.2641', 'change' => '-0.05%', 'direction' => 'down'],
        ['symbol' => 'BTC/USD', 'price' => '68,432', 'change' => '+2.4%', 'direction' => 'up'],
        ['symbol' => 'GOLD', 'price' => '2,041.50', 'change' => '+0.8%', 'direction' => 'up'],
        ['symbol' => 'NAS100', 'price' => '17,942', 'change' => '-0.3%', 'direction' => 'down'],
        ['symbol' => 'USD/JPY', 'price' => '148.50', 'change' => '+0.2%', 'direction' => 'up'],
    ];

    $heroMetrics = [
        [
            'id' => 'modes',
            'value' => '3', 
            'label' => 'أنماط تشغيل', 
            'note' => 'تلقائي، محافظ، أو تداول ذاتي',
            'icon' => asset('assets/images/new-icons/IMG_7722.svg')
        ],
        [
            'id' => 'follow',
            'value' => '24/7', 
            'label' => 'متابعة مرنة', 
            'note' => 'قراءة مستمرة للسوق والتنفيذ',
            'icon' => asset('assets/images/new-icons/IMG_7811.svg')
        ],
        [
            'id' => 'ssl',
            'value' => 'SSL', 
            'label' => 'بيئة آمنة', 
            'note' => 'حماية للبيانات والعمليات',
            'icon' => asset('assets/images/new-icons/IMG_7820.svg')
        ],
    ];

    $heroMetricDetails = [
        'modes' => [
            'title' => 'أنماط تشغيل تناسب كل هدف',
            'lead' => 'اختر بين التداول المباشر، المحافظ الاستثمارية، أو روبوت التداول الذكي.',
            'cards' => [
                [
                    'name' => 'Niro Trade',
                    'desc' => 'تداول مباشر داخل المنصة مع تنفيذ سريع ودقيق، حرية اختيار رأس المال، وتحكم كامل بالصفقات وإدارة المخاطر.',
                ],
                [
                    'name' => 'Niro Vault',
                    'desc' => 'محافظ استثمارية ذكية بخيارات Start و Trade، مصممة لعوائد دورية وإدارة مرنة تناسب المبتدئين والباحثين عن عوائد أعلى.',
                ],
                [
                    'name' => 'NiroNex AI',
                    'desc' => 'روبوت تداول بالذكاء الاصطناعي يعمل على سوق الفوركس آلياً مع تحديد رأس المال، المخاطرة، وقف الخسارة، وأهداف الربح.',
                ],
            ],
        ],
        'follow' => [
            'title' => '24/7 متابعة مرنة',
            'lead' => 'قراءة مستمرة للسوق والتنفيذ',
            'desc' => 'يوفر النظام مراقبة ذكية لحركة الأسواق على مدار الساعة لضمان سرعة الاستجابة للفرص وتنفيذ الصفقات بكفاءة عالية.',
            'points' => [
                'متابعة مباشرة 24/7',
                'تحليل لحظي لحركة السوق',
                'تنفيذ سريع ودقيق',
                'مراقبة مستمرة للفرص وإدارة المخاطر',
                'أداء مستقر دون مخاطرة برأس المال',
            ],
        ],
        'ssl' => [
            'title' => 'SSL - بيئة آمنة',
            'lead' => 'حماية متقدمة للبيانات والمعاملات',
            'desc' => 'نعتمد على بروتوكولات تشفير SSL الحديثة لتأمين الاتصال داخل المنصة وحماية بيانات المستخدمين والمعاملات المالية بأعلى مستويات الخصوصية.',
            'points' => [
                'تشفير كامل للبيانات',
                'حماية الحسابات والمعاملات',
                'خصوصية وأمان عالي',
                'اتصال آمن داخل المنصة',
                'أنظمة حماية ومراقبة مرنة',
            ],
        ],
    ];

    $tradingModes = [
        [
            'id' => 'nex',
            'index' => '01',
            'title' => 'NiroNex AI',
            'tab' => 'NiroNex AI',
            'summary' => 'ذكاء اصطناعي متطور للتداول الآلي في سوق الفوركس.',
            'paragraphs' => [
                'يفتح ويغلق الصفقات تلقائياً باستخدام استراتيجيات سكالبينغ سريعة وتحليل مباشر للسيولة والأخبار، بهدف اقتناص أفضل فرص السوق بأعلى سرعة ودقة.',
                'مصمم للأشخاص الذين يبحثون عن أرباح ذكية دون الحاجة إلى خبرة أو متابعة مستمرة للسوق.',
            ],
            'focus' => [
                'تنفيذ تلقائي للصفقات',
                'تحليل لحظي للسوق',
                'تداول وقت الأخبار والسيولة',
                'متابعة وتشغيل 24/7',
                'سرعة ودقة في اتخاذ القرار',
            ],
            'audience' => [
                'يريدون التداول بجهد أقل ونتائج أكثر',
                'لا يملكون خبرة كافية في الفوركس',
                'يبحثون عن نظام تداول ذكي وسريع',
                'لا يملكون وقتاً لمتابعة السوق باستمرار',
            ],
            'support' => 'لأنه يجمع بين سرعة الذكاء الاصطناعي ودقة التحليل لتنفيذ الصفقات تلقائياً وفق استراتيجيات مدروسة تساعد على استغلال فرص السوق بكفاءة واحترافية.',
            'image' => $homeMedia['modeAiVisual'],
            'visualNote' => 'تشغيل ذكي يراقب السوق باستمرار ويحوّل التحليل إلى تنفيذ أوضح.',
        ],
        [
            'id' => 'vault',
            'index' => '02',
            'title' => 'Niro Vault',
            'tab' => 'Niro Vault',
            'summary' => 'المحافظ الاستثمارية الذكية.',
            'paragraphs' => [
                'حلول استثمارية مصممة لإدارة رأس المال بذكاء، مع خطط مرنة تناسب المبتدئين والباحثين عن عوائد أعلى.',
            ],
            'focus' => [
                'إدارة ذكية لرأس المال',
                'خطط استثمار مرنة',
                'عوائد دورية مدروسة',
                'متابعة وتحليل مستمر',
            ],
            'plans' => [
                [
                    'name' => 'Start',
                    'desc' => 'بداية أبسط لأصحاب رأس المال المبتدئ مع نمو تدريجي ومخاطرة أقل.',
                ],
                [
                    'name' => 'Trade',
                    'desc' => 'مسار متقدم لمن يريد فرص نمو أعلى عبر استراتيجيات أكثر ديناميكية.',
                ],
            ],
            'audience' => [
                'المبتدئون في الاستثمار',
                'الباحثون عن عوائد مدروسة',
                'من يريدون إدارة احترافية لرأس المال',
            ],
            'support' => 'لأنها تختصر قرار الاستثمار في مسارين واضحين مع إدارة رأس مال ومخاطر أكثر هدوءاً.',
            'image' => $homeMedia['modeVaultVisual'],
            'visualNote' => 'مشهد استثماري أكثر هدوءاً يربط بين التوزيع والأداء داخل تجربة واحدة.',
        ],
        [
            'id' => 'trade',
            'index' => '03',
            'title' => 'Niro Trade',
            'tab' => 'Niro Trade',
            'summary' => 'منصة تداول احترافية تمنحك تحكماً كاملاً بصفقاتك مع تنفيذ فوري ووصول مباشر إلى السوق.',
            'paragraphs' => [
                'توفر Niro Trade أدوات تحليل متقدمة وتجربة تداول مرنة تساعدك على متابعة الأسواق العالمية وتنفيذ أوامرك بسهولة واحترافية من منصة واحدة متطورة.',
            ],
            'focus' => [
                'تنفيذ فوري للصفقات',
                'وصول مباشر إلى السوق',
                'تحليلات لحظية دقيقة',
                'لوحة تداول احترافية',
                'سرعة واستجابة عالية',
            ],
            'audience' => [
                'المتداولون الذين يفضلون التحكم الكامل بصفقاتهم',
                'أصحاب الخبرة في التداول والتحليل الفني',
                'من يبحثون عن سرعة تنفيذ عالية',
                'من يعتمدون على القرارات اللحظية وتحليل السوق',
            ],
            'support' => 'لأنها تمنحك بيئة تداول احترافية تجمع بين السرعة، الدقة، والتحكم الكامل، مع تنفيذ مباشر للصفقات يساعدك على استغلال فرص السوق بكفاءة ومرونة أكبر.',
            'image' => $homeMedia['modeTradeVisual'],
            'visualNote' => 'واجهة مباشرة تساعدك على قراءة الإشارات واتخاذ القرار في اللحظة نفسها.',
        ],
    ];
    $defaultTradingMode = 'nex';

    $trustPoints = [
        [
            'index' => '01',
            'title' => 'تشفير بنكي',
            'desc' => 'حماية متكاملة لبياناتك وعملياتك على مدار الساعة بأمان فائق.',
            'icon' => asset('assets/images/icons/IMG_7725.svg'),
        ],
        [
            'index' => '02',
            'title' => 'شفافية كاملة',
            'desc' => 'رؤية واضحة لحركة أموالك وأدائك المالي بكل بساطة ووضوح.',
            'icon' => asset('assets/images/new-icons/IMG_7822.svg'),
        ],
        [
            'index' => '03',
            'title' => 'تقارير لحظية',
            'desc' => 'قراءة فورية للأرباح وحالة السوق لاتخاذ قرار مالي أهدأ وأذكى.',
            'icon' => asset('assets/images/new-icons/IMG_7722.svg'),
        ],
    ];

    $homeSidebarSettings = array_merge(\App\Models\Setting::footerDefaults(), $footerSettings ?? []);
    $homeSidebarSocialLinks = array_filter([
        [
            'label' => 'Instagram',
            'icon' => 'fa-brands fa-instagram',
            'url' => $homeSidebarSettings['instagram_url'] ?? '',
        ],
        [
            'label' => 'Telegram',
            'icon' => 'fa-brands fa-telegram',
            'url' => $homeSidebarSettings['telegram_url'] ?? '',
        ],
    ], fn($link) => filled($link['url']));

    $platformStories = [
        [
            'index' => '01',
            'title' => 'مسارات مرنة',
            'desc' => 'تحكم كامل بصفقاتك أو اعتماد على الأنظمة الذكية في مكان واحد.',
        ],
        [
            'index' => '02',
            'title' => 'تعلّم واختبر',
            'desc' => 'حساب تجريبي يحاكي السوق الحقيقي لتطوير فهمك قبل أي مخاطرة.',
        ],
        [
            'index' => '03',
            'title' => 'إدارة واضحة',
            'desc' => 'إيداع وسحب سريع وآمن، مع مزايا وامتيازات تنمو مع تقدمك.',
        ],
        [
            'index' => '04',
            'title' => 'قرارات أذكى',
            'desc' => 'إشارات ومؤشرات مبنية على تحليل بيانات دقيق تمنحك وضوحاً أكبر.',
        ],
    ];

    $fallbackReviews = collect([
        [
            'name' => 'أحمد ك.',
            'date' => '2026-01-10',
            'rating' => 5,
            'text' => 'منصة ممتازة جداً وسرعة في السحب والإيداع. قسم الدعم الفني متجاوب دائماً وحل جميع مشاكلي خلال دقائق.',
        ],
        [
            'name' => 'سارة م.',
            'date' => '2026-01-18',
            'rating' => 5,
            'text' => 'واجهة واضحة وسهلة، والأرباح والمتابعة تظهر بشكل مرتب بدون تعقيد. التجربة مريحة حتى للمستخدم الجديد.',
        ],
        [
            'name' => 'خالد ع.',
            'date' => '2026-01-24',
            'rating' => 5,
            'text' => 'أعجبني تنوع الخطط وسهولة الانتقال بين التداول اليدوي والروبوت. كل شيء واضح من لوحة التحكم.',
        ],
    ]);

    $displayReviews = $fallbackReviews;
    $averageRating = number_format((float) ($displayReviews->avg(fn($review) => (int) data_get($review, 'rating', 5)) ?: 5), 1);
    $reviewCount = $displayReviews->count();
    $featuredReview = $displayReviews->first();
    $supportingReviews = $displayReviews->slice(1, 2)->values();

    if ($supportingReviews->count() < 2) {
        $supportingReviews = $supportingReviews
            ->concat($fallbackReviews->take(2 - $supportingReviews->count()))
            ->values();
    }
@endphp

@push('custom_styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alexandria:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap');

        :root {
            --hp-bg: #0d1117;
            --hp-surface: #121826;
            --hp-surface-soft: rgba(18, 24, 38, 0.72);
            --hp-line: rgba(167, 176, 192, 0.16);
            --hp-line-soft: rgba(167, 176, 192, 0.1);
            --hp-text: #f4f6fa;
            --hp-muted: #a7b0c0;
            --hp-blue: #1a2bff;
            --hp-teal: #00e6a7;
            --hp-violet: #7861ff;
            --hp-shadow: 0 24px 48px rgba(3, 8, 18, 0.24);
        }

        /* Scroll Reveal Utility */
        .hp-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1),
                transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .hp-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered children animation */
        .hp-stagger>* {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.5s cubic-bezier(0.2, 0.8, 0.2, 1),
                transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .hp-stagger.is-visible>*:nth-child(1) {
            transition-delay: 0s;
        }

        .hp-stagger.is-visible>*:nth-child(2) {
            transition-delay: 0.1s;
        }

        .hp-stagger.is-visible>*:nth-child(3) {
            transition-delay: 0.2s;
        }

        .hp-stagger.is-visible>*:nth-child(4) {
            transition-delay: 0.3s;
        }

        .hp-stagger.is-visible>*:nth-child(5) {
            transition-delay: 0.4s;
        }

        .hp-stagger.is-visible>*:nth-child(6) {
            transition-delay: 0.5s;
        }

        .hp-stagger.is-visible>* {
            opacity: 1;
            transform: translateY(0);
        }

        /* Slide from side */
        .hp-slide-in-start {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1),
                transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .hp-slide-in-end {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1),
                transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .hp-slide-in-start.is-visible,
        .hp-slide-in-end.is-visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Trust point hover lift */
        .hp-home .hp-trust-point {
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .hp-home .hp-trust-point:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Platform point hover */
        .hp-home .hp-platform-point {
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .hp-home .hp-platform-point:hover {
            transform: translateX(-4px);
            background: rgba(255, 255, 255, 0.03);
        }

        .hp-home {
            position: relative;
            overflow: clip;
            background:
                radial-gradient(circle at 88% 10%, rgba(26, 43, 255, 0.12), transparent 20%),
                radial-gradient(circle at 12% 18%, rgba(0, 230, 167, 0.08), transparent 24%),
                linear-gradient(180deg, #0d1117 0%, #0b1017 58%, #091019 100%);
            color: var(--hp-text);
            font-family: 'Alexandria', 'Cairo', sans-serif !important;
        }

        .hp-home,
        .hp-home h1,
        .hp-home h2,
        .hp-home h3,
        .hp-home h4,
        .hp-home h5,
        .hp-home h6,
        .hp-home p,
        .hp-home a,
        .hp-home span,
        .hp-home div,
        .hp-home button,
        .hp-home input,
        .hp-home textarea {
            font-family: 'Alexandria', 'Cairo', sans-serif !important;
        }

        .hp-home section {
            position: relative;
        }

        .hp-home .container {
            position: relative;
            z-index: 1;
        }

        .hp-home img {
            display: block;
            max-width: 100%;
        }

        .hp-home .hp-latin,
        .hp-home .hp-number {
            direction: ltr;
            display: inline-flex;
            justify-content: center;
            margin-inline: auto;
            text-align: center;
            font-family: 'Poppins', sans-serif !important;
        }

        .hp-home .hp-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--hp-teal);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .hp-home .hp-kicker::before {
            content: '';
            width: 26px;
            height: 1px;
            background: currentColor;
            flex: 0 0 auto;
        }

        .hp-home .hp-section-head {
            display: grid;
            gap: 14px;
            margin-bottom: 30px;
        }

        .hp-home .hp-section-title {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -0.05em;
            color: var(--hp-text);
        }

        .hp-home .hp-section-title--md {
            font-size: clamp(1.75rem, 2.8vw, 2.8rem);
            line-height: 1.3;
        }

        .hp-home .hp-section-desc {
            margin: 0;
            max-width: 700px;
            color: rgba(244, 246, 250, 0.74);
            font-size: 0.98rem;
            line-height: 2;
        }

        .hp-home .hp-btn-primary,
        .hp-home .hp-btn-secondary {
            min-height: 54px;
            padding: 0 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 18px;
            border: 1px solid transparent;
            text-decoration: none !important;
            font-size: 0.95rem;
            font-weight: 800;
            line-height: 1;
            transition: transform 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, border-color 0.22s ease;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .hp-home .hp-btn-primary {
            background: #12dcb0;
            border-color: rgba(18, 220, 176, 0.92);
            color: #0d1117 !important;
            box-shadow: none;
        }

        .hp-home .hp-btn-secondary {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(244, 246, 250, 0.12);
            color: var(--hp-text) !important;
            box-shadow: none;
        }

        .hp-home .hp-btn-primary:hover,
        .hp-home .hp-btn-secondary:hover {
            transform: translateY(-1px);
        }

        .hp-home .hp-btn-primary:hover {
            background: #22e6bc;
            border-color: rgba(34, 230, 188, 0.96);
            box-shadow: none;
        }

        .hp-home .hp-hero-actions form,
        .hp-home .hp-final-cta-actions form {
            display: flex;
            min-width: 0;
        }

        .hp-home .hp-hero-actions form button,
        .hp-home .hp-final-cta-actions form button {
            width: 100%;
        }

        .hp-home .hp-editorial-hero {
            position: relative;
            padding: calc(var(--lira-public-header-height, 92px) + 48px) 0 56px;
            z-index: 20;
        }

        .hp-home .hp-editorial-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('{{ $homeMedia['heroVisual'] }}');
            background-size: cover;
            background-position: center 20%;
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }

        .hp-home .hp-editorial-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(13, 17, 23, 0.15) 0%, rgba(13, 17, 23, 0.92) 85%);
            pointer-events: none;
            z-index: 0;
        }

        .hp-home .hp-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.06fr) minmax(0, 0.94fr);
            grid-template-areas: "media copy";
            gap: clamp(24px, 4vw, 58px);
            align-items: center;
        }

        .hp-home .hp-hero-copy {
            grid-area: copy;
            display: grid;
            gap: 22px;
        }

        .hp-home .hp-hero-title {
            margin: 0;
            font-size: clamp(2.6rem, 4.8vw, 4.8rem);
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -0.025em;
        }

        .hp-home .hp-hero-title span {
            display: inline;
            background: linear-gradient(135deg, var(--hp-text) 50%, var(--hp-muted) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hp-home .hp-hero-title .hp-tone-teal {
            color: var(--hp-teal) !important;
            background: none;
            -webkit-background-clip: text;
            -webkit-text-fill-color: currentColor;
        }

        .hp-home .hp-hero-sub {
            margin: 0;
            max-width: 620px;
            color: rgba(244, 246, 250, 0.78);
            font-size: 1rem;
            line-height: 2;
        }

        .hp-home .hp-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hp-home .hp-hero-note {
            margin: 0;
            color: #d7deea;
            font-size: 0.88rem;
            line-height: 1.9;
        }

        .hp-home .hp-hero-note strong {
            color: var(--hp-teal);
            font-weight: 800;
        }

        .hp-home .hp-hero-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0;
            padding-top: 24px;
            border-top: 1px solid var(--hp-line);
            align-items: center;
            position: relative;
            z-index: 12;
        }

        .hp-home .hp-hero-metric {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4px;
            padding: 4px 28px;
            border-inline-start: 1px solid var(--hp-line-soft);
            text-align: center;
        }

        .hp-home .hp-hero-metric-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--hp-teal);
        }

        .hp-home .hp-hero-metric-icon img,
        .hp-home .hp-hero-metric-icon svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hp-home .hp-hero-metric:first-child {
            padding-inline-start: 0;
            border-inline-start: 0;
            padding-inline-end: 28px;
        }



        .hp-home .hp-hero-metric strong,
        .hp-home .hp-hero-metric span,
        .hp-home .hp-hero-metric small {
            display: block;
        }

        .hp-home .hp-hero-metric strong {
            margin-bottom: 2px;
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--hp-text);
            line-height: 1;
        }

        .hp-home .hp-hero-metric span {
            margin-bottom: 0;
            color: #dbe2ec;
            font-size: 0.86rem;
            font-weight: 800;
            line-height: 1.65;
        }

        .hp-home .hp-hero-metric small {
            color: var(--hp-muted);
            font-size: 0.74rem;
            line-height: 1.78;
        }

        .hp-home .hp-hero-visual {
            grid-area: media;
            position: relative;
            margin: 0;
            width: 100%;
            overflow: hidden;
            border-radius: 36px;
            background: #111827;
            box-shadow: var(--hp-shadow);
            align-self: start;
            /* prevent grid stretching */
            isolation: isolate;
        }

        .hp-home .hp-hero-visual img {
            width: 100%;
            height: auto;
            display: block;
            vertical-align: top;
        }

        .hp-home .hp-hero-visual::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(130deg, rgba(8, 12, 18, 0.02), rgba(8, 12, 18, 0.45)),
                linear-gradient(180deg, transparent 50%, rgba(8, 12, 18, 0.72) 100%);
        }

        .hp-home .hp-hero-caption {
            position: absolute;
            right: 28px;
            left: 28px;
            bottom: 28px;
            z-index: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
        }

        .hp-home .hp-hero-caption strong,
        .hp-home .hp-hero-caption span {
            display: block;
        }

        .hp-home .hp-hero-caption strong {
            margin-bottom: 8px;
            color: var(--hp-text);
            font-size: 1.08rem;
            font-weight: 800;
        }

        .hp-home .hp-hero-caption span {
            max-width: 360px;
            color: rgba(244, 246, 250, 0.76);
            font-size: 0.84rem;
            line-height: 1.85;
        }

        .hp-home .hp-hero-caption-mark {
            align-self: flex-start;
            color: rgba(244, 246, 250, 0.84);
            font-size: 0.76rem;
            font-weight: 800;
        }

        .hp-home .hp-market-ribbon {
            padding: 0;
            overflow: hidden;
            background: rgba(18, 24, 38, 0.4);
            border-top: 1px solid var(--hp-line-soft);
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-ticker-viewport {
            overflow: hidden;
            width: 100%;
            padding: 14px 0;
        }

        .hp-home .hp-ticker-track {
            display: flex;
            width: max-content;
            animation: hp-marquee 180s linear infinite;
        }

        .hp-home .hp-ticker-track:hover {
            animation-play-state: paused;
        }

        .hp-home .hp-ticker-half {
            display: flex;
            gap: 28px;
            padding-right: 28px;
            flex-shrink: 0;
            align-items: center;
        }

        @keyframes hp-marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .hp-home .hp-market-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--hp-text);
            white-space: nowrap;
        }

        .hp-home .hp-market-symbol {
            color: #dce4ef;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .hp-home .hp-market-price {
            color: var(--hp-text);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .hp-home .hp-market-change,
        .hp-home .hp-market-arrow {
            font-size: 0.75rem;
            font-weight: 800;
        }

        .hp-home .hp-market-item.is-up .hp-market-change,
        .hp-home .hp-market-item.is-up .hp-market-arrow {
            color: #00d26a;
        }

        .hp-home .hp-market-item.is-down .hp-market-change,
        .hp-home .hp-market-item.is-down .hp-market-arrow {
            color: #ff3b30;
        }

        .hp-home .hp-features-highlight {
            padding: 72px 0;
            background: #05080E;
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-features-highlight {
            padding: 80px 0;
            background: #05080E;
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-features-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            text-align: center;
        }

        .hp-home .hp-feature-item {
            padding: 20px 32px;
            position: relative;
        }

        .hp-home .hp-feature-item:not(:last-child) {
            border-inline-end: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hp-home .hp-feature-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 24px;
            padding: 10px;
            color: var(--hp-teal);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hp-home .hp-feature-icon svg,
        .hp-home .hp-feature-icon img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
        }

        .hp-home .hp-feature-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--hp-text);
        }

        .hp-home .hp-feature-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--hp-muted);
            margin: 0;
        }

        /* Mobile style: matched to desktop as requested */
        @media (max-width: 767.98px) {
            .hp-home .hp-feature-icon {
                width: 74px;
                height: 74px;
                padding: 8px;
                margin: 0 auto 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .hp-home .hp-feature-icon svg {
                width: 100%;
                height: 100%;
            }
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-features-strip {
                grid-template-columns: repeat(2, 1fr);
                gap: 32px 0;
            }

            .hp-home .hp-feature-item {
                padding: 16px 20px;
                border: none !important;
                /* No borders on tablet/mobile */
            }

            .hp-home .hp-feature-title {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-feature-title {
                font-size: 0.85rem;
                margin-bottom: 6px;
            }

            .hp-home .hp-feature-desc {
                font-size: 0.75rem;
            }
        }

        .hp-home .hp-modes {
            padding: 96px 0 72px;
        }

        .hp-home .hp-mode-shell {
            display: grid;
            gap: 28px;
        }

        .hp-home .hp-mode-carousel {
            position: relative;
        }

        .hp-home .hp-mode-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-mode-trigger {
            position: relative;
            appearance: none;
            padding: 0 0 12px;
            border: 0;
            background: transparent;
            color: var(--hp-muted);
            font-size: 0.96rem;
            font-weight: 800;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .hp-home .hp-mode-trigger::after {
            content: '';
            position: absolute;
            right: 0;
            left: 0;
            bottom: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--hp-blue), var(--hp-teal));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.2s ease;
        }

        .hp-home .hp-mode-trigger.is-active {
            color: var(--hp-text);
        }

        .hp-home .hp-mode-trigger.is-active::after {
            transform: scaleX(1);
        }

        .hp-home .hp-mode-panel {
            display: none;
            grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.08fr);
            grid-template-areas: "visual copy";
            gap: clamp(32px, 5vw, 68px);
            align-items: center;
        }

        .hp-home .hp-mode-panel.is-active {
            display: grid;
        }

        .hp-home .hp-mode-visual {
            grid-area: visual;
            position: relative;
            margin: 0;
            width: 100%;
            max-width: 580px;
            border-radius: 22px;
            background: transparent;
            box-shadow: none;
            overflow: hidden;
            align-self: start;
            isolation: isolate;
        }

        .hp-home .hp-mode-visual img {
            width: 100%;
            height: auto;
            display: block;
            vertical-align: top;
            border-radius: inherit;
        }

        .hp-home .hp-mode-visual::after {
            display: none;
            content: none;
        }

        .hp-home .hp-mode-visual figcaption,
        .hp-home .hp-mode-visual .hp-mode-visual-note {
            position: absolute;
            right: 18px;
            left: 18px;
            bottom: 16px;
            z-index: 2;
            padding: 0;
            color: rgba(244, 246, 250, 0.9);
            font-size: 0.82rem;
            line-height: 1.65;
            margin: 0 auto;
            max-width: 560px;
            text-align: center;
        }

        .hp-home .hp-mode-copy {
            grid-area: copy;
            display: grid;
            gap: 18px;
        }

        .hp-home .hp-mode-index {
            color: rgba(167, 176, 192, 0.62);
            font-size: 0.78rem;
            font-weight: 800;
        }

        .hp-home .hp-mode-title {
            margin: 0;
            font-size: clamp(1.8rem, 3vw, 2.7rem);
            line-height: 1.28;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .hp-home .hp-mode-summary,
        .hp-home .hp-mode-desc {
            margin: 0;
            color: rgba(244, 246, 250, 0.76);
            font-size: 0.95rem;
            line-height: 2;
        }

        .hp-home .hp-mode-details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 26px;
            padding-top: 18px;
            border-top: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-mode-detail strong {
            display: block;
            margin-bottom: 8px;
            color: var(--hp-text);
            font-size: 0.9rem;
            font-weight: 800;
        }

        .hp-home .hp-mode-detail p {
            margin: 0;
            color: var(--hp-muted);
            font-size: 0.84rem;
            line-height: 1.9;
        }

        .hp-home .hp-mode-focus {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .hp-home .hp-mode-focus li {
            position: relative;
            padding-inline-start: 16px;
            color: #dbe2ec;
            font-size: 0.82rem;
            font-weight: 700;
            line-height: 1.8;
        }

        .hp-home .hp-mode-focus li::before {
            content: '';
            position: absolute;
            inset-inline-start: 0;
            top: 0.6em;
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: var(--hp-teal);
        }

        .hp-home .hp-trust {
            padding: 86px 0;
            border-top: 1px solid var(--hp-line-soft);
            border-bottom: 1px solid var(--hp-line-soft);
            background: linear-gradient(180deg, rgba(18, 24, 38, 0.34), rgba(18, 24, 38, 0));
        }

        .hp-home .hp-trust-layout {
            display: grid;
            gap: clamp(28px, 4vw, 48px);
        }

        .hp-home .hp-trust-intro {
            display: grid;
            gap: 18px;
        }

        .hp-home .hp-trust-copy {
            margin: 0;
            color: rgba(244, 246, 250, 0.74);
            font-size: 0.98rem;
            line-height: 2;
        }

        .hp-home .hp-trust-points {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .hp-home .hp-trust-point {
            display: grid;
            gap: 16px;
            padding: 20px;
            text-align: center;
        }

        .hp-home .hp-trust-point-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            color: var(--hp-teal);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hp-home .hp-trust-point-icon svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
        }

        .hp-home .hp-trust-point strong {
            display: block;
            margin-bottom: 12px;
            color: var(--hp-text);
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .hp-home .hp-trust-point p {
            margin: 0;
            color: var(--hp-muted);
            font-size: 0.84rem;
            line-height: 1.85;
        }

        .hp-home .hp-platform {
            padding: 100px 0 92px;
        }

        .hp-home .hp-platform-story {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
            gap: clamp(32px, 5vw, 68px);
            align-items: center;
        }

        .hp-home .hp-platform-copy {
            display: grid;
            gap: 18px;
        }

        .hp-home .hp-platform-desc {
            margin: 0;
            color: rgba(244, 246, 250, 0.74);
            font-size: 0.98rem;
            line-height: 2;
        }

        .hp-home .hp-platform-points {
            display: grid;
            gap: 0;
            border-top: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-platform-point {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 18px;
            padding: 22px 0;
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-platform-point-index {
            min-width: 34px;
            color: rgba(167, 176, 192, 0.56);
            font-size: 0.78rem;
            font-weight: 800;
        }

        .hp-home .hp-platform-point strong {
            display: block;
            margin-bottom: 8px;
            color: var(--hp-text);
            font-size: 0.98rem;
            font-weight: 800;
            line-height: 1.7;
        }

        .hp-home .hp-platform-point p {
            margin: 0;
            color: var(--hp-muted);
            font-size: 0.86rem;
            line-height: 1.92;
        }

        .hp-home .hp-platform-visual {
            position: relative;
            margin: 0;
            width: 100%;
            max-width: 560px;
            margin-right: auto;
            overflow: hidden;
            border-radius: 40px;
            background: #101722;
            box-shadow: var(--hp-shadow);
            align-self: start;
            /* prevent grid stretching */
            isolation: isolate;
        }

        .hp-home .hp-platform-visual::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(10, 15, 23, 0.9) 0%, transparent 100%);
            pointer-events: none;
        }

        .hp-home .hp-platform-visual img {
            width: 100%;
            height: auto;
            display: block;
            vertical-align: top;
        }

        .hp-home .hp-platform-labels {
            position: absolute;
            right: 28px;
            left: 28px;
            top: 28px;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hp-home .hp-platform-label {
            color: rgba(244, 246, 250, 0.76);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .hp-home .hp-platform-caption {
            position: absolute;
            right: 28px;
            bottom: 28px;
            z-index: 1;
            max-width: 300px;
            color: rgba(244, 246, 250, 0.78);
            font-size: 0.82rem;
            line-height: 1.85;
        }

        .hp-home .hp-testimonials {
            padding: 84px 0;
            border-top: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-testimonial-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 18px 34px;
            margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-testimonial-stat strong,
        .hp-home .hp-testimonial-stat span {
            display: block;
        }

        .hp-home .hp-testimonial-stat strong {
            margin-bottom: 4px;
            color: var(--hp-text);
            font-size: 1.35rem;
            font-weight: 800;
        }

        .hp-home .hp-testimonial-stat span {
            color: var(--hp-muted);
            font-size: 0.8rem;
            line-height: 1.7;
        }

        .hp-home .hp-testimonial-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 0.82fr);
            gap: 40px;
            align-items: stretch;
        }

        .hp-home .hp-testimonial-track {
            min-width: 0;
        }

        .hp-home .hp-testimonial-nav {
            display: none;
        }

        .hp-home .hp-testimonial-dots {
            display: none;
        }

        .hp-home .hp-featured-quote {
            position: relative;
            margin: 0;
            padding: 40px;
            border-radius: 32px;
            background: linear-gradient(180deg, rgba(18, 24, 38, 0.8), rgba(11, 16, 24, 0.94));
            border: 1px solid rgba(167, 176, 192, 0.08);
            box-shadow: var(--hp-shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hp-home .hp-featured-quote::after,
        .hp-home .hp-featured-quote::before {
            display: none !important;
            content: none !important;
            background: none !important;
        }

        .hp-home .hp-featured-quote-mark {
            display: block;
            margin-bottom: 20px;
            color: var(--hp-teal);
            opacity: 0.2;
            font-size: 5rem;
            line-height: 0.3;
            font-weight: 900;
        }

        .hp-home .hp-review-stars {
            display: flex;
            gap: 5px;
            margin-bottom: 14px;
        }

        .hp-home .hp-review-stars .hp-star {
            color: #ffb800;
            font-size: 0.9rem;
            line-height: 1;
        }

        .hp-home .hp-featured-quote-text {
            margin: 0;
            color: var(--hp-text);
            font-size: 1.15rem;
            line-height: 1.85;
            font-weight: 500;
            unicode-bidi: plaintext;
            overflow-wrap: anywhere;
        }

        .hp-home .hp-review-author {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(167, 176, 192, 0.1);
        }

        .hp-home .hp-review-author-copy {
            min-width: 0;
            flex: 1 1 auto;
        }

        .hp-home .hp-review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(0, 230, 167, 0.15), rgba(26, 43, 255, 0.15));
            color: var(--hp-teal);
            font-size: 1rem;
            font-weight: 800;
            flex: 0 0 auto;
            border: 1px solid rgba(0, 230, 167, 0.2);
        }

        .hp-home .hp-review-author strong,
        .hp-home .hp-review-author span {
            display: block;
        }

        .hp-home .hp-review-author strong {
            color: var(--hp-text);
            font-size: 0.92rem;
            font-weight: 800;
            unicode-bidi: plaintext;
            overflow-wrap: anywhere;
        }

        .hp-home .hp-review-author span {
            margin-top: 4px;
            color: var(--hp-muted);
            font-size: 0.76rem;
            overflow-wrap: anywhere;
        }

        .hp-home .hp-review-rail {
            display: grid;
            gap: 16px;
            align-content: start;
        }

        .hp-home .hp-review-mini {
            position: relative;
            padding: 18px 20px;
            border: 1px solid rgba(167, 176, 192, 0.08);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .hp-home .hp-review-mini:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(0, 230, 167, 0.12);
            transform: translateX(-6px);
        }

        .hp-home .hp-review-mini-text {
            margin: 0;
            color: rgba(244, 246, 250, 0.86);
            font-size: 0.92rem;
            line-height: 1.85;
            unicode-bidi: plaintext;
            overflow-wrap: anywhere;
        }

        .hp-home .hp-review-form-shell {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-review-form-title {
            margin: 0 0 8px;
            color: var(--hp-text);
            font-size: 1.08rem;
            font-weight: 800;
        }

        .hp-home .hp-review-form-subtitle {
            margin: 0 0 18px;
            color: var(--hp-muted);
            font-size: 0.86rem;
            line-height: 1.9;
        }

        .hp-home .hp-user-review-label {
            display: block;
            margin-bottom: 10px;
            color: var(--hp-text);
            font-size: 0.88rem;
            font-weight: 800;
        }

        .hp-home .hp-star-rating {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }

        .hp-home .hp-star-rating label {
            position: relative;
            cursor: pointer;
        }

        .hp-home .hp-star-rating input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .hp-home .hp-star-rating-symbol {
            color: rgba(167, 176, 192, 0.42);
            font-size: 1.4rem;
            line-height: 1;
            transition: transform 0.18s ease, color 0.18s ease;
        }

        .hp-home .hp-star-rating label:hover .hp-star-rating-symbol {
            transform: translateY(-1px);
        }

        .hp-home .hp-user-review-field {
            width: 100%;
            min-height: 124px;
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid rgba(167, 176, 192, 0.14);
            background: rgba(255, 255, 255, 0.03);
            color: var(--hp-text);
            line-height: 1.9;
            resize: vertical;
        }

        .hp-home .hp-user-review-field::placeholder {
            color: var(--hp-muted);
        }

        .hp-home .hp-user-review-field:focus {
            outline: none;
            border-color: rgba(0, 230, 167, 0.24);
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.06);
        }

        .hp-home .hp-user-review-status {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
            color: var(--hp-text);
            font-size: 0.86rem;
            font-weight: 800;
        }

        .hp-home .hp-user-review-status .niro-icon {
            width: 18px;
            height: 18px;
        }

        .hp-home .hp-final-cta {
            padding: 94px 0 28px;
        }

        .hp-home .hp-final-cta-scene {
            position: relative;
            min-height: 460px;
            overflow: hidden;
            border-radius: 40px;
            background: #0f1724;
        }

        .hp-home .hp-final-cta-scene::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('{{ $homeMedia['ctaScene'] }}');
            background-size: cover;
            background-position: center;
            transform: scale(1.03);
        }

        .hp-home .hp-final-cta-scene::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(115deg, rgba(8, 12, 18, 0.38), rgba(8, 12, 18, 0.84)),
                linear-gradient(180deg, transparent 22%, rgba(8, 12, 18, 0.9) 100%);
        }

        .hp-home .hp-final-cta-copy {
            position: absolute;
            right: 36px;
            left: 36px;
            bottom: 36px;
            z-index: 1;
            max-width: 620px;
            display: grid;
            gap: 18px;
        }

        .hp-home .hp-final-cta-title {
            margin: 0;
            font-size: clamp(2.1rem, 4vw, 3.6rem);
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -0.055em;
        }

        .hp-home .hp-final-cta-desc {
            margin: 0;
            color: rgba(244, 246, 250, 0.8);
            font-size: 0.98rem;
            line-height: 2;
        }

        .hp-home .hp-final-cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hp-home .hp-risk-strip .container {
            padding-top: 18px;
            border-top: 1px solid var(--hp-line-soft);
        }

        .hp-home .hp-risk-text {
            margin: 0;
            color: var(--hp-muted);
            font-size: 0.78rem;
            line-height: 1.95;
            text-align: center;
        }

        @media (min-width: 992px) {
            .hp-home {
                background:
                    linear-gradient(180deg, #0d1117 0%, #0b1017 52%, #091019 100%);
            }

            .hp-home .hp-editorial-hero {
                padding: calc(var(--lira-public-header-height, 92px) + 42px) 0 50px;
            }

            .hp-home .hp-hero-grid {
                grid-template-columns: minmax(0, 820px);
                grid-template-areas: "copy";
                justify-content: center;
            }

            .hp-home .hp-hero-copy {
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-hero-title {
                max-width: 860px;
                font-size: clamp(3rem, 4.4vw, 4.7rem);
                line-height: 1.2;
                letter-spacing: -0.018em;
            }

            .hp-home .hp-hero-sub {
                max-width: 680px;
            }

            .hp-home .hp-hero-actions {
                justify-content: center;
            }

            .hp-home .hp-hero-metrics {
                width: min(100%, 720px);
            }

            .hp-home .hp-modes,
            .hp-home .hp-trust,
            .hp-home .hp-platform,
            .hp-home .hp-testimonials {
                padding: 62px 0;
            }

            .hp-home .hp-section-head {
                max-width: 720px;
                margin-bottom: 26px;
            }

            .hp-home .hp-section-title {
                font-size: 2rem;
                letter-spacing: -0.025em;
            }

            .hp-home .hp-section-title--md {
                font-size: 1.75rem;
            }

            .hp-home .hp-section-desc {
                font-size: 0.86rem;
                line-height: 1.8;
            }

            .hp-home .hp-modes {
                background: #05080E;
                border-bottom: 1px solid var(--hp-line-soft);
                padding: 76px 0;
            }

            .hp-home .hp-modes .container {
                max-width: 1000px;
            }

            .hp-home .hp-modes .hp-section-head {
                max-width: 760px;
                margin-inline: auto;
                margin-bottom: 32px;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-modes .hp-kicker {
                justify-content: center;
            }

            .hp-home .hp-mode-shell {
                gap: 22px;
            }

            .hp-home .hp-mode-carousel {
                width: min(100%, 820px);
                margin-inline: auto;
                padding-inline: 0;
            }

            .hp-home .hp-mode-panels {
                position: relative;
                overflow: hidden;
                border-radius: 22px;
            }

            .hp-home .hp-mode-tabs {
                gap: 14px;
                flex-wrap: nowrap;
                justify-content: center;
                overflow-x: auto;
                scrollbar-width: none;
                width: min(100%, 720px);
                margin-inline: auto;
                padding-bottom: 14px;
                border-bottom: 1px solid var(--hp-line-soft);
                background: transparent;
            }

            .hp-home .hp-mode-tabs::-webkit-scrollbar {
                display: none;
            }

            .hp-home .hp-mode-trigger {
                flex: 0 0 auto;
                min-height: 0;
                padding: 0 0 12px;
                border-radius: 0;
                font-size: 0.88rem;
                color: var(--hp-muted);
            }

            .hp-home .hp-mode-trigger::after {
                display: block;
            }

            .hp-home .hp-mode-trigger.is-active {
                background: transparent;
                color: var(--hp-text);
            }

            .hp-home .hp-mode-panel {
                grid-template-columns: minmax(0, 1fr);
                grid-template-areas:
                    "copy"
                    "visual";
                gap: 24px;
                min-height: 0;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                opacity: 0;
                transform: translateX(18px);
                transition: opacity 0.28s ease, transform 0.28s ease;
            }

            .hp-home .hp-mode-panel.is-active {
                opacity: 1;
                transform: translateX(0);
            }

            .hp-home .hp-mode-visual {
                max-width: none;
                width: min(100%, 620px);
                height: auto;
                min-height: 0;
                aspect-ratio: auto;
                border-radius: 18px;
                box-shadow: none;
                justify-self: center;
            }

            .hp-home .hp-mode-visual img {
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 9;
                object-fit: cover;
                border: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-platform-visual {
                max-width: none;
                border-radius: 24px;
                box-shadow: none;
            }

            .hp-home .hp-mode-visual figcaption,
            .hp-home .hp-mode-visual .hp-mode-visual-note {
                right: 18px;
                left: 18px;
                bottom: 16px;
                padding: 0;
                font-size: 0.78rem;
                line-height: 1.65;
            }

            .hp-home .hp-mode-copy {
                gap: 14px;
                align-content: center;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-mode-title {
                font-size: 1.9rem;
                line-height: 1.28;
                margin-bottom: 0 !important;
            }

            .hp-home .hp-mode-summary {
                max-width: 560px;
                color: var(--hp-text);
                font-size: 0.94rem;
                font-weight: 800;
                line-height: 1.8;
            }

            .hp-home .hp-mode-desc {
                max-width: 620px;
                color: rgba(244, 246, 250, 0.72);
                font-size: 0.84rem;
                line-height: 1.9;
            }

            .hp-home .hp-mode-focus {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px 22px;
                width: 100%;
                padding-top: 4px;
            }

            .hp-home .hp-mode-focus li {
                min-height: 0;
                display: block;
                padding: 0;
                padding-inline-start: 16px;
                border-radius: 0;
                background: transparent;
                color: #dbe2ec;
                font-size: 0.82rem;
                line-height: 1.8;
                text-align: start;
            }

            .hp-home .hp-mode-focus li::before {
                display: block;
            }

            .hp-home .hp-mode-details {
                width: min(100%, 620px);
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                margin-inline: auto;
                padding-top: 16px;
                border-top: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-mode-detail {
                padding: 0;
                border-radius: 0;
                background: transparent;
                text-align: center;
            }

            .hp-home .hp-mode-detail strong {
                margin-bottom: 7px;
                color: var(--hp-teal);
                font-size: 0.8rem;
            }

            .hp-home .hp-mode-detail p {
                color: var(--hp-muted);
                font-size: 0.78rem;
                line-height: 1.75;
            }

            .hp-home .hp-trust {
                background: #0d1117;
                border-top: 0;
            }

            .hp-home .hp-trust-layout {
                grid-template-columns: minmax(0, 0.74fr) minmax(0, 1.26fr);
                align-items: start;
                gap: 30px;
            }

            .hp-home .hp-trust-intro {
                position: sticky;
                top: 100px;
                gap: 12px;
                padding: 22px;
                border: 1px solid var(--hp-line-soft);
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.018);
            }

            .hp-home .hp-trust-points {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .hp-home .hp-trust-point {
                grid-template-columns: 46px 1fr;
                align-items: center;
                gap: 16px;
                padding: 16px 18px;
                border: 1px solid var(--hp-line-soft);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.02);
                text-align: start;
            }

            .hp-home .hp-trust-point-icon {
                width: 42px;
                height: 42px;
                margin: 0;
            }

            .hp-home .hp-trust-point strong {
                margin-bottom: 4px;
                font-size: 0.95rem;
            }

            .hp-home .hp-trust-point p {
                font-size: 0.78rem;
                line-height: 1.7;
            }

            .hp-home .hp-platform {
                background: #05080E;
                border-bottom: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-platform-story {
                grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
                gap: 30px;
                align-items: center;
            }

            .hp-home .hp-platform-copy {
                gap: 12px;
            }

            .hp-home .hp-platform-points {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                border-top: 0;
                margin-top: 12px !important;
            }

            .hp-home .hp-platform-point {
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 12px;
                padding: 16px;
                border: 1px solid var(--hp-line-soft);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.02);
            }

            .hp-home .hp-platform-point-index {
                width: 34px;
                height: 34px;
                min-width: 34px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                background: rgba(0, 230, 167, 0.08);
                color: var(--hp-teal);
            }

            .hp-home .hp-platform-point strong {
                margin-bottom: 4px;
                font-size: 0.86rem;
                line-height: 1.55;
            }

            .hp-home .hp-platform-point p {
                font-size: 0.76rem;
                line-height: 1.65;
            }

            .hp-home .hp-platform-labels {
                right: 18px;
                left: 18px;
                top: 18px;
            }

            .hp-home .hp-platform-label {
                padding: 7px 10px;
                border-radius: 10px;
                background: rgba(8, 12, 18, 0.58);
                font-size: 0.68rem;
            }

            .hp-home .hp-testimonials {
                background: #0d1117;
            }

            .hp-home .hp-testimonial-stats {
                width: fit-content;
                max-width: 100%;
                gap: 0;
                padding: 0;
                margin: 0 auto 24px;
                border: 1px solid var(--hp-line-soft);
                border-radius: 16px;
                overflow: hidden;
            }

            .hp-home .hp-testimonial-stat {
                min-width: 130px;
                padding: 12px 18px;
                background: rgba(255, 255, 255, 0.018);
            }

            .hp-home .hp-testimonial-stat:not(:last-child) {
                border-inline-end: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-testimonial-stat strong {
                font-size: 1.05rem;
            }

            .hp-home .hp-testimonial-stat span {
                font-size: 0.7rem;
            }

            .hp-home .hp-testimonial-layout {
                position: relative;
                display: block;
                width: min(100%, 760px);
                margin-inline: auto;
                padding-inline: 56px;
            }

            .hp-home .hp-testimonial-track {
                position: relative;
                overflow: hidden;
                border-radius: 20px;
            }

            .hp-home .hp-testimonial-slide {
                display: none;
                min-height: 240px;
                opacity: 0;
                transform: translateX(18px);
                transition: opacity 0.24s ease, transform 0.24s ease;
            }

            .hp-home .hp-testimonial-slide.is-active {
                display: flex;
                flex-direction: column;
                opacity: 1;
                transform: translateX(0);
            }

            .hp-home .hp-testimonial-nav {
                position: absolute;
                top: 50%;
                z-index: 3;
                width: 40px;
                height: 40px;
                border: 1px solid var(--hp-line);
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.035);
                color: var(--hp-text);
                transform: translateY(-50%);
                transition: background-color 0.2s ease, border-color 0.2s ease;
            }

            .hp-home .hp-testimonial-nav:hover {
                background: rgba(0, 230, 167, 0.12);
                border-color: rgba(0, 230, 167, 0.24);
            }

            .hp-home .hp-testimonial-nav--prev {
                right: 0;
            }

            .hp-home .hp-testimonial-nav--next {
                left: 0;
            }

            .hp-home .hp-testimonial-nav i {
                font-size: 13px;
                color: currentColor !important;
            }

            .hp-home .hp-testimonial-dots {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                margin-top: 14px;
            }

            .hp-home .hp-testimonial-dot {
                width: 7px;
                height: 7px;
                padding: 0;
                border: 0;
                border-radius: 999px;
                background: rgba(167, 176, 192, 0.34);
                transition: width 0.2s ease, background-color 0.2s ease;
            }

            .hp-home .hp-testimonial-dot.is-active {
                width: 20px;
                background: var(--hp-teal);
            }

            .hp-home .hp-featured-quote,
            .hp-home .hp-review-mini,
            .hp-home .hp-review-form-shell {
                border-radius: 20px;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.02);
            }

            .hp-home .hp-featured-quote {
                padding: 30px;
                min-height: 100%;
            }

            .hp-home .hp-featured-quote-mark {
                margin-bottom: 12px;
                font-size: 3.4rem;
            }

            .hp-home .hp-featured-quote-text {
                font-size: 0.96rem;
                line-height: 1.8;
            }

            .hp-home .hp-review-rail {
                gap: 12px;
            }

            .hp-home .hp-review-mini {
                padding: 18px 22px;
                flex-direction: column;
                justify-content: center;
            }

            .hp-home .hp-review-mini:hover {
                transform: none;
            }

            .hp-home .hp-review-mini-text {
                font-size: 0.82rem;
                line-height: 1.75;
            }

            .hp-home .hp-review-author {
                margin-top: 14px;
                padding-top: 12px;
            }

            .hp-home .hp-final-cta {
                padding: 62px 0 22px;
            }

            .hp-home .hp-final-cta-scene {
                min-height: 360px;
                border-radius: 26px;
            }

            .hp-home .hp-final-cta-copy {
                top: 50%;
                right: auto;
                left: 50%;
                bottom: auto;
                width: min(620px, calc(100% - 60px));
                max-width: 620px;
                transform: translate(-50%, -50%);
                gap: 12px;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-final-cta-title {
                font-size: 2rem;
                line-height: 1.28;
            }

            .hp-home .hp-final-cta-desc {
                font-size: 0.86rem;
                line-height: 1.8;
            }
        }


        @media (max-width: 991.98px) {
            .hp-home .hp-hero-grid,
            .hp-home .hp-mode-panel,
            .hp-home .hp-trust-layout,
            .hp-home .hp-platform-story,
            .hp-home .hp-testimonial-layout {
                grid-template-columns: 1fr;
            }

            .hp-home .hp-hero-grid {
                grid-template-areas: "copy";
            }

            .hp-home .hp-hero-visual {
                display: none;
            }

            /* Hero background image on mobile */
            .hp-home .hp-editorial-hero {
                position: relative;
            }

            .hp-home .hp-editorial-hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url('{{ $homeMedia['heroVisual'] }}');
                background-size: cover;
                background-position: center top;
                opacity: 0.32;
                pointer-events: none;
            }

            .hp-home .hp-editorial-hero::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(13, 17, 23, 0.1) 0%, rgba(13, 17, 23, 0.88) 80%);
                pointer-events: none;
            }

            .hp-home .hp-editorial-hero>.container {
                position: relative;
                z-index: 1;
            }

            .hp-home .hp-mode-panel {
                grid-template-areas:
                    "copy"
                    "visual";
            }
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-editorial-hero {
                padding: calc(var(--lira-public-header-height, 92px) + 28px) 0 46px;
            }

            .hp-home .hp-hero-sub,
            .hp-home .hp-section-desc,
            .hp-home .hp-trust-copy,
            .hp-home .hp-platform-desc,
            .hp-home .hp-final-cta-desc {
                max-width: 100%;
            }

            .hp-home .hp-hero-visual,
            .hp-home .hp-platform-visual {
                min-height: 0;
            }
        }

        @media (max-width: 767.98px) {
            .hp-home .container {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            /* ── Center everything on mobile ── */
            .hp-home .hp-section-head,
            .hp-home .hp-hero-copy,
            .hp-home .hp-trust-intro,
            .hp-home .hp-mode-copy,
            .hp-home .hp-final-cta-copy {
                text-align: center;
            }

            .hp-home .hp-section-desc,
            .hp-home .hp-hero-sub,
            .hp-home .hp-trust-copy,
            .hp-home .hp-platform-desc {
                max-width: 100%;
            }

            .hp-home .hp-kicker {
                justify-content: center;
            }

            /* ── Hero section ── */
            .hp-home .hp-editorial-hero {
                padding: calc(var(--lira-public-header-height, 72px) + 64px) 0 80px;
                min-height: 65vh;
                display: flex;
                align-items: center;
            }

            .hp-home .hp-hero-copy {
                gap: 16px;
            }

            .hp-home .hp-section-head {
                gap: 10px;
                margin-bottom: 20px;
            }

            .hp-home .hp-section-title {
                font-size: 1.5rem;
                line-height: 1.3;
            }

            .hp-home .hp-section-title--md {
                font-size: 1.4rem;
                line-height: 1.35;
            }

            .hp-home .hp-hero-title {
                font-size: 1.7rem;
                line-height: 1.25;
                letter-spacing: -0.03em;
            }

            .hp-home .hp-final-cta-title {
                font-size: 1.4rem;
                line-height: 1.35;
            }

            .hp-home .hp-section-desc,
            .hp-home .hp-hero-sub,
            .hp-home .hp-trust-copy,
            .hp-home .hp-platform-desc,
            .hp-home .hp-featured-quote-text,
            .hp-home .hp-review-mini-text,
            .hp-home .hp-final-cta-desc,
            .hp-home .hp-mode-summary,
            .hp-home .hp-mode-desc {
                font-size: 0.82rem;
                line-height: 1.85;
            }

            /* Show hero visual as small centered image on mobile */
            .hp-home .hp-hero-caption {
                display: none;
            }

            /* ── CTA buttons: full-width stacked ── */
            .hp-home .hp-hero-actions,
            .hp-home .hp-final-cta-actions {
                display: grid;
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .hp-home .hp-hero-actions>*,
            .hp-home .hp-final-cta-actions>* {
                min-width: 0;
            }

            .hp-home .hp-btn-primary,
            .hp-home .hp-btn-secondary {
                width: 100%;
                min-height: 50px;
                font-size: 0.88rem;
                border-radius: 14px;
            }

            /* ── Metrics: 3 even columns, centered ── */
            .hp-home .hp-hero-metrics {
                grid-template-columns: repeat(3, 1fr);
                gap: 0;
                padding-top: 16px;
                border-top: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-hero-metric-icon {
                width: 36px;
                height: 36px;
                margin-bottom: 6px;
            }

            .hp-home .hp-hero-metric,
            .hp-home .hp-hero-metric:first-child {
                padding: 12px 8px;
                border: 0;
                text-align: center;
            }

            .hp-home .hp-hero-metric:nth-child(2) {
                border-inline-start: 1px solid var(--hp-line-soft);
                border-inline-end: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-hero-metric:last-child {
                grid-column: auto;
                padding-top: 12px;
                border-top: 0;
            }

            .hp-home .hp-hero-metric strong {
                margin-bottom: 4px;
                font-size: 1.2rem;
            }

            .hp-home .hp-hero-metric span {
                font-size: 0.75rem;
                line-height: 1.5;
            }

            .hp-home .hp-hero-metric small {
                display: none;
            }

            /* ── Image containers ── */
            .hp-home .hp-hero-visual,
            .hp-home .hp-mode-visual,
            .hp-home .hp-platform-visual,
            .hp-home .hp-final-cta-scene {
                border-radius: 20px;
            }

            .hp-home .hp-final-cta-scene {
                min-height: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 44px 0;
            }

            .hp-home .hp-hero-caption,
            .hp-home .hp-mode-visual-note,
            .hp-home .hp-platform-labels,
            .hp-home .hp-platform-caption {
                right: 16px;
                left: 16px;
            }

            .hp-home .hp-final-cta-copy {
                position: relative;
                bottom: auto;
                left: auto;
                right: auto;
                padding: 0 20px;
            }

            .hp-home .hp-market-track {
                padding: 10px 0;
            }

            /* ── Section spacing ── */
            .hp-home .hp-modes,
            .hp-home .hp-trust,
            .hp-home .hp-platform,
            .hp-home .hp-testimonials,
            .hp-home .hp-final-cta {
                padding-top: 44px;
                padding-bottom: 36px;
            }

            .hp-home .hp-features-highlight {
                padding: 24px 0;
            }

            /* ── Features strip: 2 columns as requested ── */
            .hp-home .hp-features-strip {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px 8px;
            }

            .hp-home .hp-feature-item {
                padding: 12px 16px;
                border: none !important;
            }

            .hp-home .hp-feature-title {
                font-size: 0.88rem;
                margin-bottom: 6px;
            }

            .hp-home .hp-feature-desc {
                font-size: 0.72rem;
                line-height: 1.55;
            }

            /* ── Mode tabs ── */
            .hp-home .hp-mode-tabs {
                gap: 14px;
                flex-wrap: nowrap;
                overflow-x: auto;
                scrollbar-width: none;
                justify-content: center;
            }

            .hp-home .hp-mode-tabs::-webkit-scrollbar {
                display: none;
            }

            .hp-home .hp-mode-trigger {
                flex: 0 0 auto;
                font-size: 0.82rem;
            }

            .hp-home .hp-mode-details {
                display: none !important;
            }

            .hp-home .hp-mode-focus {
                justify-content: center;
            }

            /* ── Trust cards: 3 columns as requested ── */
            .hp-home .hp-trust-points {
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 8px !important;
            }

            .hp-home .hp-trust-point {
                padding: 12px 8px !important;
                border-radius: 14px !important;
                gap: 8px;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hp-home .hp-trust-point-icon {
                width: 48px;
                height: 48px;
                border-radius: 0;
                margin: 0 auto;
            }

            .hp-home .hp-trust-point-icon svg {
                width: 100%;
                height: 100%;
            }

            .hp-home .hp-trust-point strong {
                font-size: 0.88rem;
                line-height: 1.3;
                margin-bottom: 6px;
            }

            .hp-home .hp-trust-point p {
                font-size: 0.72rem;
                line-height: 1.5;
            }

            /* ── Platform ── */
            .hp-home .hp-platform-story {
                gap: 20px;
            }

            .hp-home .hp-platform-copy {
                text-align: center;
            }

            .hp-home .hp-platform-points {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 32px 16px !important;
                border: none !important;
                padding-top: 20px;
            }

            .hp-home .hp-platform-point {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                padding: 0 !important;
                border: none !important;
                gap: 8px !important;
            }

            .hp-home .hp-platform-point-index {
                min-width: 0 !important;
                margin-bottom: 4px;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(0, 230, 167, 0.08);
                width: 40px;
                height: 40px;
                border-radius: 50%;
                color: var(--hp-teal);
            }

            .hp-home .hp-platform-point strong {
                font-size: 0.88rem;
                line-height: 1.3;
                margin-bottom: 6px;
            }

            .hp-home .hp-platform-point p {
                font-size: 0.72rem;
                line-height: 1.5;
            }

            /* ── Testimonials ── */
            .hp-home .hp-testimonial-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0;
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 16px;
            }

            .hp-home .hp-testimonial-stat {
                padding: 8px 4px;
            }

            .hp-home .hp-testimonial-stat:not(:last-child) {
                border-inline-end: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-testimonial-stat strong {
                font-size: 1.1rem;
            }

            .hp-home .hp-testimonial-stat span {
                font-size: 0.7rem;
            }

            .hp-home .hp-testimonial-layout {
                position: relative;
                display: block;
                gap: 24px;
                width: 100%;
                overflow: hidden;
                padding-inline: 0;
                /* Prevent horizontal scroll */
            }

            .hp-home .hp-testimonial-track {
                position: relative;
                display: flex;
                overflow: hidden;
                border-radius: 16px;
                direction: ltr;
            }

            .hp-home .hp-testimonial-slide {
                display: flex;
                flex-direction: column;
                flex: 0 0 100%;
                width: 100%;
                direction: rtl;
                min-height: 220px;
                opacity: 1;
                transform: translateX(calc(var(--testimonial-index, 0) * -100%));
                transition: transform 0.28s ease;
            }

            .hp-home .hp-testimonial-slide.is-active {
                display: flex;
                flex-direction: column;
                opacity: 1;
            }

            .hp-home .hp-testimonial-nav {
                display: none;
            }

            .hp-home .hp-testimonial-dots {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                margin-top: 12px;
            }

            .hp-home .hp-testimonial-dot {
                width: 7px;
                height: 7px;
                padding: 0;
                border: 0;
                border-radius: 999px;
                background: rgba(167, 176, 192, 0.34);
                transition: width 0.2s ease, background-color 0.2s ease;
            }

            .hp-home .hp-testimonial-dot.is-active {
                width: 20px;
                background: var(--hp-teal);
            }

            .hp-home .hp-featured-quote {
                padding: 22px 18px;
                border-radius: 22px;
                justify-content: flex-start;
                min-height: auto;
                background: linear-gradient(180deg, rgba(18, 24, 38, 0.9), rgba(11, 16, 24, 0.98));
            }

            .hp-home .hp-featured-quote-mark {
                font-size: 2.5rem;
                margin-bottom: 4px;
                opacity: 0.12;
            }

            .hp-home .hp-review-stars {
                margin-bottom: 10px;
                gap: 3px;
                justify-content: center;
            }

            .hp-home .hp-review-stars .hp-star {
                font-size: 0.72rem;
            }

            .hp-home .hp-featured-quote-text {
                font-size: 0.95rem;
                line-height: 1.75;
                font-weight: 500;
            }

            .hp-home .hp-review-rail {
                display: flex;
                flex-wrap: nowrap;
                align-items: stretch;
                gap: 10px;
                overflow-x: auto;
                padding: 0 16px 12px;
                margin: 0 -16px 0;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-padding-inline: 16px;
            }

            .hp-home .hp-review-mini {
                flex: none;
                display: flex;
                flex-direction: column;
                justify-content: center;
                width: 100%;
                max-width: 100%;
                min-height: 220px;
                padding: 20px 16px;
                border-radius: 16px;
                scroll-snap-align: start;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(167, 176, 192, 0.06);
            }

            .hp-home .hp-review-mini-text {
                font-size: 0.84rem;
                line-height: 1.7;
                text-align: center;
            }

            .hp-home .hp-review-avatar {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                font-size: 0.8rem;
            }

            .hp-home .hp-review-author {
                flex-direction: row;
                align-items: center;
                width: fit-content;
                max-width: 100%;
                margin: 16px auto 0;
                padding: 12px 12px 0;
                gap: 10px;
                justify-content: center;
                text-align: start;
            }

            .hp-home .hp-review-author-copy {
                flex: none;
                min-width: 0;
                width: auto;
                text-align: start;
            }

            .hp-home .hp-review-author strong {
                font-size: 0.84rem;
                line-height: 1.35;
                unicode-bidi: normal;
                word-break: normal;
                white-space: nowrap;
            }

            .hp-home .hp-review-author span {
                margin-top: 2px;
                font-size: 0.7rem;
                line-height: 1.3;
                direction: ltr;
                unicode-bidi: isolate;
                word-break: normal;
                white-space: nowrap;
            }

            .hp-home .hp-final-cta-scene {
                min-height: 320px;
            }

            .hp-home .hp-final-cta-copy {
                bottom: 16px;
            }
        }

        @media (max-width: 575.98px) {

            .hp-home .hp-hero-actions,
            .hp-home .hp-final-cta-actions {
                grid-template-columns: 1fr;
            }

            .hp-home .hp-market-track {
                padding: 11px 0;
            }

            .hp-home .hp-featured-quote-text,
            .hp-home .hp-review-mini-text {
                font-size: 0.83rem;
                line-height: 1.86;
            }

            .hp-home .hp-review-mini {
                flex-basis: auto;
                min-height: 230px;
                padding: 20px 14px;
            }

            .hp-home .hp-review-author {
                margin-top: 14px;
                padding-top: 12px;
                justify-content: center;
                flex-direction: row;
                align-items: center;
                text-align: start;
            }

            .hp-home .hp-testimonial-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 0;
            }

            .hp-home .hp-testimonial-stat:not(:last-child) {
                border-inline-end: 1px solid var(--hp-line-soft);
                border-bottom: 0;
                padding-bottom: 0;
            }

            .hp-home .hp-testimonial-stat strong {
                font-size: 0.95rem;
            }

            .hp-home .hp-testimonial-stat span {
                font-size: 0.62rem;
            }

            .hp-home .hp-platform-visual img {
                width: 100%;
                height: auto;
                object-fit: contain;
            }
        }

        /* Planned homepage refresh: hero metrics, modes, trust, and desktop auth rail */
        .hp-home {
            --hp-auth-sidebar-width: 300px;
        }

        .hp-home .hp-tone-teal {
            color: var(--hp-teal) !important;
        }

        .hp-home .hp-auth-sidebar {
            display: none;
        }

        @media (min-width: 1200px) {
            .hp-home .hp-auth-sidebar {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                z-index: 1300;
                width: var(--hp-auth-sidebar-width);
                display: flex;
                flex-direction: column;
                background: #0d1117;
                border-left: 1px solid rgba(0, 230, 167, 0.12);
                color: #fff;
                box-shadow: none !important;
                font-family: 'Alexandria', 'Cairo', sans-serif !important;
            }
        }

        .hp-home .hp-auth-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            flex: 0 0 65px;
            height: 65px;
            border-bottom: 1px solid rgba(0, 230, 167, 0.12);
            box-shadow: none !important;
        }

        .hp-home .hp-auth-tab {
            border: 0;
            background: rgba(255, 255, 255, 0.02);
            color: rgba(244, 246, 250, 0.62);
            font-size: 0.84rem;
            font-weight: 700;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .hp-home .hp-auth-tab.is-active {
            background: rgba(0, 230, 167, 0.1);
            color: var(--hp-teal);
        }

        .hp-home .hp-auth-sidebar-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding: 26px 24px 18px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.22) transparent;
        }

        .hp-home .hp-auth-panel {
            display: grid;
            gap: 13px;
        }

        .hp-home .hp-auth-panel[hidden] {
            display: none !important;
        }

        .hp-home .hp-auth-panel label {
            display: grid;
            gap: 6px;
            margin: 0;
        }

        .hp-home .hp-auth-panel label span {
            color: rgba(244, 246, 250, 0.66);
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .hp-home .hp-auth-panel input:not([type="checkbox"]) {
            width: 100%;
            min-height: 40px;
            padding: 0 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.035);
            color: #fff;
            outline: 0;
            font-size: 0.83rem;
            transition: border-color 0.18s ease, background 0.18s ease;
        }

        .hp-home .hp-auth-panel input:not([type="checkbox"]):focus {
            border-color: rgba(0, 230, 167, 0.52);
            background: rgba(0, 230, 167, 0.055);
        }

        .hp-home .hp-auth-panel input::placeholder {
            color: rgba(219, 232, 249, 0.45);
        }

        .hp-home .hp-auth-field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .hp-home .hp-auth-field-grid--phone {
            grid-template-columns: 0.62fr 1.38fr;
        }

        .hp-home .hp-auth-check {
            display: grid !important;
            grid-template-columns: 18px 1fr;
            align-items: start;
            gap: 10px !important;
            padding-top: 4px;
        }

        .hp-home .hp-auth-check input {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            accent-color: var(--hp-teal);
        }

        .hp-home .hp-auth-check a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .hp-home .hp-auth-submit {
            min-height: 52px;
            margin-top: 8px;
            border: 0;
            border-radius: 8px;
            background: var(--hp-teal);
            color: #071018;
            font-size: 0.92rem;
            font-weight: 900;
            letter-spacing: 0;
        }

        .hp-home .hp-auth-muted-link {
            color: rgba(219, 232, 249, 0.76);
            font-size: 0.78rem;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .hp-home .hp-auth-socials {
            flex: 0 0 auto;
            padding: 18px 24px 20px;
            border-top: 1px solid rgba(0, 230, 167, 0.1);
            color: rgba(244, 246, 250, 0.72);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .hp-home .hp-auth-socials div {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .hp-home .hp-auth-socials a {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: rgba(244, 246, 250, 0.78);
            text-decoration: none;
        }

        .hp-home .hp-account-sidebar {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            padding: 26px 24px 20px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.22) transparent;
        }

        .hp-home .hp-account-profile {
            display: grid;
            justify-items: center;
            gap: 9px;
            text-align: center;
        }

        .hp-home .hp-account-avatar {
            width: 84px;
            height: 84px;
            padding: 4px;
            border-radius: 50%;
            background: #05080E;
            border: 3px solid var(--hp-teal);
            box-shadow: 0 0 0 3px rgba(0, 230, 167, 0.12);
            overflow: hidden;
        }

        .hp-home .hp-account-avatar img {
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.08);
        }

        .hp-home .hp-account-name {
            margin: 0;
            color: #fff;
            font-size: 1.12rem;
            font-weight: 900;
            line-height: 1.35;
        }

        .hp-home .hp-account-meta {
            display: grid;
            gap: 2px;
            color: rgba(219, 232, 249, 0.68);
            font-size: 0.76rem;
            font-weight: 700;
            direction: ltr;
        }

        .hp-home .hp-account-balance {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 54px;
            margin-top: 22px;
            padding: 0 18px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.075);
            color: #fff;
            font-size: 1.05rem;
            font-weight: 900;
            direction: ltr;
        }

        .hp-home .hp-account-balance .niro-icon {
            width: 20px;
            height: 20px;
            color: rgba(219, 232, 249, 0.62);
        }

        .hp-home .hp-account-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 24px;
        }

        .hp-home .hp-account-action {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            border-radius: 16px;
            color: #f8fafc !important;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(0, 230, 167, 0.16);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: background 0.18s ease, border-color 0.18s ease, color 0.18s ease;
            white-space: nowrap;
            box-shadow: none;
        }

        .hp-home .hp-account-action:hover {
            color: var(--hp-teal) !important;
            background: rgba(0, 230, 167, 0.08);
            border-color: rgba(0, 230, 167, 0.22);
        }

        .hp-home .hp-account-action--primary {
            min-height: 54px;
            padding: 0 26px;
            border-radius: 18px;
            color: #0d1117 !important;
            background: #12dcb0;
            border-color: rgba(18, 220, 176, 0.92);
            font-size: 0.95rem;
            font-weight: 800;
        }

        .hp-home .hp-account-action--primary:hover {
            color: #0d1117 !important;
            background: #22e6bc;
            border-color: rgba(34, 230, 188, 0.96);
        }

        .hp-home .hp-account-nav {
            display: grid;
            gap: 2px;
            margin: 28px 0 0;
            padding: 0;
            list-style: none;
        }

        .hp-home .hp-account-nav-link {
            min-height: 42px;
            display: grid;
            grid-template-columns: 26px 1fr;
            align-items: center;
            gap: 12px;
            color: rgba(219, 232, 249, 0.76);
            font-size: 0.92rem;
            font-weight: 800;
            text-decoration: none;
            transition: color 0.18s ease, transform 0.18s ease;
        }

        .hp-home .hp-account-nav-link:hover {
            color: #fff;
            transform: translateX(-2px);
        }

        .hp-home .hp-account-nav-link .niro-icon {
            width: 18px;
            height: 18px;
            color: rgba(219, 232, 249, 0.68);
            justify-self: center;
        }

        .hp-home .hp-account-logout {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .hp-home .hp-account-logout .hp-account-nav-link {
            color: rgba(244, 246, 250, 0.84);
        }

        .hp-home .hp-account-socials {
            margin-top: auto;
            padding-top: 28px;
        }

        .hp-home .hp-account-socials .hp-auth-socials {
            padding: 0;
            border-top: 0;
        }

        .hp-home .hp-hero-metric {
            appearance: none;
            width: 100%;
            border-top: 0;
            border-right: 0;
            border-bottom: 0;
            background: transparent;
            color: inherit;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .hp-home .hp-hero-metric:hover,
        .hp-home .hp-hero-metric.is-active {
            background: rgba(255, 255, 255, 0.035);
        }

        .hp-home .hp-hero-metric:nth-child(3) {
            border-inline-start: 0 !important;
            border-left: 0 !important;
            border-right: 0 !important;
        }

        .hp-home .hp-hero-metric:focus-visible {
            outline: 2px solid rgba(0, 230, 167, 0.8);
            outline-offset: 4px;
        }

        .hp-home .hp-hero-metric-panel {
            position: absolute;
            top: calc(100% + 14px);
            right: 0;
            left: 0;
            z-index: 40;
            padding-top: 0;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(14px) scale(0.985);
            transform-origin: top center;
            transition: opacity 0.26s ease, transform 0.26s ease, visibility 0s linear 0.26s;
        }

        .hp-home .hp-hero-metric-panel[hidden] {
            display: none !important;
        }

        .hp-home .hp-hero-metric-panel.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
            transition-delay: 0s;
        }

        .hp-home .hp-hero-metric-panel-inner {
            display: grid;
            gap: 16px;
            padding: 20px;
            border: 1px solid rgba(0, 230, 167, 0.18);
            border-radius: 12px;
            background: rgba(5, 8, 14, 0.96);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.42);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .hp-home .hp-hero-metric-panel-head {
            display: grid;
            gap: 6px;
            text-align: start;
        }

        .hp-home .hp-hero-metric-panel-head strong {
            color: #fff;
            font-size: 0.98rem;
            font-weight: 900;
        }

        .hp-home .hp-hero-metric-panel-head span,
        .hp-home .hp-hero-metric-panel-desc {
            margin: 0;
            color: rgba(244, 246, 250, 0.75);
            font-size: 0.82rem;
            line-height: 1.8;
        }

        .hp-home .hp-hero-metric-mode-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .hp-home .hp-hero-metric-mode-card {
            padding: 13px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.035);
            text-align: start;
        }

        .hp-home .hp-hero-metric-mode-card h3 {
            margin: 0 0 8px;
            color: var(--hp-teal);
            font-size: 0.84rem;
            font-weight: 900;
        }

        .hp-home .hp-hero-metric-mode-card p,
        .hp-home .hp-hero-metric-panel-list li {
            margin: 0;
            color: rgba(244, 246, 250, 0.75);
            font-size: 0.76rem;
            line-height: 1.8;
        }

        .hp-home .hp-hero-metric-panel-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 16px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .hp-home .hp-hero-metric-panel-list li {
            position: relative;
            padding-inline-start: 14px;
        }

        .hp-home .hp-hero-metric-panel-list li::before {
            content: '';
            position: absolute;
            inset-inline-start: 0;
            top: 0.72em;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--hp-teal);
        }

        .hp-home .hp-modes {
            padding: clamp(72px, 8vw, 112px) 0;
            overflow: hidden;
            background: #05080e;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .hp-home .hp-modes .container {
            max-width: 1220px;
        }

        .hp-home .hp-mode-shell {
            gap: 26px;
        }

        .hp-home .hp-modes .hp-section-head {
            max-width: 660px;
            margin: 0 auto;
            text-align: center;
            justify-items: center;
        }

        .hp-home .hp-mode-tabs {
            justify-content: center;
            gap: 0;
            width: min(100%, 820px);
            margin-inline: auto;
            padding-bottom: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hp-home .hp-mode-trigger {
            flex: 1 1 0;
            min-width: 180px;
            padding: 0 22px 14px;
            color: rgba(244, 246, 250, 0.68);
            font-size: 0.95rem;
            border-inline-start: 1px solid rgba(255, 255, 255, 0.09);
        }

        .hp-home .hp-mode-trigger:first-child {
            border-inline-start: 0;
        }

        .hp-home .hp-mode-panel {
            grid-template-columns: minmax(360px, 0.94fr) minmax(0, 1.06fr);
            grid-template-areas: "visual copy";
            gap: clamp(34px, 5vw, 64px);
            direction: ltr;
            align-items: center;
            min-height: 520px;
        }

        .hp-home .hp-mode-panel.is-active {
            display: grid;
        }

        .hp-home .hp-mode-visual,
        .hp-home .hp-mode-copy {
            direction: rtl;
        }

        .hp-home .hp-mode-visual {
            width: min(100%, 680px);
            max-width: 680px;
            aspect-ratio: 1.45;
            justify-self: center;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            background: #05080e;
            isolation: isolate;
        }

        .hp-home .hp-mode-visual::after {
            display: block;
            content: '';
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
            background:
                radial-gradient(circle at 32% 56%, rgba(0, 230, 167, 0.12), transparent 34%),
                linear-gradient(90deg, rgba(5, 8, 14, 0.96) 0%, rgba(5, 8, 14, 0.12) 44%, rgba(5, 8, 14, 0.72) 100%),
                linear-gradient(180deg, rgba(5, 8, 14, 0.18), rgba(5, 8, 14, 0.64));
        }

        .hp-home .hp-mode-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 30% center;
            border-radius: inherit;
            transform: scale(1.12);
            transform-origin: center;
            filter: drop-shadow(0 28px 54px rgba(0, 230, 167, 0.12)) saturate(1.04);
            -webkit-mask-image: radial-gradient(ellipse at center, #000 58%, rgba(0, 0, 0, 0.92) 74%, transparent 100%);
            mask-image: radial-gradient(ellipse at center, #000 58%, rgba(0, 0, 0, 0.92) 74%, transparent 100%);
        }

        .hp-home .hp-mode-copy {
            gap: 13px;
            max-width: 620px;
            justify-self: center;
            text-align: center;
            justify-items: center;
        }

        .hp-home .hp-mode-index {
            color: var(--hp-teal);
            font-size: 0.88rem;
        }

        .hp-home .hp-mode-title {
            font-size: clamp(2.2rem, 4.2vw, 4rem);
            letter-spacing: 0;
        }

        .hp-home .hp-mode-summary {
            color: #fff;
            font-size: 1.03rem;
            font-weight: 800;
            line-height: 1.9;
        }

        .hp-home .hp-mode-desc {
            color: rgba(244, 246, 250, 0.76);
            line-height: 1.9;
        }

        .hp-home .hp-mode-focus {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px 24px;
            width: min(100%, 480px);
            text-align: start;
        }

        .hp-home .hp-mode-plan-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            width: min(100%, 500px);
        }

        .hp-home .hp-mode-plan {
            display: grid;
            gap: 9px;
            padding: 16px;
            border: 1px solid rgba(0, 230, 167, 0.14);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            text-align: center;
        }

        .hp-home .hp-mode-plan strong {
            color: var(--hp-teal);
            font-size: 0.95rem;
        }

        .hp-home .hp-mode-plan p {
            margin: 0;
            color: rgba(244, 246, 250, 0.74);
            font-size: 0.78rem;
            line-height: 1.75;
        }

        .hp-home .hp-mode-audience {
            display: grid;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .hp-home .hp-mode-audience li {
            position: relative;
            padding-inline-start: 14px;
        }

        .hp-home .hp-mode-audience li::before {
            content: '';
            position: absolute;
            inset-inline-start: 0;
            top: 0.74em;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--hp-teal);
        }

        .hp-home .hp-mode-details {
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
            padding-top: 18px;
            width: 100%;
            text-align: start;
        }

        .hp-home .hp-trust {
            padding: clamp(74px, 8vw, 112px) 0;
            background: #05080e;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .hp-home .hp-trust .container {
            max-width: 1220px;
        }

        .hp-home .hp-trust-layout {
            display: grid;
            grid-template-columns: minmax(0, 0.86fr) minmax(360px, 1.14fr);
            grid-template-areas: "copy visual";
            gap: clamp(30px, 5vw, 68px);
            align-items: center;
            direction: ltr;
        }

        .hp-home .hp-trust-copy-area {
            grid-area: copy;
            direction: rtl;
            display: grid;
            gap: 24px;
        }

        .hp-home .hp-trust-copy-area .hp-section-title {
            font-size: clamp(2.3rem, 4.4vw, 4.25rem);
            letter-spacing: 0;
        }

        .hp-home .hp-trust-points {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .hp-home .hp-trust-point {
            grid-template-columns: 74px 1fr;
            align-items: center;
            gap: 18px;
            padding: 16px 18px;
            border: 1px solid rgba(0, 230, 167, 0.16);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.025);
            text-align: start;
        }

        .hp-home .hp-trust-point-icon {
            width: 58px;
            height: 58px;
            margin: 0;
            color: var(--hp-teal);
        }

        .hp-home .hp-trust-point-icon img,
        .hp-home .hp-trust-point-icon svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hp-home .hp-trust-point strong {
            color: var(--hp-teal);
            font-size: 1.05rem;
        }

        .hp-home .hp-trust-tech-strip {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .hp-home .hp-trust-tech-strip span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(244, 246, 250, 0.86);
            font-size: 0.78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .hp-home .hp-trust-tech-strip i {
            color: var(--hp-teal);
        }

        .hp-home .hp-trust-visual {
            grid-area: visual;
            direction: rtl;
            margin: 0;
        }

        .hp-home .hp-trust-visual img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 24px 42px rgba(0, 230, 167, 0.08));
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-hero-metric-mode-grid,
            .hp-home .hp-hero-metric-panel-list,
            .hp-home .hp-mode-plan-grid,
            .hp-home .hp-mode-details,
            .hp-home .hp-trust-tech-strip {
                grid-template-columns: 1fr;
            }

            .hp-home .hp-mode-panel,
            .hp-home .hp-trust-layout {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "visual"
                    "copy";
                min-height: 0;
            }

            .hp-home .hp-modes .hp-section-head {
                margin-inline: auto;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-mode-tabs {
                justify-content: center;
                overflow-x: auto;
                flex-wrap: nowrap;
                scrollbar-width: none;
            }

            .hp-home .hp-mode-trigger {
                flex: 0 0 auto;
                min-width: 150px;
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-hero-metric-panel-inner {
                padding: 14px;
            }

            .hp-home .hp-hero-metrics {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0;
                border-top: 1px solid var(--hp-line);
            }

            .hp-home .hp-hero-metric-panel {
                top: calc(100% + 10px);
                right: -4px;
                left: -4px;
            }

            .hp-home .hp-hero-metric {
                border-radius: 0;
                padding: 8px 6px;
                border-inline-start: 1px solid var(--hp-line-soft) !important;
            }

            .hp-home .hp-hero-metric:first-child {
                padding: 8px 6px;
                border-inline-start: 0 !important;
            }

            .hp-home .hp-hero-metric:nth-child(3) {
                border-inline-start: 0 !important;
                border-left: 0 !important;
                border-right: 0 !important;
            }

            .hp-home .hp-hero-metric-icon {
                width: 34px;
                height: 34px;
                margin-bottom: 6px;
            }

            .hp-home .hp-hero-metric strong {
                font-size: 1.08rem;
            }

            .hp-home .hp-hero-metric span {
                font-size: 0.68rem;
            }

            .hp-home .hp-hero-metric small {
                font-size: 0.58rem;
                line-height: 1.45;
            }

            .hp-home .hp-mode-trigger {
                padding-inline: 14px;
                font-size: 0.82rem;
            }

            .hp-home .hp-mode-visual img {
                transform: scale(1.02);
            }

            .hp-home .hp-mode-copy {
                text-align: center;
            }

            .hp-home .hp-trust-point {
                grid-template-columns: 48px 1fr;
                padding: 14px;
            }

            .hp-home .hp-trust-point-icon {
                width: 42px;
                height: 42px;
            }
        }

        /* Final alignment polish */
        :root {
            --hp-shell-width: 1220px;
        }

        .hp-home .container,
        .hp-home section > .container {
            max-width: var(--hp-shell-width) !important;
        }

        .hp-home .hp-mode-trigger::after {
            background: var(--hp-teal);
        }

        .hp-home .hp-modes .container {
            max-width: 1220px !important;
        }

        .hp-home .hp-mode-carousel,
        .hp-home .hp-mode-panels {
            width: 100%;
            max-width: none;
        }

        .hp-home .hp-mode-panel {
            grid-template-columns: minmax(360px, 1.14fr) minmax(0, 0.86fr);
            gap: clamp(30px, 5vw, 68px);
        }

        .hp-home .hp-mode-visual {
            width: 100%;
            max-width: none;
            aspect-ratio: auto;
            border-radius: 14px;
            background: #05080e;
            align-self: center;
            justify-self: center;
        }

        .hp-home .hp-mode-visual::after {
            display: none !important;
            content: none !important;
            background: none !important;
        }

        .hp-home .hp-mode-visual img {
            display: block;
            width: 100%;
            height: auto;
            min-height: 0;
            object-fit: contain;
            object-position: center;
            transform: none;
            border-radius: inherit;
            -webkit-mask-image: none;
            mask-image: none;
            filter: none !important;
            opacity: 1 !important;
            mix-blend-mode: normal !important;
        }

        .hp-home .hp-mode-tabs {
            width: min(100%, 940px);
        }

        .hp-home .hp-trust-visual {
            position: relative;
            overflow: hidden;
            background: #05080e;
            isolation: isolate;
            border-radius: 14px;
        }

        .hp-home .hp-trust-visual img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: inherit;
            -webkit-mask-image: radial-gradient(ellipse at center, #000 56%, rgba(0, 0, 0, 0.88) 72%, transparent 100%);
            mask-image: radial-gradient(ellipse at center, #000 56%, rgba(0, 0, 0, 0.88) 72%, transparent 100%);
            filter: drop-shadow(0 24px 42px rgba(0, 230, 167, 0.08));
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-trust-tech-strip {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px 16px;
            }

            .hp-home .hp-trust-point {
                align-items: center;
            }

            .hp-home .hp-trust-copy-area,
            .hp-home .hp-trust-copy-area .hp-kicker,
            .hp-home .hp-trust-copy-area .hp-section-title,
            .hp-home .hp-trust-visual {
                justify-self: center;
                text-align: center;
            }

            .hp-home .hp-trust-copy-area {
                justify-items: center;
            }

            .hp-home .hp-mode-tabs {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                justify-content: stretch;
                width: 100%;
                margin-inline: auto;
                overflow: visible;
                scroll-snap-type: none;
            }

            .hp-home .hp-mode-trigger {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                min-width: 0;
                padding-inline: 8px;
                scroll-snap-align: unset;
                white-space: normal;
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-trust-point {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
            }

            .hp-home .hp-trust-point-icon {
                margin-inline: auto;
            }

            .hp-home .hp-trust-tech-strip {
                flex-wrap: nowrap;
                overflow-x: auto;
                justify-content: flex-start;
                padding-bottom: 4px;
                scrollbar-width: none;
            }

            .hp-home .hp-trust-tech-strip::-webkit-scrollbar,
            .hp-home .hp-mode-tabs::-webkit-scrollbar {
                display: none;
            }

            .hp-home .hp-mode-tabs {
                padding-inline: 0;
            }

            .hp-home .hp-mode-trigger {
                min-width: 0;
                font-size: 0.72rem;
            }
        }

        /* Closing sections */
        .hp-home .hp-testimonials {
            padding: 78px 0;
            background: #091019;
            border-top: 1px solid rgba(167, 176, 192, 0.09);
            border-bottom: 1px solid rgba(167, 176, 192, 0.07);
        }

        .hp-home .hp-testimonials .hp-section-head {
            max-width: 760px;
            margin-inline: auto;
            text-align: center;
            justify-items: center;
        }

        .hp-home .hp-testimonial-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            width: 100%;
            max-width: 760px;
            margin: 0 auto 26px;
            padding: 0;
            border: 0;
        }

        .hp-home .hp-testimonial-stat {
            padding: 18px;
            border: 1px solid rgba(167, 176, 192, 0.1);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            text-align: center;
        }

        .hp-home .hp-testimonial-stat strong {
            margin-bottom: 6px;
            font-size: 1.24rem;
        }

        .hp-home .hp-testimonial-layout {
            position: relative;
            display: block;
            width: 100%;
            max-width: none;
            margin-inline: auto;
            padding-inline: 0;
        }

        .hp-home .hp-testimonial-track {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            overflow: visible;
            border-radius: 0;
        }

        .hp-home .hp-testimonial-slide,
        .hp-home .hp-testimonial-slide.is-active {
            display: flex !important;
            min-height: 250px;
            opacity: 1 !important;
            transform: none !important;
        }

        .hp-home .hp-testimonial-nav,
        .hp-home .hp-testimonial-dots {
            display: none !important;
        }

        .hp-home .hp-review-mini,
        .hp-home .hp-review-form-shell {
            padding: 22px;
            border-radius: 16px;
            border: 1px solid rgba(167, 176, 192, 0.1);
            background: rgba(255, 255, 255, 0.025);
            box-shadow: none;
        }

        .hp-home .hp-review-mini:hover {
            transform: none;
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(0, 230, 167, 0.18);
        }

        .hp-home .hp-review-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(0, 230, 167, 0.12);
            border-color: rgba(0, 230, 167, 0.18);
            box-shadow: none;
        }

        .hp-home .hp-final-cta {
            padding: 74px 0 0;
            background: #091019;
        }

        .hp-home .hp-final-cta-scene {
            min-height: 0;
            padding: 34px;
            border-radius: 18px;
            border: 1px solid rgba(167, 176, 192, 0.1);
            background:
                linear-gradient(90deg, rgba(8, 12, 18, 0.94) 0%, rgba(8, 12, 18, 0.78) 48%, rgba(8, 12, 18, 0.42) 100%),
                url('{{ asset('assets/images/home/niro-final-cta-bg.webp') }}') center / cover no-repeat,
                #0d1117;
            overflow: hidden;
        }

        .hp-home .hp-final-cta-scene::before,
        .hp-home .hp-final-cta-scene::after {
            display: none;
        }

        .hp-home .hp-final-cta-copy {
            position: static;
            inset: auto;
            width: 100%;
            max-width: none;
            transform: none;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 16px 28px;
            align-items: center;
        }

        .hp-home .hp-final-cta-copy .hp-kicker,
        .hp-home .hp-final-cta-title,
        .hp-home .hp-final-cta-desc {
            grid-column: 1;
        }

        .hp-home .hp-final-cta-title {
            max-width: 640px;
            font-size: 2.1rem;
            line-height: 1.35;
            letter-spacing: 0;
        }

        .hp-home .hp-final-cta-desc {
            max-width: 720px;
            color: rgba(244, 246, 250, 0.76);
            font-size: 0.94rem;
            line-height: 1.9;
        }

        .hp-home .hp-final-cta-actions {
            grid-column: 2;
            grid-row: 1 / span 3;
            align-self: center;
            justify-content: flex-end;
            min-width: 280px;
        }

        .hp-home .hp-risk-strip {
            padding: 16px 0 54px;
            background: #091019;
        }

        .hp-home .hp-risk-strip .container {
            padding-top: 0;
            border-top: 0;
        }

        .hp-home .hp-risk-text {
            margin: 0;
            padding: 16px 18px;
            border: 1px solid rgba(167, 176, 192, 0.1);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            color: rgba(244, 246, 250, 0.66);
            font-size: 0.78rem;
            line-height: 1.9;
            text-align: center;
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-testimonials {
                padding: 54px 0;
            }

            .hp-home .hp-testimonial-stats,
            .hp-home .hp-testimonial-track {
                grid-template-columns: 1fr;
            }

            .hp-home .hp-testimonial-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .hp-home .hp-testimonial-stat {
                min-width: 0;
                padding: 12px 8px;
            }

            .hp-home .hp-testimonial-stat strong {
                font-size: 0.95rem;
            }

            .hp-home .hp-testimonial-stat span {
                font-size: 0.62rem;
                line-height: 1.55;
            }

            .hp-home .hp-testimonial-layout {
                padding-inline: 0;
            }

            .hp-home .hp-testimonial-slide:not(.is-active) {
                display: none !important;
            }

            .hp-home .hp-testimonial-nav {
                display: none !important;
            }

            .hp-home .hp-testimonial-dots {
                display: flex !important;
            }

            .hp-home .hp-final-cta {
                padding-top: 54px;
            }

            .hp-home .hp-final-cta-scene {
                padding: 24px;
                border-radius: 16px;
            }

            .hp-home .hp-final-cta-copy {
                grid-template-columns: 1fr;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-final-cta-actions {
                grid-column: 1;
                grid-row: auto;
                min-width: 0;
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-testimonial-stats {
                gap: 8px;
            }

            .hp-home .hp-testimonial-stat,
            .hp-home .hp-review-mini,
            .hp-home .hp-review-form-shell,
            .hp-home .hp-risk-text {
                border-radius: 12px;
            }

            .hp-home .hp-final-cta-title {
                font-size: 1.48rem;
            }

            .hp-home .hp-final-cta-actions,
            .hp-home .hp-final-cta-actions > *,
            .hp-home .hp-final-cta-actions form {
                width: 100%;
            }
        }

        /* Reference-style modes section */
        .hp-home .hp-modes {
            position: relative;
            display: flex;
            align-items: center;
            min-height: clamp(680px, 66vw, 860px);
            padding: clamp(72px, 8vw, 104px) 0;
            overflow: hidden;
            background: #02060d;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .hp-home .hp-modes::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 0;
            background:
                linear-gradient(90deg, rgba(2, 6, 13, 0.04) 0%, rgba(2, 6, 13, 0.14) 42%, rgba(2, 6, 13, 0.82) 68%, #02060d 100%),
                url('{{ $homeMedia['modeSectionVisual'] }}') center / cover no-repeat;
        }

        .hp-home .hp-modes::after {
            display: none;
        }

        .hp-home .hp-modes > .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1220px !important;
        }

        .hp-home .hp-mode-shell {
            display: block;
            gap: 0;
        }

        .hp-home .hp-mode-reference-layout {
            display: grid;
            grid-template-columns: minmax(0, 0.98fr) minmax(500px, 0.9fr);
            align-items: center;
            min-height: clamp(540px, 52vw, 680px);
            direction: ltr;
        }

        .hp-home .hp-mode-art-space {
            min-height: 520px;
        }

        .hp-home .hp-mode-content-stack {
            direction: rtl;
            display: grid;
            gap: 24px;
            justify-items: start;
            width: 100%;
            max-width: 640px;
            margin-inline-start: auto;
            text-align: start;
        }

        .hp-home .hp-modes .hp-section-head {
            max-width: 640px;
            margin: 0;
            text-align: start;
            justify-items: start;
        }

        .hp-home .hp-modes .hp-kicker {
            justify-content: flex-start;
            color: rgba(244, 246, 250, 0.78);
            font-size: 0.88rem;
        }

        .hp-home .hp-modes .hp-kicker::before {
            width: 34px;
            background: rgba(244, 246, 250, 0.72);
        }

        .hp-home .hp-modes .hp-section-title {
            font-size: clamp(2.15rem, 3.6vw, 3.55rem);
            line-height: 1.22;
            letter-spacing: 0;
        }

        .hp-home .hp-mode-tabs {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0;
            width: min(100%, 560px);
            margin: 0;
            padding-bottom: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            overflow: visible;
        }

        .hp-home .hp-mode-trigger {
            min-width: 0;
            padding: 0 20px 14px;
            border: 0;
            border-inline-start: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 0;
            color: rgba(244, 246, 250, 0.66);
            font-size: 1rem;
            line-height: 1.45;
            white-space: normal;
            background: transparent;
        }

        .hp-home .hp-mode-trigger:first-child {
            border-inline-start: 0;
        }

        .hp-home .hp-mode-trigger::after {
            height: 2px;
            background: var(--hp-teal);
        }

        .hp-home .hp-mode-trigger.is-active {
            color: #fff;
            background: transparent;
        }

        .hp-home .hp-mode-carousel,
        .hp-home .hp-mode-panels {
            width: 100%;
            max-width: none;
            overflow: visible;
        }

        .hp-home .hp-mode-panel {
            display: none !important;
            min-height: 0;
            padding: 0;
            border: 0;
            background: transparent;
            direction: rtl;
        }

        .hp-home .hp-mode-panel.is-active {
            display: block !important;
        }

        .hp-home .hp-mode-mobile-visual {
            display: none;
            margin: 0;
            overflow: hidden;
            border-radius: 20px;
            background: #05080e;
        }

        .hp-home .hp-mode-mobile-visual img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .hp-home .hp-mode-copy {
            display: grid;
            gap: 14px;
            max-width: 640px;
            justify-items: start;
            text-align: start;
        }

        .hp-home .hp-mode-index {
            color: var(--hp-teal) !important;
            font-size: 1rem;
            font-weight: 900;
        }

        .hp-home .hp-mode-title {
            margin: 0;
            color: #fff;
            font-size: clamp(2.4rem, 4.2vw, 4.15rem);
            line-height: 1.12;
            letter-spacing: 0;
        }

        .hp-home .hp-mode-summary,
        .hp-home .hp-mode-desc {
            max-width: 620px;
            margin: 0;
            color: rgba(244, 246, 250, 0.84);
            font-size: 1.05rem;
            font-weight: 500;
            line-height: 2;
        }

        .hp-home .hp-mode-summary {
            color: #fff;
            font-weight: 700;
        }

        @media (max-width: 1199.98px) {
            .hp-home .hp-modes {
                min-height: clamp(600px, 72vw, 760px);
            }

            .hp-home .hp-mode-reference-layout {
                grid-template-columns: minmax(0, 0.82fr) minmax(430px, 1fr);
                min-height: clamp(500px, 58vw, 620px);
            }

            .hp-home .hp-mode-content-stack {
                max-width: 600px;
            }
        }

        @media (max-width: 991.98px) {
            .hp-home .hp-modes {
                display: block;
                min-height: 0;
                padding: 56px 0;
                background: #02060d;
            }

            .hp-home .hp-modes > .container {
                width: 100%;
                max-width: none !important;
                padding-inline: 0 !important;
            }

            .hp-home .hp-modes::before,
            .hp-home .hp-modes::after {
                display: none;
            }

            .hp-home .hp-mode-reference-layout {
                grid-template-columns: 1fr;
                gap: 24px;
                min-height: 0;
                direction: rtl;
                justify-items: center;
                width: 100%;
                margin-inline: auto;
            }

            .hp-home .hp-mode-art-space {
                display: none;
            }

            .hp-home .hp-mode-content-stack {
                width: min(calc(100vw - 32px), 680px);
                max-width: 680px;
                margin-inline: auto;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                backdrop-filter: none;
                box-sizing: border-box;
            }

            .hp-home .hp-modes .hp-section-head {
                width: 100%;
                max-width: 680px;
                margin-inline: auto;
                text-align: center;
                justify-items: center;
            }

            .hp-home .hp-modes .hp-kicker {
                display: none;
            }

            .hp-home .hp-modes .hp-section-title {
                text-align: center;
            }

            .hp-home .hp-mode-tabs {
                width: 100%;
            }

            .hp-home .hp-mode-carousel,
            .hp-home .hp-mode-panels {
                display: grid;
                justify-items: center;
                width: 100%;
            }

            .hp-home .hp-mode-panel {
                grid-template-columns: 1fr !important;
                gap: 0;
                width: 100%;
                max-width: 680px;
                margin-inline: auto;
                justify-self: center;
                box-sizing: border-box;
            }

            .hp-home .hp-mode-panel.is-active {
                display: grid !important;
                gap: 18px;
                justify-items: center;
                justify-content: center;
                width: 100%;
                margin-inline: auto;
                text-align: center;
            }

            .hp-home .hp-mode-copy {
                width: min(100%, 620px);
                max-width: 620px;
                justify-self: center;
                justify-items: center;
                margin-inline: auto;
                text-align: center;
            }

            .hp-home .hp-mode-index,
            .hp-home .hp-mode-title,
            .hp-home .hp-mode-summary,
            .hp-home .hp-mode-desc {
                text-align: center;
            }

            .hp-home .hp-mode-mobile-visual {
                display: block;
                width: 100%;
                margin-inline: auto;
                aspect-ratio: 16 / 9;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .hp-home .hp-modes {
                display: flex;
                min-height: clamp(600px, 78vw, 720px);
                padding: 64px 0;
            }

            .hp-home .hp-modes::before {
                display: block;
            }

            .hp-home .hp-modes > .container {
                width: 100%;
                max-width: 920px !important;
                padding-inline: 32px !important;
            }

            .hp-home .hp-mode-reference-layout {
                grid-template-columns: minmax(280px, 0.88fr) minmax(350px, 1fr);
                align-items: center;
                gap: 0;
                min-height: clamp(500px, 62vw, 600px);
                direction: ltr;
                justify-items: stretch;
            }

            .hp-home .hp-mode-art-space {
                display: block;
                min-height: 460px;
            }

            .hp-home .hp-mode-content-stack {
                width: 100%;
                max-width: 420px;
                margin: 0;
                justify-self: end;
                text-align: start;
                justify-items: start;
            }

            .hp-home .hp-modes .hp-section-head {
                max-width: 420px;
                margin: 0;
                text-align: start;
                justify-items: start;
            }

            .hp-home .hp-modes .hp-kicker {
                display: inline-flex;
                justify-content: flex-start;
            }

            .hp-home .hp-modes .hp-section-title {
                font-size: clamp(2rem, 4.6vw, 3rem);
                text-align: start;
            }

            .hp-home .hp-mode-panel,
            .hp-home .hp-mode-panel.is-active {
                width: 100%;
                max-width: none;
                justify-items: start;
                justify-content: stretch;
                text-align: start;
            }

            .hp-home .hp-mode-mobile-visual {
                display: none;
            }

            .hp-home .hp-mode-copy {
                width: 100%;
                max-width: 420px;
                justify-self: start;
                justify-items: start;
                margin-inline: 0;
                text-align: start;
            }

            .hp-home .hp-mode-index,
            .hp-home .hp-mode-title,
            .hp-home .hp-mode-summary,
            .hp-home .hp-mode-desc {
                text-align: start;
            }

            .hp-home .hp-mode-title {
                font-size: clamp(2.1rem, 5vw, 3.4rem);
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-modes {
                padding: 38px 0;
            }

            .hp-home .hp-mode-art-space {
                display: none;
            }

            .hp-home .hp-mode-content-stack {
                gap: 18px;
                width: min(calc(100vw - 24px), 680px);
                padding: 0;
                border-radius: 0;
            }

            .hp-home .hp-modes .hp-section-title {
                font-size: clamp(1.7rem, 7.5vw, 2.35rem);
                line-height: 1.32;
            }

            .hp-home .hp-mode-tabs {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0;
                width: 100%;
                margin: 0;
                padding-bottom: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                overflow: visible;
            }

            .hp-home .hp-mode-trigger {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 0;
                padding: 0 8px 12px;
                border: 0;
                border-inline-start: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 0;
                color: rgba(244, 246, 250, 0.66);
                font-size: clamp(0.72rem, 2.9vw, 0.88rem);
                line-height: 1.45;
                text-align: center;
                white-space: normal;
                background: transparent;
            }

            .hp-home .hp-mode-trigger:first-child {
                border-inline-start: 0;
            }

            .hp-home .hp-mode-trigger::after {
                position: absolute;
                right: 0;
                left: 0;
                bottom: 0;
                width: auto;
                height: 2px;
                border-radius: 2px;
                transform-origin: center;
            }

            .hp-home .hp-mode-trigger.is-active {
                color: #fff;
            }

            .hp-home .hp-mode-title {
                font-size: clamp(1.9rem, 9vw, 2.75rem);
            }

            .hp-home .hp-mode-mobile-visual {
                aspect-ratio: 1.22;
                border-radius: 18px;
            }

            .hp-home .hp-mode-mobile-visual img {
                object-position: center;
            }

            .hp-home .hp-mode-summary,
            .hp-home .hp-mode-desc {
                font-size: 0.88rem;
                line-height: 1.9;
            }
        }

        /* ── Clean trust section ── */
        .hp-home .hp-trust {
            position: relative;
            display: flex;
            align-items: center;
            min-height: clamp(680px, 66vw, 860px);
            padding: clamp(72px, 8vw, 104px) 0;
            background: #02060d;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            overflow: hidden;
        }

        .hp-home .hp-trust::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 0;
            background:
                linear-gradient(90deg, #02060d 0%, rgba(2, 6, 13, 0.82) 32%, rgba(2, 6, 13, 0.14) 58%, rgba(2, 6, 13, 0.04) 100%),
                url('{{ $homeMedia['trustVisual'] }}') center / cover no-repeat;
        }

        .hp-home .hp-trust > .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1220px !important;
        }

        .hp-home .hp-trust-layout {
            display: block;
            width: 100%;
            min-height: clamp(540px, 52vw, 680px);
            box-sizing: border-box;
        }

        .hp-home .hp-trust-visual-area {
            display: grid;
            grid-area: auto;
            grid-template-columns: minmax(0, 0.98fr) minmax(500px, 0.9fr);
            grid-template-areas: "copy visual";
            align-items: center;
            direction: ltr;
            min-height: 520px;
            width: 100%;
            max-width: none;
            overflow: visible;
            border-radius: 0;
            box-sizing: border-box;
        }

        .hp-home .hp-trust-visual-area > img {
            display: none;
        }

        .hp-home .hp-trust-copy-area {
            grid-area: copy;
            direction: rtl;
            display: grid;
            gap: 24px;
            justify-items: start;
            width: 100%;
            max-width: 640px;
            margin: 0;
            box-sizing: border-box;
            text-align: start;
            position: relative;
            left: calc(clamp(48px, 8vw, 140px) * -1);
        }

        .hp-home .hp-trust .hp-kicker {
            color: rgba(244, 246, 250, 0.78);
            font-size: 0.88rem;
        }

        .hp-home .hp-trust .hp-kicker::before {
            width: 34px;
            background: rgba(244, 246, 250, 0.72);
        }

        .hp-home .hp-trust .hp-section-title {
            font-size: clamp(2.15rem, 3.6vw, 3.4rem);
            line-height: 1.22;
            letter-spacing: 0;
        }

        .hp-home .hp-trust-points {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .hp-home .hp-trust-point {
            display: grid;
            grid-template-columns: 58px 1fr;
            align-items: center;
            gap: 16px;
            padding: 16px 18px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            text-align: start;
        }

        .hp-home .hp-trust-point-icon {
            width: 58px;
            height: 58px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hp-home .hp-trust-point-icon img,
        .hp-home .hp-trust-point-icon svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hp-home .hp-trust-point strong {
            display: block;
            margin-bottom: 6px;
            color: var(--hp-teal);
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.4;
        }

        .hp-home .hp-trust-point p {
            margin: 0;
            color: rgba(244, 246, 250, 0.72);
            font-size: 0.84rem;
            line-height: 1.75;
        }

        .hp-home .hp-trust-tech-strip {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .hp-home .hp-trust-tech-strip span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(244, 246, 250, 0.86);
            font-size: 0.78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .hp-home .hp-trust-tech-strip i {
            color: var(--hp-teal);
        }

        @media (max-width: 1199.98px) {
            .hp-home .hp-trust {
                min-height: clamp(600px, 72vw, 760px);
            }

            .hp-home .hp-trust-layout {
                min-height: clamp(500px, 58vw, 620px);
            }

            .hp-home .hp-trust-visual-area {
                grid-template-columns: minmax(0, 0.9fr) minmax(420px, 1fr);
                min-height: clamp(500px, 58vw, 620px);
            }

            .hp-home .hp-trust-copy-area {
                max-width: 600px;
                left: calc(clamp(20px, 3vw, 42px) * -1);
            }
        }

        /* Mobile trust layout */
        @media (max-width: 991.98px) {
            .hp-home .hp-trust {
                display: block;
                min-height: 0;
                padding: 60px 0;
                background: #02060d;
            }

            .hp-home .hp-trust > .container {
                width: 100%;
                max-width: none !important;
                padding-inline: 0 !important;
            }

            .hp-home .hp-trust::before {
                display: none;
            }

            .hp-home .hp-trust-layout {
                min-height: 0;
                width: 100%;
                margin-inline: auto;
            }

            .hp-home .hp-trust-visual-area {
                display: grid;
                grid-template-columns: 1fr;
                grid-template-areas:
                    "visual"
                    "copy";
                gap: 18px;
                justify-items: center;
                width: min(calc(100vw - 32px), 680px);
                max-width: 680px;
                min-height: 0;
                margin-inline: auto;
                box-sizing: border-box;
            }

            .hp-home .hp-trust-visual-area > img {
                grid-area: visual;
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 10;
                display: block;
                object-fit: cover;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 26px;
                background: #05080e;
                box-sizing: border-box;
            }

            .hp-home .hp-trust-copy-area {
                grid-area: copy;
                justify-items: center;
                width: 100%;
                max-width: none;
                margin-inline: auto;
                padding: 24px;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 26px;
                background: rgba(255, 255, 255, 0.035);
                backdrop-filter: blur(12px);
                box-sizing: border-box;
                left: auto;
                text-align: center;
            }

            .hp-home .hp-trust-copy-area .hp-kicker,
            .hp-home .hp-trust-copy-area .hp-section-title {
                justify-self: center;
                text-align: center;
            }

            .hp-home .hp-trust-points {
                display: grid;
                grid-template-columns: 1fr;
                width: 100%;
                gap: 12px;
            }

            .hp-home .hp-trust-point {
                display: grid;
                grid-template-columns: 1fr;
                gap: 10px;
                justify-items: center;
                width: 100%;
                padding: 18px 16px;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.035);
                text-align: center;
                box-sizing: border-box;
            }

            .hp-home .hp-trust-point-icon {
                width: 50px;
                height: 50px;
                margin-inline: auto;
            }

            .hp-home .hp-trust-point > div:last-child {
                display: grid;
                gap: 6px;
                justify-items: center;
                width: 100%;
                min-width: 0;
            }

            .hp-home .hp-trust-point strong,
            .hp-home .hp-trust-point p {
                text-align: center;
            }

            .hp-home .hp-trust-tech-strip {
                display: grid;
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                overflow: visible;
                padding-bottom: 0;
                scrollbar-width: auto;
            }

            .hp-home .hp-trust-tech-strip span {
                min-width: 0;
                padding: 10px 8px;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 12px;
                white-space: normal;
                text-align: center;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .hp-home .hp-trust {
                display: flex;
                min-height: clamp(600px, 78vw, 720px);
                padding: 64px 0;
            }

            .hp-home .hp-trust::before {
                display: block;
            }

            .hp-home .hp-trust > .container {
                width: 100%;
                max-width: 920px !important;
                padding-inline: 32px !important;
            }

            .hp-home .hp-trust-layout {
                min-height: clamp(500px, 62vw, 600px);
            }

            .hp-home .hp-trust-visual-area {
                grid-template-columns: minmax(350px, 1fr) minmax(280px, 0.88fr);
                grid-template-areas: "copy visual";
                align-items: center;
                gap: 0;
                width: 100%;
                max-width: none;
                min-height: clamp(500px, 62vw, 600px);
                margin-inline: auto;
                direction: ltr;
                justify-items: stretch;
            }

            .hp-home .hp-trust-visual-area > img {
                display: none;
            }

            .hp-home .hp-trust-copy-area {
                width: 100%;
                max-width: 420px;
                margin: 0;
                justify-self: start;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                backdrop-filter: none;
                left: 0;
                justify-items: start;
                text-align: start;
            }

            .hp-home .hp-trust-copy-area .hp-kicker,
            .hp-home .hp-trust-copy-area .hp-section-title {
                justify-self: start;
                text-align: start;
            }

            .hp-home .hp-trust .hp-section-title {
                font-size: clamp(2rem, 4.6vw, 3rem);
            }

            .hp-home .hp-trust-point {
                grid-template-columns: 52px 1fr;
                gap: 14px;
                justify-items: stretch;
                padding: 14px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.03);
                text-align: start;
            }

            .hp-home .hp-trust-point-icon {
                width: 52px;
                height: 52px;
                margin: 0;
            }

            .hp-home .hp-trust-point > div:last-child {
                justify-items: start;
            }

            .hp-home .hp-trust-point strong,
            .hp-home .hp-trust-point p {
                text-align: start;
            }

            .hp-home .hp-trust-tech-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .hp-home .hp-trust {
                padding: 42px 0;
            }

            .hp-home .hp-trust-visual-area {
                width: min(calc(100vw - 24px), 680px);
                gap: 14px;
                border-radius: 20px;
            }

            .hp-home .hp-trust-visual-area > img {
                aspect-ratio: 1.22;
                border-radius: 20px;
            }

            .hp-home .hp-trust-copy-area {
                width: 100%;
                padding: 18px;
                border-radius: 20px;
                gap: 18px;
            }

            .hp-home .hp-trust .hp-section-title {
                font-size: clamp(1.7rem, 7.5vw, 2.35rem);
                line-height: 1.32;
            }

            .hp-home .hp-trust-point {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 14px;
                border-radius: 14px;
                justify-items: center;
                text-align: center;
            }

            .hp-home .hp-trust-point-icon {
                width: 48px;
                height: 48px;
            }

            .hp-home .hp-trust-point strong {
                font-size: 0.92rem;
            }

            .hp-home .hp-trust-point p {
                font-size: 0.78rem;
            }

            .hp-home .hp-trust-tech-strip {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
                overflow: visible;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .hp-home .hp-editorial-hero {
                padding: calc(var(--lira-public-header-height, 92px) + 42px) 0 58px;
            }

            .hp-home .hp-hero-grid {
                grid-template-columns: minmax(0, 780px);
                grid-template-areas: "copy";
                justify-content: center;
            }

            .hp-home .hp-hero-copy {
                justify-items: center;
                text-align: center;
            }

            .hp-home .hp-hero-title {
                max-width: 780px;
                margin-inline: auto;
                text-align: center;
                font-size: clamp(2.6rem, 6vw, 4.2rem);
            }

            .hp-home .hp-hero-sub {
                max-width: 680px;
                margin-inline: auto;
                text-align: center;
            }

            .hp-home .hp-hero-actions {
                justify-content: center;
            }

            .hp-home .hp-platform {
                padding: 70px 0;
                background: #05080e;
                border-bottom: 1px solid var(--hp-line-soft);
            }

            .hp-home .hp-platform > .container,
            .hp-home .hp-testimonials > .container {
                max-width: 860px !important;
                padding-inline: 32px !important;
            }

            .hp-home .hp-platform-story {
                display: grid;
                grid-template-columns: 1fr;
                gap: 28px;
                align-items: start;
                max-width: 760px;
                margin-inline: auto;
            }

            .hp-home .hp-platform-copy {
                justify-items: center;
                text-align: center;
            }

            .hp-home .hp-platform-copy .hp-kicker {
                justify-content: center;
            }

            .hp-home .hp-platform-copy .hp-section-title,
            .hp-home .hp-platform-desc {
                text-align: center;
            }

            .hp-home .hp-platform-visual {
                display: block;
                width: 100%;
                max-width: 680px;
                margin: 0 auto;
                justify-self: center;
                border-radius: 26px;
            }

            .hp-home .hp-platform-points {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                width: 100%;
                margin-top: 10px !important;
                border-top: 0;
            }

            .hp-home .hp-platform-point {
                grid-template-columns: auto 1fr;
                gap: 14px;
                min-height: 132px;
                padding: 18px;
                border: 1px solid var(--hp-line-soft);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.02);
                text-align: start;
                align-content: start;
            }

            .hp-home .hp-testimonials {
                padding: 72px 0;
                background: #0d1117;
            }

            .hp-home .hp-testimonial-layout {
                position: relative;
                display: block;
                width: 100%;
                max-width: none;
                margin-inline: auto;
                padding-inline: 0;
            }

            .hp-home .hp-testimonial-track {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
                overflow: visible;
                border-radius: 0;
            }

            .hp-home .hp-testimonial-slide,
            .hp-home .hp-testimonial-slide.is-active,
            .hp-home .hp-testimonial-slide:not(.is-active) {
                display: flex !important;
                flex-direction: column;
                min-height: 250px;
                opacity: 1 !important;
                transform: none !important;
            }

            .hp-home .hp-testimonial-slide:first-child {
                grid-column: 1 / -1;
                min-height: 220px;
            }

            .hp-home .hp-testimonial-track .hp-review-mini {
                padding: 24px;
                justify-content: flex-start;
            }

            .hp-home .hp-testimonial-track .hp-review-stars {
                justify-content: flex-start;
            }

            .hp-home .hp-testimonial-track .hp-review-mini-text {
                font-size: 0.9rem;
                line-height: 1.9;
                text-align: start;
                word-break: normal;
                overflow-wrap: break-word;
            }

            .hp-home .hp-testimonial-track .hp-review-author {
                margin-top: auto;
                padding-top: 22px;
            }

            .hp-home .hp-testimonial-nav,
            .hp-home .hp-testimonial-dots {
                display: none !important;
            }
        }

        @media (max-width: 380px) {
            .hp-home .hp-trust-tech-strip {
                grid-template-columns: 1fr;
            }
        }

        /* ===== Final Typography Scale ===== */

        /* Desktop base (applies globally, overridden by breakpoints below) */
        .hp-home .hp-hero-title {
            font-size: clamp(2.8rem, 4.6vw, 4.8rem) !important;
            line-height: 1.28 !important;
        }

        .hp-home .hp-hero-sub {
            font-size: clamp(1rem, 1.4vw, 1.12rem) !important;
            line-height: 1.75 !important;
        }

        .hp-home .hp-section-title {
            font-size: clamp(1.95rem, 2.9vw, 2.85rem) !important;
            line-height: 1.25 !important;
            letter-spacing: 0 !important;
        }

        .hp-home .hp-section-title--md {
            font-size: clamp(1.7rem, 2.3vw, 2.2rem) !important;
            line-height: 1.3 !important;
        }

        .hp-home .hp-section-desc {
            font-size: clamp(0.92rem, 1.1vw, 1.02rem) !important;
            line-height: 1.7 !important;
        }

        .hp-home .hp-mode-title {
            font-size: clamp(1.85rem, 2.7vw, 2.7rem) !important;
            line-height: 1.22 !important;
        }

        .hp-home .hp-mode-summary {
            font-size: 0.98rem !important;
            line-height: 1.65 !important;
        }

        .hp-home .hp-mode-desc {
            font-size: 0.92rem !important;
            line-height: 1.72 !important;
        }

        .hp-home .hp-kicker {
            font-size: 0.82rem !important;
            letter-spacing: 0.04em !important;
        }

        .hp-home .hp-feature-title {
            font-size: 1.05rem !important;
            line-height: 1.45 !important;
        }

        .hp-home .hp-platform-desc {
            font-size: 0.94rem !important;
            line-height: 1.7 !important;
        }

        .hp-home .hp-platform-point strong {
            font-size: 1rem !important;
            line-height: 1.45 !important;
        }

        .hp-home .hp-platform-point p {
            font-size: 0.86rem !important;
            line-height: 1.65 !important;
        }

        .hp-home .hp-trust-point strong {
            font-size: 1rem !important;
            line-height: 1.4 !important;
        }

        .hp-home .hp-trust-point p {
            font-size: 0.86rem !important;
            line-height: 1.7 !important;
        }

        .hp-home .hp-trust-tech-strip span {
            font-size: 0.8rem !important;
        }

        .hp-home .hp-review-mini-text {
            font-size: 0.92rem !important;
            line-height: 1.8 !important;
        }

        .hp-home .hp-review-author {
            font-size: 0.84rem !important;
        }

        .hp-home .hp-review-stat {
            font-size: 0.78rem !important;
        }

        .hp-home .hp-review-stat-value {
            font-size: 1.1rem !important;
        }

        .hp-home .hp-final-cta-desc {
            font-size: 0.94rem !important;
            line-height: 1.7 !important;
        }

        .hp-home .hp-modes .hp-section-title {
            font-size: clamp(2rem, 3.1vw, 3.1rem) !important;
        }

        .hp-home .hp-trust .hp-section-title {
            font-size: clamp(2rem, 3.2vw, 3rem) !important;
        }

        .hp-home .hp-platform .hp-section-title {
            font-size: clamp(1.95rem, 2.9vw, 2.85rem) !important;
        }

        .hp-home .hp-testimonials .hp-section-title {
            font-size: clamp(1.95rem, 2.9vw, 2.85rem) !important;
        }

        .hp-home .hp-final-cta .hp-section-title {
            font-size: clamp(2rem, 3.2vw, 3.15rem) !important;
        }

        /* Tablet scale: 768px–991.98px */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .hp-home .hp-hero-title {
                font-size: clamp(2.3rem, 5.5vw, 3.6rem) !important;
            }

            .hp-home .hp-hero-sub {
                font-size: 0.98rem !important;
            }

            .hp-home .hp-section-title {
                font-size: clamp(1.75rem, 4vw, 2.5rem) !important;
            }

            .hp-home .hp-section-title--md {
                font-size: clamp(1.55rem, 3.5vw, 2rem) !important;
            }

            .hp-home .hp-section-desc {
                font-size: 0.92rem !important;
            }

            .hp-home .hp-mode-title {
                font-size: clamp(1.65rem, 4vw, 2.3rem) !important;
            }

            .hp-home .hp-mode-summary {
                font-size: 0.94rem !important;
            }

            .hp-home .hp-mode-desc {
                font-size: 0.88rem !important;
            }

            .hp-home .hp-feature-title {
                font-size: 0.98rem !important;
            }

            .hp-home .hp-platform-desc {
                font-size: 0.9rem !important;
            }

            .hp-home .hp-platform-point strong {
                font-size: 0.96rem !important;
            }

            .hp-home .hp-platform-point p {
                font-size: 0.82rem !important;
            }

            .hp-home .hp-trust-point strong {
                font-size: 0.94rem !important;
            }

            .hp-home .hp-trust-point p {
                font-size: 0.82rem !important;
            }

            .hp-home .hp-trust-tech-strip span {
                font-size: 0.76rem !important;
            }

            .hp-home .hp-review-mini-text {
                font-size: 0.88rem !important;
            }

            .hp-home .hp-review-author {
                font-size: 0.8rem !important;
            }

            .hp-home .hp-final-cta-desc {
                font-size: 0.9rem !important;
            }

            .hp-home .hp-modes .hp-section-title {
                font-size: clamp(1.85rem, 4.2vw, 2.7rem) !important;
            }

            .hp-home .hp-trust .hp-section-title {
                font-size: clamp(1.8rem, 4.4vw, 2.6rem) !important;
            }
        }

        /* Mobile scale: max-width 575.98px */
        @media (max-width: 575.98px) {
            .hp-home .hp-hero-title {
                font-size: clamp(1.85rem, 9vw, 2.4rem) !important;
                line-height: 1.34 !important;
            }

            .hp-home .hp-hero-sub {
                font-size: 0.88rem !important;
                line-height: 1.7 !important;
            }

            .hp-home .hp-section-title {
                font-size: clamp(1.5rem, 7.5vw, 2rem) !important;
                line-height: 1.28 !important;
            }

            .hp-home .hp-section-title--md {
                font-size: clamp(1.35rem, 6.5vw, 1.7rem) !important;
                line-height: 1.32 !important;
            }

            .hp-home .hp-section-desc {
                font-size: 0.84rem !important;
                line-height: 1.65 !important;
            }

            .hp-home .hp-mode-title {
                font-size: clamp(1.4rem, 8vw, 1.85rem) !important;
                line-height: 1.25 !important;
            }

            .hp-home .hp-mode-summary {
                font-size: 0.86rem !important;
            }

            .hp-home .hp-mode-desc {
                font-size: 0.82rem !important;
            }

            .hp-home .hp-feature-title {
                font-size: 0.9rem !important;
            }

            .hp-home .hp-platform-desc {
                font-size: 0.84rem !important;
            }

            .hp-home .hp-platform-point strong {
                font-size: 0.9rem !important;
            }

            .hp-home .hp-platform-point p {
                font-size: 0.78rem !important;
            }

            .hp-home .hp-trust-point strong {
                font-size: 0.88rem !important;
            }

            .hp-home .hp-trust-point p {
                font-size: 0.76rem !important;
            }

            .hp-home .hp-trust-tech-strip span {
                font-size: 0.72rem !important;
            }

            .hp-home .hp-review-mini-text {
                font-size: 0.84rem !important;
                line-height: 1.75 !important;
            }

            .hp-home .hp-review-author {
                font-size: 0.76rem !important;
            }

            .hp-home .hp-review-stat {
                font-size: 0.72rem !important;
            }

            .hp-home .hp-review-stat-value {
                font-size: 0.98rem !important;
            }

            .hp-home .hp-final-cta-desc {
                font-size: 0.84rem !important;
            }

            .hp-home .hp-modes .hp-section-title {
                font-size: clamp(1.6rem, 7.8vw, 2.1rem) !important;
            }

            .hp-home .hp-trust .hp-section-title {
                font-size: clamp(1.55rem, 7.5vw, 2.05rem) !important;
            }
        }

        /* Mobile compact pass: reduce the whole homepage rhythm by roughly 20%. */
        @media (max-width: 575.98px) {
            .hp-home .container {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            .hp-home .hp-editorial-hero {
                min-height: 52vh !important;
                padding: calc(var(--lira-public-header-height, 72px) + 42px) 0 58px !important;
            }

            .hp-home .hp-hero-copy,
            .hp-home .hp-section-head,
            .hp-home .hp-mode-copy,
            .hp-home .hp-trust-copy-area,
            .hp-home .hp-final-cta-copy {
                gap: 13px !important;
            }

            .hp-home .hp-hero-title {
                font-size: clamp(1.5rem, 7.2vw, 1.92rem) !important;
                line-height: 1.38 !important;
                letter-spacing: 0 !important;
            }

            .hp-home .hp-hero-sub {
                font-size: 0.7rem !important;
                line-height: 1.8 !important;
            }

            .hp-home .hp-section-title {
                font-size: clamp(1.2rem, 6vw, 1.6rem) !important;
                line-height: 1.35 !important;
            }

            .hp-home .hp-section-title--md {
                font-size: clamp(1.08rem, 5.2vw, 1.36rem) !important;
            }

            .hp-home .hp-modes .hp-section-title,
            .hp-home .hp-trust .hp-section-title {
                font-size: clamp(1.24rem, 6.2vw, 1.68rem) !important;
            }

            .hp-home .hp-mode-title {
                font-size: clamp(1.12rem, 6.4vw, 1.48rem) !important;
                line-height: 1.32 !important;
            }

            .hp-home .hp-section-desc,
            .hp-home .hp-mode-summary,
            .hp-home .hp-mode-desc,
            .hp-home .hp-platform-desc,
            .hp-home .hp-review-mini-text,
            .hp-home .hp-final-cta-desc {
                font-size: 0.68rem !important;
                line-height: 1.75 !important;
            }

            .hp-home .hp-kicker,
            .hp-home .hp-feature-desc,
            .hp-home .hp-platform-point p,
            .hp-home .hp-trust-point p,
            .hp-home .hp-risk-text {
                font-size: 0.62rem !important;
                line-height: 1.7 !important;
            }

            .hp-home .hp-feature-title,
            .hp-home .hp-platform-point strong,
            .hp-home .hp-trust-point strong {
                font-size: 0.72rem !important;
            }

            .hp-home .hp-btn-primary,
            .hp-home .hp-btn-secondary {
                min-height: 40px !important;
                padding: 0 18px !important;
                border-radius: 11px !important;
                font-size: 0.7rem !important;
            }

            .hp-home .hp-hero-actions,
            .hp-home .hp-final-cta-actions {
                gap: 8px !important;
            }

            .hp-home .hp-hero-metrics {
                padding-top: 13px !important;
            }

            .hp-home .hp-hero-metric,
            .hp-home .hp-hero-metric:first-child,
            .hp-home .hp-hero-metric:last-child {
                gap: 7px !important;
                min-height: 118px !important;
                padding: 16px 8px !important;
            }

            .hp-home .hp-hero-metric-icon {
                width: 48px !important;
                height: 48px !important;
                margin-bottom: 8px !important;
            }

            .hp-home .hp-hero-metric strong {
                font-size: 1.28rem !important;
                line-height: 1.1 !important;
            }

            .hp-home .hp-hero-metric span {
                font-size: 0.78rem !important;
                line-height: 1.6 !important;
            }

            .hp-home .hp-market-track {
                padding: 8px 0 !important;
            }

            .hp-home .hp-modes,
            .hp-home .hp-trust,
            .hp-home .hp-platform,
            .hp-home .hp-testimonials,
            .hp-home .hp-final-cta {
                padding-top: 35px !important;
                padding-bottom: 29px !important;
            }

            .hp-home .hp-features-highlight {
                padding: 19px 0 !important;
            }

            .hp-home .hp-features-strip {
                gap: 16px 6px !important;
            }

            .hp-home .hp-feature-item {
                padding: 10px 13px !important;
            }

            .hp-home .hp-mode-content-stack,
            .hp-home .hp-trust-visual-area {
                width: min(calc(100vw - 20px), 544px) !important;
                gap: 14px !important;
            }

            .hp-home .hp-mode-tabs {
                border-bottom-width: 1px !important;
            }

            .hp-home .hp-mode-trigger {
                padding: 0 6px 10px !important;
                font-size: clamp(0.58rem, 2.3vw, 0.7rem) !important;
            }

            .hp-home .hp-mode-mobile-visual,
            .hp-home .hp-trust-visual-area > img,
            .hp-home .hp-platform-visual,
            .hp-home .hp-final-cta-scene {
                border-radius: 16px !important;
            }

            .hp-home .hp-mode-mobile-visual,
            .hp-home .hp-trust-visual-area > img {
                width: 100% !important;
                max-width: none !important;
                aspect-ratio: 1.38 !important;
                margin-inline: auto !important;
            }

            .hp-home .hp-trust-copy-area,
            .hp-home .hp-final-cta-scene {
                padding: 14px !important;
                border-radius: 16px !important;
            }

            .hp-home .hp-trust-point,
            .hp-home .hp-platform-point,
            .hp-home .hp-testimonial-stat,
            .hp-home .hp-review-mini,
            .hp-home .hp-review-form-shell,
            .hp-home .hp-risk-text {
                padding: 11px !important;
                border-radius: 10px !important;
            }

            .hp-home .hp-trust-point-icon {
                width: 38px !important;
                height: 38px !important;
            }

            .hp-home .hp-trust-tech-strip,
            .hp-home .hp-platform-points,
            .hp-home .hp-testimonial-stats,
            .hp-home .hp-testimonial-track {
                gap: 6px !important;
            }

            .hp-home .hp-trust-tech-strip span {
                padding: 8px 6px !important;
                border-radius: 10px !important;
                font-size: 0.58rem !important;
            }

            .hp-home .hp-review-mini {
                min-height: 184px !important;
            }

            .hp-home .hp-final-cta-title {
                font-size: 1.18rem !important;
                line-height: 1.4 !important;
            }

            .hp-home .hp-risk-strip {
                padding: 13px 0 43px !important;
            }
        }

        .hp-home .hp-mode-trigger.is-active {
            color: var(--hp-teal) !important;
        }

        @media (max-width: 767.98px) {
            .hp-home .hp-mode-trigger {
                font-size: clamp(0.95rem, 4vw, 1.12rem) !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="hp-home">
        <aside class="hp-auth-sidebar" aria-label="{{ auth()->check() ? 'لوحة الحساب' : 'تسجيل الدخول وفتح حساب' }}">
            @auth
                @php
                    $accountUser = auth()->user();
                    $accountAvatar = $accountUser->image
                        ? ($accountUser->getStorageUrl($accountUser->image) ?? asset('assets/images/default-pfp.webp'))
                        : asset('assets/images/default-pfp.webp');
                    $accountLinks = [
                        ['label' => 'الملف الشخصي', 'icon' => 'profile', 'url' => route('profile')],
                        ['label' => 'الإيداع', 'icon' => 'wallet', 'url' => route('site.deposit')],
                        ['label' => 'السحب', 'icon' => 'transfer', 'url' => route('site.transactions-requests.create', ['t' => 'w'])],
                        ['label' => 'إشعارات', 'icon' => 'bell', 'url' => route('site.notifications.index')],
                        ['label' => 'الدعم', 'icon' => 'support', 'url' => route('site.messages.index')],
                        ['label' => 'الإعدادات', 'icon' => 'settings', 'url' => route('profile') . '#profileSecurity'],
                    ];
                @endphp

                <div class="hp-account-sidebar">
                    <div class="hp-account-profile">
                        <div class="hp-account-avatar">
                            <img src="{{ $accountAvatar }}" alt="{{ $accountUser->full_name }}">
                        </div>
                        <div>
                            <h2 class="hp-account-name">{{ $accountUser->full_name ?: 'عميل' }}</h2>
                            <div class="hp-account-meta">
                                <span>id {{ $accountUser->id }}</span>
                                <span>{{ $accountUser->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="hp-account-balance">
                        <span>{{ formatCurrency($accountUser->deposit_balance ?? 0) }}</span>
                        <x-niro-icon name="wallet" />
                    </div>

                    <div class="hp-account-actions">
                        <a href="{{ route('site.trading') }}" class="hp-account-action hp-account-action--primary">تداول الآن</a>
                        <a href="{{ route('site.deposit') }}" class="hp-account-action">الإيداع</a>
                    </div>

                    <ul class="hp-account-nav">
                        @foreach ($accountLinks as $accountLink)
                            <li>
                                <a href="{{ $accountLink['url'] }}" class="hp-account-nav-link">
                                    <x-niro-icon :name="$accountLink['icon']" />
                                    <span>{{ $accountLink['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="hp-account-logout">
                        <a href="{{ route('logout') }}" class="hp-account-nav-link">
                            <x-niro-icon name="logout" />
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>

                    @if ($homeSidebarSocialLinks)
                        <div class="hp-account-socials">
                            <div class="hp-auth-socials">
                                <span>تابعنا على:</span>
                                <div>
                                    @foreach ($homeSidebarSocialLinks as $link)
                                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener" aria-label="{{ $link['label'] }}">
                                            <i class="{{ $link['icon'] }}"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="hp-auth-tabs" role="tablist" aria-label="Authentication">
                    <button type="button" class="hp-auth-tab is-active" data-auth-sidebar-tab="register"
                        aria-selected="true">افتح حسابك</button>
                    <button type="button" class="hp-auth-tab" data-auth-sidebar-tab="login"
                        aria-selected="false">تسجيل الدخول</button>
                </div>

                <div class="hp-auth-sidebar-scroll">
                    <form method="POST" action="{{ route('register') }}" class="hp-auth-panel is-active"
                        data-auth-sidebar-panel="register">
                        @csrf
                        <input type="hidden" name="referral_id" value="{{ request('ref') }}">

                        <div class="hp-auth-field-grid">
                            <label>
                                <span>الاسم الأول</span>
                                <input name="first_name" type="text" value="{{ old('first_name') }}" required>
                            </label>
                            <label>
                                <span>الاسم الثاني</span>
                                <input name="last_name" type="text" value="{{ old('last_name') }}" required>
                            </label>
                        </div>

                        <label>
                            <span>تاريخ الميلاد</span>
                            <input id="hpAuthBirthdate" name="birthdate" type="text" placeholder="MM/DD/YYYY" value="{{ old('birthdate') }}"
                                maxlength="10" inputmode="numeric" dir="ltr" required>
                        </label>

                        <label>
                            <span>البريد الإلكتروني</span>
                            <input name="email" type="email" value="{{ old('email') }}" required>
                        </label>

                        <div class="hp-auth-field-grid hp-auth-field-grid--phone">
                            <label>
                                <span>رمز الدولة</span>
                                <input name="country_code" type="text" value="{{ old('country_code', '+963') }}"
                                    dir="ltr" required>
                            </label>
                            <label>
                                <span>رقم الموبايل</span>
                                <input name="phone" type="tel" value="{{ old('phone') }}" dir="ltr" required>
                            </label>
                        </div>

                        <label>
                            <span>كلمة المرور</span>
                            <input name="password" type="password" required>
                        </label>

                        <label>
                            <span>تأكيد كلمة المرور</span>
                            <input name="password_confirmation" type="password" required>
                        </label>

                        <label class="hp-auth-check">
                            <input type="checkbox" name="accept" required>
                            <span>
                                أوافق على
                                <a href="{{ route('terms') }}" target="_blank" rel="noopener">اتفاقية استخدام الموقع</a>
                            </span>
                        </label>

                        <button type="submit" class="hp-auth-submit">فتح حساب جديد</button>
                    </form>

                    <form method="POST" action="{{ route('login') }}" class="hp-auth-panel"
                        data-auth-sidebar-panel="login" hidden>
                        @csrf
                        <label>
                            <span>البريد الإلكتروني أو رقم الهاتف</span>
                            <input name="identifier" type="text" value="{{ old('identifier') }}" required>
                        </label>

                        <label>
                            <span>كلمة المرور</span>
                            <input name="password" type="password" required>
                        </label>

                        <label class="hp-auth-check">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>تذكرني</span>
                        </label>

                        <button type="submit" class="hp-auth-submit">دخول إلى المنصة</button>
                        <a href="{{ route('password.request') }}" class="hp-auth-muted-link">هل نسيت كلمة المرور؟</a>
                    </form>
                </div>

                @if ($homeSidebarSocialLinks)
                    <div class="hp-auth-socials">
                        <span>Follow us on:</span>
                        <div>
                            @foreach ($homeSidebarSocialLinks as $link)
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener" aria-label="{{ $link['label'] }}">
                                    <i class="{{ $link['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth
        </aside>

        <section class="hp-editorial-hero">
            <div class="container">
                <div class="hp-hero-grid">
                    <div class="hp-hero-copy">

                        <h1 class="hp-hero-title">
                            ابدأ رحلتك في عالم التداول
                            <span class="hp-tone-teal">الذكي</span>
                            مع {{ appName() }}
                        </h1>

                        <p class="hp-hero-sub">
                            نوفر لك الأدوات الاحترافية والخبرات اللازمة لتحويل أهدافك المالية إلى واقع ملموس، عبر
                            التكنولوجيا المتطورة وبيئات التداول الشفافة.
                        </p>

                        <div class="hp-hero-actions">
                            @auth
                                <a href="{{ route('site.trading') }}" class="hp-btn-primary">الدخول إلى المنصة</a>
                            @else
                                <a href="{{ route('register') }}" class="hp-btn-primary">افتح حساب حقيقي</a>
                                <a href="{{ route('demo.login') }}" class="hp-btn-secondary">ابدأ بحساب تجريبي</a>
                            @endauth
                        </div>

                        <div class="hp-hero-metrics mt-4" data-hero-metrics>
                            @foreach ($heroMetrics as $metric)
                                <button type="button" class="hp-hero-metric" data-hero-metric-trigger="{{ $metric['id'] }}"
                                    aria-expanded="false" aria-controls="hpHeroMetricPanel-{{ $metric['id'] }}">
                                    @if(isset($metric['icon']))
                                        <div class="hp-hero-metric-icon">
                                            @if(str_contains($metric['icon'], '<svg'))
                                                {!! $metric['icon'] !!}
                                            @else
                                                <img src="{{ $metric['icon'] }}" alt="{{ $metric['label'] }}">
                                            @endif
                                        </div>
                                    @endif
                                    <strong class="hp-number">{{ $metric['value'] }}</strong>
                                    <div>
                                        <span>{{ $metric['label'] }}</span>
                                        <small>{{ $metric['note'] }}</small>
                                    </div>
                                </button>
                            @endforeach

                            @foreach ($heroMetrics as $metric)
                                @php $detail = $heroMetricDetails[$metric['id']] ?? null; @endphp
                                @if ($detail)
                                    <div class="hp-hero-metric-panel" id="hpHeroMetricPanel-{{ $metric['id'] }}"
                                        data-hero-metric-panel="{{ $metric['id'] }}" role="region"
                                        aria-label="{{ $detail['title'] }}" hidden>
                                        <div class="hp-hero-metric-panel-inner">
                                            <div class="hp-hero-metric-panel-head">
                                                <strong>{{ $detail['title'] }}</strong>
                                                <span>{{ $detail['lead'] }}</span>
                                            </div>

                                            @if (!empty($detail['cards']))
                                                <div class="hp-hero-metric-mode-grid">
                                                    @foreach ($detail['cards'] as $card)
                                                        <article class="hp-hero-metric-mode-card">
                                                            <h3>{{ $card['name'] }}</h3>
                                                            <p>{{ $card['desc'] }}</p>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="hp-hero-metric-panel-desc">{{ $detail['desc'] }}</p>
                                                <ul class="hp-hero-metric-panel-list">
                                                    @foreach ($detail['points'] as $point)
                                                        <li>{{ $point }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="hp-market-ribbon" aria-label="Live market snapshots">
            <div class="hp-ticker-viewport" dir="ltr">
                <div class="hp-ticker-track">
                    @php $dataLoop = 12; @endphp
                    @for ($duplicate = 0; $duplicate < 2; $duplicate++)
                        <div class="hp-ticker-half" aria-hidden="{{ $duplicate > 0 ? 'true' : 'false' }}">
                            @for ($i = 0; $i < $dataLoop; $i++)
                                @foreach ($marketStrip as $item)
                                    @php
                                        $isUp = str_contains($item['change'] ?? '', '+');
                                    @endphp
                                    <div class="hp-market-item {{ $isUp ? 'is-up' : 'is-down' }}">
                                        <span class="hp-market-symbol">{{ $item['symbol'] }}</span>
                                        <span class="hp-market-price hp-latin">{{ $item['price'] }}</span>
                                        <span class="hp-market-change hp-latin">{{ $item['change'] }}</span>
                                    </div>
                                @endforeach
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <section class="hp-features-highlight" aria-label="Core Advantages">
            <div class="container">
                <h2 class="hp-section-title text-center hp-reveal" style="font-size: 1.75rem; margin-bottom: 64px;">
                    لماذا تختار <span class="hp-tone-teal">@include('includes.logo', ['asText' => true])</span>؟
                </h2>

                <div class="hp-features-strip hp-stagger">
                    <div class="hp-feature-item">
                        <div class="hp-feature-icon">
                            <img src="{{ asset('assets/images/icons/IMG_7725.svg') }}" alt="Security Icon" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <h3 class="hp-feature-title">أمان عالي</h3>
                        <p class="hp-feature-desc">حماية متقدمة لأموالك ومعلوماتك الشخصية</p>
                    </div>

                    <div class="hp-feature-item">
                        <div class="hp-feature-icon">
                            <img src="{{ asset('assets/images/icons/IMG_7726.svg') }}" alt="تنفيذ سريع">
                        </div>
                        <h3 class="hp-feature-title">تنفيذ سريع</h3>
                        <p class="hp-feature-desc">سرعة فائقة في تنفيذ الصفقات</p>
                    </div>

                    <div class="hp-feature-item">
                        <div class="hp-feature-icon">
                            <img src="{{ asset('assets/images/new-icons/IMG_7722.svg') }}" alt="أنماط تشغيل">
                        </div>
                        <h3 class="hp-feature-title">أدوات احترافية</h3>
                        <p class="hp-feature-desc">مجموعة متكاملة من الأدوات التحليلية المتطورة</p>
                    </div>

                    <div class="hp-feature-item">
                        <div class="hp-feature-icon">
                            <img src="{{ asset('assets/images/icons/IMG_7723.svg') }}" alt="دعم على مدار الساعة">
                        </div>
                        <h3 class="hp-feature-title">دعم على مدار الساعة</h3>
                        <p class="hp-feature-desc">فريق دعم متخصص متاح على مدار 24/7</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-modes" id="journeys">
            <div class="container">
                <div class="hp-mode-shell hp-reveal">
                    <div class="hp-mode-reference-layout">
                        <div class="hp-mode-art-space" aria-hidden="true"></div>

                        <div class="hp-mode-content-stack">
                            <div class="hp-section-head">
                                <span class="hp-kicker">النمط التشغيلي</span>
                                <h2 class="hp-section-title hp-section-title--md">
                                    اختر الطريقة التي
                                    <span class="hp-tone-teal">تتناسب مع أهدافك</span>
                                </h2>
                            </div>

                            <div class="hp-mode-tabs" role="tablist" aria-label="Trading modes">
                                @foreach ($tradingModes as $mode)
                                    @php $isModeActive = $mode['id'] === $defaultTradingMode; @endphp
                                    <button type="button" class="hp-mode-trigger {{ $isModeActive ? 'is-active' : '' }}"
                                        data-mode-trigger="{{ $mode['id'] }}" role="tab"
                                        aria-selected="{{ $isModeActive ? 'true' : 'false' }}">
                                        {{ $mode['tab'] ?? $mode['title'] }}
                                    </button>
                                @endforeach
                            </div>

                            <div class="hp-mode-carousel" aria-label="أنماط التشغيل">
                                <div class="hp-mode-panels">
                                    @foreach ($tradingModes as $mode)
                                        @php $isModeActive = $mode['id'] === $defaultTradingMode; @endphp
                                        <article class="hp-mode-panel {{ $isModeActive ? 'is-active' : '' }}"
                                            data-mode-panel="{{ $mode['id'] }}">
                                            <figure class="hp-mode-mobile-visual">
                                                <img src="{{ $mode['image'] }}" alt="{{ $mode['title'] }} with {{ appName() }}">
                                            </figure>
                                            <div class="hp-mode-copy">
                                                <h3 class="hp-mode-title">{{ $mode['title'] }}</h3>
                                                <p class="hp-mode-summary">{{ $mode['summary'] }}</p>
                                                @foreach ($mode['paragraphs'] as $paragraph)
                                                    <p class="hp-mode-desc">{{ $paragraph }}</p>
                                                @endforeach
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-trust">
            <div class="container">
                <div class="hp-trust-layout">
                    <div class="hp-trust-visual-area">
                        <img src="{{ $homeMedia['trustVisual'] }}" alt="{{ appName() }} secure trading environment">

                        <div class="hp-trust-copy-area hp-reveal">
                            <span class="hp-kicker">الأمان والموثوقية</span>
                            <h2 class="hp-section-title hp-section-title--md">بيئات تداول آمنة</h2>
                            <div class="hp-trust-points">
                                @foreach ($trustPoints as $point)
                                    <article class="hp-trust-point">
                                        <div class="hp-trust-point-icon">
                                            @if ($point['icon'])
                                                <img src="{{ $point['icon'] }}" alt="{{ $point['title'] }}">
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $point['title'] }}</strong>
                                            <p>{{ $point['desc'] }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="hp-trust-tech-strip" aria-label="تقنيات التداول">
                                <span>سيولة عالية <i class="fa-solid fa-coins"></i></span>
                                <span>تحليل فوري <i class="fa-solid fa-chart-column"></i></span>
                                <span>أدوات احترافية <i class="fa-solid fa-gear"></i></span>
                                <span>تنفيذ سريع <i class="fa-solid fa-bolt"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-platform">
            <div class="container">
                <div class="hp-platform-story">
                    <figure class="hp-platform-visual hp-slide-in-end">
                        <div class="hp-platform-labels">
                            <span class="hp-platform-label">لوحة موحدة للمتابعة والتنفيذ</span>
                            <span class="hp-platform-label">تجربة تعمل بسلاسة على مختلف الأجهزة</span>
                        </div>
                        <img src="{{ $homeMedia['platformVisual'] }}" alt="{{ appName() }} devices and platform preview">

                    </figure>

                    <div class="hp-platform-copy hp-slide-in-start">
                        <span class="hp-kicker">تقنيات التداول</span>
                        <h2 class="hp-section-title hp-section-title--md">منصة واحدة لكل أدواتك</h2>

                        <div class="hp-platform-points hp-stagger mt-5">
                            @foreach ($platformStories as $story)
                                <article class="hp-platform-point">
                                    <span class="hp-platform-point-index">{{ $story['index'] }}</span>
                                    <div>
                                        <strong>{{ $story['title'] }}</strong>
                                        <p>{{ $story['desc'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-testimonials">
            <div class="container">
                <div class="hp-section-head hp-reveal">
                    <span class="hp-kicker">آراء وتجارب حقيقية</span>
                    <h2 class="hp-section-title hp-section-title--md">ماذا يقول الناس عنا</h2>
                    <p class="hp-section-desc">
                        آراء المستخدمين تعكس ما يهم فعلاً في التجربة: وضوح الواجهة، سهولة المتابعة، وثقة أكبر عند
                        اتخاذ القرار اليومي.
                    </p>
                </div>

                <div class="hp-testimonial-stats hp-reveal">
                    <div class="hp-testimonial-stat">
                        <strong class="hp-number">{{ $averageRating }}</strong>
                        <span>متوسط التقييم</span>
                    </div>
                    <div class="hp-testimonial-stat">
                        <strong class="hp-number">{{ $reviewCount }}</strong>
                        <span>مراجعة منشورة</span>
                    </div>
                    <div class="hp-testimonial-stat">
                        <strong class="hp-number">24/7</strong>
                        <span>تجربة ودعم مستمران</span>
                    </div>
                </div>

                <div class="hp-testimonial-layout" aria-label="آراء العملاء">
                    <button type="button" class="hp-testimonial-nav hp-testimonial-nav--prev"
                        data-testimonial-prev aria-label="التقييم السابق">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <div class="hp-testimonial-track">
                        <article class="hp-testimonial-slide hp-review-mini is-active" data-testimonial-slide>
                            <div class="hp-review-stars" aria-label="تقييم المراجعة">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        class="hp-star">{{ $i <= (int) data_get($featuredReview, 'rating', 5) ? '★' : '☆' }}</span>
                                @endfor
                            </div>

                            <p class="hp-review-mini-text" dir="auto">
                                "{{ data_get($featuredReview, 'text', 'تجربة المنصة أصبحت أوضح وأهدأ، وهذا ما يجعل القرار أسرع وأسهل في المتابعة اليومية.') }}"
                            </p>

                            <div class="hp-review-author">
                                <div class="hp-review-avatar">
                                    {{ mb_substr((string) data_get($featuredReview, 'name', appName() . ' User'), 0, 1) }}</div>
                                <div class="hp-review-author-copy">
                                    <strong
                                        dir="auto">{{ data_get($featuredReview, 'name', 'مستخدم من ' . appName()) }}</strong>
                                    <span>{{ data_get($featuredReview, 'date', 'حديثاً') }}</span>
                                </div>
                            </div>
                        </article>

                        @foreach ($supportingReviews as $review)
                            <article class="hp-testimonial-slide hp-review-mini" data-testimonial-slide>
                                <div class="hp-review-stars" aria-label="تقييم المراجعة">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span
                                            class="hp-star">{{ $i <= (int) data_get($review, 'rating', 5) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>

                                <p class="hp-review-mini-text" dir="auto">
                                    "{{ data_get($review, 'text', 'تجربة موثوقة وتنفيذ واضح للمستخدم.') }}"
                                </p>

                                <div class="hp-review-author">
                                    <div class="hp-review-avatar">
                                        {{ mb_substr((string) data_get($review, 'name', 'N'), 0, 1) }}</div>
                                    <div class="hp-review-author-copy">
                                        <strong
                                            dir="auto">{{ data_get($review, 'name', 'مستخدم من ' . appName()) }}</strong>
                                        <span>{{ data_get($review, 'date', 'حديثاً') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="hp-testimonial-dots" aria-label="موضع التقييم">
                        @foreach ($displayReviews as $review)
                            <button type="button" class="hp-testimonial-dot {{ $loop->first ? 'is-active' : '' }}"
                                data-testimonial-dot="{{ $loop->index }}"
                                aria-label="التقييم {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>

                    <button type="button" class="hp-testimonial-nav hp-testimonial-nav--next"
                        data-testimonial-next aria-label="التقييم التالي">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </div>

                @auth
                    @if (($reviewsFeatureEnabled ?? false))
                        @if (!($userHasReview ?? false))
                            <div class="hp-review-form-shell">
                                <h4 class="hp-review-form-title">أضف تقييمك</h4>
                                <p class="hp-review-form-subtitle">
                                    شاركنا رأيك في المنصة، وما الذي تريد أن نطوره أكثر في التجربة القادمة.
                                </p>

                                <form action="{{ route('site.reviews.store') }}" method="POST">
                                    @csrf

                                    <label class="hp-user-review-label">تقييمك</label>
                                    <div class="hp-star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label>
                                                <input type="radio" name="rating" value="{{ $i }}" {{ (int) old('rating', 5) === $i ? 'checked' : '' }}>
                                                <span class="hp-star-rating-symbol">★</span>
                                            </label>
                                        @endfor
                                    </div>

                                    <label class="hp-user-review-label" for="homeReviewText">ملاحظاتك</label>
                                    <textarea id="homeReviewText" name="text" rows="4" required maxlength="500"
                                        class="hp-user-review-field"
                                        placeholder="اكتب رأيك عن المنصة...">{{ old('text') }}</textarea>

                                    <button type="submit" class="hp-btn-primary mt-3 w-100">إرسال التقييم</button>
                                </form>
                            </div>
                        @else
                            <div class="hp-user-review-status">
                                <x-niro-icon name="status" class="niro-icon--current" />
                                لقد قمت بإضافة تقييمك بالفعل. شكراً لك!
                            </div>
                        @endif
                    @endif
                @endauth
            </div>
        </section>

        <section class="hp-final-cta">
            <div class="container">
                <div class="hp-final-cta-scene">
                    <div class="hp-final-cta-copy">
                        <span class="hp-kicker">جاهز للخطوة التالية؟</span>
                        <h2 class="hp-final-cta-title">ابدأ الآن خلال دقائق وتحكم في مستقبلك المالي</h2>
                        <p class="hp-final-cta-desc">
                            انضم إلى منصة {{ appName() }} اليوم واستفد من أحدث تقنيات التحليل، أدوات التنفيذ
                            الاحترافية، وبيئة التداول المتكاملة التي صممت لتواكب تطلعاتك.
                        </p>

                        <div class="hp-final-cta-actions">
                            @auth
                                <a href="{{ route('site.trading') }}" class="hp-btn-primary">الدخول إلى المنصة</a>
                            @else
                                <a href="{{ route('register') }}" class="hp-btn-primary">افتح حساب حقيقي</a>
                                <a href="{{ route('demo.login') }}" class="hp-btn-secondary">ابدأ بحساب تجريبي</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="hp-risk-strip">
            <div class="container">
                <p class="hp-risk-text">
                    تنبيه المخاطر: التداول في الأسواق المالية ينطوي على مخاطر عالية وقد لا يكون مناسباً لجميع
                    المستثمرين. يرجى التأكد من فهمك للمخاطر بالكامل قبل البدء.
                </p>
            </div>
        </section>
    </div>
@endsection

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* ── Scroll Reveal via IntersectionObserver ── */
            var animatedEls = document.querySelectorAll('.hp-reveal, .hp-stagger, .hp-slide-in-start, .hp-slide-in-end');
            if ('IntersectionObserver' in window && animatedEls.length) {
                var revealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            revealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

                animatedEls.forEach(function (el) {
                    revealObserver.observe(el);
                });
            } else {
                /* Fallback: just show everything */
                animatedEls.forEach(function (el) {
                    el.classList.add('is-visible');
                });
            }

            /* ── Hero metric panels ── */
            const heroMetricShell = document.querySelector('[data-hero-metrics]');
            const heroMetricTriggers = Array.from(document.querySelectorAll('[data-hero-metric-trigger]'));
            const heroMetricPanels = Array.from(document.querySelectorAll('[data-hero-metric-panel]'));
            let activeHeroMetric = null;
            let heroMetricCloseTimer = null;

            const closeHeroMetricPanels = function () {
                activeHeroMetric = null;
                if (heroMetricCloseTimer) {
                    clearTimeout(heroMetricCloseTimer);
                    heroMetricCloseTimer = null;
                }
                heroMetricTriggers.forEach(function (trigger) {
                    trigger.classList.remove('is-active');
                    trigger.setAttribute('aria-expanded', 'false');
                });
                heroMetricPanels.forEach(function (panel) {
                    panel.classList.remove('is-open');
                });

                heroMetricCloseTimer = setTimeout(function () {
                    heroMetricPanels.forEach(function (panel) {
                        if (!panel.classList.contains('is-open')) {
                            panel.hidden = true;
                        }
                    });
                    heroMetricCloseTimer = null;
                }, 280);
            };

            const activateHeroMetric = function (metricId) {
                if (activeHeroMetric === metricId) {
                    closeHeroMetricPanels();
                    return;
                }

                activeHeroMetric = metricId;
                if (heroMetricCloseTimer) {
                    clearTimeout(heroMetricCloseTimer);
                    heroMetricCloseTimer = null;
                }
                heroMetricTriggers.forEach(function (trigger) {
                    const isActive = trigger.getAttribute('data-hero-metric-trigger') === metricId;
                    trigger.classList.toggle('is-active', isActive);
                    trigger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
                });
                heroMetricPanels.forEach(function (panel) {
                    const isTargetPanel = panel.getAttribute('data-hero-metric-panel') === metricId;
                    panel.classList.remove('is-open');
                    panel.hidden = !isTargetPanel;
                    if (isTargetPanel) {
                        window.requestAnimationFrame(function () {
                            panel.classList.add('is-open');
                        });
                    }
                });
            };

            heroMetricTriggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    activateHeroMetric(trigger.getAttribute('data-hero-metric-trigger'));
                });

                trigger.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeHeroMetricPanels();
                    }
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeHeroMetricPanels();
                }
            });

            document.addEventListener('click', function (event) {
                if (!activeHeroMetric || !heroMetricShell || heroMetricShell.contains(event.target)) return;
                closeHeroMetricPanels();
            });

            /* ── Desktop auth sidebar tabs ── */
            const authSidebarTabs = Array.from(document.querySelectorAll('[data-auth-sidebar-tab]'));
            const authSidebarPanels = Array.from(document.querySelectorAll('[data-auth-sidebar-panel]'));

            const activateAuthSidebarPanel = function (panelId) {
                authSidebarTabs.forEach(function (tab) {
                    const isActive = tab.getAttribute('data-auth-sidebar-tab') === panelId;
                    tab.classList.toggle('is-active', isActive);
                    tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                authSidebarPanels.forEach(function (panel) {
                    panel.hidden = panel.getAttribute('data-auth-sidebar-panel') !== panelId;
                    panel.classList.toggle('is-active', panel.getAttribute('data-auth-sidebar-panel') === panelId);
                });
            };

            authSidebarTabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    activateAuthSidebarPanel(tab.getAttribute('data-auth-sidebar-tab'));
                });
            });

            /* ── Sidebar birthdate mask: matches /register behavior ── */
            const hpAuthBirthdateInput = document.getElementById('hpAuthBirthdate');

            if (hpAuthBirthdateInput) {
                const birthdateTemplate = 'MM/DD/YYYY';
                const birthdateSlots = [0, 1, 3, 4, 6, 7, 8, 9];
                const extractBirthdateDigits = function (value) {
                    return value.replace(/\D/g, '').substring(0, 8);
                };

                const buildBirthdateMask = function (digits) {
                    const chars = birthdateTemplate.split('');
                    birthdateSlots.forEach(function (slotIndex, digitIndex) {
                        if (digits[digitIndex]) {
                            chars[slotIndex] = digits[digitIndex];
                        }
                    });

                    return digits.length ? chars.join('') : '';
                };

                const caretToDigitIndex = function (caretPosition) {
                    return birthdateSlots.filter(function (slot) {
                        return slot < caretPosition;
                    }).length;
                };

                const setBirthdateCaret = function (digitsLength) {
                    const nextSlot = digitsLength >= birthdateSlots.length
                        ? birthdateTemplate.length
                        : birthdateSlots[digitsLength];

                    window.requestAnimationFrame(function () {
                        hpAuthBirthdateInput.setSelectionRange(nextSlot, nextSlot);
                    });
                };

                const syncBirthdateMask = function (digits, moveCaret = true) {
                    const safeDigits = extractBirthdateDigits(digits);
                    hpAuthBirthdateInput.value = safeDigits.length ? buildBirthdateMask(safeDigits) : '';

                    if (moveCaret && document.activeElement === hpAuthBirthdateInput) {
                        setBirthdateCaret(safeDigits.length);
                    }
                };

                if (hpAuthBirthdateInput.value) {
                    syncBirthdateMask(hpAuthBirthdateInput.value, false);
                }

                hpAuthBirthdateInput.addEventListener('focus', function () {
                    const digits = extractBirthdateDigits(this.value);

                    if (!digits.length) {
                        this.value = birthdateTemplate;
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    syncBirthdateMask(digits);
                });

                hpAuthBirthdateInput.addEventListener('click', function () {
                    const digits = extractBirthdateDigits(this.value);
                    if (!digits.length) {
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    const digitIndex = Math.min(caretToDigitIndex(this.selectionStart ?? 0), digits.length);
                    setBirthdateCaret(digitIndex);
                });

                hpAuthBirthdateInput.addEventListener('keydown', function (event) {
                    const key = event.key;
                    const digits = extractBirthdateDigits(this.value);
                    const caretPosition = this.selectionStart ?? 0;
                    const digitIndex = caretToDigitIndex(caretPosition);

                    if (/^\d$/.test(key)) {
                        event.preventDefault();

                        if (digits.length >= 8) {
                            return;
                        }

                        const updatedDigits = (digits.slice(0, digitIndex) + key + digits.slice(digitIndex)).substring(0, 8);
                        syncBirthdateMask(updatedDigits, false);
                        setBirthdateCaret(Math.min(digitIndex + 1, updatedDigits.length));
                        return;
                    }

                    if (key === 'Backspace') {
                        event.preventDefault();

                        if (!digits.length) {
                            this.value = '';
                            return;
                        }

                        const removeIndex = Math.max(0, digitIndex - 1);
                        const updatedDigits = digits.slice(0, removeIndex) + digits.slice(removeIndex + 1);
                        syncBirthdateMask(updatedDigits, false);

                        if (!updatedDigits.length) {
                            this.value = '';
                            return;
                        }

                        setBirthdateCaret(removeIndex);
                        return;
                    }

                    if (key === 'Delete') {
                        event.preventDefault();

                        if (!digits.length) {
                            this.value = '';
                            return;
                        }

                        const updatedDigits = digits.slice(0, digitIndex) + digits.slice(digitIndex + 1);
                        syncBirthdateMask(updatedDigits, false);

                        if (!updatedDigits.length) {
                            this.value = '';
                            return;
                        }

                        setBirthdateCaret(Math.min(digitIndex, updatedDigits.length));
                        return;
                    }

                    if (key === 'ArrowLeft') {
                        event.preventDefault();
                        setBirthdateCaret(Math.max(0, digitIndex - 1));
                        return;
                    }

                    if (key === 'ArrowRight') {
                        event.preventDefault();
                        setBirthdateCaret(Math.min(digits.length, digitIndex + 1));
                        return;
                    }

                    if (key === 'Home') {
                        event.preventDefault();
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    if (key === 'End') {
                        event.preventDefault();
                        setBirthdateCaret(digits.length);
                    }
                });

                hpAuthBirthdateInput.addEventListener('paste', function (event) {
                    event.preventDefault();
                    const pastedText = event.clipboardData?.getData('text') ?? '';
                    const digits = extractBirthdateDigits(pastedText);
                    syncBirthdateMask(digits, false);

                    if (digits.length) {
                        setBirthdateCaret(digits.length);
                    }
                });

                hpAuthBirthdateInput.addEventListener('input', function () {
                    const digits = extractBirthdateDigits(this.value);
                    syncBirthdateMask(digits);
                });

                hpAuthBirthdateInput.addEventListener('blur', function () {
                    const digits = extractBirthdateDigits(this.value);
                    this.value = digits.length ? buildBirthdateMask(digits) : '';
                });
            }

            /* ── Mode tabs ── */
            const modeTriggers = Array.from(document.querySelectorAll('[data-mode-trigger]'));
            const modePanels = Array.from(document.querySelectorAll('[data-mode-panel]'));

            const activateMode = function (modeId) {
                modeTriggers.forEach(function (trigger) {
                    const isActive = trigger.getAttribute('data-mode-trigger') === modeId;
                    trigger.classList.toggle('is-active', isActive);
                    trigger.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });

                modePanels.forEach(function (panel) {
                    panel.classList.toggle('is-active', panel.getAttribute('data-mode-panel') === modeId);
                });
            };

            modeTriggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    activateMode(trigger.getAttribute('data-mode-trigger'));
                });
            });

            /* ── Testimonial carousel ── */
            const testimonialSlides = Array.from(document.querySelectorAll('[data-testimonial-slide]'));
            const testimonialDots = Array.from(document.querySelectorAll('[data-testimonial-dot]'));
            const testimonialTrack = document.querySelector('.hp-testimonial-track');
            const testimonialPrevButton = document.querySelector('[data-testimonial-prev]');
            const testimonialNextButton = document.querySelector('[data-testimonial-next]');
            let activeTestimonialIndex = 0;
            let testimonialTouchStartX = 0;
            let testimonialAutoTimer = null;

            const activateTestimonial = function (index) {
                if (!testimonialSlides.length) return;

                activeTestimonialIndex = (index + testimonialSlides.length) % testimonialSlides.length;
                testimonialTrack?.style.setProperty('--testimonial-index', activeTestimonialIndex);
                testimonialSlides.forEach(function (slide, slideIndex) {
                    slide.classList.toggle('is-active', slideIndex === activeTestimonialIndex);
                });
                testimonialDots.forEach(function (dot, dotIndex) {
                    dot.classList.toggle('is-active', dotIndex === activeTestimonialIndex);
                });
            };

            const stopTestimonialAuto = function () {
                if (!testimonialAutoTimer) return;
                window.clearInterval(testimonialAutoTimer);
                testimonialAutoTimer = null;
            };

            const startTestimonialAuto = function () {
                stopTestimonialAuto();
                if (testimonialSlides.length < 2) return;

                testimonialAutoTimer = window.setInterval(function () {
                    activateTestimonial(activeTestimonialIndex + 1);
                }, 3000);
            };

            const restartTestimonialAuto = function () {
                startTestimonialAuto();
            };

            activateTestimonial(activeTestimonialIndex);
            startTestimonialAuto();

            testimonialPrevButton?.addEventListener('click', function () {
                activateTestimonial(activeTestimonialIndex - 1);
                restartTestimonialAuto();
            });

            testimonialNextButton?.addEventListener('click', function () {
                activateTestimonial(activeTestimonialIndex + 1);
                restartTestimonialAuto();
            });

            testimonialDots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    activateTestimonial(Number(dot.getAttribute('data-testimonial-dot') || 0));
                    restartTestimonialAuto();
                });
            });

            testimonialTrack?.addEventListener('touchstart', function (event) {
                testimonialTouchStartX = event.changedTouches[0]?.clientX || 0;
            }, { passive: true });

            testimonialTrack?.addEventListener('touchend', function (event) {
                const touchEndX = event.changedTouches[0]?.clientX || 0;
                const deltaX = touchEndX - testimonialTouchStartX;

                if (Math.abs(deltaX) < 42) return;

                activateTestimonial(deltaX > 0 ? activeTestimonialIndex - 1 : activeTestimonialIndex + 1);
                restartTestimonialAuto();
            }, { passive: true });

            /* ── Star rating paint ── */
            document.querySelectorAll('.hp-star-rating').forEach(function (group) {
                const radios = Array.from(group.querySelectorAll('input[type="radio"]'));

                const paintStars = function (value) {
                    radios.forEach(function (radio) {
                        const star = radio.parentElement.querySelector('.hp-star-rating-symbol');
                        star.style.color = Number(radio.value) <= value ? 'var(--hp-teal)' : 'rgba(167, 176, 192, 0.42)';
                    });
                };

                radios.forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        paintStars(Number(radio.value));
                    });
                });

                const checkedRadio = radios.find(function (radio) {
                    return radio.checked;
                });

                paintStars(checkedRadio ? Number(checkedRadio.value) : 0);
            });
        });
    </script>
@endpush
