@extends(backendView('layouts.auth'))

@section('title', 'تعيين كلمة مرور جديدة')

@section('content')
    <section class="lira-auth-page">
        <div class="container">
            <div class="lira-auth-shell lira-reset-shell">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="lira-auth-aside h-100">
                            <span class="lira-auth-badge">{{ brandAiName() }} · PASSWORD RESET</span>

                            <h1 class="lira-auth-heading">
                                أنشئ كلمة مرور جديدة لحسابك
                            </h1>

                            <p class="lira-auth-copy">
                                أنت الآن في الخطوة الأخيرة لاستعادة الوصول إلى حسابك. أدخل بريدك الإلكتروني وكلمة المرور
                                الجديدة لتأمين الحساب والعودة إلى لوحة {{ appName() }}.
                            </p>

                            <div class="lira-auth-points">
                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-regular fa-envelope"></i>
                                    </div>
                                    <div>
                                        <strong>تأكيد هوية الحساب</strong>
                                        <span>استخدم نفس البريد الإلكتروني المرتبط بحسابك في المنصة.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <div>
                                        <strong>كلمة مرور جديدة</strong>
                                        <span>اختر كلمة مرور قوية وسهلة التذكر بالنسبة لك فقط.</span>
                                    </div>
                                </div>

                                <div class="lira-auth-point">
                                    <div class="lira-auth-point-icon">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </div>
                                    <div>
                                        <strong>العودة إلى {{ appName() }}</strong>
                                        <span>بعد الحفظ يمكنك تسجيل الدخول فوراً ومتابعة حسابك بشكل طبيعي.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="lira-auth-trust-row">
                                <span>Secure Reset</span>
                                <span>Protected Access</span>
                                <span>Account Recovery</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="lira-auth-form-wrap h-100">
                            <div class="lira-auth-form-head">
                                <h2>تعيين كلمة مرور جديدة</h2>
                                <p>أدخل بياناتك أدناه لتحديث كلمة المرور.</p>
                            </div>

                            @include('includes.messages')

                            <form method="POST" action="{{ route('password.update') }}" class="lira-auth-form">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

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
                                            value="{{ old('email', request('email')) }}"
                                            required
                                            autofocus
                                        >
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="lira-auth-label">كلمة المرور الجديدة</label>
                                    <div class="lira-input-wrap">
                                        <span class="lira-input-icon">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input
                                            id="resetPassword"
                                            name="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="••••••••"
                                            required
                                        >
                                        <button type="button" class="lira-password-toggle" data-toggle-target="#resetPassword">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="lira-auth-label">تأكيد كلمة المرور</label>
                                    <div class="lira-input-wrap">
                                        <span class="lira-input-icon">
                                            <i class="fa-solid fa-shield-halved"></i>
                                        </span>
                                        <input
                                            id="resetPasswordConfirmation"
                                            name="password_confirmation"
                                            type="password"
                                            class="form-control"
                                            placeholder="••••••••"
                                            required
                                        >
                                        <button type="button" class="lira-password-toggle" data-toggle-target="#resetPasswordConfirmation">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button class="btn btn-primary lira-auth-submit w-100" type="submit">
                                    تحديث كلمة المرور
                                </button>

                                <div class="lira-auth-bottom">
                                    <span>تذكرت كلمة المرور القديمة أو تريد العودة؟</span>
                                    <a href="{{ route('login') }}">الرجوع لتسجيل الدخول</a>
                                </div>
                            </form>

                            <div class="lira-auth-footer-note">
                                بعد تحديث كلمة المرور تأكد من استخدامها فقط على جهازك الشخصي وعدم مشاركتها مع أي طرف آخر.
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
        .lira-reset-shell .lira-auth-aside {
            padding: 34px 30px;
        }

        .lira-reset-shell .lira-auth-form-wrap {
            padding: 38px 36px;
        }

        @media (max-width: 991.98px) {
            .lira-reset-shell .lira-auth-aside,
            .lira-reset-shell .lira-auth-form-wrap {
                padding: 28px 22px;
            }
        }

        @media (max-width: 575.98px) {
            .lira-reset-shell .lira-auth-aside,
            .lira-reset-shell .lira-auth-form-wrap {
                padding: 22px 18px;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-toggle-target]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const target = document.querySelector(btn.getAttribute('data-toggle-target'));
                    if (!target) return;

                    const isPassword = target.getAttribute('type') === 'password';
                    target.setAttribute('type', isPassword ? 'text' : 'password');
                    btn.innerHTML = isPassword
                        ? '<i class="fa-regular fa-eye-slash"></i>'
                        : '<i class="fa-regular fa-eye"></i>';
                });
            });
        });
    </script>
@endpush
