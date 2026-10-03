@extends(backendView('layouts.auth'))

@section('title', 'تسجيل الدخول')

@section('content')
    <section class="lira-auth-page">
        <div class="container">
            <div class="lira-auth-shell">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="lira-auth-aside h-100">
                            <span class="lira-auth-badge">{{ brandAiName() }} · TRADING</span>

                            <h1 class="lira-auth-heading">
                                دخول آمن إلى منصة تداول بالذكاء الاصطناعي
                            </h1>

                            <p class="lira-auth-copy">
                                تابع الرصيد، نشاط الحساب، والإشعارات التنفيذية من لوحة واحدة بهوية واضحة وتجربة استخدام هادئة.
                            </p>

                            <div class="lira-auth-points">
                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7727.svg') }}" alt="Chart" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>مراقبة XAUUSD</strong>
                                        <span>واجهة موحدة لمتابعة الذهب والتنبيهات والنتائج.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7725.svg') }}" alt="Shield" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>وصول آمن</strong>
                                        <span>جلسة محمية وطبقة تحقق للحساب والهوية.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <img src="{{ asset('assets/images/icons/IMG_7726.svg') }}" alt="Lightning" style="width: 24px; height: 24px; object-fit: contain;">
                                    </div>
                                    <div>
                                        <strong>جاهزية تشغيل</strong>
                                        <span>ربط واضح بين الخطط، الرصيد، ومحرك {{ brandAiName() }}.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-auth-trust-row">
                                <span>Premium Dashboard</span>
                                <span>KYC Ready</span>
                                <span>Secure Session</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="lira-auth-form-wrap h-100">
                            <div class="lira-auth-form-head">
                                <h2>تسجيل الدخول</h2>
                                <p>أدخل بياناتك للوصول إلى منصة {{ appName() }}.</p>
                            </div>

                            @include('includes.messages')

                            <form method="POST" action="{{ route('login') }}" class="lira-auth-form">
                                @csrf

                                <div class="mb-4">
                                    <label class="lira-auth-label">البريد الإلكتروني أو رقم الهاتف</label>
                                    <div class="lira-input-wrap">
                                        <span class="lira-input-icon">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input
                                            name="identifier"
                                            type="text"
                                            class="form-control @error('identifier') is-invalid @enderror"
                                            placeholder="البريد الإلكتروني أو 9639XXXXXXXX"
                                            value="{{ old('identifier') }}"
                                            required
                                            autofocus
                                        >
                                    </div>
                                    @error('identifier')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="lira-auth-label">كلمة المرور</label>
                                    <div class="lira-input-wrap">
                                        <span class="lira-input-icon">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input
                                            id="loginPassword"
                                            name="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="••••••••"
                                            required
                                        >
                                        <button type="button" class="lira-password-toggle" id="togglePassword">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="lira-auth-row mb-4">
                                    <div class="form-check lira-remember-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="remember"
                                            id="remember"
                                            {{ old('remember') ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="remember">
                                            تذكّرني
                                        </label>
                                    </div>

                                    <a href="{{ route('password.request') }}" class="lira-auth-link">
                                        هل نسيت كلمة المرور؟
                                    </a>
                                </div>

                                <button class="btn btn-primary lira-auth-submit w-100" type="submit">
                                    دخول إلى المنصة
                                </button>

                                <div class="lira-auth-bottom">
                                    <span>ليس لديك حساب بعد؟</span>
                                    <a href="{{ route('register') }}">إنشاء حساب جديد</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom_styles')
    <style>
        :root {
            --lira-auth-bg: #07090d;
            --lira-auth-surface: #10141c;
            --lira-auth-surface-2: #131925;
            --lira-auth-border: #222a36;
            --lira-auth-text: #f7f8fa;
            --lira-auth-text-soft: #c5cad3;
            --lira-auth-text-muted: #8d96a5;
            --lira-auth-gold: #00e6a7;
            --lira-auth-gold-soft: rgba(0, 230, 167, 0.10);
        }

        .lira-auth-page {
            padding: 56px 0 72px;
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.08), transparent 22%),
                linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0)),
                transparent;
        }

        .lira-auth-shell {
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background:
                linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.008)),
                var(--lira-auth-surface);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.28);
        }

        .lira-auth-aside {
            height: 100%;
            padding: 36px 32px;
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.08), transparent 35%),
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                var(--lira-auth-surface-2);
            border-inline-start: 1px solid rgba(255,255,255,0.04);
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
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .lira-auth-heading {
            margin: 24px 0 12px;
            color: var(--lira-auth-text);
            font-size: clamp(1.8rem, 2.3vw, 2.5rem);
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
            border-bottom: 1px solid rgba(255,255,255,0.04);
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

        .lira-auth-trust-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .lira-auth-trust-row span {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            color: var(--lira-auth-text-soft);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-auth-form-wrap {
            padding: 40px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100%;
        }

        .lira-auth-form-head {
            margin-bottom: 28px;
        }

        .lira-auth-form-head h2 {
            margin-bottom: 8px;
            color: var(--lira-auth-text);
            font-size: 1.7rem;
            font-weight: 800;
        }

        .lira-auth-form-head p {
            margin: 0;
            color: var(--lira-auth-text-muted);
            font-size: 14px;
        }

        .lira-auth-form {
            width: 100%;
        }

        .lira-auth-label {
            display: block;
            margin-bottom: 10px;
            color: var(--lira-auth-text-soft);
            font-size: 13px;
            font-weight: 700;
        }

        .lira-input-wrap {
            position: relative;
        }

        .lira-input-wrap .form-control {
            height: 54px;
            padding-inline-start: 48px;
            padding-inline-end: 48px;
            border-radius: 16px;
            background: var(--lira-auth-surface-2) !important;
            border: 1px solid var(--lira-auth-border) !important;
            color: var(--lira-auth-text) !important;
            box-shadow: none !important;
        }

        .lira-input-wrap .form-control::placeholder {
            color: #778191;
        }

        .lira-input-wrap .form-control:focus {
            border-color: rgba(0, 230, 167, 0.45) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.08) !important;
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
            background: rgba(255,255,255,0.03);
        }

        .lira-auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        .lira-remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 24px;
        }

        .lira-remember-check .form-check-input {
            margin: 0;
            float: none;
            background-color: var(--lira-auth-surface-2);
            border-color: var(--lira-auth-border);
        }

        .lira-remember-check .form-check-input:checked {
            background-color: var(--lira-auth-gold);
            border-color: var(--lira-auth-gold);
        }

        .lira-remember-check .form-check-label {
            color: var(--lira-auth-text-soft);
            font-size: 13px;
            cursor: pointer;
        }

        .lira-auth-link {
            color: var(--lira-auth-gold);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .lira-auth-link:hover {
            color: #38bdf8;
        }

        .lira-auth-submit {
            height: 54px;
            border-radius: 16px !important;
            font-size: 15px;
            font-weight: 800;
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
            color: var(--lira-auth-gold);
            font-weight: 700;
            text-decoration: none;
        }


        @media (max-width: 991.98px) {
            .lira-auth-page {
                padding: 28px 0 48px;
            }

            .lira-auth-aside,
            .lira-auth-form-wrap {
                padding: 28px 22px;
            }

            .lira-auth-aside {
                border-inline-start: 0;
                border-bottom: 1px solid rgba(255,255,255,0.04);
            }
        }

        @media (max-width: 575.98px) {
            .lira-auth-page {
                padding: 18px 0 36px;
                align-items: flex-start;
            }

            .lira-auth-shell {
                border-radius: 22px;
            }

            .lira-auth-heading {
                font-size: 1.55rem;
            }

            .lira-auth-form-head h2 {
                font-size: 1.45rem;
            }

            .lira-auth-aside,
            .lira-auth-form-wrap {
                padding: 22px 18px;
            }

            .lira-auth-row {
                align-items: center;
                flex-direction: row;
                justify-content: space-between;
                gap: 12px;
                flex-wrap: wrap;
            }

            .lira-remember-check {
                margin-bottom: 0;
            }

            .lira-auth-link {
                min-height: 40px;
                display: inline-flex;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .lira-auth-shell {
                border-radius: 18px;
            }

            .lira-auth-form-wrap {
                padding: 20px 16px;
            }

            .lira-auth-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
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
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('loginPassword');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleBtn.innerHTML = isPassword
                        ? '<i class="fa-regular fa-eye-slash"></i>'
                        : '<i class="fa-regular fa-eye"></i>';
                });
            }
        });
    </script>
@endpush

