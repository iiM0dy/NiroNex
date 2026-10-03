@extends('layouts.site-dash')

@section('title', 'إحالاتي')

@section('content')
    @php
        $totalReferrals = method_exists($referrals, 'total') ? $referrals->total() : collect($referrals)->count();
        $referralItems = method_exists($referrals, 'getCollection') ? $referrals->getCollection() : collect($referrals);
        $refPercent = (float) env('REFER_PERCENT') * 100;
    @endphp

    <div class="lira-referrals-page">
        <div class="lira-referrals-hero mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} GROWTH · REFERRAL NETWORK</span>
                <h1 class="lira-page-title">برنامج الإحالات</h1>
                <p class="lira-page-subtitle">
                    شارك رابطك الخاص، ادعُ مستخدمين جدد إلى {{ appName() }}، وتابع عدد الإحالات والعوائد الناتجة عنها بشكل واضح.
                </p>
            </div>

            <div class="lira-hero-note">
                <i class="fa-solid fa-users"></i>
                <div>
                    <strong>رابط إحالة مباشر</strong>
                    <span>يمكنك نسخ الرابط ومشاركته فورًا عبر أي قناة مناسبة.</span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-6">
                <div class="card lira-ref-card h-100">
                    <div class="card-header border-0">
                        <div>
                            <h6 class="mb-1">رابط الإحالة</h6>
                            <p class="text-muted mb-0 small">هذا هو الرابط المباشر المرتبط بحسابك.</p>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="lira-ref-link-box">
                            <input
                                type="text"
                                id="refLink"
                                class="form-control"
                                value="{{ $referralLink }}"
                                readonly
                                dir="ltr"
                            >
                            <button type="button" class="btn btn-primary" id="copyReferralBtn" onclick="copyReferral()">
                                نسخ
                            </button>
                        </div>

                        <div class="lira-link-meta mt-3">
                            <span class="lira-badge-chip is-accent">
                                <i class="fa-solid fa-link ms-1"></i>
                                رابط نشط
                            </span>
                            <small class="text-muted">شارك الرابط وابدأ بتوسيع شبكة إحالاتك.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">عدد الإحالات</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value">{{ $totalReferrals }}</div>
                        <div class="lira-stat-meta">
                            <span>إجمالي المستخدمين المنضمين عبر رابطك</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">مجموع الأرباح</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value text-success">{{ formatCurrency($totalCommission) }}</div>
                        <div class="lira-stat-meta">
                            <span>العوائد المسجلة من شبكة الإحالة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card lira-highlight-card mb-4">
            <div class="card-body">
                <div class="lira-highlight-wrap">
                    <div class="lira-highlight-icon">
                        <i class="fa-solid fa-gift"></i>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="mb-1">كيف تعمل مكافأة الإحالة؟</h5>
                        <p class="mb-0">
                            تحصل على
                            <strong class="ycolor">{{ $refPercent }}%</strong>
                            من أرباح كل مستخدم جديد ينضم إلى {{ appName() }} عبر رابطك الخاص، وفق سياسة برنامج الإحالة المعتمدة.
                        </p>
                    </div>

                    <span class="lira-badge-chip is-accent">Referral Active</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-9">
                <div class="card lira-table-card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6 class="mb-1">قائمة الإحالات</h6>
                                <p class="text-muted mb-0 small">عرض لجميع الحسابات المسجلة من خلال رابطك.</p>
                            </div>

                            <span class="lira-badge-chip">{{ $totalReferrals }} إحالة</span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($referralItems->count())
                            <div class="table-responsive">
                                <table class="table lira-clean-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pe-4">#</th>
                                            <th>الاسم الكامل</th>
                                            <th>البريد الإلكتروني</th>
                                            <th class="ps-4 text-start">تاريخ التسجيل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($referralItems as $index => $ref)
                                            <tr>
                                                <td class="pe-4">
                                                    <span class="lira-id-chip">#{{ $loop->iteration }}</span>
                                                </td>

                                                <td class="fw-bold">{{ $ref->full_name }}</td>

                                                <td>
                                                    <span class="lira-email-chip">{{ $ref->email }}</span>
                                                </td>

                                                <td class="ps-4 text-start text-muted">
                                                    {{ formatDate($ref->created_at) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(method_exists($referrals, 'links'))
                                <div class="lira-table-footer">
                                    {{ $referrals->links() }}
                                </div>
                            @endif
                        @else
                            <div class="lira-empty-block">
                                <i class="fa-solid fa-users-viewfinder"></i>
                                <h5>لا توجد إحالات حتى الآن</h5>
                                <p class="mb-3">بمجرد انضمام أول مستخدم عبر رابطك الخاص، سيظهر هنا ضمن قائمتك.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملخص البرنامج</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-summary-block mb-3">
                                <span>نسبة المكافأة</span>
                                <strong>{{ $refPercent }}%</strong>
                            </div>

                            <div class="lira-summary-block mb-0">
                                <span>الحالة</span>
                                <strong>نشط</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">نصائح سريعة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>شارك رابطك مع مستخدمين مهتمين فعليًا بالمنصة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>احرص على توضيح فكرة {{ appName() }} بشكل مختصر وواضح عند الدعوة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>تابع نمو قائمتك هنا لمعرفة أثر الشبكة التي تبنيها.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>العوائد تظهر بحسب سياسة النظام وآلية احتساب العمولة.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ربط سريع</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('site.dashboard') }}" class="btn btn-outline-primary w-100 mb-2">العودة للوحة التحكم</a>
                            <a href="{{ route('site.deposit') }}" class="btn lira-ghost-btn w-100">تفعيل باقة جديدة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyReferral() {
            const input = document.getElementById('refLink');
            const button = document.getElementById('copyReferralBtn');
            if (!input || !button) return;

            navigator.clipboard.writeText(input.value).then(() => {
                const original = button.innerHTML;
                button.innerHTML = 'تم النسخ';
                setTimeout(() => {
                    button.innerHTML = original;
                }, 1600);
            });
        }
    </script>
@endsection

@push('custom_styles')
    <style>
        .lira-referrals-hero {
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

        .lira-ref-card,
        .lira-highlight-card,
        .lira-table-card,
        .lira-side-card {
            overflow: hidden;
        }

        .lira-ref-link-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lira-ref-link-box .form-control {
            height: 52px;
            text-align: left;
            font-family: monospace;
        }

        .lira-link-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
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

        .lira-badge-chip.is-accent {
            background: rgba(0, 230, 167, 0.12);
            border-color: rgba(0, 230, 167, 0.24);
            color: var(--lira-accent);
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

        .lira-highlight-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .lira-highlight-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            font-size: 22px;
            flex: 0 0 auto;
        }

        .lira-highlight-wrap p {
            color: var(--lira-text-soft);
            line-height: 1.9;
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

        .lira-email-chip {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--lira-text-soft);
            font-size: 12px;
            direction: ltr;
        }

        .lira-table-footer {
            padding: 18px 20px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
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

        .lira-empty-block {
            min-height: 300px;
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

        @media (max-width: 767.98px) {
            .lira-ref-link-box {
                flex-direction: column;
                align-items: stretch;
            }

            .lira-highlight-wrap {
                align-items: flex-start;
            }
        }
    </style>
@endpush

