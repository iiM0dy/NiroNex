@php
    $niroFlashMessages = [];
    foreach (['success', 'warning', 'error', 'info'] as $niroFlashType) {
        if (session($niroFlashType)) {
            $niroFlashMessages[] = [
                'type' => $niroFlashType,
                'message' => (string) session($niroFlashType),
            ];
        }
    }
@endphp

<style>
    .niro-feedback-root {
        position: relative;
        z-index: 1200;
    }

    .niro-toast-stack {
        position: fixed;
        top: 18px;
        inset-inline-end: 18px;
        width: min(380px, calc(100vw - 24px));
        display: grid;
        gap: 10px;
        z-index: 1205;
        pointer-events: none;
    }

    .niro-toast {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: start;
        gap: 12px;
        padding: 14px 14px 14px 16px;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(14, 18, 27, 0.96);
        color: #f4f6fa;
        box-shadow: 0 18px 44px rgba(0, 0, 0, 0.24);
        transform: translateY(-8px);
        opacity: 0;
        transition: opacity 0.22s ease, transform 0.22s ease;
        pointer-events: auto;
    }

    .niro-toast.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .niro-toast__icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        font-size: 15px;
    }

    .niro-toast__body {
        min-width: 0;
        display: grid;
        gap: 4px;
    }

    .niro-toast__title {
        font-size: 13px;
        font-weight: 800;
        line-height: 1.35;
        color: #f4f6fa;
    }

    .niro-toast__message {
        color: #cdd5e1;
        font-size: 13px;
        line-height: 1.75;
        overflow-wrap: anywhere;
    }

    .niro-toast__close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #a7b0c0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.18s ease, color 0.18s ease;
    }

    .niro-toast__close:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #f4f6fa;
    }

    .niro-toast--success .niro-toast__icon {
        background: rgba(0, 230, 167, 0.12);
        color: #00e6a7;
    }

    .niro-toast--error .niro-toast__icon {
        background: rgba(240, 68, 56, 0.14);
        color: #ff8a80;
    }

    .niro-toast--warning .niro-toast__icon {
        background: rgba(120, 97, 255, 0.14);
        color: #c4b6ff;
    }

    .niro-toast--info .niro-toast__icon {
        background: rgba(26, 43, 255, 0.14);
        color: #8ea1ff;
    }

    .niro-dialog-backdrop {
        position: fixed;
        inset: 0;
        padding: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(4, 7, 12, 0.6);
        backdrop-filter: blur(6px);
        z-index: 1210;
    }

    .niro-dialog-backdrop.is-open {
        display: flex;
    }

    .niro-dialog {
        width: min(460px, 100%);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: #11161f;
        color: #f4f6fa;
        box-shadow: 0 26px 70px rgba(0, 0, 0, 0.34);
        overflow: hidden;
    }

    .niro-dialog__head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 22px 22px 14px;
    }

    .niro-dialog__badge {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        font-size: 17px;
    }

    .niro-dialog__content {
        min-width: 0;
        flex: 1 1 auto;
    }

    .niro-dialog__title {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.35;
        color: #f4f6fa;
    }

    .niro-dialog__text {
        margin: 8px 0 0;
        color: #c5cad3;
        font-size: 14px;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .niro-dialog__actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 22px 22px;
    }

    .niro-dialog__btn {
        min-height: 42px;
        padding: 0 18px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.04);
        color: #f4f6fa;
        font-size: 13px;
        font-weight: 800;
        transition: background 0.18s ease, border-color 0.18s ease, color 0.18s ease;
    }

    .niro-dialog__btn:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .niro-dialog__btn--primary {
        background: #00e6a7;
        border-color: rgba(0, 230, 167, 0.18);
        color: #0d1117;
    }

    .niro-dialog__btn--primary:hover {
        background: #19eeb1;
        border-color: rgba(0, 230, 167, 0.24);
        color: #0d1117;
    }

    .niro-dialog--success .niro-dialog__badge {
        background: rgba(0, 230, 167, 0.12);
        color: #00e6a7;
    }

    .niro-dialog--error .niro-dialog__badge {
        background: rgba(240, 68, 56, 0.14);
        color: #ff8a80;
    }

    .niro-dialog--warning .niro-dialog__badge {
        background: rgba(120, 97, 255, 0.14);
        color: #c4b6ff;
    }

    .niro-dialog--info .niro-dialog__badge {
        background: rgba(26, 43, 255, 0.14);
        color: #8ea1ff;
    }

    body.niro-dialog-open {
        overflow: hidden !important;
    }

    @media (max-width: 767.98px) {
        .niro-toast-stack {
            top: 12px;
            inset-inline-start: 12px;
            inset-inline-end: 12px;
            width: auto;
        }

        .niro-toast {
            padding: 12px 12px 12px 14px;
            border-radius: 16px;
        }

        .niro-dialog-backdrop {
            padding: 14px;
        }

        .niro-dialog {
            border-radius: 22px;
        }

        .niro-dialog__head {
            padding: 18px 18px 12px;
        }

        .niro-dialog__actions {
            padding: 0 18px 18px;
            flex-wrap: wrap;
        }

        .niro-dialog__btn {
            flex: 1 1 calc(50% - 5px);
        }
    }
