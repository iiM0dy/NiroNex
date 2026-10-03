@php
    $tableId = 'liraTable_' . uniqid();
    $imageModalId = 'imageModal_' . uniqid();
    $actionModalId = 'actionModal_' . uniqid();
    $editAmountModalId = 'editAmountModal_' . uniqid();

    $hasActions = !empty($actions);
    $hasImageColumn = array_key_exists('image', $columns ?? []);
    $hasApproveReject = collect($actions ?? [])->contains(fn ($a) => in_array($a['type'] ?? null, ['approve', 'reject']));
    $hasEditAmount = collect($actions ?? [])->contains(fn ($a) => ($a['type'] ?? null) === 'edit-amount');

    $isPaginator = $nativeData && method_exists($nativeData, 'links');
    $columnKeys = array_keys($columns ?? []);
    $mobilePrimaryKeys = match (true) {
        in_array('user', $columnKeys, true) && in_array('type', $columnKeys, true) => ['user', 'type'],
        in_array('name', $columnKeys, true) && in_array('status', $columnKeys, true) => ['name', 'status'],
        in_array('user', $columnKeys, true) && in_array('display_id', $columnKeys, true) => ['user', 'display_id'],
        in_array('display_id', $columnKeys, true) && in_array('type', $columnKeys, true) => ['display_id', 'type'],
        default => array_slice($columnKeys, 0, 2),
    };

    $normalizeStatus = function ($value) {
        return mb_strtolower(trim(strip_tags((string) $value)));
    };
@endphp

