@extends('layouts.site-dash')

@section('title', 'لوحة التحكم')

@php
    $totalBalance = $mainBalance + $profitBalance;
    $plan = $user->plan;

    $duration = $plan->duration_days ?? 30;
    $daysPassed = 0;
    $progress = 0;
    $nextExpected = now()->addDays($duration);
    $expectedProfit = 0;

    if ($plan) {
        if ($user->last_profit_date) {
            $lastProfit = \Carbon\Carbon::parse($user->last_profit_date);
            $nextExpected = $lastProfit->copy()->addDays($duration);
            $diff = now()->diff($lastProfit);
            $daysPassed = $diff->invert ? $diff->days : 0;
            $progress = $duration > 0 ? min(100, ($daysPassed / $duration) * 100) : 0;
        }

        $expectedProfit = ($user->deposit_balance * ($plan->profit_rate / 100));
    }

    $dailyPnl = collect($profitTotals)->last() ?? 0;
    $weeklyPnl = collect($profitTotals)->slice(-7)->sum();
    $spotGold = 2034.60; // مؤقت حتى ربط مزود الأسعار المباشر
    $priceChange = 1.24;
    $priceChangePct = 0.06;

    $kycVerified = !empty($user->id_photo_front) && $user->status !== \App\Enums\UserStatus::Pending && $user->status !== \App\Enums\UserStatus::Inactive;
    $aiStatus = $plan && $user->status !== \App\Enums\UserStatus::Pending && $user->status !== \App\Enums\UserStatus::Inactive ? 'نشط' : 'في الانتظار';
    $aiConfidence = $plan ? min(97, max(81, round(($progress ?: 66) + 14))) : 72;

    $alerts = collect();

    if ($user->status === \App\Enums\UserStatus::Pending) {
        $alerts->push([
            'tone' => 'warning',
            'icon' => 'fa-clock',
            'title' => 'حسابك قيد التفعيل',
            'body' => 'تم رفع المستندات أو إنشاء الحساب بنجاح، والآن بانتظار اعتماد الإدارة.',
            'time' => 'الآن',
        ]);
    }

    if ($user->status === \App\Enums\UserStatus::Inactive) {
        $alerts->push([
            'tone' => 'danger',
            'icon' => 'fa-ban',
            'title' => 'الحساب معطّل حالياً',
            'body' => 'يرجى التواصل مع الدعم الفني لمعرفة سبب التعطيل وإعادة التفعيل.',
            'time' => 'مهم',
        ]);
    }

    if (!$user->id_photo_front) {
        $alerts->push([
            'tone' => 'warning',
            'icon' => 'fa-id-card',
            'title' => 'التحقق من الهوية غير مكتمل',
            'body' => 'أكمل رفع مستندات KYC لتفعيل السحب والوصول الكامل لواجهة التداول.',
            'time' => 'KYC',
        ]);
    }

    if ($plan) {
        $alerts->push([
            'tone' => 'success',
            'icon' => 'fa-robot',
            'title' => 'محرك ' . brandAiName() . ' جاهز',
            'body' => 'خطتك الحالية فعّالة ويمكن تفعيل تنفيذ XAUUSD فور اكتمال الربط التنفيذي.',
            'time' => 'AI',
        ]);
    }

    if ($pendingRequests->count()) {
        $latestPending = $pendingRequests->first();
        $alerts->push([
            'tone' => 'info',
            'icon' => $latestPending->type == \App\Enums\TransactionRequestType::Deposit ? 'fa-arrow-down' : 'fa-arrow-up',
            'title' => $latestPending->type == \App\Enums\TransactionRequestType::Deposit ? 'طلب إيداع قيد المراجعة' : 'طلب سحب قيد المراجعة',
            'body' => 'قيمة الطلب: ' . formatCurrency($latestPending->amount),
            'time' => $latestPending->created_at->diffForHumans(),
        ]);
    }

    foreach ($unreadMessages->take(2) as $msg) {
        $alerts->push([
            'tone' => 'neutral',
            'icon' => 'fa-envelope-open-text',
            'title' => $msg->title,
            'body' => \Illuminate\Support\Str::limit(strip_tags($msg->body), 90),
            'time' => $msg->created_at->diffForHumans(),
        ]);
    }

    $demoOpenPositions = $plan ? [
        [
            'ticket' => '#XAU-2104',
            'side' => 'BUY',
            'entry' => $spotGold - 2.40,
            'current' => $spotGold,
            'tp' => $spotGold + 4.80,
            'sl' => $spotGold - 4.10,
            'size' => '0.40',
            'pnl' => 126.40,
        ],
        [
            'ticket' => '#XAU-2107',
            'side' => 'SELL',
            'entry' => $spotGold + 1.85,
            'current' => $spotGold,
            'tp' => $spotGold - 3.60,
            'sl' => $spotGold + 3.10,
            'size' => '0.25',
            'pnl' => 62.80,
        ],
    ] : [];

    $demoClosedPositions = $plan ? [
        [
            'ticket' => '#XAU-2098',
            'side' => 'BUY',
            'entry' => $spotGold - 5.10,
            'exit' => $spotGold - 0.40,
            'duration' => '58 دقيقة',
            'pnl' => 214.00,
            'result' => 'ربح',
        ],
        [
            'ticket' => '#XAU-2095',
            'side' => 'SELL',
            'entry' => $spotGold + 3.20,
            'exit' => $spotGold + 4.10,
            'duration' => '31 دقيقة',
            'pnl' => -46.50,
            'result' => 'خسارة',
        ],
        [
            'ticket' => '#XAU-2091',
            'side' => 'BUY',
            'entry' => $spotGold - 7.40,
            'exit' => $spotGold - 2.30,
            'duration' => '1 س 14 د',
            'pnl' => 188.90,
            'result' => 'ربح',
        ],
    ] : [];
