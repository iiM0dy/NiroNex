@php
    $user = auth()->user();
    $planName = $user->plan->display_name ?? 'بدون خطة';
    $kycVerified = !empty($user->id_photo_front)
        && $user->status !== \App\Enums\UserStatus::Pending
        && $user->status !== \App\Enums\UserStatus::Inactive;

    $statusText = match ($user->status) {
        \App\Enums\UserStatus::Pending => 'قيد التفعيل',
        \App\Enums\UserStatus::Inactive => 'معلّق',
        default => 'نشط',
    };

    $statusClass = match ($user->status) {
        \App\Enums\UserStatus::Pending => 'is-pending',
        \App\Enums\UserStatus::Inactive => 'is-inactive',
        default => 'is-active',
    };

    $hasUnreadMessages = $user->receivedMessages()->where('is_read', false)->exists();
@endphp

<style>
    .lira-topbar {
        padding: 0 var(--dash-content-gutter, 28px) !important;
        background: rgba(10, 14, 22, 0.94) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.14);
    }

    .lira-topbar .container-xxl {
        width: 100%;
        max-width: var(--dash-content-max-width, 1120px) !important;
        margin-inline: auto;
    }

    body.page-dash-standard .lira-topbar {
        padding-inline: var(--dash-content-gutter, 16px) !important;
    }

    body.page-dash-standard .lira-topbar .container-xxl {
        max-width: var(--dash-content-max-width, 1120px) !important;
        padding-inline: 0 !important;
    }

    @media (min-width: 1025px) {
        .lira-topbar {
            width: 100%;
            margin-inline: 0;
            padding-inline: var(--dash-content-gutter, 28px) !important;
            border-radius: 0;
        }

        body.page-dash-standard .lira-topbar {
            padding-inline: var(--dash-content-gutter, 16px) !important;
        }
    }

    .lira-topbar-inner {
        min-height: var(--header-height);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 0;
    }

    .lira-topbar-start,
    .lira-topbar-end {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .lira-topbar-start {
        flex: 1 1 auto;
    }

    .lira-topbar-end {
        flex: 0 0 auto;
    }

    .lira-topbar-heading {
        min-width: 0;
        flex: 1 1 auto;
        overflow: hidden;
    }

    .lira-topbar-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--lira-text);
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .lira-topbar-subtitle {
        margin-top: 4px;
        color: var(--lira-text-muted);
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .lira-topbar-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 38px;
        padding: 0 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--lira-border);
        color: var(--lira-text-soft);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .lira-topbar-chip i,
    .lira-topbar-chip .niro-icon {
        width: 14px;
        height: 14px;
        font-size: 12px;
        color: currentColor;
    }

    .lira-topbar-chip.is-accent {
        background: rgba(0, 230, 167, 0.10);
        border-color: rgba(0, 230, 167, 0.22);
        color: var(--lira-accent);
    }

    .lira-topbar-chip.is-active {
        background: rgba(23, 178, 106, 0.12);
        border-color: rgba(23, 178, 106, 0.18);
        color: #63ddab;
    }

    .lira-topbar-chip.is-pending {
        background: rgba(120, 97, 255, 0.12);
        border-color: rgba(120, 97, 255, 0.18);
        color: #c4b6ff;
    }

    .lira-topbar-chip.is-inactive {
        background: rgba(240, 68, 56, 0.12);
        border-color: rgba(240, 68, 56, 0.18);
        color: #ff8a80;
    }

    .lira-topbar-chip.is-neutral {
        background: rgba(255, 255, 255, 0.04);
        color: var(--lira-text-soft);
    }

    .lira-header-icon-link {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--lira-border);
        background: rgba(255, 255, 255, 0.03);
        color: var(--lira-text-soft);
        transition: 0.2s ease;
        position: relative;
    }

    .lira-header-icon-link:hover {
        color: var(--lira-text);
        background: rgba(255, 255, 255, 0.05);
    }

    .lira-header-icon-link .niro-icon {
        width: 18px;
        height: 18px;
        color: currentColor;
    }

    .lira-header-icon-link .lira-dot {
        position: absolute;
        top: 9px;
        inset-inline-start: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--lira-accent);
        box-shadow: 0 0 0 2px rgba(0, 230, 167, 0.08);
    }

    .lira-userbox {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 8px 6px 6px;
        border-radius: 18px;
        border: 1px solid var(--lira-border);
        background: rgba(255, 255, 255, 0.03);
    }

    .lira-userbox-meta {
        text-align: right;
        min-width: 0;
    }

    .lira-userbox-name {
        color: var(--lira-text);
        font-size: 13px;
        font-weight: 800;
        line-height: 1.2;
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lira-userbox-plan {
        margin-top: 3px;
        color: var(--lira-text-muted);
        font-size: 11px;
        white-space: nowrap;
    }

    .lira-userbox-avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        overflow: hidden;
        flex: 0 0 auto;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(0, 230, 167, 0.16);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .lira-userbox-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .lira-userbox-avatar span {
        color: var(--lira-accent);
        font-weight: 800;
        font-size: 15px;
    }

    @media (max-width: 1199.98px) {
        .lira-topbar-inner {
            padding: 0 18px;
        }

        .lira-topbar-subtitle {
            max-width: 320px;
        }
    }

    @media (max-width: 1024.98px) {
        .lira-topbar {
            padding: 0 14px !important;
        }

        .lira-topbar-inner {
            min-height: var(--header-height);
            padding: 0;
        }

        .lira-topbar-heading {
            flex: 1 1 auto;
        }

        .lira-topbar-subtitle,
        .lira-topbar-chip.hide-mobile,
        .lira-userbox-meta {
            display: none;
        }

        .lira-userbox {
            padding: 4px;
            border-radius: 16px;
        }

        .lira-userbox-avatar {
            width: 40px;
            height: 40px;
        }

        .lira-topbar-end {
            gap: 8px;
        }

        .lira-topbar-start {
            gap: 10px;
            min-width: 0;
            flex: 1 1 auto;
            overflow: hidden;
        }
    }

    @media (max-width: 575.98px) {
        .lira-topbar-title {
            font-size: 0.92rem;
        }

        .lira-topbar-end {
            gap: 6px;
        }

        .lira-header-icon-link {
            width: 38px;
            height: 38px;
        }

        .lira-userbox {
            padding: 4px;
        }

        .lira-userbox-avatar {
            width: 36px;
            height: 36px;
            border-radius: 12px;
        }
    }
</style>

<header class="header lira-topbar">
    <div class="container-xxl">
        <div class="lira-topbar-inner">
            <div class="lira-topbar-start">
                <div class="lira-topbar-heading">
                    <h4 class="lira-topbar-title">@yield('title')</h4>
                    <div class="lira-topbar-subtitle">
                        منصة {{ appName() }} لمتابعة التداول، الصفقات، والتنبيهات التنفيذية.
                    </div>
                </div>
            </div>

            <div class="lira-topbar-end">
                <span class="lira-topbar-chip is-accent hide-mobile">
                    <x-niro-icon name="academy" />
                    {{ $planName }}
                </span>

                <span class="lira-topbar-chip {{ $statusClass }} hide-mobile">
                    <x-niro-icon name="signals" />
                    {{ $statusText }}
                </span>

                <span class="lira-topbar-chip {{ $kycVerified ? 'is-active' : 'is-neutral' }} hide-mobile">
                    <x-niro-icon name="security" />
                    {{ $kycVerified ? 'KYC موثق' : 'KYC غير مكتمل' }}
                </span>

                <a href="{{ url('/') }}" class="lira-header-icon-link" title="الرئيسية">
                    <x-niro-icon name="dashboard" />
                </a>

                <a href="{{ route('site.messages.index') }}" class="lira-header-icon-link" title="الدعم">
                    <x-niro-icon name="support" />
                    @if ($hasUnreadMessages)
                        <span class="lira-dot"></span>
                    @endif
                </a>

                <a href="{{ route('profile') }}" class="lira-header-icon-link" title="حسابي">
                    <x-niro-icon name="users" />
                </a>

                <a href="{{ route('logout') }}" class="lira-header-icon-link text-danger" title="تسجيل خروج"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <x-niro-icon name="logout" />
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>

