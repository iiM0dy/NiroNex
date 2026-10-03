@extends('layouts.admin')
@section('title', 'معاملات التحويل الداخلي')
@section('content')
    @php
        $requestsCollection = collect(method_exists($requests, 'items') ? $requests->items() : $requests);
        $totalCount = method_exists($requests, 'total') ? $requests->total() : $requestsCollection->count();
        $pendingCount = $requestsCollection->filter(fn($r) => $r->status === \App\Enums\TransactionStatus::Pending)->count();
        $acceptedCount = $requestsCollection->filter(fn($r) => $r->status === \App\Enums\TransactionStatus::Accepted)->count();
    @endphp

    <div class="lira-admin-internal-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">INTERNAL TRANSFERS</span>
                <h2 class="lira-page-hero-title">التحويلات الداخلية</h2>
                <p class="lira-page-hero-subtitle">
                    مراقبة جميع عمليات نقل الأرصدة بين المحافظ الداخلية، وإنشاء تحويلات إدارية جديدة.
                </p>
            </div>

            <div class="lira-page-hero-actions">
                <span class="lira-page-hero-badge">
                    {{ number_format($totalCount) }} عملية
                </span>
                <a href="{{ route('admin.transactions-requests.create-internal-transfer') }}" class="btn btn-primary px-4">
                    <i class="fa-solid fa-plus ms-2"></i>
                    تحويل جديد
                </a>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-accent">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">إجمالي التحويلات</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-right-left"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ number_format($totalCount) }}</div>
                    <div class="lira-metric-tile-foot">جميع عمليات التحويل الداخلي</div>
                </div>
            </div>

            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-warning">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">بانتظار المراجعة</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ number_format($pendingCount) }}</div>
                    <div class="lira-metric-tile-foot">تحويلات تنتظر القرار الإداري</div>
                </div>
            </div>

            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-success">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">تحويلات مكتملة</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ number_format($acceptedCount) }}</div>
                    <div class="lira-metric-tile-foot">تم تنفيذها واعتمادها بنجاح</div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                @php
                    $handedData = $requests->map(function ($req) {
                        $d = $req->getFormattedTransferData();
                        return [
                            'id' => $req->id,
                            'display_id' => '#' . str_pad($req->id, 5, '0', STR_PAD_LEFT),
                            'user' => optional($req->user)->full_name ?? '—',
                            'receiver' => optional($req->receiver)->full_name ?? '—',
                            'amount' => formatCurrency($req->amount),
                            'status' => renderStatusBadge($req->status),
                            'date' => formatDate($req->created_at),
                            'admin_note' => $req->admin_note ?? '—',
                        ];
                    });
                @endphp

                <x-table :nativeData="$requests" title="تحويلات داخلية" :columns="[
                    'display_id' => 'ID المعاملة',
                    'user' => 'المرسل',
                    'receiver' => 'المستلم',
                    'amount' => 'المبلغ',
                    'status' => 'الحالة',
                    'date' => 'تاريخ المعاملة',
                    'admin_note' => 'ملاحظات',
                ]" :rows="$handedData->toArray()"
                    :actions="[
                        ['type' => 'approve', 'route' => 'admin.transactions-requests.approve', 'key' => 'id'],
                        ['type' => 'reject', 'route' => 'admin.transactions-requests.reject', 'key' => 'id'],
                    ]" />
            </div>
        </section>
    </div>
@endsection
