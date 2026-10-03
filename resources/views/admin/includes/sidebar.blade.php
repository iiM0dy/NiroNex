<!-- Admin Sidebar -->
<style>
    .lira-sidebar {
        width: var(--sidebar-width) !important;
        position: fixed;
        top: 0;
        right: 0 !important;
        left: auto !important;
        bottom: 0;
        z-index: 1045;
        display: flex;
        flex-direction: column;
        background: rgba(11, 15, 21, 0.65) !important;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border-left: 1px solid rgba(255, 255, 255, 0.06) !important;
        box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.02), -10px 0 40px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .lira-admin-sidebar-top {
        position: relative;
        padding: 16px 18px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), transparent);
    }

    .lira-admin-sidebar-brand {
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    .lira-admin-sidebar-brand .niro-logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .lira-admin-sidebar-brand .niro-logo__image {
        display: block;
        width: min(84px, 52%);
        height: auto;
        object-fit: contain;
    }

    .lira-admin-sidebar-badge {
        min-height: 34px;
        border-radius: 16px;
        display: inline-flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: rgba(0, 230, 167, 0.10);
        border: 1px solid rgba(0, 230, 167, 0.18);
        color: var(--lira-accent);
        font-size: 12px;
        font-weight: 800;
        text-align: center;
        padding: 0 10px;
    }

    .lira-admin-sidebar-section {
        padding: 24px 22px 10px;
    }

    .lira-admin-sidebar-label {
        color: var(--lira-text-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        opacity: 0.6;
    }

    .lira-admin-nav {
        padding: 4px 0 12px;
        gap: 4px;
    }

    .lira-admin-nav .nav-link,
    .lira-admin-side-action {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--lira-text-muted) !important;
        padding: 13px 22px !important;
        margin: 4px 14px;
        border-radius: 14px;
        border: 1px solid transparent !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 14px;
        font-weight: 700;
        text-align: right;
        width: calc(100% - 28px);
        box-shadow: inset 0 0 0 rgba(255, 255, 255, 0);
    }

    .lira-admin-nav .nav-link:hover,
    .lira-admin-side-action:hover {
        color: var(--lira-text) !important;
        background: rgba(255, 255, 255, 0.04) !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
        transform: translateX(-4px);
    }

    .lira-admin-nav .nav-link.active {
        color: var(--lira-accent) !important;
        background: linear-gradient(90deg, rgba(0, 230, 167, 0.12), rgba(0, 230, 167, 0.02)) !important;
        border-color: rgba(0, 230, 167, 0.2) !important;
        box-shadow: inset -2px 0 0 var(--lira-accent), inset 0 1px 0 rgba(255, 255, 255, 0.06), 0 4px 15px rgba(0, 230, 167, 0.08);
    }

    .lira-admin-nav-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: currentColor;
        flex: 0 0 auto;
        transition: 0.3s ease;
        font-size: 14px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }

    .lira-admin-nav-icon .niro-icon {
        width: 18px;
        height: 18px;
        color: currentColor;
    }

    .lira-admin-nav .nav-link.active .lira-admin-nav-icon {
        background: rgba(0, 230, 167, 0.15);
        border-color: rgba(0, 230, 167, 0.3);
        color: var(--lira-accent);
        box-shadow: 0 0 10px rgba(0, 230, 167, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .lira-admin-sidebar-bottom {
        padding: 16px;
        margin-top: auto;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), transparent);
    }

    .lira-admin-sidebar-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
        margin: 0 12px 14px;
    }

    .lira-admin-side-action {
        margin: 4px 0 !important;
        width: 100% !important;
    }

    .lira-admin-side-action.is-accent {
        color: var(--lira-accent) !important;
    }

    .lira-admin-side-action.is-danger {
        color: var(--lira-danger) !important;
    }

    .lira-admin-side-action.is-danger .lira-admin-nav-icon {
        background: rgba(240, 68, 56, 0.10);
    }

    .sidebar-close-btn {
        position: absolute;
        top: 22px;
        left: 22px;
        width: 38px;
        height: 38px;
        border: 1px solid var(--lira-border);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.03);
        color: var(--lira-text-muted);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s ease;
        z-index: 10;
    }
</style>

<div class="lira-sidebar d-flex flex-column h-100">
    <div class="lira-admin-sidebar-top">
        <button type="button" class="sidebar-close-btn d-lg-none" id="sidebarCloseBtn" aria-label="إغلاق القائمة">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <a href="{{ route('admin.dashboard') }}" class="lira-admin-sidebar-brand text-decoration-none">
            @include('includes.logo-white', ['variant' => 2])
        </a>
    </div>

    <div class="lira-admin-sidebar-section">
        <span class="lira-admin-sidebar-label">الإدارة الرئيسية</span>
    </div>

    <ul class="nav flex-column flex-grow-1 lira-admin-nav">
        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="dashboard" />
                </span>
                <span>لوحة التحكم</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.users.index') ? 'active' : '' }}"
                href="{{ route('admin.users.index') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="users" />
                </span>
                <span>العملاء</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.verification-kyc.*') ? 'active' : '' }}"
                href="{{ route('admin.verification-kyc.index') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="status" />
                </span>
                <span>التحقق KYC</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.robot-requests.*') ? 'active' : '' }}"
                href="{{ route('admin.robot-requests.index') }}">
                <span class="lira-admin-nav-icon">
                    <i class="fa-solid fa-robot"></i>
                </span>
                <span>طلبات الروبوت</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.transactions-requests.index') ? 'active' : '' }}"
                href="{{ route('admin.transactions-requests.index') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="signals" />
                </span>
                <span>الطلبات</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.transactions.index') ? 'active' : '' }}"
                href="{{ route('admin.transactions.index') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="wallet" />
                </span>
                <span>المعاملات المالية</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.transactions-requests.internal-transfer') ? 'active' : '' }}"
                href="{{ route('admin.transactions-requests.internal-transfer') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="transfer" />
                </span>
                <span>تحويل داخلي</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.messages.index') ? 'active' : '' }}"
                href="{{ route('admin.messages.index') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="support" />
                </span>
                <span>الرسائل</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.messages.recommendations') ? 'active' : '' }}"
                href="{{ route('admin.messages.recommendations') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="signals" />
                </span>
                <span>التوصيات</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ routeIsActive('admin.settings.footer.*') ? 'active' : '' }}"
                href="{{ route('admin.settings.footer.edit') }}">
                <span class="lira-admin-nav-icon">
                    <x-niro-icon name="settings" />
                </span>
                <span>إعدادات الفوتر</span>
            </a>
        </li>
    </ul>

    <div class="lira-admin-sidebar-bottom">
        <div class="lira-admin-sidebar-divider"></div>

        <a href="{{ url('/') }}" class="lira-admin-side-action is-accent text-decoration-none">
            <span class="lira-admin-nav-icon">
                <x-niro-icon name="globe" />
            </span>
            <span>العودة للموقع</span>
        </a>

        <a href="{{ route('logout') }}" class="lira-admin-side-action is-danger text-decoration-none">
            <span class="lira-admin-nav-icon">
                <x-niro-icon name="logout" class="niro-icon--current" />
            </span>
            <span>تسجيل الخروج</span>
        </a>
    </div>
</div>

