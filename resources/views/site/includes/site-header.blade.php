@php
    $isAuth = auth()->check();
    $isAdmin = $isAuth && auth()->user()->is_admin;
    $isHome = request()->routeIs('site.index');
    $isTerms = request()->routeIs('terms');
    $isLogin = request()->routeIs('login');
    $isRegister = request()->routeIs('register');
    $isDashboardLinkActive = request()->routeIs('site.dashboard') || request()->routeIs('admin.dashboard');
    $dashboardRoute = $isAdmin ? route('admin.dashboard') : route('site.dashboard');
    $mobileEntryLabel = $isAuth ? 'لوحة التحكم' : 'تسجيل دخول';
    $mobileEntryRoute = $isAuth ? $dashboardRoute : route('login');
    $supportEmail = env('SUPPORT_EMAIL');
    $supportRoute = $supportEmail ? 'mailto:' . $supportEmail : route('site.index');
@endphp

<style>
    :root {
        --lira-public-header-height: 104px;
    }

    body .header.navbar-area.lira-site-header {
        position: fixed !important;
        top: 0 !important;
        inset-inline: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        z-index: 1100 !important;
        padding: 18px 0 0 !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        transform: none !important;
    }

    .lira-site-header .container,
    .lira-site-header .nav-inner,
    .lira-site-header .navbar {
        position: relative;
    }

    .lira-site-header.is-home > .container {
        max-width: var(--hp-shell-width, 1220px) !important;
    }

    .lira-site-header .nav-inner {
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(13, 18, 28, 0.92);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
        overflow: hidden;
    }

    .lira-site-header.is-inner .nav-inner {
        background: rgba(10, 14, 22, 0.9);
    }

    .lira-site-header .navbar {
        min-height: 86px;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 20px;
        padding: 0 22px !important;
        flex-wrap: nowrap !important;
    }

    .lira-site-header .navbar-brand {
        margin: 0 !important;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        flex: 0 0 auto;
    }

    .lira-site-desktop-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1 1 auto;
        min-width: 0;
        padding-inline: 18px;
    }



    .lira-site-header .navbar-brand .logo,
    .lira-site-mobile-brand .logo {
        display: inline-flex;
        align-items: center;
        padding-block: 4px;
    }

    .lira-site-header .navbar-brand .logo svg,
    .lira-site-header .navbar-brand .logo img,
    .lira-site-mobile-brand .logo svg,
    .lira-site-mobile-brand .logo img {
        display: block;
        width: 86px !important;
        max-width: 86px !important;
        height: auto;
    }

    .lira-site-mobile-entry,
    .lira-site-mobile-brand {
        display: none;
    }

    @media (min-width: 992px) {
        .lira-site-header .navbar-brand .logo img,
        .lira-site-header .navbar-brand .logo svg {
            width: auto !important;
            max-width: 62px !important;
            max-height: 42px !important;
            object-fit: contain;
        }
    }

    .lira-site-brand-lockup {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        direction: ltr;
        line-height: 1;
        white-space: nowrap;
    }

    .lira-site-brand-lockup .logo {
        padding-block: 0;
        flex: 0 0 auto;
    }

    .lira-site-brand-lockup .niro-logo--text {
        flex: 0 0 auto;
    }

    .lira-site-brand-lockup .niro-logo__wordmark {
        font-size: 1.52rem;
    }

    @media (min-width: 992px) {
        .lira-site-header .lira-site-brand-lockup {
            gap: 0;
        }

        .lira-site-header .lira-site-brand-lockup .logo img,
        .lira-site-header .lira-site-brand-lockup .logo svg {
            width: 42px !important;
            max-width: 42px !important;
            max-height: 42px !important;
            object-fit: contain;
        }

        .lira-site-header .lira-site-brand-lockup .niro-logo--text {
            margin-inline-start: -18px;
        }
    }

    .lira-site-header .navbar-collapse {
        flex: 1 1 auto;
        display: flex !important;
        justify-content: center;
        margin-inline: 0 auto;
    }

    .lira-site-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .lira-site-nav .nav-link {
        position: relative;
        color: rgba(248, 250, 252, 0.78) !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        padding: 12px 16px !important;
        border-radius: 14px;
        border: 1px solid transparent;
        transition: 0.22s ease;
        margin: 0 !important;
        white-space: nowrap;
        line-height: 1;
    }

    .lira-site-nav .nav-link:hover,
    .lira-site-nav .nav-link.active {
        color: var(--lira-accent) !important;
        background: rgba(0, 230, 167, 0.10);
        box-shadow: none;
    }

    .lira-site-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0 0 auto;
        margin-inline-start: 0;
        order: 4;
    }

    .lira-site-link-btn {
        min-height: 44px;
        padding: 0 16px;
        border-radius: 16px;
        border: 1px solid rgba(0, 230, 167, 0.16);
        background: rgba(255, 255, 255, 0.03);
        color: #f8fafc !important;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: 0.22s ease;
        white-space: nowrap;
        box-shadow: none;
    }

    .lira-site-link-btn:hover {
        color: var(--lira-accent) !important;
        background: rgba(0, 230, 167, 0.08);
        border-color: rgba(0, 230, 167, 0.22);
    }

    .lira-site-main-btn {
        min-height: 44px;
        padding: 0 24px !important;
        border-radius: 14px !important;
        border: 1px solid rgba(0, 230, 167, 0.82) !important;
        background: var(--lira-accent) !important;
        color: #0d1117 !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.14);
        transition: background-color 0.22s ease, border-color 0.22s ease, transform 0.22s ease, box-shadow 0.22s ease !important;
        overflow: hidden;
    }

    .lira-site-main-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.16);
        background: #14efb3 !important;
    }

    @media (min-width: 992px) {
        .lira-site-header .navbar {
            display: grid !important;
            direction: ltr !important;
            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            grid-template-areas: "actions nav brand";
            gap: 18px;
            padding-inline: 26px !important;
            align-items: center !important;
        }

        .lira-site-header .navbar-brand {
            grid-area: brand;
            justify-self: end;
            order: initial !important;
        }

        .lira-site-desktop-nav {
            grid-area: nav;
            justify-self: center;
            padding-inline: 0;
            order: initial !important;
        }

        .lira-site-actions {
            grid-area: actions;
            justify-self: start;
            order: initial !important;
        }

        .lira-site-header .navbar-brand .logo svg,
        .lira-site-header .navbar-brand .logo img {
            width: 92px !important;
            max-width: 92px !important;
        }

        .lira-site-nav {
            gap: 10px;
            margin: 0 !important;
        }

        .lira-site-nav .nav-link {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px !important;
            border-radius: 999px;
            font-size: 13px !important;
        }

        .lira-site-actions {
            gap: 8px;
        }

        .lira-site-desktop-nav,
        .lira-site-nav,
        .lira-site-actions,
        .lira-site-header .navbar-brand {
            direction: rtl !important;
        }

        #liraPublicNavbar,
        #liraPublicNavbar.show,
        #liraPublicNavbar.collapsing {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }
    }

    .lira-site-mobile-toggle {
        direction: ltr !important;
        display: none !important;
        width: 44px;
        height: 44px;
        border-radius: 12px !important;
        border: 1px solid rgba(0, 230, 167, 0.2) !important;
        background: rgba(0, 230, 167, 0.05) !important;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        box-shadow: none;
        position: relative;
        padding: 0 !important;
        align-items: center;
        justify-content: center;
        color: var(--lira-accent) !important;
        cursor: pointer;
        flex: 0 0 auto;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .lira-site-mobile-toggle:hover,
    .lira-site-mobile-toggle:focus {
        background: rgba(0, 230, 167, 0.08) !important;
        border-color: rgba(0, 230, 167, 0.28) !important;
        box-shadow: none !important;
    }

    .lira-site-mobile-toggle.active,
    .lira-site-mobile-toggle[aria-expanded="true"] {
        background: rgba(0, 230, 167, 0.12) !important;
        border-color: rgba(0, 230, 167, 0.32) !important;
        box-shadow: none !important;
    }

    .lira-site-mobile-toggle-icon {
        position: relative;
        width: 22px;
        height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .lira-site-mobile-toggle-hamburger,
    .lira-site-mobile-toggle-close {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.22s ease, transform 0.22s ease;
    }

    .lira-site-mobile-toggle-hamburger {
        flex-direction: column;
        gap: 5px;
    }

    .lira-site-mobile-toggle-hamburger .toggler-icon {
        position: static;
        width: 22px !important;
        height: 2.5px !important;
        background-color: var(--lira-accent) !important;
        display: block !important;
        border-radius: 4px !important;
        margin: 0 !important;
        transition: transform 0.22s ease, opacity 0.22s ease;
    }

    .lira-site-mobile-toggle-close {
        opacity: 0;
        transform: scale(0.82);
        color: var(--lira-accent);
        font-size: 1.05rem;
        line-height: 1;
    }

    .lira-site-mobile-toggle.active .lira-site-mobile-toggle-hamburger,
    .lira-site-mobile-toggle[aria-expanded="true"] .lira-site-mobile-toggle-hamburger {
        opacity: 0;
        transform: scale(0.82);
    }

    .lira-site-mobile-toggle.active .lira-site-mobile-toggle-close,
    .lira-site-mobile-toggle[aria-expanded="true"] .lira-site-mobile-toggle-close {
        opacity: 1;
        transform: scale(1);
    }

    @media (max-width: 1199.98px) {
        .lira-site-header .navbar {
            gap: 14px;
            padding: 0 16px !important;
        }

        .lira-site-brand-shell {
            padding: 0 14px;
        }

        .lira-site-brand-shell .logo svg,
        .lira-site-brand-shell .logo img {
            width: 78px !important;
            max-width: 78px !important;
        }

        .lira-site-nav .nav-link {
            padding: 11px 13px !important;
            font-size: 13px !important;
        }
    }

    @media (max-width: 991.98px) {
        :root {
            --lira-public-header-height: 82px;
        }

        body .header.navbar-area.lira-site-header {
            padding: calc(10px + env(safe-area-inset-top, 0px)) 0 0 !important;
        }

        .lira-site-header .nav-inner {
            border-radius: 20px;
        }

        .lira-site-header .navbar {
            min-height: 70px;
            position: relative;
            display: flex !important;
            flex-direction: row-reverse !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 12px !important;
            gap: 8px !important;
            border-radius: inherit;
        }

        .lira-site-actions.desktop-only,
        .lira-site-header .navbar-brand.desktop-only {
            display: none !important;
        }

        .lira-site-mobile-entry {
            display: inline-flex !important;
            min-height: 42px;
            min-width: 94px;
            max-width: 112px;
            padding: 0 12px;
            border-radius: 999px;
            border: 1px solid rgba(0, 230, 167, 0.18);
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent) !important;
            text-decoration: none;
            font-size: 11px;
            font-weight: 900;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            z-index: 2;
        }

        .lira-site-mobile-brand {
            display: flex !important;
            position: absolute !important;
            inset-inline: 0 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 100% !important;
            justify-content: center;
            box-sizing: border-box;
            z-index: 1 !important;
            pointer-events: none;
            margin: 0 !important;
            padding: 0 72px !important;
        }

        .lira-site-mobile-brand .logo {
            pointer-events: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lira-site-mobile-brand .logo svg,
        .lira-site-mobile-brand .logo img {
            width: 64px !important;
            max-width: 64px !important;
            height: auto;
        }

        .lira-site-mobile-brand .lira-site-brand-lockup {
            gap: 7px;
        }

        .lira-site-mobile-brand .lira-site-brand-lockup .logo img,
        .lira-site-mobile-brand .lira-site-brand-lockup .logo svg {
            width: 32px !important;
            max-width: 32px !important;
            max-height: 32px !important;
        }

        .lira-site-mobile-brand .lira-site-brand-lockup .niro-logo__wordmark {
            font-size: 1.05rem !important;
        }

        .lira-site-mobile-toggle {
            display: inline-flex !important;
            z-index: 2;
        }

        /* ─── Mobile Menu: Hidden Global Correctly ─── */
        #liraPublicNavbar {
            display: none !important;
        }

        @media (max-width: 991px) {
            #liraPublicNavbar {
                position: fixed !important;
                top: calc(env(safe-area-inset-top, 0px) + 92px) !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: calc(100% - 20px) !important;
                max-width: 420px !important;
                background: #0d141f !important;
                border: 1px solid rgba(255, 255, 255, 0.12) !important;
                border-radius: 24px !important;
                padding: 18px 16px calc(18px + env(safe-area-inset-bottom, 0px)) !important;
                box-shadow: 0 14px 34px rgba(0, 0, 0, 0.28) !important;
                z-index: 9999 !important;
                overflow-y: auto !important;
                margin: 0 !important;
                transition: none !important;
                max-height: calc(100dvh - env(safe-area-inset-top, 0px) - 108px) !important;
            }

            #liraPublicNavbar.collapsing, 
            #liraPublicNavbar.show {
                display: flex !important;
                flex-direction: column !important;
                height: auto !important;
                max-height: calc(100dvh - env(safe-area-inset-top, 0px) - 108px) !important;
            }
        }

        /* Desktop specific layout fix after link removal */
        @media (min-width: 992px) {
            .lira-site-header .navbar {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 100% !important;
                padding: 0 24px !important;
                min-height: 86px;
            }
            #liraPublicNavbar {
                display: none !important;
            }
        }

        .lira-mobile-menu-label {
            display: block;
            font-size: 10px;
            font-weight: 900;
            color: rgba(0, 230, 167, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .lira-mobile-menu-wrapper {
            display: grid;
            gap: 18px;
        }

        .lira-mobile-menu-section {
            display: grid;
            gap: 10px;
        }

        .lira-mobile-nav-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lira-mobile-nav-item .nav-link {
            width: 100%;
            display: flex !important;
            align-items: center;
            gap: 16px;
            min-height: 54px;
            padding: 14px 16px !important;
            background: rgba(255, 255, 255, 0.035);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 18px;
            color: #fff !important;
            font-size: 14px;
            font-weight: 800 !important;
            transition: 0.2s ease;
        }

        .lira-mobile-nav-item .nav-link i,
        .lira-mobile-nav-item .nav-link .niro-icon {
            color: var(--lira-accent);
            width: 20px;
            height: 20px;
            text-align: center;
        }

        .lira-mobile-nav-item .nav-link.active {
            background: rgba(0, 230, 167, 0.10) !important;
            border-color: rgba(0, 230, 167, 0.24) !important;
            box-shadow: none;
        }

        .lira-mobile-menu-footer {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 2px;
        }

        .lira-menu-cta {
            min-height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 14px;
            gap: 10px;
            text-decoration: none;
        }

        .lira-menu-cta .niro-icon {
            width: 18px;
            height: 18px;
            color: currentColor;
        }

        .lira-menu-cta-primary {
            background: var(--lira-accent);
            color: #0d1117 !important;
        }

        .lira-menu-cta-outline {
            border: 1px solid rgba(0, 230, 167, 0.2);
            color: var(--lira-accent) !important;
        }
    }
</style>

<header class="header navbar-area lira-site-header {{ $isHome ? 'is-home' : 'is-inner' }}">
    <div class="container">
        <div class="nav-inner">
            <nav class="navbar navbar-expand-lg">
                <a href="{{ $mobileEntryRoute }}" class="lira-site-mobile-entry d-lg-none">
                    {{ $mobileEntryLabel }}
                </a>

                <a class="navbar-brand desktop-only d-none d-lg-inline-flex" href="{{ route('site.index') }}">
                    <span class="lira-site-brand-lockup">
                        <span class="logo default-logo">@include('includes.logo-white')</span>
                        @include('includes.logo-white', ['asText' => true])
                    </span>
                </a>

                <a class="lira-site-mobile-brand d-lg-none" href="{{ route('site.index') }}">
                    <span class="lira-site-brand-lockup">
                        <span class="logo">@include('includes.logo-white')</span>
                        @include('includes.logo-white', ['asText' => true])
                    </span>
                </a>

                <div class="lira-site-desktop-nav d-none d-lg-flex" aria-label="روابط رئيسية">
                    <ul class="lira-site-nav">
                        <li class="nav-item">
                            <a href="{{ route('site.index') }}" class="nav-link {{ $isHome ? 'active' : '' }}">
                                الرئيسية
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('terms') }}" class="nav-link {{ $isTerms ? 'active' : '' }}">
                                الشروط
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $supportRoute }}" target="_blank" class="nav-link">
                                تواصل معنا
                            </a>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler mobile-menu-btn lira-site-mobile-toggle d-lg-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#liraPublicNavbar"
                    aria-controls="liraPublicNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="lira-site-mobile-toggle-icon" aria-hidden="true">
                        <span class="lira-site-mobile-toggle-hamburger">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </span>
                        <span class="lira-site-mobile-toggle-close">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </span>
                </button>

                <div class="lira-site-actions desktop-only d-none d-lg-flex">
                    @if ($isAuth)
                        <a href="{{ $dashboardRoute }}" class="lira-site-link-btn">
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="lira-site-link-btn">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="btn lira-site-main-btn">
                            افتح حسابك
                        </a>
                    @endif
                </div>
            </nav>
        </div>

        {{-- Mobile Menu UI --}}
        <div class="collapse navbar-collapse d-lg-none" id="liraPublicNavbar">
            <div class="lira-mobile-menu-wrapper w-100">
                <div class="lira-mobile-menu-section">
                    <label class="lira-mobile-menu-label">القائمة الرئيسية</label>
                    <ul class="lira-mobile-nav-list">
                        <li class="lira-mobile-nav-item">
                            <a href="{{ route('site.index') }}" class="nav-link {{ $isHome ? 'active' : '' }}">
                                <x-niro-icon name="home" />
                                <span>الصفحة الرئيسية</span>
                            </a>
                        </li>
                        <li class="lira-mobile-nav-item">
                            <a href="{{ route('terms') }}" class="nav-link {{ $isTerms ? 'active' : '' }}">
                                <x-niro-icon name="security" />
                                <span>شروط الاستخدام</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="lira-mobile-menu-section">
                    <label class="lira-mobile-menu-label">الدعم والمساعدة</label>
                    <ul class="lira-mobile-nav-list">
                        <li class="lira-mobile-nav-item">
                            <a href="{{ $supportRoute }}" class="nav-link">
                                <x-niro-icon name="support" />
                                <span>تواصل مع الدعم</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="lira-mobile-menu-footer">
                    @if ($isAuth)
                        <a href="{{ $dashboardRoute }}" class="lira-menu-cta lira-menu-cta-primary">
                            <x-niro-icon name="dashboard" class="niro-icon--current" />
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="lira-menu-cta lira-menu-cta-primary">
                            <x-niro-icon name="login" class="niro-icon--current" />
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="lira-menu-cta lira-menu-cta-outline">
                            <x-niro-icon name="users" />
                            فتح حساب جديد
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

