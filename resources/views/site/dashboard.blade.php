@extends('layouts.site-dash')

@section('title', 'لوحة التحكم المركزية')

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

        $expectedProfit = ((float) $user->plan_amount * ($plan->profit_rate / 100));
    }

    $aiStatus = $plan && $user->status !== \App\Enums\UserStatus::Pending && $user->status !== \App\Enums\UserStatus::Inactive ? 'نشط' : 'في الانتظار';
@endphp

@section('content')

<style>
.app-dash-container {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding-bottom: 30px;
}
.app-card {
    background: var(--lira-surface);
    border: 1px solid var(--lira-border);
    border-radius: 16px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}
.active-robot-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(23, 178, 106, 0.1);
    color: #17b26a;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    border: 1px solid rgba(23, 178, 106, 0.2);
}
.inactive-robot-badge {
    background: rgba(120, 97, 255, 0.1);
    color: #7861ff;
    border-color: rgba(120, 97, 255, 0.2);
}
.plan-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 5px;
}
.plan-subtitle {
    color: var(--lira-text-muted);
    font-size: 0.95rem;
    margin-bottom: 24px;
}

/* Data Grid within Cards */
.data-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    background: var(--lira-surface-2);
    padding: 15px;
    border-radius: 14px;
    border: 1px solid var(--lira-border);
}
.data-item {
    display: flex;
    flex-direction: column;
}
.data-label {
    font-size: 0.8rem;
    color: var(--lira-text-muted);
    margin-bottom: 4px;
}
.data-val {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
}
.data-val.gold { color: var(--lira-accent); }

/* Trade Feed List */
.trade-feed {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.trade-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: var(--lira-surface);
    border: 1px solid var(--lira-border);
    border-radius: 14px;
}
.trade-asset {
    display: flex;
    align-items: center;
    gap: 12px;
}
.trade-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--lira-surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.trade-icon.win {
    background: rgba(23, 178, 106, 0.12);
    border: 1px solid rgba(23, 178, 106, 0.2);
    color: #17b26a;
}
.trade-icon.loss {
    background: rgba(240, 68, 56, 0.12);
    border: 1px solid rgba(240, 68, 56, 0.2);
    color: #f04438;
}
.trade-meta h4 { font-size: 1rem; margin: 0 0 2px; color: #fff; font-weight: 700; }
.trade-meta span { font-size: 0.75rem; color: var(--lira-text-muted); }
.trade-result { text-align: left; }
.trade-result h4 { font-size: 1.05rem; margin: 0 0 2px; font-weight: 700; }
.trade-result.won h4 { color: #17b26a; }
.trade-result.loss h4 { color: #f04438; }
.trade-result span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 2px;
    padding: 2px 8px;
    border-radius: 999px;
    font-size: 0.68rem;
    font-weight: 800;
}
.trade-result.won span {
    background: rgba(23, 178, 106, 0.12);
    color: #5fe2a1;
}
.trade-result.loss span {
    background: rgba(240, 68, 56, 0.12);
    color: #ff8a80;
}
.app-primary-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--lira-accent);
    color: #000 !important;
    font-weight: 700;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
}
.app-primary-btn:hover {
    background: #00c891;
    color: #000 !important;
}

@media (max-width: 576px) {
    .data-grid { grid-template-columns: 1fr; }
    .plan-title { font-size: 1.5rem; }
    .app-card { padding: 18px 16px; border-radius: 14px; }
}
</style>

