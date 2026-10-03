@extends(backendView('layouts.auth'))

@section('title', 'حساب جديد')

@section('content')
    <section class="lira-auth-page">
        <div class="container">
            <div class="lira-auth-shell lira-register-shell">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="lira-auth-aside h-100">
                            <span class="lira-auth-badge">{{ brandAiName() }} · ACCOUNT SETUP</span>

                            <h1 class="lira-auth-heading">
                                افتح حسابك وابدأ تجهيز تجربة {{ appName() }}
                            </h1>

                            <p class="lira-auth-copy">
                                أنشئ حسابك، فعّل بياناتك الأساسية، وارفع مستندات التحقق لتهيئة الوصول الكامل إلى لوحة
                                المنصة.
                            </p>

                            <div class="lira-auth-points">
                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7721.svg') }}" alt="Registration" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>1. إنشاء الحساب</strong>
                                        <span>إدخال البيانات الأساسية وربط البريد والهاتف.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7725.svg') }}" alt="Verification" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>2. التحقق من الهوية</strong>
                                        <span>رفع الوثائق يدعم أمان الحساب ويجهّز السحب والاعتماد.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7727.svg') }}" alt="Activation" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>3. تفعيل الخطة</strong>
                                        <span>بعد الدخول يمكنك متابعة الخطط والرصيد ولوحة التحكم.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-register-note-box">
                                <strong>مهم</strong>
                                <span>
                                    يمكنك رفع مستندات KYC أثناء التسجيل الآن، أو استكمالها لاحقاً من داخل الحساب إن كانت
                                    الحقول غير إلزامية في إعداداتك الحالية.
                                </span>
                            </div>

                            @if(request('ref'))
                                <div class="lira-ref-chip">
                                    <img src="{{ asset('assets/images/icons/IMG_7721.svg') }}" alt="Referral" style="width: 18px; height: 18px; object-fit: contain; margin-inline-end: 8px;">
                                    تسجيل عبر رابط إحالة
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="lira-auth-form-wrap h-100">
                            <div class="lira-auth-form-head">
                                <h2>إنشاء حساب جديد</h2>
                                <p>أدخل بياناتك الأساسية لفتح حسابك في {{ appName() }}.</p>
                            </div>

                            @include('includes.messages')

                            <form method="POST" action="{{ route('register') }}" class="lira-auth-form">
                                @csrf
                                <input type="hidden" name="referral_id" value="{{ request('ref') }}">

                                <div class="lira-form-section">
                                    <div class="lira-form-section-head">
                                        <h3>البيانات الشخصية</h3>
                                        <p>الهوية الأساسية للحساب.</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="lira-auth-label">الاسم الأول</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-regular fa-user"></i>
                                                </span>
                                                <input name="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    placeholder="الاسم الأول" value="{{ old('first_name') }}" required>
                                            </div>
                                            @error('first_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="lira-auth-label">الاسم الثاني</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-regular fa-user"></i>
                                                </span>
                                                <input name="last_name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    placeholder="الاسم الثاني" value="{{ old('last_name') }}" required>
                                            </div>
                                            @error('last_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="lira-auth-label">تاريخ الميلاد</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-regular fa-calendar" style="display: none;"></i>
                                                </span>
                                                <input id="birthdate" name="birthdate" type="text"
                                                    class="form-control @error('birthdate') is-invalid @enderror"
                                                    placeholder="MM/DD/YYYY"
                                                    style="padding-inline-start: 16px; font-family: 'League Spartan', sans-serif; direction: ltr; text-align: left;"
                                                    value="{{ old('birthdate') }}" maxlength="10" inputmode="numeric"
                                                    autocomplete="off" required>
                                            </div>
                                            @error('birthdate')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="lira-form-section">
                                    <div class="lira-form-section-head">
                                        <h3>بيانات التواصل</h3>
                                        <p>سيتم استخدامها لإدارة الحساب والتنبيهات.</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="lira-auth-label">البريد الإلكتروني</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </span>
                                                <input name="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="example@email.com" value="{{ old('email') }}" required>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12" dir="ltr">
                                            <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                                <span class="lira-phone-hint" dir="rtl" >اختر الدولة ثم أدخل الرقم</span>
                                                    <label class="lira-auth-label m-0" dir="rtl">رمز الدولة ورقم
                                                        الموبايل</label>
                                            </div>
                                            <div class="lira-input-wrap phone-wrap">
                                                <input id="lira-phone" type="tel" class="form-control"
                                                    placeholder="رقم الموبايل" required
                                                    style="padding-left: 90px; text-align: left;"
                                                    value="{{ old('country_code', '+963') }}{{ old('phone') }}">
                                                <input type="hidden" name="country_code" id="hidden_country_code"
                                                    value="{{ old('country_code', '+963') }}">
                                                <input type="hidden" name="phone" id="hidden_phone"
                                                    value="{{ old('phone') }}">
                                            </div>
                                            <div id="phone-error" class="invalid-feedback d-none text-end" dir="rtl"
                                                style="color: #ef4444; font-size: 13px; margin-top: 6px;"></div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block text-end" dir="rtl">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="lira-form-section">
                                    <div class="lira-form-section-head">
                                        <h3>حماية الحساب</h3>
                                        <p>اختر كلمة مرور قوية لحسابك.</p>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="lira-auth-label">كلمة المرور</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-solid fa-lock"></i>
                                                </span>
                                                <input id="registerPassword" name="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="••••••••" required>
                                                <button type="button" class="lira-password-toggle"
                                                    data-toggle-target="#registerPassword">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="lira-auth-label">تأكيد كلمة المرور</label>
                                            <div class="lira-input-wrap">
                                                <span class="lira-input-icon">
                                                    <i class="fa-solid fa-lock"></i>
                                                </span>
                                                <input id="registerPasswordConfirm" name="password_confirmation"
                                                    type="password" class="form-control" placeholder="••••••••" required>
                                                <button type="button" class="lira-password-toggle"
                                                    data-toggle-target="#registerPasswordConfirm">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lira-auth-consent">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="accept" name="accept"
                                                required>
                                            <label class="form-check-label" for="accept">
                                                أوافق على
                                                <a href="{{ route('terms') }}" target="_blank" class="lira-auth-link">
                                                    اتفاقية استخدام الموقع
                                                </a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="lira-register-submit-bar">
                                        <button class="btn btn-primary lira-auth-submit mb-3 mb-md-3 w-100" type="submit">
                                            فتح حساب جديد
                                        </button>
                                    </div>

                                    <div class="lira-auth-bottom">
                                        <span>لديك حساب بالفعل؟</span>
                                        <a href="{{ route('login') }}">تسجيل الدخول</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Premium Toast Container -->
    <div id="lira-toast-container"></div>
@endsection

@push('custom_styles')
    <style>
        :root {
            --lira-auth-bg: #07090d;
            --lira-auth-surface: #10141c;
            --lira-auth-surface-2: #141a23;
            --lira-auth-border: #222a36;
            --lira-auth-text: #f7f8fa;
            --lira-auth-text-soft: #c5cad3;
            --lira-auth-text-muted: #8d96a5;
            --lira-auth-gold: #00e6a7;
            --lira-auth-gold-strong: #38bdf8;
            --lira-auth-gold-soft: rgba(0, 230, 167, 0.12);
        }

        .lira-auth-page {
            padding: 40px 0 80px;
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
        }

        .lira-auth-shell {
            background: var(--lira-auth-surface);
            border: 1px solid var(--lira-auth-border);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }

        .lira-auth-aside {
            padding: 42px 38px;
            background: linear-gradient(135deg, #0b0f15 0%, #07090d 100%);
            border-inline-end: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-auth-badge {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: var(--lira-auth-gold-soft);
            border: 1px solid rgba(0, 230, 167, 0.22);
            color: var(--lira-auth-gold);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .lira-auth-heading {
            margin: 24px 0 12px;
            color: var(--lira-auth-text);
            font-size: 2rem;
            line-height: 1.3;
            font-weight: 800;
        }

        .lira-auth-copy {
            margin: 0 0 28px;
            color: var(--lira-auth-text-muted);
            line-height: 1.9;
            font-size: 14px;
        }

        .lira-auth-points {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .lira-auth-point {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-auth-point:last-child {
            border-bottom: 0;
        }

        .lira-auth-point-icon {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.09);
            color: var(--lira-auth-gold);
            flex: 0 0 auto;
        }

        .lira-auth-point strong {
            display: block;
            color: var(--lira-auth-text);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .lira-auth-point span {
            color: var(--lira-auth-text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-register-shell .lira-auth-aside {
            padding: 34px 28px;
        }

        .lira-register-shell .lira-auth-form-wrap {
            padding: 36px 34px;
        }

        .lira-auth-form-head {
            margin-bottom: 28px;
        }

        .lira-auth-form-head h2 {
            font-size: 1.6rem;
            margin-bottom: 8px;
            font-weight: 800;
            color: var(--lira-auth-text);
        }

        .lira-auth-form-head p {
            color: var(--lira-auth-text-muted);
            font-size: 14px;
            margin: 0;
        }

        .lira-auth-label {
            display: block;
            color: var(--lira-auth-text-soft);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lira-input-wrap {
            position: relative;
        }

        .lira-input-wrap .form-control {
            height: 54px;
            padding-inline-start: 48px;
            border-radius: 16px;
            background: var(--lira-auth-surface-2) !important;
            border: 1px solid var(--lira-auth-border) !important;
            color: var(--lira-auth-text-soft) !important;
            font-size: 14px;
        }

        .lira-input-icon {
            position: absolute;
            top: 50%;
            inset-inline-start: 16px;
            transform: translateY(-50%);
            color: var(--lira-auth-text-muted);
            z-index: 2;
        }

        .lira-password-toggle {
            position: absolute;
            top: 50%;
            inset-inline-end: 14px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: var(--lira-auth-text-muted);
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .lira-password-toggle:hover {
            color: var(--lira-auth-text);
            background: rgba(255, 255, 255, 0.03);
        }

        .lira-form-section {
            padding: 20px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-form-section:first-of-type {
            border-top: 0;
            padding-top: 0;
        }

        .lira-form-section-head {
            margin-bottom: 18px;
        }

        .lira-form-section-head h3 {
            margin-bottom: 6px;
            font-size: 1rem;
            font-weight: 800;
            color: var(--lira-auth-text);
        }

        .lira-form-section-head p {
            margin: 0;
            color: var(--lira-auth-text-muted);
            font-size: 13px;
        }

        .lira-select-wrap .form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        /* removed unused birth meta styles */

        .lira-file-wrap {
            position: relative;
        }

        .lira-file-wrap .form-control {
            min-height: 54px;
            padding-inline-start: 48px;
            padding-top: 14px;
            padding-bottom: 14px;
            border-radius: 16px;
            background: var(--lira-auth-surface-2) !important;
            border: 1px solid var(--lira-auth-border) !important;
            color: var(--lira-auth-text-soft) !important;
        }

        .lira-file-wrap .form-control::-webkit-file-upload-button {
            border: 0;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-auth-gold);
            padding: 8px 12px;
            border-radius: 10px;
            margin-inline-end: 12px;
            cursor: pointer;
        }

        .lira-file-icon {
            position: absolute;
            top: 50%;
            inset-inline-start: 16px;
            transform: translateY(-50%);
            color: var(--lira-auth-text-muted);
            z-index: 2;
        }

        .lira-auth-consent {
            padding: 8px 0 20px;
        }

        .lira-register-note-box {
            margin-top: 22px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-register-note-box strong {
            display: block;
            color: var(--lira-auth-text);
            font-size: 13px;
            margin-bottom: 6px;
        }

        .lira-register-note-box span {
            color: var(--lira-auth-text-muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .lira-ref-chip {
            margin-top: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(0, 230, 167, 0.10);
            border: 1px solid rgba(0, 230, 167, 0.22);
            color: var(--lira-auth-gold);
            font-size: 12px;
            font-weight: 800;
        }

        /* native inputs adjustments */

        @media (max-width: 991.98px) {

            .lira-register-shell .lira-auth-aside,
            .lira-register-shell .lira-auth-form-wrap {
                padding: 28px 22px;
            }
        }

        @media (max-width: 575.98px) {

            .lira-register-shell .lira-auth-aside,
            .lira-register-shell .lira-auth-form-wrap {
                padding: 24px 20px;
            }

            /* mobile sizes adjust */

            .lira-auth-point {
                padding: 16px 12px;
                border: 1px solid rgba(255, 255, 255, 0.04);
                border-radius: 18px;
                margin-bottom: 8px;
            }

            .lira-register-note-box {
                padding: 18px;
            }
        }

        .lira-auth-submit {
            min-height: 54px;
            border-radius: 16px !important;
            font-weight: 800 !important;
            font-size: 15px !important;
            background: linear-gradient(180deg, var(--lira-accent-strong), var(--lira-accent)) !important;
            border: none !important;
            color: #17120a !important;
            box-shadow: 0 4px 12px rgba(0, 230, 167, 0.16) !important;
            margin-top: 10px;
            transition: all 0.25s ease !important;
        }

        .lira-auth-submit:hover {
            filter: brightness(1.05) !important;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 230, 167, 0.24) !important;
        }

        .lira-auth-bottom {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
            color: var(--lira-auth-text-muted);
            font-size: 14px;
        }

        .lira-auth-bottom a {
            color: #00e6a7 !important;
            font-weight: 700;
            text-decoration: none;
            transition: none !important;
        }

        .lira-auth-bottom a:hover {
            color: #00e6a7 !important;
            text-decoration: none !important;
        }

        .lira-register-submit-bar {
            position: relative;
        }

        /* Password Toggle Button */
        .lira-password-toggle {
            position: absolute;
            top: 50%;
            inset-inline-end: 14px;
            transform: translateY(-50%);
            background: none !important;
            border: none !important;
            color: var(--lira-auth-text-muted);
            font-size: 16px;
            cursor: pointer;
            z-index: 5;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .lira-password-toggle:hover {
            color: var(--lira-auth-gold);
        }

        /* Premium Minimal Toast */
        #lira-toast-container {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999999;
            pointer-events: none;
        }

        .lira-toast {
            background: rgba(240, 68, 56, 1);
            color: #fff;
            padding: 12px 28px;
            border-radius: 99px;
            font-weight: 800;
            font-size: 16px;
            box-shadow: 0 10px 30px rgba(240, 68, 56, 0.35);
            animation: liraToastIn 0.4s cubic-bezier(0.19, 1, 0.22, 1), liraToastOut 0.4s 2.6s forwards;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes liraToastIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes liraToastOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }
        }

        .lira-phone-hint {
            color: var(--lira-auth-text-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .lira-country-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(3, 6, 12, 0.72);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 999997;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .lira-country-backdrop.is-visible {
            opacity: 1;
            pointer-events: auto;
        }

        /* IntlTelInput custom overrides for brand UI */
        .iti {
            width: 100%;
            display: block;
            direction: ltr;
        }

        .iti__flag {
            background-image: url("{{ asset('assets/images/flags/flags.webp') }}");
        }

        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .iti__flag {
                background-image: url("{{ asset('assets/images/flags/flags@2x.webp') }}");
            }
        }

        /* Ensure phone-wrap creates its own stacking context above everything below */
        .phone-wrap {
            position: relative;
            z-index: 100;
        }

        .phone-wrap .iti__selected-country,
        .phone-wrap .iti__selected-country-primary {
            height: 58px;
            min-width: 88px;
            padding: 0 14px 0 12px !important;
            border-radius: 16px 0 0 16px;
            background: rgba(255, 255, 255, 0.03);
        }

        .phone-wrap .iti input {
            min-height: 58px;
            padding-left: 108px !important;
            padding-right: 16px !important;
            direction: ltr;
            letter-spacing: 0.02em;
        }

        .phone-wrap .iti__flag {
            transform: scale(1.08);
            transform-origin: center;
        }

        .phone-wrap .iti__selected-dial-code {
            color: #ffffff !important;
            font-family: 'League Spartan', sans-serif;
            font-size: 15px;
            font-weight: 700;
            margin-left: 8px;
        }

        .phone-wrap .iti__arrow {
            margin-left: 6px;
        }

        .iti__country-list {
            background-color: #0b0f15 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            text-align: right;
            border-radius: 12px;
            font-family: inherit;
            width: 340px;
            max-width: 90vw;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.7);
            z-index: 999999 !important;
            direction: rtl;
            overflow-x: hidden;
            /* Anchor to the right side (under the flag in RTL) */
            right: 0 !important;
            left: auto !important;
        }

        .iti__country-list.mobile-country-sheet {
            position: fixed !important;
            inset: auto 12px 12px 12px !important;
            width: auto !important;
            max-width: none !important;
            max-height: min(52vh, 420px) !important;
            border-radius: 24px !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            background: linear-gradient(180deg, #121822 0%, #0b0f15 100%) !important;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.65) !important;
            padding-bottom: env(safe-area-inset-bottom, 0);
            direction: rtl;
            z-index: 999998 !important;
        }

        .iti__search-input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            padding: 10px 12px !important;
            margin: 10px !important;
            width: calc(100% - 20px) !important;
            text-align: right;
        }

        .iti__search-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .iti__country {
            padding: 11px 14px !important;
            outline: none;
            direction: rtl;
            white-space: nowrap;
        }

        .iti__country.iti__highlight {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .iti__country-name {
            color: #ffffff !important;
            margin-right: 6px;
        }

        .iti__dial-code {
            color: #00e6a7 !important;
            opacity: 0.8;
            margin-right: auto;
        }

        .iti__selected-dial-code {
            color: #ffffff !important;
            font-family: 'League Spartan', sans-serif;
        }

        .iti__arrow {
            border-top-color: #94a3b8 !important;
        }

        @media (max-width: 767.98px) {
            .lira-form-section-head {
                margin-bottom: 14px;
            }

            .lira-form-section-head h3 {
                font-size: 0.95rem;
            }

            .lira-form-section-head p {
                font-size: 12px;
                line-height: 1.7;
            }

            .phone-wrap {
                overflow: visible !important;
            }

            .phone-wrap .iti__selected-country,
            .phone-wrap .iti__selected-country-primary {
                min-height: 50px;
                min-width: 84px;
                padding-inline: 12px !important;
            }

            .phone-wrap .iti input {
                min-height: 50px;
                padding-left: 100px !important;
                font-size: 15px;
            }

            .lira-register-submit-bar {
                position: static;
                inset: auto;
                z-index: auto;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                box-shadow: none;
            }

            .lira-register-submit-bar .lira-auth-submit {
                margin: 0 0 1rem !important;
            }
        }

        /* Syrian Revolution Flag Override */
        .iti__flag.iti__sy {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 900 600'%3E%3Cpath fill='%23000' d='M0 400h900v200H0z'/%3E%3Cpath fill='%23fff' d='M0 200h900v200H0z'/%3E%3Cpath fill='%23007a3d' d='M0 0h900v200H0z'/%3E%3Cg fill='%23ce1126'%3E%3Cpath d='M300 230l25.8 79.5h83.5l-67.6 49.1 25.8 79.5-67.5-49.1-67.6 49.1 25.8-79.5-67.5-49.1h83.5zM450 230l25.8 79.5h83.5l-67.6 49.1 25.8 79.5-67.5-49.1-67.6 49.1 25.8-79.5-67.5-49.1h83.5zM600 230l25.8 79.5h83.5l-67.6 49.1 25.8 79.5-67.5-49.1-67.6 49.1 25.8-79.5-67.5-49.1h83.5z'/%3E%3C/g%3E%3C/svg%3E") !important;
            background-position: center !important;
            background-size: cover !important;
        }
    </style>
@endpush

@push('custom_scripts')
    <!-- IntlTelInput CSS/JS Injection -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/intlTelInput.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const birthdateInput = document.getElementById('birthdate');
            let formatBirthdateValue = function (digits) {
                return digits;
            };

            if (birthdateInput) {
                const birthdateTemplate = 'MM/DD/YYYY';
                const birthdateSlots = [0, 1, 3, 4, 6, 7, 8, 9];
                const extractBirthdateDigits = function (value) {
                    return value.replace(/\D/g, '').substring(0, 8);
                };

                const buildBirthdateMask = function (digits) {
                    const chars = birthdateTemplate.split('');
                    birthdateSlots.forEach(function (slotIndex, digitIndex) {
                        if (digits[digitIndex]) {
                            chars[slotIndex] = digits[digitIndex];
                        }
                    });

                    return digits.length ? chars.join('') : '';
                };

                formatBirthdateValue = function (digits) {
                    let formatted = '';

                    if (digits.length > 0) {
                        formatted += digits.substring(0, Math.min(2, digits.length));
                    }
                    if (digits.length > 2) {
                        formatted += '/' + digits.substring(2, Math.min(4, digits.length));
                    }
                    if (digits.length > 4) {
                        formatted += '/' + digits.substring(4, 8);
                    }

                    return formatted;
                };

                const caretToDigitIndex = function (caretPosition) {
                    return birthdateSlots.filter(function (slot) {
                        return slot < caretPosition;
                    }).length;
                };

                const setBirthdateCaret = function (digitsLength) {
                    const nextSlot = digitsLength >= birthdateSlots.length
                        ? birthdateTemplate.length
                        : birthdateSlots[digitsLength];

                    window.requestAnimationFrame(function () {
                        birthdateInput.setSelectionRange(nextSlot, nextSlot);
                    });
                };

                const syncBirthdateMask = function (digits, moveCaret = true) {
                    const safeDigits = extractBirthdateDigits(digits);
                    birthdateInput.value = safeDigits.length ? buildBirthdateMask(safeDigits) : '';

                    if (moveCaret && document.activeElement === birthdateInput) {
                        setBirthdateCaret(safeDigits.length);
                    }
                };

                if (birthdateInput.value) {
                    syncBirthdateMask(birthdateInput.value, false);
                }

                birthdateInput.addEventListener('focus', function () {
                    const digits = extractBirthdateDigits(this.value);

                    if (!digits.length) {
                        this.value = birthdateTemplate;
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    syncBirthdateMask(digits);
                });

                birthdateInput.addEventListener('click', function () {
                    const digits = extractBirthdateDigits(this.value);
                    if (!digits.length) {
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    const digitIndex = Math.min(caretToDigitIndex(this.selectionStart ?? 0), digits.length);
                    setBirthdateCaret(digitIndex);
                });

                birthdateInput.addEventListener('keydown', function (event) {
                    const key = event.key;
                    const digits = extractBirthdateDigits(this.value);
                    const caretPosition = this.selectionStart ?? 0;
                    const digitIndex = caretToDigitIndex(caretPosition);

                    if (/^\d$/.test(key)) {
                        event.preventDefault();

                        if (digits.length >= 8) {
                            return;
                        }

                        const updatedDigits = (digits.slice(0, digitIndex) + key + digits.slice(digitIndex)).substring(0, 8);
                        syncBirthdateMask(updatedDigits, false);
                        setBirthdateCaret(Math.min(digitIndex + 1, updatedDigits.length));
                        return;
                    }

                    if (key === 'Backspace') {
                        event.preventDefault();

                        if (!digits.length) {
                            this.value = '';
                            return;
                        }

                        const removeIndex = Math.max(0, digitIndex - 1);
                        const updatedDigits = digits.slice(0, removeIndex) + digits.slice(removeIndex + 1);
                        syncBirthdateMask(updatedDigits, false);

                        if (!updatedDigits.length) {
                            this.value = '';
                            return;
                        }

                        setBirthdateCaret(removeIndex);
                        return;
                    }

                    if (key === 'Delete') {
                        event.preventDefault();

                        if (!digits.length) {
                            this.value = '';
                            return;
                        }

                        const updatedDigits = digits.slice(0, digitIndex) + digits.slice(digitIndex + 1);
                        syncBirthdateMask(updatedDigits, false);

                        if (!updatedDigits.length) {
                            this.value = '';
                            return;
                        }

                        setBirthdateCaret(Math.min(digitIndex, updatedDigits.length));
                        return;
                    }

                    if (key === 'ArrowLeft') {
                        event.preventDefault();
                        setBirthdateCaret(Math.max(0, digitIndex - 1));
                        return;
                    }

                    if (key === 'ArrowRight') {
                        event.preventDefault();
                        setBirthdateCaret(Math.min(digits.length, digitIndex + 1));
                        return;
                    }

                    if (key === 'Home') {
                        event.preventDefault();
                        this.setSelectionRange(0, 0);
                        return;
                    }

                    if (key === 'End') {
                        event.preventDefault();
                        setBirthdateCaret(digits.length);
                    }
                });

                birthdateInput.addEventListener('paste', function (event) {
                    event.preventDefault();
                    const pastedText = event.clipboardData?.getData('text') ?? '';
                    const digits = extractBirthdateDigits(pastedText);
                    syncBirthdateMask(digits, false);

                    if (digits.length) {
                        setBirthdateCaret(digits.length);
                    }
                });

                birthdateInput.addEventListener('input', function () {
                    const digits = extractBirthdateDigits(this.value);
                    syncBirthdateMask(digits);
                });

                birthdateInput.addEventListener('blur', function () {
                    const digits = extractBirthdateDigits(this.value);
                    this.value = digits.length ? buildBirthdateMask(digits) : '';
                });
            }

            // 1. Password Visibility Toggle
            document.querySelectorAll('.lira-password-toggle').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetSelector = btn.getAttribute('data-toggle-target');
                    if (!targetSelector) return;

                    const target = document.querySelector(targetSelector);
                    if (!target) return;

                    const isPassword = target.getAttribute('type') === 'password';
                    target.setAttribute('type', isPassword ? 'text' : 'password');
                    btn.innerHTML = isPassword
                        ? '<i class="fa-regular fa-eye-slash"></i>'
                        : '<i class="fa-regular fa-eye"></i>';
                });
            });

            // 2. IntlTelInput Package Initialization
            const phoneInputField = document.querySelector("#lira-phone");
            const hiddenCountryCode = document.querySelector("#hidden_country_code");
            const hiddenPhone = document.querySelector("#hidden_phone");
            const phoneError = document.querySelector("#phone-error");
            const countryBackdrop = document.createElement('div');
            countryBackdrop.className = 'lira-country-backdrop';
            document.body.appendChild(countryBackdrop);

            if (phoneInputField) {
                const iti = window.intlTelInput(phoneInputField, {
                    initialCountry: "sy",
                    separateDialCode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/utils.js",
                    onlyCountries: [
                        "sy", "sa", "ae", "eg", "iq", "jo", "qa", "kw", "lb", "dz", "ma",
                        "tn", "ly", "sd", "ye", "om", "bh", "ps", "mr", "so", "dj", "km"
                    ],
                    preferredCountries: ["sy", "sa", "ae", "eg", "iq"],
                });

                const closeCountrySheet = function () {
                    const list = document.querySelector('.iti__country-list');
                    if (list) {
                        list.classList.remove('mobile-country-sheet');
                        list.style.removeProperty('top');
                        list.style.removeProperty('left');
                        list.style.removeProperty('right');
                        list.style.removeProperty('bottom');
                        list.style.removeProperty('width');
                    }
                    countryBackdrop.classList.remove('is-visible');
                    document.body.style.removeProperty('overflow');
                };

                const openCountrySheet = function () {
                    if (window.innerWidth >= 768) {
                        return;
                    }

                    window.setTimeout(function () {
                        const list = document.querySelector('.iti__country-list');
                        if (!list || list.offsetParent === null) {
                            closeCountrySheet();
                            return;
                        }

                        list.classList.add('mobile-country-sheet');
                        countryBackdrop.classList.add('is-visible');
                        document.body.style.overflow = 'hidden';
                    }, 20);
                };

                // Strip non-digits as user types
                phoneInputField.addEventListener('input', function () {
                    const cleaned = phoneInputField.value.replace(/[^0-9]/g, '');
                    if (phoneInputField.value !== cleaned) {
                        phoneInputField.value = cleaned;
                    }
                    syncFields();
                });

                phoneInputField.addEventListener('countrychange', function () {
                    syncFields();
                    closeCountrySheet();
                });

                phoneInputField.closest('.phone-wrap')?.addEventListener('click', function (event) {
                    if (event.target.closest('.iti__selected-country')) {
                        openCountrySheet();
                    }
                });

                countryBackdrop.addEventListener('click', function () {
                    const activeTrigger = phoneInputField.closest('.phone-wrap')?.querySelector('.iti__selected-country');
                    activeTrigger?.click();
                    closeCountrySheet();
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeCountrySheet();
                    }
                });

                window.addEventListener('resize', function () {
                    if (window.innerWidth >= 768) {
                        closeCountrySheet();
                    }
                });

                function syncFields() {
                    // 1. Sync hidden fields
                    const countryData = iti.getSelectedCountryData();
                    const dialCode = countryData && countryData.dialCode ? '+' + countryData.dialCode : '+963';
                    hiddenCountryCode.value = dialCode;

                    let numberStr = phoneInputField.value.replace(/\D/g, '');
                    hiddenPhone.value = numberStr;

                    // 2. Quiet clear if valid (don't show errors while typing)
                    if (numberStr.length === 0 || iti.isValidNumber()) {
                        phoneInputField.setCustomValidity('');
                        hideError();
                        phoneInputField.classList.remove('is-invalid');
                        if (iti.isValidNumber()) phoneInputField.classList.add('is-valid');
                    } else {
                        // Just remove the valid state, don't show invalid yet
                        phoneInputField.classList.remove('is-valid');
                    }
                }

                function showError(msg) {
                    if (phoneError) {
                        phoneError.textContent = msg;
                        phoneError.classList.remove('d-none');
                        phoneError.classList.add('d-block');
                    }
                }

                function hideError() {
                    if (phoneError) {
                        phoneError.textContent = '';
                        phoneError.classList.remove('d-block');
                        phoneError.classList.add('d-none');
                    }
                }

                function showBrandToast(word) {
                    const container = document.getElementById('lira-toast-container');
                    if (!container) return;

                    const toast = document.createElement('div');
                    toast.className = 'lira-toast';
                    toast.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i><span>${word}</span>`;

                    container.appendChild(toast);
                    setTimeout(() => toast.remove(), 3200);
                }

                // Block form submission if phone is invalid
                const form = phoneInputField.closest('form');
                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (birthdateInput) {
                            const birthdateDigits = birthdateInput.value.replace(/\D/g, '').substring(0, 8);
                            birthdateInput.value = formatBirthdateValue(birthdateDigits);
                        }

                        syncFields();

                        if (!iti.isValidNumber()) {
                            // If empty, standard required takes over. 
                            // If not empty but invalid, show our custom toast.
                            if (phoneInputField.value.trim() !== '') {
                                e.preventDefault();
                                const msg = 'يرجى إدخال رقم موبايل صحيح';

                                // Show clear feedback ONLY on submit
                                showBrandToast(msg);
                                showError(msg);

                                phoneInputField.classList.add('is-invalid');
                                phoneInputField.focus();
                                phoneInputField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    });
                }

                // Initial sync
                syncFields();
            }
        });
    </script>
@endpush

