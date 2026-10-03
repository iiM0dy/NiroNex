@extends('layouts.site-dash')

@if ($transactionType === \App\Enums\TransactionRequestType::Withdrawal->value)
    @section('title', 'طلب سحب')
@elseif ($transactionType === \App\Enums\TransactionRequestType::Deposit->value)
    @section('title', 'طلب إيداع')
@elseif ($transactionType === \App\Enums\TransactionRequestType::InternalTransfer->value)
    @section('title', 'طلب تحويل داخلي')
@endif

@section('content')
    <div class="lira-request-page">
        @if ($transactionType === \App\Enums\TransactionRequestType::Withdrawal->value)
            @include('site.transactions-requests._withdrawal')
        @elseif ($transactionType === \App\Enums\TransactionRequestType::Deposit->value)
            @include('site.transactions-requests._deposit')
        @elseif ($transactionType === \App\Enums\TransactionRequestType::InternalTransfer->value)
            @include('site.transactions-requests._internal-transfers')
        @endif
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-request-page .lira-page-header {
            margin-bottom: 22px;
        }

        .lira-transfer-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 18px;
            align-items: start;
        }

        .lira-transfer-card {
            min-width: 0;
        }

        .lira-transfer-side {
            display: grid;
            gap: 14px;
            position: sticky;
            top: 96px;
        }

        .lira-request-page .card {
            background:
                linear-gradient(135deg, rgba(0, 230, 167, 0.055), rgba(26, 43, 255, 0.025)),
                rgba(16, 20, 28, 0.86) !important;
            border: 1px solid rgba(255, 255, 255, 0.075) !important;
            border-top: 1px solid rgba(0, 230, 167, 0.24) !important;
            border-radius: 22px !important;
            box-shadow: none !important;
            backdrop-filter: none;
        }

        .lira-request-page .card-body {
            padding: clamp(22px, 4vw, 44px) !important;
        }

        .lira-form-section {
            padding-bottom: 26px;
            margin-bottom: 26px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-section-heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .lira-section-heading > span {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            background: rgba(0, 230, 167, 0.10);
            border: 1px solid rgba(0, 230, 167, 0.20);
            color: var(--lira-accent);
            font-size: 12px;
            font-weight: 800;
            direction: ltr;
        }

        .lira-section-heading h2 {
            margin: 0 0 4px;
            color: var(--lira-text);
            font-size: 1rem;
            font-weight: 800;
            line-height: 1.5;
        }

        .lira-section-heading p {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-request-page .form-label {
            color: var(--lira-text-soft) !important;
            font-size: 13px;
            letter-spacing: 0;
        }

        .lira-request-page .lira-input-wrap,
        .lira-request-page .lira-select-wrap {
            position: relative;
        }

        .lira-request-page .lira-input-icon {
            position: absolute;
            top: 50%;
            inset-inline-start: 16px;
            transform: translateY(-50%);
            color: var(--lira-text-muted);
            z-index: 2;
            font-size: 14px;
            pointer-events: none;
        }

        .lira-request-page .lira-input-wrap.is-recipient-email .form-control {
            direction: ltr;
            text-align: left;
            padding-right: 58px !important;
            padding-left: 16px !important;
        }

        .lira-field-hint {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 9px;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .lira-field-hint i {
            color: var(--lira-accent);
            font-size: 12px;
        }

        .lira-request-page .form-control,
        .lira-request-page .form-select {
            min-height: 56px;
            padding-inline-start: 48px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, 0.035) !important;
            border: 1px solid rgba(255, 255, 255, 0.075) !important;
            transition: border-color 0.18s ease, background-color 0.18s ease;
        }

        .lira-request-page .form-control:focus,
        .lira-request-page .form-select:focus {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(0, 230, 167, 0.46) !important;
            box-shadow: none !important;
        }

        .lira-request-page .lira-select-wrap .form-select {
            appearance: none;
            -webkit-appearance: none;
            color-scheme: dark;
            background-image:
                linear-gradient(45deg, transparent 50%, #8d96a5 50%),
                linear-gradient(135deg, #8d96a5 50%, transparent 50%) !important;
            background-position:
                left 20px center,
                left 14px center !important;
            background-size:
                6px 6px,
                6px 6px !important;
            background-repeat: no-repeat !important;
            padding-inline-end: 16px !important;
        }

        .lira-request-page .form-select option,
        .lira-request-page select option {
            background: #10141c !important;
            color: #f7f8fa !important;
        }

        .lira-request-page .form-select option:checked,
        .lira-request-page select option:checked {
            background: #00e6a7 !important;
            color: #06110f !important;
        }

        .lira-request-page .form-select option:hover,
        .lira-request-page select option:hover {
            background: #141a23 !important;
            color: #ffffff !important;
        }

        .lira-method-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-request-page .wallet-select-card,
        .lira-request-page .payment-info-box,
        .lira-request-page .upload-area {
            background: rgba(255, 255, 255, 0.032) !important;
            border: 1px solid rgba(255, 255, 255, 0.075) !important;
            box-shadow: none;
        }

        .lira-request-page .wallet-select-card:hover,
        .lira-request-page .upload-area:hover {
            border-color: rgba(0, 230, 167, 0.32) !important;
            transform: none;
        }

        .lira-request-page .btn-check:checked + .wallet-select-card {
            background: rgba(0, 230, 167, 0.08) !important;
            border-color: rgba(0, 230, 167, 0.42) !important;
            box-shadow: none !important;
        }

        .lira-wallet-tile {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 18px;
            border-radius: 18px !important;
            color: var(--lira-text) !important;
            text-align: start;
            cursor: pointer;
        }

        .lira-wallet-tile__icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            flex: 0 0 auto;
        }

        .lira-wallet-tile__copy strong,
        .lira-wallet-tile__copy small {
            display: block;
        }

        .lira-wallet-tile__copy strong {
            margin-bottom: 3px;
            color: var(--lira-text);
            font-size: 14px;
            font-weight: 800;
        }

        .lira-wallet-tile__copy small {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-wallet-tile__amount {
            color: var(--lira-accent);
            font-weight: 900;
            direction: ltr;
            white-space: nowrap;
        }

        .lira-request-page .icon-circle {
            background: rgba(0, 230, 167, 0.10) !important;
            color: var(--lira-accent) !important;
        }

        .lira-request-page .method-pill {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 10px;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, 0.035) !important;
            border-color: rgba(255, 255, 255, 0.075) !important;
            color: var(--lira-text-soft) !important;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.18s ease, background-color 0.18s ease, color 0.18s ease;
        }

        .lira-request-page .method-pill i {
            color: var(--lira-accent);
            font-size: 13px;
        }

        .lira-request-page .method-pill:hover,
        .lira-request-page .btn-check:checked + .method-pill {
            background: rgba(0, 230, 167, 0.10) !important;
            border-color: rgba(0, 230, 167, 0.40) !important;
            color: var(--lira-accent) !important;
            transform: none;
        }

        .lira-request-page .payment-info-box {
            border-style: solid !important;
            padding: 18px;
            border-radius: 18px;
        }

        .lira-copy-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .lira-copy-head strong {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text);
            font-size: 14px;
        }

        .lira-copy-head span {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-copy-head > i {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 14px;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
        }

        .lira-copy-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 8px;
        }

        .lira-copy-row .form-control {
            padding-inline: 16px !important;
            direction: ltr;
            text-align: left;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 13px;
        }

        .lira-copy-row .btn,
        .lira-request-page .payment-info-box .input-group .btn {
            border-radius: 14px !important;
            padding-inline: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .lira-request-page textarea.form-control,
        .lira-request-page textarea {
            min-height: 112px;
            padding: 14px 16px !important;
            resize: vertical;
        }

        .lira-request-page .upload-area {
            min-height: 164px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 24px;
            border-style: dashed !important;
            color: var(--lira-text-soft);
            text-align: center;
            cursor: pointer;
        }

        .lira-request-page .upload-area > i {
            color: var(--lira-accent);
            font-size: 30px;
        }

        .lira-request-page .upload-area strong {
            color: var(--lira-text);
            font-size: 15px;
        }

        .lira-request-page .upload-area span {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-request-page .upload-area input[type="file"] {
            width: 1px;
            height: 1px;
            min-height: 1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            pointer-events: none;
        }

        .lira-submit-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 26px;
        }

        .lira-request-page .btn-primary {
            min-height: 52px;
            border: 0 !important;
            background: var(--lira-gold) !important;
            color: #000 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding-inline: 26px;
        }

        .lira-request-page .btn-primary:hover {
            background: #00c891 !important;
            color: #000 !important;
            filter: none;
            transform: none;
        }

        .lira-request-page .alert-danger {
            color: #ffd6d1;
            background: rgba(240, 68, 56, 0.10);
            border: 1px solid rgba(240, 68, 56, 0.18) !important;
            border-radius: 18px;
        }

        .lira-balance-panel,
        .lira-side-panel {
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.075);
            background:
                linear-gradient(135deg, rgba(0, 230, 167, 0.055), rgba(255, 255, 255, 0.02)),
                rgba(16, 20, 28, 0.78);
            backdrop-filter: none;
            box-shadow: none;
        }

        .lira-balance-panel {
            padding: 22px;
        }

        .lira-balance-panel span,
        .lira-balance-panel small,
        .lira-side-kicker {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.7;
        }

        .lira-balance-panel strong {
            display: block;
            margin: 6px 0 3px;
            color: var(--lira-accent);
            font-size: 1.55rem;
            font-weight: 900;
            direction: ltr;
            text-align: right;
        }

        .lira-side-panel {
            padding: 22px;
        }

        .lira-side-kicker {
            margin-bottom: 8px;
            letter-spacing: 0;
            font-weight: 800;
        }

        .lira-side-panel h3 {
            margin: 0 0 16px;
            color: var(--lira-text);
            font-size: 1rem;
            line-height: 1.7;
            font-weight: 800;
        }

        .lira-side-list {
            display: grid;
            gap: 12px;
        }

        .lira-side-list div {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--lira-text-soft);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-side-list i {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            border-radius: 50%;
            background: rgba(0, 230, 167, 0.11);
            color: var(--lira-accent);
            font-size: 10px;
            margin-top: 2px;
        }

        @media (max-width: 1199.98px) {
            .lira-transfer-layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .lira-transfer-side {
                position: static;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                order: -1;
            }
        }

        @media (max-width: 767.98px) {
            .lira-transfer-side {
                grid-template-columns: 1fr;
            }

            .lira-method-grid {
                grid-template-columns: 1fr;
            }

            .lira-copy-row {
                grid-template-columns: 1fr;
            }

            .lira-wallet-tile {
                grid-template-columns: auto minmax(0, 1fr);
            }

            .lira-wallet-tile__amount {
                grid-column: 1 / -1;
                padding-inline-start: 60px;
            }

            .lira-submit-row {
                justify-content: stretch;
            }

            .lira-submit-row .btn {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .lira-request-page .card-body {
                padding: 18px !important;
            }

            .lira-request-page .btn-lg {
                width: 100%;
                padding-inline: 18px !important;
            }

            .lira-request-page .payment-info-box {
                padding: 16px !important;
            }
        }
    </style>
@endpush


@push('custom_scripts')
    <script>
        const methodSelect = document.getElementById('method');
        const typeSelect = document.getElementById('type');
        const transferFieldsContainer = document.getElementById('transfer-fields');
        const oldTransferData = @json(old('transfer_data', []));

        function renderTransferFields() {
            const method = methodSelect.value;
            const type = 'withdraw';

            transferFieldsContainer.innerHTML = '';
            let fields = [{
                name: 'wallet_address',
                label: 'عنوان المحفظة',
                type: 'text',
                icon: 'wallet-fill'
            }];
            {{-- if (type === 'withdraw') {
                if (method === '{{ \App\Enums\TransactionRequestMethod::WireTransfer->value }}') {
                    fields = [{
                            name: 'name',
                            label: 'اسم المستلم',
                            type: 'text',
                            icon: 'person-fill'
                        },
                        {
                            name: 'phone',
                            label: 'رقم الهاتف',
                            type: 'tel',
                            icon: 'telephone-fill'
                        },
                        {
                            name: 'country',
                            label: 'الدولة',
                            type: 'text',
                            icon: 'globe2'
                        },
                        {
                            name: 'address',
                            label: 'العنوان',
                            type: 'text',
                            icon: 'address'
                        },
                    ];
                } else if (method === '{{ \App\Enums\TransactionRequestMethod::USDT->value }}') {
                    fields = [{
                        name: 'wallet_address',
                        label: 'عنوان المحفظة',
                        type: 'text',
                        icon: 'wallet-fill'
                    }];
                }
            } --}}

            fields.forEach(field => {
                const value = oldTransferData[field.name] || '';
                transferFieldsContainer.innerHTML += `
                    <label class="form-label mt-3 d-block">${field.label}</label>
                    <div class="lira-input-wrap animate__animated animate__fadeInUp">
                        <i class="fas fa-wallet lira-input-icon"></i>
                        <input type="${field.type}" name="transfer_data[${field.name}]" 
                               class="form-control" 
                               placeholder="أدخل ${field.label}"
                               value="${value}" required>
                    </div>
                `;
            });
        }

        if (methodSelect && transferFieldsContainer) {
            methodSelect.addEventListener('change', renderTransferFields);
            renderTransferFields();
        }
    </script>
@endpush
