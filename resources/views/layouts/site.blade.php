<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
        $brandLogo = asset('assets/images/home/LOGO-NIRO-3.webp');
        $pageTitle = trim($__env->yieldContent('title'));
        $isHomePage = request()->routeIs('site.index');
        $metaTitle = $isHomePage || $pageTitle === appName()
            ? appName()
            : trim(appName() . ($pageTitle ? ' - ' . $pageTitle : ''));
        $metaDescription = trim($__env->yieldContent('meta_description', 'NiroNex هي منصة تداول ذكية مدعومة بالذكاء الاصطناعي لإدارة الحسابات بأمان، والإيداع والسحب، وأدوات التداول الآلي.'));
        $canonicalUrl = url()->current();
        $metaLocale = app()->getLocale() === 'ar' ? 'ar_AR' : 'en_US';
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="index, follow">
    <meta name="application-name" content="{{ appName() }}">
    <meta name="apple-mobile-web-app-title" content="{{ appName() }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ appName() }}">
    <meta property="og:locale" content="{{ $metaLocale }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $brandLogo }}">
    <meta property="og:image:secure_url" content="{{ $brandLogo }}">
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="3676">
    <meta property="og:image:height" content="3254">
    <meta property="og:image:alt" content="{{ appName() }} logo">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $brandLogo }}">
    <meta name="twitter:image:alt" content="{{ appName() }} logo">
    <link rel="icon" href="{{ asset('assets/images/logo/niro-icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ $brandLogo }}">
    <meta name="theme-color" content="#0d1117">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=League+Spartan:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

    @stack('custom_styles')
    @if (isBrandTheme('nironex'))
        <link rel="stylesheet" href="{{ asset('assets/css/nironex-theme.css') }}" />
    @endif

    <!-- Shared UI Overrides -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --lira-bg: #0d1421;
            /* Deep slate blue */
            --lira-bg-alt: #080d15;
            /* Darker slate for contrast */
            --lira-card: #151e2f;
            /* Elevated slate for cards */
            --lira-accent: #00e6a7;
            --lira-accent-strong: #1a2bff;
            --lira-accent-soft: rgba(0, 230, 167, 0.12);
            /* Brand accent palette */
            --lira-text: #ffffff;
            --lira-text-muted: #94a3b8;
            /* Slate gray for muted text, perfectly harmonious */
        }

        html {
            scroll-padding-top: var(--lira-public-header-height, 92px);
        }

        body,
        .feature.section,
        .hero-area,
        .trust-section {
            background-color: var(--lira-bg) !important;
            color: var(--lira-text) !important;
            font-family: 'Cairo', sans-serif;
            /* Default to Cairo for normal text */
        }

        /* Desktop Navbar Layout - RTL with logo on right */
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

        /* Titles & Header in League Spartan */
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
            font-family: 'League Spartan', sans-serif !important;
        }

        /* Subtitles & Descriptions in Cairo */
        p,
        .hero-subtitle,
        .footer-subtitle,
        .trust-arabic,
        .text-muted {
            font-family: 'Cairo', sans-serif !important;
        }

        /* Ensure no accidental white backgrounds remain */
        .bg-white,
        section.bg-white,
        div.bg-white {
            background-color: var(--lira-bg) !important;
        }

        /* Higher specificity to override .feature.section base color */
        .bg-alt,
        section.bg-alt,
        div.bg-alt,
        .feature.section.bg-alt {
            background-color: var(--lira-bg-alt) !important;
        }

        @media (max-width: 991px) {
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
                padding: 0;
            }

            .footer .f-contact li a,
            .footer .social li {
                display: flex;
                justify-content: center;
                width: 100%;
            }

            .footer .social {
                flex-direction: row;
                gap: 20px;
            }

            .footer .logo {
                margin-bottom: 20px;
            }

            /* --- Rebuilt Mobile & Tablet Navigation --- */
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
                /* RTL: logo on right */
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
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                background: transparent !important;
                flex: 0 0 auto !important;
            }

            .header .button {
                order: 3 !important;
                margin: 0 !important;
                flex: 0 0 auto !important;
            }

            .header .button .btn {
                padding: 8px 15px !important;
                font-size: 13px !important;
                white-space: nowrap !important;
                display: inline-block !important;
                width: auto !important;
                height: auto !important;
                line-height: normal !important;
            }

            .header .navbar .navbar-collapse {
                background-color: var(--lira-bg) !important;
                padding: 20px !important;
                border-radius: 12px !important;
                margin-top: 15px !important;
                border: 1px solid var(--lira-border) !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 99999 !important;
                /* Increased specificity and z-index */
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6) !important;
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                transition: all 0.3s ease-in-out !important;
                max-height: none !important;
            }

            /* Force show when BS adds .show OR when toggler is .active */
            .header .navbar .navbar-collapse.show,
            .header .navbar .navbar-collapse.collapsing,
            .header .navbar .navbar-toggler.active+.navbar-collapse {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            /* Ensure all parents allow the menu to be seen */
            .navbar,
            .nav-inner,
            .navbar-area,
            .header {
                overflow: visible !important;
            }

            /* Ensure toggler icons are visible */
            .navbar-toggler .toggler-icon {
                background-color: #ffffff !important;
                display: block !important;
                height: 2px !important;
                width: 25px !important;
                margin: 5px 0 !important;
                transition: all 0.3s ease !important;
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
                font-size: 16px !important;
            }

            .navbar-nav .nav-item:last-child a {
                border-bottom: none !important;
            }

            /* Tablet Specific Optimizations (768px to 991px) */
            @media (min-width: 768px) {
                .navbar-brand {
                    max-width: 150px !important;
                }

                .header .button .btn {
                    padding: 10px 20px !important;
                    font-size: 14px !important;
                }
            }

        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        span {
            color: var(--lira-text) !important;
        }

        p {
            color: var(--lira-text-muted) !important;
        }

        .ycolor {
            color: var(--lira-accent) !important;
            font-style: normal !important;
        }

        /* Premium Footer Styles */
        .footer {
            background-color: var(--lira-bg) !important;
            padding-top: 50px !important;
            border-top: 1px solid var(--lira-border) !important;
        }

        .footer .single-footer h3 {
            font-family: 'League Spartan', sans-serif !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            color: var(--lira-accent) !important;
            margin-bottom: 30px !important;
            position: relative;
            display: inline-block;
        }

        .lira-metric-tile::before {
            display: none;
        }

        .footer .single-footer h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 30px;
            height: 2px;
            background: var(--lira-accent);
            border-radius: 2px;
        }

        .footer .single-footer p {
            font-size: 15px !important;
            line-height: 1.8 !important;
            color: var(--lira-text-muted) !important;
        }

        .footer .f-link li a,
        .footer .f-contact li a {
            color: var(--lira-text-muted) !important;
            font-size: 15px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
        }

        .footer .f-link li a:hover,
        .footer .f-contact li a:hover {
            color: var(--lira-accent) !important;
            padding-right: 5px !important;
        }

        .footer .social li a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff !important;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer .social li a:hover {
            background: var(--lira-accent) !important;
            color: var(--lira-bg) !important;
            transform: translateY(-3px);
            border-color: var(--lira-accent) !important;
        }

        .footer .social li a i {
            color: inherit !important;
            font-size: 18px !important;
        }

        .copyright-area {
            background-color: var(--lira-bg) !important;
            padding: 20px 0 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
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

        /* Footer Contact Fixes */
        .footer .f-contact li a i {
            width: 20px;
            display: inline-block;
            text-align: center;
        }

        .hero-title {
            font-size: 38px !important;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 16px !important;
            margin-bottom: 40px;
        }

        .btn {
            background-color: var(--lira-accent) !important;
            color: var(--lira-bg) !important;
            border: none;
            box-shadow: none !important;
            border-radius: 30px;
            padding: 12px 30px !important;
            line-height: 1.5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px !important;
            font-weight: 600;
            transition: all 0.3s ease;
            overflow: hidden;
            text-decoration: none;
            font-family: 'Cairo', sans-serif;
            width: auto !important;
            min-width: 140px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: var(--lira-accent) !important;
            color: var(--lira-bg) !important;
            filter: brightness(1.05);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18) !important;
            text-decoration: none;
        }

        .hero-title {
            position: relative;
            z-index: 1;
        }

        .hero-subtitle {
            position: relative;
            z-index: 1;
        }

        .hero-btn {
            font-size: 26px !important;
            /* Slightly more balanced */
            padding: 16px 45px !important;
            min-width: 280px;
            width: auto !important;
            /* Changed from 50% to auto for better centering */
            max-width: 100%;
            position: relative;
            z-index: 1;
        }

        .hero-area {
            min-height: calc(100vh - 84px);
            /* Full height minus header */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            /* Add some padding just to prevent edge touching */
            position: relative;
            overflow: hidden;
        }

        /* Ambient background accents removed */


        /* Hero Animations */
        @keyframes floatImage {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .hero-image {
            position: relative;
            z-index: 1;
        }

        .hero-image img {
            animation: floatImage 6s ease-in-out infinite;
            filter: drop-shadow(0 18px 28px rgba(0, 0, 0, 0.18));
        }

        @media (max-width: 991px) {
            .hero-area {
                padding: 0 !important;
                min-height: 100vh !important;
                min-height: 100dvh !important;
                /* Modern fix for mobile address bars */
                height: 100vh;
                height: 100dvh;
            }

            .hero-title {
                font-size: 30px !important;
            }

            .hero-subtitle {
                font-size: 15px !important;
            }

            .btn {
                font-size: 17px !important;
                padding: 10px 24px !important;
                min-width: 120px;
            }

            .hero-btn {
                font-size: 22px !important;
                padding: 14px 40px !important;
                width: auto !important;
                min-width: 220px;
            }
        }

        @media (min-width: 1200px) {
            body.lira-public-layout,
            body.lira-public-home {
                font-size: 14px;
            }

            .container {
                max-width: 1020px;
            }

            .header.navbar-area {
                padding: 10px 0 !important;
            }

            .navbar-nav .nav-item a {
                font-size: 15px !important;
                margin: 0 10px !important;
            }

            .header .button .btn,
            .btn {
                padding: 9px 22px !important;
                border-radius: 22px;
                font-size: 14px !important;
                min-width: 112px;
            }

            .hero-title {
                font-size: 32px !important;
                margin-bottom: 14px;
            }

            .hero-subtitle {
                font-size: 14px !important;
                margin-bottom: 28px;
            }

            .hero-btn {
                font-size: 20px !important;
                padding: 12px 34px !important;
                min-width: 220px;
            }

            .trust-section,
            .feature.section,
            .footer {
                padding-top: 44px !important;
                padding-bottom: 44px !important;
            }

            .footer .single-footer h3 {
                font-size: 17px !important;
                margin-bottom: 20px !important;
            }

            .footer .single-footer p,
            .footer .f-link li a,
            .footer .f-contact li a {
                font-size: 13px !important;
            }

            .hp-home section {
                padding-top: 60px;
                padding-bottom: 60px;
            }

            .hp-home .container {
                max-width: 1000px;
            }

            .hp-home .hp-editorial-hero {
                padding-top: calc(var(--lira-public-header-height, 92px) + 26px);
                padding-bottom: 42px;
            }

            .hp-home .hp-section-head {
                margin-bottom: 30px;
            }

            .hp-home .hp-section-title {
                font-size: 2.15rem;
            }

            .hp-home .hp-section-title--md {
                font-size: 1.8rem;
            }

            .hp-home .hp-section-desc {
                font-size: 0.86rem;
                line-height: 1.7;
            }

            .hp-home .hp-hero-title {
                font-size: 3.3rem;
            }

            .hp-home .hp-card,
            .hp-home .hp-mode-card,
            .hp-home .hp-trust-card,
            .hp-home .hp-testimonial-card {
                padding: 20px;
            }
        }

        @media (max-width: 575px) {
            .hero-title {
                font-size: 24px !important;
            }

            .hero-subtitle {
                font-size: 14px !important;
            }

            .btn {
                font-size: 16px !important;
                padding: 8px 20px !important;
                min-width: 100px;
            }

            .hero-btn {
                font-size: 19px !important;
                padding: 12px 30px !important;
                width: auto !important;
                min-width: 200px;
            }
        }

        /* Trust Section Styles */
        .trust-section {
            padding: 60px 0;
            background-color: var(--lira-bg) !important;
        }



        .trust-item {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            /* RTL feel: Icon on the right */
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .trust-item:hover {
            transform: translateY(-5px);
        }

        .trust-icon {
            width: 70px;
            height: 70px;
            border: 2px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            flex-shrink: 0;
            margin-right: 15px;
            /* Space from text in RTL */
        }

        .trust-icon.no-border {
            border: none;
            font-size: 40px;
        }

        .trust-content {
            text-align: right;
        }

        .trust-english {
            color: var(--lira-accent);
            font-family: 'League Spartan', sans-serif;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: inline-block;
            border-bottom: 2px solid var(--lira-accent);
            padding-bottom: 3px;
        }

        .trust-arabic {
            color: #fff;
            font-size: 13.5px;
            line-height: 1.6;
            margin-top: 5px;
        }

        @media (max-width: 991px) {
            .trust-item {
                justify-content: center;
                text-align: center;
            }

            .trust-content {
                text-align: center;
            }

            .trust-item {
                flex-direction: column;
                gap: 15px;
            }

            .trust-icon {
                margin: 0;
            }
        }

        .navbar-area {
            background-color: var(--lira-bg) !important;
            box-shadow: none !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer {
            background-color: var(--lira-bg) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .feature-box {
            background-color: var(--lira-card) !important;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: none !important;
            border-radius: 8px;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        .feature-box.elite-plan {
            border: 2px solid var(--lira-accent) !important;
        }

        .text-title {
            color: var(--lira-text) !important;
        }

        ul.text-end li {
            color: var(--lira-text-muted) !important;
        }

        /* Separate sections to control stacking correctly */
        .hero-area,
        .footer-top,
        .copyright-area {
            background-color: var(--lira-bg) !important;
            position: relative !important;
            z-index: 1;
            /* Lower than header */
        }

        /* Simplified Header - Solid & Clean - MUST BE ON TOP */
        .header.navbar-area {
            background-color: var(--lira-bg) !important;
            border-bottom: 2px solid var(--lira-border) !important;
            position: sticky !important;
            top: 0 !important;
            padding: 15px 0 !important;
            z-index: 9999 !important;
            /* Extremely high to stay on top of hero/other sections */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
            overflow: visible !important;
        }

        /* Responsive Mobile Menu Link Colors - Force Dark or Contrast */
        @media (max-width: 991px) {
            .header .navbar .navbar-collapse .navbar-nav .nav-item a {
                color: #ffffff !important;
                background: transparent !important;
                text-align: right !important;
                padding: 15px !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            }

            .header .navbar .navbar-collapse {
                background-color: var(--lira-bg) !important;
                border: 1px solid var(--lira-border) !important;
                z-index: 10000 !important;
            }
        }

        .header.navbar-area.sticky {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            background-color: var(--lira-bg) !important;
            animation: none !important;
            padding: 10px 0 !important;
        }

        .navbar-nav .nav-item a {
            font-family: 'Cairo', sans-serif !important;
            font-weight: 700 !important;
            font-size: 18px !important;
            margin: 0 15px !important;
            color: #fff !important;
            opacity: 0.95;
        }

        .navbar-nav .nav-item a:hover {
            color: var(--lira-accent) !important;
            opacity: 1;
        }

        /* Simplified Button for Header */
        .header .button .btn {
            background: var(--lira-accent) !important;
            color: var(--lira-bg) !important;
            font-weight: 700 !important;
            padding: 10px 22px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            border: none !important;
            box-shadow: none !important;
            min-width: auto !important;
            width: auto !important;
            height: auto !important;
            transition: opacity 0.3s ease !important;
        }

        .header .button .btn:hover {
            opacity: 0.8 !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .section-title h2 {
            color: var(--lira-text) !important;
        }

        .lni,
        .fa,
        .fas,
        .far {
            color: var(--lira-accent) !important;
        }

        /* Scroll Top Button - Unified Design */
        .scroll-top {
            background-color: var(--lira-accent) !important;
            color: var(--lira-bg) !important;
            border-radius: 14px !important;
            width: 48px !important;
            height: 48px !important;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.16) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: background-color 0.22s ease, transform 0.22s ease, box-shadow 0.22s ease !important;
            border: 1px solid rgba(0, 230, 167, 0.82) !important;
            position: fixed;
            bottom: 24px;
            right: auto;
            inset-inline-start: auto !important;
            inset-inline-end: 24px !important;
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
            color: var(--lira-bg) !important;
            font-size: 20px !important;
            line-height: 1 !important;
        }

        .scroll-top:hover {
            background-color: #14efb3 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18) !important;
        }

        .scroll-top:hover i {
            color: var(--lira-bg) !important;
        }

        .scroll-top:focus,
        .scroll-top:active {
            outline: none !important;
        }

        body.lira-public-layout {
            padding-top: var(--lira-public-header-height, 92px) !important;
        }
        /* Modern Toast Notifications */
        .lira-toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .lira-toast {
            pointer-events: auto;
            min-width: 280px;
            padding: 16px 20px;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.98);
            border: 1px solid rgba(0, 230, 167, 0.14);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.22);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.24s ease, transform 0.24s ease;
            font-size: 14px;
            font-weight: 600;
        }

        .lira-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .lira-toast--error {
            border-color: rgba(239, 68, 68, 0.3);
            background: rgba(20, 10, 10, 0.95);
        }

        .lira-toast--success {
            border-color: rgba(34, 197, 94, 0.3);
            background: rgba(10, 20, 10, 0.95);
        }

        .lira-toast-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .lira-toast--error .lira-toast-icon { color: #ef4444; }
        .lira-toast--success .lira-toast-icon { color: #22c55e; }
        .lira-toast--info .lira-toast-icon { color: var(--lira-accent); }

        @media (max-width: 767px) {
            .lira-toast-container {
                top: auto;
                bottom: 100px;
                right: 10px;
                left: 10px;
                align-items: center;
            }
            .lira-toast {
                width: 100%;
                min-width: 0;
                transform: translateY(150%);
            }
            .lira-toast.show {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Fund Amount Buttons */
        .lira-amount-pill {
            background: rgba(0, 230, 167, 0.08) !important;
            border: 1px solid rgba(0, 230, 167, 0.3) !important;
            color: var(--lira-accent) !important;
            border-radius: 10px !important;
            padding: 6px 14px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            transition: all 0.2s ease !important;
        }

        .lira-amount-pill:hover {
            background: rgba(0, 230, 167, 0.15) !important;
            border-color: var(--lira-accent) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.14);
        }

        @media (min-width: 1200px) {
            body.has-home-auth-sidebar {
                --hp-auth-sidebar-width: 300px;
                padding-right: var(--hp-auth-sidebar-width);
            }

            body.has-home-auth-sidebar .header.navbar-area.lira-site-header {
                inset-inline: auto !important;
                right: var(--hp-auth-sidebar-width) !important;
                left: 0 !important;
                width: auto !important;
                top: 0 !important;
                padding-top: 0 !important;
            }

            body.has-home-auth-sidebar .lira-site-header > .container {
                width: 100% !important;
                max-width: none !important;
                padding-inline: 0 !important;
                margin-inline: 0 !important;
            }

            body.has-home-auth-sidebar .lira-site-header .nav-inner {
                width: 100% !important;
                border-radius: 0;
                border-inline: 0;
                background: #05080E;
            }

            body.has-home-auth-sidebar .lira-site-header .navbar {
                max-width: var(--hp-shell-width, 1220px);
                min-height: 63px;
                height: 63px;
                margin-inline: auto;
                padding-right: 26px !important;
                padding-left: 26px !important;
            }

            body.has-home-auth-sidebar .scroll-top {
                right: calc(var(--hp-auth-sidebar-width) + 24px) !important;
            }
        }
    </style>
</head>

<body class="{{ request()->routeIs('site.index') ? 'lira-public-home' : 'lira-public-layout' }} {{ request()->routeIs('site.index') ? 'has-home-auth-sidebar' : '' }} {{ isBrandTheme('nironex') ? 'theme-nironex' : '' }}">

    @include('site.includes.site-header')

    @include('includes.messages')

    @yield('content')

    @include('site.includes.site-footer')

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>


    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        //========= Road Map 
        tns({
            container: '.road-map-slider',
            items: 1,
            slideBy: 'page',
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            nav: true,
            controls: false,
            responsive: {
                0: {
                    items: 2,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 4,
                },
                1170: {
                    items: 6,
                }
            }
        });

        //========= testimonial 
        tns({
            container: '.testimonial-slider',
            items: 3,
            slideBy: 'page',
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            nav: true,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1170: {
                    items: 3,
                }
            }
        });

        //====== counter up 
        var cu = new counterUp({
            start: 0,
            duration: 2000,
            intvalues: true,
            interval: 100,
            append: " ",
        });
        cu.start();

        //========= glightbox
        GLightbox({
            'href': 'https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM',
            'type': 'video',
            'source': 'youtube', //vimeo, youtube or local
            'width': 900,
            'autoplayVideos': true,
        });

        // Diagnostic & Manual Toggle for Mobile Menu
        document.addEventListener('DOMContentLoaded', () => {
            const toggler = document.querySelector('.mobile-menu-btn');
            const menu = document.querySelector('#navbarSupportedContent');

            if (toggler && menu) {
                toggler.addEventListener('click', () => {
                    console.log('Menu Toggler Clicked');
                    // Manual fallback if BS fails
                    setTimeout(() => {
                        const isActive = toggler.classList.contains('active');
                        console.log('Toggler active state:', isActive);
                        if (isActive) {
                            menu.style.setProperty('display', 'block', 'important');
                            menu.style.setProperty('visibility', 'visible', 'important');
                            menu.style.setProperty('opacity', '1', 'important');
                        }
                    }, 50);
                });
            } else {
                console.error('Mobile menu elements not found:', { toggler: !!toggler, menu: !!menu });
            }
        });

        // Auto-close mobile menu when a link is clicked
        document.querySelectorAll('.navbar-nav .nav-item a').forEach(link => {
            link.addEventListener('click', () => {
                const navbarCollapse = document.getElementById('navbarSupportedContent');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
                // Also remove active class from toggler
                const toggler = document.querySelector('.mobile-menu-btn');
                if (toggler) toggler.classList.remove('active');
            });
        });
        if (window.NiroFeedback && typeof window.NiroFeedback.toast === 'function') {
            window.showNotification = function (message, type = 'info', options = {}) {
                window.NiroFeedback.toast(message, type, options);
            };
        }
    </script>
    @stack('custom_scripts')
</body>

</html>

