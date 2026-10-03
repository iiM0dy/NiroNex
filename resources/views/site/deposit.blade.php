@extends('layouts.site-dash')

@section('title', 'اختيار الخطة')

@section('content')
    <div class="lira-plan-pick-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">ACCOUNT PLAN · SELECT</span>
                <h1 class="lira-page-title">اختر خطة الحساب</h1>
            </div>
        </div>

        <div class="card lira-plan-pick-card mb-4">
            <div class="card-body">
                <div class="lira-plan-pick-note">
                    <div class="lira-plan-pick-note__icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <strong>الخطة الحالية</strong>
                        <span>{{ $user?->plan?->display_name ?? 'لا توجد خطة مفعلة حالياً' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @foreach ($plans as $plan)
                @php
                    $isCurrent = (int) $user?->plan_id === (int) $plan->id;
                    $isSelected = (int) $selectedPlan?->id === (int) $plan->id;
                    $planFundingUrl = route('site.funding', ['plan_id' => $plan->id]);
                @endphp

                <div class="col-xl-6">
                    <label class="lira-plan-select {{ $isSelected ? 'is-selected' : '' }}" for="plan-option-{{ $plan->id }}">
                        <input
                            class="d-none lira-plan-select__input"
                            id="plan-option-{{ $plan->id }}"
                            type="radio"
                            name="plan_choice"
                            value="{{ $plan->id }}"
                            data-url="{{ $planFundingUrl }}"
                            {{ $isSelected ? 'checked' : '' }}
                        >

                        <div class="lira-plan-select__card">
                            <div class="lira-plan-select__top">
                                <div>
                                    <span class="lira-plan-select__eyebrow">{{ $isCurrent ? 'الخطة الحالية' : 'خطة متاحة' }}</span>
                                    <h3>{{ $plan->display_name }}</h3>
                                </div>

                                <div class="lira-plan-select__check">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>

                            <p class="lira-plan-select__desc">
                                {{ brandText($plan->description ?: 'خطة تشغيل مرنة داخل منصة ' . appName() . ' مع إعدادات مناسبة للتداول اليومي.') }}
                            </p>

                            <div class="lira-plan-select__stats">
                                <div class="lira-plan-select__stat">
                                    <span>نطاق الإيداع</span>
                                    <strong>{{ $plan->deposit_range_label }}</strong>
                                </div>
                                <div class="lira-plan-select__stat">
                                    <span>دورة الدفع</span>
                                    <strong>{{ $plan->payout_interval_label }}</strong>
                                </div>
                                <div class="lira-plan-select__stat">
                                    <span>الربح المعروض</span>
                                    <strong>{{ $plan->display_profit_rate }}</strong>
                                </div>
                                <div class="lira-plan-select__stat">
                                    <span>مستوى المخاطرة</span>
                                    <strong>{{ $plan->risk_label ?? '—' }}</strong>
                                </div>
                            </div>

                            <div class="lira-plan-select__footer">
                                <span>{{ $isCurrent ? 'يمكنك الإيداع على نفس الخطة أو تغييرها قبل المتابعة.' : 'حدد هذه الخطة ثم أكمل الإيداع.' }}</span>
                                <i class="fa-solid fa-arrow-left"></i>
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="card lira-plan-pick-card mt-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <strong class="d-block mb-1">الخطة المختارة</strong>
                    <span class="text-muted" id="selectedPlanName">{{ $selectedPlan?->display_name ?? 'اختر خطة للمتابعة' }}</span>
                </div>

                <a href="{{ $selectedPlan ? route('site.funding', ['plan_id' => $selectedPlan->id]) : route('site.funding') }}"
                    class="btn btn-primary px-4 py-3"
                    id="continueToFundingBtn">
                    متابعة إلى صفحة الإيداع
                    <i class="fa-solid fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-plan-pick-card {
            border: 1px solid rgba(255, 255, 255, 0.06);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.018), rgba(255, 255, 255, 0.01));
        }

        .lira-plan-pick-note {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .lira-plan-pick-note__icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
            font-size: 20px;
        }

        .lira-plan-pick-note strong {
            display: block;
            font-size: 14px;
        }

        .lira-plan-pick-note span {
            color: var(--lira-text-muted);
            font-size: 13px;
        }

        .lira-plan-select {
            display: block;
            margin: 0;
            cursor: pointer;
        }

        .lira-plan-select__card {
            height: 100%;
            padding: 26px 24px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.025), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: transform 0.24s ease, border-color 0.24s ease, box-shadow 0.24s ease;
        }

        .lira-plan-select:hover .lira-plan-select__card {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.14);
        }

        .lira-plan-select.is-selected .lira-plan-select__card {
            border-color: rgba(0, 230, 167, 0.42);
            box-shadow: 0 0 0 3px rgba(0, 230, 167, 0.14);
        }

        .lira-plan-select__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .lira-plan-select__eyebrow {
            display: block;
            margin-bottom: 8px;
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lira-plan-select__top h3 {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 900;
        }

        .lira-plan-select__check {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.34);
            flex: 0 0 auto;
        }

        .lira-plan-select.is-selected .lira-plan-select__check {
            background: rgba(0, 230, 167, 0.12);
            color: var(--lira-accent);
        }

        .lira-plan-select__desc {
            margin-bottom: 18px;
            color: var(--lira-text-muted);
            line-height: 1.75;
        }

        .lira-plan-select__stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-plan-select__stat {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-plan-select__stat span {
            display: block;
            margin-bottom: 5px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-plan-select__stat strong {
            display: block;
            font-size: 14px;
            font-weight: 800;
        }

        .lira-plan-select__footer {
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--lira-accent);
            font-size: 13px;
            font-weight: 700;
        }

        @media (max-width: 767.98px) {
            .lira-plan-select__stats {
                grid-template-columns: 1fr;
            }

            .lira-plan-pick-card .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const planInputs = document.querySelectorAll('.lira-plan-select__input');
            const selectedPlanName = document.getElementById('selectedPlanName');
            const continueBtn = document.getElementById('continueToFundingBtn');

            function syncPlanSelection(input) {
                if (!input) return;

                planInputs.forEach(item => {
                    item.checked = item === input;
                    item.closest('.lira-plan-select')?.classList.toggle('is-selected', item === input);
                });

                const planTitle = input.closest('.lira-plan-select')?.querySelector('h3')?.textContent?.trim();
                if (planTitle && selectedPlanName) {
                    selectedPlanName.textContent = planTitle;
                }

                if (continueBtn && input.dataset.url) {
                    continueBtn.href = input.dataset.url;
                }
            }

            planInputs.forEach(input => {
                input.addEventListener('change', () => syncPlanSelection(input));
                input.closest('.lira-plan-select')?.addEventListener('click', () => syncPlanSelection(input));
            });
        });
    </script>
@endpush

