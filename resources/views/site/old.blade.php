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
    $spotGold = 2034.60;
    $priceChange = 1.24;
    $priceChangePct = 0.06;

    $kycVerified = !empty($user->id_photo_front)
        && $user->status !== \App\Enums\UserStatus::Pending
        && $user->status !== \App\Enums\UserStatus::Inactive;

    $aiStatus = $plan && $user->status !== \App\Enums\UserStatus::Pending && $user->status !== \App\Enums\UserStatus::Inactive
        ? 'نشط'
        : 'في الانتظار';

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
        $pendingMeta = match ($latestPending->type) {
            \App\Enums\TransactionRequestType::Deposit => ['fa-arrow-down', 'طلب إيداع قيد المراجعة'],
            \App\Enums\TransactionRequestType::Robot => ['fa-robot', 'طلب روبوت قيد المراجعة'],
            default => ['fa-arrow-up', 'طلب سحب قيد المراجعة'],
        };

        $alerts->push([
            'tone' => 'info',
            'icon' => $pendingMeta[0],
            'title' => $pendingMeta[1],
            'body' => 'قيمة الطلب: ' . formatCurrency($latestPending->amount),
            'time' => $latestPending->created_at->diffForHumans(),
        ]);
    }
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

        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · XAUUSD CONTROL</span>
                <h1 class="lira-page-title">لوحة تداول الذهب بالذكاء الاصطناعي</h1>
                <p class="lira-page-subtitle">لوحة أبسط وأوضح لمتابعة الرصيد، السوق، حالة الحساب، وأهم الإجراءات.</p>
            </div>

            <div class="lira-hero-actions">
                <a href="{{ route('site.deposit') }}" class="btn btn-primary px-4">
                    <i class="fa-solid fa-plus ms-2"></i>
                    شحن الرصيد
                </a>

                <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}"
                    class="btn btn-outline-primary px-4">
                    <i class="fa-solid fa-arrow-up-from-bracket ms-2"></i>
                    سحب الأرباح
                </a>

                <a href="{{ route('site.transactions.index') }}" class="lira-text-link lira-inline-link">
                    <i class="fa-solid fa-clock-rotate-left ms-1"></i>
                    السجل الكامل
                </a>
            </div>
        </div>

        <div class="lira-status-strip mb-4">
            <div class="lira-status-pill {{ $kycVerified ? 'is-success' : 'is-warning' }}">
                <span>KYC</span>
                <strong>{{ $kycVerified ? 'موثق' : 'قيد الاستكمال' }}</strong>
            </div>
            <div class="lira-status-pill">
                <span>الخطة</span>
                <strong>{{ $plan?->name ?? 'غير مفعلة' }}</strong>
            </div>
            <div class="lira-status-pill">
                <span>المحرك</span>
                <strong>{{ $aiStatus }}</strong>
            </div>
            <div class="lira-status-pill">
                <span>الثقة</span>
                <strong>{{ $aiConfidence }}%</strong>
            </div>
            <div class="lira-status-pill {{ $pendingRequests->count() ? 'is-warning' : '' }}">
                <span>طلبات معلقة</span>
                <strong>{{ $pendingRequests->count() }}</strong>
            </div>
        </div>

        <div class="row g-3 mb-4">
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
                            <span class="lira-stat-label">الدورة الحالية</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-microchip"></i></div>
                        </div>
                        <div class="lira-stat-value lira-plan-value">{{ round($progress, 1) }}%</div>
                        <div class="lira-stat-meta">
                            <span>{{ $plan?->name ?? 'بدون خطة' }}</span>
                            <span>{{ $nextExpected->format('Y/m/d') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xxl-8">
                <div id="chartFullscreenTarget" class="lira-fs-wrapper">
                    <div class="card lira-terminal-card lira-terminal-shell h-100">
                        <div class="card-header border-0 pb-0">
                            <div class="lira-terminal-topbar">
                                <div class="lira-terminal-left">
                                    <div class="lira-terminal-symbol-group">
                                        <div class="lira-symbol-tabs">
                                            <button class="lira-symbol-tab active" data-symbol="XAUUSD">XAUUSD</button>
                                            <button class="lira-symbol-tab" data-symbol="BTCUSD">BTCUSD</button>
                                        </div>

                                        <div class="lira-terminal-market-wrap">
                                            <span class="lira-terminal-market" id="marketLabel">Gold / US Dollar</span>
                                            <strong class="lira-terminal-price"
                                                id="goldSpotPrice">{{ number_format($spotGold, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="lira-terminal-right">
                                    <div class="lira-timeframe-group">
                                        <button type="button" class="lira-timeframe-chip">1H</button>
                                        <button type="button" class="lira-timeframe-chip active">5M</button>
                                        <button type="button" class="lira-timeframe-chip">1M</button>
                                    </div>

                                    <button id="toggleFullscreenBtn" class="lira-btn-expand" title="Expand chart">
                                        <i class="fa-solid fa-expand"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="lira-terminal-stats lira-terminal-stats--four">
                                <div class="lira-terminal-stat">
                                    <span>Change</span>
                                    <strong id="goldPriceChange" class="{{ $priceChange >= 0 ? 'is-up' : 'is-down' }}">
                                        {{ $priceChange >= 0 ? '+' : '' }}{{ number_format($priceChange, 2) }}
                                        ({{ $priceChangePct >= 0 ? '+' : '' }}{{ number_format($priceChangePct, 2) }}%)
                                    </strong>
                                </div>

                                <div class="lira-terminal-stat">
                                    <span>Hovered</span>
                                    <strong id="goldHoveredPrice">{{ number_format($spotGold, 2) }}</strong>
                                </div>

                                <div class="lira-terminal-stat">
                                    <span>Time</span>
                                    <strong id="goldHoveredTime">Now</strong>
                                </div>

                                <div class="lira-terminal-stat">
                                    <span>Range</span>
                                    <strong id="goldRangeText">--</strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-3" id="chartAreaWrapper">

                            <div class="lira-lwc-stage" id="tradeChartStage">

                                <div class="lira-draw-toolbar-wrap" id="drawToolsWrap">
                                    <button type="button" class="lira-draw-toggle" id="drawMenuToggle">
                                        <i class="fa-solid fa-pen-ruler"></i>
                                        <span id="activeToolLabel">Cursor</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>

                                    <div class="lira-draw-menu" id="drawMenu">
                                        <button type="button" class="lira-draw-item is-active" data-tool="cursor">
                                            <i class="fa-solid fa-arrow-pointer"></i>
                                            Cursor
                                        </button>
                                        <button type="button" class="lira-draw-item" data-tool="hline">
                                            <i class="fa-solid fa-grip-lines"></i>
                                            Horizontal Line
                                        </button>
                                        <button type="button" class="lira-draw-item" data-tool="vline">
                                            <i class="fa-solid fa-up-down"></i>
                                            Vertical Line
                                        </button>
                                        <button type="button" class="lira-draw-item" data-tool="trend">
                                            <i class="fa-solid fa-arrow-trend-up"></i>
                                            Trend Line
                                        </button>
                                        <button type="button" class="lira-draw-item" data-tool="rect">
                                            <i class="fa-regular fa-square"></i>
                                            Rectangle
                                        </button>

                                        <div class="lira-draw-sep"></div>

                                        <button type="button" class="lira-draw-item" data-action="follow-live">
                                            <i class="fa-solid fa-satellite-dish"></i>
                                            Follow Live
                                        </button>
                                        <button type="button" class="lira-draw-item" data-action="clear">
                                            <i class="fa-solid fa-trash"></i>
                                            Clear Drawings
                                        </button>
                                    </div>
                                </div>

                                <div id="tradeChart" class="lira-lwc-chart"></div>
                                <canvas id="tradeDrawLayer" class="lira-draw-layer"></canvas>
                                <div id="tradeTooltip" class="lira-trade-tooltip"></div>
                            </div>

                            <div class="lira-trade-dock" id="tradeDock">
                                <div class="lira-trade-dock__head">
                                    <div>
                                        <span class="lira-trade-dock__eyebrow">{{ appName() }} QUICK TRADE</span>
                                        <strong class="lira-trade-dock__title">تنفيذ الصفقات من نفس الشارت</strong>
                                    </div>

                                    <div class="lira-trade-mode-pill" id="tradeModePill">Live</div>
                                </div>

                                <div class="lira-trade-form">
                                    <div class="lira-trade-field">
                                        <label for="tradeAmountInput">المبلغ</label>
                                        <div class="lira-trade-input-wrap">
                                            <input type="number" id="tradeAmountInput" min="1" step="1" value="100">
                                            <span>USD</span>
                                        </div>
                                    </div>

                                    <div class="lira-trade-field">
                                        <label>مدة الصفقة</label>
                                        <div class="lira-duration-group" id="tradeDurationGroup">
                                            <div class="lira-custom-duration">
                                                <button type="button" class="lira-duration-chip"
                                                    id="customDurationBtn">Custom</button>

                                                <div class="lira-custom-duration__input">
                                                    <input type="number" id="customDurationInput" min="3" step="1"
                                                        value="3">
                                                    <span>sec</span>
                                                </div>
                                            </div>
                                            <button type="button" class="lira-duration-chip" data-seconds="60">1M</button>
                                            <button type="button" class="lira-duration-chip active"
                                                data-seconds="300">5M</button>
                                            <button type="button" class="lira-duration-chip" data-seconds="900">15M</button>
                                            <button type="button" class="lira-duration-chip"
                                                data-seconds="1800">30M</button>
                                        </div>
                                    </div>

                                    <div class="lira-trade-actions">
                                        <button type="button" class="lira-order-btn is-buy" id="buyTradeBtn">
                                            <i class="fa-solid fa-arrow-trend-up ms-2"></i>
                                            Buy
                                        </button>

                                        <button type="button" class="lira-order-btn is-sell" id="sellTradeBtn">
                                            <i class="fa-solid fa-arrow-trend-down ms-2"></i>
                                            Sell
                                        </button>
                                    </div>
                                </div>

                                <div class="lira-trade-summary">
                                    <div class="lira-trade-mini-stat">
                                        <span>الصفقات المفتوحة</span>
                                        <strong id="openTradesCount">0</strong>
                                    </div>

                                    <div class="lira-trade-mini-stat">
                                        <span>الصفقات الرابحة</span>
                                        <strong id="winTradesCount">0</strong>
                                    </div>

                                    <div class="lira-trade-mini-stat">
                                        <span>صافي النتائج</span>
                                        <strong id="tradePnlValue">0.00</strong>
                                    </div>
                                </div>

                                <div class="lira-trade-list" id="tradePositionsList">
                                    <div class="lira-empty-trades">لا توجد صفقات حالياً.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="d-flex flex-column gap-3 h-100">
                    <div class="card lira-side-card">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">حالة الحساب</h6>
                            <span class="lira-badge-chip">{{ $aiConfidence }}%</span>
                        </div>
                        <div class="card-body">
                            <div class="lira-account-summary-grid">
                                <div class="lira-summary-row">
                                    <span>الخطة الحالية</span>
                                    <strong>{{ $plan?->name ?? 'غير مفعلة' }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>التحقق</span>
                                    <strong
                                        class="{{ $kycVerified ? 'text-success' : 'text-warning' }}">{{ $kycVerified ? 'موثق' : 'قيد الاستكمال' }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>حالة الذكاء الاصطناعي</span>
                                    <strong>{{ $aiStatus }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>الربح القادم</span>
                                    <strong>{{ formatCurrency($expectedProfit) }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>التاريخ المتوقع</span>
                                    <strong>{{ $nextExpected->format('Y/m/d') }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>أرباح الإحالة</span>
                                    <strong class="text-success">{{ formatCurrency($referralEarnings) }}</strong>
                                </div>
                            </div>

                            @if($plan)
                                <div class="lira-plan-box mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">تقدم الدورة الحالية</span>
                                        <strong class="ycolor">{{ round($progress, 1) }}%</strong>
                                    </div>
                                    <div class="progress lira-progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="lira-quick-actions mt-4">
                                <a href="{{ route('site.deposit') }}" class="btn btn-primary">إضافة رصيد</a>
                                <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}"
                                    class="btn btn-outline-primary">سحب</a>
                                <a href="{{ route('profile') }}" class="btn lira-ghost-btn">التحقق</a>
                            </div>

                            <div class="lira-referral-box mt-4">
                                <label class="form-label small text-muted">رابط الإحالة</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="referralLink"
                                        value="{{ $user->referral_link }}" readonly dir="ltr">
                                    <button class="btn btn-outline-primary" type="button" id="copyReferralBtn"
                                        onclick="copyReferralLink()">نسخ</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xxl-8">
                <div class="card lira-table-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">آخر العمليات المالية</h6>
                            <p class="text-muted mb-0 small">السجل المالي الأهم للحساب.</p>
                        </div>
                        <a href="{{ route('site.transactions.index') }}" class="lira-text-link">عرض الكل</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">البيان</th>
                                        <th>القيمة</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-start">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestTransactions as $tx)
                                        <tr>
                                            <td class="pe-4">{{ $tx->type->getName() }}</td>
                                            <td>{{ formatCurrency($tx->amount) }}</td>
                                            <td>
                                                @if($tx->status == \App\Enums\TransactionStatus::Accepted)
                                                    <span class="lira-result-chip is-profit">مكتمل</span>
                                                @else
                                                    <span class="lira-result-chip is-loss">مرفوض</span>
                                                @endif
                                            </td>
                                            <td class="ps-4 text-start text-muted">{{ $tx->created_at->format('Y/m/d') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="lira-empty-state">لا توجد عمليات مالية حتى الآن.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="card lira-side-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">التنبيهات والطلبات</h6>
                        <span class="lira-badge-chip">{{ $alerts->count() + $pendingRequests->count() }}</span>
                    </div>
                    <div class="card-body">
                        <div class="lira-alert-feed">
                            @forelse($alerts->take(4) as $alert)
                                <div class="lira-alert-item is-{{ $alert['tone'] }}">
                                    <div class="lira-alert-icon">
                                        <i class="fa-solid {{ $alert['icon'] }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between gap-3">
                                            <strong>{{ $alert['title'] }}</strong>
                                            <span class="text-muted small">{{ $alert['time'] }}</span>
                                        </div>
                                        <p class="mb-0">{{ $alert['body'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="lira-empty-state small">لا توجد إشعارات حالياً.</div>
                            @endforelse
                        </div>

                        <div class="lira-subpanel border-top mt-3 pt-3 px-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>الطلبات المعلقة</strong>
                                <a href="{{ route('site.transactions-requests.index') }}" class="lira-text-link">متابعة</a>
                            </div>

                            @forelse($pendingRequests->take(3) as $request)
                                                    <div class="lira-pending-row">
                                                        <div>
                                                            <strong>
                                                                {{ match ($request->type) {
                                    \App\Enums\TransactionRequestType::Deposit => 'طلب إيداع',
                                    \App\Enums\TransactionRequestType::Robot => 'طلب روبوت',
                                    default => 'طلب سحب',
                                } }}
                                                            </strong>
                                                            <span>{{ $request->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="text-start">
                                                            <strong>{{ formatCurrency($request->amount) }}</strong>
                                                            <span class="text-warning">معلق</span>
                                                        </div>
                                                    </div>
                            @empty
                                <div class="lira-empty-state small">لا توجد طلبات قيد المراجعة.</div>
                            @endforelse
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

        .lira-hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .lira-inline-link {
            display: inline-flex;
            align-items: center;
            padding: 0 6px;
        }

        .lira-status-alert {
            border-radius: 18px !important;
            padding: 16px 18px !important;
        }

        .lira-status-strip {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-status-pill {
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-status-pill span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            margin-bottom: 4px;
        }

        .lira-status-pill strong {
            font-size: 14px;
            color: #fff;
        }

        .lira-status-pill.is-success {
            border-color: rgba(23, 178, 106, 0.24);
            background: rgba(23, 178, 106, 0.08);
        }

        .lira-status-pill.is-warning {
            border-color: rgba(120, 97, 255, 0.24);
            background: rgba(120, 97, 255, 0.08);
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

        .lira-stat-card,
        .lira-terminal-card,
        .lira-side-card,
        .lira-table-card {
            overflow: hidden;
        }

        .lira-stat-card {
            min-height: 170px;
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

        .lira-terminal-shell {
            background: radial-gradient(circle at top right, rgba(0, 230, 167, 0.12), transparent 24%), radial-gradient(circle at top left, rgba(88, 132, 255, 0.10), transparent 18%), linear-gradient(180deg, rgba(14, 19, 31, 0.98), rgba(10, 14, 24, 0.98));
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.34);
        }

        .lira-terminal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .lira-terminal-left,
        .lira-terminal-right,
        .lira-terminal-symbol-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .lira-symbol-tabs,
        .lira-timeframe-group {
            display: inline-flex;
            gap: 8px;
            padding: 6px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-symbol-tab,
        .lira-timeframe-chip {
            min-width: 58px;
            height: 40px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: var(--lira-text-muted);
            font-weight: 800;
            transition: 0.22s ease;
            padding: 0 14px;
        }

        .lira-symbol-tab {
            min-width: 92px;
        }

        .lira-symbol-tab:hover,
        .lira-timeframe-chip:hover {
            color: var(--lira-text);
            background: rgba(255, 255, 255, 0.04);
        }

        .lira-symbol-tab.active,
        .lira-timeframe-chip.active {
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.26);
        }

        .lira-terminal-market-wrap {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lira-terminal-market {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-terminal-price {
            font-size: clamp(1.8rem, 2.4vw, 2.8rem);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.04em;
            color: #fff;
        }

        .lira-terminal-stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 8px;
        }

        .lira-terminal-stats--four {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .lira-terminal-stat {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-terminal-stat span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .lira-terminal-stat strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .lira-terminal-stat .is-up {
            color: #4fe0a5;
        }

        .lira-terminal-stat .is-down {
            color: #ff7d8b;
        }

        #chartAreaWrapper {
            position: relative;
            padding-top: 4px;
        }


        .lira-accent-chart {
            position: relative;
            z-index: 2;
            height: 560px;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(19, 24, 40, 0.96), rgba(12, 16, 28, 0.98)), #111827;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04), inset 0 -60px 120px rgba(0, 0, 0, 0.20);
        }

        .lira-btn-expand {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.75);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.22s ease;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .lira-btn-expand:hover {
            background: rgba(0, 230, 167, 0.16);
            color: var(--lira-accent);
        }

        .lira-account-summary-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .lira-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-summary-row span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-summary-row strong {
            font-size: 14px;
            color: #fff;
            text-align: start;
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

        .lira-clean-table thead th {
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-size: 12px !important;
        }

        .lira-clean-table tbody td {
            font-size: 13px;
        }

        .lira-result-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-result-chip.is-profit {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-result-chip.is-loss {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
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

        .lira-text-link {
            color: var(--lira-accent);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .lira-text-link:hover {
            color: var(--lira-accent-strong);
        }

        .lira-referral-box .input-group .btn {
            min-width: 92px;
        }

        .apexcharts-toolbar {
            display: flex !important;
            opacity: 0.9;
            top: 10px !important;
            right: 10px !important;
        }

        .apexcharts-toolbar svg {
            fill: rgba(255, 255, 255, 0.55) !important;
        }

        .apexcharts-toolbar svg:hover {
            fill: var(--lira-accent) !important;
        }

        .lira-analysis-toolbar {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 9;
            display: none;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 10px;
            border-radius: 16px;
            background: rgba(7, 11, 20, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
        }

        .lira-fs-wrapper.is-fullscreen-tools .lira-analysis-toolbar,
        .lira-fs-wrapper:fullscreen .lira-analysis-toolbar,
        .lira-fs-wrapper:-webkit-full-screen .lira-analysis-toolbar {
            display: inline-flex;
        }

        .lira-analysis-btn {
            height: 38px;
            border: 0;
            border-radius: 12px;
            padding: 0 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.06);
            color: #eef2ff;
            font-size: 12px;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .lira-analysis-btn:hover {
            background: rgba(0, 230, 167, 0.16);
            color: var(--lira-accent);
        }

        .lira-analysis-btn.is-active {
            background: rgba(0, 230, 167, 0.18);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.24);
        }

        .lira-analysis-btn.is-danger:hover {
            background: rgba(240, 68, 56, 0.16);
            color: #ff8a80;
        }

        @media (max-width:1199.98px) {
            .lira-status-strip {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .lira-accent-chart {
                height: 500px;
            }
        }

        @media (max-width:991.98px) {

            .lira-status-strip,
            .lira-quick-actions,
            .lira-terminal-stats--four {
                grid-template-columns: 1fr 1fr;
            }

            .lira-accent-chart {
                height: 420px;
            }
        }

        @media (max-width:767.98px) {

            .lira-status-strip,
            .lira-terminal-stats--four,
            .lira-quick-actions {
                grid-template-columns: 1fr;
            }

            .lira-terminal-topbar {
                align-items: stretch;
            }

            .lira-terminal-right,
            .lira-terminal-left,
            .lira-terminal-symbol-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tabs,
            .lira-timeframe-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                flex: 1 1 0;
            }

            .lira-terminal-price {
                font-size: 1.9rem;
            }

            .lira-accent-chart {
                height: 340px;
            }
        }

        .lira-lwc-stage {
            position: relative;
            height: 560px;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(19, 24, 40, 0.96), rgba(12, 16, 28, 0.98)),
                #111827;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.04),
                inset 0 -60px 120px rgba(0, 0, 0, 0.20);
        }

        .lira-lwc-chart {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .lira-draw-layer {
            position: absolute;
            inset: 0;
            z-index: 3;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .lira-trade-tooltip {
            position: absolute;
            z-index: 8;
            min-width: 190px;
            pointer-events: none;
            display: none;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(10, 14, 24, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            color: #fff;
            font-family: 'Cairo', sans-serif;
        }

        .lira-trade-tooltip__time {
            color: rgba(255, 255, 255, 0.65);
            font-size: 11px;
            margin-bottom: 10px;
        }

        .lira-trade-tooltip__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 12px;
        }

        .lira-trade-tooltip__item span {
            display: block;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .lira-trade-tooltip__item strong {
            font-size: 13px;
            color: #fff;
        }

        .lira-draw-toolbar-wrap {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 9;
            display: none;
        }

        .lira-fs-wrapper.is-fullscreen-tools .lira-draw-toolbar-wrap,
        .lira-fs-wrapper:fullscreen .lira-draw-toolbar-wrap,
        .lira-fs-wrapper:-webkit-full-screen .lira-draw-toolbar-wrap {
            display: block;
        }

        .lira-draw-toggle {
            height: 42px;
            border: 0;
            border-radius: 14px;
            padding: 0 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(7, 11, 20, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #eef2ff;
            font-size: 12px;
            font-weight: 800;
            backdrop-filter: blur(12px);
        }

        .lira-draw-toggle:hover {
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
        }

        .lira-draw-menu {
            display: none;
            position: absolute;
            top: 52px;
            left: 0;
            width: 240px;
            padding: 10px;
            border-radius: 16px;
            background: rgba(17, 24, 39, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(14px);
        }

        .lira-draw-menu.is-open {
            display: block;
        }

        .lira-draw-item {
            width: 100%;
            height: 40px;
            border: 0;
            border-radius: 12px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: #d7deee;
            font-size: 13px;
            font-weight: 700;
            text-align: start;
        }

        .lira-draw-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .lira-draw-item.is-active {
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.24);
        }

        .lira-draw-sep {
            height: 1px;
            margin: 8px 0;
            background: rgba(255, 255, 255, 0.08);
        }

        .lira-fs-wrapper:fullscreen,
        .lira-fs-wrapper:-webkit-full-screen {
            background: #0b1020;
            padding: 0;
            overflow: hidden;
        }

        .lira-fs-wrapper:fullscreen .lira-terminal-shell,
        .lira-fs-wrapper:-webkit-full-screen .lira-terminal-shell {
            height: 100dvh !important;
            border-radius: 0 !important;
            border: 0 !important;
            display: flex;
            flex-direction: column;
        }

        .lira-fs-wrapper:fullscreen .card-header,
        .lira-fs-wrapper:-webkit-full-screen .card-header {
            position: sticky;
            top: 0;
            z-index: 12;
            padding: 12px 12px 8px !important;
            background: linear-gradient(180deg, rgba(10, 14, 24, 0.96), rgba(10, 14, 24, 0.82));
            backdrop-filter: blur(12px);
        }

        .lira-fs-wrapper:fullscreen #chartAreaWrapper,
        .lira-fs-wrapper:-webkit-full-screen #chartAreaWrapper {
            flex: 1 1 auto;
            min-height: 0;
            padding: 8px 8px 10px !important;
        }

        .lira-fs-wrapper:fullscreen .lira-lwc-stage,
        .lira-fs-wrapper:-webkit-full-screen .lira-lwc-stage {
            height: 100% !important;
            border-radius: 16px !important;
        }

        .lira-fs-wrapper:fullscreen .lira-draw-toolbar-wrap,
        .lira-fs-wrapper:-webkit-full-screen .lira-draw-toolbar-wrap {
            top: 10px;
            left: 10px;
            right: 10px;
        }

        .lira-fs-wrapper:fullscreen .lira-draw-toggle,
        .lira-fs-wrapper:-webkit-full-screen .lira-draw-toggle {
            width: 100%;
            justify-content: space-between;
        }

        .lira-fs-wrapper:fullscreen .lira-draw-menu,
        .lira-fs-wrapper:-webkit-full-screen .lira-draw-menu {
            left: 0;
            right: 0;
            top: 52px;
            width: auto;
            max-height: min(46dvh, 380px);
            overflow: auto;
        }

        @media (max-width: 767.98px) {
            .lira-terminal-stats--four {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-terminal-stat {
                padding: 10px 12px;
            }

            .lira-terminal-stat strong {
                font-size: 13px;
            }

            .lira-terminal-stat span {
                font-size: 10px;
            }

            .lira-terminal-price {
                font-size: 1.5rem;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                min-width: 0;
                height: 36px;
                padding: 0 10px;
                font-size: 12px;
            }

            .lira-fs-wrapper:fullscreen .lira-terminal-topbar,
            .lira-fs-wrapper:-webkit-full-screen .lira-terminal-topbar {
                gap: 10px;
                margin-bottom: 10px;
            }

            .lira-fs-wrapper:fullscreen .lira-terminal-left,
            .lira-fs-wrapper:fullscreen .lira-terminal-right,
            .lira-fs-wrapper:fullscreen .lira-terminal-symbol-group,
            .lira-fs-wrapper:-webkit-full-screen .lira-terminal-left,
            .lira-fs-wrapper:-webkit-full-screen .lira-terminal-right,
            .lira-fs-wrapper:-webkit-full-screen .lira-terminal-symbol-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-fs-wrapper:fullscreen .lira-symbol-tabs,
            .lira-fs-wrapper:fullscreen .lira-timeframe-group,
            .lira-fs-wrapper:-webkit-full-screen .lira-symbol-tabs,
            .lira-fs-wrapper:-webkit-full-screen .lira-timeframe-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-fs-wrapper:fullscreen .lira-draw-toolbar-wrap,
            .lira-fs-wrapper:-webkit-full-screen .lira-draw-toolbar-wrap {
                top: auto;
                bottom: 10px;
                left: 10px;
                right: 10px;
            }

            .lira-fs-wrapper:fullscreen .lira-draw-menu,
            .lira-fs-wrapper:-webkit-full-screen .lira-draw-menu {
                top: auto;
                bottom: 52px;
            }

            .lira-trade-tooltip {
                display: none !important;
            }
        }

        @media (max-width: 1199.98px) {
            .lira-lwc-stage {
                height: 500px;
            }
        }

        @media (max-width: 991.98px) {
            .lira-lwc-stage {
                height: 420px;
            }
        }

        @media (max-width: 767.98px) {
            .lira-lwc-stage {
                height: 340px;
            }

            .lira-draw-menu {
                width: 220px;
            }
        }

        /* =========================
                                                                                       Mobile polish patch
                                                                                       add at the END of custom_styles
                                                                                       ========================= */

        @media (max-width: 991.98px) {
            .lira-page-header {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .lira-page-title {
                font-size: clamp(1.5rem, 6vw, 2rem);
                line-height: 1.25;
            }

            .lira-page-subtitle {
                font-size: 14px;
                line-height: 1.8;
                max-width: 100%;
            }

            .lira-hero-actions {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .lira-hero-actions .btn,
            .lira-hero-actions .lira-inline-link {
                width: 100%;
                min-height: 44px;
                justify-content: center;
            }

            .lira-hero-actions .lira-inline-link {
                padding: 10px 12px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.06);
            }
        }

        @media (max-width: 767.98px) {
            .lira-dashboard-page {
                --page-gap: 14px;
            }

            .lira-page-header {
                margin-bottom: 18px !important;
            }

            .lira-page-title {
                font-size: 1.45rem;
            }

            .lira-page-subtitle {
                font-size: 13px;
            }

            /* status strip: better balance on phones */
            .lira-status-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .lira-status-pill {
                min-height: 72px;
                padding: 10px 12px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .lira-status-pill span {
                font-size: 10px;
                margin-bottom: 3px;
            }

            .lira-status-pill strong {
                font-size: 13px;
                line-height: 1.35;
            }

            /* cards */
            .lira-stat-card {
                min-height: auto;
            }

            .lira-stat-card .card-body,
            .lira-side-card .card-body,
            .lira-table-card .card-body {
                padding: 16px;
            }

            .lira-stat-top {
                margin-bottom: 14px;
                gap: 12px;
            }

            .lira-stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 14px;
                font-size: 16px;
            }

            .lira-stat-value {
                font-size: 1.35rem;
                margin-bottom: 8px;
            }

            .lira-stat-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            /* trading card */
            .lira-terminal-card .card-header {
                padding: 16px 16px 0;
            }

            .lira-terminal-topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                margin-bottom: 12px;
            }

            .lira-terminal-left,
            .lira-terminal-right,
            .lira-terminal-symbol-group {
                width: 100%;
            }

            .lira-terminal-symbol-group {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .lira-terminal-market-wrap {
                padding-inline: 2px;
            }

            .lira-terminal-market {
                font-size: 11px;
            }

            .lira-terminal-price {
                font-size: 1.45rem;
            }

            .lira-terminal-right {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .lira-timeframe-group {
                flex: 1 1 auto;
            }

            .lira-btn-expand {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                flex: 0 0 40px;
            }

            .lira-terminal-stats--four {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-terminal-stat {
                padding: 10px 12px;
                border-radius: 14px;
            }

            .lira-terminal-stat span {
                font-size: 10px;
            }

            .lira-terminal-stat strong {
                font-size: 13px;
            }

            .lira-lwc-stage {
                height: 300px;
                border-radius: 18px;
            }

            .lira-draw-menu {
                width: 220px;
            }

            /* account summary */
            .lira-summary-row {
                padding: 10px 12px;
                align-items: flex-start;
            }

            .lira-summary-row span {
                font-size: 11px;
            }

            .lira-summary-row strong {
                font-size: 13px;
                max-width: 52%;
            }

            .lira-plan-box {
                padding: 14px;
                border-radius: 16px;
            }

            .lira-quick-actions {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .lira-quick-actions .btn:last-child {
                grid-column: 1 / -1;
            }

            .lira-referral-box .input-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .lira-referral-box .input-group>.form-control,
            .lira-referral-box .input-group>.btn {
                width: 100%;
                border-radius: 12px !important;
            }

            .lira-referral-box .input-group>.btn {
                min-height: 44px;
            }

            /* alerts / pending */
            .lira-alert-item {
                padding: 12px;
                border-radius: 14px;
            }

            .lira-alert-item p {
                line-height: 1.6;
            }

            .lira-pending-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .lira-pending-row .text-start {
                text-align: start !important;
            }

            /* table -> mobile cards */
            .lira-table-card .table-responsive {
                overflow: visible;
            }

            .lira-clean-table thead {
                display: none;
            }

            .lira-clean-table,
            .lira-clean-table tbody,
            .lira-clean-table tr,
            .lira-clean-table td {
                display: block;
                width: 100%;
            }

            .lira-clean-table tbody {
                padding: 12px;
            }

            .lira-clean-table tbody tr {
                padding: 12px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(255, 255, 255, 0.05);
                margin-bottom: 10px;
            }

            .lira-clean-table tbody tr:last-child {
                margin-bottom: 0;
            }

            .lira-clean-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                padding: 6px 0 !important;
                border: 0 !important;
                text-align: start !important;
            }

            .lira-clean-table tbody td::before {
                color: var(--lira-text-muted);
                font-size: 11px;
                font-weight: 700;
                flex: 0 0 auto;
            }

            .lira-clean-table tbody td:nth-child(1)::before {
                content: "البيان";
            }

            .lira-clean-table tbody td:nth-child(2)::before {
                content: "القيمة";
            }

            .lira-clean-table tbody td:nth-child(3)::before {
                content: "الحالة";
            }

            .lira-clean-table tbody td:nth-child(4)::before {
                content: "التاريخ";
            }

            .lira-clean-table tbody td[colspan] {
                display: block;
                text-align: center !important;
            }

            .lira-clean-table tbody td[colspan]::before {
                content: none !important;
            }

            .lira-empty-state {
                min-height: 80px;
                padding: 10px;
            }
        }

        @media (max-width: 420px) {

            .lira-hero-actions,
            .lira-status-strip,
            .lira-quick-actions,
            .lira-terminal-stats--four {
                grid-template-columns: 1fr;
            }

            .lira-terminal-price {
                font-size: 1.3rem;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                height: 34px;
                font-size: 11px;
                padding: 0 8px;
            }

            .lira-lwc-stage {
                height: 280px;
            }

            .lira-btn-expand {
                display: none;
            }
        }

        /* =========================
                                                                                   Mobile chart expanded mode
                                                                                   Add at END of custom_styles
                                                                                   ========================= */

        @media (max-width: 767.98px) {
            .lira-btn-expand {
                display: inline-flex !important;
            }

            .lira-terminal-card .card-header {
                padding: 14px 14px 0;
            }

            .lira-terminal-topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .lira-terminal-left,
            .lira-terminal-right,
            .lira-terminal-symbol-group {
                width: 100%;
            }

            .lira-terminal-symbol-group {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .lira-terminal-right {
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .lira-timeframe-group {
                flex: 1 1 auto;
            }

            .lira-symbol-tabs,
            .lira-timeframe-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                flex: 1 1 0;
                min-width: 0;
                height: 40px;
                font-size: 12px;
            }

            .lira-terminal-stats--four {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-terminal-stat {
                padding: 10px 12px;
                border-radius: 14px;
            }

            .lira-terminal-stat span {
                font-size: 10px;
            }

            .lira-terminal-stat strong {
                font-size: 13px;
            }

            .lira-lwc-stage {
                height: 360px;
            }

            .lira-draw-toolbar-wrap {
                display: block;
            }
        }

        /* never hide expand button on mobile */
        @media (max-width: 420px) {
            .lira-btn-expand {
                display: inline-flex !important;
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
            }

            .lira-lwc-stage {
                height: 320px;
            }
        }

        /* fixed mobile expanded mode fallback */
        .lira-fs-wrapper.is-mobile-expanded {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #0b1020;
            padding: 0;
            margin: 0;
            width: 100vw;
            height: 100dvh;
        }

        .lira-fs-wrapper.is-mobile-expanded .lira-terminal-shell {
            height: 100dvh !important;
            border-radius: 0 !important;
            border: 0 !important;
            display: flex;
            flex-direction: column;
        }

        .lira-fs-wrapper.is-mobile-expanded .card-header {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: 12px 12px 8px !important;
            background: linear-gradient(180deg, rgba(10, 14, 24, 0.98), rgba(10, 14, 24, 0.84));
            backdrop-filter: blur(12px);
        }

        .lira-fs-wrapper.is-mobile-expanded #chartAreaWrapper {
            flex: 1 1 auto;
            min-height: 0;
            padding: 8px 8px 88px !important;
        }

        .lira-fs-wrapper.is-mobile-expanded .lira-lwc-stage {
            height: 100% !important;
            min-height: 0;
            border-radius: 14px !important;
        }

        /* mobile tools become bottom sheet style */
        .lira-fs-wrapper.is-mobile-expanded .lira-draw-toolbar-wrap {
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 10px;
            top: auto;
            z-index: 30;
            display: block;
        }

        .lira-fs-wrapper.is-mobile-expanded .lira-draw-toggle {
            width: 100%;
            min-height: 48px;
            border-radius: 14px;
            justify-content: space-between;
            font-size: 13px;
            padding: 0 14px;
        }

        .lira-fs-wrapper.is-mobile-expanded .lira-draw-menu {
            left: 0;
            right: 0;
            top: auto;
            bottom: 56px;
            width: auto;
            max-height: min(52dvh, 420px);
            overflow: auto;
            border-radius: 16px;
            padding: 10px;
        }

        .lira-fs-wrapper.is-mobile-expanded .lira-draw-item {
            min-height: 46px;
            border-radius: 12px;
            font-size: 14px;
        }

        /* allow tools in both real fullscreen and mobile fallback */
        .lira-fs-wrapper.is-mobile-expanded .lira-draw-toolbar-wrap,
        .lira-fs-wrapper.is-mobile-expanded .lira-analysis-toolbar {
            display: block;
        }

        /* safer tooltip behavior on touch */
        @media (max-width: 767.98px) {
            .lira-trade-tooltip {
                display: none !important;
            }

            .lira-draw-toggle,
            .lira-draw-item,
            .lira-symbol-tab,
            .lira-timeframe-chip,
            .lira-btn-expand {
                touch-action: manipulation;
            }
        }

        /* lock page scroll when chart is expanded */
        body.lira-mobile-chart-open {
            overflow: hidden;
            touch-action: none;
        }

        /* =========================
                                                                               Trade dock
                                                                               ========================= */

        .lira-trade-dock {
            margin-top: 14px;
            padding: 16px;
            border-radius: 20px;
            background:
                linear-gradient(180deg, rgba(15, 20, 33, 0.96), rgba(11, 15, 25, 0.98));
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
        }

        .lira-trade-dock__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .lira-trade-dock__eyebrow {
            display: block;
            font-size: 11px;
            letter-spacing: 0.08em;
            color: var(--lira-text-muted);
            margin-bottom: 4px;
        }

        .lira-trade-dock__title {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .lira-trade-mode-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 84px;
            height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
            font-size: 12px;
            font-weight: 800;
            border: 1px solid rgba(0, 230, 167, 0.22);
        }

        .lira-trade-mode-pill.is-simulated {
            background: rgba(88, 132, 255, 0.12);
            color: #8fb0ff;
            border-color: rgba(88, 132, 255, 0.22);
        }

        .lira-trade-form {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr) 220px;
            gap: 12px;
            align-items: end;
        }

        .lira-trade-field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--lira-text-muted);
            margin-bottom: 8px;
        }

        .lira-trade-input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 48px;
            padding: 0 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-trade-input-wrap input {
            flex: 1 1 auto;
            background: transparent;
            border: 0;
            outline: 0;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .lira-trade-input-wrap span {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-duration-group {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
        }

        .lira-duration-chip {
            height: 48px;
            border: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 800;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            transition: 0.2s ease;
        }

        .lira-duration-chip:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .lira-duration-chip.active {
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.24);
        }

        .lira-trade-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .lira-order-btn {
            height: 48px;
            border: 0;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .lira-order-btn.is-buy {
            background: rgba(23, 178, 106, 0.14);
            color: #63ddab;
            box-shadow: inset 0 0 0 1px rgba(23, 178, 106, 0.2);
        }

        .lira-order-btn.is-buy:hover {
            background: rgba(23, 178, 106, 0.2);
        }

        .lira-order-btn.is-sell {
            background: rgba(240, 68, 56, 0.14);
            color: #ff9a8f;
            box-shadow: inset 0 0 0 1px rgba(240, 68, 56, 0.2);
        }

        .lira-order-btn.is-sell:hover {
            background: rgba(240, 68, 56, 0.2);
        }

        .lira-trade-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }

        .lira-trade-mini-stat {
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-trade-mini-stat span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            margin-bottom: 4px;
        }

        .lira-trade-mini-stat strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .lira-trade-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 14px;
        }

        .lira-trade-row {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-trade-row__left strong,
        .lira-trade-row__right strong {
            display: block;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-trade-row__left span,
        .lira-trade-row__right span {
            display: block;
            margin-top: 3px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-trade-side {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-trade-side.is-buy {
            background: rgba(23, 178, 106, 0.14);
            color: #63ddab;
        }

        .lira-trade-side.is-sell {
            background: rgba(240, 68, 56, 0.14);
            color: #ff9a8f;
        }

        .lira-empty-trades {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 72px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.08);
            color: var(--lira-text-muted);
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 1199.98px) {
            .lira-trade-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .lira-trade-dock {
                padding: 14px;
                border-radius: 18px;
            }

            .lira-trade-dock__head {
                flex-direction: column;
                align-items: stretch;
            }

            .lira-duration-group,
            .lira-trade-actions,
            .lira-trade-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lira-trade-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        @media (max-width: 420px) {

            .lira-duration-group,
            .lira-trade-actions,
            .lira-trade-summary {
                grid-template-columns: 1fr;
            }
        }

        .lira-custom-duration {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .lira-custom-duration__input {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            min-width: 120px;
            padding: 0 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-custom-duration__input input {
            width: 100%;
            background: transparent;
            border: 0;
            outline: 0;
            color: #fff;
            font-size: 14px;
            font-weight: 800;
        }

        .lira-custom-duration__input span {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 767.98px) {
            .lira-custom-duration {
                flex-direction: column;
                align-items: stretch;
            }

            .lira-custom-duration__input {
                width: 100%;
            }
        }

        .lira-trade-dock {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 22px;
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.08), transparent 28%),
                linear-gradient(180deg, rgba(15, 20, 33, 0.98), rgba(11, 15, 25, 0.98));
        }

        .lira-trade-dock::before {
            content: "";
            position: absolute;
            top: 0;
            left: 18px;
            right: 18px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 230, 167, 0.45), transparent);
        }

        .lira-order-btn {
            height: 52px;
            border-radius: 16px;
        }

        .lira-trade-row {
            display: block;
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.015));
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-trade-row__top {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 12px;
            align-items: center;
        }

        .lira-trade-row__symbol strong,
        .lira-trade-row__meta strong {
            display: block;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-trade-row__symbol span,
        .lira-trade-row__meta span {
            display: block;
            margin-top: 4px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-trade-row__meta {
            text-align: end;
        }

        .lira-trade-row__progress {
            margin-top: 12px;
            height: 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            overflow: hidden;
        }

        .lira-trade-row__progress span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, rgba(0, 230, 167, 0.35), rgba(0, 230, 167, 0.95));
        }

        .lira-trade-row.is-buy .lira-trade-row__progress span {
            background: linear-gradient(90deg, rgba(23, 178, 106, 0.35), rgba(99, 221, 171, 0.95));
        }

        .lira-trade-row.is-sell .lira-trade-row__progress span {
            background: linear-gradient(90deg, rgba(240, 68, 56, 0.35), rgba(255, 154, 143, 0.95));
        }

        @media (max-width: 767.98px) {
            .lira-trade-row__top {
                grid-template-columns: 1fr;
            }

            .lira-trade-row__meta {
                text-align: start;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const chartHost = document.getElementById('tradeChart');
            if (!chartHost || typeof LightweightCharts === 'undefined') return;

            const {
                createChart,
                CrosshairMode,
                LineStyle,
                CandlestickSeries,
            } = LightweightCharts;

            const symbolMap = {
                XAUUSD: { rest: 'PAXGUSDT', stream: 'paxgusdt', name: 'Gold / US Dollar' },
                BTCUSD: { rest: 'BTCUSDT', stream: 'btcusdt', name: 'Bitcoin / US Dollar' },
            };

            const priceEl = document.getElementById('goldSpotPrice');
            const changeEl = document.getElementById('goldPriceChange');
            const hoveredPriceEl = document.getElementById('goldHoveredPrice');
            const hoveredTimeEl = document.getElementById('goldHoveredTime');
            const rangeEl = document.getElementById('goldRangeText');
            const marketEl = document.getElementById('marketLabel');
            const tradeAmountInput = document.getElementById('tradeAmountInput');
            const tradeDurationGroup = document.getElementById('tradeDurationGroup');
            const buyTradeBtn = document.getElementById('buyTradeBtn');
            const sellTradeBtn = document.getElementById('sellTradeBtn');
            const tradePositionsList = document.getElementById('tradePositionsList');
            const openTradesCountEl = document.getElementById('openTradesCount');
            const winTradesCountEl = document.getElementById('winTradesCount');
            const tradePnlValueEl = document.getElementById('tradePnlValue');
            const tradeModePill = document.getElementById('tradeModePill');
            const fsTarget = document.getElementById('chartFullscreenTarget');
            const fsBtn = document.getElementById('toggleFullscreenBtn');

            const customDurationBtn = document.getElementById('customDurationBtn');
            const customDurationInput = document.getElementById('customDurationInput');
            const drawMenuToggle = document.getElementById('drawMenuToggle');
            const drawMenu = document.getElementById('drawMenu');
            const activeToolLabel = document.getElementById('activeToolLabel');
            const drawLayer = document.getElementById('tradeDrawLayer');
            const tooltipEl = document.getElementById('tradeTooltip');

            const symbolTabs = document.querySelectorAll('.lira-symbol-tab');
            const timeframeBtns = document.querySelectorAll('.lira-timeframe-chip');

            let currentSymbol = 'XAUUSD';
            let activeInterval = '5m';
            let bars = [];
            let currentTool = 'cursor';
            let followLive = true;
            let socket = null;
            let reconnectTimer = null;
            let streamGeneration = 0;

            let syntheticMode = false;
            let syntheticTimer = null;
            let tradeDurationSeconds = 300;
            let tradeId = 1;
            let trades = [];
            let closedTrades = [];

            let drawings = [];
            let draftDrawing = null;
            let pointer = null;
            let dragTarget = null;
            let isDraggingDrawing = false;

            const ctx = drawLayer.getContext('2d');
            let chart;
            let candleSeries;
            let resizeObserver;

            function formatNum(n, digits = 2) {
                return Number(n).toLocaleString('en-US', {
                    minimumFractionDigits: digits,
                    maximumFractionDigits: digits,
                });
            }

            function formatTime(ts) {
                return new Date(ts * 1000).toLocaleString('en-GB', {
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                });
            }

            function toBar(k) {
                return {
                    time: Math.floor(k[0] / 1000),
                    open: +parseFloat(k[1]).toFixed(2),
                    high: +parseFloat(k[2]).toFixed(2),
                    low: +parseFloat(k[3]).toFixed(2),
                    close: +parseFloat(k[4]).toFixed(2),
                };
            }

            async function fetchCandles(symbol, interval) {
                const pair = symbolMap[symbol];

                try {
                    const res = await fetch(`https://api.binance.com/api/v3/klines?symbol=${pair.rest}&interval=${interval}&limit=800`, {
                        cache: 'no-store',
                    });

                    if (!res.ok) throw new Error('Failed to fetch candles');

                    syntheticMode = false;
                    setTradeModePill();

                    const json = await res.json();
                    return json.map(toBar);
                } catch (_) {
                    syntheticMode = true;
                    setTradeModePill();
                    return generateSyntheticCandles(symbol, interval, 600);
                }
            }

            function updateTopMeta(data) {
                if (!data.length) return;

                const first = data[0].open;
                const last = data[data.length - 1].close;
                const diff = last - first;
                const pct = first ? (diff / first) * 100 : 0;
                const high = Math.max(...data.map(d => d.high));
                const low = Math.min(...data.map(d => d.low));

                priceEl.textContent = formatNum(last);
                changeEl.className = pct >= 0 ? 'is-up' : 'is-down';
                changeEl.textContent = `${diff >= 0 ? '+' : ''}${formatNum(diff)} (${pct >= 0 ? '+' : ''}${pct.toFixed(2)}%)`;
                rangeEl.textContent = `${formatNum(low)} - ${formatNum(high)}`;
                marketEl.textContent = symbolMap[currentSymbol].name;
            }

            function setHovered(bar) {
                if (!bar) return;
                hoveredPriceEl.textContent = formatNum(bar.close);
                hoveredTimeEl.textContent = formatTime(bar.time);
            }

            function setTool(tool) {
                currentTool = tool;
                activeToolLabel.textContent =
                    tool === 'cursor' ? 'Cursor' :
                        tool === 'hline' ? 'Horizontal Line' :
                            tool === 'vline' ? 'Vertical Line' :
                                tool === 'trend' ? 'Trend Line' :
                                    tool === 'rect' ? 'Rectangle' :
                                        'Cursor';

                document.querySelectorAll('.lira-draw-item[data-tool]').forEach(btn => {
                    btn.classList.toggle('is-active', btn.dataset.tool === tool);
                });

                drawLayer.style.pointerEvents = tool === 'cursor' ? 'none' : 'auto';
                draftDrawing = null;
                dragTarget = null;
                isDraggingDrawing = false;
                requestOverlayDraw();
            }

            function syncCanvasSize() {
                const rect = drawLayer.getBoundingClientRect();
                const dpr = window.devicePixelRatio || 1;

                drawLayer.width = Math.round(rect.width * dpr);
                drawLayer.height = Math.round(rect.height * dpr);
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                requestOverlayDraw();
            }

            function logicalToX(logical) {
                return chart.timeScale().logicalToCoordinate(logical);
            }

            function xToLogical(x) {
                return chart.timeScale().coordinateToLogical(x);
            }

            function priceToY(price) {
                return candleSeries.priceToCoordinate(price);
            }

            function yToPrice(y) {
                return candleSeries.coordinateToPrice(y);
            }

            function domainPointFromEvent(evt) {
                const rect = drawLayer.getBoundingClientRect();
                const x = evt.clientX - rect.left;
                const y = evt.clientY - rect.top;

                return {
                    x,
                    y,
                    logical: xToLogical(x),
                    price: yToPrice(y),
                };
            }

            function requestOverlayDraw() {
                window.requestAnimationFrame(drawOverlay);
            }

            function drawLine(x1, y1, x2, y2, color = '#00e6a7', width = 1.5, dashed = false) {
                if ([x1, y1, x2, y2].some(v => v === null || v === undefined)) return;
                ctx.save();
                ctx.strokeStyle = color;
                ctx.lineWidth = width;
                if (dashed) ctx.setLineDash([6, 6]);
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.restore();
            }

            function drawRect(x1, y1, x2, y2) {
                if ([x1, y1, x2, y2].some(v => v === null || v === undefined)) return;
                const left = Math.min(x1, x2);
                const top = Math.min(y1, y2);
                const width = Math.abs(x2 - x1);
                const height = Math.abs(y2 - y1);

                ctx.save();
                ctx.fillStyle = 'rgba(0, 230, 167, 0.10)';
                ctx.strokeStyle = 'rgba(0, 230, 167, 0.85)';
                ctx.lineWidth = 1.2;
                ctx.fillRect(left, top, width, height);
                ctx.strokeRect(left, top, width, height);
                ctx.restore();
            }

            function findDrawingHit(x, y) {
                for (let i = drawings.length - 1; i >= 0; i--) {
                    const item = drawings[i];

                    if (item.type === 'hline') {
                        const yy = priceToY(item.price);
                        if (yy != null && Math.abs(y - yy) <= 8) {
                            return { index: i, type: 'hline' };
                        }
                    }

                    if (item.type === 'vline') {
                        const xx = logicalToX(item.logical);
                        if (xx != null && Math.abs(x - xx) <= 8) {
                            return { index: i, type: 'vline' };
                        }
                    }
                }

                return null;
            }

            function updateDraggedDrawing(hit, point) {
                if (!hit || !point) return;

                const item = drawings[hit.index];
                if (!item) return;

                if (item.type === 'hline' && point.price != null) {
                    item.price = point.price;
                }

                if (item.type === 'vline' && point.logical != null) {
                    item.logical = point.logical;
                }

                requestOverlayDraw();
            }

            function drawOverlay() {
                const rect = drawLayer.getBoundingClientRect();
                ctx.clearRect(0, 0, rect.width, rect.height);

                for (const item of drawings) {
                    if (item.type === 'hline') {
                        const y = priceToY(item.price);
                        drawLine(0, y, rect.width, y, '#00e6a7', 1.3, true);
                    }

                    if (item.type === 'vline') {
                        const x = logicalToX(item.logical);
                        drawLine(x, 0, x, rect.height, 'rgba(255,255,255,0.55)', 1.2, true);
                    }

                    if (item.type === 'trend') {
                        drawLine(
                            logicalToX(item.startLogical),
                            priceToY(item.startPrice),
                            logicalToX(item.endLogical),
                            priceToY(item.endPrice),
                            '#4fe0a5',
                            1.6,
                            false
                        );
                    }

                    if (item.type === 'rect') {
                        drawRect(
                            logicalToX(item.startLogical),
                            priceToY(item.startPrice),
                            logicalToX(item.endLogical),
                            priceToY(item.endPrice)
                        );
                    }
                }

                if (draftDrawing) {
                    if (draftDrawing.type === 'trend' && pointer) {
                        drawLine(
                            logicalToX(draftDrawing.startLogical),
                            priceToY(draftDrawing.startPrice),
                            pointer.x,
                            pointer.y,
                            '#7aa2ff',
                            1.5,
                            true
                        );
                    }

                    if (draftDrawing.type === 'rect' && pointer) {
                        drawRect(
                            logicalToX(draftDrawing.startLogical),
                            priceToY(draftDrawing.startPrice),
                            pointer.x,
                            pointer.y
                        );
                    }
                }
                for (const trade of trades) {
                    const y = priceToY(trade.entryPrice);
                    if (y == null) continue;

                    const lineColor = trade.side === 'buy' ? '#31c48d' : '#f97066';
                    const label = `${trade.side === 'buy' ? 'BUY' : 'SELL'} · ${formatNum(trade.entryPrice)}`;

                    drawLine(rect.width - 150, y, rect.width - 14, y, lineColor, 1.35, false);
                    drawTradeLabel(rect.width - 12, y, label, lineColor);
                }
            }

            function clearDrawings() {
                drawings = [];
                draftDrawing = null;
                dragTarget = null;
                isDraggingDrawing = false;
                requestOverlayDraw();
            }

            function intervalToMs(interval) {
                return interval === '1h' ? 3600000 : interval === '1m' ? 60000 : 300000;
            }

            function formatDuration(seconds) {
                if (seconds < 60) return `${Math.round(seconds)}S`;
                if (seconds >= 3600) return `${Math.round(seconds / 3600)}H`;
                return `${Math.round(seconds / 60)}M`;
            }

            function setActiveDurationChip(target) {
                document.querySelectorAll('.lira-duration-chip').forEach(btn => {
                    btn.classList.remove('active');
                });

                if (target) {
                    target.classList.add('active');
                }
            }

            function setTradeModePill() {
                if (!tradeModePill) return;
                tradeModePill.textContent = syntheticMode ? 'Simulation' : 'Live';
                tradeModePill.classList.toggle('is-simulated', syntheticMode);
            }

            function getCurrentPrice() {
                return bars.length ? bars[bars.length - 1].close : null;
            }

            function getBaseSyntheticPrice(symbol) {
                return symbol === 'BTCUSD' ? 68450 : 2034.6;
            }

            function generateSyntheticCandles(symbol, interval, count = 500) {
                const out = [];
                const stepMs = intervalToMs(interval);
                const now = Date.now();
                let price = getBaseSyntheticPrice(symbol);
                let time = now - (count * stepMs);

                for (let i = 0; i < count; i++) {
                    const drift = (Math.random() - 0.5) * (symbol === 'BTCUSD' ? 180 : 4.5);
                    const spread = Math.abs((Math.random() * (symbol === 'BTCUSD' ? 90 : 2.2)));
                    const open = price;
                    const close = Math.max(1, open + drift);
                    const high = Math.max(open, close) + spread;
                    const low = Math.max(0.01, Math.min(open, close) - spread);

                    out.push({
                        time: Math.floor(time / 1000),
                        open: +open.toFixed(2),
                        high: +high.toFixed(2),
                        low: +low.toFixed(2),
                        close: +close.toFixed(2),
                    });

                    price = close;
                    time += stepMs;
                }

                return out;
            }

            function applyRealtimeBar(bar) {
                const last = bars[bars.length - 1];

                if (!last || last.time !== bar.time) {
                    bars.push(bar);
                    if (bars.length > 2000) bars.shift();
                } else {
                    bars[bars.length - 1] = bar;
                }

                candleSeries.update(bar);
                updateTopMeta(bars);
                setHovered(bar);

                if (followLive) {
                    chart.timeScale().scrollToRealTime();
                }

                settleExpiredTrades();
                requestOverlayDraw();
                renderTrades();
            }

            let syntheticBarOpenedAtMs = 0;
            let syntheticLastPrice = null;

            function getSyntheticBarRuntimeMs() {
                return activeInterval === '1m' ? 7000 : activeInterval === '5m' ? 12000 : 18000;
            }

            function nextSyntheticPrice() {
                const anchor = bars.length ? bars[bars.length - 1].close : getBaseSyntheticPrice(currentSymbol);

                if (syntheticLastPrice == null) {
                    syntheticLastPrice = anchor;
                }

                const volatility = currentSymbol === 'BTCUSD' ? 18 : 0.45;
                const drift = (Math.random() - 0.5) * volatility;
                const meanPull = (anchor - syntheticLastPrice) * 0.08;

                syntheticLastPrice = Math.max(1, syntheticLastPrice + drift + meanPull);
                return +syntheticLastPrice.toFixed(2);
            }

            function startSyntheticStream() {
                if (syntheticTimer) {
                    clearInterval(syntheticTimer);
                    syntheticTimer = null;
                }

                if (!bars.length) return;

                syntheticBarOpenedAtMs = Date.now();
                syntheticLastPrice = bars[bars.length - 1].close;

                syntheticTimer = setInterval(() => {
                    const last = bars[bars.length - 1];
                    if (!last) return;

                    const nextPrice = nextSyntheticPrice();
                    const runtimeMs = getSyntheticBarRuntimeMs();
                    const elapsed = Date.now() - syntheticBarOpenedAtMs;

                    if (elapsed >= runtimeMs) {
                        syntheticBarOpenedAtMs = Date.now();

                        const nextBar = {
                            time: last.time + Math.floor(intervalToMs(activeInterval) / 1000),
                            open: +last.close.toFixed(2),
                            high: Math.max(last.close, nextPrice),
                            low: Math.min(last.close, nextPrice),
                            close: nextPrice,
                        };

                        applyRealtimeBar(nextBar);
                        return;
                    }

                    const intrabar = {
                        ...last,
                        high: Math.max(last.high, nextPrice),
                        low: Math.min(last.low, nextPrice),
                        close: nextPrice,
                    };

                    applyRealtimeBar(intrabar);
                }, 220);
            }

            function renderTrades() {
                if (!tradePositionsList) return;

                if (!trades.length) {
                    tradePositionsList.innerHTML = '<div class="lira-empty-trades">لا توجد صفقات حالياً.</div>';
                } else {
                    tradePositionsList.innerHTML = trades.map(trade => {
                        const secondsLeft = Math.max(0, Math.ceil((trade.expireAt - Date.now()) / 1000));
                        const progress = Math.min(
                            100,
                            Math.max(0, ((Date.now() - trade.openedAt) / (trade.duration * 1000)) * 100)
                        );

                        return `
                            <div class="lira-trade-row is-${trade.side}">
                                <div class="lira-trade-row__top">
                                    <div class="lira-trade-side is-${trade.side}">
                                        ${trade.side === 'buy' ? 'BUY' : 'SELL'}
                                    </div>

                                    <div class="lira-trade-row__symbol">
                                        <strong>${trade.symbol} · #${trade.id}</strong>
                                        <span>${formatDuration(trade.duration)} · ينتهي خلال ${secondsLeft}s</span>
                                    </div>

                                    <div class="lira-trade-row__meta">
                                        <strong>${formatNum(trade.amount)}</strong>
                                        <span>Entry: ${formatNum(trade.entryPrice)}</span>
                                    </div>
                                </div>

                                <div class="lira-trade-row__progress">
                                    <span style="width:${progress}%"></span>
                                </div>
                            </div>
                        `;
                    }).join('');
                }

                if (openTradesCountEl) {
                    openTradesCountEl.textContent = String(trades.length);
                }

                if (winTradesCountEl) {
                    winTradesCountEl.textContent = String(closedTrades.filter(t => t.result === 'win').length);
                }

                if (tradePnlValueEl) {
                    const totalPnl = closedTrades.reduce((sum, t) => sum + t.pnl, 0);
                    tradePnlValueEl.textContent = `${totalPnl >= 0 ? '+' : ''}${formatNum(totalPnl)}`;
                    tradePnlValueEl.classList.toggle('text-success', totalPnl >= 0);
                    tradePnlValueEl.classList.toggle('text-danger', totalPnl < 0);
                }
            }

            function placeTrade(side) {
                const entryPrice = getCurrentPrice();
                const amount = Math.max(1, Number(tradeAmountInput?.value || 0));

                if (!entryPrice || !amount) return;

                trades.unshift({
                    id: tradeId++,
                    symbol: currentSymbol,
                    side,
                    amount,
                    duration: tradeDurationSeconds,
                    entryPrice,
                    openedAt: Date.now(),
                    expireAt: Date.now() + (tradeDurationSeconds * 1000),
                    payoutRatio: 0.82,
                });

                renderTrades();
                requestOverlayDraw();
            }

            function settleExpiredTrades() {
                if (!trades.length || !bars.length) return;

                const now = Date.now();
                const exitPrice = getCurrentPrice();

                const stillOpen = [];

                trades.forEach(trade => {
                    if (trade.expireAt > now) {
                        stillOpen.push(trade);
                        return;
                    }

                    const isWin = trade.side === 'buy'
                        ? exitPrice > trade.entryPrice
                        : exitPrice < trade.entryPrice;

                    const pnl = isWin
                        ? trade.amount * trade.payoutRatio
                        : -trade.amount;

                    closedTrades.unshift({
                        ...trade,
                        closedAt: now,
                        exitPrice,
                        result: isWin ? 'win' : 'loss',
                        pnl,
                    });
                });

                trades = stillOpen;
            }

            function drawTradeLabel(x, y, text, color) {
                ctx.save();
                ctx.font = '700 11px Cairo, sans-serif';
                const width = ctx.measureText(text).width + 18;
                const height = 24;
                const left = x - width;
                const top = y - (height / 2);

                ctx.fillStyle = color;
                ctx.beginPath();
                ctx.roundRect(left, top, width, height, 10);
                ctx.fill();

                ctx.fillStyle = '#08111f';
                ctx.textBaseline = 'middle';
                ctx.fillText(text, left + 9, y);
                ctx.restore();
            }

            function initChart() {

                chart = createChart(chartHost, {
                    autoSize: true,
                    layout: {
                        background: { type: 'solid', color: 'transparent' },
                        textColor: '#8d96a5',
                        attributionLogo: false,
                    },
                    grid: {
                        vertLines: { color: 'rgba(255,255,255,0.07)', style: LineStyle.Dashed },
                        horzLines: { color: 'rgba(255,255,255,0.07)', style: LineStyle.Dashed },
                    },
                    crosshair: {
                        mode: CrosshairMode.Normal,
                        vertLine: { color: 'rgba(255,255,255,0.26)', style: LineStyle.Dashed, width: 1 },
                        horzLine: { color: 'rgba(255,255,255,0.26)', style: LineStyle.Dashed, width: 1 },
                    },
                    rightPriceScale: {
                        borderColor: 'rgba(255,255,255,0.08)',
                        scaleMargins: { top: 0.08, bottom: 0.06 },
                    },
                    timeScale: {
                        borderColor: 'rgba(255,255,255,0.08)',
                        timeVisible: true,
                        secondsVisible: false,
                        rightOffset: 6,
                        barSpacing: 9,
                        minBarSpacing: 4,
                        fixLeftEdge: false,
                        fixRightEdge: false,
                        lockVisibleTimeRangeOnResize: true,
                    },
                    handleScroll: {
                        mouseWheel: true,
                        pressedMouseMove: true,
                        horzTouchDrag: true,
                        vertTouchDrag: false,
                    },
                    handleScale: {
                        mouseWheel: true,
                        pinch: true,
                        axisPressedMouseMove: { time: true, price: true },
                    },
                });

                candleSeries = chart.addSeries(CandlestickSeries, {
                    upColor: '#31c48d',
                    downColor: '#f97066',
                    borderVisible: false,
                    wickUpColor: '#31c48d',
                    wickDownColor: '#f97066',
                    priceLineVisible: true,
                    lastValueVisible: true,
                });

                chart.subscribeCrosshairMove(param => {
                    if (
                        !param.point ||
                        !param.time ||
                        param.point.x < 0 ||
                        param.point.y < 0 ||
                        !param.seriesData.has(candleSeries)
                    ) {
                        tooltipEl.style.display = 'none';
                        return;
                    }

                    const data = param.seriesData.get(candleSeries);
                    if (!data) {
                        tooltipEl.style.display = 'none';
                        return;
                    }

                    const bar = {
                        time: param.time,
                        open: data.open,
                        high: data.high,
                        low: data.low,
                        close: data.close,
                    };

                    setHovered(bar);

                    tooltipEl.innerHTML = `
                                                                                                        <div class="lira-trade-tooltip__time">${formatTime(bar.time)}</div>
                                                                                                        <div class="lira-trade-tooltip__grid">
                                                                                                            <div class="lira-trade-tooltip__item"><span>Open</span><strong>${formatNum(bar.open)}</strong></div>
                                                                                                            <div class="lira-trade-tooltip__item"><span>High</span><strong>${formatNum(bar.high)}</strong></div>
                                                                                                            <div class="lira-trade-tooltip__item"><span>Low</span><strong>${formatNum(bar.low)}</strong></div>
                                                                                                            <div class="lira-trade-tooltip__item"><span>Close</span><strong>${formatNum(bar.close)}</strong></div>
                                                                                                        </div>
                                                                                                    `;

                    tooltipEl.style.display = 'block';

                    const stageRect = chartHost.getBoundingClientRect();
                    let left = param.point.x + 18;
                    let top = param.point.y + 18;

                    if (left + 210 > stageRect.width) left = param.point.x - 210;
                    if (top + 110 > stageRect.height) top = param.point.y - 110;

                    tooltipEl.style.left = `${left}px`;
                    tooltipEl.style.top = `${top}px`;
                });

                chart.timeScale().subscribeVisibleLogicalRangeChange(range => {
                    requestOverlayDraw();

                    if (!range) return;
                    const info = candleSeries.barsInLogicalRange(range);
                    if (info && typeof info.barsAfter === 'number') {
                        followLive = info.barsAfter <= 1;
                    }
                });

                resizeObserver = new ResizeObserver(() => {
                    syncCanvasSize();
                    requestOverlayDraw();
                });

                resizeObserver.observe(chartHost);
                syncCanvasSize();
            }

            function syncResponsiveChartLayout() {
                if (!chartHost || !chart) return;

                const rect = chartHost.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    chart.resize(rect.width, rect.height);
                }

                syncCanvasSize();
                requestOverlayDraw();
            }

            async function loadInitialData() {
                bars = await fetchCandles(currentSymbol, activeInterval);
                candleSeries.setData(bars);
                updateTopMeta(bars);
                setHovered(bars[bars.length - 1]);
                chart.timeScale().scrollToRealTime();
                requestOverlayDraw();
            }

            function stopStream() {
                if (reconnectTimer) {
                    clearTimeout(reconnectTimer);
                    reconnectTimer = null;
                }

                if (syntheticTimer) {
                    clearInterval(syntheticTimer);
                    syntheticTimer = null;
                }

                if (socket) {
                    socket.onclose = null;
                    socket.onerror = null;
                    socket.onmessage = null;
                    socket.close();
                    socket = null;
                }
            }
            function startStream() {
                stopStream();

                if (syntheticMode) {
                    startSyntheticStream();
                    return;
                }

                const myGeneration = ++streamGeneration;
                const stream = symbolMap[currentSymbol].stream;
                const url = `wss://stream.binance.com:9443/ws/${stream}@kline_${activeInterval}`;

                function connect() {
                    if (myGeneration !== streamGeneration) return;

                    socket = new WebSocket(url);

                    socket.onmessage = event => {
                        const payload = JSON.parse(event.data);
                        const k = payload.k;

                        const bar = {
                            time: Math.floor(k.t / 1000),
                            open: +parseFloat(k.o).toFixed(2),
                            high: +parseFloat(k.h).toFixed(2),
                            low: +parseFloat(k.l).toFixed(2),
                            close: +parseFloat(k.c).toFixed(2),
                        };

                        applyRealtimeBar(bar);
                    };

                    socket.onerror = () => {
                        try { socket.close(); } catch (_) { }
                    };

                    socket.onclose = () => {
                        if (myGeneration !== streamGeneration) return;

                        syntheticMode = true;
                        setTradeModePill();
                        startSyntheticStream();
                    };
                }

                connect();
            }

            function rebuild() {
                followLive = true;
                drawings = [];
                draftDrawing = null;
                dragTarget = null;
                isDraggingDrawing = false;
                syntheticLastPrice = null;
                syntheticBarOpenedAtMs = 0;
                stopStream();
                loadInitialData().then(startStream);
            }

            drawMenuToggle.addEventListener('click', () => {
                drawMenu.classList.toggle('is-open');
            });

            document.addEventListener('click', evt => {
                if (!drawMenu.contains(evt.target) && !drawMenuToggle.contains(evt.target)) {
                    drawMenu.classList.remove('is-open');
                }
            });

            drawMenu.querySelectorAll('[data-tool]').forEach(btn => {
                btn.addEventListener('click', () => {
                    setTool(btn.dataset.tool);
                    drawMenu.classList.remove('is-open');
                });
            });

            drawMenu.querySelector('[data-action="clear"]').addEventListener('click', () => {
                clearDrawings();
                drawMenu.classList.remove('is-open');
            });

            drawMenu.querySelector('[data-action="follow-live"]').addEventListener('click', () => {
                followLive = true;
                chart.timeScale().scrollToRealTime();
                drawMenu.classList.remove('is-open');
            });

            drawLayer.addEventListener('pointerdown', evt => {
                if (currentTool === 'cursor') return;

                const p = domainPointFromEvent(evt);
                if (p.logical == null || p.price == null) return;

                const hit = findDrawingHit(p.x, p.y);

                if ((currentTool === 'hline' || currentTool === 'vline') && hit) {
                    dragTarget = hit;
                    isDraggingDrawing = true;
                    drawLayer.setPointerCapture(evt.pointerId);
                    return;
                }

                if (currentTool === 'hline') {
                    drawings.push({ type: 'hline', price: p.price });
                    requestOverlayDraw();
                    return;
                }

                if (currentTool === 'vline') {
                    drawings.push({ type: 'vline', logical: p.logical });
                    requestOverlayDraw();
                    return;
                }

                if (currentTool === 'trend') {
                    if (!draftDrawing) {
                        draftDrawing = {
                            type: 'trend',
                            startLogical: p.logical,
                            startPrice: p.price,
                        };
                    } else {
                        drawings.push({
                            type: 'trend',
                            startLogical: draftDrawing.startLogical,
                            startPrice: draftDrawing.startPrice,
                            endLogical: p.logical,
                            endPrice: p.price,
                        });
                        draftDrawing = null;
                    }
                    requestOverlayDraw();
                    return;
                }

                if (currentTool === 'rect') {
                    if (!draftDrawing) {
                        draftDrawing = {
                            type: 'rect',
                            startLogical: p.logical,
                            startPrice: p.price,
                        };
                    } else {
                        drawings.push({
                            type: 'rect',
                            startLogical: draftDrawing.startLogical,
                            startPrice: draftDrawing.startPrice,
                            endLogical: p.logical,
                            endPrice: p.price,
                        });
                        draftDrawing = null;
                    }
                    requestOverlayDraw();
                }
            });

            drawLayer.addEventListener('pointermove', evt => {
                pointer = domainPointFromEvent(evt);

                if (isDraggingDrawing && dragTarget && pointer) {
                    updateDraggedDrawing(dragTarget, pointer);
                    return;
                }

                requestOverlayDraw();
            });

            drawLayer.addEventListener('pointerup', evt => {
                if (isDraggingDrawing) {
                    isDraggingDrawing = false;
                    dragTarget = null;
                    try { drawLayer.releasePointerCapture(evt.pointerId); } catch (_) { }
                }
            });

            drawLayer.addEventListener('pointerleave', () => {
                pointer = null;
                requestOverlayDraw();
            });

            symbolTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    if (tab.dataset.symbol === currentSymbol) return;

                    symbolTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentSymbol = tab.dataset.symbol;
                    rebuild();
                });
            });

            timeframeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.classList.contains('active')) return;

                    timeframeBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const tf = btn.textContent.trim();
                    activeInterval = tf === '1H' ? '1h' : tf === '1M' ? '1m' : '5m';
                    rebuild();
                });
            });

            tradeDurationGroup?.querySelectorAll('.lira-duration-chip[data-seconds]').forEach(btn => {
                btn.addEventListener('click', () => {
                    tradeDurationSeconds = Number(btn.dataset.seconds || 300);
                    setActiveDurationChip(btn);
                });
            });

            customDurationBtn?.addEventListener('click', () => {
                const value = Math.max(3, Math.floor(Number(customDurationInput?.value || 3)));
                customDurationInput.value = String(value);
                tradeDurationSeconds = value;
                setActiveDurationChip(customDurationBtn);
            });

            customDurationInput?.addEventListener('focus', () => {
                customDurationBtn?.click();
            });

            customDurationInput?.addEventListener('input', () => {
                const value = Math.max(3, Math.floor(Number(customDurationInput.value || 3)));
                customDurationInput.value = String(value);
                tradeDurationSeconds = value;
                setActiveDurationChip(customDurationBtn);
            });

            buyTradeBtn?.addEventListener('click', () => placeTrade('buy'));
            sellTradeBtn?.addEventListener('click', () => placeTrade('sell'));

            setInterval(() => {
                settleExpiredTrades();
                renderTrades();
                requestOverlayDraw();
            }, 1000);

            if (fsBtn && fsTarget) {
                fsBtn.addEventListener('click', async () => {
                    try {
                        if (!document.fullscreenElement) {
                            await fsTarget.requestFullscreen();
                            fsBtn.innerHTML = '<i class="fa-solid fa-compress"></i>';
                            fsTarget.classList.add('is-fullscreen-tools');
                        } else {
                            await document.exitFullscreen();
                            fsBtn.innerHTML = '<i class="fa-solid fa-expand"></i>';
                            fsTarget.classList.remove('is-fullscreen-tools');
                        }
                        setTimeout(() => requestOverlayDraw(), 200);
                    } catch (_) { }
                });

                document.addEventListener('fullscreenchange', () => {
                    if (!document.fullscreenElement) {
                        fsBtn.innerHTML = '<i class="fa-solid fa-expand"></i>';
                        fsTarget.classList.remove('is-fullscreen-tools');
                    } else {
                        fsTarget.classList.add('is-fullscreen-tools');
                    }

                    setTimeout(() => {
                        syncCanvasSize();
                        requestOverlayDraw();
                    }, 200);
                });
            }

            window.addEventListener('resize', () => {
                setTimeout(syncResponsiveChartLayout, 120);
            });

            window.addEventListener('orientationchange', () => {
                setTimeout(syncResponsiveChartLayout, 250);
            });

            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', () => {
                    setTimeout(syncResponsiveChartLayout, 120);
                });
            }

            initChart();
            await loadInitialData();
            startStream();
        });
    </script>
@endpush

