@extends('layouts.admin')

@section('title', 'طلبات الروبوت')

@section('content')
    @php
        $statusTabs = [
            'all' => ['label' => 'الكل', 'count' => $stats['total'] ?? 0],
            'pending' => ['label' => 'قيد المراجعة', 'count' => $stats['pending'] ?? 0],
            'accepted' => ['label' => 'مقبولة', 'count' => $stats['accepted'] ?? 0],
            'rejected' => ['label' => 'مرفوضة', 'count' => $stats['rejected'] ?? 0],
            'canceled' => ['label' => 'ملغاة', 'count' => $stats['canceled'] ?? 0],
        ];

        $requestsCollection = collect(method_exists($requests, 'items') ? $requests->items() : $requests);
        $formatRobotDetails = function ($request) {
            $setting = $request->robotSetting;
            $data = $request->transfer_data ?? [];
            $risk = $setting?->risk_label ?? ($data['risk_level_label'] ?? '—');
            $allocation = $setting?->allocation_amount ?? ($data['allocation_amount'] ?? $request->amount);
            $walletPercentage = $setting?->wallet_percentage ?? ($data['wallet_percentage'] ?? null);
            $pepPrice = $setting?->pep_price ?? ($data['pep_price'] ?? null);
            $takeProfit = $setting?->take_profit ?? ($data['take_profit'] ?? null);
            $stopLoss = $setting?->stop_loss ?? ($data['stop_loss'] ?? null);

            $items = [
                'المخاطرة' => $risk,
                'التخصيص' => formatCurrency($allocation),
                'النسبة' => !is_null($walletPercentage) ? formatPercent($walletPercentage) : '—',
                'PEP' => !is_null($pepPrice) ? formatCurrency($pepPrice) : '—',
                'TP / SL' => (!is_null($takeProfit) ? formatPercent($takeProfit) : '—') . ' / ' . (!is_null($stopLoss) ? formatPercent($stopLoss) : '—'),
            ];

            return collect($items)->map(fn ($value, $label) => '<span><strong>' . e($label) . '</strong>' . e($value) . '</span>')->implode('');
        };

        $handedData = $requestsCollection->map(function ($request) use ($formatRobotDetails) {
            $setting = $request->robotSetting;

            return [
                'id' => $request->id,
                'user_id' => $request->user_id,
                'display_id' => '#' . str_pad($request->id, 5, '0', STR_PAD_LEFT),
                'user' => optional($request->user)->full_name . '<br><small class="text-muted">' . e(optional($request->user)->email ?? '—') . '</small>',
                'amount' => formatCurrency($request->amount),
                'robot_details' => '<div class="lira-robot-detail-grid">' . $formatRobotDetails($request) . '</div>',
                'status' => renderStatusBadge($request->status),
                'setting_status' => $setting
                    ? '<span class="badge ' . ($setting->is_active ? 'bg-success' : 'bg-warning text-dark') . '">' . e($setting->status_label) . '</span>'
                    : '<span class="badge bg-secondary">لا توجد إعدادات</span>',
                'reviewer' => optional($request->reviewer)->full_name ?? '—',
                'admin_note' => $request->admin_note ?: '—',
                'date' => formatDate($request->created_at),
            ];
        });
    @endphp

    <div class="lira-robot-requests-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">NIROBOT REQUESTS</span>
                <h1 class="lira-page-hero-title">طلبات تفعيل الروبوت</h1>
                <p class="lira-page-hero-subtitle">
                    صفحة لمراجعة طلبات الروبوت، تفاصيل المخاطرة والتخصيص، واتخاذ قرار الموافقة أو الرفض.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <span class="lira-page-hero-badge">{{ number_format($stats['pending'] ?? 0) }} قيد المراجعة</span>
                <span class="lira-page-hero-badge">{{ number_format($stats['total'] ?? 0) }} طلب روبوت</span>
            </div>
        </section>

        <section class="lira-filter-panel mb-4">
            <form method="GET" class="lira-filter-form">
                <div class="lira-filter-tabs" role="tablist" aria-label="Robot request status filters">
                    @foreach ($statusTabs as $key => $tab)
                        <a href="{{ route('admin.robot-requests.index', array_filter(['status' => $key, 'search' => request('search')])) }}"
                            class="lira-filter-tab {{ $status === $key ? 'is-active' : '' }}">
                            <span>{{ $tab['label'] }}</span>
                            <strong>{{ number_format($tab['count']) }}</strong>
                        </a>
                    @endforeach
                </div>

                <div class="lira-filter-search">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="بحث بالعميل، البريد، أو رقم الطلب...">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </form>
        </section>

        <x-table :nativeData="$requests" title="قائمة طلبات الروبوت" :columns="[
            'display_id' => 'ID الطلب',
            'user' => 'العميل',
            'amount' => 'المبلغ',
            'robot_details' => 'إعدادات الروبوت',
            'status' => 'حالة الطلب',
            'setting_status' => 'حالة الروبوت',
            'reviewer' => 'راجع بواسطة',
            'admin_note' => 'ملاحظة',
            'date' => 'تاريخ الطلب',
        ]" :rows="$handedData->toArray()" :actions="[
            ['type' => 'approve', 'route' => 'admin.transactions-requests.approve', 'key' => 'id'],
            ['type' => 'reject', 'route' => 'admin.transactions-requests.reject', 'key' => 'id'],
            [
                'type' => 'custom',
                'key' => 'user_id',
                'route' => 'admin.users.show',
                'label' => 'ملف العميل',
                'class' => 'btn btn-sm btn-info text-white',
            ],
        ]" />
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-filter-panel {
            padding: 16px;
            border: 1px solid var(--lira-border);
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)), var(--lira-surface-2);
        }

        .lira-filter-form,
        .lira-filter-search {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lira-filter-tabs {
            display: flex;
            gap: 8px;
            flex: 1 1 auto;
            flex-wrap: wrap;
        }

        .lira-filter-tab {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 13px;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 999px;
            background: rgba(255,255,255,0.025);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 800;
        }

        .lira-filter-tab.is-active {
            color: var(--lira-accent);
            border-color: rgba(0, 230, 167, 0.26);
            background: rgba(0, 230, 167, 0.1);
        }

        .lira-filter-search {
            flex: 0 1 430px;
        }

        .lira-filter-search .form-control {
            min-width: 240px;
        }

        .lira-robot-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 6px;
            min-width: 300px;
        }

        .lira-robot-detail-grid span {
            padding: 7px 8px;
            border-radius: 10px;
            background: rgba(255,255,255,0.035);
            color: var(--lira-text-soft);
            font-size: 11px;
            line-height: 1.5;
        }

        .lira-robot-detail-grid strong {
            display: block;
            color: var(--lira-text-muted);
            font-size: 9px;
            margin-bottom: 2px;
        }

        .lira-robot-requests-page .btn-info.text-white {
            color: #fff !important;
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .lira-filter-search,
            .lira-filter-search .form-control,
            .lira-filter-search .btn {
                width: 100%;
            }

            .lira-robot-detail-grid {
                min-width: 0;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
@endpush
