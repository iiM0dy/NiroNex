@php
    $user = auth()->user();
    $profitWallet = $user->profitWallet;
    $availableBalance = (float) ($profitWallet?->balance ?? 0);
@endphp

<div class="lira-page-header animate__animated animate__fadeIn">
    <div>
        <span class="lira-eyebrow">EQUITY · PEER TO PEER</span>
        <h1 class="lira-page-title">تحويل داخلي</h1>
        <p class="lira-page-subtitle">قم بتحويل الرصيد إلى مستخدمين آخرين داخل شبكة {{ appName() }}.</p>
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

<form action="{{ route('site.transactions-requests.store.internal-transfer') }}" method="POST">
    @csrf
    <input type="hidden" name="type" value="{{ \App\Enums\TransactionRequestType::InternalTransfer->value }}">

    <div class="lira-transfer-layout">
        <section class="card lira-transfer-card">
            <div class="card-body">
                <div class="lira-form-section">
                    <div class="lira-section-heading">
                        <span>01</span>
                        <div>
                            <h2>بيانات المستلم</h2>
                            <p>أدخل البريد الإلكتروني المرتبط بحساب المستلم داخل المنصة.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="receiver_email" class="form-label">البريد الإلكتروني للمستلم</label>
                            <div class="lira-input-wrap is-recipient-email">
                                <i class="fas fa-envelope lira-input-icon"></i>
                                <input
                                    type="email"
                                    id="receiver_email"
                                    name="receiver_email"
                                    class="form-control text-start"
                                    placeholder="example@email.com"
                                    value="{{ old('receiver_email') }}"
                                    dir="ltr"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">المبلغ المراد تحويله</label>
                            <div class="lira-input-wrap">
                                <i class="fas fa-dollar-sign lira-input-icon"></i>
                                <input
                                    type="number"
                                    id="amount"
                                    name="amount"
                                    class="form-control text-start"
                                    placeholder="0.00"
                                    value="{{ old('amount') }}"
                                    required
                                    min="1"
                                    @if ($availableBalance > 0) max="{{ $availableBalance }}" @endif
                                    step="0.01">
                            </div>
                            <div class="lira-field-hint">
                                <i class="fas fa-circle-info"></i>
                                الرصيد المتاح للتحويل: {{ formatCurrency($availableBalance) }}.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lira-form-section mb-0">
                    <div class="lira-section-heading">
                        <span>02</span>
                        <div>
                            <h2>ملاحظة الطلب</h2>
                            <p>يمكنك إضافة سبب التحويل أو أي مرجع داخلي.</p>
                        </div>
                    </div>

                    <label for="note" class="form-label">ملاحظة اختيارية</label>
                    <textarea
                        id="note"
                        name="note"
                        class="form-control"
                        rows="4"
                        maxlength="255"
                        placeholder="أضف ملاحظة قصيرة هنا...">{{ old('note') }}</textarea>
                </div>

                <div class="lira-submit-row">
                    <button type="submit" class="btn btn-primary btn-lg" @disabled($availableBalance < 1)>
                        <i class="fas fa-share-nodes"></i>
                        إرسال طلب التحويل
                    </button>
                </div>
            </div>
        </section>

        <aside class="lira-transfer-side">
            <div class="lira-balance-panel">
                <span>محفظة الأرباح</span>
                <strong>{{ formatCurrency($availableBalance) }}</strong>
                <small>الرصيد المتاح للتحويل الداخلي</small>
            </div>

            <div class="lira-side-panel">
                <span class="lira-side-kicker">TRANSFER CHECK</span>
                <h3>طلب التحويل يمر للمراجعة قبل التنفيذ</h3>
                <div class="lira-side-list">
                    <div>
                        <i class="fas fa-check"></i>
                        <span>لا يمكن التحويل لنفس الحساب.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>يتم استخدام رصيد محفظة الأرباح فقط.</span>
                    </div>
                    <div>
                        <i class="fas fa-check"></i>
                        <span>يجب استكمال التحقق من الهوية قبل إرسال الطلب.</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</form>
