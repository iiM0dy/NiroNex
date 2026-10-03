@extends('layouts.site-dash')

@section('title', 'المعاملات المالية')

@section('content')
    @php
        $user = auth()->user();

        $transactionItems = method_exists($transactions, 'getCollection') ? $transactions->getCollection() : collect($transactions);
        $totalTransactions = method_exists($transactions, 'total') ? $transactions->total() : $transactionItems->count();

        $acceptedOnPage = $transactionItems->filter(fn($tx) => $tx->status == \App\Enums\TransactionStatus::Accepted)->count();
        $otherOnPage = $transactionItems->count() - $acceptedOnPage;
    @endphp

    <div class="lira-transactions-page">
        <div class="lira-transactions-hero mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} ACCOUNT · FINANCIAL LEDGER</span>
                <h1 class="lira-page-title">سجل المعاملات المالية</h1>
                <p class="lira-page-subtitle">
                    متابعة جميع الحركات المالية المرتبطة بحسابك من مكان واحد، مع حالة كل عملية وقيمتها وتاريخها.
                </p>
            </div>

            <div class="lira-hero-note">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>سجل مراجعة واضح</strong>
                    <span>كل عملية تظهر بحالتها الحالية لتسهيل المتابعة والمراجعة.</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4 lira-dashboard-stats">
            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">الرصيد الكلي</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value">{{ formatCurrency($user->balance) }}</div>
                        <div class="lira-stat-meta">
                            <span>إجمالي رصيد الحساب الحالي</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">إجمالي الإيداع</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value text-info">{{ formatCurrency($user->deposit_balance) }}</div>
                        <div class="lira-stat-meta">
                            <span>الرصيد المودع داخل المنصة</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">إجمالي الأرباح</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value text-success">{{ formatCurrency($user->profit_balance) }}</div>
                        <div class="lira-stat-meta">
                            <span>الأرباح المضافة إلى حسابك</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">عدد المعاملات</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value">{{ $totalTransactions }}</div>
                        <div class="lira-stat-meta">
                            <span>{{ $acceptedOnPage }} مكتملة في الصفحة الحالية</span>
                            <span class="text-muted">{{ $otherOnPage }} أخرى</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-9 lira-transactions-main">
                <div class="card lira-table-card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6 class="mb-1">سجل العمليات</h6>
                                <p class="text-muted mb-0 small">عرض مباشر لحالة الإيداعات والسحوبات والتحويلات المرتبطة بحسابك.</p>
                            </div>

                            <div class="lira-table-meta">
                                <span class="lira-badge-chip">{{ $totalTransactions }} عملية</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($transactionItems->count())
                            <div class="table-responsive d-none d-md-block">
                                <table class="table lira-clean-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pe-4">رقم العملية</th>
                                            <th>النوع</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th class="ps-4 text-start">التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactionItems as $tx)
                                            @php
                                                $typeName = $tx->type->getName() ?? 'عملية مالية';
                                                $typeIcon = 'fa-money-bill-transfer';
                                                $typeClass = 'is-neutral';

                                                if (\Illuminate\Support\Str::contains($typeName, ['إيداع', 'Deposit'])) {
                                                    $typeIcon = 'fa-arrow-down';
                                                    $typeClass = 'is-profit';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['سحب', 'Withdraw'])) {
                                                    $typeIcon = 'fa-arrow-up';
                                                    $typeClass = 'is-loss';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['ربح', 'Profit'])) {
                                                    $typeIcon = 'fa-chart-line';
                                                    $typeClass = 'is-profit';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['تحويل', 'Transfer'])) {
                                                    $typeIcon = 'fa-right-left';
                                                    $typeClass = 'is-neutral';
                                                }
                                            @endphp

                                            <tr>
                                                <td class="pe-4">
                                                    <span class="lira-id-chip">#{{ str_pad($tx->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </td>

                                                <td>
                                                    <span class="lira-type-chip {{ $typeClass }}">
                                                        <i class="fa-solid {{ $typeIcon }}"></i>
                                                        {{ $typeName }}
                                                    </span>
                                                </td>

                                                <td class="fw-bold">{{ formatCurrency($tx->amount) }}</td>

                                                <td>{!! renderStatusBadge($tx->status) !!}</td>

                                                <td class="ps-4 text-start text-muted">
                                                    {{ $tx->created_at?->format('Y/m/d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="lira-mobile-ledger d-md-none">
                                @foreach($transactionItems as $tx)
                                    @php
                                        $typeName = $tx->type->getName() ?? 'عملية مالية';
                                        $typeIcon = 'fa-money-bill-transfer';
                                        $typeClass = 'is-neutral';

                                        if (\Illuminate\Support\Str::contains($typeName, ['إيداع', 'Deposit'])) {
                                            $typeIcon = 'fa-arrow-down';
                                            $typeClass = 'is-profit';
                                        } elseif (\Illuminate\Support\Str::contains($typeName, ['سحب', 'Withdraw'])) {
                                            $typeIcon = 'fa-arrow-up';
                                            $typeClass = 'is-loss';
                                        } elseif (\Illuminate\Support\Str::contains($typeName, ['ربح', 'Profit'])) {
                                            $typeIcon = 'fa-chart-line';
                                            $typeClass = 'is-profit';
                                        } elseif (\Illuminate\Support\Str::contains($typeName, ['تحويل', 'Transfer'])) {
                                            $typeIcon = 'fa-right-left';
                                            $typeClass = 'is-neutral';
                                        }
                                    @endphp

                                    <div class="lira-mobile-ledger__item">
                                        <div class="lira-mobile-ledger__head">
                                            <span class="lira-type-chip {{ $typeClass }}">
                                                <i class="fa-solid {{ $typeIcon }}"></i>
                                                {{ $typeName }}
                                            </span>
                                            {!! renderStatusBadge($tx->status) !!}
                                        </div>
                                        <div class="lira-mobile-ledger__grid">
                                            <div>
                                                <span>رقم العملية</span>
                                                <strong>#{{ str_pad($tx->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                            </div>
                                            <div>
                                                <span>المبلغ</span>
                                                <strong>{{ formatCurrency($tx->amount) }}</strong>
                                            </div>
                                            <div>
                                                <span>التاريخ</span>
                                                <strong>{{ $tx->created_at?->format('Y/m/d') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if(method_exists($transactions, 'links'))
                                <div class="lira-table-footer">
                                    {{ $transactions->links() }}
                                </div>
                            @endif
                        @else
                            <div class="lira-empty-block">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <h5>لا توجد معاملات مالية حتى الآن</h5>
                                <p class="mb-3">عند تنفيذ أول عملية إيداع أو سحب أو تحويل، ستظهر هنا ضمن السجل المالي.</p>
                                <a href="{{ route('site.funding') }}" class="btn btn-primary">ابدأ بطلب إيداع</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 lira-transactions-side">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">إجراءات سريعة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-quick-actions">
                                <a href="{{ route('site.funding') }}" class="btn btn-primary">إيداع جديد</a>
                                <a href="{{ route('site.transactions-requests.index') }}" class="btn btn-outline-primary">طلبات الحساب</a>
                                <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}" class="btn lira-ghost-btn">طلب سحب</a>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملاحظات الحساب المالي</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>المعاملات تظهر هنا بعد تسجيلها واعتماد حالتها داخل النظام.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>الطلبات قيد المراجعة يمكن متابعتها بشكل أدق من صفحة طلباتي.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>العمليات المكتملة تنعكس على أرصدة الحساب بحسب نوع الحركة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>احتفظ بإثباتات التحويل عند الحاجة لتسريع المراجعة المالية.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">الخطة الحالية</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-summary-block mb-0">
                                <span>اسم الخطة</span>
                                <strong>{{ $user->plan->display_name ?? 'بدون خطة مفعلة' }}</strong>
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
        .lira-transactions-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
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
        }

        .lira-hero-note span {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-stat-card {
            min-height: 168px;
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

        .lira-stat-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: var(--lira-text-muted);
            flex-wrap: wrap;
        }

        .lira-table-card,
        .lira-side-card {
            overflow: hidden;
        }

        .lira-table-meta {
            display: flex;
            align-items: center;
            gap: 10px;
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

        .lira-clean-table thead th {
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-size: 12px !important;
        }

        .lira-clean-table tbody td {
            font-size: 13px;
        }

        .lira-id-chip {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 700;
            direction: ltr;
        }

        .lira-type-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .lira-type-chip.is-profit {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-type-chip.is-loss {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-type-chip.is-neutral {
            background: rgba(255, 255, 255, 0.04);
            color: var(--lira-text-soft);
        }

        .lira-table-footer {
            padding: 18px 20px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-quick-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .lira-guidelines {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lira-guideline-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--lira-text-soft);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-guideline-item i {
            color: var(--lira-accent);
            margin-top: 4px;
            flex: 0 0 auto;
        }

        .lira-summary-block {
            padding: 16px;
            border-radius: 18px;
            background: rgba(0, 230, 167, 0.08);
            border: 1px solid rgba(0, 230, 167, 0.16);
        }

        .lira-summary-block span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 4px;
        }

        .lira-summary-block strong {
            font-size: 1rem;
            color: var(--lira-accent);
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
            padding: 28px;
        }

        .lira-empty-block i {
            font-size: 34px;
            color: var(--lira-accent);
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
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .lira-mobile-ledger__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-mobile-ledger__grid span {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-mobile-ledger__grid strong {
            display: block;
            font-size: 13px;
            line-height: 1.5;
        }

        @media (max-width: 767.98px) {
            .lira-transactions-main {
                order: 2;
            }

            .lira-transactions-side {
                order: 1;
            }

            .lira-hero-note {
                min-width: 0;
                width: 100%;
            }

            .lira-dashboard-stats > [class*='col-'] {
                width: 50%;
                max-width: 50%;
                flex: 0 0 auto;
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
        }

        @media (max-width: 575.98px) {
            .lira-dashboard-stats > [class*='col-'] {
                width: 50%;
                max-width: 50%;
            }

            .lira-stat-value {
                font-size: 1.08rem;
            }

            .lira-stat-meta {
                font-size: 11px;
            }

            .lira-mobile-ledger__grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