<div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4" style="background: var(--lira-card);">
    @if ($title)
        <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="fw-bold m-0 text-white">{{ $title }}</h5>

            @if ($isSearchable)
                <form method="GET" class="mb-0">
                    <div class="input-group search-group" style="direction: ltr; min-width: 280px;">
                        <button type="submit" class="btn btn-search px-3" style="border-radius: 10px 0 0 10px !important;">
                            <i class="fa fa-search ycolor"></i>
                        </button>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control search-input"
                            placeholder="بحث في البيانات..."
                            style="border-radius: 0 10px 10px 0 !important; text-align: right;"
                        >
                    </div>
                </form>
            @endif
        </div>
    @endif

    <div class="card-body p-0">
        <div class="table-responsive lira-table-wrap">
            <table class="table align-middle mb-0 lira-data-table lira-has-mobile-priorities" style="width:100% !important" id="{{ $tableId }}">
                <thead>
                    <tr>
                        @foreach ($columns as $col)
                            <th>{{ $col }}</th>
                        @endforeach

                        @if ($hasActions)
                            <th style="min-width: 180px;">الإجراءات</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rows as $row)
                        <tr>
                            @foreach (array_keys($columns) as $key)
                                @php
                                    $mobilePrimaryIndex = array_search($key, $mobilePrimaryKeys, true);
                                    $mobilePriorityClass = $mobilePrimaryIndex === 0
                                        ? ' lira-mobile-primary lira-mobile-primary-main'
                                        : ($mobilePrimaryIndex === 1 ? ' lira-mobile-primary lira-mobile-primary-side' : '');
                                @endphp
                                <td class="{{ trim($mobilePriorityClass) }}" data-label="{{ $columns[$key] }}">
                                    @if ($key === 'image' && !empty($row['image']))
                                        <img
                                            src="{{ $row['image'] }}"
                                            alt="صورة"
                                            class="img-thumbnail"
                                            style="max-width: 70px; cursor: pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#{{ $imageModalId }}"
                                            data-image="{{ $row['image'] }}"
                                        >
                                    @else
                                        {!! $row[$key] ?? '--' !!}
                                    @endif
                                </td>
                            @endforeach

                            @if ($hasActions)
                                <td data-label="الإجراءات">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($actions as $action)
                                            @php
                                                $statusPlain = $normalizeStatus($row['status'] ?? '');
                                                $isPendingStatus = \Illuminate\Support\Str::contains($statusPlain, ['pending', 'معلق', 'قيد', 'بانتظار']);
                                                $isAcceptedStatus = \Illuminate\Support\Str::contains($statusPlain, ['accepted', 'مقبول', 'مكتمل']);

                                                $shouldShow = true;

                                                if (in_array($action['type'], ['approve', 'reject']) && !$isPendingStatus) {
                                                    $shouldShow = false;
                                                }

                                                if (($action['type'] ?? null) === 'delete' && $isAcceptedStatus) {
                                                    $shouldShow = false;
                                                }
                                            @endphp

                                            @if ($shouldShow)
                                                @if ($action['type'] === 'edit')
                                                    <a href="{{ route($action['route'], $row[$action['key']]) }}"
                                                        class="btn btn-sm btn-primary text-white">
                                                        تعديل
                                                    </a>

                                                @elseif($action['type'] === 'edit-amount')
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-warning text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#{{ $editAmountModalId }}"
                                                        data-id="{{ $row['id'] }}"
                                                        data-amount="{{ preg_replace('/[^\d.\-]/', '', strip_tags($row['amount'] ?? '0')) }}"
                                                    >
                                                        تعديل المبلغ
                                                    </button>

                                                @elseif($action['type'] === 'delete')
                                                    <form
                                                        action="{{ route($action['route'], $row[$action['key']]) }}"
                                                        method="POST"
                                                        style="display:inline-block"
                                                        data-niro-confirm="true"
                                                        data-niro-confirm-message="هل أنت متأكد من الحذف؟"
                                                        data-niro-confirm-title="تأكيد الحذف"
                                                        data-niro-confirm-type="warning"
                                                        data-niro-confirm-button="نعم، احذف"
                                                        data-niro-cancel-button="إلغاء"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger text-white">حذف</button>
                                                    </form>

                                                @elseif($action['type'] === 'approve')
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-success text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#{{ $actionModalId }}"
                                                        data-action="approve"
                                                        data-id="{{ $row['id'] }}"
                                                    >
                                                        قبول
                                                    </button>

                                                @elseif($action['type'] === 'reject')
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#{{ $actionModalId }}"
                                                        data-action="reject"
                                                        data-id="{{ $row['id'] }}"
                                                    >
                                                        رفض
                                                    </button>

                                                @elseif($action['type'] === 'show')
                                                    <a
                                                        href="{{ route($action['route'], $row[$action['key']]) }}"
                                                        class="btn btn-sm btn-info text-white"
                                                    >
                                                        تفاصيل
                                                    </a>

                                                @elseif($action['type'] === 'custom' && isset($action['html']))
                                                    {!! str_replace(['{id}'], [$row[$action['key']]], $action['html']) !!}
                                                @elseif($action['type'] === 'custom' && isset($action['route']))
                                                    <a
                                                        href="{{ route($action['route'], $row[$action['key']]) }}"
                                                        class="{{ $action['class'] ?? 'btn btn-sm btn-info text-white' }}"
                                                    >
                                                        {{ $action['label'] ?? 'فتح' }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger fw-bold py-4" colspan="{{ count($columns) + ($hasActions ? 1 : 0) }}">
                                لا يوجد بيانات
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($isPaginator)
        <div class="mt-3 px-3 pb-3">
            {{ $nativeData->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@if ($hasImageColumn)
    <div class="modal fade" id="{{ $imageModalId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="" id="{{ $imageModalId }}_img" class="img-fluid w-100" alt="صورة">
                </div>
            </div>
        </div>
    </div>
@endif

@if ($hasApproveReject)
    <div class="modal fade" id="{{ $actionModalId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog lira-modal-dialog">
            <form method="POST" id="{{ $actionModalId }}_form">
                @csrf
                <div class="modal-content lira-modal-content border-0">
                    <div class="modal-header border-bottom border-light border-opacity-10 py-3">
                        <h5 class="modal-title fw-bold text-white">تأكيد العملية</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-4">
                        <input type="hidden" name="action_type" id="{{ $actionModalId }}_action_type">
                        <input type="hidden" name="request_id" id="{{ $actionModalId }}_request_id">

                        <div class="mb-0">
                            <label for="{{ $actionModalId }}_admin_note" class="form-label fw-bold text-muted small">ملاحظة إدارية (اختياري)</label>
                            <textarea name="admin_note" id="{{ $actionModalId }}_admin_note" class="form-control lira-form-control" rows="3" placeholder="أضف سبباً للقبول أو الرفض..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-light border-opacity-10 py-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">تأكيد التنفيذ</button>
                        <button type="button" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

@if ($hasEditAmount)
    <div class="modal fade" id="{{ $editAmountModalId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog lira-modal-dialog">
            <form method="POST" id="{{ $editAmountModalId }}_form">
                @csrf
                @method('PUT')

                <div class="modal-content lira-modal-content border-0">
                    <div class="modal-header border-bottom border-light border-opacity-10 py-3">
                        <h5 class="modal-title fw-bold text-white">تعديل مبلغ المعاملة</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-4">
                        <input type="hidden" name="id" id="{{ $editAmountModalId }}_id">

                        <div class="mb-0">
                            <label for="{{ $editAmountModalId }}_amount" class="form-label fw-bold text-muted small">المبلغ الجديد</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-white fw-bold">$</span>
                                <input
                                    type="number"
                                    min="0.01"
                                    step="0.01"
                                    name="amount"
                                    id="{{ $editAmountModalId }}_amount"
                                    class="form-control lira-form-control ps-2"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-light border-opacity-10 py-3">
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-bold">حفظ التغييرات</button>
                        <button type="button" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

@push('custom_styles')
    @once
        <link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') !!}">
        <style>
            .lira-modal-dialog {
                max-width: 420px !important;
                margin-top: 50px;
            }

            .lira-modal-content {
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.01)), #0a101d !important;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                border-radius: 28px !important;
                box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6);
            }

            .lira-form-control {
                background: rgba(255, 255, 255, 0.03) !important;
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                border-radius: 14px !important;
                color: #fff !important;
                padding: 12px 16px !important;
                transition: all 0.2s ease;
            }

            .lira-form-control:focus {
                background: rgba(255, 255, 255, 0.05) !important;
                border-color: var(--lira-accent) !important;
                box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.1) !important;
            }

            .lira-table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .lira-data-table {
                min-width: 980px;
            }

            .lira-data-table thead th {
                white-space: nowrap;
            }

            .lira-data-table tbody td {
                white-space: nowrap;
            }

            .lira-data-table tbody td:last-child {
                white-space: normal;
            }

            .lira-data-table .btn {
                white-space: nowrap;
            }

            @media (max-width: 991.98px) {
                .lira-data-table {
                    min-width: 0 !important;
                }

                .dataTables_wrapper .dataTables_scroll,
                .dataTables_wrapper .dataTables_scrollBody {
                    overflow: visible !important;
                    width: 100% !important;
                }

                .dataTables_wrapper .dataTables_scrollHead {
                    display: none !important;
                }

                .lira-table-wrap {
                    overflow: visible !important;
                }

                .table-responsive.lira-mobile-stack td .d-flex {
                    width: 100%;
                }
            }
        </style>
    @endonce
