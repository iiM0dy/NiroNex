@extends('layouts.site-dash')

@section('title', 'الأداء')

@section('content')
    <div class="lira-performance-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · PERFORMANCE</span>
                <h1 class="lira-page-title">إحصائيات الأداء</h1>
                <p class="lira-page-subtitle">تحليل شامل لأداء صفقاتك: معدل الربح، العوائد، والتراجع.</p>
            </div>
        </div>

        {{-- ─── STATS CARDS ─── --}}
        <div class="lira-perf-stats mb-4">
            <div class="lira-perf-stat">
                <div class="lira-perf-stat-icon is-green">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <div>
                    <span>معدل النجاح</span>
                    <strong>{{ $winRate }}%</strong>
                </div>
            </div>
            <div class="lira-perf-stat">
                <div class="lira-perf-stat-icon is-accent">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <span>متوسط العائد</span>
                    <strong class="{{ $avgReturn >= 0 ? 'text-success' : 'text-danger' }}">{{ $avgReturn >= 0 ? '+' : '' }}{{ formatCurrency($avgReturn) }}</strong>
                </div>
            </div>
            <div class="lira-perf-stat">
                <div class="lira-perf-stat-icon is-red">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
                <div>
                    <span>أقصى تراجع</span>
                    <strong>{{ $drawdown }}%</strong>
                </div>
            </div>
            <div class="lira-perf-stat">
                <div class="lira-perf-stat-icon">
                    <i class="fa-solid fa-hashtag"></i>
                </div>
                <div>
                    <span>إجمالي الصفقات</span>
                    <strong>{{ $totalTrades }}</strong>
                </div>
            </div>
        </div>

        {{-- ─── EQUITY CURVE ─── --}}
        <div class="card lira-table-card mb-4">
            <div class="card-header border-0">
                <h6 class="mb-1">منحنى رأس المال (Equity Curve)</h6>
                <p class="text-muted mb-0 small">تطور الأرباح التراكمية على مدار صفقاتك.</p>
            </div>
            <div class="card-body" style="min-height: 300px;">
                @if(count($equityDates) > 0)
                    <canvas id="equityCurveChart"></canvas>
                @else
                    <div class="lira-empty-block" style="min-height: 260px;">
                        <i class="fa-solid fa-chart-area"></i>
                        <h5>لا توجد بيانات كافية</h5>
                        <p>سيظهر المنحنى بعد إغلاق أول صفقاتك.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="lira-disclaimer">
            <i class="fa-solid fa-circle-info"></i>
            <span>تنبيه: الأداء السابق لا يعكس بالضرورة النتائج المستقبلية. جميع الأرقام للاسترشاد فقط.</span>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-perf-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .lira-perf-stat {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 22px 20px;
            border-radius: var(--radius-md);
            background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.008)), var(--lira-surface);
            border: 1px solid var(--lira-border);
        }

        .lira-perf-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex: 0 0 auto;
            background: rgba(255,255,255,0.04);
            color: var(--lira-text-muted);
        }

        .lira-perf-stat-icon.is-green {
            background: rgba(23,178,106,0.10);
            color: #5fe2a1;
        }

        .lira-perf-stat-icon.is-accent {
            background: rgba(0,230,167,0.10);
            color: var(--lira-accent);
        }

        .lira-perf-stat-icon.is-red {
            background: rgba(240,68,56,0.10);
            color: #ff8a80;
        }

        .lira-perf-stat span {
            display: block;
            font-size: 12px;
            color: var(--lira-text-muted);
            margin-bottom: 4px;
        }

        .lira-perf-stat strong {
            font-size: 1.3rem;
            font-weight: 800;
            direction: ltr;
            display: block;
            text-align: right;
        }

        .lira-disclaimer {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 16px 18px;
            border-radius: var(--radius-md);
            background: rgba(255,193,7,0.06);
            border: 1px solid rgba(255,193,7,0.12);
            font-size: 13px;
            color: #ffd54f;
            line-height: 1.8;
        }

        .lira-disclaimer i {
            margin-top: 3px;
            flex: 0 0 auto;
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

@push('scripts')
    @if(count($equityDates) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('equityCurveChart').getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(0,230,167,0.18)');
                gradient.addColorStop(1, 'rgba(0,230,167,0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($equityDates),
                        datasets: [{
                            label: 'الأرباح التراكمية ($)',
                            data: @json($equityValues),
                            borderColor: '#00e6a7',
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                            pointBackgroundColor: '#00e6a7',
                            pointBorderColor: 'rgba(15,23,42,0.8)',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                grid: { color: 'rgba(255,255,255,0.04)' },
                                ticks: {
                                    color: 'rgba(255,255,255,0.4)',
                                    callback: val => '$' + val
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: 'rgba(255,255,255,0.3)' }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endpush

