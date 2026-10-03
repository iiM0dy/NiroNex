@extends('layouts.site-dash')

@section('title', 'Niro Vault')

@section('content')
    @php
        $isDemoAccount = auth()->user()?->isDemoAccount() ?? false;
    @endphp

    <div class="lira-plans-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · SUBSCRIPTION PLANS</span>
                <h1 class="lira-page-title">Niro Vault</h1>
                <p class="lira-page-subtitle">
                    اختر خطة الاستثمار المناسبة لك، واستفد من عوائد مُدارة بالذكاء الاصطناعي.
                </p>
            </div>
        </div>

        <div class="lira-wallet-strip mb-4">
            <div>
                <span>رصيد محفظة الإيداع المتاح</span>
                <strong dir="ltr">{{ formatCurrency($availableBalance ?? 0) }}</strong>
            </div>
            <a href="{{ route('site.deposit') }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-wallet ms-2"></i>
                إضافة رصيد
            </a>
        </div>

        @if($isDemoAccount)
            <div class="alert alert-warning mb-4">
                حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً للاشتراك في الخطط.
            </div>
        @endif

        @if($plans->count())
            <div class="lira-plans-grid">
                @foreach($plans as $plan)
                    @php
                        $minAmount = (float) $plan->min_deposit;
                        $maxAmount = $plan->hasUnlimitedMaxDeposit() ? null : (float) $plan->max_deposit;
                        $suggestedAmount = max($minAmount, min((float) ($availableBalance ?? 0), $maxAmount ?? (float) ($availableBalance ?? 0)));
                        $hasEnoughBalance = (float) ($availableBalance ?? 0) >= $minAmount;
                    @endphp

                    <div class="lira-plan-card {{ $plan->isRobotPlan() ? 'is-featured' : '' }}">
                        @if($plan->isRobotPlan())
                            <div class="lira-plan-featured-badge">
                                <i class="fa-solid fa-robot"></i>
                                <span>وصول صفحة الروبوت</span>
                            </div>
                        @endif

                        <div class="lira-plan-header">
                            <h3>{{ $plan->display_name }}</h3>
                            @if($plan->description)
                                <p>{{ $plan->description }}</p>
                            @endif
                        </div>

                        <div class="lira-plan-rate">
                            <span class="lira-plan-rate-value">{{ $plan->display_profit_rate }}</span>
                            <span class="lira-plan-rate-label">الربح المعروض</span>
                        </div>

                        <div class="lira-plan-details">
                            <div class="lira-plan-detail-item">
                                <span>نطاق الإيداع</span>
                                <strong>{{ $plan->deposit_range_label }}</strong>
                            </div>
                            <div class="lira-plan-detail-item">
                                <span>دورة الدفع</span>
                                <strong>{{ $plan->payout_interval_label }}</strong>
                            </div>
                            <div class="lira-plan-detail-item">
                                <span>العائد الفعلي</span>
                                <strong>{{ $plan->subscriber_return_label }}</strong>
                            </div>
                            <div class="lira-plan-detail-item">
                                <span>المخاطر</span>
                                <strong>{{ $plan->risk_label ?? 'بحسب إعدادات الروبوت' }}</strong>
                            </div>
                        </div>

                        <div class="lira-plan-features">
                            @if($plan->isRobotPlan())
                                <div class="lira-plan-feature is-included">
                                    <i class="fa-solid fa-check"></i>
                                    <span>إظهار /robot في القائمة الجانبية بعد الاشتراك</span>
                                </div>
                            @else
                                <div class="lira-plan-feature is-included">
                                    <i class="fa-solid fa-check"></i>
                                    <span>KYC مطلوب فقط عند السحب وليس قبل الإيداع</span>
                                </div>
                            @endif
                        </div>

                        @if(!$hasEnoughBalance)
                            <div class="lira-plan-warning">
                                رصيدك غير كافٍ. تحتاج إلى {{ formatCurrency($minAmount) }} على الأقل لهذه الخطة.
                            </div>
                            <a href="{{ route('site.deposit') }}" class="lira-plan-cta">
                                <span>إضافة رصيد</span>
                                <i class="fa-solid fa-wallet"></i>
                            </a>
                        @else
                            <form method="POST" action="{{ route('site.plans.subscribe', $plan) }}" class="lira-plan-subscribe">
                                @csrf
                                <label for="planAmount{{ $plan->id }}">مبلغ الاشتراك</label>
                                <div class="lira-plan-amount">
                                    <span>$</span>
                                    <input
                                        id="planAmount{{ $plan->id }}"
                                        name="amount"
                                        type="number"
                                        step="0.01"
                                        min="{{ $minAmount }}"
                                        @if($maxAmount) max="{{ $maxAmount }}" @endif
                                        value="{{ old('amount', number_format($suggestedAmount, 2, '.', '')) }}"
                                        @disabled($isDemoAccount)
                                        required
                                    >
                                </div>
                                <button type="submit" class="lira-plan-cta" @disabled($isDemoAccount)>
                                    <span>{{ $isDemoAccount ? 'حساب ديمو' : 'اشترك الآن' }}</span>
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="card lira-table-card">
                <div class="card-body">
                    <div class="lira-empty-block">
                        <i class="fa-solid fa-tags"></i>
                        <h5>لا توجد خطط متاحة حالياً</h5>
                        <p>سيتم إضافة Niro Vault قريباً. تابعنا للحصول على أحدث العروض.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .lira-wallet-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 20px;
            border-radius: 18px;
            background: rgba(255,255,255,0.025);
            border: 1px solid var(--lira-border);
        }

        .lira-wallet-strip span {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-wallet-strip strong {
            display: block;
            font-size: 1.35rem;
            color: var(--lira-text);
        }

        .lira-plan-card {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 28px 24px;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.005)), var(--lira-surface);
            border: 1px solid var(--lira-border);
            transition: border-color 0.3s ease, transform 0.3s ease;
        }

        .lira-plan-card:hover {
            border-color: rgba(255,255,255,0.12);
            transform: translateY(-4px);
        }

        .lira-plan-card.is-featured {
            border-color: rgba(0,230,167,0.28);
            background: linear-gradient(180deg, rgba(0,230,167,0.05), rgba(26,43,255,0.02));
        }

        .lira-plan-featured-badge {
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--lira-accent-strong), var(--lira-accent));
            color: #f4f6fa;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .lira-plan-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .lira-plan-header h3 {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .lira-plan-header p {
            font-size: 13px;
            color: var(--lira-text-muted);
            margin: 0;
            line-height: 1.6;
        }

        .lira-plan-rate {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 22px 0;
            margin-bottom: 18px;
            border-top: 1px solid rgba(255,255,255,0.04);
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .lira-plan-rate-value {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--lira-gold);
            direction: rtl;
        }

        .lira-plan-rate-label {
            font-size: 12px;
            color: var(--lira-text-muted);
            font-weight: 600;
        }

        .lira-plan-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
        }

        .lira-plan-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255,255,255,0.02);
        }

        .lira-plan-detail-item span {
            font-size: 13px;
            color: var(--lira-text-muted);
        }

        .lira-plan-detail-item strong {
            font-size: 14px;
            direction: ltr;
        }

        .lira-plan-features {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 22px;
        }

        .lira-plan-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }

        .lira-plan-feature.is-included i { color: #5fe2a1; }
        .lira-plan-feature.is-excluded i { color: rgba(255,255,255,0.15); }
        .lira-plan-feature.is-excluded span { color: var(--lira-text-muted); }

        .lira-plan-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px;
            border-radius: 14px;
            background: var(--lira-gold);
            border: 1px solid var(--lira-gold);
            color: #000;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.22s ease;
            margin-top: auto;
            width: 100%;
        }

        .lira-plan-cta:hover {
            background: #00c891;
            border-color: #00c891;
            color: #000;
        }

        button.lira-plan-cta {
            cursor: pointer;
        }

        .lira-plan-cta:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .lira-plan-subscribe {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: auto;
        }

        .lira-plan-subscribe label {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 800;
        }

        .lira-plan-amount {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 14px;
            min-height: 48px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
        }

        .lira-plan-amount span {
            color: var(--lira-accent);
            font-weight: 900;
        }

        .lira-plan-amount input {
            flex: 1;
            min-width: 0;
            border: 0 !important;
            background: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
            direction: ltr;
            font-weight: 800;
        }

        .lira-plan-warning {
            margin-top: auto;
            margin-bottom: 10px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(120,97,255,0.12);
            border: 1px solid rgba(120,97,255,0.22);
            color: #c4b6ff;
            font-size: 12px;
            line-height: 1.7;
        }

        .lira-empty-block {
            min-height: 240px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 10px;
            color: var(--lira-text-muted);
            padding: 28px;
        }

        .lira-empty-block i {
            font-size: 34px;
            color: var(--lira-accent);
        }

        @media (min-width: 1200px) {
            .lira-plans-page {
                width: 100%;
                max-width: none;
                margin-inline: 0;
            }

            .lira-plans-grid {
                grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
                justify-content: center;
                gap: 22px;
            }

            .lira-wallet-strip {
                max-width: none;
                margin-inline: 0;
                padding: 18px 22px;
                border-radius: 18px;
            }

            .lira-wallet-strip span {
                font-size: 12px;
            }

            .lira-wallet-strip strong {
                font-size: 1.45rem;
            }

            .lira-plan-card {
                min-height: 100%;
                padding: 28px 24px;
                border-radius: 20px;
            }

            .lira-plan-card:hover {
                transform: translateY(-4px);
            }

            .lira-plan-featured-badge {
                padding: 6px 16px;
                font-size: 11px;
            }

            .lira-plan-header {
                margin-bottom: 20px;
            }

            .lira-plan-header h3 {
                font-size: 1.32rem;
                margin-bottom: 6px;
            }

            .lira-plan-header p {
                font-size: 13px;
                line-height: 1.65;
            }

            .lira-plan-rate {
                gap: 4px;
                padding: 22px 0;
                margin-bottom: 18px;
            }

            .lira-plan-rate-value {
                font-size: 2.3rem;
            }

            .lira-plan-rate-label {
                font-size: 12px;
            }

            .lira-plan-details {
                gap: 10px;
                margin-bottom: 18px;
            }

            .lira-plan-detail-item {
                padding: 11px 14px;
                border-radius: 12px;
            }

            .lira-plan-detail-item span,
            .lira-plan-detail-item strong,
            .lira-plan-feature {
                font-size: 13px;
            }

            .lira-plan-features {
                gap: 8px;
                margin-bottom: 22px;
            }

            .lira-plan-feature {
                gap: 10px;
            }

            .lira-plan-subscribe {
                gap: 10px;
            }

            .lira-plan-subscribe label {
                font-size: 12px;
            }

            .lira-plan-amount {
                min-height: 48px;
                padding: 0 14px;
                border-radius: 14px;
                font-size: 14px;
            }

            .lira-plan-cta {
                min-height: 48px;
                padding: 13px 16px;
                border-radius: 14px;
                font-size: 14px;
            }

            .lira-plan-warning {
                padding: 12px 14px;
                border-radius: 14px;
                font-size: 12px;
                line-height: 1.7;
            }
        }

        @media (max-width: 767.98px) {
            .lira-plans-grid {
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 12px;
            }

            .lira-plan-card {
                padding: 20px 16px;
                border-radius: 16px;
            }

            .lira-plan-header {
                margin-bottom: 14px;
            }

            .lira-plan-header h3 {
                font-size: 1.12rem;
            }

            .lira-plan-rate {
                padding: 14px 0;
                margin-bottom: 12px;
            }

            .lira-plan-rate-value {
                font-size: 1.9rem;
            }

            .lira-plan-details {
                gap: 8px;
                margin-bottom: 14px;
            }

            .lira-plan-detail-item {
                padding: 8px 10px;
                border-radius: 10px;
            }

            .lira-plan-features {
                margin-bottom: 14px;
            }

            .lira-plan-cta {
                min-height: 42px;
                padding: 10px 12px;
                border-radius: 12px;
            }
        }

        @media (max-width: 575.98px) {
            .lira-wallet-strip {
                align-items: stretch;
                flex-direction: column;
            }

            .lira-wallet-strip .btn {
                width: 100%;
                justify-content: center;
            }

            .lira-plans-grid {
                grid-template-columns: 1fr;
            }

            .lira-plan-card {
                padding: 16px 12px;
            }

            .lira-plan-card.is-featured {
                padding-top: 14px;
            }

            .lira-plan-featured-badge {
                position: static;
                transform: none;
                margin: 0 auto 14px;
                width: fit-content;
            }

            .lira-plan-rate-value {
                font-size: 1.45rem;
            }

            .lira-plan-header p,
            .lira-plan-detail-item span,
            .lira-plan-detail-item strong,
            .lira-plan-feature,
            .lira-plan-cta {
                font-size: 12px;
            }

            .lira-plan-amount {
                min-height: 42px;
                border-radius: 12px;
            }
        }
    </style>
@endpush
