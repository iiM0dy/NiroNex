@extends('layouts.admin')
@section('title', 'صندوق الرسائل')
@section('content')
    @php
        $totalChats = $users->total() ?? $users->count();
        $usersCollection = collect(method_exists($users, 'items') ? $users->items() : $users);
        $unreadTotal = $usersCollection->sum('unread_count');
    @endphp

    <div class="lira-admin-messages-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">MESSAGES CENTER</span>
                <h2 class="lira-page-hero-title">إدارة المحادثات</h2>
                <p class="lira-page-hero-subtitle">
                    التواصل مع العملاء والرد على استفسارات الدعم الفني ومتابعة الرسائل الواردة والصادرة.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <span class="lira-page-hero-badge">
                    <i class="fa-solid fa-comments ms-2"></i>
                    {{ number_format($totalChats) }} محادثة
                </span>
                @if($unreadTotal > 0)
                    <span class="lira-page-hero-badge" style="background: rgba(240, 68, 56, 0.10); border-color: rgba(240, 68, 56, 0.18); color: #ff8a80;">
                        <i class="fa-solid fa-bell ms-2"></i>
                        {{ $unreadTotal }} غير مقروء
                    </span>
                @endif
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-accent">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">إجمالي المحادثات</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ number_format($totalChats) }}</div>
                    <div class="lira-metric-tile-foot">جميع المحادثات النشطة مع العملاء</div>
                </div>
            </div>

            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-danger">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">رسائل غير مقروءة</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ number_format($unreadTotal) }}</div>
                    <div class="lira-metric-tile-foot">رسائل تنتظر الرد من الإدارة</div>
                </div>
            </div>

            <div class="col-6 col-xl-4">
                <div class="lira-metric-tile is-info">
                    <div class="lira-metric-tile-top">
                        <span class="lira-metric-tile-label">معدل الاستجابة</span>
                        <div class="lira-metric-tile-icon">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                    </div>
                    <div class="lira-metric-tile-value">{{ $unreadTotal > 0 ? round((($totalChats - $unreadTotal) / max($totalChats, 1)) * 100) : 100 }}%</div>
                    <div class="lira-metric-tile-foot">نسبة المحادثات المُتابَعة</div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                @php
                    $handedData = $users->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'display_id' => '#' . str_pad($value->id, 4, '0', STR_PAD_LEFT),
                            'name' => $value->full_name,
                            'email' => $value->email,
                            'unread_count' => $value->unread_count > 0
                                ? '<span class="badge bg-danger rounded-pill px-3 py-2" style="width: fit-content;">' . $value->unread_count . ' غير مقروء</span>'
                                : '<span class="badge rounded-pill px-3 py-2" style="width: fit-content; background: rgba(255,255,255,0.05); color: var(--lira-text-muted);">لا يوجد جديد</span>',
                        ];
                    });
                @endphp

                <x-table :nativeData="$users" title="قائمة المحادثات مع العملاء" :columns="[
                    'display_id' => 'ID العميل',
                    'name' => 'اسم العميل',
                    'email' => 'البريد الالكتروني',
                    'unread_count' => 'الرسائل غير المقروءة',
                ]" :rows="$handedData->toArray()" :actions="[
                    [
                        'type' => 'custom',
                        'key' => 'id',
                        'html' => '<a href=\'' . url('admin/messages/{id}') . '\' class=\'btn btn-sm px-3 py-1 text-white\' style=\'background-color: var(--lira-accent);\'>
                                                <i class=\'fas fa-comments me-1\'></i> فتح الرسائل
                                               </a>'
                    ],
                ]" />
            </div>
        </section>
    </div>
@endsection
