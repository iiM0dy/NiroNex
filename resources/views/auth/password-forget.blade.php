@extends(backendView('layouts.auth'))

@section('title', 'استعادة كلمة المرور')

@section('content')
    <section class="lira-auth-page">
        <div class="container">
            <div class="lira-auth-shell lira-forgot-shell">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="lira-auth-aside h-100">
                            <span class="lira-auth-badge">{{ brandAiName() }} · ACCOUNT RECOVERY</span>

                            <h1 class="lira-auth-heading">
                                استعادة الوصول إلى حسابك
                            </h1>

                            <p class="lira-auth-copy">
                                أدخل بريدك الإلكتروني المسجل وسنرسل لك رابطًا آمنًا لإعادة تعيين كلمة المرور والدخول من
                                جديد إلى حسابك.
                            </p>

                            <div class="lira-auth-points">
                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div>
                                        <strong>إرسال رابط الاستعادة</strong>
                                        <span>يتم إرسال رابط إعادة التعيين إلى بريدك الإلكتروني.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <strong>تحقق آمن</strong>
                                        <span>الرابط مخصص لحسابك ويساعد على حماية الوصول غير المصرح به.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </div>
                                    <div>
                                        <strong>العودة إلى {{ appName() }}</strong>
                                        <span>بعد تعيين كلمة مرور جديدة، يمكنك الدخول إلى لوحة التحكم مباشرة.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-auth-trust-row">
                                <span>Secure Recovery</span>
                                <span>Protected Access</span>
                                <span>Email Verification</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="lira-auth-form-wrap h-100">
                            <div class="lira-auth-form-head">
                                <h2>استعادة كلمة المرور</h2>
                                <p>أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين.</p>
                            </div>

                            @include('includes.messages')

                            <form method="POST" action="{{ route('password.email') }}" class="lira-auth-form">
                                @csrf

                                <div class="mb-4">
                                    <label class="lira-auth-label">البريد الإلكتروني</label>
                                    <div class="lira-input-wrap">
                                        <span class="lira-input-icon">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input
                                            name="email"
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="example@email.com"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                        >
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary lira-auth-submit w-100" type="submit">
                                    إرسال رابط الاستعادة
                                </button>

                                <div class="lira-auth-bottom">
                                    <span>تذكرت كلمة المرور؟</span>
                                    <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
                                </div>
                            </form>

                            @if (session('success'))
                                <div class="lira-resend-box">
                                    <div class="lira-resend-copy">
                                        <strong>لم يصلك البريد بعد؟</strong>
                                        <span>تحقق من البريد غير الهام أو أعد إرسال الرابط إلى نفس العنوان.</span>
                                    </div>

                                    <form action="{{ route('password.email') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ old('email') }}">
                                        <button class="btn btn-outline-primary" type="submit">
                                            إعادة الإرسال
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <div class="lira-auth-footer-note">
                                لأسباب أمنية، تأكد من استخدام البريد الإلكتروني المرتبط بحسابك في {{ appName() }}.
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
        .lira-forgot-shell .lira-auth-aside {
            padding: 34px 30px;
        }

        .lira-forgot-shell .lira-auth-form-wrap {
            padding: 38px 36px;
        }

        .lira-resend-box {
            margin-top: 22px;
            padding: 16px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            flex-wrap: wrap;
        }

        .lira-resend-copy strong {
            display: block;
            color: var(--lira-auth-text);
            font-size: 13px;
            margin-bottom: 4px;
        }

        .lira-resend-copy span {
            color: var(--lira-auth-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        @media (max-width: 991.98px) {
            .lira-forgot-shell .lira-auth-aside,
            .lira-forgot-shell .lira-auth-form-wrap {
                padding: 28px 22px;
            }
        }

        @media (max-width: 575.98px) {
            .lira-forgot-shell .lira-auth-aside,
            .lira-forgot-shell .lira-auth-form-wrap {
                padding: 22px 18px;
            }

            .lira-resend-box {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush
