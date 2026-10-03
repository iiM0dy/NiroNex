@extends('layouts.admin')
@section('title', 'تفاصيل العميل')

@section('content')
    @php
        $robotSettings = $user->robotSettings;
        $requestStats = [
            'deposit' => $user->requests->where('type', \App\Enums\TransactionRequestType::Deposit)->count(),
            'withdrawal' => $user->requests->where('type', \App\Enums\TransactionRequestType::Withdrawal)->count(),
            'internal' => $user->requests->where('type', \App\Enums\TransactionRequestType::InternalTransfer)->count(),
            'robot' => $user->requests->where('type', \App\Enums\TransactionRequestType::Robot)->count(),
        ];
        $kycDocsCount = collect([$user->id_photo_front, $user->id_photo_back, $user->selfie_photo])->filter()->count();
        $kycState = match ($user->status) {
            \App\Enums\UserStatus::Active => ['label' => 'موثق', 'class' => 'is-success'],
            \App\Enums\UserStatus::Inactive => ['label' => 'مرفوض / معطل', 'class' => 'is-danger'],
            default => ['label' => 'قيد المراجعة', 'class' => 'is-warning'],
        };
        $referralTotal = $user->referralEarnings->sum('amount');
    @endphp

    <div class="lira-admin-user-show-page">
        <section class="lira-admin-user-show-hero mb-4">
            <div>
                <span class="lira-admin-user-show-kicker">CLIENT PROFILE</span>
                <h2 class="lira-admin-user-show-title">تفاصيل الملف الشخصي</h2>
                <p class="lira-admin-user-show-subtitle">
                    مراجعة بيانات العميل، حالة التحقق، أرصدة المحافظ، وسجل الطلبات والمعاملات.
                </p>
            </div>

            <div class="lira-admin-user-show-actions">
                <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" class="d-flex align-items-center gap-2 lira-admin-status-form">
                    @csrf
                    <label class="lira-admin-status-label mb-0">حالة الحساب:</label>
                    <div class="lira-admin-status-select-wrap">
                        <i class="fa-solid fa-user-gear lira-select-icon"></i>
                        <select name="status" class="form-select lira-admin-user-status-select" onchange="this.form.submit()">
                            @foreach (\App\Enums\UserStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ $user->status === $status ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <a href="{{ route('admin.messages.chat', $user) }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-comment-dots me-1 ms-1"></i>
                    محادثة
                </a>

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-sliders me-1 ms-1"></i>
                        الإجراءات
                    </button>
                    <ul class="dropdown-menu lira-admin-action-dropdown">
                        <li>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editWalletModal">
                                <i class="fa-solid fa-wallet"></i>
                                تعديل رصيد الإيداع
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                                <i class="fa-solid fa-plus-circle"></i>
                                إضافة أرباح
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                data-niro-confirm="true"
                                data-niro-confirm-message="هل أنت متأكد من حذف هذا الحساب؟"
                                data-niro-confirm-title="تأكيد الحذف"
                                data-niro-confirm-type="warning"
                                data-niro-confirm-button="نعم، احذف"
                                data-niro-cancel-button="إلغاء">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger">
                                    <i class="fa-solid fa-trash"></i>
                                    حذف الحساب
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="card border-0 mb-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <div class="row g-4 align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="lira-admin-user-profile-side">
                            <div class="lira-admin-user-avatar-wrap">
                                <div class="lira-admin-user-avatar">
                                    <img src="{{ asset($user->getStorageUrl($user->image) ?? backendAssets('dist/assets/images/profile_av.svg')) }}"
                                        alt="User Avatar">
                                </div>
                            </div>

                            <h4 class="fw-bold text-white mb-1">{{ $user->full_name }}</h4>
                            <p class="text-muted small mb-3">{{ $user->email }}</p>

                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <span class="lira-admin-user-chip is-accent">
                                    <i class="fa-solid fa-gem"></i>
                                    {{ $user->plan->display_name ?? 'بدون خطة' }}
                                </span>

                                @if ($user->hasVerifiedEmail())
                                    <span class="lira-admin-user-chip is-success">
                                        <i class="fa-solid fa-badge-check"></i>
                                        البريد موثق
                                    </span>
                                @else
                                    <span class="lira-admin-user-chip is-warning">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                        البريد غير موثق
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="lira-admin-info-box">
                                    <span class="lira-admin-info-label">الاسم بالكامل</span>
                                    <div class="lira-admin-info-value">{{ $user->full_name }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="lira-admin-info-box">
                                    <span class="lira-admin-info-label">البريد الإلكتروني</span>
                                    <div class="lira-admin-info-value">{{ $user->email }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="lira-admin-info-box">
                                    <span class="lira-admin-info-label">رقم الهاتف</span>
                                    <div class="lira-admin-info-value" style="direction:ltr; text-align:right;">
                                        {{ $user->phone }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="lira-admin-info-box">
                                    <span class="lira-admin-info-label">الخطة الحالية</span>
                                    <div class="lira-admin-info-value ycolor">
                                        {{ $user->plan->display_name ?? 'بدون خطة' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lira-admin-info-box">
                                    <span class="lira-admin-info-label">عنوان المحفظة الافتراضي</span>
                                    <div class="lira-admin-info-value">
                                        {{ $user->withdrawal_address ?: 'غير محدد' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="lira-admin-balance-card is-accent">
                    <div class="lira-admin-balance-icon">
                        <i class="fa-solid fa-vault"></i>
                    </div>
                    <span class="lira-admin-balance-label">الرصيد الكلي</span>
                    <strong class="lira-admin-balance-value">{{ formatCurrency($user->balance) }}</strong>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="lira-admin-balance-card is-info">
                    <div class="lira-admin-balance-icon">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                    <span class="lira-admin-balance-label">رصيد الإيداع</span>
                    <strong class="lira-admin-balance-value">{{ formatCurrency($user->deposit_balance) }}</strong>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="lira-admin-balance-card is-success">
                    <div class="lira-admin-balance-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <span class="lira-admin-balance-label">رصيد الأرباح</span>
                    <strong class="lira-admin-balance-value">{{ formatCurrency($user->profit_balance) }}</strong>
                </div>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-xl-4">
                <div class="lira-admin-detail-card h-100">
                    <div class="lira-admin-detail-card-head">
                        <div class="lira-admin-detail-icon is-accent"><i class="fa-solid fa-id-card"></i></div>
                        <div>
                            <h5>حالة التحقق KYC</h5>
                            <p>وثائق الهوية وحالة الموافقة</p>
                        </div>
                    </div>

                    <div class="lira-admin-detail-list">
                        <span><strong>الحالة</strong><em class="lira-inline-status {{ $kycState['class'] }}">{{ $kycState['label'] }}</em></span>
                        <span><strong>نوع الهوية</strong>{{ $user->id_photo_type ?: 'غير محدد' }}</span>
                        <span><strong>الوثائق المرفوعة</strong>{{ $kycDocsCount }}/3</span>
                        <span><strong>البريد الإلكتروني</strong>{{ $user->hasVerifiedEmail() ? 'موثق' : 'غير موثق' }}</span>
                    </div>

                    <div class="lira-admin-detail-actions">
                        <a href="{{ route('admin.verification-kyc.index', ['search' => $user->email, 'status' => 'all']) }}" class="btn btn-outline-primary">فتح في KYC</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="lira-admin-detail-card h-100">
                    <div class="lira-admin-detail-card-head">
                        <div class="lira-admin-detail-icon is-info"><i class="fa-solid fa-wallet"></i></div>
                        <div>
                            <h5>الأرصدة والمحافظ</h5>
                            <p>ملخص الرصيد المستخدم في المنصة</p>
                        </div>
                    </div>

                    <div class="lira-admin-detail-list">
                        <span><strong>رصيد التداول</strong>{{ formatCurrency($user->trading_balance ?? 0) }}</span>
                        <span><strong>رصيد الديمو</strong>{{ formatCurrency($user->demo_trading_balance ?? 0) }}</span>
                        <span><strong>مبلغ الخطة</strong>{{ formatCurrency($user->plan_amount ?? 0) }}</span>
                        <span><strong>محافظ النظام</strong>{{ $user->wallets->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="lira-admin-detail-card h-100">
                    <div class="lira-admin-detail-card-head">
                        <div class="lira-admin-detail-icon is-success"><i class="fa-solid fa-robot"></i></div>
                        <div>
                            <h5>إعدادات الروبوت</h5>
                            <p>آخر إعدادات تخصيص الروبوت</p>
                        </div>
                    </div>

                    <div class="lira-admin-detail-list">
                        <span><strong>الحالة</strong>{{ $robotSettings?->status_label ?? 'لا توجد إعدادات' }}</span>
                        <span><strong>التفعيل</strong>{{ $robotSettings?->is_active ? 'نشط' : 'غير نشط' }}</span>
                        <span><strong>المخاطرة</strong>{{ $robotSettings?->risk_label ?? '—' }}</span>
                        <span><strong>التخصيص</strong>{{ $robotSettings ? formatCurrency($robotSettings->allocation_amount) : '—' }}</span>
                        <span><strong>TP / SL</strong>{{ $robotSettings ? formatPercent($robotSettings->take_profit) . ' / ' . formatPercent($robotSettings->stop_loss) : '—' }}</span>
                    </div>

                    <div class="lira-admin-detail-actions">
                        <a href="{{ route('admin.robot-requests.index', ['search' => $user->email, 'status' => 'all']) }}" class="btn btn-outline-primary">طلبات الروبوت</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="lira-admin-detail-card h-100">
                    <div class="lira-admin-detail-card-head">
                        <div class="lira-admin-detail-icon is-warning"><i class="fa-solid fa-file-invoice"></i></div>
                        <div>
                            <h5>طلبات العميل حسب النوع</h5>
                            <p>إيداع، سحب، تحويل داخلي، وروبوت</p>
                        </div>
                    </div>

                    <div class="lira-admin-request-breakdown">
                        <span><strong>{{ number_format($requestStats['deposit']) }}</strong>إيداع</span>
                        <span><strong>{{ number_format($requestStats['withdrawal']) }}</strong>سحب</span>
                        <span><strong>{{ number_format($requestStats['internal']) }}</strong>تحويل داخلي</span>
                        <span><strong>{{ number_format($requestStats['robot']) }}</strong>روبوت</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="lira-admin-detail-card h-100">
                    <div class="lira-admin-detail-card-head">
                        <div class="lira-admin-detail-icon is-danger"><i class="fa-solid fa-share-nodes"></i></div>
                        <div>
                            <h5>الإحالات</h5>
                            <p>بيانات الرابط والأرباح الناتجة</p>
                        </div>
                    </div>

                    <div class="lira-admin-detail-list">
                        <span><strong>المُحيل</strong>{{ $user->referrer?->full_name ?? 'لا يوجد' }}</span>
                        <span><strong>عدد الإحالات</strong>{{ number_format($user->referrals->count()) }}</span>
                        <span><strong>أرباح الإحالة</strong>{{ formatCurrency($referralTotal) }}</span>
                        <span><strong>رابط الإحالة</strong><small dir="ltr">{{ $user->referral_link }}</small></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="card border-0 mb-4 overflow-hidden">
            <div class="card-header lira-admin-section-header">
                <div>
                    <h5 class="mb-1">وثائق التحقق من الهوية</h5>
                    <p class="mb-0 text-muted small">مراجعة الصور المرفوعة الخاصة بالهوية والسيلفي</p>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="lira-admin-doc-card">
                            <span class="lira-admin-doc-title">الصورة الأمامية</span>
                            @if ($user->id_photo_front)
                                <a href="{{ $user->getStorageUrl($user->id_photo_front) }}" target="_blank" class="lira-admin-doc-preview">
                                    <img src="{{ $user->getStorageUrl($user->id_photo_front) }}" alt="Front ID">
                                </a>
                            @else
                                <div class="lira-admin-doc-empty">
                                    <i class="fa-solid fa-image"></i>
                                    <span>غير متوفر</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="lira-admin-doc-card">
                            <span class="lira-admin-doc-title">الصورة الخلفية</span>
                            @if ($user->id_photo_back)
                                <a href="{{ $user->getStorageUrl($user->id_photo_back) }}" target="_blank" class="lira-admin-doc-preview">
                                    <img src="{{ $user->getStorageUrl($user->id_photo_back) }}" alt="Back ID">
                                </a>
                            @else
                                <div class="lira-admin-doc-empty">
                                    <i class="fa-solid fa-image"></i>
                                    <span>غير متوفر</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="lira-admin-doc-card">
                            <span class="lira-admin-doc-title">صورة السيلفي</span>
                            @if ($user->selfie_photo)
                                <a href="{{ $user->getStorageUrl($user->selfie_photo) }}" target="_blank" class="lira-admin-doc-preview">
                                    <img src="{{ $user->getStorageUrl($user->selfie_photo) }}" alt="Selfie">
                                </a>
                            @else
                                <div class="lira-admin-doc-empty">
                                    <i class="fa-solid fa-image"></i>
                                    <span>غير متوفر</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mb-4">
            <x-table title="طلبات العميل" :columns="[
                'display_id' => 'ID الطلب',
                'type' => 'النوع',
                'method' => 'الطريقة',
                'receiver' => 'المستلم',
                'amount' => 'المبلغ',
                'status' => 'الحالة',
                'image' => 'صورة مرفقة',
                'created_at' => 'تاريخ الطلب',
            ]" :rows="$requests->toArray()" :isSearchable="false" :actions="[
                ['type' => 'approve', 'route' => 'admin.transactions-requests.approve', 'key' => 'id'],
                ['type' => 'reject', 'route' => 'admin.transactions-requests.reject', 'key' => 'id'],
            ]" />
        </div>

        <div class="mb-4">
            <x-table title="المعاملات المالية" :columns="[
                'display_id' => 'ID المعاملة',
                'type' => 'النوع',
                'amount' => 'المبلغ',
                'status' => 'الحالة',
                'date' => 'التاريخ',
                'description' => 'الوصف',
            ]" :rows="$transactions->toArray()" :isSearchable="false" :actions="[
                [
                    'type' => 'edit-amount',
                    'route' => 'admin.transactions.update',
                    'key' => 'id',
                ],
            ]" />
        </div>
    </div>

    <div class="modal fade" id="editWalletModal" tabindex="-1" aria-labelledby="editWalletModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.update-wallet', $user->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editWalletModalLabel">تعديل رصيد محفظة الإيداع</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-0">
                            <label for="wallet-value" class="form-label">الرصيد الجديد</label>
                            <input type="number" name="value" class="form-control" id="wallet-value" min="0" required>
                            @error('value')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.transactions.store') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransactionModalLabel">إضافة أرباح</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body">
                        @php
                            use App\Enums\TransactionType;
                        @endphp

                        <div class="mb-3">
                            <label for="type" class="form-label">نوع الربح</label>
                            <select name="type" class="form-select" id="type">
                                <option value="{{ TransactionType::Profit->value }}">{{ TransactionType::Profit->getName() }}</option>
                                <option value="{{ TransactionType::ProfitRefer->value }}">{{ TransactionType::ProfitRefer->getName() }}</option>
                            </select>
                            @error('type')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">القيمة</label>
                            <input type="number" step="any" placeholder="0.064" name="amount" class="form-control" id="amount" min="0" required>
                            @error('amount')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="date" class="form-label">التاريخ</label>
                            <input type="date" name="transaction_date" class="form-control" id="date" required>
                            @error('transaction_date')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-admin-user-show-page {
            padding-bottom: 10px;
        }

        .lira-admin-user-show-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .lira-admin-user-show-kicker {
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

        .lira-admin-user-show-title {
            margin: 0 0 10px;
            font-size: clamp(1.5rem, 2.2vw, 2rem);
            color: var(--lira-text);
        }

        .lira-admin-user-show-subtitle {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 760px;
        }

        .lira-admin-user-show-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-admin-status-form {
            background: rgba(255, 255, 255, 0.02);
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-admin-status-label {
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .lira-admin-status-select-wrap {
            position: relative;
            min-width: 160px;
        }

        .lira-select-icon {
            position: absolute;
            top: 50%;
            inset-inline-start: 12px;
            transform: translateY(-50%);
            color: var(--lira-accent);
            font-size: 13px;
            pointer-events: none;
            z-index: 2;
        }

        .lira-admin-user-status-select,
        .lira-admin-user-status-select:focus {
            height: 42px !important;
            padding-inline-start: 36px !important;
            padding-inline-end: 28px !important;
            background-color: #141a23 !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23d4af37' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: left 12px center !important;
            border: 1px solid rgba(0, 230, 167, 0.3) !important;
            color: var(--lira-text-soft) !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            border-radius: 14px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }

        .lira-admin-user-status-select:focus {
            border-color: var(--lira-accent) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.08) !important;
        }

        .lira-admin-user-status-select:hover {
            border-color: var(--lira-accent) !important;
            box-shadow: 0 4px 12px rgba(0, 230, 167, 0.12) !important;
            transform: translateY(-1px);
        }

        .lira-admin-user-status-select option {
            background-color: #141a23 !important;
            color: #f7f8fa !important;
            padding: 10px !important;
        }

        .lira-admin-profile-side {
            text-align: center;
        }

        .lira-admin-user-profile-side {
            text-align: center;
        }

        .lira-admin-user-avatar-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .lira-admin-user-avatar {
            width: 132px;
            height: 132px;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(0, 230, 167, 0.18);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.22);
        }

        .lira-admin-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .lira-admin-user-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid transparent;
        }

        .lira-admin-user-chip.is-accent {
            background: rgba(0, 230, 167, 0.10);
            border-color: rgba(0, 230, 167, 0.18);
            color: var(--lira-accent);
        }

        .lira-admin-user-chip.is-success {
            background: rgba(23, 178, 106, 0.10);
            border-color: rgba(23, 178, 106, 0.18);
            color: #63ddab;
        }

        .lira-admin-user-chip.is-warning {
            background: rgba(120, 97, 255, 0.10);
            border-color: rgba(120, 97, 255, 0.18);
            color: #c4b6ff;
        }

        .lira-admin-info-box {
            min-height: 100%;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-admin-info-label {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .lira-admin-info-value {
            color: var(--lira-text);
            font-size: 14px;
            font-weight: 700;
            line-height: 1.9;
            word-break: break-word;
        }

        .lira-admin-balance-card {
            height: 100%;
            min-height: 150px;
            padding: 20px;
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)),
                var(--lira-surface-2);
            border: 1px solid var(--lira-border);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .lira-admin-balance-card.is-accent { border-top: 2px solid var(--lira-accent); }
        .lira-admin-balance-card.is-info { border-top: 2px solid var(--lira-info); }
        .lira-admin-balance-card.is-success { border-top: 2px solid var(--lira-success); }

        .lira-admin-balance-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 20px;
        }

        .lira-admin-balance-card.is-accent .lira-admin-balance-icon {
            color: var(--lira-accent);
            background: rgba(0, 230, 167, 0.10);
        }

        .lira-admin-balance-card.is-info .lira-admin-balance-icon {
            color: var(--lira-info);
            background: rgba(54, 191, 250, 0.10);
        }

        .lira-admin-balance-card.is-success .lira-admin-balance-icon {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-admin-balance-label {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lira-admin-balance-value {
            display: block;
            color: var(--lira-text);
            font-size: 1.65rem;
            line-height: 1.2;
            font-weight: 800;
        }

        .lira-admin-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 22px 0 !important;
        }

        .lira-admin-doc-card {
            height: 100%;
            padding: 16px;
            border-radius: 22px;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-admin-doc-title {
            display: block;
            color: var(--lira-text-soft);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .lira-admin-doc-preview {
            display: block;
            height: 170px;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.06);
            background: rgba(255,255,255,0.03);
        }

        .lira-admin-doc-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lira-admin-doc-empty {
            height: 170px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--lira-text-muted);
            background: rgba(255,255,255,0.02);
            border: 1px dashed rgba(255,255,255,0.08);
        }

        .lira-admin-doc-empty i {
            font-size: 26px;
            opacity: 0.5;
        }

        .lira-admin-detail-card {
            padding: 20px;
            border-radius: 24px;
            border: 1px solid var(--lira-border);
            background: linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)), var(--lira-surface-2);
        }

        .lira-admin-detail-card-head {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 16px;
        }

        .lira-admin-detail-card-head h5 {
            margin: 0 0 4px;
            font-size: 1rem;
        }

        .lira-admin-detail-card-head p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .lira-admin-detail-icon {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            background: rgba(255,255,255,0.04);
        }

        .lira-admin-detail-icon.is-accent { color: var(--lira-accent); background: rgba(0, 230, 167, 0.1); }
        .lira-admin-detail-icon.is-info { color: var(--lira-info); background: rgba(11, 165, 236, 0.1); }
        .lira-admin-detail-icon.is-success { color: var(--lira-success); background: rgba(23, 178, 106, 0.1); }
        .lira-admin-detail-icon.is-warning { color: var(--lira-warning); background: rgba(120, 97, 255, 0.1); }
        .lira-admin-detail-icon.is-danger { color: var(--lira-danger); background: rgba(240, 68, 56, 0.1); }

        .lira-admin-detail-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-admin-detail-list span,
        .lira-admin-request-breakdown span {
            padding: 10px 12px;
            border-radius: 14px;
            background: rgba(255,255,255,0.025);
            color: var(--lira-text-soft);
            font-size: 12px;
            line-height: 1.65;
            word-break: break-word;
        }

        .lira-admin-detail-list strong {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text-muted);
            font-size: 10px;
        }

        .lira-inline-status {
            display: inline-flex;
            min-height: 26px;
            align-items: center;
            padding: 0 9px;
            border-radius: 999px;
            font-style: normal;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-inline-status.is-success { background: rgba(23, 178, 106, 0.12); color: #63ddab; }
        .lira-inline-status.is-warning { background: rgba(120, 97, 255, 0.12); color: #c4b6ff; }
        .lira-inline-status.is-danger { background: rgba(240, 68, 56, 0.12); color: #ff8a80; }

        .lira-admin-detail-actions {
            margin-top: 14px;
        }

        .lira-admin-request-breakdown {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-admin-request-breakdown span {
            text-align: center;
        }

        .lira-admin-request-breakdown strong {
            display: block;
            margin-bottom: 4px;
            color: #fff;
            font-size: 1.35rem;
        }

        .lira-admin-action-dropdown {
            min-width: 220px;
        }

        .lira-admin-action-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 42px;
        }

        @media (max-width: 991.98px) {
            .lira-admin-user-show-hero {
                align-items: flex-start;
            }
        }

        @media (max-width: 575.98px) {
            .lira-admin-detail-card {
                padding: 14px;
                border-radius: 18px;
            }

            .lira-admin-detail-list,
            .lira-admin-request-breakdown {
                grid-template-columns: 1fr;
            }

            .lira-admin-detail-actions .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush

