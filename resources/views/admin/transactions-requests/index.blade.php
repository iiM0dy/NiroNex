@extends('layouts.admin')
@section('title', 'طلبات المستخدمين')

@section('content')
    @php
        $requestsCollection = collect(method_exists($requests, 'items') ? $requests->items() : $requests);
        $totalRequestsCount = method_exists($requests, 'total') ? $requests->total() : $requestsCollection->count();

        $pendingCount = $requestsCollection->filter(fn($r) => $r->status === \App\Enums\TransactionStatus::Pending)->count();
        $acceptedCount = $requestsCollection->filter(fn($r) => $r->status === \App\Enums\TransactionStatus::Accepted)->count();
        $rejectedCount = $requestsCollection->filter(fn($r) => $r->status === \App\Enums\TransactionStatus::Rejected)->count();
    @endphp

    <div class="lira-admin-requests-page">
        <section class="lira-admin-requests-hero mb-4">
            <div>
                <span class="lira-admin-requests-kicker">REQUESTS MONITOR</span>
                <h2 class="lira-admin-requests-title">طلبات المعاملات</h2>
                <p class="lira-admin-requests-subtitle">
                    مراجعة طلبات الإيداع والسحب والتحويلات الداخلية، مع الوصول السريع إلى حالة كل طلب والملفات المرفقة.
                </p>
            </div>

            <div class="lira-admin-requests-total">
                <span class="lira-admin-requests-total-badge">
                    {{ number_format($totalRequestsCount) }} طلب
                </span>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="lira-admin-request-stat is-accent">
                    <div class="lira-admin-request-stat-top">
                        <span class="lira-admin-request-stat-label">إجمالي الطلبات</span>
                        <div class="lira-admin-request-stat-icon">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                    </div>
                    <div class="lira-admin-request-stat-value">{{ number_format($totalRequestsCount) }}</div>
                    <div class="lira-admin-request-stat-foot">جميع الطلبات في الصفحة الحالية أو كامل النتائج</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-request-stat is-warning">
                    <div class="lira-admin-request-stat-top">
                        <span class="lira-admin-request-stat-label">طلبات معلّقة</span>
                        <div class="lira-admin-request-stat-icon">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="lira-admin-request-stat-value">{{ number_format($pendingCount) }}</div>
                    <div class="lira-admin-request-stat-foot">تحتاج إلى مراجعة أو قرار إداري</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-request-stat is-success">
                    <div class="lira-admin-request-stat-top">
                        <span class="lira-admin-request-stat-label">طلبات مقبولة</span>
                        <div class="lira-admin-request-stat-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="lira-admin-request-stat-value">{{ number_format($acceptedCount) }}</div>
                    <div class="lira-admin-request-stat-foot">تم تنفيذها أو اعتمادها بنجاح</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-request-stat is-danger">
                    <div class="lira-admin-request-stat-top">
                        <span class="lira-admin-request-stat-label">طلبات مرفوضة</span>
                        <div class="lira-admin-request-stat-icon">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                    </div>
                    <div class="lira-admin-request-stat-value">{{ number_format($rejectedCount) }}</div>
                    <div class="lira-admin-request-stat-foot">طلبات لم تستوفِ الشروط أو تم رفضها</div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                @php
                    $handedData = $requestsCollection->map(function ($req) {
                        $d = $req->getFormattedTransferData();

                        return [
                            'id' => $req->id,
                            'display_id' => '#' . str_pad($req->id, 5, '0', STR_PAD_LEFT),
                            'type' => $req->type->getName(),
                            'user' => optional($req->user)->full_name ?? '—',
                            'receiver' => optional($req->receiver)->full_name ?? '—',
                            'amount' => match ($req->type) {
                                \App\Enums\TransactionRequestType::Robot => 'روبوت / ' . formatCurrency($req->amount),
                                \App\Enums\TransactionRequestType::InternalTransfer => 'داخلي / ' . formatCurrency($req->amount),
                                default => ($req->method?->getName() ?? '—') . ' / ' . formatCurrency($req->amount),
                            },
                            'status' => renderStatusBadge($req->status),
                            'image' => $req->getStorageUrl($req->image),
                            'date' => formatDate($req->created_at),
                            'transfer_data' => $d && !empty($d) ? $d : '—',
                            'admin_note' => $req->admin_note ?? '—',
                        ];
                    });
                @endphp

                <x-table :nativeData="$requests" title="قائمة طلبات المستخدمين" :columns="[
                    'display_id' => 'ID المعاملة',
                    'type' => 'النوع',
                    'user' => 'العميل|المرسل',
                    'receiver' => 'المستلم',
                    'amount' => 'الطريقة / المبلغ',
                    'status' => 'الحالة',
                    'image' => 'صورة مرفقة',
                    'date' => 'تاريخ المعاملة',
                    'transfer_data' => 'معلومات التحويل',
                    'admin_note' => 'ملاحظات',
                ]" :rows="$handedData->toArray()" :actions="[
                    ['type' => 'approve', 'route' => 'admin.transactions-requests.approve', 'key' => 'id'],
                    ['type' => 'reject', 'route' => 'admin.transactions-requests.reject', 'key' => 'id'],
                    ['type' => 'delete', 'route' => 'admin.transactions-requests.destroy', 'key' => 'id'],
                ]" />
            </div>
        </section>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-admin-requests-page {
            padding-bottom: 10px;
        }

        .lira-admin-requests-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .lira-admin-requests-kicker {
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

        .lira-admin-requests-title {
            margin: 0 0 10px;
            font-size: clamp(1.5rem, 2.2vw, 2rem);
            color: var(--lira-text);
        }

        .lira-admin-requests-subtitle {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 760px;
        }

        .lira-admin-requests-total-badge {
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

        .lira-admin-request-stat {
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

        .lira-admin-request-stat::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 90px;
            height: 90px;
            background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%);
            pointer-events: none;
        }

        .lira-admin-request-stat.is-accent {
            border-top: 2px solid var(--lira-accent);
        }

        .lira-admin-request-stat.is-warning {
            border-top: 2px solid var(--lira-warning);
        }

        .lira-admin-request-stat.is-success {
            border-top: 2px solid var(--lira-success);
        }

        .lira-admin-request-stat.is-danger {
            border-top: 2px solid var(--lira-danger);
        }

        .lira-admin-request-stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .lira-admin-request-stat-label {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lira-admin-request-stat-value {
            display: block;
            color: var(--lira-text);
            font-size: clamp(1.5rem, 2vw, 2rem);
            line-height: 1.1;
            font-weight: 800;
        }

        .lira-admin-request-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.04);
            flex: 0 0 auto;
        }

        .lira-admin-request-stat.is-accent .lira-admin-request-stat-icon {
            color: var(--lira-accent);
            background: rgba(0, 230, 167, 0.10);
        }

        .lira-admin-request-stat.is-warning .lira-admin-request-stat-icon {
            color: var(--lira-warning);
            background: rgba(120, 97, 255, 0.10);
        }

        .lira-admin-request-stat.is-success .lira-admin-request-stat-icon {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-admin-request-stat.is-danger .lira-admin-request-stat-icon {
            color: var(--lira-danger);
            background: rgba(240, 68, 56, 0.10);
        }

        .lira-admin-request-stat-foot {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        @media (max-width: 991.98px) {
            .lira-admin-requests-hero {
                align-items: flex-start;
            }
        }
    </style>
@endpush