@endpush

@push('custom_scripts')
    @once
        <script src="{!! backendAssets('dist/assets/bundles/dataTables.bundle.js') !!}"></script>
    @endonce

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableElement = $('#{{ $tableId }}');

            if (tableElement.length) {
                tableElement.DataTable({
                    paging: false,
                    info: false,
                    searching: false,
                    ordering: false,
                    responsive: false,
                    autoWidth: false,
                    scrollX: window.innerWidth > 991,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json'
                    }
                });
            }

            @if ($hasApproveReject)
                const actionModal = document.getElementById('{{ $actionModalId }}');
                if (actionModal) {
                    actionModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        if (!button) return;

                        const action = button.getAttribute('data-action');
                        const id = button.getAttribute('data-id');

                        const form = document.getElementById('{{ $actionModalId }}_form');
                        const routeApprove = "{{ route('admin.transactions-requests.approve', ':id') }}";
                        const routeReject = "{{ route('admin.transactions-requests.reject', ':id') }}";

                        form.setAttribute('action', (action === 'approve' ? routeApprove : routeReject).replace(':id', id));
                        document.getElementById('{{ $actionModalId }}_action_type').value = action;
                        document.getElementById('{{ $actionModalId }}_request_id').value = id;
                    });
                }
            @endif

            @if ($hasImageColumn)
                const imageModal = document.getElementById('{{ $imageModalId }}');
                if (imageModal) {
                    imageModal.addEventListener('show.bs.modal', function (event) {
                        const img = event.relatedTarget;
                        if (!img) return;

                        const src = img.getAttribute('data-image');
                        const modalImage = document.getElementById('{{ $imageModalId }}_img');
                        if (modalImage) {
                            modalImage.src = src;
                        }
                    });
                }
            @endif

            @if ($hasEditAmount)
                const editAmountModal = document.getElementById('{{ $editAmountModalId }}');
                if (editAmountModal) {
                    editAmountModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        if (!button) return;

                        const id = button.getAttribute('data-id');
                        const amount = button.getAttribute('data-amount');

                        const form = document.getElementById('{{ $editAmountModalId }}_form');
                        const actionUrl = "{{ route('admin.transactions.update', ':id') }}".replace(':id', id);

                        form.setAttribute('action', actionUrl);
                        document.getElementById('{{ $editAmountModalId }}_id').value = id;
                        document.getElementById('{{ $editAmountModalId }}_amount').value = amount;
                    });
                }
            @endif
        });
    </script>
@endpush

