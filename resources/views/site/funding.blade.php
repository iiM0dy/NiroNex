@extends('layouts.site-dash')

@section('title', 'إيداع الأموال')

@section('content')
    @php
        $depositMethods = App\Enums\TransactionRequestMethod::depositMethods();
        $shamCashAccount = env('SHAMCASH_ACCOUNT') ?: (env('WHATSAPP_NUMBER') ?: env('SUPPORT_EMAIL'));
        $isDemoAccount = auth()->user()?->isDemoAccount() ?? false;
    @endphp

    <div class="lira-funding-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">FUNDING · DEPOSIT REQUEST</span>
                <h1 class="lira-page-title">إرسال طلب إيداع جديد</h1>
                <p class="lira-page-subtitle">
                    اختر مبلغ الإيداع، وسيلة الدفع، ثم أرفق صورة إثبات التحويل. بعد قبول الطلب سيضاف الرصيد إلى محفظتك خلال 15 دقيقة.
                </p>
            </div>
        </div>

        @if($isDemoAccount)
            <div class="alert alert-warning mb-4">
                حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لإرسال طلبات الإيداع.
            </div>
        @endif

        <div class="row g-3">
            <div class="col-xl-8">
                <form method="POST" action="{{ route('site.deposit') }}" enctype="multipart/form-data" class="d-flex flex-column gap-3" id="fundingDepositForm">
                    @csrf

                    <div class="card lira-funding-card">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">مبلغ الإيداع</h6>
                                <p class="text-muted mb-0 small">أدخل المبلغ الذي تريد إضافته إلى محفظتك الرئيسية.</p>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <label for="fundingAmountInput" class="lira-funding-label">المبلغ بالدولار</label>
                            <div class="lira-funding-money">
                                <span>$</span>
                                <input
                                    id="fundingAmountInput"
                                    name="amount"
                                    type="number"
                                    step="0.01"
                                    min="20"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}"
                                    placeholder="0.00"
                                    required
                                >
                            </div>

                            <div class="lira-funding-range">
                                <span>الحد الأدنى: $20.00</span>
                                <span>سيكون الرصيد متاحاً في المحفظة بعد موافقة الإدارة.</span>
                            </div>

                            <div class="alert alert-warning d-none mt-3 mb-0" id="fundingMinimumAlert">
                                الحد الأدنى للإيداع هو 20 دولار. يرجى إدخال مبلغ 20 دولار أو أكثر.
                            </div>

                            @error('amount')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card lira-funding-card">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">وسيلة الدفع</h6>
                                <p class="text-muted mb-0 small">اختر وسيلة التحويل التي ستستخدمها ثم انسخ بيانات الدفع المرتبطة بها.</p>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                @foreach ($depositMethods as $method)
                                    <div class="col-md-6">
                                        <label class="lira-funding-method">
                                            <input
                                                class="d-none funding-method-input"
                                                type="radio"
                                                name="payment_method"
                                                value="{{ $method->value }}"
                                                data-wallet-target="{{ $method->getWalletTarget() }}"
                                                {{ old('payment_method') === $method->value ? 'checked' : '' }}
                                                required
                                            >

                                            <div class="lira-funding-method__box">
                                                <div class="lira-funding-method__icon">
                                                    <i class="fa-solid fa-wallet"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $method->getName() }}</strong>
                                                    <span>اختيار وسيلة الإيداع المعتمدة</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('payment_method')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror

                            <div id="wallet-info-trc20" class="lira-funding-wallet d-none mt-3">
                                <div class="lira-funding-wallet__head">
                                    <strong>عنوان محفظة USDT (TRC20)</strong>
                                    <span>انسخ هذا العنوان ثم نفذ التحويل.</span>
                                </div>
                                <div class="lira-funding-wallet__row">
                                    <input id="wallet-trc20-address" type="text" readonly value="{{ env('USDTTRC20') }}">
                                    <button type="button" class="btn btn-outline-primary" data-copy-target="wallet-trc20-address">نسخ</button>
                                </div>
                            </div>

                            <div id="wallet-info-erc20" class="lira-funding-wallet d-none mt-3">
                                <div class="lira-funding-wallet__head">
                                    <strong>عنوان محفظة USDT (ERC20)</strong>
                                    <span>انسخ هذا العنوان ثم نفذ التحويل.</span>
                                </div>
                                <div class="lira-funding-wallet__row">
                                    <input id="wallet-erc20-address" type="text" readonly value="{{ env('USDTERC20') }}">
                                    <button type="button" class="btn btn-outline-primary" data-copy-target="wallet-erc20-address">نسخ</button>
                                </div>
                            </div>

                            <div id="wallet-info-shamcash" class="lira-funding-wallet d-none mt-3">
                                <div class="lira-funding-wallet__head">
                                    <strong>بيانات تحويل ShamCash</strong>
                                    <span>استخدم الحساب التالي للتحويل ثم أرفق الإثبات.</span>
                                </div>
                                <div class="lira-funding-wallet__row">
                                    <input id="wallet-shamcash-account" type="text" readonly value="{{ $shamCashAccount }}">
                                    <button type="button" class="btn btn-outline-primary" data-copy-target="wallet-shamcash-account">نسخ</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-funding-card">
                        <div class="card-header border-0">
                            <div>
                                <h6 class="mb-1">إثبات الدفع</h6>
                                <p class="text-muted mb-0 small">أرفق صورة واضحة لإشعار التحويل أو العملية المكتملة.</p>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <label class="lira-funding-upload" for="fundingProofInput">
                                <input
                                    id="fundingProofInput"
                                    name="payment_proof"
                                    type="file"
                                    accept="image/*"
                                    class="d-none"
                                    required
                                >

                                <div class="lira-funding-upload__icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <strong id="fundingFileName">اضغط لرفع صورة إثبات الدفع</strong>
                                <span>JPG / PNG / JPEG</span>
                            </label>

                            @error('payment_proof')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-between lira-funding-actions">
                        <a href="{{ route('site.wallet') }}" class="btn lira-outline-action px-4 py-3">
                            <i class="fa-solid fa-wallet ms-2"></i>
                            المحفظة
                        </a>

                        <button type="submit" class="btn btn-primary px-4 py-3">
                            {{ $isDemoAccount ? 'حساب ديمو' : 'إرسال طلب الإيداع' }}
                            <i class="fa-solid fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-xl-4">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-funding-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">بعد إضافة الرصيد</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="lira-funding-guide">
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-chart-line"></i>
                                    <span>يمكنك تحويل جزء من الرصيد إلى محفظة التداول الحقيقي.</span>
                                </div>
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-robot"></i>
                                    <span>يمكنك تخصيص جزء من الرصيد للروبوت.</span>
                                </div>
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <span>يمكنك الاشتراك في خطة استثمار من صفحة الخطط.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-funding-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملاحظات مهمة</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="lira-funding-guide">
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>سيتم إضافة الرصيد إلى المحفظة بعد مراجعة إثبات الدفع.</span>
                                </div>
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>استخدم نفس وسيلة الدفع التي سترفع إثباتها داخل الطلب.</span>
                                </div>
                                <div class="lira-funding-guide__item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>يمكنك متابعة حالة الطلب من صفحة طلبات المعاملات.</span>
                                </div>
                            </div>

                            <a href="{{ route('site.transactions-requests.index') }}" class="btn btn-outline-primary w-100 mt-3">
                                متابعة الطلبات السابقة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-funding-card {
            border: 1px solid rgba(255, 255, 255, 0.06);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.012));
        }

        .lira-funding-label {
            display: block;
            margin-bottom: 10px;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-funding-money {
            height: 62px;
            padding: 0 18px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .lira-funding-money span {
            color: var(--lira-accent);
            font-size: 22px;
            font-weight: 900;
        }

        .lira-funding-money input {
            border: 0;
            outline: 0;
            background: transparent;
            color: #fff;
            font-size: 24px;
            font-weight: 900;
            box-shadow: none !important;
            padding: 0;
        }

        .lira-funding-range {
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-funding-method {
            display: block;
            margin: 0;
            cursor: pointer;
        }

        .lira-funding-method__box {
            padding: 16px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.026);
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: 0.2s ease;
        }

        .lira-funding-method__icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            font-size: 16px;
            flex: 0 0 auto;
        }

        .lira-funding-method__box strong {
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .lira-funding-method__box span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .funding-method-input:checked + .lira-funding-method__box {
            border-color: rgba(0, 230, 167, 0.36);
            box-shadow: 0 0 0 3px rgba(0, 230, 167, 0.12);
        }

        .lira-funding-wallet {
            padding: 16px;
            border-radius: 18px;
            background: rgba(0, 230, 167, 0.05);
            border: 1px dashed rgba(0, 230, 167, 0.22);
        }

        .lira-funding-wallet__head {
            margin-bottom: 12px;
        }

        .lira-funding-wallet__head strong {
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .lira-funding-wallet__head span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-funding-wallet__row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lira-funding-wallet__row input {
            flex: 1 1 auto;
            height: 48px;
            padding: 0 14px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(7, 11, 18, 0.62);
            color: #fff;
            direction: ltr;
        }

        .lira-funding-upload {
            min-height: 190px;
            padding: 22px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
            background: rgba(255, 255, 255, 0.025);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: 0.2s ease;
        }

        .lira-funding-upload:hover {
            border-color: rgba(0, 230, 167, 0.3);
            background: rgba(0, 230, 167, 0.03);
        }

        .lira-funding-upload__icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            font-size: 24px;
        }

        .lira-funding-upload strong {
            font-size: 15px;
        }

        .lira-funding-upload span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-funding-summary {
            margin-bottom: 14px;
        }

        .lira-funding-summary span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .lira-funding-summary strong {
            display: block;
            font-size: 1.35rem;
            font-weight: 900;
        }

        .lira-funding-summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-funding-summary-mini {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-funding-summary-mini span {
            display: block;
            margin-bottom: 5px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-funding-summary-mini strong {
            display: block;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-funding-guide {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-funding-guide__item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--lira-text-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .lira-funding-guide__item i {
            margin-top: 3px;
            color: #63ddab;
        }

        .lira-outline-action {
            border: 1px solid rgba(0, 230, 167, 0.32) !important;
            background: rgba(0, 230, 167, 0.1) !important;
            color: var(--lira-accent) !important;
            font-weight: 700;
        }

        .lira-outline-action:hover,
        .lira-outline-action:focus {
            background: rgba(0, 230, 167, 0.18) !important;
            border-color: rgba(0, 230, 167, 0.48) !important;
            color: #f5d979 !important;
            box-shadow: none !important;
        }

        .lira-outline-action i {
            color: currentColor !important;
        }

        @media (max-width: 767.98px) {
            .lira-funding-wallet__row {
                flex-direction: column;
            }

            .lira-funding-wallet__row button {
                width: 100%;
            }

            .lira-funding-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .lira-funding-upload {
                min-height: 140px;
                padding: 18px 16px;
            }

            .lira-funding-actions > .btn,
            .lira-funding-actions > a {
                width: 100%;
                justify-content: center;
            }

            .lira-funding-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const depositForm = document.getElementById('fundingDepositForm');
            const amountInput = document.getElementById('fundingAmountInput');
            const minimumAlert = document.getElementById('fundingMinimumAlert');
            const methodInputs = document.querySelectorAll('.funding-method-input');
            const trc20Box = document.getElementById('wallet-info-trc20');
            const erc20Box = document.getElementById('wallet-info-erc20');
            const shamCashBox = document.getElementById('wallet-info-shamcash');
            const fileInput = document.getElementById('fundingProofInput');
            const fileName = document.getElementById('fundingFileName');

            function showMinimumAlert() {
                minimumAlert?.classList.remove('d-none');
                amountInput?.focus();
            }

            function hideMinimumAlert() {
                minimumAlert?.classList.add('d-none');
            }

            function isBelowMinimumDeposit() {
                return parseFloat(amountInput?.value || 0) < 20;
            }

            depositForm?.addEventListener('submit', event => {
                if (isBelowMinimumDeposit()) {
                    event.preventDefault();
                    showMinimumAlert();
                }
            });

            amountInput?.addEventListener('input', () => {
                if (!isBelowMinimumDeposit()) {
                    hideMinimumAlert();
                }
            });

            amountInput?.addEventListener('invalid', () => {
                if (isBelowMinimumDeposit()) {
                    showMinimumAlert();
                }
            });

            function toggleWalletInfo() {
                const activeMethod = document.querySelector('.funding-method-input:checked')?.value;

                trc20Box?.classList.toggle('d-none', activeMethod !== '{{ \App\Enums\TransactionRequestMethod::USDT_TRC20->value }}');
                erc20Box?.classList.toggle('d-none', activeMethod !== '{{ \App\Enums\TransactionRequestMethod::USDT_ERC20->value }}');
                shamCashBox?.classList.toggle('d-none', activeMethod !== '{{ \App\Enums\TransactionRequestMethod::ShamCash->value }}');
            }

            methodInputs.forEach(input => {
                input.addEventListener('change', toggleWalletInfo);
            });

            fileInput?.addEventListener('change', () => {
                const selectedFile = fileInput.files?.[0]?.name;
                if (selectedFile && fileName) {
                    fileName.textContent = selectedFile;
                }
            });

            document.querySelectorAll('[data-copy-target]').forEach(button => {
                button.addEventListener('click', async () => {
                    const targetId = button.getAttribute('data-copy-target');
                    const targetInput = targetId ? document.getElementById(targetId) : null;
                    if (!targetInput) return;

                    try {
                        await navigator.clipboard.writeText(targetInput.value);
                        button.textContent = 'تم النسخ';
                        window.setTimeout(() => {
                            button.textContent = 'نسخ';
                        }, 1200);
                    } catch (_) {
                        targetInput.select();
                        document.execCommand('copy');
                    }
                });
            });

            toggleWalletInfo();
        });
    </script>
@endpush

