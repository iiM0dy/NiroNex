@extends('layouts.site-dash')

@section('title', 'الملف الشخصي')

@section('content')
    @php
        $fullName = $user->full_name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        $hasPlan = !empty($user->plan);
        $emailVerified = method_exists($user, 'hasVerifiedEmail') ? $user->hasVerifiedEmail() : !empty($user->email_verified_at);

        $kycFront = !empty($user->id_photo_front);
        $kycBack = !empty($user->id_photo_back);
        $kycSelfie = !empty($user->selfie_photo);
        $kycComplete = !empty($user->id_photo_front) && !in_array($user->status, [\App\Enums\UserStatus::Pending, \App\Enums\UserStatus::Inactive]);

        $statusText = match ($user->status) {
            \App\Enums\UserStatus::Pending => 'قيد التفعيل',
            \App\Enums\UserStatus::Inactive => 'معلّق',
            default => 'نشط',
        };

        $statusClass = match ($user->status) {
            \App\Enums\UserStatus::Pending => 'is-pending',
            \App\Enums\UserStatus::Inactive => 'is-inactive',
            default => 'is-active',
        };

        $memberSince = $user->created_at ? $user->created_at->format('Y/m') : '—';
        $userCode = '#' . str_pad($user->id, 5, '0', STR_PAD_LEFT);
    @endphp

    <div class="lira-profile-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} ACCOUNT · PROFILE & SECURITY</span>
                <h1 class="lira-page-title">الملف الشخصي</h1>
                <p class="lira-page-subtitle">
                    إدارة معلومات الحساب، بيانات السحب، حالة التوثيق، وإعدادات الأمان من مكان واحد.
                </p>
            </div>

            <div class="lira-hero-note">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>إعدادات الحساب والأمان</strong>
                    <span>حافظ على تحديث معلوماتك لضمان تشغيل الحساب والمعاملات بسلاسة.</span>
                </div>
            </div>
        </div>

        <div class="lira-profile-stats-grid mb-4">
            <div class="lira-profile-stat-slot">
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

            <div class="lira-profile-stat-slot">
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
                            <span>الرصيد المودع في المنصة</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lira-profile-stat-slot">
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
                            <span>الأرباح المضافة إلى الحساب</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lira-profile-stat-slot">
                <div class="card lira-stat-card h-100">
                    <div class="card-body">
                        <div class="lira-stat-top">
                            <span class="lira-stat-label">حالة الحساب</span>
                            <div class="lira-stat-icon">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                        <div class="lira-stat-value">{{ $statusText }}</div>
                        <div class="lira-stat-meta">
                            <span>{{ $hasPlan ? ($user->plan->display_name ?? 'خطة مفعلة') : 'بدون خطة' }}</span>
                            <span class="{{ $emailVerified ? 'text-success' : 'text-warning' }}">
                                {{ $emailVerified ? 'Email Verified' : 'Email Pending' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 lira-profile-layout">
            <div class="col-xxl-4 lira-profile-sidebar">
                <div class="lira-profile-side-stack d-flex flex-column gap-3">
                    <div class="card lira-profile-card" id="profileOverview">
                        <div class="card-body">
                            <div class="lira-profile-top">
                                <div class="lira-profile-avatar">
                                    @if ($user->image && file_exists(public_path($user->image)))
                                        <img src="{{ asset($user->image) }}" alt="Avatar">
                                    @else
                                        <span>{{ mb_substr($fullName ?: 'L', 0, 1) }}</span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <h4 class="mb-1">{{ $fullName ?: 'مستخدم ' . appName() }}</h4>
                                    <p class="text-muted mb-3">{{ $user->email }}</p>

                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <span class="lira-status-pill {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>

                                        <span class="lira-status-pill {{ $emailVerified ? 'is-active' : 'is-pending' }}">
                                            {{ $emailVerified ? 'البريد موثق' : 'البريد بانتظار التوثيق' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-profile-meta mt-4">
                                <div class="lira-meta-row">
                                    <span>رقم الحساب</span>
                                    <strong>{{ $userCode }}</strong>
                                </div>

                                <div class="lira-meta-row">
                                    <span>تاريخ الانضمام</span>
                                    <strong>{{ $memberSince }}</strong>
                                </div>

                                <div class="lira-meta-row">
                                    <span>الخطة الحالية</span>
                                    <strong>{{ $hasPlan ? ($user->plan->display_name ?? '—') : 'بدون خطة' }}</strong>
                                </div>

                                <div class="lira-meta-row">
                                    <span>الهاتف</span>
                                    <strong dir="ltr">{{ $user->phone ?: '—' }}</strong>
                                </div>

                                <div class="lira-meta-row">
                                    <span>عنوان السحب</span>
                                    <strong class="lira-meta-break">{{ $user->withdrawal_address ?: 'غير محدد' }}</strong>
                                </div>
                            </div>

                            <div class="lira-profile-actions mt-4">
                                <a href="{{ route('site.plans') }}" class="btn btn-outline-primary w-100">
                                    {{ $hasPlan ? 'تغيير الخطة' : 'تفعيل خطة' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">حالة التوثيق</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-kyc-summary">
                                <div class="lira-summary-block mb-3">
                                    <span>وضع KYC</span>
                                    <strong class="{{ $kycComplete ? 'text-success' : 'text-warning' }}">
                                        {{ $kycComplete ? 'مكتمل' : 'غير مكتمل' }}
                                    </strong>
                                </div>

                                <div class="lira-guidelines">
                                    <div class="lira-guideline-item">
                                        <i class="fa-solid {{ $kycFront ? 'fa-circle-check text-success' : 'fa-circle text-muted' }}"></i>
                                        <span>صورة الهوية - الوجه الأول</span>
                                    </div>
                                    <div class="lira-guideline-item">
                                        <i class="fa-solid {{ $kycBack ? 'fa-circle-check text-success' : 'fa-circle text-muted' }}"></i>
                                        <span>صورة الهوية - الوجه الثاني</span>
                                    </div>
                                    <div class="lira-guideline-item">
                                        <i class="fa-solid {{ $kycSelfie ? 'fa-circle-check text-success' : 'fa-circle text-muted' }}"></i>
                                        <span>صورة السيلفي مع الوثيقة</span>
                                    </div>
                                </div>

                                <div class="lira-inline-note mt-3">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>
                                        اكتمال التوثيق يساعد على حماية الحساب وتسريع المراجعات المرتبطة بالمعاملات.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملاحظات الحساب</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>حدّث بيانات السحب بدقة لتفادي أي تأخير عند المراجعة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>استخدم كلمة مرور قوية ولا تشاركها مع أي طرف.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>احرص على بقاء البريد الإلكتروني والهاتف محدثين دائمًا.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 lira-profile-main">
                <div class="lira-settings-stack d-flex flex-column gap-3">
                    <div class="card lira-form-card" id="profileInfo">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">بيانات الحساب</h6>
                                <p class="text-muted mb-0 small">قم بتحديث معلوماتك الشخصية والمالية الأساسية.</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="lira-auth-label">الاسم الأول</label>
                                        <input
                                            name="first_name"
                                            type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $user->first_name) }}"
                                            required
                                        >
                                        @error('first_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="lira-auth-label">اسم العائلة</label>
                                        <input
                                            name="last_name"
                                            type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $user->last_name) }}"
                                            required
                                        >
                                        @error('last_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="lira-auth-label">رقم الهاتف</label>
                                        <input
                                            name="phone"
                                            type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}"
                                            dir="ltr"
                                        >
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="lira-auth-label">تاريخ الميلاد</label>
                                        <input
                                            name="birthday"
                                            type="date"
                                            class="form-control @error('birthday') is-invalid @enderror"
                                            value="{{ old('birthday', $user->birthday) }}"
                                        >
                                        @error('birthday')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="lira-auth-label">عنوان السحب الافتراضي</label>
                                        <input
                                            name="withdrawal_address"
                                            type="text"
                                            class="form-control @error('withdrawal_address') is-invalid @enderror"
                                            value="{{ old('withdrawal_address', $user->withdrawal_address) }}"
                                            placeholder="USDT Wallet Address"
                                            dir="ltr"
                                        >
                                        @error('withdrawal_address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="lira-auth-label">العنوان الفعلي</label>
                                        <input
                                            name="address"
                                            type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $user->address) }}"
                                            placeholder="المدينة، المنطقة، العنوان"
                                        >
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 d-flex justify-content-end pt-2">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fa-solid fa-floppy-disk ms-2"></i>
                                            حفظ المعلومات
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card lira-form-card" id="profileSecurity">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">الأمان وتغيير كلمة المرور</h6>
                                <p class="text-muted mb-0 small">استخدم كلمة مرور جديدة قوية عند الحاجة فقط.</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('change-password') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="lira-auth-label">كلمة المرور الحالية</label>
                                        <input
                                            name="current_password"
                                            type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            placeholder="••••••••"
                                            required
                                        >
                                        @error('current_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="lira-auth-label">كلمة المرور الجديدة</label>
                                        <input
                                            name="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="••••••••"
                                            required
                                        >
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="lira-auth-label">تأكيد كلمة المرور</label>
                                        <input
                                            name="password_confirmation"
                                            type="password"
                                            class="form-control"
                                            placeholder="••••••••"
                                            required
                                        >
                                    </div>



                                    <div class="col-12 d-flex justify-content-end pt-2">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fa-solid fa-key ms-2"></i>
                                            تحديث كلمة المرور
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card lira-form-card" id="profileKyc">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">استكمال التوثيق (KYC)</h6>
                                <p class="text-muted mb-0 small">رفع المستندات يساعد على اعتماد الحساب بشكل أسرع.</p>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($kycComplete)
                                <div class="alert alert-success d-flex align-items-center mb-0" style="background: rgba(23, 178, 106, 0.12); border: 1px solid rgba(23, 178, 106, 0.2); color: #5fe2a1; border-radius: 16px;">
                                    <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                                    <div>
                                        <strong>تم التحقق من هويتك بنجاح ✓</strong>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('profile.kyc') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="lira-auth-label">نوع الوثيقة</label>
                                            <div class="lira-input-wrap lira-select-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-solid fa-id-card"></i>
                                                </span>
                                                <select
                                                    name="document_type"
                                                    class="form-control @error('document_type') is-invalid @enderror"
                                                    required
                                                >
                                                    <option value="">اختر نوع الوثيقة</option>
                                                    <option value="1">الهوية الوطنية (National ID)</option>
                                                    <option value="0">جواز السفر (Passport)</option>
                                                    <option value="2">رخصة القيادة (Driving License)</option>
                                                </select>
                                            </div>
                                            @error('document_type')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="lira-auth-label">صورة الوجه الأول</label>
                                            <div class="lira-file-wrap">
                                                <span class="lira-file-icon">
                                                    <i class="fa-regular fa-image"></i>
                                                </span>
                                                <input
                                                    type="file"
                                                    name="id_photo_front"
                                                    class="form-control @error('id_photo_front') is-invalid @enderror"
                                                    accept="image/*"
                                                >
                                            </div>
                                            @error('id_photo_front')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="lira-auth-label">صورة الوجه الثاني</label>
                                            <div class="lira-file-wrap">
                                                <span class="lira-file-icon">
                                                    <i class="fa-regular fa-image"></i>
                                                </span>
                                                <input
                                                    type="file"
                                                    name="id_photo_back"
                                                    class="form-control @error('id_photo_back') is-invalid @enderror"
                                                    accept="image/*"
                                                >
                                            </div>
                                            @error('id_photo_back')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="lira-auth-label">صورة السيلفي مع الوثيقة</label>
                                            <div class="lira-file-wrap">
                                                <span class="lira-file-icon">
                                                    <i class="fa-regular fa-address-card"></i>
                                                </span>
                                                <input
                                                    type="file"
                                                    name="selfie_with_document"
                                                    class="form-control @error('selfie_with_document') is-invalid @enderror"
                                                    accept="image/*"
                                                >
                                            </div>
                                            @error('selfie_with_document')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12 d-flex justify-content-end pt-2">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fa-solid fa-cloud-arrow-up ms-2"></i>
                                                رفع الوثائق
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="card lira-form-card" id="profileStatus">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">وضع الحساب</h6>
                                <p class="text-muted mb-0 small">قراءة سريعة لوضع البريد، الخطة، والتوثيق.</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="lira-account-grid">
                                <div class="lira-account-box">
                                    <span>البريد الإلكتروني</span>
                                    <strong>{{ $user->email }}</strong>
                                    <small class="{{ $emailVerified ? 'text-success' : 'text-warning' }}">
                                        {{ $emailVerified ? 'تم التحقق' : 'بانتظار التحقق' }}
                                    </small>
                                </div>

                                <div class="lira-account-box">
                                    <span>الخطة الحالية</span>
                                    <strong>{{ $hasPlan ? ($user->plan->display_name ?? '—') : 'بدون خطة' }}</strong>
                                    <small>{{ $hasPlan ? 'الاشتراك مفعل' : 'يمكنك تفعيل خطة من صفحة الخطط' }}</small>
                                </div>

                                <div class="lira-account-box">
                                    <span>حالة الحساب</span>
                                    <strong>{{ $statusText }}</strong>
                                    <small>{{ $kycComplete ? 'التوثيق مكتمل' : 'التوثيق بحاجة لمراجعة أو استكمال' }}</small>
                                </div>

                                <div class="lira-account-box">
                                    <span>آخر بيانات السحب</span>
                                    <strong class="lira-meta-break">{{ $user->withdrawal_address ?: 'غير محدد' }}</strong>
                                    <small>يتم استخدامها كعنوان افتراضي عند الطلب</small>
                                </div>
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
        /* Profile-specific styling */
        .lira-profile-page [id] {
            scroll-margin-top: 92px;
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

        .lira-profile-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-profile-layout {
            align-items: flex-start;
        }

        .lira-stat-card,
        .lira-profile-card,
        .lira-form-card,
        .lira-side-card {
            overflow: hidden;
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

        .lira-profile-top {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .lira-profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 28px;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            background: rgba(0, 230, 167, 0.12);
            border: 1px solid rgba(0, 230, 167, 0.18);
        }

        .lira-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lira-profile-avatar span {
            font-size: 2rem;
            font-weight: 800;
            color: var(--lira-accent);
        }

        .lira-status-pill {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-status-pill.is-active {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-status-pill.is-pending {
            background: rgba(120, 97, 255, 0.12);
            color: #c4b6ff;
        }

        .lira-status-pill.is-inactive {
            background: rgba(240, 68, 56, 0.12);
            color: #ff8a80;
        }

        .lira-profile-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-meta-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-meta-row span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-meta-row strong {
            color: var(--lira-text);
            font-size: 13px;
            text-align: left;
        }

        .lira-meta-break {
            word-break: break-word;
            max-width: 60%;
        }

        .lira-profile-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .lira-auth-label {
            display: block;
            margin-bottom: 10px;
            color: var(--lira-text-soft);
            font-size: 13px;
            font-weight: 700;
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
            margin-top: 4px;
            flex: 0 0 auto;
        }

        .lira-inline-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-inline-note i {
            color: var(--lira-accent);
            margin-top: 2px;
            flex: 0 0 auto;
        }

        .lira-account-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-account-box {
            padding: 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-account-box span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .lira-account-box strong {
            display: block;
            color: var(--lira-text);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .lira-account-box small {
            color: var(--lira-text-muted);
            font-size: 11px;
            line-height: 1.7;
        }

        @media (max-width: 991.98px) {
            .lira-profile-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .lira-account-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .lira-hero-note {
                display: none;
            }

            .lira-profile-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-stat-card {
                min-height: auto;
                box-shadow: none !important;
            }

            .lira-stat-top {
                gap: 8px;
                margin-bottom: 8px;
            }

            .lira-stat-label {
                font-size: 11px;
            }

            .lira-stat-icon {
                width: 32px;
                height: 32px;
                border-radius: 10px;
                font-size: 13px;
            }

            .lira-stat-value {
                font-size: 0.92rem;
                margin-bottom: 6px;
            }

            .lira-stat-meta {
                font-size: 10px;
                gap: 4px;
                line-height: 1.45;
            }

            .lira-profile-sidebar {
                order: 1;
            }

            .lira-profile-main {
                order: 2;
            }

            .lira-profile-layout {
                --bs-gutter-x: 0;
                --bs-gutter-y: 8px;
                margin-left: 0;
                margin-right: 0;
            }

            .lira-profile-sidebar,
            .lira-profile-main,
            .lira-profile-side-stack,
            .lira-settings-stack {
                display: contents;
            }

            .lira-meta-row {
                padding: 12px;
                border-radius: 12px;
            }

            .lira-meta-row strong {
                font-size: 12px;
            }

            .lira-meta-break {
                max-width: 52%;
            }

            .lira-account-grid {
                gap: 10px;
            }

            .lira-account-box {
                padding: 13px;
                border-radius: 16px;
            }

            .lira-account-box span {
                font-size: 11px;
            }

            .lira-account-box strong {
                font-size: 13px;
            }

            .lira-account-box small {
                font-size: 10px;
                line-height: 1.6;
            }

            .lira-profile-layout .lira-profile-card,
            .lira-profile-layout .lira-side-card,
            .lira-profile-layout .lira-form-card {
                width: 100%;
                flex: 0 0 100%;
            }

            .lira-profile-card,
            .lira-side-card,
            .lira-form-card {
                border-radius: 12px !important;
                box-shadow: none !important;
                border-color: rgba(255, 255, 255, 0.05) !important;
                background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005)), var(--lira-surface) !important;
            }

            .lira-form-card .card-header,
            .lira-form-card .card-body,
            .lira-profile-card .card-body,
            .lira-side-card .card-header,
            .lira-side-card .card-body {
                padding: 10px 12px !important;
            }

            .lira-form-card .card-header,
            .lira-side-card .card-header {
                padding-bottom: 6px !important;
            }

            .lira-form-card .card-header p,
            .lira-side-card .card-header p {
                font-size: 10px;
                line-height: 1.5;
            }

            .lira-form-card .row.g-3,
            .lira-form-card .row.g-4 {
                --bs-gutter-x: 8px;
                --bs-gutter-y: 8px;
            }

            .lira-form-card .btn,
            .lira-profile-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .lira-profile-top {
                align-items: flex-start;
            }

            .lira-profile-top .text-center {
                width: 100%;
                text-align: right !important;
            }

            .lira-profile-avatar {
                width: 76px;
                height: 76px;
                border-radius: 20px;
                margin-bottom: 14px;
            }

            .lira-profile-avatar span {
                font-size: 1.45rem;
            }

            .lira-status-pill {
                min-height: 28px;
                padding: 0 10px;
                font-size: 10px;
            }

            .lira-profile-meta {
                gap: 6px;
                margin-top: 12px !important;
            }

            .lira-guideline-item {
                font-size: 12px;
                line-height: 1.65;
            }

            .lira-summary-block,
            .lira-account-box,
            .lira-inline-note {
                padding: 12px;
                border-radius: 12px;
            }

            .lira-inline-note {
                font-size: 11px;
            }

            .lira-profile-actions {
                margin-top: 12px !important;
            }
        }

        @media (max-width: 575.98px) {
            .lira-stat-card {
                min-height: auto;
            }

            .lira-account-grid {
                grid-template-columns: 1fr;
            }
            
            .lira-account-box {
                padding: 12px;
                border-radius: 14px;
            }

            .lira-account-box span {
                font-size: 11px;
            }

            .lira-account-box strong {
                font-size: 13px;
            }

            .lira-meta-row {
                gap: 10px;
            }

            .lira-meta-break {
                max-width: 48%;
            }

            .lira-profile-stats-grid {
                gap: 6px;
            }
        }

        /* ─── Premium Form Wrappers ─── */
        .lira-input-wrap, .lira-file-wrap {
            position: relative;
            width: 100%;
        }

        .lira-input-icon, .lira-file-icon {
            position: absolute;
            top: 50%;
            inset-inline-start: 16px;
            transform: translateY(-50%);
            color: var(--lira-text-muted);
            z-index: 2;
            font-size: 14px;
            pointer-events: none;
        }

        .lira-input-wrap .form-control,
        .lira-file-wrap .form-control {
            padding-inline-start: 48px !important;
            height: 54px;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--lira-border) !important;
            transition: all 0.2s ease;
        }

        .lira-input-wrap .form-control:focus,
        .lira-file-wrap .form-control:focus {
            border-color: rgba(0, 230, 167, 0.4) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.08) !important;
        }

        /* File Upload Button Styling */
        .lira-file-wrap .form-control {
            display: flex;
            align-items: center;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .lira-file-wrap .form-control::-webkit-file-upload-button,
        .lira-file-wrap .form-control::file-selector-button {
            border: 0;
            background: var(--lira-gold);
            color: #17120a;
            padding: 8px 16px;
            border-radius: 12px;
            margin-inline-end: 15px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
            transition: background-color 0.18s ease, color 0.18s ease;
            box-shadow: none;
        }

        .lira-file-wrap .form-control::-webkit-file-upload-button:hover,
        .lira-file-wrap .form-control::file-selector-button:hover {
            background: var(--lira-gold-strong);
            color: #f4f6fa;
            box-shadow: none;
        }

        /* Select Wrapper Styling */
        .lira-select-wrap select {
            appearance: none;
            -webkit-appearance: none;
            color-scheme: dark;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%238d96a5' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: left 16px center !important;
        }

        .lira-select-wrap select option {
            background: var(--lira-surface-2);
            color: var(--lira-text);
        }

        [dir="rtl"] .lira-select-wrap select {
            background-position: left 16px center !important;
        }
    </style>
@endpush

