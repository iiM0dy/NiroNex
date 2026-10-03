@extends('layouts.admin')
@section('title', 'المعاملات المالية')

@section('content')
    @php
        $transactionsCollection = collect(method_exists($transactions, 'items') ? $transactions->items() : $transactions);
        $totalTransactionsCount = method_exists($transactions, 'total') ? $transactions->total() : $transactionsCollection->count();

        $acceptedCount = $transactionsCollection->filter(fn($t) => $t->status === \App\Enums\TransactionStatus::Accepted)->count();
        $pendingCount = $transactionsCollection->filter(fn($t) => $t->status === \App\Enums\TransactionStatus::Pending)->count();
        $rejectedCount = $transactionsCollection->filter(fn($t) => $t->status === \App\Enums\TransactionStatus::Rejected)->count();
        $pageAmountTotal = $transactionsCollection->sum('amount');
    @endphp

    <div class="lira-admin-transactions-page">
        <section class="lira-admin-transactions-hero mb-4">
            <div>
                <span class="lira-admin-transactions-kicker">FINANCIAL LEDGER</span>
                <h2 class="lira-admin-transactions-title">السجل المالي العام</h2>
                <p class="lira-admin-transactions-subtitle">
                    مراقبة جميع التحركات المالية داخل النظام، من الإيداعات والسحوبات إلى الأرباح والمعاملات التشغيلية.
                </p>
            </div>

            <div class="lira-admin-transactions-total">
                <span class="lira-admin-transactions-total-badge">
                    {{ number_format($totalTransactionsCount) }} عملية
                </span>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="lira-admin-transaction-stat is-accent">
                    <div class="lira-admin-transaction-stat-top">
                        <span class="lira-admin-transaction-stat-label">إجمالي العمليات</span>
                        <div class="lira-admin-transaction-stat-icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                    <div class="lira-admin-transaction-stat-value">{{ number_format($totalTransactionsCount) }}</div>
                    <div class="lira-admin-transaction-stat-foot">جميع المعاملات المعروضة أو كامل النتائج</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-transaction-stat is-success">
                    <div class="lira-admin-transaction-stat-top">
                        <span class="lira-admin-transaction-stat-label">عمليات مقبولة</span>
                        <div class="lira-admin-transaction-stat-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="lira-admin-transaction-stat-value">{{ number_format($acceptedCount) }}</div>
                    <div class="lira-admin-transaction-stat-foot">تم تنفيذها أو اعتمادها بنجاح</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-transaction-stat is-warning">
                    <div class="lira-admin-transaction-stat-top">
                        <span class="lira-admin-transaction-stat-label">عمليات معلّقة</span>
                        <div class="lira-admin-transaction-stat-icon">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="lira-admin-transaction-stat-value">{{ number_format($pendingCount) }}</div>
                    <div class="lira-admin-transaction-stat-foot">بانتظار القرار أو التنفيذ الإداري</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-transaction-stat is-info">
                    <div class="lira-admin-transaction-stat-top">
                        <span class="lira-admin-transaction-stat-label">إجمالي مبالغ الصفحة الحالية</span>
                        <div class="lira-admin-transaction-stat-icon">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                    </div>
                    <div class="lira-admin-transaction-stat-value">{{ formatCurrency($pageAmountTotal) }}</div>
                    <div class="lira-admin-transaction-stat-foot">مجموع القيم ضمن النتائج الحالية</div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                @php
                    $handedData = $transactionsCollection->map(function ($trx) {
                        $wallet = $trx->wallet;
                        $walletUser = optional(optional($wallet)->user)->full_name ?? '—';
                        $walletType = optional(optional($wallet)->type)->name ?? '—';

                        return [
                            'id' => $trx->id,
                            'display_id' => '#' . str_pad($trx->id, 5, '0', STR_PAD_LEFT),
                            'type' => $trx->type->name ?? '—',
                            'user' => $walletUser . ' — المحفظة: ' . $walletType,
                            'amount' => formatCurrency($trx->amount),
                            'status' => renderStatusBadge($trx->status),
                            'date' => formatDate($trx->transaction_date),
                            'description' => $trx->description ?: '—',
                        ];
                    });
                @endphp

                <x-table :nativeData="$transactions" title="قائمة المعاملات المالية" :columns="[
                    'display_id' => 'ID المعاملة',
                    'type' => 'النوع',
                    'user' => 'العميل',
                    'amount' => 'المبلغ',
                    'status' => 'الحالة',
                    'date' => 'تاريخ المعاملة',
                    'description' => 'الوصف',
                ]" :rows="$handedData->toArray()" :actions="[
                    [
                        'type' => 'edit-amount',
                        'route' => 'admin.transactions.update',
                        'key' => 'id',
                    ],
                ]" />
            </div>
        </section>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-admin-transactions-page {
            padding-bottom: 10px;
        }

        .lira-admin-transactions-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .lira-admin-transactions-kicker {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(0, 230, 167, 0.10);
            border: 1px solid rgba(0, 230, 167, 0.18);
            color: var(--lira-accent);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .lira-admin-transactions-title {
            margin: 0 0 10px;
            font-size: clamp(1.5rem, 2.2vw, 2rem);
            color: var(--lira-text);
        }

        .lira-admin-transactions-subtitle {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 760px;
        }

        .lira-admin-transactions-total-badge {
            display: inline-flex;
            align-items: center;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(240, 68, 56, 0.10);
            border: 1px solid rgba(240, 68, 56, 0.18);
            color: #ff8a80;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-admin-transaction-stat {
            height: 100%;
            min-height: 148px;
            padding: 20px;
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)),
                var(--lira-surface-2);
            border: 1px solid var(--lira-border);
            position: relative;
            overflow: hidden;
        }

        .lira-admin-transaction-stat::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 90px;
            height: 90px;
            background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%);
            pointer-events: none;
        }

        .lira-admin-transaction-stat.is-accent {
            border-top: 2px solid var(--lira-accent);
        }

        .lira-admin-transaction-stat.is-success {
            border-top: 2px solid var(--lira-success);
        }

        .lira-admin-transaction-stat.is-warning {
            border-top: 2px solid var(--lira-warning);
        }

        .lira-admin-transaction-stat.is-info {
            border-top: 2px solid var(--lira-info);
        }

        .lira-admin-transaction-stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .lira-admin-transaction-stat-label {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lira-admin-transaction-stat-value {
            display: block;
            color: var(--lira-text);
            font-size: clamp(1.45rem, 2vw, 2rem);
            line-height: 1.1;
            font-weight: 800;
        }

        .lira-admin-transaction-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.04);
            flex: 0 0 auto;
        }

        .lira-admin-transaction-stat.is-accent .lira-admin-transaction-stat-icon {
            color: var(--lira-accent);
            background: rgba(0, 230, 167, 0.10);
        }

        .lira-admin-transaction-stat.is-success .lira-admin-transaction-stat-icon {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-admin-transaction-stat.is-warning .lira-admin-transaction-stat-icon {
            color: var(--lira-warning);
            background: rgba(120, 97, 255, 0.10);
        }

        .lira-admin-transaction-stat.is-info .lira-admin-transaction-stat-icon {
            color: var(--lira-info);
            background: rgba(54, 191, 250, 0.10);
        }

        .lira-admin-transaction-stat-foot {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        @media (max-width: 991.98px) {
            .lira-admin-transactions-hero {
                align-items: flex-start;
            }
        }
    </style>
@endpush

