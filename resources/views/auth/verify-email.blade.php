@extends(backendView('layouts.auth'))

@section('title', 'تأكيد البريد الإلكتروني')

@section('content')
    <section class="lira-auth-page">
        <div class="container">
            <div class="lira-auth-shell lira-verify-shell">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="lira-auth-aside h-100">
                            <span class="lira-auth-badge">{{ brandAiName() }} · EMAIL VERIFICATION</span>

                            <h1 class="lira-auth-heading">
                                فعّل بريدك الإلكتروني لإكمال الوصول إلى المنصة
                            </h1>

                            <p class="lira-auth-copy">
                                تم إنشاء حسابك بنجاح. الخطوة التالية هي تأكيد البريد الإلكتروني حتى يتم تفعيل الوصول الكامل
                                إلى بيئة {{ appName() }} ومتابعة الإيداع ولوحة التحكم.
                            </p>

                            <div class="lira-auth-points">
                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div>
                                        <strong>تحقق من بريدك الوارد</strong>
                                        <span>افتح الرسالة المرسلة إلى بريدك واضغط على رابط التفعيل.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <strong>تأمين الحساب</strong>
                                        <span>التفعيل يساعد في حماية الوصول ويضمن ربط الحساب بعنوان بريد صحيح.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </div>
                                    <div>
                                        <strong>الانتقال إلى {{ appName() }}</strong>
                                        <span>بعد التحقق سيتم السماح لك بمتابعة تفعيل الحساب واستخدام المنصة.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-auth-trust-row">
                                <span>Secure Verification</span>
                                <span>Email Protected</span>
                                <span>Account Activation</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="lira-auth-form-wrap h-100">
                            <div class="lira-auth-form-head">
                                <h2>تأكيد البريد الإلكتروني</h2>
                                <p>يرجى فتح بريدك الإلكتروني والنقر على رابط التحقق لإكمال تفعيل الحساب.</p>
                            </div>

                            @include('includes.messages')

                            <div class="lira-verify-card">
                                <div class="lira-verify-icon">
                                    <i class="fa-regular fa-envelope-open"></i>
                                </div>

                                <h4>تم إرسال رسالة التفعيل</h4>
                                <p>
                                    أرسلنا رسالة تأكيد إلى بريدك الإلكتروني. إن لم تجدها في البريد الوارد، راجع مجلد الرسائل
                                    غير الهامة أو أعد إرسال الرابط.
                                </p>

                                @if (is_null(session('resendLink')))
                                    <div class="lira-verify-alert is-danger">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>تعذر إنشاء رابط إعادة الإرسال حالياً. حاول بعد قليل.</span>
                                    </div>
                                @endif

                                @if (session('status') == 'verification-link-sent')
                                    <div class="lira-verify-alert is-success">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.</span>
                                    </div>
                                @endif

                                @if (!is_null(session('resendLink')))
                                    <form method="POST" action="{{ session('resendLink') }}" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-primary lira-auth-submit w-100">
                                            إعادة إرسال رابط التحقق
                                        </button>
                                    </form>
                                @endif

                                <div class="lira-auth-bottom mt-4">
                                    <span>هل تود العودة؟</span>
                                    <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
                                </div>
                            </div>

                            <div class="lira-auth-footer-note">
                                لأسباب أمنية، لن يتم تفعيل الوصول الكامل إلى الحساب قبل التحقق من البريد الإلكتروني.
                            </div>
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

        .lira-auth-submit {
            height: 54px;
            border-radius: 16px !important;
            font-size: 15px;
            font-weight: 800;
            background: linear-gradient(180deg, var(--lira-accent-strong, #38bdf8), var(--lira-accent, #00e6a7)) !important;
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
            color: var(--lira-auth-gold, #00e6a7);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .lira-auth-bottom a:hover {
            color: var(--lira-auth-gold-strong, #38bdf8);
            text-decoration: underline;
        }

        .lira-auth-footer-note {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid rgba(255,255,255,0.05);
            color: var(--lira-auth-text-muted);
            font-size: 12px;
            line-height: 1.8;
            text-align: center;
        }

        .lira-verify-shell .lira-auth-aside {
            padding: 34px 30px;
        }

        .lira-verify-shell .lira-auth-form-wrap {
            padding: 38px 36px;
        }

        .lira-verify-card {
            width: 100%;
            padding: 28px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01)), var(--lira-auth-surface-2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .lira-verify-icon {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-auth-gold);
            font-size: 28px;
            margin-bottom: 18px;
        }

        .lira-verify-card h4 {
            margin-bottom: 10px;
            color: var(--lira-auth-text);
            font-size: 1.2rem;
            font-weight: 800;
        }

        .lira-verify-card p {
            margin: 0 0 20px;
            color: var(--lira-auth-text-muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 520px;
        }

        .lira-verify-alert {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: right;
            padding: 14px 16px;
            border-radius: 16px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 700;
        }

        .lira-verify-alert i {
            flex: 0 0 auto;
        }

        .lira-verify-alert.is-success {
            background: rgba(23, 178, 106, 0.10);
            border: 1px solid rgba(23, 178, 106, 0.18);
            color: #5fe2a1;
        }

        .lira-verify-alert.is-danger {
            background: rgba(240, 68, 56, 0.10);
            border: 1px solid rgba(240, 68, 56, 0.18);
            color: #ff8a80;
        }

        @media (max-width: 991.98px) {
            .lira-verify-shell .lira-auth-aside,
            .lira-verify-shell .lira-auth-form-wrap {
                padding: 28px 22px;
            }
        }

        @media (max-width: 575.98px) {
            .lira-verify-shell .lira-auth-aside,
            .lira-verify-shell .lira-auth-form-wrap {
                padding: 22px 18px;
            }

            .lira-verify-card {
                padding: 22px 18px;
                border-radius: 20px;
            }
        }
    </style>
@endpush

