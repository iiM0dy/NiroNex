@extends('layouts.admin')

@section('title', 'لوحة القيادة الإدارية')

@section('content')
    @php
        $normalize = function ($value) {
            if ($value instanceof \Illuminate\Contracts\Pagination\Paginator || $value instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                return collect($value->items());
            }
            return collect($value ?? []);
        };

        $formatNumber = function ($value) {
            return is_numeric($value) ? number_format((float) $value) : '—';
        };

        $formatMoney = function ($value) {
            return is_numeric($value) ? formatCurrency($value) : '—';
        };

        $latestUsers = $normalize($latestUsers ?? $users ?? []);
        $latestTransactions = $normalize($latestTransactions ?? $transactions ?? []);
        $pendingRequests = $normalize($latestPendingRequests ?? $transactionRequests ?? $requests ?? []);
        $latestInternalTransfers = $normalize($latestInternalTransfers ?? []);
        $latestMessages = $normalize($latestMessages ?? $messages ?? []);

        $usersMetric = $usersCount ?? ($latestUsers->count() ?: 0);
        $transactionsMetric = $transactionsCount ?? ($latestTransactions->count() ?: 0);
        $pendingRequestsMetric = $pendingRequestsCount ?? ($pendingRequests->count() ?: 0);
        $messagesMetric = $messagesCount ?? ($latestMessages->count() ?: 0);
        $volumeMetric = $volumeTotal ?? $totalVolume ?? 0;

        $usersRoute = route('admin.users.index');
        $transactionsRoute = route('admin.transactions.index');
        $requestsRoute = route('admin.transactions-requests.index');
        $messagesRoute = route('admin.messages.index');
        $internalTransferRoute = route('admin.transactions-requests.internal-transfer');

        $latestRequest = $pendingRequests->first();
        $latestUser = $latestUsers->first();
        $latestMessage = $latestMessages->first();
        $latestTransaction = $latestTransactions->first();

        $normalizeRequestType = function ($type) {
            if ($type instanceof \App\Enums\TransactionRequestType) {
                return $type->value;
            }

            return is_numeric($type) ? (int) $type : (string) $type;
        };

        $requestTypeLabel = function ($type) use ($normalizeRequestType) {
            return match ($normalizeRequestType($type)) {
                'deposit', \App\Enums\TransactionRequestType::Deposit->value => 'إيداع',
                'withdrawal', \App\Enums\TransactionRequestType::Withdrawal->value => 'سحب',
                'internal', \App\Enums\TransactionRequestType::InternalTransfer->value => 'تحويل داخلي',
                'robot', \App\Enums\TransactionRequestType::Robot->value => 'روبوت',
                default => 'طلب',
            };
        };

        $requestToneClass = function ($type) use ($normalizeRequestType) {
            return match ($normalizeRequestType($type)) {
                'deposit', \App\Enums\TransactionRequestType::Deposit->value => 'is-profit',
                'withdrawal', \App\Enums\TransactionRequestType::Withdrawal->value => 'is-warning',
                'robot', \App\Enums\TransactionRequestType::Robot->value => 'is-info',
                default => 'is-neutral',
            };
        };

        $requestIcon = function ($type) use ($normalizeRequestType) {
            return match ($normalizeRequestType($type)) {
                'deposit', \App\Enums\TransactionRequestType::Deposit->value => 'fa-arrow-down',
                'withdrawal', \App\Enums\TransactionRequestType::Withdrawal->value => 'fa-arrow-up',
                'internal', \App\Enums\TransactionRequestType::InternalTransfer->value => 'fa-right-left',
                'robot', \App\Enums\TransactionRequestType::Robot->value => 'fa-robot',
                default => 'fa-bell',
            };
        };

        $statusLabel = function ($status) {
            if ($status instanceof \App\Enums\TransactionStatus) {
                return $status->getName();
            }

            if ($status instanceof \App\Enums\UserStatus) {
                return match ($status) {
                    \App\Enums\UserStatus::Active => 'نشط',
                    \App\Enums\UserStatus::Pending => 'قيد المراجعة',
                    \App\Enums\UserStatus::Inactive => 'معطل',
                };
            }

            return '—';
        };

        $statusToneClass = function ($status) {
            if ($status instanceof \App\Enums\TransactionStatus) {
                return match ($status) {
                    \App\Enums\TransactionStatus::Accepted => 'is-profit',
                    \App\Enums\TransactionStatus::Pending => 'is-warning',
                    \App\Enums\TransactionStatus::Rejected => 'is-danger',
                    \App\Enums\TransactionStatus::Canceled => 'is-neutral',
                };
            }

            if ($status instanceof \App\Enums\UserStatus) {
                return match ($status) {
                    \App\Enums\UserStatus::Active => 'is-profit',
                    \App\Enums\UserStatus::Pending => 'is-warning',
                    \App\Enums\UserStatus::Inactive => 'is-neutral',
                };
            }

            return 'is-neutral';
        };

        $displayUserName = fn ($user) => data_get($user, 'full_name') ?? data_get($user, 'name') ?? trim((data_get($user, 'first_name') ?? '') . ' ' . (data_get($user, 'last_name') ?? '')) ?: 'مستخدم';

        $alerts = collect();

        $alerts->push([
            'tone' => $pendingRequestsMetric > 0 ? 'warning' : 'success',
            'icon' => $pendingRequestsMetric > 0 ? 'fa-clock' : 'fa-circle-check',
            'title' => $pendingRequestsMetric > 0 ? 'توجد طلبات تحتاج مراجعة' : 'لا توجد طلبات معلقة',
            'body' => $pendingRequestsMetric > 0
                ? 'هناك ' . $formatNumber($pendingRequestsMetric) . ' طلب بانتظار الاعتماد من لوحة الإدارة.'
                : 'سير العمل المالي مستقر حالياً ولا توجد طلبات حرجة.',
            'time' => 'الآن',
        ]);

        if ($latestUser) {
            $alerts->push([
                'tone' => 'info',
                'icon' => 'fa-user-plus',
                'title' => 'آخر عميل منضم',
                'body' => (data_get($latestUser, 'name') ?? 'مستخدم جديد') . ' انضم مؤخراً إلى المنصة.',
                'time' => data_get($latestUser, 'created_at')?->diffForHumans() ?? 'حديثاً',
            ]);
        }

        if ($latestMessage) {
            $alerts->push([
                'tone' => 'warning',
                'icon' => 'fa-envelope-open-text',
                'title' => 'رسالة دعم جديدة',
                'body' => \Illuminate\Support\Str::limit(strip_tags((string) data_get($latestMessage, 'message', 'تم استلام رسالة دعم جديدة.')), 90),
                'time' => data_get($latestMessage, 'created_at')?->diffForHumans() ?? 'حديثاً',
            ]);
        }

        if ($latestTransaction) {
            $alerts->push([
                'tone' => 'success',
                'icon' => 'fa-wallet',
                'title' => 'آخر عملية مالية',
                'body' => 'بقيمة ' . $formatMoney(data_get($latestTransaction, 'amount')) . ' في سجل العمليات.',
                'time' => data_get($latestTransaction, 'created_at')?->diffForHumans() ?? 'حديثاً',
            ]);
        }
    @endphp

    <div class="lira-dashboard-page lira-admin-shell">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} ADMIN · CONTROL CENTER</span>
                <h1 class="lira-page-title">لوحة القيادة الإدارية</h1>
            </div>

            <div class="lira-hero-actions">
                <a href="{{ $requestsRoute }}" class="btn btn-primary px-4">
                    <i class="fa-solid fa-wallet ms-2"></i>
                    مراجعة الطلبات
                </a>
                <a href="{{ $usersRoute }}" class="btn btn-outline-primary px-4">
                    <i class="fa-solid fa-users ms-2"></i>
                    إدارة العملاء
                </a>
            </div>
        </div>

        <div class="lira-status-strip mb-4">
            <div class="lira-status-pill is-success">
                <span>حالة المنصة</span>
                <strong>تشغيل مستقر</strong>
            </div>
            <div class="lira-status-pill {{ $pendingRequestsMetric > 0 ? 'is-warning' : 'is-success' }}">
                <span>طلبات معلقة</span>
                <strong>{{ $formatNumber($pendingRequestsMetric) }}</strong>
            </div>
            <div class="lira-status-pill">
                <span>العملاء</span>
                <strong>{{ $formatNumber($usersMetric) }}</strong>
            </div>
            <div class="lira-status-pill">
                <span>الرسائل</span>
                <strong>{{ $formatNumber($messagesMetric) }}</strong>
            </div>
            <div class="lira-status-pill is-success">
                <span>الأمان</span>
                <strong>SSL + Firewall</strong>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">إجمالي المستخدمين</span>
                            <div class="lira-stat-icon"><i class="fa-solid fa-users"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ $formatNumber($usersMetric) }}</div>
                        <div class="lira-stat-meta">
                            <span>قاعدة العملاء الفعالة</span>
                            <span class="lira-positive-chip">إدارة مباشرة</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">الطلبات المعلقة</span>
                            <div class="lira-stat-icon is-warning-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ $formatNumber($pendingRequestsMetric) }}</div>
                        <div class="lira-stat-meta">
                            <span>{{ $pendingRequestsMetric > 0 ? 'تحتاج متابعة واعتماد' : 'لا يوجد ضغط تشغيلي' }}</span>
                            <span class="{{ $pendingRequestsMetric > 0 ? 'text-warning' : 'text-success' }}">{{ $pendingRequestsMetric > 0 ? 'مراجعة الآن' : 'مستقر' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">الحجم المالي</span>
                            <div class="lira-stat-icon is-success-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ $formatMoney($volumeMetric) }}</div>
                        <div class="lira-stat-meta">
                            <span>إجمالي التدفقات الحالية</span>
                            <span class="text-muted">{{ $formatNumber($transactionsMetric) }} عملية</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">رسائل الدعم</span>
                            <div class="lira-stat-icon is-info-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                        </div>
                        <div class="lira-stat-value">{{ $formatNumber($messagesMetric) }}</div>
                        <div class="lira-stat-meta">
                            <span>الطلبات والاستفسارات</span>
                            <span class="text-muted">متابعة يومية</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xxl-8">
                <div class="card lira-terminal-card lira-terminal-shell h-100">
                    <div class="card-header border-0 pb-0">
                        <div class="lira-terminal-topbar">
                            <div class="lira-terminal-left">
                                <div class="lira-terminal-symbol-group">
                                    <div class="lira-symbol-tabs lira-admin-tabs">
                                        <button type="button" class="lira-symbol-tab active" data-terminal-target="requests" data-terminal-title="مكتب مراجعة الطلبات" data-terminal-count="{{ $formatNumber($pendingRequestsMetric) }}">الطلبات</button>
                                        <button type="button" class="lira-symbol-tab" data-terminal-target="transactions" data-terminal-title="سجل العمليات المالية" data-terminal-count="{{ $formatNumber($transactionsMetric) }}">العمليات</button>
                                        <button type="button" class="lira-symbol-tab" data-terminal-target="users" data-terminal-title="متابعة المستخدمين" data-terminal-count="{{ $formatNumber($usersMetric) }}">المستخدمون</button>
                                    </div>

                                    <div class="lira-terminal-market-wrap">
                                        <span class="lira-terminal-market" data-terminal-current-title>مكتب مراجعة الطلبات</span>
                                        <strong class="lira-terminal-price" data-terminal-current-count>{{ $formatNumber($pendingRequestsMetric) }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-terminal-right">
                                <div class="lira-timeframe-group lira-admin-tabs">
                                    <button type="button" class="lira-timeframe-chip" data-terminal-target="support" data-terminal-title="متابعة الدعم" data-terminal-count="{{ $formatNumber($messagesMetric) }}">الدعم</button>
                                    <button type="button" class="lira-timeframe-chip" data-terminal-target="transfers" data-terminal-title="التحويلات الداخلية" data-terminal-count="{{ $formatNumber($latestInternalTransfers->count()) }}">التحويلات</button>
                                </div>
                            </div>
                        </div>

                        <div class="lira-terminal-stats lira-terminal-stats--four">
                            <div class="lira-terminal-stat">
                                <span>آخر طلب</span>
                                <strong>{{ $latestRequest ? $requestTypeLabel(data_get($latestRequest, 'type')) : '—' }}</strong>
                            </div>
                            <div class="lira-terminal-stat">
                                <span>آخر مستخدم</span>
                                <strong>{{ $latestUser ? $displayUserName($latestUser) : '—' }}</strong>
                            </div>
                            <div class="lira-terminal-stat">
                                <span>رسائل الدعم</span>
                                <strong>{{ $formatNumber($messagesMetric) }}</strong>
                            </div>
                            <div class="lira-terminal-stat">
                                <span>الحجم المالي</span>
                                <strong>{{ $formatMoney($volumeMetric) }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-3">
                        <div class="table-responsive lira-terminal-panel is-active" data-terminal-panel="requests">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">المستخدم</th>
                                        <th>نوع الطلب</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-center">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingRequests->take(8) as $request)
                                        @php $type = data_get($request, 'type') ?? 'deposit'; @endphp
                                        <tr>
                                            <td class="pe-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="lira-dash-avatar">
                                                        <i class="fa-solid fa-user-tag"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold d-block">{{ $displayUserName(data_get($request, 'user')) }}</span>
                                                        <span class="text-muted small">{{ data_get($request, 'user.email') ?? '—' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="lira-result-chip {{ $requestToneClass($type) }}">
                                                    <i class="fa-solid {{ $requestIcon($type) }} ms-1"></i>
                                                    {{ $requestTypeLabel($type) }}
                                                </span>
                                            </td>
                                            <td class="fw-bold" style="color: var(--lira-text);">{{ $formatMoney(data_get($request, 'amount')) }}</td>
                                            <td class="text-muted small">{{ data_get($request, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                            <td>
                                                <span class="lira-result-chip is-warning">قيد الانتظار</span>
                                            </td>
                                            <td class="ps-4 text-center">
                                                <a href="{{ $requestsRoute }}" class="lira-text-link">فتح</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="lira-empty-state">لا توجد طلبات معلقة حالياً.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive lira-terminal-panel" data-terminal-panel="transactions">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">العميل</th>
                                        <th>نوع العملية</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-center">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestTransactions->take(8) as $transaction)
                                        @php
                                            $walletUser = data_get($transaction, 'wallet.user');
                                            $transactionType = data_get($transaction, 'type');
                                            $transactionStatus = data_get($transaction, 'status');
                                        @endphp
                                        <tr>
                                            <td class="pe-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="lira-dash-avatar">
                                                        <i class="fa-solid fa-wallet"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold d-block">{{ $walletUser ? $displayUserName($walletUser) : 'عملية مالية' }}</span>
                                                        <span class="text-muted small">{{ data_get($walletUser, 'email') ?? '—' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="lira-result-chip is-info">
                                                    {{ $transactionType && method_exists($transactionType, 'getName') ? $transactionType->getName() : 'عملية' }}
                                                </span>
                                            </td>
                                            <td class="fw-bold" style="color: var(--lira-text);">{{ $formatMoney(data_get($transaction, 'amount')) }}</td>
                                            <td class="text-muted small">{{ data_get($transaction, 'transaction_date')?->diffForHumans() ?? data_get($transaction, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                            <td>
                                                <span class="lira-result-chip {{ $statusToneClass($transactionStatus) }}">{{ $statusLabel($transactionStatus) }}</span>
                                            </td>
                                            <td class="ps-4 text-center">
                                                <a href="{{ $transactionsRoute }}" class="lira-text-link">فتح</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="lira-empty-state">لا توجد عمليات مالية حديثة حالياً.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive lira-terminal-panel" data-terminal-panel="users">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">المستخدم</th>
                                        <th>البريد</th>
                                        <th>الخطة</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-center">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestUsers->take(8) as $userItem)
                                        @php $userStatus = data_get($userItem, 'status'); @endphp
                                        <tr>
                                            <td class="pe-4 fw-bold">{{ $displayUserName($userItem) }}</td>
                                            <td class="text-muted">{{ data_get($userItem, 'email') ?? '—' }}</td>
                                            <td>{{ data_get($userItem, 'plan.display_name') ?? 'بدون خطة' }}</td>
                                            <td class="text-muted small">{{ data_get($userItem, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                            <td>
                                                <span class="lira-result-chip {{ $statusToneClass($userStatus) }}">{{ $statusLabel($userStatus) }}</span>
                                            </td>
                                            <td class="ps-4 text-center">
                                                <a href="{{ $usersRoute }}" class="lira-text-link">فتح</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="lira-empty-state">لا يوجد مستخدمون جدد حالياً.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive lira-terminal-panel" data-terminal-panel="support">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">المرسل</th>
                                        <th>الرسالة</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-center">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestMessages->take(8) as $message)
                                        <tr>
                                            <td class="pe-4 fw-bold">{{ $displayUserName(data_get($message, 'sender')) }}</td>
                                            <td class="text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) (data_get($message, 'message') ?? data_get($message, 'content') ?? '—')), 76) }}</td>
                                            <td class="text-muted small">{{ data_get($message, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                            <td>
                                                <span class="lira-result-chip {{ data_get($message, 'is_read') ? 'is-profit' : 'is-warning' }}">
                                                    {{ data_get($message, 'is_read') ? 'مقروءة' : 'غير مقروءة' }}
                                                </span>
                                            </td>
                                            <td class="ps-4 text-center">
                                                <a href="{{ $messagesRoute }}" class="lira-text-link">فتح</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="lira-empty-state">لا توجد رسائل دعم حديثة حالياً.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive lira-terminal-panel" data-terminal-panel="transfers">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">المرسل</th>
                                        <th>المستلم</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th class="ps-4 text-center">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestInternalTransfers->take(8) as $transfer)
                                        @php $transferStatus = data_get($transfer, 'status'); @endphp
                                        <tr>
                                            <td class="pe-4 fw-bold">{{ $displayUserName(data_get($transfer, 'user')) }}</td>
                                            <td>{{ $displayUserName(data_get($transfer, 'receiver')) }}</td>
                                            <td class="fw-bold" style="color: var(--lira-text);">{{ $formatMoney(data_get($transfer, 'amount')) }}</td>
                                            <td class="text-muted small">{{ data_get($transfer, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                            <td>
                                                <span class="lira-result-chip {{ $statusToneClass($transferStatus) }}">{{ $statusLabel($transferStatus) }}</span>
                                            </td>
                                            <td class="ps-4 text-center">
                                                <a href="{{ $internalTransferRoute }}" class="lira-text-link">فتح</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="lira-empty-state">لا توجد تحويلات داخلية حديثة حالياً.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="d-flex flex-column gap-3 h-100">
                    <div class="card lira-side-card">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">مركز التحكم الإداري</h6>
                            <span class="lira-badge-chip">نشط</span>
                        </div>
                        <div class="card-body">
                            <div class="lira-account-summary-grid">
                                <div class="lira-summary-row">
                                    <span>إجمالي العمليات</span>
                                    <strong>{{ $formatNumber($transactionsMetric) }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>آخر طلب</span>
                                    <strong>{{ $latestRequest ? $requestTypeLabel(data_get($latestRequest, 'type')) : '—' }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>آخر عملية</span>
                                    <strong>{{ $formatMoney(data_get($latestTransaction, 'amount')) }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>آخر رسالة</span>
                                    <strong>{{ data_get($latestMessage, 'created_at')?->diffForHumans() ?? '—' }}</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>حالة الأمن</span>
                                    <strong class="text-success">مستقر</strong>
                                </div>
                                <div class="lira-summary-row">
                                    <span>متابعة الدعم</span>
                                    <strong>{{ $formatNumber($messagesMetric) }}</strong>
                                </div>
                            </div>

                            <div class="lira-plan-box mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">أولوية المتابعة الحالية</span>
                                    <strong class="ycolor">{{ min(100, max(12, $pendingRequestsMetric * 10)) }}%</strong>
                                </div>
                                <div class="progress lira-progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ min(100, max(12, $pendingRequestsMetric * 10)) }}%"></div>
                                </div>
                            </div>

                            <div class="lira-quick-actions mt-4">
                                <a href="{{ $requestsRoute }}" class="btn btn-primary">الطلبات</a>
                                <a href="{{ $usersRoute }}" class="btn btn-outline-primary">المستخدمون</a>
                                <a href="{{ $messagesRoute }}" class="btn lira-ghost-btn">الدعم</a>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card flex-grow-1">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">التنبيهات والوصول السريع</h6>
                            <span class="lira-badge-chip">{{ $alerts->count() }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="lira-alert-feed">
                                @foreach($alerts->take(4) as $alert)
                                    <div class="lira-alert-item is-{{ $alert['tone'] }}">
                                        <div class="lira-alert-icon">
                                            <i class="fa-solid {{ $alert['icon'] }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between gap-3">
                                                <strong>{{ $alert['title'] }}</strong>
                                                <span class="text-muted small">{{ $alert['time'] }}</span>
                                            </div>
                                            <p class="mb-0">{{ $alert['body'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row g-2 mt-3">
                                <div class="col-6">
                                    <a href="{{ $transactionsRoute }}" class="lira-dash-quick-btn">
                                        <i class="fa-solid fa-file-invoice-dollar ycolor mb-2"></i>
                                        <span class="small fw-bold">العمليات</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ $internalTransferRoute }}" class="lira-dash-quick-btn">
                                        <i class="fa-solid fa-right-left ycolor mb-2"></i>
                                        <span class="small fw-bold">تحويل داخلي</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-6">
                <div class="card lira-table-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">أحدث العملاء</h6>
                            <p class="text-muted mb-0 small">آخر الحسابات التي انضمت إلى المنصة.</p>
                        </div>
                        <a href="{{ $usersRoute }}" class="lira-text-link">عرض الكل</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">الاسم</th>
                                        <th>البريد</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestUsers->take(5) as $userItem)
                                        <tr>
                                            <td class="pe-4 fw-bold">{{ data_get($userItem, 'name') ?? 'مستخدم' }}</td>
                                            <td class="text-muted">{{ data_get($userItem, 'email') ?? '—' }}</td>
                                            <td class="text-muted small">{{ data_get($userItem, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"><div class="lira-empty-state">لا يوجد مستخدمون جدد حالياً.</div></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card lira-table-card h-100">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">أحدث رسائل الدعم</h6>
                            <p class="text-muted mb-0 small">متابعة سريعة لآخر الرسائل الواردة.</p>
                        </div>
                        <a href="{{ $messagesRoute }}" class="lira-text-link">عرض الكل</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table lira-clean-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pe-4">المرسل</th>
                                        <th>الرسالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestMessages->take(5) as $message)
                                        <tr>
                                            <td class="pe-4 fw-bold">{{ data_get($message, 'name') ?? data_get($message, 'user.name') ?? 'رسالة' }}</td>
                                            <td class="text-muted">{{ \Illuminate\Support\Str::limit(strip_tags((string) (data_get($message, 'message') ?? data_get($message, 'content') ?? '—')), 70) }}</td>
                                            <td class="text-muted small">{{ data_get($message, 'created_at')?->diffForHumans() ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"><div class="lira-empty-state">لا توجد رسائل جديدة حالياً.</div></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-admin-shell {
            --page-gap: 18px;
            padding-bottom: 10px;
        }

        .lira-hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .lira-inline-link {
            display: inline-flex;
            align-items: center;
            padding: 0 6px;
        }

        .lira-status-strip {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-status-pill {
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-status-pill span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            margin-bottom: 4px;
        }

        .lira-status-pill strong {
            font-size: 14px;
            color: #fff;
        }

        .lira-status-pill.is-success {
            border-color: rgba(23, 178, 106, 0.24);
            background: rgba(23, 178, 106, 0.08);
        }

        .lira-status-pill.is-warning {
            border-color: rgba(120, 97, 255, 0.24);
            background: rgba(120, 97, 255, 0.08);
        }

        .lira-stat-card,
        .lira-terminal-card,
        .lira-side-card,
        .lira-table-card {
            overflow: hidden;
        }

        .lira-stat-card {
            min-height: 170px;
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

        .lira-stat-icon.is-warning-icon {
            background: rgba(120, 97, 255, 0.09);
            color: #7861ff;
        }

        .lira-stat-icon.is-success-icon {
            background: rgba(23, 178, 106, 0.09);
            color: #17b26a;
        }

        .lira-stat-icon.is-info-icon {
            background: rgba(11, 165, 236, 0.09);
            color: #0ba5ec;
        }

        .lira-stat-value {
            font-size: clamp(1.45rem, 1.6vw, 2rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
            color: #fff !important;
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

        .lira-positive-chip {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(23, 178, 106, 0.12);
            color: #63ddab;
            font-weight: 700;
        }

        .lira-terminal-shell {
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.12), transparent 24%),
                radial-gradient(circle at top left, rgba(88, 132, 255, 0.10), transparent 18%),
                linear-gradient(180deg, rgba(14, 19, 31, 0.98), rgba(10, 14, 24, 0.98));
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.34);
        }

        .lira-terminal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .lira-terminal-left,
        .lira-terminal-right,
        .lira-terminal-symbol-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .lira-symbol-tabs,
        .lira-timeframe-group {
            display: inline-flex;
            gap: 8px;
            padding: 6px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-symbol-tab,
        .lira-timeframe-chip {
            min-width: 58px;
            height: 40px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: var(--lira-text-muted);
            font-weight: 800;
            transition: 0.22s ease;
            padding: 0 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .lira-symbol-tab:hover,
        .lira-timeframe-chip:hover {
            color: var(--lira-text);
            background: rgba(255, 255, 255, 0.04);
        }

        .lira-symbol-tab.active,
        .lira-timeframe-chip.active {
            background: rgba(0, 230, 167, 0.14);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.26);
        }

        .lira-terminal-market-wrap {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lira-terminal-market {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-terminal-price {
            font-size: clamp(1.8rem, 2.4vw, 2.8rem);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.04em;
            color: #fff;
        }

        .lira-terminal-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 8px;
        }

        .lira-terminal-panel {
            display: none;
        }

        .lira-terminal-panel.is-active {
            display: block;
        }

        .lira-terminal-stat {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-terminal-stat span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .lira-terminal-stat strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .lira-account-summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-summary-row {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 6px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
            min-height: 76px;
        }

        .lira-summary-row span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-summary-row strong {
            font-size: 14px;
            color: #fff;
            text-align: start;
            overflow-wrap: anywhere;
        }

        .lira-plan-box {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-progress {
            height: 10px;
        }

        .lira-quick-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-ghost-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
        }

        .lira-ghost-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--lira-text);
        }

        .lira-alert-feed {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-alert-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: rgba(255, 255, 255, 0.02);
        }

        .lira-alert-item strong {
            color: var(--lira-text);
            font-size: 14px;
        }

        .lira-alert-item p {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
            margin-top: 4px;
        }

        .lira-alert-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .lira-alert-item.is-success .lira-alert-icon {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-alert-item.is-warning .lira-alert-icon {
            background: rgba(120, 97, 255, 0.12);
            color: #c4b6ff;
        }

        .lira-alert-item.is-info .lira-alert-icon {
            background: rgba(11, 165, 236, 0.12);
            color: #66cfff;
        }

        .lira-clean-table thead th {
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-size: 12px !important;
        }

        .lira-clean-table tbody td {
            font-size: 13px;
        }

        .lira-result-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-result-chip.is-profit {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-result-chip.is-warning {
            background: rgba(120, 97, 255, 0.12);
            color: #c4b6ff;
        }

        .lira-result-chip.is-info {
            background: rgba(11, 165, 236, 0.12);
            color: #66cfff;
        }

        .lira-result-chip.is-neutral {
            background: rgba(255,255,255,0.08);
            color: #d7deee;
        }

        .lira-badge-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-empty-state {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            color: var(--lira-text-muted);
            text-align: center;
        }

        .lira-dash-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
            color: var(--lira-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex: 0 0 auto;
        }

        .lira-dash-quick-btn {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 16px;
            border-radius: 16px;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .lira-dash-quick-btn:hover {
            background: rgba(0, 230, 167, 0.05);
            border-color: rgba(0, 230, 167, 0.18);
            color: var(--lira-text);
            transform: translateY(-2px);
        }

        .lira-text-link {
            color: var(--lira-accent);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .lira-text-link:hover {
            color: var(--lira-accent);
        }

        @media (max-width: 1199.98px) {
            .lira-status-strip {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .lira-terminal-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .lira-status-strip,
            .lira-quick-actions {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .lira-terminal-stats,
            .lira-quick-actions {
                grid-template-columns: 1fr;
            }

            .lira-terminal-stats.lira-terminal-stats--four {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lira-hero-actions {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                width: 100%;
            }

            .lira-hero-actions .btn {
                width: 100%;
                min-height: 44px;
                padding-inline: 10px !important;
                font-size: 12px;
            }

            .lira-hero-actions .lira-inline-link {
                grid-column: 1 / -1;
                justify-content: flex-start;
                min-height: 34px;
            }

            .lira-status-strip {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-status-pill {
                padding: 10px 8px;
                border-radius: 14px;
                text-align: center;
            }

            .lira-status-pill span {
                font-size: 10px;
                line-height: 1.45;
            }

            .lira-status-pill strong {
                display: block;
                font-size: 12px;
                line-height: 1.45;
                overflow-wrap: anywhere;
            }

            .lira-terminal-topbar {
                align-items: stretch;
            }

            .lira-terminal-right,
            .lira-terminal-left,
            .lira-terminal-symbol-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tabs,
            .lira-timeframe-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                flex: 1 1 0;
            }

            .lira-terminal-price {
                font-size: 1.9rem;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const terminalCard = document.querySelector('.lira-terminal-card');

            if (!terminalCard) {
                return;
            }

            const controls = terminalCard.querySelectorAll('[data-terminal-target]');
            const panels = terminalCard.querySelectorAll('[data-terminal-panel]');
            const title = terminalCard.querySelector('[data-terminal-current-title]');
            const count = terminalCard.querySelector('[data-terminal-current-count]');

            controls.forEach((control) => {
                control.addEventListener('click', function () {
                    const target = control.dataset.terminalTarget;

                    controls.forEach((item) => item.classList.toggle('active', item === control));
                    panels.forEach((panel) => panel.classList.toggle('is-active', panel.dataset.terminalPanel === target));

                    if (title) {
                        title.textContent = control.dataset.terminalTitle || '';
                    }

                    if (count) {
                        count.textContent = control.dataset.terminalCount || '0';
                    }
                });
            });
        });
    </script>
@endpush
