@php
    $planName = trim((string) ($plan->display_name ?? $plan->name));
    $planDescription = trim((string) brandText($plan->description ?: 'خطة استثمار مرنة داخل منصة ' . appName() . '.'));
    $isStarter = method_exists($plan, 'isStarterPlan') ? $plan->isStarterPlan() : str_contains(strtolower($planName), 'start');
    $isTrader = method_exists($plan, 'isTraderPlan') ? $plan->isTraderPlan() : str_contains(strtolower($planName), 'trader');
    $profitRange = $plan->display_profit_rate ?? formatPercent($plan->profit_rate);
    $payoutLabel = $plan->payout_interval_label ?? getDurationLabel($plan->duration_days);
    $iconClass = match (true) {
        $isStarter => 'fa-solid fa-seedling',
        $isTrader => 'fa-solid fa-chart-line',
        default => 'fa-solid fa-layer-group',
    };
@endphp

<style>
    .plan-card-dark {
        background-color: #0d1117;
        border: 1px solid #1c212b;
        border-radius: 24px;
        padding: 30px 25px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        color: #fff;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .plan-card-dark:hover {
        border-color: rgba(0, 230, 167, 0.4);
        transform: translateY(-5px);
        color: #fff;
    }

    .plan-card-dark__head {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        text-align: start;
    }

    .plan-icon-wrapper {
        width: 60px;
        height: 60px;
        background-color: rgba(0, 230, 167, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .plan-card-dark h4 {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .plan-card-dark p.plan-desc {
        color: #8b94a5;
        font-size: 0.9rem;
        line-height: 1.7;
        min-height: 48px;
        margin-bottom: 25px;
    }

    .plan-list {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-grow: 1;
    }

    .plan-list li {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        line-height: 1.65;
    }

    .plan-list li.highlight-profit {
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid #1c212b;
        padding: 12px 15px;
        border-radius: 12px;
        font-weight: 700;
    }

    .plan-list li i {
        color: var(--lira-accent);
        width: 25px;
        text-align: center;
        flex: 0 0 auto;
        font-size: 1.05rem;
    }

    .plan-btn {
        width: 100%;
        background-color: transparent;
        border: 1px solid var(--lira-accent);
        color: var(--lira-accent);
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        text-align: center;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .plan-card-dark:hover .plan-btn {
        background: linear-gradient(135deg, var(--lira-accent-strong), var(--lira-accent));
        color: #f4f6fa;
    }

    @media (max-width: 575.98px) {
        .plan-card-dark {
            padding: 24px 18px;
            border-radius: 22px;
        }

        .plan-card-dark h4 {
            font-size: 1.15rem;
        }

        .plan-card-dark p.plan-desc,
        .plan-list li {
            font-size: 0.84rem;
        }

        .plan-list li.highlight-profit {
            padding: 10px 12px;
        }
    }
</style>

@if ($url != 1)
    <a class="plan-card-dark {{ $classes }}" href="{{ $url }}">
@else
    <div class="plan-card-dark {{ $classes }}">
@endif

    <div class="plan-card-dark__head">
        <div class="plan-icon-wrapper">
            <i class="{{ $iconClass }} fs-3" style="color: var(--lira-accent);"></i>
        </div>
        <h4 dir="{{ preg_match('/[A-Za-z]/', $planName) ? 'ltr' : 'rtl' }}">{{ $planName }}</h4>
        <p class="plan-desc" dir="{{ preg_match('/[\x{0600}-\x{06FF}]/u', $planDescription) ? 'rtl' : 'ltr' }}">{{ $planDescription }}</p>
    </div>

    <ul class="plan-list text-start w-100">
        <li class="highlight-profit" dir="rtl">
            <i class="fa-solid fa-arrow-trend-up"></i>
            <span>نسبة الربح:
                <strong style="color: var(--lira-accent); font-size: 1.1rem;" dir="ltr">{{ $profitRange }}</strong>
                <span style="font-size: 0.8rem; font-weight: 400; color: #8b94a5;">{{ $payoutLabel }}</span>
            </span>
        </li>

        <li dir="rtl">
            <i class="fa-solid fa-dollar-sign"></i>
            <span style="color: #8b94a5;">الحد الأدنى:</span>
            <strong class="ms-1" dir="ltr">{{ $plan->display_min_deposit ?? formatCurrency($plan->min_deposit) }}</strong>
        </li>

        <li dir="rtl">
            <i class="fa-solid fa-money-bill-trend-up"></i>
            <span style="color: #8b94a5;">الحد الأعلى:</span>
            <strong class="ms-1" dir="{{ preg_match('/[\x{0600}-\x{06FF}]/u', $plan->display_max_deposit ?? '') ? 'rtl' : 'ltr' }}">{{ $plan->display_max_deposit ?? formatCurrency($plan->max_deposit) }}</strong>
        </li>

        @if ($plan->instant_withdrawal)
            <li dir="rtl">
                <i class="fa-regular fa-clock"></i>
                <span>سحب فوري للأرباح</span>
            </li>
        @endif

        @if ($plan->weekly_support)
            <li dir="rtl">
                <i class="fa-solid fa-headset"></i>
                <span>دعم مباشر 24/7</span>
            </li>
        @endif

        @if ($plan->privet_manger)
            <li dir="rtl">
                <i class="fa-solid fa-user-tie"></i>
                <span>مدير حساب خاص</span>
            </li>
        @endif

        @if ($plan->recommendation)
            <li dir="rtl">
                <i class="fa-solid fa-chart-pie"></i>
                <span>تقارير وتوصيات دقيقة</span>
            </li>
        @endif
    </ul>

    @if ($url != 1)
        <div class="plan-btn">اختيار الباقة</div>
    @endif

@if ($url != 1)
    </a>
@else
    </div>
@endif
