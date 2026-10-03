@php
    $authUser = auth()->user();
    $firstLetter = $authUser?->full_name ? mb_substr($authUser->full_name, 0, 1) : 'N';
    $hasPlan = !empty($authUser?->plan);
    $kycVerified = $authUser?->hasCompletedKyc() ?? false;

    $userStatusText = match ($authUser?->status) {
        \App\Enums\UserStatus::Pending => 'قيد التفعيل',
        \App\Enums\UserStatus::Inactive => 'معلّق',
        default => 'نشط',
    };

    $userStatusClass = match ($authUser?->status) {
        \App\Enums\UserStatus::Pending => 'is-pending',
        \App\Enums\UserStatus::Inactive => 'is-inactive',
        default => 'is-active',
    };

    $withdrawActive = request()->routeIs('site.transactions-requests.create') && request('t', 'w') === 'w';
    $operationActive = request()->routeIs('site.dashboard', 'site.trading', 'site.robot.*', 'site.deposit', 'site.plans');
    $financialActive = request()->routeIs('site.funding*', 'site.transactions.*', 'site.transactions-requests.*', 'site.wallet');
    $supportActive = request()->routeIs('profile', 'site.messages.*', 'site.performance');
@endphp

<style>
    .lira-sidebar {
        padding: 0 0 16px !important;
    }

    .lira-sidebar-brand {
        padding: 0 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 85px;
        min-height: 85px;
        flex: 0 0 85px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .lira-sidebar-brand a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    @media (min-width: 1025px) {
        .lira-sidebar-brand .niro-logo__image {
            width: auto !important;
            max-width: 72px !important;
            max-height: 46px !important;
            object-fit: contain;
        }
    }

    .lira-sidebar-user {
        margin: 18px 16px 8px;
        padding: 16px;
        border-radius: 20px;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.015)),
            rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .lira-sidebar-user-top {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lira-sidebar-avatar {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 230, 167, 0.14);
        color: var(--lira-accent);
        font-weight: 800;
        font-size: 18px;
        flex: 0 0 auto;
    }

    .lira-sidebar-user-meta strong {
        display: block;
        color: var(--lira-text);
        font-size: 14px;
        line-height: 1.4;
    }

    .lira-sidebar-user-meta span {
        display: block;
        color: var(--lira-text-muted);
        font-size: 12px;
        margin-top: 2px;
    }

    .lira-sidebar-status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .lira-sidebar-status-chip,
    .lira-sidebar-kyc-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 30px;
        padding: 0 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .lira-sidebar-status-chip.is-active {
        background: rgba(23, 178, 106, 0.12);
        color: #63ddab;
    }

    .lira-sidebar-status-chip.is-pending {
        background: rgba(120, 97, 255, 0.12);
        color: #c4b6ff;
    }

    .lira-sidebar-status-chip.is-inactive {
        background: rgba(240, 68, 56, 0.12);
        color: #ff8a80;
    }

    .lira-sidebar-kyc-chip.is-verified {
        background: rgba(23, 178, 106, 0.12);
        color: #63ddab;
    }

    .lira-sidebar-kyc-chip.is-pending {
        background: rgba(255, 255, 255, 0.05);
        color: var(--lira-text-soft);
    }

    .lira-sidebar-section {
        padding: 14px 16px 4px;
    }

    .lira-sidebar-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        background: none;
        border: none;
        padding: 0 14px;
        margin-bottom: 10px;
        color: var(--lira-text-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        cursor: pointer;
        text-align: right;
        transition: color 0.2s ease;
    }

    .lira-sidebar-toggle:hover {
        color: var(--lira-accent);
    }

    .lira-toggle-icon {
        font-size: 10px;
        transition: transform 0.3s ease;
    }

    .lira-sidebar-toggle.collapsed .lira-toggle-icon {
        transform: rotate(-90deg);
    }

    .lira-sidebar-collapse {
        list-style: none;
        overflow: hidden;
        transition: max-height 0.3s ease;
        max-height: 0;
    }

    .lira-sidebar-collapse.collapsed {
        max-height: 0 !important;
    }

    .lira-sidebar .m-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--lira-text-muted) !important;
        padding: 13px 18px !important;
        margin: 4px 12px;
        border-radius: 14px;
        border-right: 2px solid transparent !important;
        border-left: none !important;
        transition: all 0.22s ease;
        font-size: 15px;
        font-weight: 600;
    }

    .lira-sidebar .m-link i,
    .lira-sidebar .m-link .niro-icon {
        width: 18px;
        height: 18px;
        text-align: center;
        margin: 0 !important;
        color: currentColor !important;
        opacity: 0.92;
    }

    .lira-sidebar-status-chip .niro-icon,
    .lira-sidebar-kyc-chip .niro-icon {
        width: 14px;
        height: 14px;
    }

    .lira-sidebar .m-link:hover {
        color: var(--lira-text) !important;
        background: rgba(255, 255, 255, 0.03) !important;
    }

    .lira-sidebar .m-link.active,
    .lira-sidebar .m-link.router-link-active,
    .lira-sidebar .m-link[aria-expanded="true"] {
        color: var(--lira-accent) !important;
        background: linear-gradient(90deg, rgba(0, 230, 167, 0.12), rgba(0, 230, 167, 0.04)) !important;
        border-right-color: var(--lira-accent) !important;
        box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.08);
    }

    .lira-sidebar .menu-list {
        gap: 2px;
    }

    .lira-sidebar-footer {
        margin: auto 16px 0;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .logout-link:hover {
        color: #ff4d4d !important;
    }

    @media (max-width: 1024.98px) {
        .lira-sidebar-brand {
            padding: 22px 18px 0;
        }

        .lira-sidebar-user,
        .lira-sidebar-footer {
            margin-left: 12px;
            margin-right: 12px;
        }

        .lira-sidebar-section {
            padding-left: 12px;
            padding-right: 12px;
        }

        .sidebar-close-btn.d-lg-none {
            display: inline-flex !important;
        }
    }
</style>

<div class="lira-sidebar d-flex flex-column h-100">
    <div class="lira-sidebar-brand position-relative text-center">
        <button type="button" class="sidebar-close-btn d-lg-none" id="sidebarCloseBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <a href="{{ route('site.dashboard') }}" class="text-decoration-none">
            @include('includes.logo-white')
        </a>
    </div>

    <div class="lira-sidebar-user">
        <div class="lira-sidebar-user-top">
            <div class="lira-sidebar-avatar">{{ $firstLetter }}</div>
            <div class="lira-sidebar-user-meta">
                <strong>{{ $authUser?->full_name ?? 'مستخدم ' . appName() }}</strong>
                <span>{{ $hasPlan ? ($authUser->plan->display_name ?? 'خطة مفعلة') : 'بدون خطة مفعلة' }}</span>
            </div>
        </div>
        <div class="lira-sidebar-status-row">
            <span class="lira-sidebar-status-chip {{ $userStatusClass }}">
                <x-niro-icon name="status" class="niro-icon--current" />
                {{ $userStatusText }}
            </span>
            <span class="lira-sidebar-kyc-chip {{ $kycVerified ? 'is-verified' : 'is-pending' }}">
                <x-niro-icon name="security" class="niro-icon--current" />
                {{ $kycVerified ? 'KYC موثق' : 'KYC غير مكتمل' }}
            </span>
        </div>
    </div>

    <div class="lira-sidebar-section">
        <button class="lira-sidebar-section-title lira-sidebar-toggle {{ $operationActive ? '' : 'collapsed' }}"
            data-target="section-operation"
            data-lock-open="{{ $operationActive ? 'true' : 'false' }}"
            type="button"
            aria-expanded="{{ $operationActive ? 'true' : 'false' }}">
            <span>التشغيل</span>
            <i class="fa-solid fa-chevron-down lira-toggle-icon"></i>
        </button>
        <ul class="menu-list d-flex flex-column p-0 m-0 lira-sidebar-collapse {{ $operationActive ? '' : 'collapsed' }}" id="section-operation">
            <li>
                <a class="m-link {{ request()->routeIs('site.trading') ? 'active' : '' }}" href="{{ route('site.trading') }}">
                    <x-niro-icon name="markets" />
                    <span>Niro Trade</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.robot.*') ? 'active' : '' }}" href="{{ route('site.robot.index') }}">
                    <x-niro-icon name="robot" />
                    <span>{{ brandAiName() }}</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.plans') ? 'active' : '' }}" href="{{ route('site.plans') }}">
                    <x-niro-icon name="academy" />
                    <span>الخطط والاشتراك</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.dashboard') ? 'active' : '' }}" href="{{ route('site.dashboard') }}">
                    <x-niro-icon name="dashboard" />
                    <span>لوحة التحكم</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="lira-sidebar-section">
        <button class="lira-sidebar-section-title lira-sidebar-toggle {{ $financialActive ? '' : 'collapsed' }}"
            data-target="section-financial"
            data-lock-open="{{ $financialActive ? 'true' : 'false' }}"
            type="button"
            aria-expanded="{{ $financialActive ? 'true' : 'false' }}">
            <span>الحساب المالي</span>
            <i class="fa-solid fa-chevron-down lira-toggle-icon"></i>
        </button>
        <ul class="menu-list d-flex flex-column p-0 m-0 lira-sidebar-collapse {{ $financialActive ? '' : 'collapsed' }}" id="section-financial">
            <li>
                <a class="m-link {{ request()->routeIs('site.funding*') ? 'active' : '' }}" href="{{ route('site.funding') }}">
                    <x-niro-icon name="wallet" />
                    <span>ايداع</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ $withdrawActive ? 'active' : '' }}" href="{{ route('site.transactions-requests.create', ['t' => 'w']) }}">
                    <x-niro-icon name="transfer" />
                    <span>سحب</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.transactions.index') ? 'active' : '' }}" href="{{ route('site.transactions.index') }}">
                    <x-niro-icon name="transfer" />
                    <span>المعاملات</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.wallet') ? 'active' : '' }}" href="{{ route('site.wallet') }}">
                    <x-niro-icon name="wallet" />
                    <span>المحفظة</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="lira-sidebar-section">
        <button class="lira-sidebar-section-title lira-sidebar-toggle {{ $supportActive ? '' : 'collapsed' }}"
            data-target="section-support"
            data-lock-open="{{ $supportActive ? 'true' : 'false' }}"
            type="button"
            aria-expanded="{{ $supportActive ? 'true' : 'false' }}">
            <span>المتابعة والدعم</span>
            <i class="fa-solid fa-chevron-down lira-toggle-icon"></i>
        </button>
        <ul class="menu-list d-flex flex-column p-0 m-0 lira-sidebar-collapse {{ $supportActive ? '' : 'collapsed' }}" id="section-support">
            <li>
                <a class="m-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                    <x-niro-icon name="profile" />
                    <span>الملف الشخصي</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.messages.index') ? 'active' : '' }}" href="{{ route('site.messages.index') }}">
                    <x-niro-icon name="support" />
                    <span>خدمة العملاء</span>
                </a>
            </li>
            <li>
                <a class="m-link {{ request()->routeIs('site.performance') ? 'active' : '' }}" href="{{ route('site.performance') }}">
                    <x-niro-icon name="portfolio" />
                    <span>الأداء</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="lira-sidebar-footer">
        <ul class="menu-list d-flex flex-column p-0 m-0" style="list-style: none;">
            <li>
                <a href="{{ url('/') }}" class="m-link">
                    <x-niro-icon name="home" />
                    <span>الصفحة الرئيسية</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="m-link text-danger logout-link">
                    <x-niro-icon name="logout" class="niro-icon--current" />
                    <span>تسجيل الخروج</span>
                </a>
            </li>
        </ul>
    </div>
</div>

@push('custom_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.lira-sidebar-toggle');

            const syncSidebarSection = function (button, collapse) {
                const isLockedOpen = button.dataset.lockOpen === 'true';
                const isCollapsed = isLockedOpen ? false : collapse.classList.contains('collapsed');

                if (isLockedOpen) {
                    collapse.classList.remove('collapsed');
                }

                collapse.style.maxHeight = isCollapsed ? '0px' : collapse.scrollHeight + 'px';
                button.classList.toggle('collapsed', isCollapsed);
                button.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');
            };

            toggles.forEach(function (button) {
                const target = document.getElementById(button.getAttribute('data-target'));
                if (!target) {
                    return;
                }

                syncSidebarSection(button, target);

                button.addEventListener('click', function () {
                    if (button.dataset.lockOpen === 'true') {
                        target.classList.remove('collapsed');
                        syncSidebarSection(button, target);
                        return;
                    }

                    target.classList.toggle('collapsed');
                    syncSidebarSection(button, target);
                });
            });

            window.addEventListener('resize', function () {
                toggles.forEach(function (button) {
                    const target = document.getElementById(button.getAttribute('data-target'));
                    if (target) {
                        syncSidebarSection(button, target);
                    }
                });
            });
        });
    </script>
@endpush

