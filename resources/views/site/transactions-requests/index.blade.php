@extends('layouts.site-dash')

@section('title', 'طلباتي')

@section('content')
    @php
        $user = auth()->user();

        $requestItems = method_exists($transactions, 'getCollection') ? $transactions->getCollection() : collect($transactions);
        $totalRequests = method_exists($transactions, 'total') ? $transactions->total() : $requestItems->count();
        $requestsWithImages = $requestItems->filter(fn($item) => !empty($item->image))->count();
    @endphp

    <div class="lira-requests-page">
        <div class="lira-requests-hero mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} ACCOUNT · REQUESTS TRACKING</span>
                <h1 class="lira-page-title">متابعة طلبات الحساب</h1>
                <p class="lira-page-subtitle">
                    راقب حالة طلبات الإيداع والسحب والتحويل، واطلع على بيانات كل طلب والمرفقات المرتبطة به.
                </p>
            </div>

            <div class="lira-hero-note">
                <i class="fa-solid fa-list-check"></i>
                <div>
                    <strong>حالة الطلبات بشكل مباشر</strong>
                    <span>يمكنك العودة لهذه الصفحة في أي وقت لمراجعة طلباتك السابقة والحالية.</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
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
                            <span>الأرباح المتاحة داخل الحساب</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">عدد الطلبات</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value">{{ $totalRequests }}</div>
                        <div class="lira-stat-meta">
                            <span>{{ $requestsWithImages }} طلب مرفق بصورة</span>
                            <span class="text-muted">{{ $requestItems->count() }} في الصفحة الحالية</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-9">
                <div class="card lira-table-card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6 class="mb-1">سجل الطلبات</h6>
                                <p class="text-muted mb-0 small">يشمل الإيداعات والسحوبات والتحويلات مع حالة كل طلب وتفاصيله.</p>
                            </div>

                            <span class="lira-badge-chip">{{ $totalRequests }} طلب</span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($requestItems->count())
                            <div class="table-responsive">
                                <table class="table lira-clean-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pe-4">رقم الطلب</th>
                                            <th>النوع</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>معلومات التحويل</th>
                                            <th>المرفق</th>
                                            <th>التاريخ</th>
                                            <th class="text-start ps-4">إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requestItems as $request)
                                            @php
                                                $typeName = $request->type->getName() ?? 'طلب مالي';
                                                $typeIcon = 'fa-money-bill-transfer';
                                                $typeClass = 'is-neutral';

                                                if (\Illuminate\Support\Str::contains($typeName, ['إيداع', 'Deposit'])) {
                                                    $typeIcon = 'fa-arrow-down';
                                                    $typeClass = 'is-profit';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['روبوت', 'Robot'])) {
                                                    $typeIcon = 'fa-robot';
                                                    $typeClass = 'is-neutral';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['سحب', 'Withdraw'])) {
                                                    $typeIcon = 'fa-arrow-up';
                                                    $typeClass = 'is-loss';
                                                } elseif (\Illuminate\Support\Str::contains($typeName, ['تحويل', 'Transfer'])) {
                                                    $typeIcon = 'fa-right-left';
                                                    $typeClass = 'is-neutral';
                                                }

                                                $transferData = $request->getFormattedTransferData() ?? '--';
                                                $imageUrl = !empty($request->image) ? $request->getStorageUrl($request->image) : null;
                                            @endphp

                                            <tr>
                                                <td class="pe-4">
                                                    <span class="lira-id-chip">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </td>

                                                <td>
                                                    <span class="lira-type-chip {{ $typeClass }}">
                                                        <i class="fa-solid {{ $typeIcon }}"></i>
                                                        {{ $typeName }}
                                                    </span>
                                                </td>

                                                <td class="fw-bold">{{ formatCurrency($request->amount) }}</td>

                                                <td>{!! renderStatusBadge($request->status) !!}</td>

                                                <td>
                                                    <div class="lira-transfer-cell">{!! nl2br(e($transferData)) !!}</div>
                                                </td>

                                                <td>
                                                    @if($imageUrl)
                                                        <a href="{{ $imageUrl }}" target="_blank" class="lira-image-preview">
                                                            <img src="{{ $imageUrl }}" alt="Payment proof">
                                                            <span>عرض</span>
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">لا يوجد</span>
                                                    @endif
                                                </td>

                                                <td class="text-muted">{{ $request->created_at?->format('Y/m/d') }}</td>

                                                <td class="text-start ps-4">
                                                    <form action="{{ route('site.transactions-requests.destroy', $request->id) }}" method="POST" class="m-0"
                                                        data-niro-confirm="true"
                                                        data-niro-confirm-message="هل أنت متأكد من حذف هذا الطلب؟"
                                                        data-niro-confirm-title="تأكيد الحذف"
                                                        data-niro-confirm-type="warning"
                                                        data-niro-confirm-button="نعم، احذف"
                                                        data-niro-cancel-button="إلغاء">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm lira-delete-btn">
                                                            <i class="fa-solid fa-trash-can ms-1"></i>
                                                            حذف
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(method_exists($transactions, 'links'))
                                <div class="lira-table-footer">
                                    {{ $transactions->links() }}
                                </div>
                            @endif
                        @else
                            <div class="lira-empty-block">
                                <i class="fa-solid fa-inbox"></i>
                                <h5>لا توجد طلبات حتى الآن</h5>
                                <p class="mb-3">عند إرسال أول طلب إيداع أو سحب أو تحويل، سيظهر هنا مع حالته وتفاصيله.</p>
                                <a href="{{ route('site.funding') }}" class="btn btn-primary">بدء طلب إيداع</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">إجراءات سريعة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-quick-actions">
                                <a href="{{ route('site.funding') }}" class="btn btn-primary">إيداع جديد</a>
                                <a href="{{ route('site.transactions.index') }}" class="btn btn-outline-primary">المعاملات المالية</a>
                                <a href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}" class="btn lira-ghost-btn">طلب سحب</a>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملاحظات مهمة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>احرص على أن تكون بيانات التحويل وصورة الإثبات واضحة ومطابقة للطلب.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>يمكن حذف بعض الطلبات من هنا بحسب قواعد النظام قبل اعتمادها النهائي.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>تنعكس حالة الطلب على الرصيد بعد مراجعته واعتماده من الإدارة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>عند الحاجة للدعم، احتفظ برقم الطلب لتسريع المتابعة.</span>
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
        .lira-requests-hero {
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

        .lira-transfer-cell {
            max-width: 220px;
            color: var(--lira-text-soft);
            line-height: 1.8;
            font-size: 12px;
            white-space: normal;
        }

        .lira-image-preview {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--lira-text-soft);
        }

        .lira-image-preview img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-image-preview span {
            font-size: 12px;
            color: var(--lira-accent);
            font-weight: 700;
        }

        .lira-delete-btn {
            border: 1px solid rgba(240, 68, 56, 0.22) !important;
            background: rgba(240, 68, 56, 0.08) !important;
            color: #ff8a80 !important;
            border-radius: 12px !important;
            font-weight: 700;
        }

        .lira-delete-btn:hover {
            background: rgba(240, 68, 56, 0.14) !important;
            color: #ff8a80 !important;
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
    </style>
@endpush

