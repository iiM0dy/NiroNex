@extends('layouts.site-dash')

@php
    $robotProductName = 'Niro Nex AI';
@endphp

@section('title', $robotProductName)

@section('content')
    @php
        $statusTone = match ($settings->status) {
            \App\Enums\TransactionStatus::Accepted => 'is-success',
            \App\Enums\TransactionStatus::Rejected => 'is-danger',
            default => 'is-warning',
        };

        $currentRiskLevel = old('risk_level', $settings->risk_level ?: 'low');
        $currentRiskRules = $riskRules[$currentRiskLevel] ?? $riskRules['low'];
        $currentAllocationAmount = (float) old(
            'allocation_amount',
            $settings->allocation_amount ?: $currentRiskRules['min_allocation']
        );
        $currentTakeProfit = (float) old(
            'take_profit',
            $settings->take_profit ?: $currentRiskRules['default_take_profit']
        );
        $currentStopLoss = (float) old(
            'stop_loss',
            $settings->stop_loss ?: ($currentRiskRules['auto_stop_loss_half']
                ? round($currentTakeProfit / 2, 2)
                : $currentRiskRules['default_stop_loss'])
        );
        $currentPepPrice = (float) ($pepPrices[$currentRiskLevel] ?? ($settings->pep_price ?: $pepPrices['low']));
        $previewAllocationAmount = $formLocked && $settings->exists
            ? (float) $settings->allocation_amount
            : $currentAllocationAmount;
        $previewPepUnits = $currentPepPrice > 0 ? $previewAllocationAmount / $currentPepPrice : 0;
    @endphp

    <div class="lira-robot-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ $robotProductName }} · SYSTEM REQUEST</span>
                <h1 class="lira-page-title">تفعيل {{ $robotProductName }}</h1>
                <p class="lira-page-subtitle">
                    اختر مستوى المخاطرة، حدد المبلغ المستخدم من محفظة الإيداع، ثم أرسل الطلب للإدارة للتأكيد
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="row g-3">
            <div class="col-xxl-8">
                <div class="card lira-robot-card">
                    <div class="card-header border-0">
                        <div>
                            <h6 class="mb-1">إعدادات طلب {{ $robotProductName }}</h6>
                            <p class="text-muted mb-0 small">
                                يتم حجز المبلغ الذي تختاره من محفظة الإيداع بعد مراجعة قواعد مستوى المخاطرة.
                            </p>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($formLocked)
                            <div class="lira-robot-lock-note {{ $statusTone }}">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>
                                    {{ $settings->status === \App\Enums\TransactionStatus::Accepted
                                        ? $robotProductName . ' مفعل لهذا الحساب بالفعل. لا يمكن إرسال طلب جديد قبل الرجوع إلى الإدارة.'
                                        : 'يوجد طلب ' . $robotProductName . ' قيد المراجعة حاليًا. لا يمكن إرسال طلب جديد حتى يتم اتخاذ قرار إداري.' }}
                                </span>
                            </div>
                        @endif

                        <form action="{{ route('site.robot.update') }}" method="POST" id="robotRequestForm">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">مستوى المخاطرة</label>
                                <div class="lira-risk-grid">
                                    @foreach([
                                        'low' => ['منخفض', 'fa-shield-halved', 'محافظ', $pepPrices['low'], '#2ed573', '46, 213, 115'],
                                        'medium' => ['متوسط', 'fa-scale-balanced', 'متوازن', $pepPrices['medium'], '#ffa502', '255, 165, 2'],
                                        'high' => ['مرتفع', 'fa-bolt', 'هجومي', $pepPrices['high'], '#ff4757', '255, 71, 87'],
                                    ] as $value => [$label, $icon, $caption, $price, $color, $rgb])
                                        <label class="lira-risk-card {{ $currentRiskLevel === $value ? 'active' : '' }}"
                                               style="--risk-color: {{ $color }}; --risk-color-rgb: {{ $rgb }};">
                                            <input type="radio" name="risk_level" value="{{ $value }}"
                                                {{ $currentRiskLevel === $value ? 'checked' : '' }}
                                                {{ $formLocked ? 'disabled' : '' }}>
                                            
                                            <div class="lira-risk-icon-wrapper">
                                                <i class="fa-solid {{ $icon }}"></i>
                                            </div>
                                            
                                            <strong>{{ $label }}</strong>
                                            <span>{{ $caption }}</span>
                                            
                                            <div class="lira-risk-pep-badge" style="direction: ltr;">
                                                1 PEP = ${{ formatTrimmedNumber($price, 2) }}
                                            </div>
                                            <span class="lira-risk-min">أقل إيداع {{ formatCurrency($riskRules[$value]['min_allocation']) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('risk_level')
                                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">المبلغ المستخدم من المحفظة ($)</label>
                                    <div class="lira-input-wrap">
                                        <i class="lira-input-icon fa-solid fa-dollar-sign"></i>
                                        <input type="number" name="allocation_amount" id="allocationAmount"
                                            class="form-control" min="{{ $currentRiskRules['min_allocation'] }}"
                                            max="{{ $availableBalance }}" step="0.01"
                                            value="{{ $currentAllocationAmount }}"
                                            placeholder="مثال: {{ $currentRiskRules['min_allocation'] }}" {{ $formLocked ? 'disabled' : '' }}>
                                    </div>
                                    <small class="lira-field-hint" id="allocationHint">
                                        أقل إيداع لهذا المستوى {{ formatCurrency($currentRiskRules['min_allocation']) }}.
                                    </small>
                                    @error('allocation_amount')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">جني الربح (%)</label>
                                    <div class="lira-input-wrap">
                                        <i class="lira-input-icon fa-solid fa-arrow-trend-up"></i>
                                        <input type="number" name="take_profit" id="takeProfit"
                                            class="form-control" min="{{ $currentRiskRules['min_take_profit'] }}" max="100" step="0.01"
                                            value="{{ $currentTakeProfit }}"
                                            placeholder="مثال: 18" {{ $formLocked ? 'disabled' : '' }}
                                            {{ $currentRiskRules['fixed_values'] && ! $formLocked ? 'readonly' : '' }}>
                                    </div>
                                    <small class="lira-field-hint" id="takeProfitHint">
                                        {{ $currentRiskRules['fixed_values']
                                            ? 'جني الربح ثابت لهذا المستوى على ' . formatPercent($currentRiskRules['default_take_profit'], 2) . '.'
                                            : ($currentRiskRules['auto_stop_loss_half']
                                                ? 'جني الربح يحدده المستخدم لهذا المستوى.'
                                                : 'أقل جني ربح لهذا المستوى ' . formatPercent($currentRiskRules['min_take_profit'], 2) . '.') }}
                                    </small>
                                    @error('take_profit')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">حد الخسارة (%)</label>
                                    <div class="lira-input-wrap">
                                        <i class="lira-input-icon fa-solid fa-arrow-trend-down"></i>
                                        <input type="number" name="stop_loss" id="stopLoss"
                                            class="form-control" min="{{ $currentRiskRules['min_stop_loss'] }}" max="100" step="0.01"
                                            value="{{ $currentStopLoss }}"
                                            placeholder="مثال: 8" {{ $formLocked ? 'disabled' : '' }}
                                            {{ ($currentRiskRules['auto_stop_loss_half'] || $currentRiskRules['fixed_values']) && ! $formLocked ? 'readonly' : '' }}>
                                    </div>
                                    <small class="lira-field-hint" id="stopLossHint">
                                        {{ $currentRiskRules['fixed_values']
                                            ? 'حد الخسارة ثابت لهذا المستوى على ' . formatPercent($currentRiskRules['default_stop_loss'], 2) . '.'
                                            : ($currentRiskRules['auto_stop_loss_half']
                                            ? 'يتم احتساب حد الخسارة تلقائياً كنصف جني الربح.'
                                            : 'أقل حد خسارة لهذا المستوى ' . formatPercent($currentRiskRules['min_stop_loss'], 2) . '.') }}
                                    </small>
                                    @error('stop_loss')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="lira-robot-preview"
                                data-wallet-balance="{{ $availableBalance }}"
                                data-saved-allocation="{{ $previewAllocationAmount }}"
                                data-form-locked="{{ $formLocked ? '1' : '0' }}">
                                <div class="lira-preview-item">
                                    <span>الرصيد المتاح</span>
                                    <strong>{{ formatCurrency($availableBalance) }}</strong>
                                </div>
                                <div class="lira-preview-item">
                                    <span>المبلغ المتوقع استخدامه</span>
                                    <strong id="previewAllocation">{{ formatCurrency($previewAllocationAmount) }}</strong>
                                </div>
                                <div class="lira-preview-item">
                                    <span>سعر PEP الحالي</span>
                                    <strong id="previewPepPrice">${{ formatTrimmedNumber($currentPepPrice, 2) }}</strong>
                                </div>
                                <div class="lira-preview-item">
                                    <span>تقدير وحدات PEP</span>
                                    <strong id="previewPepUnits">{{ formatTrimmedNumber($previewPepUnits, 4) }}</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 px-5 lira-robot-submit-btn" {{ $formLocked ? 'disabled' : '' }}>
                                <i class="fa-solid fa-paper-plane ms-2"></i>
                                إرسال طلب تشغيل {{ $robotProductName }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">حالة الطلب الحالية</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-status-box {{ $statusTone }}">
                                <i class="fa-solid {{ $settings->status === \App\Enums\TransactionStatus::Accepted ? 'fa-circle-check' : ($settings->status === \App\Enums\TransactionStatus::Rejected ? 'fa-circle-xmark' : 'fa-hourglass-half') }}"></i>
                                <div>
                                    <strong>{{ $settings->exists ? $settings->status_label : 'لم يتم إرسال طلب بعد' }}</strong>
                                    <span>{{ $settings->exists ? 'آخر إعدادات محفوظة لطلب ' . $robotProductName . '.' : 'بمجرد الإرسال سيظهر ملخص الطلب هنا.' }}</span>
                                </div>
                            </div>

                            @if($settings->exists)
                                <div class="lira-side-grid mt-3">
                                    <div class="lira-side-metric">
                                        <span>المخاطرة</span>
                                        <strong>{{ $settings->risk_label }}</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>أقل إيداع للمستوى</span>
                                        <strong>{{ formatCurrency($riskRules[$settings->risk_level]['min_allocation'] ?? 20) }}</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>جني الربح</span>
                                        <strong class="text-success">{{ formatPercent($settings->take_profit, 2) }}</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>وقف الخسارة</span>
                                        <strong class="text-danger">{{ formatPercent($settings->stop_loss, 2) }}</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>سعر PEP</span>
                                        <strong>{{ $settings->pep_price_label }}</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>المبلغ المستخدم</span>
                                        <strong>{{ formatCurrency($settings->allocation_amount) }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">قواعد التشغيل</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>خطة Robot فقط هي التي تفتح هذه الصفحة وتسمح بإرسال الطلب.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>الحد الأدنى للإيداع: منخفض $20، متوسط $100، مرتفع $300.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>في المخاطرة المنخفضة يكون حد الخسارة نصف نسبة جني الربح تلقائياً.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>يتم إرسال الطلب للإدارة بحالة pending بشكل افتراضي.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>في حالة الرفض، تتم إعادة مبلغ التخصيص إلى محفظة المستخدم.</span>
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
        .lira-robot-card,
        .lira-side-card {
            overflow: hidden;
        }

        .lira-risk-grid,
        .lira-side-grid,
        .lira-robot-preview {
            display: grid;
            gap: 12px;
        }

        .lira-risk-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .lira-risk-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 28px 20px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.04);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .lira-risk-card:hover {
            background: rgba(255, 255, 255, 0.025);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .lira-risk-card.active {
            border-color: var(--risk-color);
            background: rgba(var(--risk-color-rgb), 0.04);
        }

        .lira-risk-card input {
            display: none;
        }

        .lira-risk-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 20px;
            color: var(--risk-color);
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .lira-risk-card.active .lira-risk-icon-wrapper {
            background: var(--risk-color);
            color: #111;
        }

        .lira-risk-card strong {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: var(--lira-text);
            margin-bottom: 2px;
        }

        .lira-risk-card span {
            display: block;
            font-size: 12px;
            color: var(--lira-text-muted);
            margin-bottom: 12px;
        }

        .lira-risk-pep-badge {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.03);
            font-size: 10px;
            font-weight: 600;
            color: var(--lira-text-soft);
            letter-spacing: 0.02em;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-risk-card.active .lira-risk-pep-badge {
            border-color: rgba(var(--risk-color-rgb), 0.2);
            color: var(--risk-color);
        }

        .lira-risk-card .lira-risk-min {
            margin: 8px 0 0;
            color: var(--lira-text-soft);
            font-size: 11px;
        }

        .lira-field-hint {
            display: block;
            margin-top: 7px;
            color: var(--lira-text-muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .lira-input-wrap .form-control[readonly] {
            color: var(--lira-text-soft);
            background-color: rgba(255, 255, 255, 0.035);
            cursor: default;
        }

        .lira-robot-preview,
        .lira-side-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .lira-preview-item,
        .lira-side-metric {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .lira-preview-item span,
        .lira-side-metric span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 11px;
            margin-bottom: 5px;
        }

        .lira-preview-item strong,
        .lira-side-metric strong {
            color: var(--lira-text);
            font-size: 14px;
        }

        .lira-robot-guideline,
        .lira-robot-lock-note,
        .lira-status-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: 18px;
        }

        .lira-robot-guideline {
            background: rgba(0, 230, 167, 0.08);
            border: 1px solid rgba(0, 230, 167, 0.16);
            color: var(--lira-text-soft);
        }

        .lira-robot-lock-note.is-warning,
        .lira-status-box.is-warning {
            background: rgba(120, 97, 255, 0.1);
            border: 1px solid rgba(120, 97, 255, 0.2);
            color: #c4b6ff;
        }

        .lira-robot-lock-note.is-success,
        .lira-status-box.is-success {
            background: rgba(23, 178, 106, 0.1);
            border: 1px solid rgba(23, 178, 106, 0.2);
            color: #5fe2a1;
        }

        .lira-robot-lock-note.is-danger,
        .lira-status-box.is-danger {
            background: rgba(240, 68, 56, 0.1);
            border: 1px solid rgba(240, 68, 56, 0.2);
            color: #ff8a80;
        }

        .lira-status-box strong,
        .lira-robot-lock-note strong {
            display: block;
            margin-bottom: 4px;
        }

        .lira-status-box span,
        .lira-robot-lock-note span {
            color: var(--lira-text-muted);
            line-height: 1.8;
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
            line-height: 1.8;
        }

        .lira-guideline-item i,
        .lira-robot-guideline i {
            color: var(--lira-gold);
            margin-top: 4px;
            flex: 0 0 auto;
        }

        @media (max-width: 767.98px) {
            .lira-robot-submit-btn {
                display: flex;
                width: fit-content;
                max-width: 100%;
                margin-inline: auto;
                justify-content: center;
            }

            .lira-robot-preview,
            .lira-side-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .lira-risk-grid {
                gap: 8px;
            }
            .lira-risk-card {
                padding: 16px 8px;
            }
            .lira-risk-icon-wrapper {
                width: 32px;
                height: 32px;
                font-size: 14px;
                margin-bottom: 10px;
            }
            .lira-risk-card strong {
                font-size: 13px;
            }
            .lira-risk-card span {
                font-size: 10px;
            }
            .lira-risk-pep-badge {
                padding: 4px 6px;
                font-size: 9px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pepPrices = @json($pepPrices);
            const riskRules = @json($riskRules);
            const preview = document.querySelector('.lira-robot-preview');
            const walletBalance = parseFloat(preview?.dataset.walletBalance || 0);
            const savedAllocation = parseFloat(preview?.dataset.savedAllocation || 0);
            const isFormLocked = preview?.dataset.formLocked === '1';
            const allocationInput = document.getElementById('allocationAmount');
            const takeProfitInput = document.getElementById('takeProfit');
            const stopLossInput = document.getElementById('stopLoss');
            const allocationHint = document.getElementById('allocationHint');
            const takeProfitHint = document.getElementById('takeProfitHint');
            const stopLossHint = document.getElementById('stopLossHint');
            const robotForm = document.getElementById('robotRequestForm');
            const allocationTarget = document.getElementById('previewAllocation');
            const pepPriceTarget = document.getElementById('previewPepPrice');
            const pepUnitsTarget = document.getElementById('previewPepUnits');

            function trimNumber(value, decimals = 6) {
                const fixed = Number(value || 0).toFixed(decimals);
                return fixed.replace(/\.?0+$/, '');
            }

            function updateRiskCards() {
                document.querySelectorAll('.lira-risk-card').forEach(card => {
                    const input = card.querySelector('input');
                    card.classList.toggle('active', !!input?.checked);
                });
            }

            function selectedRisk() {
                return document.querySelector('input[name="risk_level"]:checked')?.value || 'low';
            }

            function selectedRiskRules() {
                return riskRules[selectedRisk()] || riskRules.low;
            }

            function syncLowRiskStopLoss() {
                const rules = selectedRiskRules();
                if (!rules.auto_stop_loss_half || !takeProfitInput || !stopLossInput) return;

                const takeProfit = parseFloat(takeProfitInput.value || rules.default_take_profit || 0);
                stopLossInput.value = trimNumber(takeProfit / 2, 2);
            }

            function formatCurrency(value) {
                return `$${trimNumber(value, 2)}`;
            }

            function formatPercent(value) {
                return `${trimNumber(value, 2)}%`;
            }

            function applyRiskRules(forceDefaults = false) {
                const rules = selectedRiskRules();

                if (allocationInput) {
                    allocationInput.min = rules.min_allocation;
                    allocationInput.placeholder = `مثال: ${rules.min_allocation}`;

                    const currentAllocation = parseFloat(allocationInput.value || 0);
                    if (forceDefaults || !currentAllocation || currentAllocation < parseFloat(rules.min_allocation)) {
                        allocationInput.value = rules.min_allocation;
                    }
                }

                if (takeProfitInput) {
                    takeProfitInput.min = rules.min_take_profit;
                    takeProfitInput.readOnly = !!rules.fixed_values && !isFormLocked;

                    const currentTakeProfit = parseFloat(takeProfitInput.value || 0);
                    if (rules.fixed_values || forceDefaults || !currentTakeProfit || currentTakeProfit < parseFloat(rules.min_take_profit)) {
                        takeProfitInput.value = trimNumber(rules.default_take_profit, 2);
                    }
                }

                if (stopLossInput) {
                    stopLossInput.min = rules.min_stop_loss;
                    stopLossInput.readOnly = (!!rules.auto_stop_loss_half || !!rules.fixed_values) && !isFormLocked;

                    if (rules.fixed_values) {
                        stopLossInput.value = trimNumber(rules.default_stop_loss, 2);
                    } else if (rules.auto_stop_loss_half) {
                        syncLowRiskStopLoss();
                    } else {
                        const currentStopLoss = parseFloat(stopLossInput.value || 0);
                        if (forceDefaults || !currentStopLoss || currentStopLoss < parseFloat(rules.min_stop_loss)) {
                            stopLossInput.value = trimNumber(rules.default_stop_loss, 2);
                        }
                    }
                }

                if (allocationHint) {
                    allocationHint.textContent = `أقل إيداع لهذا المستوى ${formatCurrency(rules.min_allocation)}.`;
                }

                if (takeProfitHint) {
                    takeProfitHint.textContent = rules.fixed_values
                        ? `جني الربح ثابت لهذا المستوى على ${formatPercent(rules.default_take_profit)}.`
                        : rules.auto_stop_loss_half
                        ? 'جني الربح يحدده المستخدم لهذا المستوى.'
                        : `أقل جني ربح لهذا المستوى ${formatPercent(rules.min_take_profit)}.`;
                }

                if (stopLossHint) {
                    stopLossHint.textContent = rules.fixed_values
                        ? `حد الخسارة ثابت لهذا المستوى على ${formatPercent(rules.default_stop_loss)}.`
                        : rules.auto_stop_loss_half
                        ? 'يتم احتساب حد الخسارة تلقائياً كنصف جني الربح.'
                        : `أقل حد خسارة لهذا المستوى ${formatPercent(rules.min_stop_loss)}.`;
                }
            }

            function updatePreview() {
                const pepPrice = parseFloat(pepPrices[selectedRisk()] || 1);
                const allocation = isFormLocked ? savedAllocation : parseFloat(allocationInput?.value || 0);
                const pepUnits = pepPrice > 0 ? allocation / pepPrice : 0;

                if (pepPriceTarget) {
                    pepPriceTarget.textContent = `$${trimNumber(pepPrice, 2)}`;
                }

                if (allocationTarget) {
                    allocationTarget.textContent = `$${trimNumber(allocation, 6)}`;
                }

                if (pepUnitsTarget) {
                    pepUnitsTarget.textContent = trimNumber(pepUnits, 4);
                }
            }

            document.querySelectorAll('.lira-risk-card').forEach(card => {
                card.addEventListener('click', function () {
                    const input = this.querySelector('input');
                    if (!input || input.disabled) return;

                    document.querySelectorAll('.lira-risk-card input').forEach(radio => {
                        radio.checked = false;
                    });

                    input.checked = true;
                    updateRiskCards();
                    applyRiskRules(true);
                    updatePreview();
                });
            });

            allocationInput?.addEventListener('input', updatePreview);
            takeProfitInput?.addEventListener('input', function () {
                syncLowRiskStopLoss();
            });
            takeProfitInput?.addEventListener('input', updatePreview);
            document.querySelectorAll('input[name="risk_level"]').forEach(input => {
                input.addEventListener('change', function () {
                    applyRiskRules(true);
                    updatePreview();
                });
            });
            robotForm?.addEventListener('submit', syncLowRiskStopLoss);

            updateRiskCards();
            applyRiskRules(false);
            updatePreview();
        });
    </script>
@endpush

