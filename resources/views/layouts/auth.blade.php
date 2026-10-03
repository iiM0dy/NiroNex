<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
        $brandLogo = asset('assets/images/home/LOGO-NIRO-3.png');
        $pageTitle = trim($__env->yieldContent('title'));
        $metaTitle = trim(appName() . ($pageTitle ? ' - ' . $pageTitle : ''));
        $metaDescription = trim($__env->yieldContent('meta_description', 'Access your NiroNex account to manage trading tools, secure wallets, verification, deposits, withdrawals, and AI robot services.'));
        $canonicalUrl = url()->current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $brandLogo }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $brandLogo }}">
    <link rel="icon" href="{{ $brandLogo }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ $brandLogo }}">
    <meta name="theme-color" content="#0d1117">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --lira-bg: #07090d;
            --lira-bg-2: #0b0f15;
            --lira-surface: #10141c;
            --lira-surface-2: #141a23;
            --lira-surface-3: #171e29;
            --lira-border: #222a36;
            --lira-border-strong: #2b3442;
            --lira-text: #f7f8fa;
            --lira-text-soft: #c5cad3;
            --lira-text-muted: #8d96a5;
            --lira-gold: #00e6a7;
            --lira-gold-strong: #1a2bff;
            --lira-gold-soft: rgba(0, 230, 167, 0.12);
            --lira-success: #17b26a;
            --lira-danger: #f04438;
            --lira-warning: #7861ff;
            --lira-info: #0ba5ec;
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 26px;
            --shadow-soft: 0 18px 48px rgba(0, 0, 0, 0.28);
            --lira-public-header-height: 92px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
            max-width: 100%;
        }

        html {
            scroll-padding-top: var(--lira-public-header-height);
        }

        @media (max-width: 767.98px) {
            .row {
                margin-left: 0;
                margin-right: 0;
            }
        }


        body {
            margin: 0;
            direction: rtl;
            font-family: "Cairo", sans-serif !important;
            background: linear-gradient(180deg, #080a0e 0%, #090c11 100%);
            color: var(--lira-text);
            overflow-x: hidden;
        }

        body.lira-public-layout {
            padding-top: var(--lira-public-header-height) !important;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.014) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.014) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.35), transparent 85%);
            z-index: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .hero-title,
        .section-title h2,
        .section-title h3,
        .footer-title,
        .navbar-nav .nav-item a,
        .footer .single-footer h3 {
            font-family: "Cairo", sans-serif !important;
            color: var(--lira-text) !important;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        p,
        span,
        div,
        small,
        li,
        a,
        label {
            color: inherit;
        }

        a {
            text-decoration: none;
        }

        .text-muted {
            color: var(--lira-text-muted) !important;
        }

        /* Header */
        .header.navbar-area {
            position: relative !important;
            z-index: 1000 !important;
            background: rgba(7, 9, 13, 0.82) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            padding: 14px 0 !important;
        }

        .header.navbar-area.sticky {
            position: fixed !important;
            top: 0;
            inset-inline: 0;
            background: rgba(7, 9, 13, 0.9) !important;
            padding: 12px 0 !important;
            animation: none !important;
        }

        .navbar,
        .nav-inner,
        .navbar-area,
        .header {
            overflow: visible !important;
        }

        @media (min-width: 992px) {
            .navbar {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 0 !important;
                flex-direction: row !important;
            }

            .navbar-brand {
                order: 1 !important;
                margin: 0 !important;
            }

            .navbar-toggler {
                order: 2 !important;
            }

            .header .button {
                order: 4 !important;
                margin: 0 !important;
            }

            .navbar-collapse {
                order: 3 !important;
                flex-grow: 1 !important;
                display: flex !important;
                justify-content: flex-end !important;
            }

            .navbar-nav {
                margin: 0 0 0 auto !important;
            }
        }

        .navbar-nav .nav-item a {
            font-family: "Cairo", sans-serif !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            margin: 0 12px !important;
            color: var(--lira-text-soft) !important;
            opacity: 1;
        }

        .navbar-nav .nav-item a:hover,
        .navbar-nav .nav-item a.active {
            color: var(--lira-gold) !important;
        }

        .header .button .btn {
            background: linear-gradient(180deg, var(--lira-gold-strong), var(--lira-gold)) !important;
            color: #17120a !important;
            font-weight: 800 !important;
            padding: 10px 20px !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            border: none !important;
            box-shadow: none !important;
            min-width: auto !important;
            width: auto !important;
            height: auto !important;
        }

        .header .button .btn:hover {
            filter: brightness(1.03) !important;
            transform: translateY(-1px);
        }

        @media (max-width: 991px) {
            :root {
                --lira-public-header-height: 76px;
            }

            .header.navbar-area {
                padding: 10px 0 !important;
            }

            .nav-inner {
                display: block !important;
            }

            .navbar {
                display: flex !important;
                flex-wrap: wrap !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 0 !important;
                position: relative !important;
                flex-direction: row-reverse !important;
            }

            .navbar-brand {
                max-width: 120px !important;
                margin: 0 !important;
                padding: 0 !important;
                order: 1 !important;
                flex: 0 0 auto !important;
            }

            .navbar-toggler {
                order: 2 !important;
                margin: 0 !important;
                padding: 8px !important;
                border: 1px solid var(--lira-border) !important;
                background: rgba(255, 255, 255, 0.03) !important;
                flex: 0 0 auto !important;
                border-radius: 12px !important;
            }

            .navbar-toggler .toggler-icon {
                background-color: #ffffff !important;
                display: block !important;
                height: 2px !important;
                width: 25px !important;
                margin: 5px 0 !important;
                transition: all 0.3s ease !important;
            }

            .header .button {
                order: 3 !important;
                margin: 0 !important;
                flex: 0 0 auto !important;
            }

            .header .button .btn {
                padding: 8px 14px !important;
                font-size: 13px !important;
                white-space: nowrap !important;
            }

            .header .navbar .navbar-collapse {
                position: absolute !important;
                top: calc(100% + 12px) !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 99999 !important;
                background: var(--lira-surface) !important;
                border: 1px solid var(--lira-border) !important;
                border-radius: 18px !important;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5) !important;
                padding: 14px !important;
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                transition: 0.25s ease !important;
            }

            .header .navbar .navbar-collapse.show,
            .header .navbar .navbar-collapse.collapsing,
            .header .navbar .navbar-toggler.active+.navbar-collapse {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .navbar-nav {
                margin: 0 !important;
                padding: 0 !important;
                text-align: right !important;
            }

            .navbar-nav .nav-item a {
                color: var(--lira-text) !important;
                display: block !important;
                padding: 12px 10px !important;
                margin: 0 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
                font-size: 15px !important;
            }

            .navbar-nav .nav-item:last-child a {
                border-bottom: none !important;
            }
        }

        /* Breadcrumbs */
        .breadcrumbs {
            background: transparent !important;
            padding: 26px 0 8px !important;
            border: 0 !important;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .breadcrumbs::before {
            display: none !important;
        }

        .breadcrumbs .page-title {
            font-size: 28px !important;
            margin-bottom: 10px !important;
            color: var(--lira-text) !important;
        }

        .breadcrumbs .breadcrumb-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }

        .breadcrumbs .breadcrumb-nav li {
            color: var(--lira-text-muted) !important;
            font-size: 14px;
        }

        .breadcrumbs .breadcrumb-nav li a {
            color: var(--lira-gold) !important;
        }

        /* Generic forms / cards */
        .card,
        .login-form,
        .register-form,
        .modal-content {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.015), rgba(255, 255, 255, 0.008)), var(--lira-surface) !important;
            border: 1px solid var(--lira-border) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-soft) !important;
            color: var(--lira-text) !important;
        }

        .card-body,
        .modal-body {
            color: var(--lira-text) !important;
        }

        .form-control,
        .form-select,
        input,
        textarea,
        select {
            background: var(--lira-surface-2) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: 14px !important;
            box-shadow: none !important;
        }

        .form-control::placeholder,
        input::placeholder,
        textarea::placeholder {
            color: #778191 !important;
        }

        .form-control:focus,
        .form-select:focus,
        input:focus,
        textarea:focus,
        select:focus {
            background: var(--lira-surface-2) !important;
            border-color: rgba(0, 230, 167, 0.45) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.08) !important;
            color: var(--lira-text) !important;
        }

        .invalid-feedback {
            font-size: 12px;
            margin-top: 6px;
            padding-right: 2px;
            color: #ff968f !important;
        }

        .btn-submit,
        .login-form .button .btn,
        .register-form .button .btn,
        .btn-primary {
            background: linear-gradient(180deg, var(--lira-gold-strong), var(--lira-gold)) !important;
            color: #17120a !important;
            border: none !important;
            border-radius: 14px !important;
            font-weight: 800 !important;
            box-shadow: none !important;
        }

        .btn-submit:hover,
        .login-form .button .btn:hover,
        .register-form .button .btn:hover,
        .btn-primary:hover {
            filter: brightness(1.03) !important;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border-color: rgba(0, 230, 167, 0.34) !important;
            color: var(--lira-gold) !important;
            background: transparent !important;
            border-radius: 14px !important;
        }

        .btn-outline-primary:hover {
            background: var(--lira-gold-soft) !important;
            color: var(--lira-gold) !important;
            border-color: rgba(0, 230, 167, 0.45) !important;
        }

        .form-check {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .form-check-input {
            width: 18px !important;
            height: 18px !important;
            margin: 0 !important;
            float: none !important;
            background-color: var(--lira-surface-2) !important;
            border-color: var(--lira-border) !important;
            cursor: pointer;
            box-shadow: none !important;
        }

        .form-check-input:checked {
            background-color: var(--lira-gold) !important;
            border-color: var(--lira-gold) !important;
        }

        .form-check-label {
            color: var(--lira-text-soft) !important;
            font-size: 13px !important;
            cursor: pointer;
            line-height: 1.2 !important;
            margin: 0 !important;
        }

        /* Footer */
        .footer {
            background: transparent !important;
            padding-top: 50px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
            position: relative;
            z-index: 1;
        }

        .footer .single-footer h3 {
            font-size: 18px !important;
            color: var(--lira-text) !important;
            margin-bottom: 24px !important;
            position: relative;
            display: inline-block;
        }

        .footer .single-footer h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 30px;
            height: 2px;
            background: var(--lira-gold);
            border-radius: 2px;
        }

        .footer .single-footer p {
            font-size: 15px !important;
            line-height: 1.9 !important;
            color: var(--lira-text-muted) !important;
        }

        .footer .f-link li a,
        .footer .f-contact li a {
            color: var(--lira-text-muted) !important;
            font-size: 15px !important;
            transition: all 0.25s ease !important;
            text-decoration: none !important;
        }

        .footer .f-link li a:hover,
        .footer .f-contact li a:hover {
            color: var(--lira-gold) !important;
            padding-right: 5px !important;
        }

        .footer .social {
            display: flex !important;
            gap: 12px !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
        }

        .footer .social li a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--lira-text) !important;
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer .social li a:hover {
            background: var(--lira-gold) !important;
            color: #17120a !important;
            transform: translateY(-3px);
            border-color: var(--lira-gold) !important;
        }

        .footer .social li a i {
            color: inherit !important;
            font-size: 16px !important;
        }

        .footer .f-contact li {
            margin-bottom: 14px !important;
        }

        .footer .f-contact li a {
            display: flex !important;
            align-items: center !important;
        }

        .footer .f-contact li a i {
            width: 22px !important;
            display: inline-block !important;
            text-align: center !important;
            color: var(--lira-gold) !important;
            margin-inline-end: 8px !important;
        }

        .copyright-area {
            background: transparent !important;
            padding: 18px 0 24px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
            margin-top: 18px !important;
        }

        .copyright-area .inner-content {
            border-top: none !important;
            padding: 0 !important;
        }

        .copyright-text {
            font-size: 14px !important;
            color: var(--lira-text-muted) !important;
            margin: 0 !important;
        }

        @media (max-width: 768px) {
            .footer .single-footer {
                text-align: center;
                margin-bottom: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .footer .social,
            .footer .f-contact ul,
            .footer .f-link ul {
                justify-content: center !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 0 !important;
            }

            .footer .social {
                flex-direction: row !important;
            }
        }

        /* Scroll top */
        .scroll-top {
            background: linear-gradient(180deg, var(--lira-gold-strong), var(--lira-gold)) !important;
            color: #17120a !important;
            border-radius: 50% !important;
            width: 46px !important;
            height: 46px !important;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.28) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: 0.25s ease !important;
            border: none !important;
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 1000;
            text-decoration: none !important;
            opacity: 0;
            visibility: hidden;
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top i {
            color: #17120a !important;
            font-size: 18px !important;
            line-height: 1 !important;
        }

        .scroll-top:hover {
            transform: translateY(-4px) !important;
        }

        /* WhatsApp */
        .whatsapp-float {
            position: fixed !important;
            bottom: 28px !important;
            left: 28px !important;
            right: auto !important;
            z-index: 1000 !important;
            background: #25d366 !important;
            box-shadow: 0 12px 26px rgba(37, 211, 102, 0.28) !important;
            border-radius: 50% !important;
            width: 58px !important;
            height: 58px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: 0.25s ease !important;
            text-decoration: none !important;
        }

        .whatsapp-float:hover {
            transform: translateY(-2px) scale(1.03) !important;
        }

        .whatsapp-float img {
            width: 34px !important;
            height: 34px !important;
            object-fit: contain !important;
        }

        @media (max-width: 991px) {
            .whatsapp-float {
                width: 52px !important;
                height: 52px !important;
                bottom: 16px !important;
                left: 16px !important;
            }

            .whatsapp-float img {
                width: 28px !important;
                height: 28px !important;
            }

            .scroll-top {
                bottom: 16px !important;
                right: 16px !important;
                width: 42px !important;
                height: 42px !important;
            }
        }

        /* Reset some old theme bleed */
        .account-login.section,
        .register-login.section,
        .section {
            background: transparent !important;
            color: var(--lira-text) !important;
            position: relative;
            z-index: 1;
        }

        .input-group {
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            overflow: visible !important;
            display: block !important;
        }

        .input-group label {
            margin-bottom: 0 !important;
        }
    </style>

    @stack('custom_styles')
    <style>
        /* ─── PREMIUM CUSTOM SCROLLBAR (FORCED) ─── */
        * {
            scrollbar-width: thin !important;
            scrollbar-color: #00e6a7 #0B0F15 !important;
        }

        html {
            overflow-y: scroll !important;
            scrollbar-gutter: stable !important;
            height: auto !important;
            min-height: 100% !important;
        }

        body {
            min-height: 100% !important;
            direction: rtl;
        }

        /* Webkit Browsers */
        ::-webkit-scrollbar {
            width: 12px !important;
            height: 12px !important;
            display: block !important;
        }

        ::-webkit-scrollbar-track {
            background: #0B0F15 !important;
            border-radius: 10px !important;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #00e6a7 !important;
            border-radius: 10px !important;
            border: 3px solid transparent !important;
            background-clip: content-box !important;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #38bdf8 !important;
        }
    </style>
    @if (isBrandTheme('nironex'))
        <link rel="stylesheet" href="{{ asset('assets/css/nironex-theme.css') }}">
    @endif
</head>

<body class="lira-public-layout {{ isBrandTheme('nironex') ? 'theme-nironex' : '' }}">
    @include('site.includes.site-header')

    @yield('content')

    @include('site.includes.site-footer')

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>



    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>

    <script>
        document.querySelectorAll('.navbar-nav .nav-item a').forEach(link => {
            link.addEventListener('click', () => {
                const navbarCollapse = document.getElementById('navbarSupportedContent');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>

    @stack('custom_scripts')
</body>

</html>

