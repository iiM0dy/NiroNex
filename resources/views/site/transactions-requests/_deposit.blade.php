@php
    $depositMethods = \App\Enums\TransactionRequestMethod::depositMethods();
    $selectedMethod = (int) old('method', $depositMethods[0]->value ?? \App\Enums\TransactionRequestMethod::USDT_TRC20->value);
    $shamCashAccount = env('SHAMCASH_ACCOUNT') ?: (env('WHATSAPP_NUMBER') ?: env('SUPPORT_EMAIL'));
    $paymentTargets = [
        \App\Enums\TransactionRequestMethod::USDT_TRC20->value => [
            'id' => 'usdttrc20',
            'title' => 'عنوان محفظة USDT (TRC-20)',
            'value' => env('USDTTRC20'),
            'hint' => 'استخدم شبكة TRC-20 فقط لهذا العنوان.',
        ],
        \App\Enums\TransactionRequestMethod::USDT_ERC20->value => [
            'id' => 'usdterc20',
            'title' => 'عنوان محفظة USDT (ERC-20)',
            'value' => env('USDTERC20'),
            'hint' => 'استخدم شبكة ERC-20 فقط لهذا العنوان.',
        ],
        \App\Enums\TransactionRequestMethod::ShamCash->value => [
            'id' => 'shamcash',
            'title' => 'بيانات تحويل ShamCash',
            'value' => $shamCashAccount,
            'hint' => 'أرفق إشعار التحويل بعد إتمام العملية.',
        ],
    ];
@endphp

<div class="lira-page-header animate__animated animate__fadeIn">
    <div>
        <span class="lira-eyebrow">TRANSFERS · TOP UP</span>
        <h1 class="lira-page-title">طلب إيداع جديد</h1>
        <p class="lira-page-subtitle">اشحن رصيدك بسهولة لبدء التداول والاستفادة من إمكانات {{ brandAiName() }}.</p>
    </div>
</div>

