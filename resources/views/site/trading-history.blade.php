@extends('layouts.site-dash')

@section('title', 'سجل الصفقات')

@section('content')
    <div class="lira-trading-history-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · TRADING HISTORY</span>
                <h1 class="lira-page-title">سجل الصفقات</h1>
                <p class="lira-page-subtitle">كل الصفقات المغلقة مع نتيجة الربح أو الخسارة وتفاصيل التنفيذ.</p>
            </div>
        </div>

        <div class="lira-history-stats mb-4">
            <div class="lira-history-stat">
                <i class="fa-solid fa-list-check"></i>
                <span>إجمالي الصفقات</span>
                <strong>{{ $totalTrades }}</strong>
            </div>
            <div class="lira-history-stat is-win">
                <i class="fa-solid fa-trophy"></i>
                <span>صفقات رابحة</span>
                <strong>{{ $winningTrades }}</strong>
            </div>
            <div class="lira-history-stat is-loss">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>صفقات خاسرة</span>
                <strong>{{ $losingTrades }}</strong>
            </div>
            <div class="lira-history-stat">
                <i class="fa-solid fa-percent"></i>
                <span>معدل الربح</span>
                <strong>{{ $winRate }}%</strong>
            </div>
            <div class="lira-history-stat {{ $netPnl >= 0 ? 'is-win' : 'is-loss' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>صافي الربح والخسارة</span>
                <strong>{{ $netPnl >= 0 ? '+' : '' }}{{ formatCurrency($netPnl) }}</strong>
            </div>
        </div>

        <div class="card lira-table-card">
            <div class="card-header border-0">
                <h6 class="mb-1">كل الصفقات المغلقة</h6>
                <p class="text-muted mb-0 small">يتم ترتيب السجل من الأحدث إلى الأقدم.</p>
            </div>

            <div class="card-body p-0">
                @if($closedTrades->count())
                    <div class="table-responsive d-none d-md-block">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>النتيجة</th>
                                    <th>الرمز</th>
                                    <th>الاتجاه</th>
                                    <th>المبلغ</th>
                                    <th>سعر الدخول</th>
                                    <th>سعر الإغلاق</th>
                                    <th>الربح / الخسارة</th>
                                    <th>وقت الإغلاق</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($closedTrades as $trade)
                                    @php
                                        $isWin = (float) $trade->pnl > 0;
                                        $type = strtoupper($trade->type);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="lira-result-chip {{ $isWin ? 'is-win' : 'is-loss' }}">
                                                <i class="fa-solid {{ $isWin ? 'fa-trophy' : 'fa-triangle-exclamation' }}"></i>
                                                {{ $isWin ? 'رابحة' : 'خاسرة' }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $trade->symbol }}</strong></td>
                                        <td>{{ $type }}</td>
                                        <td>{{ formatCurrency($trade->lot_size) }}</td>
                                        <td dir="ltr">{{ formatTrimmedNumber($trade->open_price, 8) }}</td>
                                        <td dir="ltr">{{ formatTrimmedNumber($trade->close_price, 8) }}</td>
                                        <td class="{{ $isWin ? 'text-success' : 'text-danger' }}">
                                            {{ $isWin ? '+' : '' }}{{ formatCurrency($trade->pnl) }}
                                        </td>
                                        <td class="text-muted">{{ $trade->closed_at?->format('Y/m/d H:i') ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="lira-history-mobile d-md-none">
                        @foreach($closedTrades as $trade)
                            @php
                                $isWin = (float) $trade->pnl > 0;
                                $type = strtoupper($trade->type);
                            @endphp
                            <article class="lira-history-record {{ $isWin ? 'is-win' : 'is-loss' }}">
                                <div class="lira-history-record__head">
                                    <div>
                                        <strong>{{ $trade->symbol }}</strong>
                                        <span>{{ $type }} · {{ $trade->closed_at?->format('Y/m/d H:i') ?? '--' }}</span>
                                    </div>
                                    <span class="lira-result-chip {{ $isWin ? 'is-win' : 'is-loss' }}">
                                        <i class="fa-solid {{ $isWin ? 'fa-trophy' : 'fa-triangle-exclamation' }}"></i>
                                        {{ $isWin ? 'رابحة' : 'خاسرة' }}
                                    </span>
                                </div>

                                <div class="lira-history-record__grid">
                                    <div>
                                        <span>المبلغ</span>
                                        <strong>{{ formatCurrency($trade->lot_size) }}</strong>
                                    </div>
                                    <div>
                                        <span>النتيجة</span>
                                        <strong class="{{ $isWin ? 'text-success' : 'text-danger' }}">{{ $isWin ? '+' : '' }}{{ formatCurrency($trade->pnl) }}</strong>
                                    </div>
                                    <div>
                                        <span>الدخول</span>
                                        <strong dir="ltr">{{ formatTrimmedNumber($trade->open_price, 8) }}</strong>
                                    </div>
                                    <div>
                                        <span>الإغلاق</span>
                                        <strong dir="ltr">{{ formatTrimmedNumber($trade->close_price, 8) }}</strong>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="lira-history-footer">
                        {{ $closedTrades->links() }}
                    </div>
                @else
                    <div class="lira-empty-block">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h5>لا توجد صفقات مغلقة بعد</h5>
                        <p>بعد إغلاق أول صفقة ستظهر هنا نتيجة الربح أو الخسارة وتفاصيلها.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-history-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 12px;
        }

        .lira-history-stat {
            display: grid;
            gap: 6px;
            padding: 16px;
            border-radius: 16px;
            background: var(--lira-surface);
            border: 1px solid var(--lira-border);
        }

        .lira-history-stat i {
            color: var(--lira-text-muted);
            font-size: 18px;
        }

        .lira-history-stat.is-win i,
        .lira-history-stat.is-win strong {
            color: #5fe2a1;
        }

        .lira-history-stat.is-loss i,
        .lira-history-stat.is-loss strong {
            color: #ff8a80;
        }

        .lira-history-stat span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-history-stat strong {
            font-size: 1.2rem;
            font-weight: 800;
            direction: ltr;
        }

        .lira-result-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .lira-result-chip.is-win {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-result-chip.is-loss {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-history-mobile {
            display: grid;
            gap: 10px;
            padding: 14px;
        }

        .lira-history-record {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255,255,255,0.025);
            border: 1px solid var(--lira-border);
        }

        .lira-history-record.is-win {
            border-color: rgba(23, 178, 106, 0.18);
        }

        .lira-history-record.is-loss {
            border-color: rgba(240, 68, 56, 0.18);
        }

        .lira-history-record__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .lira-history-record__head strong,
        .lira-history-record__head span {
            display: block;
        }

        .lira-history-record__head > div span,
        .lira-history-record__grid span {
            color: var(--lira-text-muted);
            font-size: 11px;
            margin-top: 3px;
        }

        .lira-history-record__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-history-record__grid strong {
            display: block;
            font-size: 13px;
            margin-top: 3px;
        }

        .lira-history-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.04);
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
    </style>
@endpush
