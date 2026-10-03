<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
        $brandLogo = asset('assets/images/home/LOGO-NIRO-3.webp');
        $pageTitle = trim($__env->yieldContent('title'));
        $metaTitle = trim(appName() . ($pageTitle ? ' - ' . $pageTitle : ''));
        $metaDescription = trim($__env->yieldContent('meta_description', 'NiroNex user dashboard for wallet balances, trading tools, deposits, withdrawals, robot settings, and account management.'));
        $canonicalUrl = url()->current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="icon" href="{{ asset('assets/images/logo/niro-icon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ $brandLogo }}">
    <meta name="theme-color" content="#0d1117">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @stack('styles')

    <link rel="stylesheet" href="{!! backendAssets('ebazar.style.min.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --lira-bg: #07090d;
            --lira-bg-elevated: #0b0f15;
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
            --lira-accent: var(--lira-gold);
            --lira-accent-strong: var(--lira-gold-strong);
            --lira-accent-soft: var(--lira-gold-soft);
            --lira-success: #17b26a;
            --lira-danger: #f04438;
            --lira-warning: #7861ff;
            --lira-info: #0ba5ec;
            --sidebar-width: 292px;
            --header-height: 76px;
            --dash-content-max-width: 1120px;
            --dash-content-gutter: 28px;
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 24px;
            --shadow-soft: 0 18px 48px rgba(0, 0, 0, 0.28);
            --shadow-gold: 0 0 0 1px rgba(0, 230, 167, 0.14), 0 16px 36px rgba(26, 43, 255, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            direction: rtl;
        }

        /* --- MOBILE NATIVE APP BOTTOM NAV CSS --- */
        .lira-bottom-nav {
            display: none;
        }

        @media (max-width: 1024.98px) {
            body {
                padding-bottom: 80px !important; /* Space for Bottom Nav */
            }
            .lira-sidebar {
                display: none !important; /* Override sidebar on tablets and mobile */
            }
            .lira-main-content {
                width: 100% !important;
                margin-right: 0 !important;
            }
            .lira-bottom-nav {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 70px;
                background: rgba(11, 15, 21, 0.95);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(255,255,255,0.06);
                z-index: 1050;
                justify-content: space-around;
                align-items: center;
                padding: 0 10px;
                box-shadow: 0 -10px 40px rgba(0,0,0,0.8);
            }
            .lira-bottom-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                color: var(--lira-text-muted);
                text-decoration: none;
                flex: 1;
                height: 100%;
                font-size: 0.72rem;
                font-weight: 700;
                transition: color 0.2s ease;
            }
            .lira-bottom-nav-item i,
            .lira-bottom-nav-item .niro-icon {
                font-size: 1.35rem;
                width: 22px;
                height: 22px;
                color: currentColor;
                margin-bottom: 2px;
                transition: transform 0.2s ease, text-shadow 0.2s ease;
            }
            .lira-bottom-nav-item:active, .lira-bottom-nav-item.active {
                color: var(--lira-gold);
            }
            .lira-bottom-nav-item.active i,
            .lira-bottom-nav-item.active .niro-icon {
                transform: translateY(-2px);
            }

            .lira-bottom-nav-item.is-tablet-only {
                display: none;
            }
        }

        @media (min-width: 768px) and (max-width: 1024.98px) {
            .lira-bottom-nav {
                padding: 0 6px;
            }

            .lira-bottom-nav-item {
                font-size: 0.66rem;
            }

            .lira-bottom-nav-item i {
                font-size: 1.1rem;
            }

            .lira-bottom-nav-item.is-tablet-only {
                display: flex;
            }
        }

        body {
            background: linear-gradient(180deg, #080a0e 0%, #090c11 100%);
            color: var(--lira-text);
            font-family: "Cairo", sans-serif !important;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
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
        .brand-name,
        .modal-title {
            color: var(--lira-text) !important;
            font-family: "Cairo", sans-serif !important;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .ycolor {
            color: var(--lira-gold) !important;
        }

        .ybg {
            background-color: var(--lira-gold) !important;
        }

        .lira-dash-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* Sidebar */
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
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.02), transparent 28%),
                var(--lira-bg-elevated) !important;
            border-left: 1px solid var(--lira-border) !important;
            box-shadow: -24px 0 60px rgba(0, 0, 0, 0.28);
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--lira-border-strong) transparent;
        }

        .lira-sidebar::-webkit-scrollbar {
            width: 7px;
        }

        .lira-sidebar::-webkit-scrollbar-thumb {
            background: var(--lira-border-strong);
            border-radius: 999px;
        }

        .lira-main-content {
            min-height: 100vh;
            margin-right: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            position: relative;
            transition: margin-right 0.3s ease, width 0.3s ease;
        }

        /* Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 1030;
            min-height: var(--header-height);
            display: flex;
            align-items: center;
            background: rgba(7, 9, 13, 0.82) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            padding: 14px 24px !important;
        }

        .header .navbar {
            width: 100%;
            padding: 0 !important;
            min-height: 46px;
        }

        .header .nav-link,
        .header .dropdown-toggle,
        .header .btn,
        .header .icon,
        .header .fa,
        .header .bi {
            color: var(--lira-text-soft) !important;
        }

        .header .nav-link:hover,
        .header .dropdown-toggle:hover {
            color: var(--lira-text) !important;
        }

        .header .navbar-brand,
        .header .brand-name {
            color: var(--lira-text) !important;
            font-weight: 800;
        }

        /* Content */
        .lira-page-shell {
            flex: 1;
            padding: var(--dash-content-gutter);
        }

        .lira-page-shell>.container-xxl,
        .lira-page-shell .container-xxl {
            width: 100%;
            max-width: var(--dash-content-max-width);
            margin-inline: auto;
        }

        .lira-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .lira-eyebrow {
            display: inline-block;
            margin-bottom: 8px;
            color: var(--lira-gold);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .lira-page-title {
            margin: 0;
            font-size: clamp(1.7rem, 2.2vw, 2.4rem);
            line-height: 1.15;
        }

        .lira-page-subtitle {
            margin: 8px 0 0;
            max-width: 760px;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .grow {
            flex: 1;
        }

        /* Sidebar navigation */
        .menu-list .m-link {
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

        .menu-list .m-link i,
        .menu-list .m-link .niro-icon {
            width: 18px;
            height: 18px;
            text-align: center;
            margin: 0 !important;
            color: currentColor !important;
            opacity: 0.92;
        }

        .menu-list .m-link:hover {
            color: var(--lira-text) !important;
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .menu-list .m-link.active,
        .menu-list .m-link.router-link-active,
        .menu-list .m-link[aria-expanded="true"] {
            color: var(--lira-gold) !important;
            background: linear-gradient(90deg, rgba(0, 230, 167, 0.12), rgba(0, 230, 167, 0.04)) !important;
            border-right-color: var(--lira-gold) !important;
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.08);
        }

        .sub-menu {
            background: transparent !important;
            padding: 4px 10px 6px 0 !important;
            margin: 0 8px 8px 0;
        }

        .sub-menu .m-link {
            font-size: 14px;
            padding: 10px 16px !important;
            margin-right: 18px;
            border-radius: 12px;
        }

        /* Cards */
        .card,
        .modal-content,
        .list-group-item,
        .dropdown-menu {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.015), rgba(255, 255, 255, 0.008)), var(--lira-surface) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: var(--shadow-soft);
        }

        .card-header,
        .card-footer,
        .modal-header,
        .modal-footer {
            background: transparent !important;
            border-color: var(--lira-border) !important;
            padding: 18px 20px !important;
        }

        .card-body,
        .modal-body {
            padding: 20px !important;
        }

        .card-header h6,
        .card-title {
            margin: 0;
            color: var(--lira-text) !important;
            font-weight: 700;
        }

        /* Tables */
        table,
        .table {
            color: var(--lira-text) !important;
            border-color: var(--lira-border) !important;
            margin-bottom: 0;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: transparent;
            --bs-table-hover-bg: transparent;
        }

        .table thead th {
            color: var(--lira-text-muted) !important;
            background: rgba(255, 255, 255, 0.015) !important;
            border-bottom: 1px solid var(--lira-border) !important;
            border-top: none !important;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
            padding: 14px 16px !important;
            text-align: right;
        }

        .table tbody tr {
            background: transparent !important;
            transition: background-color 0.2s ease;
        }

        .table tbody td,
        .table tbody th {
            color: var(--lira-text-soft) !important;
            background: transparent !important;
            border-color: rgba(255, 255, 255, 0.04) !important;
            padding: 16px !important;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        .table .badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            font-weight: 700;
            padding: 8px 10px;
        }

        /* Datatables */
        .dataTables_wrapper,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--lira-text-muted) !important;
        }

        table.dataTable.no-footer,
        table.dataTable thead th,
        table.dataTable thead td {
            border-color: var(--lira-border) !important;
        }

        /* Forms */
        .form-label {
            color: var(--lira-text-soft) !important;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select,
        .input-group-text,
        input[type="search"],
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        input[type="tel"],
        textarea,
        select {
            min-height: 46px;
            background: var(--lira-surface-2) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: 14px !important;
            box-shadow: none !important;
        }

        .form-control::placeholder,
        textarea::placeholder,
        input::placeholder {
            color: #778191 !important;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus,
        input:focus,
        select:focus {
            background: var(--lira-surface-2) !important;
            border-color: rgba(0, 230, 167, 0.55) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.08) !important;
            color: var(--lira-text) !important;
        }

        .input-group-text {
            color: var(--lira-text-muted) !important;
        }

        /* Buttons */
        .btn {
            border-radius: 14px !important;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: none !important;
        }

        .btn:focus,
        .btn:active {
            box-shadow: none !important;
        }

        .btn-primary,
        .bg-primary {
            background: var(--lira-gold) !important;
            border-color: var(--lira-gold) !important;
            color: #000 !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            background: #00c891 !important;
            border-color: #00c891 !important;
            color: #000 !important;
            filter: none;
        }

        .btn-outline-primary {
            border-color: rgba(0, 230, 167, 0.34) !important;
            color: var(--lira-gold) !important;
            background: transparent !important;
        }

        .btn-outline-primary:hover {
            background: var(--lira-gold-soft) !important;
            border-color: rgba(0, 230, 167, 0.45) !important;
            color: var(--lira-gold) !important;
        }

        .btn-danger,
        .bg-danger,
        .badge.bg-danger {
            background: rgba(240, 68, 56, 0.16) !important;
            border-color: rgba(240, 68, 56, 0.22) !important;
            color: #ff8a80 !important;
        }

        .badge.bg-success,
        .text-success {
            background: rgba(23, 178, 106, 0.16) !important;
            color: #5fe2a1 !important;
        }

        .badge.bg-warning {
            background: rgba(120, 97, 255, 0.16) !important;
            color: #c4b6ff !important;
        }

        .badge.bg-info,
        .alert-info {
            background: rgba(11, 165, 236, 0.14) !important;
            color: #66cfff !important;
            border-color: rgba(11, 165, 236, 0.2) !important;
        }

        /* Page Header Base */
        .lira-page-header { margin-bottom: 20px; }
        .lira-eyebrow { display: inline-flex; align-items: center; gap: 8px; color: var(--lira-gold); font-size: 12px; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 10px; }
        .lira-page-title { margin: 0; font-size: clamp(1.5rem, 2vw, 2.2rem); line-height: 1.1; }
        .lira-page-subtitle { margin: 8px 0 0; max-width: 760px; color: var(--lira-text-muted); font-size: 14px; line-height: 1.8; }

        /* Alerts */
        .alert {
            border-radius: 16px !important;
            border: 1px solid var(--lira-border) !important;
            background: var(--lira-surface-2) !important;
            color: var(--lira-text-soft) !important;
        }

        .alert-warning {
            background: rgba(120, 97, 255, 0.12) !important;
            border-color: rgba(120, 97, 255, 0.26) !important;
            color: #c4b6ff !important;
        }

        .alert-danger {
            background: rgba(240, 68, 56, 0.1) !important;
            border-color: rgba(240, 68, 56, 0.24) !important;
            color: #ff968f !important;
        }

        /* Utilities */
        p,
        span,
        div,
        small,
        li {
            color: inherit;
        }

        .text-muted {
            color: var(--lira-text-muted) !important;
        }

        .text-white {
            color: var(--lira-text) !important;
        }

        .bg-light,
        .bg-white,
        .bg-dark,
        .bg-secondary {
            background: var(--lira-surface) !important;
        }

        .border,
        .border-top,
        .border-end,
        .border-bottom,
        .border-start,
        hr {
            border-color: var(--lira-border) !important;
        }

        .progress {
            height: 8px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.06) !important;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--lira-gold), var(--lira-gold-strong)) !important;
        }

        .page-link {
            border-radius: 12px !important;
            background: var(--lira-surface-2) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text-soft) !important;
            margin: 0 3px;
        }

        .page-link:hover {
            background: rgba(255, 255, 255, 0.03) !important;
            color: var(--lira-text) !important;
        }

        .page-item.active .page-link {
            background: var(--lira-gold-soft) !important;
            border-color: rgba(0, 230, 167, 0.35) !important;
            color: var(--lira-gold) !important;
        }

        .page-item.disabled .page-link {
            opacity: 0.45;
        }

        .shadow,
        .shadow-sm,
        .shadow-lg,
        .lift {
            box-shadow: none !important;
        }

        /* Floating WhatsApp */
        .whatsapp-float {
            position: fixed;
            left: 24px;
            bottom: 24px;
            z-index: 1048;
            width: 58px;
            height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #25D366;
            box-shadow: 0 12px 26px rgba(37, 211, 102, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .whatsapp-float:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 18px 34px rgba(37, 211, 102, 0.34);
        }

        .whatsapp-float img {
            width: 34px;
            height: 34px;
        }

        /* Mobile */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(0, 0, 0, 0.58);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: 0.25s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-close-btn {
            position: absolute;
            top: 18px;
            left: 18px;
            z-index: 5;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--lira-border);
            background: var(--lira-surface-2);
            color: var(--lira-text-soft);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-close-btn:hover {
            color: var(--lira-gold);
            border-color: rgba(0, 230, 167, 0.26);
        }

        @media (max-width: 1199.98px) {
            .lira-page-shell {
                padding: 20px 18px;
            }
        }

        @media (min-width: 1200px) {
            body.page-dash-standard {
                --sidebar-width: 280px;
                --header-height: 64px;
                --dash-content-max-width: 1120px;
                --dash-content-gutter: 16px;
                --radius-sm: 8px;
                --radius-md: 12px;
                --radius-lg: 16px;
                font-size: 13px;
            }

            body.page-dash-standard .header {
                padding: 10px 16px !important;
                min-height: var(--header-height);
            }

            body.page-dash-standard .header .navbar {
                min-height: 42px;
            }

            body.page-dash-standard .lira-page-shell {
                padding: var(--dash-content-gutter);
            }

            body.page-dash-standard .lira-page-shell>.container-xxl,
            body.page-dash-standard .lira-page-shell .container-xxl {
                max-width: var(--dash-content-max-width);
                padding-inline: 0;
            }

            body.page-dash-standard .lira-page-header {
                gap: 10px;
                margin-bottom: 12px;
            }

            body.page-dash-standard .lira-eyebrow {
                margin-bottom: 4px;
                font-size: 9px;
            }

            body.page-dash-standard .lira-page-title {
                font-size: 1.32rem;
                line-height: 1.15;
            }

            body.page-dash-standard .lira-page-subtitle {
                margin-top: 4px;
                max-width: 560px;
                font-size: 11px;
                line-height: 1.65;
            }

            body.page-dash-standard .card,
            body.page-dash-standard .modal-content,
            body.page-dash-standard .list-group-item,
            body.page-dash-standard .dropdown-menu {
                border-radius: var(--radius-md) !important;
            }

            body.page-dash-standard .card-header,
            body.page-dash-standard .card-footer,
            body.page-dash-standard .modal-header,
            body.page-dash-standard .modal-footer {
                padding: 10px 12px !important;
            }

            body.page-dash-standard .card-body,
            body.page-dash-standard .modal-body {
                padding: 12px !important;
            }

            body.page-dash-standard .card-header h6,
            body.page-dash-standard .card-title {
                font-size: 12px;
            }

            body.page-dash-standard .row.g-3,
            body.page-dash-standard .row.g-4 {
                --bs-gutter-x: 9px;
                --bs-gutter-y: 9px;
            }

            body.page-dash-standard .gap-3,
            body.page-dash-standard .gap-4 {
                gap: 9px !important;
            }

            body.page-dash-standard .menu-list .m-link {
                gap: 11px;
                padding: 11px 15px !important;
                margin: 3px 10px;
                border-radius: 12px;
                font-size: 13px;
            }

            body.page-dash-standard .sub-menu .m-link {
                padding: 9px 14px !important;
                font-size: 12px;
            }

            body.page-dash-standard .lira-sidebar-brand {
                padding: 0 20px;
                height: 85px;
                min-height: 85px;
                flex-basis: 85px;
            }

            body.page-dash-standard .lira-sidebar-user {
                margin: 16px 14px 8px;
                padding: 14px;
                border-radius: 17px;
            }

            body.page-dash-standard .lira-sidebar-user-top {
                gap: 10px;
            }

            body.page-dash-standard .lira-sidebar-avatar {
                width: 44px;
                height: 44px;
                border-radius: 13px;
                font-size: 16px;
            }

            body.page-dash-standard .lira-sidebar-user-meta strong {
                font-size: 13px;
            }

            body.page-dash-standard .lira-sidebar-user-meta span {
                font-size: 11px;
            }

            body.page-dash-standard .lira-sidebar-status-row {
                gap: 8px;
                margin-top: 12px;
            }

            body.page-dash-standard .lira-sidebar-status-chip,
            body.page-dash-standard .lira-sidebar-kyc-chip {
                min-height: 28px;
                padding: 0 10px;
                font-size: 10px;
            }

            body.page-dash-standard .lira-sidebar-section {
                padding: 12px 13px 3px;
            }

            body.page-dash-standard .lira-sidebar-toggle {
                padding: 0 12px;
                margin-bottom: 8px;
                font-size: 10px;
            }

            body.page-dash-standard .lira-sidebar-footer {
                margin: auto 14px 0;
                padding-top: 13px;
            }

            body.page-dash-standard .table thead th {
                padding: 8px 10px !important;
                font-size: 9px;
            }

            body.page-dash-standard .table tbody td,
            body.page-dash-standard .table tbody th {
                padding: 9px 10px !important;
                font-size: 11px;
            }

            body.page-dash-standard .form-label {
                margin-bottom: 5px;
                font-size: 11px;
            }

            body.page-dash-standard .form-control,
            body.page-dash-standard .form-select,
            body.page-dash-standard .input-group-text,
            body.page-dash-standard input[type="search"],
            body.page-dash-standard input[type="text"],
            body.page-dash-standard input[type="email"],
            body.page-dash-standard input[type="password"],
            body.page-dash-standard input[type="number"],
            body.page-dash-standard input[type="date"],
            body.page-dash-standard input[type="tel"],
            body.page-dash-standard textarea,
            body.page-dash-standard select {
                min-height: 34px;
                border-radius: 9px !important;
                font-size: 12px;
            }

            body.page-dash-standard .btn {
                min-height: 32px;
                padding: 5px 11px;
                border-radius: 9px !important;
                font-size: 11px;
            }

            body.page-dash-standard .badge,
            body.page-dash-standard .page-link {
                font-size: 11px;
            }

            body.page-dash-standard small,
            body.page-dash-standard .small,
            body.page-dash-standard .text-muted {
                font-size: 11px !important;
            }
        }

        @media (max-width: 991.98px) {
            .lira-sidebar {
                transform: translateX(100%);
            }

            .lira-sidebar.open {
                transform: translateX(0);
            }

            .lira-main-content {
                margin-right: 0 !important;
                width: 100% !important;
            }

            .header {
                padding: 12px 16px !important;
            }

            .lira-page-shell {
                padding: 16px 14px 22px;
            }

            .whatsapp-float {
                width: 54px;
                height: 54px;
                left: 16px;
                bottom: 16px;
            }
        }

        @media (max-width: 575.98px) {
            :root {
                --header-height: 68px;
            }

            .header {
                min-height: var(--header-height);
            }

            .lira-page-shell {
                padding: 10px 10px 16px;
            }

            .card-header,
            .card-footer {
                padding: 12px 14px !important;
            }

            .card-body {
                padding: 14px !important;
            }

            .lira-page-header {
                margin-bottom: 10px;
            }

            .lira-page-title {
                font-size: 1.15rem;
            }

            .btn {
                min-height: 40px;
                font-size: 13px;
                padding: 8px 14px;
            }

            .form-control,
            .form-select,
            .input-group-text,
            input[type="search"],
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="date"],
            input[type="tel"],
            textarea,
            select {
                min-height: 40px;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 767.98px) {
            .lira-page-shell {
                padding: 14px 12px 20px;
            }

            .lira-page-header {
                gap: 10px;
                margin-bottom: 14px;
            }

            .lira-eyebrow {
                margin-bottom: 6px;
                font-size: 10px;
                letter-spacing: 0.08em;
            }

            .lira-page-title {
                font-size: 1.25rem;
                line-height: 1.2;
            }

            .lira-page-subtitle {
                margin-top: 6px;
                font-size: 12px;
                line-height: 1.7;
                max-width: 100%;
            }

            .card,
            .modal-content,
            .list-group-item,
            .dropdown-menu {
                border-radius: 16px !important;
            }

            .card-header,
            .card-footer,
            .modal-header,
            .modal-footer {
                padding: 14px 16px !important;
            }

            .card-body,
            .modal-body {
                padding: 14px 16px !important;
            }

            .table thead th {
                font-size: 11px;
                padding: 11px 12px !important;
            }

            .table tbody td,
            .table tbody th {
                padding: 12px !important;
                font-size: 12px;
            }

            .form-control,
            .form-select,
            .input-group-text,
            input[type="search"],
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="date"],
            input[type="tel"],
            textarea,
            select {
                min-height: 42px;
                font-size: 14px;
            }

            textarea {
                min-height: 116px;
            }

            .lira-mobile-record {
                padding: 12px !important;
                border-radius: 14px !important;
            }
        }
        @media (max-width: 767.98px) {
            body.page-dash-standard {
                font-size: 13px;
            }

            body.page-dash-standard .container-xxl,
            body.page-dash-standard .container-xl,
            body.page-dash-standard .container-lg,
            body.page-dash-standard .container-md,
            body.page-dash-standard .container-sm,
            body.page-dash-standard .container-fluid {
                padding-left: 0;
                padding-right: 0;
            }

            body.page-dash-standard .lira-page-shell {
                padding: 6px 8px;
            }

            body.page-dash-standard .lira-page-header {
                gap: 8px;
                margin-bottom: 8px;
            }

            body.page-dash-standard .lira-eyebrow {
                margin-bottom: 4px;
                font-size: 9px;
                letter-spacing: 0.06em;
            }

            body.page-dash-standard .lira-page-title {
                font-size: 1.02rem;
                line-height: 1.15;
            }

            body.page-dash-standard .lira-page-subtitle {
                margin-top: 4px;
                font-size: 11px;
                line-height: 1.5;
                max-width: 100%;
            }

            body.page-dash-standard .card,
            body.page-dash-standard .modal-content,
            body.page-dash-standard .list-group-item,
            body.page-dash-standard .dropdown-menu {
                border-radius: 12px !important;
                min-height: auto !important;
            }

            body.page-dash-standard .card-header,
            body.page-dash-standard .card-footer,
            body.page-dash-standard .modal-header,
            body.page-dash-standard .modal-footer,
            body.page-dash-standard .card-body,
            body.page-dash-standard .modal-body {
                padding: 10px 12px !important;
            }

            body.page-dash-standard .card-header h6,
            body.page-dash-standard .card-title {
                font-size: 13px;
            }

            body.page-dash-standard .row.g-2,
            body.page-dash-standard .row.g-3,
            body.page-dash-standard .row.g-4 {
                --bs-gutter-x: 8px;
                --bs-gutter-y: 8px;
            }

            body.page-dash-standard .gap-2,
            body.page-dash-standard .gap-3,
            body.page-dash-standard .gap-4 {
                gap: 8px !important;
            }

            body.page-dash-standard .table thead th {
                font-size: 10px;
                padding: 8px 10px !important;
            }

            body.page-dash-standard .table tbody td,
            body.page-dash-standard .table tbody th {
                padding: 10px !important;
                font-size: 11px;
            }

            body.page-dash-standard .form-control,
            body.page-dash-standard .form-select,
            body.page-dash-standard .input-group-text,
            body.page-dash-standard input[type="search"],
            body.page-dash-standard input[type="text"],
            body.page-dash-standard input[type="email"],
            body.page-dash-standard input[type="password"],
            body.page-dash-standard input[type="number"],
            body.page-dash-standard input[type="date"],
            body.page-dash-standard input[type="tel"],
            body.page-dash-standard textarea,
            body.page-dash-standard select,
            body.page-dash-standard .btn {
                min-height: 36px;
                font-size: 12px;
            }

            body.page-dash-standard textarea {
                min-height: 92px;
            }

            body.page-dash-standard .btn {
                padding: 6px 12px;
            }

            body.page-dash-standard small,
            body.page-dash-standard .small,
            body.page-dash-standard .text-muted {
                font-size: 11px !important;
            }

            body.page-dash-standard .lira-mobile-record {
                padding: 10px !important;
                border-radius: 12px !important;
                min-height: auto !important;
            }
        }

        @media (max-width: 575.98px) {
            body.page-dash-standard .lira-page-shell {
                padding: 6px 8px;
            }

            body.page-dash-standard .lira-page-title {
                font-size: 0.96rem;
            }

            body.page-dash-standard .lira-page-subtitle {
                font-size: 10px;
            }
        }
    </style>

    @stack('custom_styles')
    @if (isBrandTheme('nironex'))
        <link rel="stylesheet" href="{{ asset('assets/css/nironex-theme.css') }}">
    @endif