</style>

<div class="niro-feedback-root" id="niroFeedbackRoot" aria-live="polite">
    <div class="niro-toast-stack" id="niroToastStack"></div>

    <div class="niro-dialog-backdrop" id="niroDialogBackdrop" hidden>
        <div class="niro-dialog niro-dialog--info" id="niroDialog" role="alertdialog" aria-modal="true" aria-labelledby="niroDialogTitle" aria-describedby="niroDialogText">
            <div class="niro-dialog__head">
                <div class="niro-dialog__badge" id="niroDialogBadge">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="niro-dialog__content">
                    <h3 class="niro-dialog__title" id="niroDialogTitle">تنبيه</h3>
                    <p class="niro-dialog__text" id="niroDialogText"></p>
                </div>
            </div>
            <div class="niro-dialog__actions">
                <button type="button" class="niro-dialog__btn" id="niroDialogCancel">إلغاء</button>
                <button type="button" class="niro-dialog__btn niro-dialog__btn--primary" id="niroDialogConfirm">حسنًا</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const flashMessages = @json($niroFlashMessages);

        if (!window.NiroFeedback) {
            const toastStack = document.getElementById('niroToastStack');
            const dialogBackdrop = document.getElementById('niroDialogBackdrop');
            const dialog = document.getElementById('niroDialog');
            const dialogBadge = document.getElementById('niroDialogBadge');
            const dialogTitle = document.getElementById('niroDialogTitle');
            const dialogText = document.getElementById('niroDialogText');
            const dialogCancel = document.getElementById('niroDialogCancel');
            const dialogConfirm = document.getElementById('niroDialogConfirm');

            const typeMap = {
                success: { icon: 'fa-circle-check', title: 'تم بنجاح' },
                error: { icon: 'fa-circle-exclamation', title: 'حدث خطأ' },
                warning: { icon: 'fa-triangle-exclamation', title: 'تنبيه' },
                info: { icon: 'fa-circle-info', title: 'معلومة' }
            };

            let activeResolver = null;
            let activeOptions = null;

            function normalizeType(type) {
                return typeMap[type] ? type : 'info';
            }

            function closeDialog(result) {
                dialogBackdrop.classList.remove('is-open');
                dialogBackdrop.hidden = true;
                document.body.classList.remove('niro-dialog-open');
                dialogCancel.style.display = 'none';
                activeOptions = null;
                if (activeResolver) {
                    activeResolver(result);
                    activeResolver = null;
                }
            }

            function createToast(message, type = 'info', options = {}) {
                if (!toastStack || !message) {
                    return;
                }

                const safeType = normalizeType(type);
                const meta = typeMap[safeType];
                const toast = document.createElement('div');
                toast.className = `niro-toast niro-toast--${safeType}`;
                toast.innerHTML = `
                    <div class="niro-toast__icon">
                        <i class="fa-solid ${meta.icon}"></i>
                    </div>
                    <div class="niro-toast__body">
                        <strong class="niro-toast__title">${options.title || meta.title}</strong>
                        <div class="niro-toast__message"></div>
                    </div>
                    <button type="button" class="niro-toast__close" aria-label="إغلاق">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                toast.querySelector('.niro-toast__message').textContent = String(message);
                toastStack.appendChild(toast);

                const removeToast = () => {
                    toast.classList.remove('is-visible');
                    window.setTimeout(() => toast.remove(), 220);
                };

                toast.querySelector('.niro-toast__close').addEventListener('click', removeToast);
                window.setTimeout(() => toast.classList.add('is-visible'), 16);
                window.setTimeout(removeToast, Number(options.duration || 4200));
            }

            function openDialog(message, options = {}) {
                const safeType = normalizeType(options.type || 'info');
                const meta = typeMap[safeType];

                dialog.className = `niro-dialog niro-dialog--${safeType}`;
                dialogBadge.innerHTML = `<i class="fa-solid ${meta.icon}"></i>`;
                dialogTitle.textContent = options.title || meta.title;
                dialogText.textContent = String(message || '');
                dialogConfirm.textContent = options.confirmText || 'حسنًا';
                dialogCancel.textContent = options.cancelText || 'إلغاء';
                dialogCancel.style.display = options.showCancel ? 'inline-flex' : 'none';
                dialogBackdrop.hidden = false;
                dialogBackdrop.classList.add('is-open');
                document.body.classList.add('niro-dialog-open');
                activeOptions = options;
                window.setTimeout(() => dialogConfirm.focus(), 10);

                return new Promise(resolve => {
                    activeResolver = resolve;
                });
            }

            dialogConfirm.addEventListener('click', function () {
                closeDialog({ confirmed: true });
            });

            dialogCancel.addEventListener('click', function () {
                closeDialog({ confirmed: false });
            });

            dialogBackdrop.addEventListener('click', function (event) {
                if (event.target === dialogBackdrop) {
                    if (activeOptions && activeOptions.showCancel) {
                        closeDialog({ confirmed: false });
                        return;
                    }
                    closeDialog({ confirmed: true });
                }
            });

            document.addEventListener('keydown', function (event) {
                if (!dialogBackdrop.classList.contains('is-open')) {
                    return;
                }

                if (event.key === 'Escape') {
                    event.preventDefault();
                    if (activeOptions && activeOptions.showCancel) {
                        closeDialog({ confirmed: false });
                        return;
                    }
                    closeDialog({ confirmed: true });
                }
            });

            document.addEventListener('submit', function (event) {
                const form = event.target.closest('form[data-niro-confirm]');
                if (!form || form.dataset.niroConfirmHandled === 'true') {
                    return;
                }

                event.preventDefault();

                openDialog(form.dataset.niroConfirmMessage || 'هل أنت متأكد من المتابعة؟', {
                    type: form.dataset.niroConfirmType || 'warning',
                    title: form.dataset.niroConfirmTitle || 'تأكيد الإجراء',
                    confirmText: form.dataset.niroConfirmButton || 'متابعة',
                    cancelText: form.dataset.niroCancelButton || 'إلغاء',
                    showCancel: true
                }).then(result => {
                    if (!result || !result.confirmed) {
                        return;
                    }

                    form.dataset.niroConfirmHandled = 'true';
                    HTMLFormElement.prototype.submit.call(form);
                });
            });

            const nativeAlert = window.alert ? window.alert.bind(window) : null;

            window.NiroFeedback = {
                toast: createToast,
                dialog: openDialog,
                nativeAlert: nativeAlert
            };

            window.showNotification = function (message, type = 'info', options = {}) {
                createToast(message, type, options);
            };

            window.showNiroToast = window.showNotification;

            window.showNiroDialog = function (message, options = {}) {
                return openDialog(message, options);
            };

            window.alert = function (message) {
                openDialog(message, {
                    type: 'warning',
                    title: 'تنبيه',
                    confirmText: 'حسنًا'
                });
            };
        }

        if (Array.isArray(flashMessages) && flashMessages.length) {
            const queueFlash = function () {
                flashMessages.forEach(function (item, index) {
                    window.setTimeout(function () {
                        if (window.NiroFeedback && typeof window.NiroFeedback.toast === 'function') {
                            window.NiroFeedback.toast(item.message, item.type);
                        }
                    }, index * 140);
                });
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', queueFlash, { once: true });
            } else {
                queueFlash();
            }
        }
    })();
</script>