<form action="{{ route('site.transactions-requests.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{ App\Enums\TransactionRequestType::Deposit->value }}">

    <div class="lira-transfer-layout">
        <section class="card lira-transfer-card">
            <div class="card-body">
                <div class="lira-form-section">
                    <div class="lira-section-heading">
                        <span>01</span>
                        <div>
                            <h2>تفاصيل الإيداع</h2>
                            <p>حدد المبلغ وطريقة التحويل ثم أرفق الإشعار.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-5">
                            <label class="form-label" for="deposit-amount">المبلغ المراد إيداعه</label>
                            <div class="lira-input-wrap">
                                <i class="fas fa-dollar-sign lira-input-icon"></i>
                                <input
                                    id="deposit-amount"
                                    name="amount"
                                    type="number"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    placeholder="20.00"
                                    value="{{ old('amount') }}"
                                    required
                                    min="20"
                                    step="0.01">
                            </div>
                            <div class="lira-field-hint">
                                <i class="fas fa-circle-info"></i>
                                الحد الأدنى للإيداع هو 20 دولار.
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-7">
                            <label class="form-label d-block">طريقة الإيداع</label>
                            <div class="lira-method-grid">
                                @foreach ($depositMethods as $method)
                                    @php
                                        $methodIcon = match ($method) {
                                            \App\Enums\TransactionRequestMethod::USDT_TRC20 => 'fa-bolt',
                                            \App\Enums\TransactionRequestMethod::USDT_ERC20 => 'fa-link',
                                            \App\Enums\TransactionRequestMethod::ShamCash => 'fa-wallet',
                                        };
                                    @endphp
                                    <input
                                        type="radio"
                                        name="method"
                                        id="payment_{{ $method->value }}"
                                        value="{{ $method->value }}"
                                        autocomplete="off"
                                        required
                                        class="btn-check"
                                        @checked($selectedMethod === $method->value)>
                                    <label class="method-pill" for="payment_{{ $method->value }}">
                                        <i class="fas {{ $methodIcon }}"></i>
                                        <span>{{ $method->getName() }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('method')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="lira-form-section">
                    <div class="lira-section-heading">
                        <span>02</span>
                        <div>
                            <h2>بيانات التحويل</h2>
                            <p>انسخ البيانات المطابقة لطريقة الإيداع المختارة.</p>
                        </div>
                    </div>

                    @foreach ($paymentTargets as $methodValue => $target)
                        <div
                            id="{{ $target['id'] }}-info"
                            class="payment-info-box {{ $selectedMethod === $methodValue ? '' : 'd-none' }}"
                            data-payment-info="{{ $methodValue }}">
                            <div class="lira-copy-head">
                                <div>
                                    <strong>{{ $target['title'] }}</strong>
                                    <span>{{ $target['hint'] }}</span>
                                </div>
                                <i class="fas fa-shield-halved"></i>
                            </div>
                            <div class="lira-copy-row">
                                <input
                                    type="text"
                                    id="{{ $target['id'] }}-address"
                                    class="form-control"
                                    readonly
                                    value="{{ $target['value'] }}"
                                    dir="ltr">
                                <button type="button" class="btn btn-primary" onclick="copyToClipboard('{{ $target['id'] }}-address')">
                                    <i class="fas fa-copy"></i>
                                    نسخ
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lira-form-section mb-0">
                    <div class="lira-section-heading">
                        <span>03</span>
                        <div>
                            <h2>إشعار الإيداع</h2>
                            <p>ارفع صورة واضحة للإيصال حتى تتم المراجعة بسرعة.</p>
                        </div>
                    </div>

                    <label class="upload-area" for="payment_proof">
                        <i class="fas fa-cloud-arrow-up"></i>
                        <strong>اختر صورة الإيصال</strong>
                        <span id="deposit-file-name">PNG أو JPG أو PDF حسب إعدادات المتصفح</span>
                        <input
                            name="payment_proof"
                            type="file"
                            id="payment_proof"
                            class="form-control @error('payment_proof') is-invalid @enderror"
                            required>
                    </label>
                    @error('payment_proof')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="lira-submit-row">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i>
                        إرسال الطلب للمراجعة
                    </button>
                </div>
            </div>
        </section>

        <aside class="lira-transfer-side">
            <div class="lira-side-panel">
                <span class="lira-side-kicker">DEPOSIT FLOW</span>
                <h3>مراجعة أسرع تبدأ من بيانات واضحة</h3>
                <div class="lira-side-list">
                    <div>
                        <i class="fas fa-check"></i>
                        <span>تأكد من اختيار الشبكة الصحيحة قبل التحويل.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>يجب أن يكون المبلغ 20 دولار أو أكثر.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>الإشعار الواضح يساعد الإدارة على اعتماد الطلب بسرعة.</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</form>

@push('custom_scripts')
    <script>
        const depositInfoBoxes = document.querySelectorAll('[data-payment-info]');

        function toggleDetails() {
            const selectedMethod = document.querySelector('input[name="method"]:checked')?.value;

            depositInfoBoxes.forEach(box => {
                box.classList.toggle('d-none', box.dataset.paymentInfo !== selectedMethod);
            });
        }

        document.querySelectorAll('input[name="method"]').forEach(radio => {
            radio.addEventListener('change', toggleDetails);
        });

        toggleDetails();

        const paymentProofInput = document.getElementById('payment_proof');
        const depositFileName = document.getElementById('deposit-file-name');

        paymentProofInput?.addEventListener('change', () => {
            depositFileName.textContent = paymentProofInput.files?.[0]?.name || 'PNG أو JPG أو PDF حسب إعدادات المتصفح';
        });

        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');

            if (window.showNotification) {
                window.showNotification('تم نسخ البيانات بنجاح!', 'success');
            } else {
                alert('تم نسخ البيانات بنجاح!');
            }
        }
    </script>
@endpush
