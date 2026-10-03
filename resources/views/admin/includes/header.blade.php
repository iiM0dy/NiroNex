@php
    $user = auth()->user();
    $displayName = $user->full_name ?? $user->name ?? 'Administrator';
    $initial = mb_substr($displayName, 0, 1);
@endphp

<style>
    .lira-admin-topbar {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: rgba(7, 9, 13, 0.65) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        padding: 0 !important; /* Reset outer padding */
        width: 100%;
    }

    .lira-admin-topbar .container-xxl {
        max-width: 1480px !important;
        padding: 0 28px !important; /* Padding inside the centered box */
        margin-inline: auto;
    }

    .lira-admin-topbar-inner {
        min-height: var(--header-height);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 0 !important;
    }

    .lira-admin-topbar-start,
    .lira-admin-topbar-end {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .lira-admin-topbar-start {
        flex: 1 1 auto;
    }

    .lira-admin-topbar-end {
        flex: 0 0 auto;
    }

    .lira-admin-menu-btn {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
        color: var(--lira-text-soft);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s ease;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
    }

    .lira-admin-menu-btn:hover {
        color: #fff;
        background: rgba(0, 230, 167, 0.12);
        border-color: rgba(0, 230, 167, 0.3);
        box-shadow: 0 0 15px rgba(0, 230, 167, 0.15);
    }

    .lira-admin-heading {
        min-width: 0;
    }

    .lira-admin-title {
        margin: 0;
        color: var(--lira-text);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.2;
        font-family: "Cairo", sans-serif !important;
    }

    .lira-admin-subtitle {
        margin-top: 4px;
        color: var(--lira-text-muted);
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 520px;
    }

    .lira-admin-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        padding: 0 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: var(--lira-text-soft);
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
        letter-spacing: 0.02em;
    }

    .lira-admin-chip.is-accent {
        background: rgba(0, 230, 167, 0.12);
        border-color: rgba(0, 230, 167, 0.25);
        color: var(--lira-accent);
        box-shadow: 0 0 15px rgba(0, 230, 167, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    .lira-admin-chip.is-info {
        background: rgba(54, 191, 250, 0.12);
        border-color: rgba(54, 191, 250, 0.2);
        color: #88d8ff;
        box-shadow: 0 0 15px rgba(54, 191, 250, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    .lira-admin-icon-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
        color: var(--lira-text-soft);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.3s ease;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
    }

    .lira-admin-icon-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-1px);
    }

    .lira-admin-userbox {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 5px 12px 5px 5px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(255, 255, 255, 0.02);
        text-decoration: none;
        transition: 0.3s ease;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
    }

    .lira-admin-userbox:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.12);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .lira-admin-userbox-meta {
        text-align: right;
        min-width: 0;
    }

    .lira-admin-userbox-name {
        color: var(--lira-text);
        font-size: 13px;
        font-weight: 800;
        line-height: 1.2;
        max-width: 170px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lira-admin-userbox-role {
        margin-top: 1px;
        color: var(--lira-accent);
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .lira-admin-userbox-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        overflow: hidden;
        flex: 0 0 auto;
        border: 2px solid rgba(0, 230, 167, 0.4);
        background: rgba(0, 230, 167, 0.12);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 10px rgba(0, 230, 167, 0.2);
    }

    .lira-admin-userbox-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lira-admin-userbox-avatar span {
        color: var(--lira-accent);
        font-size: 15px;
        font-weight: 800;
    }

    .lira-admin-dropdown {
        min-width: 220px !important;
        padding: 10px !important;
        border-radius: 18px !important;
        background:
            linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
            var(--lira-surface-2) !important;
        border: 1px solid var(--lira-border) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28) !important;
    }

    .lira-admin-dropdown .dropdown-item {
        min-height: 42px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
    }

    .lira-admin-dropdown .dropdown-divider {
        border-color: var(--lira-border) !important;
        opacity: 1;
    }

    .lira-admin-modal .modal-content {
        border-radius: 24px !important;
        background: linear-gradient(180deg, rgba(20, 26, 35, 0.95), rgba(11, 15, 21, 0.98)) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    .lira-admin-modal .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 24px 28px 20px;
    }

    .lira-admin-modal .modal-body {
        padding: 28px;
    }

    .lira-admin-modal .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 20px 28px;
        background: rgba(0,0,0,0.15);
        border-bottom-left-radius: 24px;
        border-bottom-right-radius: 24px;
    }

    .lira-admin-modal .modal-title {
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .lira-modal-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        transition: 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .lira-modal-input-wrap:focus-within {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(0, 230, 167, 0.4);
        box-shadow: 0 0 15px rgba(0, 230, 167, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .lira-modal-input-icon {
        width: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--lira-text-muted);
        font-size: 16px;
        transition: 0.3s ease;
    }

    .lira-modal-input-wrap:focus-within .lira-modal-input-icon {
        color: var(--lira-accent);
    }

    .lira-modal-input {
        flex: 1;
        background: transparent !important;
        border: none !important;
        color: #fff !important;
        padding: 14px 14px 14px 0;
        font-weight: 600;
        font-size: 15px;
        box-shadow: none !important;
    }

    .lira-modal-input::placeholder {
        color: rgba(255, 255, 255, 0.2);
        font-weight: 500;
    }

    .lira-admin-modal .form-label {
        color: var(--lira-text-soft) !important;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    @media (max-width: 991.98px) {
        .lira-admin-topbar .container-xxl {
            padding: 0 16px !important;
        }

        .lira-admin-subtitle,
        .lira-admin-chip.hide-mobile,
        .lira-admin-userbox-meta {
            display: none;
        }

        .lira-admin-userbox {
            padding: 4px;
            border-radius: 50%;
            border-color: transparent;
            background: transparent;
            box-shadow: none;
        }

        .lira-admin-userbox:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: transparent;
            box-shadow: none;
        }

        .lira-admin-userbox-avatar {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 575.98px) {
        .lira-admin-title {
            font-size: 0.98rem;
        }

        .lira-admin-topbar-end {
            gap: 8px;
        }

        .lira-admin-chip {
            display: none;
        }
    }
</style>

<header class="lira-admin-topbar">
    <div class="container-xxl lira-admin-topbar-inner">
        <div class="lira-admin-topbar-start">
            <button class="lira-admin-menu-btn menu-toggle d-lg-none" type="button" aria-label="فتح القائمة">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="lira-admin-heading">
                <h4 class="lira-admin-title">@yield('title', 'لوحة الإدارة')</h4>
                <div class="lira-admin-subtitle">
                    مركز إدارة {{ appName() }} والتحكم الكامل بالمستخدمين والطلبات والمعاملات.
                </div>
            </div>
        </div>

        <div class="lira-admin-topbar-end">
            <span class="lira-admin-chip is-accent hide-mobile">
                <i class="fa-solid fa-shield-halved"></i>
                Admin Access
            </span>

            <span class="lira-admin-chip is-info hide-mobile">
                <i class="fa-regular fa-clock"></i>
                <span id="live-clock">{{ now()->format('h:i:s A') }}</span>
            </span>

            <a href="{{ route('site.index') }}" class="lira-admin-icon-btn" title="فتح الموقع">
                <i class="fa-solid fa-globe"></i>
            </a>

            <div class="dropdown">
                <a class="lira-admin-userbox dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="lira-admin-userbox-meta d-none d-sm-block">
                        <div class="lira-admin-userbox-name">{{ $displayName }}</div>
                        <div class="lira-admin-userbox-role">المدير العام</div>
                    </div>

                    <div class="lira-admin-userbox-avatar">
                        @if ($user->image && file_exists(public_path($user->image)))
                            <img src="{{ asset($user->image) }}" alt="Avatar">
                        @else
                            <span>{{ $initial }}</span>
                        @endif
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-start lira-admin-dropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('site.index') }}" target="_blank">
                            <i class="fa-solid fa-arrow-up-right-from-square text-primary"></i>
                            زيارة الموقع
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fa-solid fa-key text-primary"></i>
                            تغيير كلمة المرور
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            تسجيل الخروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="modal fade lira-admin-modal" id="changePasswordModal" tabindex="-1"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('change-password') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fa-solid fa-lock text-primary me-2 is-accent ycolor"></i>
                        تغيير كلمة المرور
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small mb-4">يرجى إدخال كلمة المرور الحالية للتأكد من هويتك قبل تعيين كلمة مرور جديدة لحسابك الإداري.</p>

                    <div class="mb-4">
                        <label for="current-password" class="form-label">كلمة المرور الحالية</label>
                        <div class="lira-modal-input-wrap">
                            <div class="lira-modal-input-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" name="current_password" class="lira-modal-input" id="current-password" placeholder="أدخل كلمة المرور الحالية..." required>
                        </div>
                        @error('current_password')
                            <div class="text-danger mt-2 small"><i class="fa-solid fa-circle-exclamation ms-1"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="new-password" class="form-label">كلمة المرور الجديدة</label>
                        <div class="lira-modal-input-wrap">
                            <div class="lira-modal-input-icon">
                                <i class="fa-solid fa-lock-open"></i>
                            </div>
                            <input type="password" name="password" class="lira-modal-input" id="new-password" placeholder="أدخل كلمة المرور الجديدة..." required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-2 small"><i class="fa-solid fa-circle-exclamation ms-1"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password-confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <div class="lira-modal-input-wrap">
                            <div class="lira-modal-input-icon">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <input type="password" name="password_confirmation" class="lira-modal-input" id="password-confirmation" placeholder="أعد إدخال كلمة المرور الجديدة..." required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex gap-2">
                    <button type="button" class="btn lira-ghost-btn flex-fill m-0" style="padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); color: #fff; background: rgba(255,255,255,0.03);" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary flex-fill m-0" style="padding: 12px; border-radius: 12px; font-weight: 700; box-shadow: inset 0 1px 0 rgba(255,255,255,0.15);">تحديث وتأمين</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        const clockEl = document.getElementById('live-clock');
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