</head>

<body class="rtl_mode font-cairo {{ request()->routeIs('site.trading') || !empty($normalizeTradingUrl ?? false) ? 'page-trading' : 'page-dash-standard' }} {{ isBrandTheme('nironex') ? 'theme-nironex' : '' }}">
    <div class="lira-dash-wrapper">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        @include(backendView('site.includes.sidebar'))

        <div class="lira-main-content">
            @include(backendView('site.includes.header'))

            <main class="lira-page-shell grow">
                <div class="container-xxl">
                    @include('includes.messages')
                    @yield('content')
                </div>
            </main>

            <!-- MOBILE NATIVE APP BOTTOM NAVIGATION -->
            <div class="lira-bottom-nav">
                <a href="{{ route('site.dashboard') }}" class="lira-bottom-nav-item {{ request()->routeIs('site.dashboard') ? 'active' : '' }}">
                    <x-niro-icon name="dashboard" />
                    <span>الرئيسية</span>
                </a>
                <a href="{{ route('site.wallet') }}" class="lira-bottom-nav-item {{ request()->routeIs('site.wallet') ? 'active' : '' }}">
                    <x-niro-icon name="wallet" />
                    <span>المحفظة</span>
                </a>
                <a href="{{ route('site.trading') }}" class="lira-bottom-nav-item {{ request()->routeIs('site.trading') ? 'active' : '' }}">
                    <x-niro-icon name="markets" />
                    <span>تداول</span>
                </a>
                <a href="{{ route('site.robot.index') }}" class="lira-bottom-nav-item {{ request()->routeIs('site.robot.index') ? 'active' : '' }}">
                    <x-niro-icon name="robot" />
                    <span>الروبوت</span>
                </a>
                <a href="{{ route('site.messages.index') }}" class="lira-bottom-nav-item is-tablet-only {{ request()->routeIs('site.messages.*') ? 'active' : '' }}">
                    <x-niro-icon name="support" />
                    <span>الدعم</span>
                </a>
                <a href="{{ route('site.performance') }}" class="lira-bottom-nav-item is-tablet-only {{ request()->routeIs('site.performance') ? 'active' : '' }}">
                    <x-niro-icon name="portfolio" />
                    <span>الأداء</span>
                </a>
                <a href="{{ route('site.plans') }}" class="lira-bottom-nav-item {{ request()->routeIs('site.plans') ? 'active' : '' }}">
                    <x-niro-icon name="academy" />
                    <span>الخطط</span>
                </a>
            </div> @stack('modals')
        </div>
    </div>



    <script src="{!! backendAssets('dist/assets/bundles/libscripts.bundle.js') !!}"></script>
    @stack('scripts')
    <script src="{!! backendAssets('dist/assets/js/template.js') !!}"></script>
    @stack('custom_scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.lira-sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtns = document.querySelectorAll('[data-bs-target="#sidebarCollapse"], .menu-toggle, .navbar-toggler');

            if (!sidebar) return;

            function openSidebar() {
                sidebar.classList.add('open');
                overlay?.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay?.classList.remove('active');
                document.body.style.overflow = '';
            }

            toggleBtns.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    if (window.innerWidth > 991) return;
                    e.preventDefault();
                    e.stopPropagation();

                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            });

            const closeBtn = document.getElementById('sidebarCloseBtn');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }

            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth > 991) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>

</html>

