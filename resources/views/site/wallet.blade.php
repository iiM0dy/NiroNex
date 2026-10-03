@extends('layouts.site-dash')

@section('title', 'المحفظة')

@section('content')
    <div class="lira-wallet-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · WALLET</span>
                <h1 class="lira-page-title">المحفظة</h1>
                <p class="lira-page-subtitle">تابع رصيدك، وأدِر عمليات الإيداع والسحب والتحويل.</p>
            </div>
        </div>

        {{-- ─── BALANCE CARDS ─── --}}
        <div class="lira-balance-strip mb-4">
            <div class="lira-balance-card is-total">
                <i class="fa-solid fa-wallet"></i>
                <div>
                    <span>الرصيد الإجمالي</span>
                    <strong>{{ formatCurrency($totalBalance) }}</strong>
                </div>
            </div>
            <div class="lira-balance-card">
                <i class="fa-solid fa-arrow-down"></i>
                <div>
                    <span>رصيد الإيداع</span>
                    <strong>{{ formatCurrency($depositBalance) }}</strong>
                </div>
            </div>
            <div class="lira-balance-card">
                <i class="fa-solid fa-sack-dollar"></i>
                <div>
                    <span>رصيد الأرباح</span>
                    <strong>{{ formatCurrency($profitBalance) }}</strong>
                </div>
            </div>
            <div class="lira-balance-card">
                <i class="fa-solid fa-chart-line"></i>
                <div>
                    <span>رصيد التداول</span>
                    <strong>{{ formatCurrency($tradingBalance) }}</strong>
                </div>
            </div>
            <div class="lira-balance-card">
                <i class="fa-solid fa-layer-group"></i>
                <div>
                    <span>الرصيد المستخدم في الخطط</span>
                    <strong>{{ formatCurrency($planAmount) }}</strong>
                </div>
            </div>
            <div class="lira-balance-card">
                <i class="fa-solid fa-robot"></i>
                <div>
                    <span>الرصيد المستخدم في الروبوت</span>
                    <strong>{{ formatCurrency($robotBalance) }}</strong>
                </div>
            </div>
        </div>

        {{-- ─── QUICK ACTIONS ─── --}}
        <div class="lira-quick-actions mb-4">
            <a href="{{ route('site.funding') }}" class="lira-action-btn">
                <i class="fa-solid fa-plus"></i>
                إيداع
            </a>
            <a href="{{ route('site.transactions-requests.create') }}" class="lira-action-btn">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                سحب
            </a>
            <a href="{{ route('site.transactions-requests.create', ['t' => 't']) }}" class="lira-action-btn">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                تحويل داخلي
            </a>
        </div>

        @if(session('success') || session('error') || session('warning') || $errors->any())
            <div class="lira-wallet-alerts mb-4">
                @if(session('success'))
                    <div class="alert alert-success mb-0">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-0">{{ session('error') }}</div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning mb-0">{{ session('warning') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-0">
                        <ul class="mb-0 list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <div class="lira-trading-withdraw-panel mb-4">
            <div class="lira-trading-withdraw-panel__copy">
                <span class="lira-eyebrow mb-2">TRADING · WITHDRAW</span>
                <h2>تحويل رصيد التداول إلى محفظة الأرباح</h2>
                <p>انقل أرباح التداول إلى محفظة الأرباح، ثم استخدم زر السحب لإرسال طلب سحب خارجي.</p>
            </div>
            <form action="{{ route('site.trading.withdraw') }}" method="POST" class="lira-trading-withdraw-form">
                @csrf
                <label for="trading-withdraw-amount">المبلغ</label>
                <div class="lira-trading-withdraw-form__row">
                    <input
                        type="number"
                        id="trading-withdraw-amount"
                        name="amount"
                        class="form-control"
                        placeholder="0.00"
                        value="{{ old('amount') }}"
                        min="1"
                        @if($tradingBalance > 0) max="{{ $tradingBalance }}" @endif
                        step="0.01"
                        required>
                    <button type="submit" class="lira-action-btn is-primary" @disabled($tradingBalance < 1)>
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        تحويل للأرباح
                    </button>
                </div>
                <small>رصيد التداول المتاح: {{ formatCurrency($tradingBalance) }}</small>
            </form>
        </div>

        {{-- ─── PENDING REQUESTS ─── --}}
        @if($pendingRequests->count())
            <div class="card lira-table-card mb-4">
                <div class="card-header border-0">
                    <h6 class="mb-1">طلبات قيد الانتظار</h6>
                    <p class="text-muted mb-0 small">طلبات لم تتم الموافقة عليها بعد.</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table lira-clean-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>النوع</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingRequests as $req)
                                    <tr>
                                        <td>{{ $req->type_label ?? $req->type }}</td>
                                        <td><strong>{{ formatCurrency($req->amount) }}</strong></td>
                                        <td><span class="lira-status-chip is-pending">قيد الانتظار</span></td>
                                        <td class="text-muted">{{ $req->created_at->format('Y/m/d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="lira-mobile-records d-md-none">
                        @foreach($pendingRequests as $req)
                            <div class="lira-mobile-record">
                                <div class="lira-mobile-record__head">
                                    <strong>{{ $req->type_label ?? $req->type }}</strong>
                                    <span class="lira-status-chip is-pending">قيد الانتظار</span>
                                </div>
                                <div class="lira-mobile-record__grid">
                                    <div>
                                        <span>المبلغ</span>
                                        <strong>{{ formatCurrency($req->amount) }}</strong>
                                    </div>
                                    <div>
                                        <span>التاريخ</span>
                                        <strong>{{ $req->created_at->format('Y/m/d H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- ─── TRANSACTION HISTORY ─── --}}
        <div class="card lira-table-card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-1">سجل المعاملات</h6>
                        <p class="text-muted mb-0 small">جميع عمليات الإيداع والسحب والتحويل.</p>
                    </div>
                    <span class="lira-badge-chip">{{ $transactions->total() }} معاملة</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($transactions->count())
                    <div class="table-responsive d-none d-md-block">
                        <table class="table lira-clean-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المحفظة</th>
                                    <th>المبلغ</th>
                                    <th>الرصيد بعد</th>
                                    <th>الوصف</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $tx)
                                    <tr>
                                        <td><span class="lira-id-chip">#{{ $tx->id }}</span></td>
                                        <td>{{ $tx->wallet->type ?? '--' }}</td>
                                        <td class="{{ $tx->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $tx->amount >= 0 ? '+' : '' }}{{ formatCurrency($tx->amount) }}
                                        </td>
                                        <td>{{ formatCurrency($tx->balance_after ?? 0) }}</td>
                                        <td class="text-muted">{{ $tx->description ?? '--' }}</td>
                                        <td class="text-muted">{{ $tx->created_at->format('Y/m/d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="lira-mobile-records d-md-none">
                        @foreach($transactions as $tx)
                            <div class="lira-mobile-record">
                                <div class="lira-mobile-record__head">
                                    <strong>#{{ $tx->id }}</strong>
                                    <span class="{{ $tx->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $tx->amount >= 0 ? '+' : '' }}{{ formatCurrency($tx->amount) }}
                                    </span>
                                </div>
                                <div class="lira-mobile-record__grid">
                                    <div>
                                        <span>المحفظة</span>
                                        <strong>{{ $tx->wallet->type ?? '--' }}</strong>
                                    </div>
                                    <div>
                                        <span>الرصيد بعد</span>
                                        <strong>{{ formatCurrency($tx->balance_after ?? 0) }}</strong>
                                    </div>
                                    <div>
                                        <span>الوصف</span>
                                        <strong>{{ $tx->description ?? '--' }}</strong>
                                    </div>
                                    <div>
                                        <span>التاريخ</span>
                                        <strong>{{ $tx->created_at->format('Y/m/d') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="lira-table-footer">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="lira-empty-block">
                        <i class="fa-solid fa-receipt"></i>
                        <h5>لا توجد معاملات بعد</h5>
                        <p>ستظهر هنا جميع عملياتك المالية.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-balance-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }

        .lira-balance-card {
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 88px;
            padding: 16px 18px;
            border-radius: var(--radius-md);
            background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.008)), var(--lira-surface);
            border: 1px solid var(--lira-border);
        }

        .lira-balance-card.is-total {
            background: linear-gradient(135deg, rgba(0,230,167,0.06), rgba(0,230,167,0.02));
            border-color: rgba(0,230,167,0.18);
        }

        .lira-balance-card.is-total i {
            color: var(--lira-gold);
        }

        .lira-balance-card i {
            font-size: 24px;
            color: var(--lira-text-muted);
            flex: 0 0 auto;
        }

        .lira-balance-card span {
            display: block;
            font-size: 12px;
            color: var(--lira-text-muted);
            margin-bottom: 4px;
        }

        .lira-balance-card strong {
            font-size: 1.3rem;
            font-weight: 800;
            direction: ltr;
            display: block;
            text-align: right;
        }

        .lira-quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 44px;
            padding: 0 20px;
            border-radius: 999px;
            background: var(--lira-surface-2);
            border: 1px solid var(--lira-border);
            color: var(--lira-text);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        .lira-action-btn:hover {
            background: rgba(0,230,167,0.08);
            border-color: rgba(0,230,167,0.28);
            color: var(--lira-gold);
        }

        .lira-action-btn.is-primary {
            min-width: 150px;
            justify-content: center;
            border-color: var(--lira-gold);
            background: var(--lira-gold);
            color: #000;
        }

        .lira-action-btn.is-primary:hover {
            background: #00c891;
            border-color: #00c891;
            color: #000;
        }

        .lira-action-btn.is-primary:disabled {
            opacity: 0.48;
            cursor: not-allowed;
        }

        .lira-wallet-alerts {
            display: grid;
            gap: 10px;
        }

        .lira-wallet-alerts .alert-success {
            background: rgba(23,178,106,0.14) !important;
            border-color: rgba(23,178,106,0.22) !important;
            color: #5fe2a1 !important;
        }

        .lira-trading-withdraw-panel {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(300px, 430px);
            gap: 18px;
            align-items: center;
            padding: 22px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, rgba(0,230,167,0.055), rgba(255,255,255,0.018)), var(--lira-surface);
            border: 1px solid var(--lira-border);
        }

        .lira-trading-withdraw-panel h2 {
            margin: 0 0 8px;
            color: var(--lira-text);
            font-size: 1.08rem;
            line-height: 1.6;
            font-weight: 800;
        }

        .lira-trading-withdraw-panel p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-trading-withdraw-form label,
        .lira-trading-withdraw-form small {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .lira-trading-withdraw-form label {
            margin-bottom: 8px;
            color: var(--lira-text-soft);
            font-weight: 700;
        }

        .lira-trading-withdraw-form small {
            margin-top: 8px;
        }

        .lira-trading-withdraw-form__row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
        }

        .lira-trading-withdraw-form .form-control {
            min-height: 44px;
            border-radius: 999px !important;
            direction: ltr;
            text-align: left;
        }

        .lira-status-chip {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .lira-status-chip.is-pending {
            background: rgba(255,193,7,0.14);
            color: #ffd54f;
        }

        .lira-status-chip.is-approved {
            background: rgba(23,178,106,0.14);
            color: #5fe2a1;
        }

        .lira-status-chip.is-rejected {
            background: rgba(240,68,56,0.14);
            color: #ff8a80;
        }

        .lira-id-chip {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.05);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 700;
            direction: ltr;
        }

        .lira-badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 700;
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
            color: var(--lira-gold);
        }

        .lira-mobile-records {
            display: grid;
            gap: 10px;
            padding: 14px;
        }

        .lira-mobile-record {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-mobile-record__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .lira-mobile-record__head strong {
            font-size: 13px;
        }

        .lira-mobile-record__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-mobile-record__grid span {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-mobile-record__grid strong {
            display: block;
            font-size: 13px;
            line-height: 1.6;
        }

        .lira-table-footer {
            padding: 18px 20px 20px;
            border-top: 1px solid rgba(255,255,255,0.04);
        }

        @media (max-width: 767.98px) {
            .lira-balance-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-quick-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .lira-balance-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                min-height: 96px;
                padding: 12px 10px;
                border-radius: 14px;
            }

            .lira-balance-card i {
                font-size: 18px;
            }

            .lira-balance-card strong {
                font-size: 0.98rem;
            }

            .lira-action-btn {
                flex: 1;
                min-width: 120px;
                justify-content: center;
                padding: 0 8px;
                border-radius: 16px;
                font-size: 12px;
            }

            .lira-trading-withdraw-panel {
                grid-template-columns: 1fr;
                padding: 16px;
            }

            .lira-trading-withdraw-form__row {
                grid-template-columns: 1fr;
            }

            .lira-action-btn.is-primary {
                min-width: 0;
            }
        }

        @media (max-width: 575.98px) {
            .lira-balance-strip {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 6px;
            }

            .lira-quick-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .lira-balance-card span {
                font-size: 10px;
                margin-bottom: 2px;
            }

            .lira-balance-card strong {
                font-size: 0.9rem;
            }

            .lira-action-btn {
                flex: 1;
                min-width: 100px;
                font-size: 12px;
                gap: 6px;
            }

            .lira-mobile-record__grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
