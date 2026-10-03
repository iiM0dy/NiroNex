@extends('layouts.admin')
@section('title', 'تحويل رصيد إداري')

@section('content')
    <div class="lira-admin-create-transfer-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">ADMIN TRANSFER</span>
                <h2 class="lira-page-hero-title">تحويل رصيد إداري</h2>
                <p class="lira-page-hero-subtitle">
                    نقل الأموال يدوياً بين محافظ المستخدمين في النظام. سيتم تنفيذ العملية فوراً بعد التأكيد.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <a href="{{ route('admin.transactions-requests.internal-transfer') }}" class="btn btn-outline-primary px-4">
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                    العودة للتحويلات
                </a>
            </div>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger mb-4" style="background: rgba(240, 68, 56, 0.10); border-color: rgba(240, 68, 56, 0.22); color: #ff8a80;">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-circle-exclamation ms-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.transactions-requests.store-internal-transfer') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- From Section --}}
                <div class="col-lg-5">
                    <div class="lira-transfer-card is-danger">
                        <div class="lira-transfer-card-header">
                            <div class="lira-transfer-card-icon is-danger">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </div>
                            <div>
                                <h5 class="lira-transfer-card-title">خصم من (المصدر)</h5>
                                <p class="lira-transfer-card-subtitle">اختر محفظة المرسل</p>
                            </div>
                        </div>

                        <div class="lira-transfer-card-body">
                            <label class="form-label">محفظة المرسل</label>
                            <select id="from" name="from_id" class="form-select select2-custom" required>
                                <option value="">بحث عن مستخدم أو رقم محفظة...</option>
                                @foreach ($wallets as $value)
                                    <option value="{{ $value->id }}" data-balance="{{ $value->balance }}"
                                        data-user="{{ $value->user->full_name }}" data-type="{{ $value->type->getName() }}">
                                        {{ $value->user->full_name }} ({{ $value->type->getName() }}) -
                                        {{ formatCurrency($value->balance) }}
                                    </option>
                                @endforeach
                            </select>

                            <div id="from-preview" class="lira-transfer-preview d-none">
                                <span class="text-muted small">الرصيد الحالي</span>
                                <strong id="from-balance-text">0.00</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Middle Arrow --}}
                <div class="col-lg-2 d-none d-lg-flex align-items-center justify-content-center">
                    <div class="lira-transfer-arrow">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </div>

                {{-- Mobile Arrow --}}
                <div class="col-12 d-lg-none d-flex justify-content-center">
                    <div class="lira-transfer-arrow" style="transform: rotate(90deg);">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                </div>

                {{-- To Section --}}
                <div class="col-lg-5">
                    <div class="lira-transfer-card is-success">
                        <div class="lira-transfer-card-header">
                            <div class="lira-transfer-card-icon is-success">
                                <i class="fa-solid fa-arrow-down-to-bracket"></i>
                            </div>
                            <div>
                                <h5 class="lira-transfer-card-title">إضافة إلى (المستلم)</h5>
                                <p class="lira-transfer-card-subtitle">اختر محفظة المستلم</p>
                            </div>
                        </div>

                        <div class="lira-transfer-card-body">
                            <label class="form-label">محفظة المستلم</label>
                            <select id="to" name="to_id" class="form-select select2-custom" required>
                                <option value="">بحث عن مستخدم أو رقم محفظة...</option>
                                @foreach ($wallets as $value)
                                    <option value="{{ $value->id }}" data-balance="{{ $value->balance }}"
                                        data-user="{{ $value->user->full_name }}" data-type="{{ $value->type->getName() }}">
                                        {{ $value->user->full_name }} ({{ $value->type->getName() }}) -
                                        {{ formatCurrency($value->balance) }}
                                    </option>
                                @endforeach
                            </select>

                            <div id="to-preview" class="lira-transfer-preview d-none">
                                <span class="text-muted small">الرصيد الحالي</span>
                                <strong id="to-balance-text">0.00</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Amount & Action --}}
                <div class="col-12">
                    <div class="lira-data-panel">
                        <div class="lira-data-panel-body">
                            <div class="row g-4 align-items-end justify-content-center">
                                <div class="col-md-6 col-lg-5 col-xl-4">
                                    <label class="form-label">مبلغ التحويل</label>
                                    <div class="input-group" style="direction: ltr;">
                                        <input type="number" name="amount" class="form-control"
                                            placeholder="0.00" required min="0.01" step="0.01"
                                            style="min-height: 56px; text-align: right; border-radius: 14px 0 0 14px !important;">
                                        <span class="input-group-text" style="background: var(--lira-accent) !important; color: #0a1220 !important; border-radius: 0 14px 14px 0 !important; font-weight: 800; min-height: 56px;">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-4 col-xl-3">
                                    <button type="submit" class="btn btn-primary w-100" style="min-height: 56px;">
                                        <i class="fa-solid fa-check-double ms-2"></i>
                                        تأكيد عملية التحويل
                                    </button>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="text-muted small mb-0">
                                        <i class="fa-solid fa-circle-info ms-1"></i>
                                        سيتم تنفيذ العملية فوراً وتحديث أرصدة الطرفين.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .lira-transfer-card {
            height: 100%;
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                var(--lira-surface);
            border: 1px solid var(--lira-border);
            overflow: hidden;
        }

        .lira-transfer-card.is-danger { border-top: 3px solid var(--lira-danger); }
        .lira-transfer-card.is-success { border-top: 3px solid var(--lira-success); }

        .lira-transfer-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--lira-border);
        }

        .lira-transfer-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            font-size: 18px;
        }

        .lira-transfer-card-icon.is-danger {
            color: var(--lira-danger);
            background: rgba(240, 68, 56, 0.10);
        }

        .lira-transfer-card-icon.is-success {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-transfer-card-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            color: var(--lira-text);
        }

        .lira-transfer-card-subtitle {
            margin: 4px 0 0;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-transfer-card-body {
            padding: 22px 24px;
        }

        .lira-transfer-preview {
            margin-top: 18px;
            padding: 16px;
            border-radius: 16px;
            background: rgba(255,255,255,0.025);
            border: 1px dashed var(--lira-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lira-transfer-preview strong {
            font-size: 1.25rem;
            color: var(--lira-text);
        }

        .lira-transfer-arrow {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--lira-accent);
            color: #0a1220;
            font-size: 22px;
            animation: lira-pulse-arrow 2s infinite;
        }

        @keyframes lira-pulse-arrow {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 230, 167, 0.35); }
            50% { transform: scale(1.06); box-shadow: 0 0 0 12px rgba(0, 230, 167, 0); }
        }

        /* Select2 Theme Override */
        .select2-container--default .select2-selection--single {
            background-color: rgba(255,255,255,0.03) !important;
            border: 1px solid var(--lira-border) !important;
            height: 50px !important;
            display: flex;
            align-items: center;
            color: var(--lira-text) !important;
            border-radius: 14px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--lira-text) !important;
            text-align: right;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px !important;
        }

        .select2-dropdown {
            background-color: var(--lira-surface-2) !important;
            border-color: var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: 14px !important;
        }

        .select2-search__field {
            background-color: rgba(255,255,255,0.03) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: 10px !important;
            min-height: 40px !important;
        }

        .select2-results__option {
            color: var(--lira-text-soft) !important;
            padding: 10px 14px !important;
        }

        .select2-results__option--highlighted {
            background-color: rgba(0, 230, 167, 0.14) !important;
            color: var(--lira-accent) !important;
        }

        .select2-results__option--selected {
            background-color: rgba(0, 230, 167, 0.08) !important;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush

@push('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2-custom').select2({
                dir: 'rtl',
                width: '100%',
                language: {
                    noResults: () => "لا توجد نتائج"
                }
            });

            $('#from').on('change', function () {
                const selectedVal = $(this).val();
                const toSelect = $('#to');

                if (toSelect.val() === selectedVal && selectedVal !== "") {
                    toSelect.val(null).trigger('change');
                    if (window.showNotification) {
                        window.showNotification('لا يمكن اختيار نفس المحفظة للإرسال والاستقبال', 'warning');
                    } else {
                        alert('لا يمكن اختيار نفس المحفظة للإرسال والاستقبال');
                    }
                }

                const selected = $(this).find('option:selected');
                if (selectedVal) {
                    $('#from-preview').removeClass('d-none');
                    $('#from-balance-text').text('$' + parseFloat(selected.data('balance')).toLocaleString());
                } else {
                    $('#from-preview').addClass('d-none');
                }
            });

            $('#to').on('change', function () {
                const selectedVal = $(this).val();
                const fromSelect = $('#from');

                if (fromSelect.val() === selectedVal && selectedVal !== "") {
                    fromSelect.val(null).trigger('change');
                    if (window.showNotification) {
                        window.showNotification('لا يمكن اختيار نفس المحفظة للإرسال والاستقبال', 'warning');
                    } else {
                        alert('لا يمكن اختيار نفس المحفظة للإرسال والاستقبال');
                    }
                }

                const selected = $(this).find('option:selected');
                if (selectedVal) {
                    $('#to-preview').removeClass('d-none');
                    $('#to-balance-text').text('$' + parseFloat(selected.data('balance')).toLocaleString());
                } else {
                    $('#to-preview').addClass('d-none');
                }
            });
        });
    </script>
@endpush

