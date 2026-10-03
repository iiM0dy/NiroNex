@php
    $user = auth()->user();
    $profitWallet = $user->profitWallet;
    $availableBalance = (float) ($profitWallet?->balance ?? 0);
    $withdrawalMethods = \App\Enums\TransactionRequestMethod::withdrawalMethods();
@endphp

<div class="lira-page-header animate__animated animate__fadeIn">
    <div>
        <span class="lira-eyebrow">TRANSFERS · CASH OUT</span>
        <h1 class="lira-page-title">طلب سحب جديد</h1>
        <p class="lira-page-subtitle">قم بسحب أرباحك بسهولة وموثوقية من خلال قنواتنا المعتمدة.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <ul class="mb-0 list-unstyled">
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-triangle me-2"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('site.transactions-requests.store') }}" method="POST">
    @csrf
    <input type="hidden" name="type" id="type" value="{{ App\Enums\TransactionRequestType::Withdrawal->value }}">

    <div class="lira-transfer-layout">
        <section class="card lira-transfer-card">
            <div class="card-body">
                <div class="lira-form-section">
                    <div class="lira-section-heading">
                        <span>01</span>
                        <div>
                            <h2>تفاصيل السحب</h2>
                            <p>اختر شبكة التحويل وأدخل المبلغ المطلوب.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label" for="method">طريقة التحويل</label>
                            <div class="lira-select-wrap">
                                <i class="fas fa-credit-card lira-input-icon"></i>
                                <select name="method" id="method" class="form-select" required>
                                    @foreach ($withdrawalMethods as $method)
                                        <option value="{{ $method->value }}" @selected((int) old('method', $withdrawalMethods[0]->value ?? $method->value) === $method->value)>
                                            {{ $method->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="lira-field-hint">
                                <i class="fas fa-circle-info"></i>
                                اختر نفس الشبكة الخاصة بعنوان محفظتك.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="withdrawal-amount">المبلغ المراد سحبه</label>
                            <div class="lira-input-wrap">
                                <i class="fas fa-dollar-sign lira-input-icon"></i>
                                <input
                                    type="number"
                                    id="withdrawal-amount"
                                    name="amount"
                                    class="form-control"
                                    placeholder="0.00"
                                    value="{{ old('amount') }}"
                                    required
                                    min="1"
                                    @if ($availableBalance > 0) max="{{ $availableBalance }}" @endif
                                    step="0.01">
                            </div>
                            <div class="lira-field-hint">
                                <i class="fas fa-circle-info"></i>
                                الحد الأدنى للسحب هو 1 دولار.
                            </div>
                        </div>

                        <div class="col-12" id="transfer-fields"></div>
                    </div>
                </div>

                <div class="lira-submit-row">
                    <button type="submit" class="btn btn-primary btn-lg" @disabled($availableBalance < 1)>
                        <i class="fas fa-check-double"></i>
                        إرسال طلب السحب
                    </button>
                </div>
            </div>
        </section>

        <aside class="lira-transfer-side">
            <div class="lira-balance-panel">
                <span>محفظة الأرباح</span>
                <strong>{{ formatCurrency($availableBalance) }}</strong>
                <small>الرصيد المتاح للسحب</small>
            </div>

            <div class="lira-side-panel">
                <span class="lira-side-kicker">WITHDRAW CHECK</span>
                <h3>راجع التفاصيل قبل إرسال الطلب</h3>
                <div class="lira-side-list">
                    <div>
                        <i class="fas fa-check"></i>
                        <span>عنوان المحفظة يجب أن يطابق الشبكة المختارة.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>لا يمكن تجاوز الرصيد المتاح في محفظة الأرباح.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>يجب استكمال التحقق من الهوية قبل إرسال طلب السحب.</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</form>