@endphp

@section('content')
    <div class="lira-dashboard-page">
        @if ($user->status === \App\Enums\UserStatus::Pending)
            <div class="alert alert-warning d-flex align-items-center mb-4 lira-status-alert" role="alert">
                <i class="fa-solid fa-clock fa-lg ms-3"></i>
                <div>حسابك قيد الانتظار حالياً، وسيتم تفعيله بعد مراجعة الإدارة.</div>
            </div>
        @elseif ($user->status === \App\Enums\UserStatus::Inactive)
            <div class="alert alert-danger d-flex align-items-center mb-4 lira-status-alert" role="alert">
                <i class="fa-solid fa-ban fa-lg ms-3"></i>
                <div>حسابك معطّل حالياً. يرجى التواصل مع الدعم الفني لمعرفة التفاصيل.</div>
            </div>
        @endif

        <div class="lira-hero mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · XAUUSD CONTROL</span>
                <h1 class="lira-page-title">لوحة تداول الذهب بالذكاء الاصطناعي</h1>
                <p class="lira-page-subtitle">
                    متابعة الرصيد، نشاط النظام، مخطط الذهب، والتنبيهات التنفيذية من مكان واحد.
                </p>
            </div>

            <div class="lira-hero-actions">
                <a href="{{ route('site.deposit') }}" class="btn btn-primary px-4">
                    <i class="fa-solid fa-plus ms-2"></i>
                    شحن الرصيد
                </a>

                <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}" class="btn btn-outline-primary px-4">
                    <i class="fa-solid fa-arrow-up-from-bracket ms-2"></i>
                    سحب الأرباح
                </a>

                <a href="{{ route('site.transactions.index') }}" class="btn lira-ghost-btn px-4">
                    <i class="fa-solid fa-clock-rotate-left ms-2"></i>
                    السجل
                </a>
            </div>
        </div>

        <div class="lira-mobile-page-nav">
            <a href="#dashboardOverview">نظرة سريعة</a>
            <a href="#dashboardFinance">العمليات</a>
            <a href="#dashboardActivity">التنبيهات</a>
            <a href="#dashboardAnalytics">التحليل</a>
            <a href="#dashboardAccount">الحساب</a>
        </div>

        <div class="lira-mobile-spotlight">
            <div class="lira-mobile-spotlight__body">
                <div class="lira-mobile-spotlight__head">
                    <div>
                        <strong>ملخص الحساب الآن</strong>
                        <span>أهم حالة التشغيل والاختصارات في مكان واحد لسهولة المتابعة من الهاتف.</span>
                    </div>
                    <div class="lira-mobile-spotlight__icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>

                <div class="lira-mobile-spotlight__grid">
                    <div class="lira-mobile-spotlight__item">
                        <span>الخطة</span>
                        <strong>{{ $plan?->name ?? 'بدون خطة' }}</strong>
                    </div>
                    <div class="lira-mobile-spotlight__item">
                        <span>AI</span>
                        <strong>{{ $aiStatus }} · {{ $aiConfidence }}%</strong>
                    </div>
                    <div class="lira-mobile-spotlight__item">
                        <span>KYC</span>
                        <strong>{{ $kycVerified ? 'موثق' : 'قيد الاستكمال' }}</strong>
                    </div>
                    <div class="lira-mobile-spotlight__item">
                        <span>الاستحقاق</span>
                        <strong>{{ $plan ? $nextExpected->format('Y/m/d') : '—' }}</strong>
                    </div>
                </div>

                <div class="lira-mobile-spotlight__actions">
                    <a href="{{ route('site.funding') }}">إيداع</a>
                    <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}">سحب</a>
                    <a href="{{ route('profile') }}">الملف</a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Summary -->
        <div class="row g-3 mb-4 lira-dashboard-stats" id="dashboardOverview">
            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">إجمالي الرصيد</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-wallet"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ formatCurrency($totalBalance) }}</div>
                        <div class="lira-stat-meta">
                            <span>محفظة التداول + الأرباح</span>
                            <span class="lira-positive-chip">جاهز للتشغيل</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">الرصيد المتاح للتداول</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-coins"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ formatCurrency($mainBalance) }}</div>
                        <div class="lira-stat-meta">
                            <span>رصيد الإيداع الأساسي</span>
                            <span>{{ formatCurrency($totalDeposits) }} إيداعات</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">أرباح آخر 7 أيام</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-chart-line"></i></div>
                        </div>
                        <div class="lira-stat-value {{ $weeklyPnl >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $weeklyPnl >= 0 ? '+' : '' }}{{ formatCurrency($weeklyPnl) }}
                        </div>
                        <div class="lira-stat-meta">
                            <span>آخر قيمة يومية: {{ $dailyPnl >= 0 ? '+' : '' }}{{ formatCurrency($dailyPnl) }}</span>
                            <span class="text-muted">من سجل الأرباح الحالي</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">الخطة والمحرك</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-microchip"></i></div>
                        </div>
                        <div class="lira-stat-value lira-plan-value">{{ $plan?->name ?? 'بدون خطة' }}</div>
                        <div class="lira-stat-meta">
                            <span>AI: {{ $aiStatus }} · {{ $aiConfidence }}%</span>
                            <span class="{{ $kycVerified ? 'text-success' : 'text-warning' }}">
                                {{ $kycVerified ? 'KYC Verified' : 'KYC Pending' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Primary Data Row: System & Finance -->
        <div class="row g-3 mb-4" id="dashboardFinance">
            <div class="col-xxl-4 col-xl-5">
                <div class="card lira-side-card h-100">
                    <div class="card-header border-0 pb-0">
                        <h6 class="mb-0 text-white font-cairo">مركز التشغيل</h6>
                    </div>
                    <div class="card-body mt-2">
                        <div class="lira-side-grid">
                            <div class="lira-side-metric">
                                <span>حالة الذكاء الاصطناعي</span>
                                <strong class="text-white">{{ $aiStatus }}</strong>
                            </div>
                            <div class="lira-side-metric">
                                <span>نسبة الثقة</span>
                                <strong class="ycolor">{{ $aiConfidence }}%</strong>
                            </div>
                            <div class="lira-side-metric">
                                <span>الخطة الحالية</span>
                                <strong class="text-white small">{{ $plan?->name ?? 'غير مفعلة' }}</strong>
                            </div>
                            <div class="lira-side-metric">
                                <span>التحقق</span>
                                <strong class="{{ $kycVerified ? 'text-success' : 'text-warning' }}">
                                    {{ $kycVerified ? 'موثق' : 'قيد الاستكمال' }}
                                </strong>
                            </div>
                        </div>

                        @if($plan)
                            <div class="lira-plan-box mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">تقدم الدورة الحالية</span>
                                    <strong class="ycolor small">{{ round($progress, 1) }}%</strong>
                                </div>
                                <div class="progress lira-progress" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>

                                <div class="lira-plan-meta mt-3">
                                    <div>
                                        <span>الربح المتوقع</span>
                                        <strong class="text-white">{{ formatCurrency($expectedProfit) }}</strong>
                                    </div>
                                    <div>
                                        <span>تاريخ الاستحقاق</span>
                                        <strong class="text-white">{{ $nextExpected->format('Y/m/d') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="lira-empty-inline mt-4">
                                <i class="fa-solid fa-layer-group"></i>
                                <span>لا توجد خطة مفعلة حالياً لبدء التداول.</span>
                            </div>
                        @endif

                        <div class="lira-quick-actions mt-4 pt-2">
                            <a href="{{ route('site.funding') }}" class="btn btn-primary">إيداع</a>
                            <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}" class="btn btn-outline-primary">سحب</a>
                            <a href="{{ route('profile') }}" class="btn lira-ghost-btn">الملف</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 col-xl-7">
                <div class="card lira-table-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 text-white font-cairo">آخر العمليات المالية</h6>
                            <p class="text-muted mb-0 small">سجل تحركات المحفظة والأرباح.</p>
                        </div>
                        <a href="{{ route('site.transactions.index') }}" class="lira-text-link">عرض الكل</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive d-none d-md-block">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">النوع</th>
                                        <th>القيمة</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-start">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestTransactions->take(6) as $tx)
                                        <tr>
                                            <td class="pe-4 text-white">{{ $tx->type->getName() }}</td>
                                            <td class="fw-bold">{{ formatCurrency($tx->amount) }}</td>
                                            <td>
                                                @if($tx->status == \App\Enums\TransactionStatus::Accepted)
                                                    <span class="lira-result-chip is-profit px-2">مكتمل</span>
                                                @else
                                                    <span class="lira-result-chip is-loss px-2">مرفوض</span>
                                                @endif
                                            </td>
                                            <td class="ps-4 text-start text-muted small">{{ $tx->created_at->format('Y/m/d') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-4">لا توجد عمليات مسجلة.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="lira-mobile-ledger d-md-none">
                            @forelse($latestTransactions->take(6) as $tx)
                                <div class="lira-mobile-ledger__item">
                                    <div class="lira-mobile-ledger__head">
                                        <strong>{{ $tx->type->getName() }}</strong>
                                        @if($tx->status == \App\Enums\TransactionStatus::Accepted)
                                            <span class="lira-result-chip is-profit">مكتمل</span>
                                        @else
                                            <span class="lira-result-chip is-loss">مرفوض</span>
                                        @endif
                                    </div>
                                    <div class="lira-mobile-ledger__grid">
                                        <div>
                                            <span>القيمة</span>
                                            <strong>{{ formatCurrency($tx->amount) }}</strong>
                                        </div>
                                        <div>
                                            <span>التاريخ</span>
                                            <strong>{{ $tx->created_at->format('Y/m/d') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="lira-empty-state py-4">لا توجد عمليات مسجلة.</div>
                            @endforelse
                        </div>

                        <div class="lira-subpanel border-top mt-auto bg-dark-opacity-1">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong class="text-white small">الطلبات قيد المعالجة</strong>
                                <a href="{{ route('site.transactions-requests.index') }}" class="lira-text-link small">متابعة</a>
                            </div>
                            <div class="row g-3">
                                @forelse($pendingRequests->take(2) as $request)
                                    <div class="col-sm-6">
                                        <div class="lira-pending-row border-0 bg-white-opacity-1 p-2 rounded-3">
                                            <div>
                                                <strong class="text-white small">
                                                    {{ $request->type->getName() }}
                                                </strong>
                                                <span class="text-muted d-block" style="font-size: 10px;">{{ $request->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="text-start">
                                                <strong class="text-white small">{{ formatCurrency($request->amount) }}</strong>
                                                <span class="text-warning d-block" style="font-size: 10px;">{{ $request->statusName() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12"><div class="lira-empty-state small py-2">لا توجد طلبات معلقة حالياً.</div></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Row: Alerts & Messages -->
        <div class="row g-3 mb-4" id="dashboardActivity">
            <div class="col-xl-6">
                <div class="card lira-side-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white font-cairo">تنبيهات النظام</h6>
                        <span class="lira-badge-chip">{{ $alerts->count() }} إشعار</span>
                    </div>
                    <div class="card-body">
                        <div class="lira-alert-feed">
                            @forelse($alerts->take(4) as $alert)
                                <div class="lira-alert-item is-{{ $alert['tone'] }} mb-2">
                                    <div class="lira-alert-icon"><i class="fa-solid {{ $alert['icon'] }}"></i></div>
                                    <div class="grow">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong class="text-white small">{{ $alert['title'] }}</strong>
                                            <span class="text-muted" style="font-size: 10px;">{{ $alert['time'] }}</span>
                                        </div>
                                        <p class="mb-0 text-muted small mt-1" style="font-size: 11px;">{{ $alert['body'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="lira-empty-state py-4 small">صندوق التنبيهات فارغ.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card lira-table-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white font-cairo">صندوق الرسائل</h6>
                        <a href="{{ route('site.messages.index') }}" class="lira-text-link">كل الرسائل</a>
                    </div>
                    <div class="card-body">
                        @forelse($unreadMessages->take(3) as $msg)
                            <div class="lira-message-item pb-3 mb-3 border-bottom-dashed">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-white small">{{ $msg->title }}</strong>
                                    <span class="text-muted" style="font-size: 10px;">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mb-0 text-muted small" style="font-size: 11px;">{{ \Illuminate\Support\Str::limit(strip_tags($msg->body), 120) }}</p>
                            </div>
                        @empty
                            <div class="lira-empty-state py-4">لا توجد رسائل جديدة.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Row: Performance Charts -->
        <div class="row g-3 mb-4" id="dashboardAnalytics">
            <div class="col-xl-6">
                <div class="card lira-chart-card h-100">
                    <div class="card-header border-0">
                        <h6 class="mb-1 text-white font-cairo">تحليل الأرباح</h6>
                        <p class="text-muted mb-0 small">تذبذب رصيد المحفظة لآخر 30 يوماً.</p>
                    </div>
                    <div class="card-body">
                        <div class="lira-mini-chart-wrap" style="height: 300px;">
                            <canvas id="profitChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card lira-chart-card h-100">
                    <div class="card-header border-0">
                        <h6 class="mb-1 text-white font-cairo">إحصائيات التدفق</h6>
                        <p class="text-muted mb-0 small">توزيع الإيداعات مقابل السحوبات الشهرية.</p>
                    </div>
                    <div class="card-body">
                        <div class="lira-mini-chart-wrap" style="height: 300px;">
                            <canvas id="flowChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security & Social Row: Referrals & Verification -->
        <div class="row g-3" id="dashboardAccount">
            <div class="col-12">
                <div class="card lira-table-card">
                    <div class="card-header border-0">
                        <h6 class="mb-0 text-white font-cairo">نظام الإحالة والتحقق من الحساب</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 align-items-center">
                            <div class="col-xl-5">
                                <div class="lira-trust-grid">
                                    <div class="lira-trust-item">
                                        <span>حالة الـ KYC</span>
                                        <strong class="{{ $kycVerified ? 'text-success' : 'text-warning' }}">
                                            {{ $kycVerified ? 'موثق بالكامل' : 'قيد الاستكمال' }}
                                        </strong>
                                    </div>
                                    <div class="lira-trust-item">
                                        <span>إجمالي المحالين</span>
                                        <strong class="text-white">{{ $referredCount }} مستخدم</strong>
                                    </div>
                                    <div class="lira-trust-item">
                                        <span>أرباح الشركاء</span>
                                        <strong class="text-success">{{ formatCurrency($referralEarnings) }}</strong>
                                    </div>
                                    <div class="lira-trust-item">
                                        <span>آخر تحديث</span>
                                        <strong class="text-white">الآن</strong>
                                    </div>
                                </div>
                                <div class="lira-referral-box mt-3">
                                    <label class="form-label small text-muted">رابط الإحالة المباشر</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-dark border-0" id="referralLink" value="{{ $user->referral_link }}" readonly dir="ltr">
                                        <button class="btn btn-primary" type="button" onclick="copyReferralLink()">نسخ</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7">
                                @if(!$user->id_photo_front)
                                    <div class="lira-inline-warning p-4 h-100 rounded-4">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="lira-warning-icon-shell"><i class="fa-solid fa-shield-halved"></i></div>
                                            <div class="grow">
                                                <h6 class="mb-1 text-white font-cairo">لماذا يجب عليك التحقق؟</h6>
                                                <p class="mb-3 text-muted small" style="line-height: 1.8;">يعد نظام اعرف عميلك (KYC) خطوة أساسية لضمان أمان عمليات السحب والوصول إلى المحرك المتقدم {{ brandAiName() }} v3.0.</p>
                                                <a href="{{ route('profile') }}" class="btn btn-warning px-4 fw-bold">رفع وثائق الهوية الآن</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="lira-inline-success p-4 h-100 rounded-4">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="lira-success-icon-shell"><i class="fa-solid fa-badge-check"></i></div>
                                            <div class="grow">
                                                <h6 class="mb-1 text-white font-cairo">أنت شريك موثق!</h6>
                                                <p class="mb-0 text-muted small" style="line-height: 1.8;">حسابك متصل الآن بكامل ميزات الحماية والتفويض. يمكنك البدء بسحب أرباحك فور وصولها إلى الحد الأدنى، كما يمكنك استخدام جميع ميزات المنصة دون أي قيود برمجية.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom_styles')
    <style>
        .lira-dashboard-page {
            --page-gap: 18px;
        }

        .lira-dashboard-page [id] {
            scroll-margin-top: 92px;
        }

        .bg-dark-opacity-1 {
            background: rgba(0, 0, 0, 0.1) !important;
        }

        .bg-white-opacity-1 {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .border-bottom-dashed {
            border-bottom: 1px dashed rgba(255, 255, 255, 0.08);
        }

        .border-bottom-dashed:last-child {
            border-bottom: 0;
        }

        .lira-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            padding: 6px 2px 4px;
            flex-wrap: wrap;
        }

        .lira-eyebrow {
            display: inline-block;
            margin-bottom: 8px;
            color: var(--lira-accent);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.14em;
        }

        .lira-page-title {
            font-size: clamp(1.8rem, 2.4vw, 2.5rem);
            margin-bottom: 8px;
        }

        .lira-page-subtitle {
            color: var(--lira-text-muted);
            margin-bottom: 0;
            max-width: 760px;
        }

        .lira-hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-ghost-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
        }

        .lira-ghost-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--lira-text);
        }

        .lira-status-alert {
            border-radius: 18px !important;
            padding: 16px 18px !important;
        }

        .lira-stat-card {
            min-height: 170px;
            overflow: hidden;
        }

        .lira-stat-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .lira-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
        }

        .lira-stat-label {
            color: var(--lira-text-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .lira-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.09);
            color: var(--lira-accent);
            font-size: 18px;
        }

        .lira-stat-value {
            font-size: clamp(1.45rem, 1.6vw, 2rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }

        .lira-plan-value {
            font-size: 1.35rem;
        }

        .lira-stat-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: var(--lira-text-muted);
            flex-wrap: wrap;
        }

        .lira-positive-chip {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(23, 178, 106, 0.12);
            color: #63ddab;
            font-weight: 700;
        }

        .lira-terminal-card,
        .lira-side-card,
        .lira-table-card,
        .lira-chart-card {
            overflow: hidden;
        }

        .lira-terminal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .lira-terminal-symbol-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .lira-terminal-symbol {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .lira-terminal-market {
            color: var(--lira-text-muted);
            font-size: 13px;
        }

        .lira-terminal-quote {
            display: flex;
            align-items: baseline;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lira-terminal-quote #goldSpotPrice {
            font-size: 2rem;
            font-weight: 800;
        }

        .lira-terminal-change {
            font-size: 14px;
            font-weight: 700;
        }

        .lira-terminal-change.is-up {
            color: #5fe2a1;
        }

        .lira-terminal-change.is-down {
            color: #ff8a80;
        }

        .lira-terminal-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-badge-chip.is-accent {
            background: rgba(0, 230, 167, 0.12);
            border-color: rgba(0, 230, 167, 0.24);
            color: var(--lira-accent);
        }

        .lira-timeframe-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lira-timeframe-chip {
            height: 34px;
            padding: 0 14px;
            border-radius: 12px;
            background: transparent;
            border: 1px solid var(--lira-border);
            color: var(--lira-text-muted);
            font-weight: 700;
        }

        .lira-timeframe-chip.active {
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            border-color: rgba(0, 230, 167, 0.28);
        }

        .lira-terminal-meta-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .lira-meta-item {
            min-width: 140px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-meta-item strong {
            display: block;
            margin-top: 4px;
            color: var(--lira-text);
            font-size: 15px;
        }

        .lira-meta-label {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-accent-chart {
            height: 510px;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            background:
                radial-gradient(circle at top right, rgba(26, 43, 255, 0.08), transparent 20%),
                rgba(0, 0, 0, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .lira-chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            font-size: 12px;
            color: var(--lira-text-muted);
        }

        .lira-chart-legend i {
            font-size: 9px;
            margin-left: 6px;
        }

        .lira-dot-entry {
            color: var(--lira-accent);
        }

        .lira-dot-exit {
            color: #ff8a80;
        }

        .lira-dot-line {
            color: #5fe2a1;
        }

        .lira-chart-footnote {
            font-size: 12px;
            color: var(--lira-text-muted);
            line-height: 1.8;
        }

        .lira-side-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-side-metric {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-side-metric span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .lira-side-metric strong {
            font-size: 15px;
        }

        .lira-plan-box {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-progress {
            height: 10px;
        }

        .lira-plan-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-plan-meta span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .lira-plan-meta strong {
            font-size: 14px;
        }

        .lira-empty-inline {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            color: var(--lira-text-muted);
        }

        .lira-empty-inline i {
            color: var(--lira-accent);
        }

        .lira-quick-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-alert-feed {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-alert-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: rgba(255, 255, 255, 0.02);
        }

        .lira-alert-item strong {
            color: var(--lira-text);
            font-size: 14px;
        }

        .lira-alert-item p {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
            margin-top: 4px;
        }

        .lira-alert-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .lira-alert-item.is-success .lira-alert-icon {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-alert-item.is-warning .lira-alert-icon {
            background: rgba(120, 97, 255, 0.12);
            color: #c4b6ff;
        }

        .lira-alert-item.is-danger .lira-alert-icon {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-alert-item.is-info .lira-alert-icon,
        .lira-alert-item.is-neutral .lira-alert-icon {
            background: rgba(255, 255, 255, 0.05);
            color: var(--lira-text-soft);
        }

        .lira-notice-box {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(0, 230, 167, 0.08);
            border: 1px solid rgba(0, 230, 167, 0.16);
            color: var(--lira-text-soft);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-section-title {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 14px;
            color: var(--lira-text-soft) !important;
        }

        .lira-clean-table thead th {
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-size: 12px !important;
        }

        .lira-clean-table tbody td {
            font-size: 13px;
        }

        .lira-side-chip,
        .lira-result-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .lira-side-chip.is-buy {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-side-chip.is-sell {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-result-chip.is-profit {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-result-chip.is-loss {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-empty-block {
            min-height: 340px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 10px;
            color: var(--lira-text-muted);
        }

        .lira-empty-block i {
            font-size: 34px;
            color: var(--lira-accent);
        }

        .lira-empty-state {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            color: var(--lira-text-muted);
            text-align: center;
        }

        .lira-subpanel {
            padding: 18px 20px 20px;
        }

        .lira-pending-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-pending-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .lira-pending-row strong {
            display: block;
            margin-bottom: 4px;
        }

        .lira-pending-row span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-mini-chart-wrap {
            height: 300px;
        }

        .lira-text-link {
            color: var(--lira-accent);
            font-size: 13px;
            font-weight: 700;
        }

        .lira-text-link:hover {
            color: var(--lira-accent-strong);
        }

        .lira-message-item {
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-message-item:first-child {
            padding-top: 0;
        }

        .lira-message-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .lira-message-item p {
            color: var(--lira-text-muted);
            line-height: 1.9;
            font-size: 13px;
        }

        .lira-mobile-ledger {
            display: grid;
            gap: 10px;
            padding: 14px;
        }

        .lira-mobile-ledger__item {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-mobile-ledger__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .lira-mobile-ledger__head strong {
            font-size: 13px;
        }

        .lira-mobile-ledger__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-mobile-ledger__grid span {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            color: var(--lira-text-muted);
        }

        .lira-mobile-ledger__grid strong {
            display: block;
            font-size: 13px;
        }

        .lira-trust-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-trust-item {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-trust-item span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .lira-trust-item strong {
            font-size: 15px;
        }

        .lira-referral-box .input-group .btn {
            min-width: 92px;
        }

        .lira-inline-warning,
        .lira-inline-success {
            display: flex;
            align-items: center;
            gap: 14px;
            border-radius: 18px;
        }

        .lira-warning-icon-shell,
        .lira-success-icon-shell {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
            font-size: 18px;
        }

        .lira-warning-icon-shell {
            background: rgba(120, 97, 255, 0.15);
            border: 1px solid rgba(120, 97, 255, 0.2);
            color: #c4b6ff;
        }

        .lira-success-icon-shell {
            background: rgba(23, 178, 106, 0.15);
            border: 1px solid rgba(23, 178, 106, 0.2);
            color: #5fe2a1;
        }

        .lira-inline-warning,
        .lira-inline-success {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-inline-warning strong,
        .lira-inline-success strong {
            display: block;
            margin-bottom: 4px;
        }

        .lira-inline-warning span,
        .lira-inline-success span {
            color: var(--lira-text-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        @media (max-width: 1199.98px) {
            .lira-accent-chart {
                height: 440px;
            }
        }

        @media (max-width: 991.98px) {
            .lira-quick-actions {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-side-grid,
            .lira-plan-meta,
            .lira-trust-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lira-side-metric,
            .lira-trust-item,
            .lira-plan-box {
                padding: 12px;
            }

            .lira-accent-chart {
                height: 360px;
            }
        }

        @media (max-width: 767.98px) {
            .lira-hero {
                gap: 12px;
                margin-bottom: 14px !important;
            }

            .lira-hero-note {
                min-width: 0;
                width: 100%;
            }

            .lira-page-subtitle {
                font-size: 12px;
            }

            .lira-dashboard-stats > [class*='col-'] {
                width: 50%;
                flex: 0 0 auto;
                max-width: 50%;
            }

            .lira-stat-card {
                min-height: 148px;
            }

            .lira-stat-top {
                margin-bottom: 16px;
            }

            .lira-stat-value {
                font-size: 1.15rem;
            }

            .lira-stat-icon {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                font-size: 15px;
            }

            .lira-terminal-quote #goldSpotPrice {
                font-size: 1.6rem;
            }

            .lira-terminal-meta-row {
                flex-direction: column;
            }

            .lira-meta-item {
                width: 100%;
            }

            .lira-hero-actions {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-hero-actions .btn,
            .lira-quick-actions .btn {
                width: 100%;
                min-height: 42px;
                padding-right: 10px;
                padding-left: 10px;
                font-size: 12px;
            }

            .lira-side-grid,
            .lira-plan-meta,
            .lira-trust-grid {
                gap: 10px;
            }

            .lira-stat-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .lira-alert-item,
            .lira-pending-row,
            .lira-inline-warning,
            .lira-inline-success {
                border-radius: 14px;
            }
        }

        @media (max-width: 575.98px) {
            .lira-hero-actions {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lira-dashboard-stats > [class*='col-'] {
                width: 50%;
                max-width: 50%;
            }

            .lira-hero-actions .btn,
            .lira-quick-actions .btn {
                font-size: 12px;
                padding-right: 8px;
                padding-left: 8px;
            }

            .lira-hero-actions .btn:last-child {
                grid-column: 1 / -1;
            }

            .lira-side-metric strong,
            .lira-trust-item strong,
            .lira-plan-meta strong {
                font-size: 13px;
            }

            .lira-accent-chart {
                height: 300px;
            }

            .lira-mini-chart-wrap {
                height: 220px !important;
            }

            .lira-alert-item {
                padding: 10px;
            }

            .lira-message-item p {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .lira-referral-box .input-group {
                flex-direction: column;
                gap: 10px;
            }

            .lira-referral-box .input-group .form-control,
            .lira-referral-box .input-group .btn {
                width: 100%;
                border-radius: 14px !important;
            }

            .lira-mobile-ledger__grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

    <script>
        function copyReferralLink() {
            const input = document.getElementById('referralLink');
            const btn = document.getElementById('copyReferralBtn');
            if (!input || !btn) return;

            navigator.clipboard.writeText(input.value).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML = 'تم النسخ';
                setTimeout(() => btn.innerHTML = original, 1600);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const textColor = getComputedStyle(document.documentElement).getPropertyValue('--lira-text-soft').trim() || '#c5cad3';
            const mutedColor = getComputedStyle(document.documentElement).getPropertyValue('--lira-text-muted').trim() || '#8d96a5';
            const borderColor = 'rgba(255,255,255,0.06)';
            const goldColor = getComputedStyle(document.documentElement).getPropertyValue('--lira-accent').trim() || '#00e6a7';
            const successColor = '#5fe2a1';
            const dangerColor = '#ff8a80';

            Chart.defaults.color = mutedColor;
            Chart.defaults.font.family = "'Cairo', sans-serif";

            const profitLabels = @json($profitDates ?? []);
            const profitData = @json($profitTotals ?? []);
            const flowLabels = @json($barMonths ?? []);
            const flowDeposits = @json($barDeposits ?? []);
            const flowWithdrawals = @json($barWithdrawals ?? []);

            const safeProfitLabels = profitLabels.length ? profitLabels : ['-'];
            const safeProfitData = profitData.length ? profitData : [0];

            const safeFlowLabels = flowLabels.length ? flowLabels : ['-'];
            const safeFlowDeposits = flowDeposits.length ? flowDeposits : [0];
            const safeFlowWithdrawals = flowWithdrawals.length ? flowWithdrawals : [0];

            const profitCanvas = document.getElementById('profitChart');
            if (profitCanvas) {
                const ctx = profitCanvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 280);
                gradient.addColorStop(0, 'rgba(0, 230, 167, 0.22)');
                gradient.addColorStop(1, 'rgba(0, 230, 167, 0.01)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: safeProfitLabels,
                        datasets: [{
                            data: safeProfitData,
                            borderColor: goldColor,
                            backgroundColor: gradient,
                            fill: true,
                            borderWidth: 2.4,
                            tension: 0.35,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: goldColor,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                rtl: true,
                                displayColors: false,
                                backgroundColor: '#0f141c',
                                borderColor: 'rgba(0, 230, 167, 0.24)',
                                borderWidth: 1,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: {
                                    color: mutedColor,
                                    maxTicksLimit: 6
                                }
                            },
                            y: {
                                grid: { color: borderColor },
                                border: { display: false },
                                ticks: { color: mutedColor }
                            }
                        }
                    }
                });
            }

            const flowCanvas = document.getElementById('flowChart');
            if (flowCanvas) {
                const ctx = flowCanvas.getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: safeFlowLabels,
                        datasets: [
                            {
                                label: 'إيداعات',
                                data: safeFlowDeposits,
                                backgroundColor: goldColor,
                                borderRadius: 8,
                                barThickness: 12
                            },
                            {
                                label: 'سحوبات',
                                data: safeFlowWithdrawals,
                                backgroundColor: 'rgba(255, 138, 128, 0.82)',
                                borderRadius: 8,
                                barThickness: 12
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    color: textColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8
                                }
                            },
                            tooltip: {
                                rtl: true,
                                backgroundColor: '#0f141c',
                                borderColor: 'rgba(0, 230, 167, 0.24)',
                                borderWidth: 1,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: { color: mutedColor }
                            },
                            y: {
                                grid: { color: borderColor },
                                border: { display: false },
                                ticks: { color: mutedColor }
                            }
                        }
                    }
                });
            }

            const chartContainer = document.getElementById('goldChart');
            if (chartContainer && window.LightweightCharts) {
                const chart = LightweightCharts.createChart(chartContainer, {
                    layout: {
                        background: { color: 'transparent' },
                        textColor: textColor
                    },
                    grid: {
                        vertLines: { color: 'rgba(255,255,255,0.03)' },
                        horzLines: { color: 'rgba(255,255,255,0.03)' }
                    },
                    rightPriceScale: {
                        borderColor: 'rgba(255,255,255,0.06)'
                    },
                    timeScale: {
                        borderColor: 'rgba(255,255,255,0.06)',
                        timeVisible: true,
                        secondsVisible: false
                    },
                    crosshair: {
                        vertLine: {
                            color: 'rgba(0,230,167,0.24)',
                            labelBackgroundColor: '#161b23'
                        },
                        horzLine: {
                            color: 'rgba(0,230,167,0.24)',
                            labelBackgroundColor: '#161b23'
                        }
                    },
                    localization: {
                        locale: 'ar'
                    },
                    autoSize: true
                });

                const candleSeries = chart.addCandlestickSeries({
                    upColor: successColor,
                    downColor: dangerColor,
                    borderVisible: false,
                    wickUpColor: successColor,
                    wickDownColor: dangerColor,
                    priceLineColor: goldColor,
                    lastValueVisible: true
                });

                const basePrice = {{ json_encode($spotGold) }};
                const candleData = [];
                const markers = [];
                let lastClose = basePrice - 4.8;
                const now = Math.floor(Date.now() / 1000);

                for (let i = 0; i < 120; i++) {
                    const time = now - ((119 - i) * 300);
                    const wave = Math.sin(i / 8) * 0.95;
                    const drift = (i > 70 ? 0.08 : 0.02) * i / 35;
                    const noise = ((i % 5) - 2) * 0.12;
                    const open = lastClose;
                    const close = open + wave + drift + noise;
                    const high = Math.max(open, close) + 0.55 + ((i % 4) * 0.04);
                    const low = Math.min(open, close) - 0.48 - ((i % 3) * 0.05);

                    candleData.push({
                        time,
                        open: Number(open.toFixed(2)),
                        high: Number(high.toFixed(2)),
                        low: Number(low.toFixed(2)),
                        close: Number(close.toFixed(2)),
                    });

                    lastClose = close;
                }

                candleSeries.setData(candleData);

                const markerIndexes = [18, 32, 57, 81, 102];
                const markerTemplate = [
                    { position: 'belowBar', color: goldColor, shape: 'arrowUp', text: 'BUY' },
                    { position: 'aboveBar', color: successColor, shape: 'circle', text: 'TP' },
                    { position: 'aboveBar', color: goldColor, shape: 'arrowDown', text: 'SELL' },
                    { position: 'belowBar', color: dangerColor, shape: 'circle', text: 'SL' },
                    { position: 'belowBar', color: goldColor, shape: 'arrowUp', text: 'BUY' },
                ];

                markerIndexes.forEach((idx, i) => {
                    markers.push({
                        time: candleData[idx].time,
                        position: markerTemplate[i].position,
                        color: markerTemplate[i].color,
                        shape: markerTemplate[i].shape,
                        text: markerTemplate[i].text
                    });
                });

                candleSeries.setMarkers(markers);
                chart.timeScale().fitContent();

                const hoveredPrice = document.getElementById('goldHoveredPrice');
                const hoveredTime = document.getElementById('goldHoveredTime');
                const spotPrice = document.getElementById('goldSpotPrice');

                const lastBar = candleData[candleData.length - 1];
                if (spotPrice) spotPrice.textContent = lastBar.close.toFixed(2);
                if (hoveredPrice) hoveredPrice.textContent = lastBar.close.toFixed(2);

                chart.subscribeCrosshairMove((param) => {
                    if (!param || !param.time || !param.seriesData) return;

                    const data = param.seriesData.get(candleSeries);
                    if (!data) return;

                    if (hoveredPrice) hoveredPrice.textContent = Number(data.close).toFixed(2);

                    const date = new Date(param.time * 1000);
                    const hh = String(date.getHours()).padStart(2, '0');
                    const mm = String(date.getMinutes()).padStart(2, '0');
                    if (hoveredTime) hoveredTime.textContent = `${hh}:${mm}`;
                });

                const resizeObserver = new ResizeObserver(() => chart.timeScale().fitContent());
                resizeObserver.observe(chartContainer);
            }
        });
    </script>
@endpush