<div class="app-dash-container">
    <div class="lira-page-header mb-4">
        <div>
            <span class="lira-eyebrow">{{ brandAiName() }} · DASHBOARD</span>
            <h1 class="lira-page-title">لوحة التحكم</h1>
            <p class="lira-page-subtitle">تابع حالة الخطة، الرصيد، وآخر نتائج التداول من مكان واحد.</p>
        </div>
    </div>

    
    @if ($user->status === \App\Enums\UserStatus::Pending)
        <div class="alert alert-warning d-flex align-items-center mb-4" style="border-radius:16px; background: rgba(120, 97, 255, 0.1); border-color: rgba(120, 97, 255, 0.2); color: #7861ff;">
            <i class="fa-solid fa-clock fa-lg ms-3"></i>
            <div class="small">حسابك قيد الانتظار حالياً، وسيتم تفعيله بعد مراجعة الإدارة.</div>
        </div>
    @elseif ($user->status === \App\Enums\UserStatus::Inactive)
        <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius:16px; background: rgba(240, 68, 56, 0.1); border-color: rgba(240, 68, 56, 0.2); color: #f04438;">
            <i class="fa-solid fa-ban fa-lg ms-3"></i>
            <div class="small">حسابك معطّل حالياً. يرجى التواصل مع الدعم الفني.</div>
        </div>
    @endif

    {{-- 1. ACTIVE PLAN & ROBOT CARD --}}
    <div class="app-card">
        @if($plan && $aiStatus == 'نشط')
            <div class="active-robot-badge">
                <i class="fa-solid fa-circle-bolt" style="animation: pulse 2s infinite;"></i> 
                نظام {{ brandAiName() }} نشط يعالج الصفقات
            </div>
        @else
            <div class="active-robot-badge inactive-robot-badge">
                <i class="fa-solid fa-pause"></i> الروبوت متوقف / بانتظار الخطة
            </div>
        @endif

        <h2 class="plan-title">{{ $plan ? $plan->display_name : 'لم يتم الاشتراك بأي خطة' }}</h2>
        <p class="plan-subtitle">
            {{ $plan ? 'يتم إدارة محفظتك حالياً بواسطة الذكاء الاصطناعي الخاص بالمنصة.' : 'يرجى الانتقال لصفحة الروبوت واختيار باقة للبدء.' }}
        </p>

        <div class="data-grid">
            <div class="data-item">
                <span class="data-label">دقة الذكاء الاصطناعي (AI)</span>
                <span class="data-val">
                    @if($aiConfidence > 0)
                        {{ $aiConfidence }}%
                    @else
                        <span style="font-size: 0.9rem; color: var(--lira-text-muted);">غير نشط</span>
                    @endif
                </span>
            </div>
            <div class="data-item">
                <span class="data-label">حالة التوثيق (KYC)</span>
                <span class="data-val" style="color: {{ !empty($user->id_photo_front) && $user->status !== \App\Enums\UserStatus::Pending ? '#17b26a' : '#7861ff' }};">
                    {{ !empty($user->id_photo_front) && $user->status !== \App\Enums\UserStatus::Pending ? 'موثق' : 'قيد المراجعة' }}
                </span>
            </div>
        </div>
        
        @if(!$plan)
            <div class="mt-4">
                <a href="{{ route('site.robot.index') }}" class="btn w-100 app-primary-btn">تفعيل نظام التداول الآلي</a>
            </div>
        @endif
    </div>

    {{-- 2. FINANCIAL RESULTS CARD --}}
    <div class="app-card">
        <h3 class="plan-title" style="font-size: 1.3rem; margin-bottom: 20px;">النتائج والأرباح</h3>
        
        <div class="data-grid" style="grid-template-columns: 1fr;">
            <div class="data-item" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px; margin-bottom: 15px;">
                <span class="data-label">الرصيد الإجمالي</span>
                <span class="data-val gold" style="font-size: 2rem;">${{ number_format($totalBalance, 2) }}</span>
            </div>
            
            <div class="d-flex" style="gap: 15px;">
                <div class="data-item" style="flex: 1;">
                    <span class="data-label">الربح المتوقع</span>
                    <span class="data-val text-success">
                        @if($plan)
                            +${{ number_format($expectedProfit, 2) }}
                        @else
                            $0.00
                        @endif
                    </span>
                </div>
                <div class="data-item" style="flex: 1;">
                    <span class="data-label">صرف الأرباح القادم</span>
                    <span class="data-val" style="font-size:1.1rem;">{{ $plan ? $nextExpected->format('Y/m/d') : '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. TRADE NOTIFICATIONS (PROFIT/LOSS) --}}
    <div class="mb-4 d-flex justify-content-between align-items-end">
        <h3 class="plan-title" style="font-size: 1.3rem; margin: 0;">آخر الصفقات</h3>
        <span style="font-size:0.8rem; color: var(--lira-text-muted);">{{ $recentTrades->count() }} صفقة</span>
    </div>

    @if($recentTrades->count() > 0)
        <div class="trade-feed">
            @foreach($recentTrades as $trade)
                @php
                    $isProfitable = $trade->pnl > 0;
                    $tradeType = strtoupper($trade->type);
                @endphp
                <div class="trade-row">
                    <div class="trade-asset">
                        <div class="trade-icon {{ $isProfitable ? 'win' : 'loss' }}">
                            <i class="fa-solid {{ $isProfitable ? 'fa-trophy' : 'fa-triangle-exclamation' }}"></i>
                        </div>
                        <div class="trade-meta">
                            <h4>{{ $trade->symbol }}</h4>
                            <span>{{ $tradeType }} · {{ $trade->closed_at ? $trade->closed_at->diffForHumans() : 'منذ لحظات' }}</span>
                        </div>
                    </div>
                    <div class="trade-result {{ $isProfitable ? 'won' : 'loss' }}">
                        <h4>{{ $isProfitable ? '+' : '' }} ${{ number_format($trade->pnl, 2) }}</h4>
                        <span>{{ $isProfitable ? 'رابحة' : 'خاسرة' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ route('site.trading.history') }}" style="color: var(--lira-text-muted); font-size: 0.85rem; text-decoration: underline;">عرض جميع الصفقات</a>
        </div>
    @else
        <div class="app-card" style="text-align: center; padding: 40px 24px;">
            <i class="fa-solid fa-chart-line" style="font-size: 3rem; color: var(--lira-text-muted); opacity: 0.3; margin-bottom: 15px;"></i>
            <p style="color: var(--lira-text-muted); margin: 0;">لا توجد صفقات بعد</p>
            <p style="color: var(--lira-text-muted); font-size: 0.85rem; margin-top: 5px;">
                @if(!$plan)
                    قم بتفعيل خطة للبدء في التداول الآلي
                @else
                    سيبدأ نظام التداول الآلي قريباً
                @endif
            </p>
        </div>
    @endif

</div>

@endsection

