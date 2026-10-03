@extends('layouts.site-dash')

@section('title', 'نسخ الصفقات')

@section('content')
    <div class="lira-copy-trading-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · COPY TRADING</span>
                <h1 class="lira-page-title">نسخ الصفقات</h1>
                <p class="lira-page-subtitle">
                    اختر حساب التداول المصدر، حدد نسبة رأس المال ومستوى المخاطرة، وفعّل النسخ التلقائي.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 18px; padding: 16px 18px;">
                <i class="fa-solid fa-check-circle ms-3"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="row g-3">
            <div class="col-xxl-8">
                <div class="card lira-table-card">
                    <div class="card-header border-0">
                        <h6 class="mb-1">إعدادات النسخ</h6>
                        <p class="text-muted mb-0 small">حدد المعايير التي تريد نسخ الصفقات بها.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('site.copy-trading.update') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">حساب التداول المصدر</label>
                                <div class="lira-input-wrap">
                                    <i class="lira-input-icon fa-solid fa-user-tie"></i>
                                    <input type="text" name="source_account" class="form-control"
                                           placeholder="أدخل رقم حساب المتداول المصدر"
                                           value="{{ old('source_account', $settings->source_account) }}">
                                </div>
                                @error('source_account')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">نسبة رأس المال (%)</label>
                                <div class="lira-input-wrap">
                                    <i class="lira-input-icon fa-solid fa-percent"></i>
                                    <input type="number" name="capital_percentage" class="form-control"
                                           min="1" max="100" step="0.01"
                                           placeholder="مثال: 10"
                                           value="{{ old('capital_percentage', $settings->capital_percentage) }}">
                                </div>
                                <small class="text-muted">نسبة رصيدك التي سيتم تخصيصها لنسخ الصفقات.</small>
                                @error('capital_percentage')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">مستوى المخاطرة</label>
                                <div class="lira-risk-selector">
                                    @foreach(['low' => ['منخفض', 'fa-shield-halved', 'is-low'], 'medium' => ['متوسط', 'fa-scale-balanced', 'is-medium'], 'high' => ['مرتفع', 'fa-fire', 'is-high']] as $value => [$label, $icon, $class])
                                        <label class="lira-risk-card {{ $class }} {{ old('risk_level', $settings->risk_level) === $value ? 'active' : '' }}">
                                            <input type="radio" name="risk_level" value="{{ $value }}"
                                                   {{ old('risk_level', $settings->risk_level) === $value ? 'checked' : '' }}>
                                            <i class="fa-solid {{ $icon }}"></i>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('risk_level')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">حماية إيقاف النسخ (Stop Copy Loss)</label>
                                <div class="lira-input-wrap">
                                    <i class="lira-input-icon fa-solid fa-shield-exclamation"></i>
                                    <input type="number" name="stop_copy_loss" class="form-control"
                                           min="0" step="0.01"
                                           placeholder="أقصى خسارة مقبولة بالدولار"
                                           value="{{ old('stop_copy_loss', $settings->stop_copy_loss) }}">
                                </div>
                                <small class="text-muted">سيتم إيقاف النسخ تلقائياً عند الوصول لهذا الحد.</small>
                                @error('stop_copy_loss')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="lira-toggle-row mb-4">
                                <div>
                                    <strong>تفعيل النسخ التلقائي</strong>
                                    <span class="text-muted d-block small">عند التفعيل، سيتم نسخ صفقات الحساب المصدر تلقائياً.</span>
                                </div>
                                <label class="lira-toggle">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ old('is_active', $settings->is_active) ? 'checked' : '' }}>
                                    <span class="lira-toggle-slider"></span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fa-solid fa-floppy-disk ms-2"></i>
                                حفظ الإعدادات
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">حالة النسخ</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-status-indicator {{ $settings->is_active ? 'is-active' : 'is-inactive' }}">
                                <i class="fa-solid {{ $settings->is_active ? 'fa-circle-play' : 'fa-circle-pause' }}"></i>
                                <span>{{ $settings->is_active ? 'النسخ مفعّل' : 'النسخ متوقف' }}</span>
                            </div>

                            @if($settings->exists)
                                <div class="lira-side-grid mt-3">
                                    <div class="lira-side-metric">
                                        <span>رأس المال</span>
                                        <strong>{{ $settings->capital_percentage }}%</strong>
                                    </div>
                                    <div class="lira-side-metric">
                                        <span>المخاطرة</span>
                                        <strong>{{ ['low' => 'منخفض', 'medium' => 'متوسط', 'high' => 'مرتفع'][$settings->risk_level] ?? $settings->risk_level }}</strong>
                                    </div>
                                    @if($settings->stop_copy_loss)
                                        <div class="lira-side-metric">
                                            <span>حد الإيقاف</span>
                                            <strong>{{ formatCurrency($settings->stop_copy_loss) }}</strong>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">ملاحظات مهمة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>نسخ الصفقات يتم بناءً على الحساب المصدر بشكل آلي.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>تأكد من ضبط حد الإيقاف لحماية رأس المال من الخسائر الكبيرة.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>يمكنك إيقاف النسخ في أي وقت عبر زر التعطيل أعلاه.</span>
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
        .lira-risk-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .lira-risk-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 22px 16px;
            border-radius: var(--radius-md);
            background: var(--lira-surface-2);
            border: 2px solid var(--lira-border);
            cursor: pointer;
            transition: all 0.22s ease;
            text-align: center;
        }

        .lira-risk-card input { display: none; }

        .lira-risk-card i {
            font-size: 22px;
            opacity: 0.6;
            transition: all 0.22s ease;
        }

        .lira-risk-card span {
            font-weight: 700;
            font-size: 14px;
        }

        .lira-risk-card:hover { border-color: rgba(255,255,255,0.1); }

        .lira-risk-card.active,
        .lira-risk-card:has(input:checked) {
            border-color: var(--lira-accent) !important;
            background: rgba(0,230,167,0.06);
        }

        .lira-risk-card.active i,
        .lira-risk-card:has(input:checked) i { opacity: 1; }

        .lira-risk-card.is-low i { color: #5fe2a1; }
        .lira-risk-card.is-medium i { color: var(--lira-accent); }
        .lira-risk-card.is-high i { color: #ff8a80; }

        .lira-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 18px 20px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .lira-toggle {
            position: relative;
            width: 56px;
            height: 30px;
            flex: 0 0 auto;
        }

        .lira-toggle input { display: none; }

        .lira-toggle-slider {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background: var(--lira-surface-3);
            border: 1px solid var(--lira-border);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .lira-toggle-slider::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--lira-text-muted);
            transition: all 0.25s ease;
        }

        .lira-toggle input:checked + .lira-toggle-slider {
            background: rgba(0,230,167,0.18);
            border-color: rgba(0,230,167,0.4);
        }

        .lira-toggle input:checked + .lira-toggle-slider::before {
            transform: translateX(26px);
            background: var(--lira-accent);
        }

        .lira-status-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-radius: var(--radius-md);
            font-weight: 700;
        }

        .lira-status-indicator.is-active {
            background: rgba(23,178,106,0.10);
            color: #5fe2a1;
        }

        .lira-status-indicator.is-inactive {
            background: rgba(255,255,255,0.03);
            color: var(--lira-text-muted);
        }

        .lira-status-indicator i { font-size: 22px; }

        .lira-side-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .lira-side-metric {
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,0.025);
        }

        .lira-side-metric span {
            display: block;
            font-size: 11px;
            color: var(--lira-text-muted);
            margin-bottom: 4px;
        }

        .lira-side-metric strong {
            font-size: 14px;
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
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-guideline-item i {
            color: var(--lira-accent);
            margin-top: 4px;
            flex: 0 0 auto;
        }

        @media (max-width: 575px) {
            .lira-risk-selector {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .lira-risk-card {
                padding: 16px 8px;
                gap: 8px;
            }

            .lira-risk-card i {
                font-size: 18px;
            }

            .lira-risk-card span {
                font-size: 12px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.querySelectorAll('.lira-risk-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.lira-risk-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
            });
        });
    </script>
@endpush

