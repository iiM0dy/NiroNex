<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
        $brandLogo = asset('assets/images/home/LOGO-NIRO-3.png');
        $pageTitle = trim($__env->yieldContent('title'));
        $metaTitle = trim(appName() . ($pageTitle ? ' - ' . $pageTitle : ''));
        $metaDescription = trim($__env->yieldContent('meta_description', 'NiroNex admin control center for users, KYC verification, deposits, withdrawals, robot requests, transactions, and support operations.'));
        $canonicalUrl = url()->current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
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
    <link rel="icon" href="{{ $brandLogo }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ $brandLogo }}">
    <meta name="theme-color" content="#0d1117">

    @stack('styles')

    <link rel="stylesheet" href="{!! backendAssets('ebazar.style.min.css') !!}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=League+Spartan:wght@400;600;700;800&display=swap" rel="stylesheet">
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
            --lira-accent: #00e6a7;
            --lira-accent-strong: #1a2bff;
            --lira-accent-soft: rgba(0, 230, 167, 0.12);
            --lira-success: #17b26a;
            --lira-danger: #f04438;
            --lira-warning: #7861ff;
            --lira-info: #0ba5ec;
            --sidebar-width: 292px;
            --header-height: 76px;
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 24px;
            --shadow-soft: 0 18px 48px rgba(0, 0, 0, 0.28);
            --shadow-gold: 0 0 0 1px rgba(0, 230, 167, 0.14), 0 16px 36px rgba(26, 43, 255, 0.08);
        }

        * {
            box-shadow: none !important;
        }

        html,
        body {
            min-height: 100%;
            overflow-x: hidden;
            max-width: 100%;
        }

        /* ─── PREMIUM CUSTOM SCROLLBAR (FORCED) ─── */
        * {
            scrollbar-width: thin !important;
            scrollbar-color: #00e6a7 #0B0F15 !important;
        }

        html {
            overflow-y: scroll !important;
            scrollbar-gutter: stable;
        }

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

        body {
            margin: 0;
            direction: rtl;
            background: linear-gradient(180deg, #080a0e 0%, #090c11 100%);
            color: var(--lira-text) !important;
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
            text-decoration: none !important;
        }

        .lira-main a:not(.btn):not(.dropdown-item):hover {
            color: var(--lira-accent) !important;
        }

        p,
        span,
        div,
        li,
        small,
        label {
            color: inherit;
        }

        .text-muted {
            color: var(--lira-text-muted) !important;
        }

        .ycolor {
            color: var(--lira-accent) !important;
        }

        .ybg {
            background-color: var(--lira-accent) !important;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2, 8, 18, 0.72);
            backdrop-filter: blur(6px);
            opacity: 0;
            visibility: hidden;
            transition: 0.25s ease;
            z-index: 70;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .lira-admin-shell {
            min-height: 100vh;
        }

        .lira-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            z-index: 80;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), transparent 35%),
                linear-gradient(180deg, var(--lira-sidebar) 0%, var(--lira-sidebar-2) 100%);
            border-left: 1px solid var(--lira-border);
            padding: 0;
            overflow-y: auto;
        }

        .lira-main {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
        }

        .lira-admin-stage {
            width: min(100%, 1480px);
            margin-inline: auto;
            padding: 28px !important;
        }

        /* Header Synchronization */
        .lira-admin-topbar {
            padding: 0 28px !important; /* Unified with content stage */
            background: rgba(7, 9, 13, 0.88) !important;
        }

        /* Sidebar */
        .sidebar-logo {
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.015);
        }

        .sidebar-nav {
            padding: 14px 14px 0 !important;
            gap: 6px;
        }

        .sidebar-nav .nav-link {
            min-height: 48px;
            border-radius: 16px;
            color: var(--lira-text-soft) !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0 14px !important;
            border: 1px solid transparent;
            background: transparent;
            transition: 0.2s ease;
            font-weight: 700;
        }

        .sidebar-nav .nav-link i {
            width: 18px;
            text-align: center;
            color: var(--lira-text-muted);
            transition: 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.03);
            border-color: var(--lira-border);
            color: var(--lira-text) !important;
        }

        .sidebar-nav .nav-link.active {
            background: rgba(0, 230, 167, 0.10);
            border-color: var(--lira-border-strong);
            color: var(--lira-accent) !important;
        }

        .sidebar-nav .nav-link.active i {
            color: var(--lira-accent) !important;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 18px 14px 16px !important;
            background: linear-gradient(180deg, transparent, rgba(255,255,255,0.02));
        }

        .sidebar-footer .nav-link {
            min-height: 44px;
            border-radius: 14px;
            padding: 0 12px !important;
            border: 1px solid transparent;
            font-weight: 700;
        }

        .sidebar-footer .nav-link:hover {
            background: rgba(255,255,255,0.03);
            border-color: var(--lira-border);
        }

        /* Surfaces */
        .card,
        .modal-content {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                var(--lira-surface);
            border: 1px solid var(--lira-border) !important;
            border-radius: var(--radius-lg) !important;
            overflow: hidden;
        }

        .card-header,
        .card-footer,
        .modal-header,
        .modal-footer {
            background: transparent !important;
            border-color: var(--lira-border) !important;
        }

        .bg-light,
        .bg-white,
        .bg-dark {
            background: var(--lira-surface) !important;
        }

        .border,
        .border-top,
        .border-bottom,
        .border-start,
        .border-end {
            border-color: var(--lira-border) !important;
        }

        hr {
            border-color: var(--lira-border) !important;
            opacity: 0.35;
        }

        /* Forms */
        .form-control,
        .form-select,
        .input-group-text {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text) !important;
            border-radius: 14px !important;
        }

        .form-control::placeholder,
        textarea::placeholder {
            color: var(--lira-text-muted) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(0, 230, 167, 0.35) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 230, 167, 0.08) !important;
            background: rgba(255,255,255,0.04) !important;
            color: var(--lira-text) !important;
        }

        /* Buttons */
        .btn {
            border-radius: 14px !important;
            font-weight: 800 !important;
        }

        .btn-primary,
        .bg-primary {
            background: var(--lira-accent) !important;
            border-color: var(--lira-accent) !important;
            color: #0a1220 !important;
        }

        .btn-primary:hover {
            opacity: 0.92;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.05) !important;
            border-color: var(--lira-border) !important;
            color: var(--lira-text) !important;
        }

        .btn-success {
            background: var(--lira-success) !important;
            border-color: var(--lira-success) !important;
        }

        .btn-danger {
            background: var(--lira-danger) !important;
            border-color: var(--lira-danger) !important;
        }

        .btn-warning {
            background: var(--lira-warning) !important;
            border-color: var(--lira-warning) !important;
            color: #0a1220 !important;
        }

        .btn-info {
            background: var(--lira-info) !important;
            border-color: var(--lira-info) !important;
            color: #071120 !important;
        }

        .btn-outline-primary {
            border-color: rgba(0, 230, 167, 0.3) !important;
            color: var(--lira-accent) !important;
            background: transparent !important;
        }

        .btn-outline-primary:hover {
            background: rgba(0, 230, 167, 0.08) !important;
        }

        /* Badges */
        .badge {
            border-radius: 999px !important;
            font-weight: 800 !important;
        }

        .bg-success {
            background: var(--lira-success) !important;
        }

        .bg-danger {
            background: var(--lira-danger) !important;
        }

        .bg-warning {
            background: var(--lira-warning) !important;
            color: #0a1220 !important;
        }

        .bg-info {
            background: var(--lira-info) !important;
            color: #06111e !important;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table,
        .table {
            width: 100%;
            color: var(--lira-text) !important;
            border-color: var(--lira-border) !important;
            margin-bottom: 0;
        }

        .table thead th {
            background: rgba(3, 9, 20, 0.42) !important;
            color: var(--lira-accent) !important;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.02em;
            border-bottom: 1px solid var(--lira-border) !important;
            white-space: nowrap;
            padding: 16px 18px !important;
        }

        .table tbody td {
            background: transparent !important;
            color: var(--lira-text-soft) !important;
            border-bottom: 1px solid var(--lira-border) !important;
            padding: 16px 18px !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody tr:hover td {
            background: rgba(255,255,255,0.015) !important;
        }

        /* Pagination */
        .page-link {
            background: rgba(255,255,255,0.03) !important;
            border-color: var(--lira-border) !important;
            color: var(--lira-text-soft) !important;
        }

        .page-item.active .page-link {
            background: var(--lira-accent) !important;
            color: #071120 !important;
            border-color: var(--lira-accent) !important;
        }

        /* Dropdown */
        .dropdown-menu {
            background: var(--lira-surface-2) !important;
            border: 1px solid var(--lira-border) !important;
            border-radius: 16px !important;
        }

        .dropdown-item {
            color: var(--lira-text-soft) !important;
            font-weight: 600;
        }

        .dropdown-item:hover {
            background: rgba(255,255,255,0.04) !important;
            color: var(--lira-text) !important;
        }

        /* Alerts */
        .alert {
            border-radius: 18px !important;
            border: 1px solid var(--lira-border) !important;
        }

        /* New plan B primitives */
        .lira-page-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .lira-page-hero-copy {
            flex: 1 1 560px;
        }

        .lira-kicker {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(0, 230, 167, 0.10);
            border: 1px solid rgba(0, 230, 167, 0.18);
            color: var(--lira-accent);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .lira-page-hero-title {
            margin: 0 0 10px;
            font-size: clamp(1.8rem, 2.5vw, 2.5rem);
            line-height: 1.05;
        }

        .lira-page-hero-subtitle {
            margin: 0;
            max-width: 760px;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .lira-page-hero-side {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-page-hero-badge {
            display: inline-flex;
            align-items: center;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-soft);
            font-size: 13px;
            font-weight: 800;
        }

        .lira-page-hero-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-metric-tile {
            min-height: 152px;
            padding: 20px;
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01)),
                var(--lira-surface-2);
            border: 1px solid var(--lira-border);
            position: relative;
            overflow: hidden;
        }

        .lira-metric-tile::before {
            display: none;
        }

        .lira-metric-tile.is-accent { border-top: 2px solid var(--lira-accent); }
        .lira-metric-tile.is-success { border-top: 2px solid var(--lira-success); }
        .lira-metric-tile.is-warning { border-top: 2px solid var(--lira-warning); }
        .lira-metric-tile.is-danger { border-top: 2px solid var(--lira-danger); }
        .lira-metric-tile.is-info { border-top: 2px solid var(--lira-info); }

        .lira-metric-tile-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .lira-metric-tile-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--lira-text-muted);
        }

        .lira-metric-tile-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.04);
            flex: 0 0 auto;
        }

        .lira-metric-tile.is-accent .lira-metric-tile-icon {
            color: var(--lira-accent);
            background: rgba(0, 230, 167, 0.10);
        }

        .lira-metric-tile.is-success .lira-metric-tile-icon {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-metric-tile.is-warning .lira-metric-tile-icon {
            color: var(--lira-warning);
            background: rgba(120, 97, 255, 0.10);
        }

        .lira-metric-tile.is-danger .lira-metric-tile-icon {
            color: var(--lira-danger);
            background: rgba(240, 68, 56, 0.10);
        }

        .lira-metric-tile.is-info .lira-metric-tile-icon {
            color: var(--lira-info);
            background: rgba(54, 191, 250, 0.10);
        }

        .lira-metric-tile-value {
            font-family: 'League Spartan', sans-serif !important;
            font-size: clamp(1.65rem, 2.2vw, 2.2rem);
            line-height: 1.05;
            font-weight: 800;
            color: var(--lira-text);
        }

        .lira-metric-tile-foot {
            margin-top: 10px;
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.75;
        }

        .lira-data-panel {
            border-radius: 28px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)),
                var(--lira-surface);
            border: 1px solid var(--lira-border);
            overflow: hidden;
        }

        .lira-data-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--lira-border);
        }

        .lira-data-panel-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 800;
        }

        .lira-data-panel-subtitle {
            margin: 6px 0 0;
            color: var(--lira-text-muted);
            font-size: 13px;
        }

        .lira-data-panel-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-data-panel-body {
            padding: 20px 22px;
        }

        .lira-data-panel-body.is-flush {
            padding: 0;
        }

        /* DataTables */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--lira-text-muted) !important;
            padding: 14px 16px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid var(--lira-border) !important;
            color: var(--lira-text-soft) !important;
            border-radius: 12px !important;
            margin: 0 3px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--lira-accent) !important;
            border-color: var(--lira-accent) !important;
            color: #071120 !important;
        }

        /* Mobile */
        @media (max-width: 991.98px) {
            .lira-sidebar {
                transform: translateX(100%);
                transition: transform 0.25s ease;
            }

            .lira-sidebar.open {
                transform: translateX(0);
            }

            .lira-main {
                margin-right: 0;
                width: 100%;
            }

            .lira-admin-stage {
                padding: 18px 14px 26px !important;
            }

            .lira-page-hero {
                align-items: flex-start;
            }

            .lira-page-hero-copy,
            .lira-page-hero-side,
            .lira-page-hero-actions {
                width: 100%;
            }

            .lira-data-panel-head,
            .card-header {
                align-items: flex-start !important;
                gap: 12px !important;
            }

            .card-header form,
            .card-header .input-group,
            .card-header .search-group {
                width: 100% !important;
                min-width: 0 !important;
            }

            .modal-dialog {
                margin: 12px !important;
            }

            .modal-footer {
                flex-direction: column;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .lira-admin-stage {
                padding: 14px 10px 22px !important;
            }

            .lira-admin-topbar-inner {
                min-height: 66px;
            }

            .lira-page-hero,
            .lira-page-header {
                margin-bottom: 16px !important;
            }

            .lira-page-hero-title,
            .lira-page-title {
                font-size: 1.35rem !important;
                line-height: 1.35 !important;
            }

            .lira-page-hero-subtitle,
            .lira-page-subtitle {
                font-size: 12px !important;
                line-height: 1.8 !important;
            }

            .card,
            .lira-data-panel,
            .lira-metric-tile {
                border-radius: 18px !important;
            }

            .card-body,
            .lira-data-panel-body {
                padding: 14px !important;
            }

            .lira-metric-tile {
                min-height: 128px;
                padding: 16px;
            }

            .lira-stat-card,
            .lira-admin-user-stat,
            .lira-admin-transaction-stat,
            .lira-admin-request-stat,
            .lira-admin-balance-card {
                min-height: 128px !important;
                border-radius: 18px !important;
            }

            .lira-admin-user-stat,
            .lira-admin-transaction-stat,
            .lira-admin-request-stat,
            .lira-admin-balance-card {
                padding: 14px !important;
            }

            .lira-stat-top,
            .lira-metric-tile-top,
            .lira-admin-user-stat-top,
            .lira-admin-transaction-stat-top,
            .lira-admin-request-stat-top {
                gap: 8px !important;
                margin-bottom: 12px !important;
            }

            .lira-stat-icon,
            .lira-metric-tile-icon,
            .lira-admin-user-stat-icon,
            .lira-admin-transaction-stat-icon,
            .lira-admin-request-stat-icon,
            .lira-admin-balance-icon {
                width: 38px !important;
                height: 38px !important;
                border-radius: 13px !important;
                font-size: 15px !important;
            }

            .lira-stat-label,
            .lira-metric-tile-label,
            .lira-admin-user-stat-label,
            .lira-admin-transaction-stat-label,
            .lira-admin-request-stat-label,
            .lira-admin-balance-label {
                font-size: 11px !important;
                line-height: 1.55 !important;
            }

            .lira-stat-value,
            .lira-metric-tile-value,
            .lira-admin-user-stat-value,
            .lira-admin-transaction-stat-value,
            .lira-admin-request-stat-value,
            .lira-admin-balance-value {
                font-size: 1.35rem !important;
                overflow-wrap: anywhere;
            }

            .lira-stat-meta,
            .lira-metric-tile-foot,
            .lira-admin-user-stat-foot,
            .lira-admin-transaction-stat-foot,
            .lira-admin-request-stat-foot {
                font-size: 10px !important;
                line-height: 1.65 !important;
            }

            .btn {
                min-height: 40px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .lira-page-hero-side {
                width: 100%;
                justify-content: flex-start;
            }
        }
        /* ─── Global Accordion Responsive Tables ─── */
        @media (max-width: 991.98px) {
            .table-responsive.lira-mobile-stack table,
            .table-responsive.lira-mobile-stack tbody {
                display: block;
                width: 100%;
                border: none;
            }
            .table-responsive {
                border: none !important;
                background: transparent !important;
                overflow-x: hidden !important; /* Strictly block horizontal scroll */
            }
            .table-responsive.lira-mobile-stack thead {
                display: none !important;
            }
            .table-responsive.lira-mobile-stack tr {
                display: flex;
                flex-wrap: wrap; /* Allows 100% width elements to drop to next line naturally */
                align-items: stretch; /* keep the visible header cells equal-height */
                column-gap: 10px;
                row-gap: 10px;
                background: var(--lira-surface-2);
                border: 1px solid var(--lira-border) !important;
                border-radius: 14px;
                margin-bottom: 14px;
                padding: 16px 14px;
                position: relative;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            }
            .table-responsive.lira-mobile-stack tr:hover {
                border-color: rgba(0, 230, 167, 0.4) !important;
            }
            
            /* Hide columns 3+ by default */
            .table-responsive.lira-mobile-stack td {
                display: none;
                width: calc(50% - 5px);
                max-width: calc(50% - 5px);
                flex: 0 0 calc(50% - 5px);
                flex-direction: column;
                align-items: stretch; /* So internal divs take full width */
                margin-top: 10px;
                padding: 12px;
                border: 1px solid rgba(255,255,255,0.045);
                border-radius: 12px;
                background: rgba(255,255,255,0.018);
                font-size: 13px;
                color: var(--lira-text);
                text-align: right;
                white-space: normal !important;
                word-break: break-word;
                overflow: hidden;
            }
            
            /* Always show columns 1 and 2 as the header */
            .table-responsive.lira-mobile-stack td:nth-child(1),
            .table-responsive.lira-mobile-stack td:nth-child(2) {
                display: flex;
                flex-direction: row;
                border-top: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                margin-top: 0;
                padding: 0;
                align-items: center;
                white-space: normal;
                word-break: break-word;
                min-height: 54px;
                order: 0;
            }
            .table-responsive.lira-mobile-stack td:nth-child(1) {
                flex: 1 1 calc(100% - 130px);
                width: calc(100% - 130px);
                max-width: calc(100% - 130px);
                min-width: 0;
                font-weight: 700;
                font-size: 14.5px;
                color: #fff;
                padding-right: 12px;
            }
            .table-responsive.lira-mobile-stack td:nth-child(2) {
                flex: 0 0 120px;
                width: 120px;
                max-width: 120px;
                margin-right: 0; 
                padding-left: 36px; /* leave space for chevron */
                font-weight: 700;
                color: var(--lira-text-muted);
                justify-content: center;
            }

            .table-responsive.lira-mobile-stack td:nth-child(n+3) {
                order: 1;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td:nth-child(1),
            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td:nth-child(2) {
                display: none;
                width: calc(50% - 5px);
                max-width: calc(50% - 5px);
                flex: 0 0 calc(50% - 5px);
                flex-direction: column;
                align-items: stretch;
                margin-top: 10px;
                padding: 12px;
                border: 1px solid rgba(255,255,255,0.045);
                border-radius: 12px;
                background: rgba(255,255,255,0.018);
                min-height: auto;
                order: 1;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary {
                display: flex;
                flex-direction: row;
                border: 0;
                border-radius: 0;
                background: transparent;
                margin-top: 0;
                padding: 0;
                align-items: center;
                min-height: 54px;
                order: 0;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary-main {
                flex: 1 1 calc(100% - 130px);
                width: calc(100% - 130px);
                max-width: calc(100% - 130px);
                min-width: 0;
                padding-right: 12px;
                font-weight: 700;
                font-size: 14.5px;
                color: #fff;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary-side {
                flex: 0 0 120px;
                width: 120px;
                max-width: 120px;
                padding-left: 36px;
                color: var(--lira-text-muted);
                justify-content: center;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary::before {
                display: none !important;
            }

            .table-responsive.lira-mobile-stack td:nth-child(1) > *,
            .table-responsive.lira-mobile-stack td:nth-child(1) .d-flex,
            .table-responsive.lira-mobile-stack td:nth-child(1) .d-flex > div:last-child,
            .table-responsive.lira-mobile-stack td.lira-mobile-primary-main > *,
            .table-responsive.lira-mobile-stack td.lira-mobile-primary-main .d-flex,
            .table-responsive.lira-mobile-stack td.lira-mobile-primary-main .d-flex > div:last-child {
                min-width: 0;
            }
            
            /* Prevent labels on header columns */
            .table-responsive.lira-mobile-stack td:nth-child(1)::before,
            .table-responsive.lira-mobile-stack td:nth-child(2)::before {
                display: none !important;
            }
            
            .table-responsive.lira-mobile-stack td .btn {
                width: 100%;
                margin-top: 0;
                text-align: center;
                justify-content: center;
            }

            /* Add label text */
            .table-responsive.lira-mobile-stack td::before {
                content: attr(data-label);
                font-size: 11px;
                color: var(--lira-text-muted);
                margin-bottom: 4px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Expand State */
            .table-responsive.lira-mobile-stack tr.is-expanded td {
                display: flex;
            }

            .table-responsive.lira-mobile-stack tr.is-expanded td:nth-child(n+3) {
                min-height: 86px;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td {
                display: none !important;
                width: auto !important;
                max-width: none !important;
                flex: none !important;
                flex-direction: column !important;
                align-items: stretch !important;
                margin-top: 0 !important;
                padding: 12px !important;
                border: 1px solid rgba(255,255,255,0.045) !important;
                border-radius: 12px !important;
                background: rgba(255,255,255,0.018) !important;
                min-height: 86px !important;
                order: 2 !important;
                box-sizing: border-box !important;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities tr {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) 120px;
                column-gap: 10px;
                row-gap: 10px;
                align-items: stretch;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities tr.is-expanded {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                min-height: 54px !important;
                margin-top: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: transparent !important;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary-main {
                grid-column: 1;
                flex: none !important;
                width: auto !important;
                max-width: none !important;
                min-width: 0 !important;
                padding-right: 12px !important;
                order: 0 !important;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary-side {
                grid-column: 2;
                flex: none !important;
                width: auto !important;
                max-width: none !important;
                padding-left: 36px !important;
                justify-content: center !important;
                order: 1 !important;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities tr.is-expanded td:not(.lira-mobile-primary) {
                display: flex !important;
                grid-column: auto;
                width: auto !important;
                max-width: none !important;
                flex: none !important;
            }

            .table-responsive.lira-mobile-stack table.lira-has-mobile-priorities td.lira-mobile-primary::before {
                display: none !important;
            }

            .table-responsive.lira-mobile-stack tr.is-expanded {
                background: linear-gradient(180deg, rgba(255,255,255,0.03), transparent), var(--lira-surface-2);
                border-color: rgba(0, 230, 167, 0.3) !important;
            }

            /* The Chevron */
            .table-responsive.lira-mobile-stack tr::after {
                content: "\f078"; /* FontAwesome Chevron Down */
                font-family: "Font Awesome 5 Free", "FontAwesome", "Font Awesome 6 Free";
                font-weight: 900;
                position: absolute;
                top: 18px;
                left: 16px; /* Very left side in RTL */
                font-size: 13px;
                color: var(--lira-text-soft);
                transition: transform 0.3s ease, color 0.3s ease;
            }
            .table-responsive.lira-mobile-stack tr.is-expanded::after {
                transform: rotate(180deg);
                color: var(--lira-accent);
            }
        }
    </style>

    @stack('custom_styles')
    @if (isBrandTheme('nironex'))
        <link rel="stylesheet" href="{{ asset('assets/css/nironex-theme.css') }}">
    @endif
</head>

<body class="{{ app()->getLocale() == 'ar' ? 'rtl_mode' : '' }} {{ isBrandTheme('nironex') ? 'theme-nironex' : '' }}">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="lira-admin-shell">
        @include(backendView('admin.includes.sidebar'))

        <div class="lira-main">
            @include(backendView('admin.includes.header'))

            <main class="lira-admin-stage flex-grow-1">
                @include('includes.messages')
                @yield('content')
            </main>

            @include(backendView('admin.includes.footer'))
            @stack('modals')
        </div>
    </div>

    <script src="{!! backendAssets('dist/assets/bundles/libscripts.bundle.js') !!}"></script>
    @stack('scripts')
    <script src="{!! backendAssets('dist/assets/js/template.js') !!}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.lira-sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleButtons = document.querySelectorAll('.menu-toggle, [data-bs-target="#sidebarCollapse"], .navbar-toggler');

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('open');
                overlay?.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('open');
                overlay?.classList.remove('active');
                document.body.style.overflow = '';
            }

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    if (window.innerWidth > 991) return;
                    e.preventDefault();
                    sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
                });
            });

            overlay?.addEventListener('click', closeSidebar);

            const closeBtn = document.getElementById('sidebarCloseBtn');
            closeBtn?.addEventListener('click', closeSidebar);

            /* ─── Premium Mobile Accordion Tables Init ─── */
            document.querySelectorAll('.table-responsive table').forEach(table => {
                const thead = table.querySelector('thead');
                if (!thead) return;

                const headers = Array.from(thead.querySelectorAll('th')).map(th => th.innerText.trim());
                if (headers.length === 0) return;

                const wrapper = table.closest('.table-responsive');
                wrapper.classList.add('lira-mobile-stack');

                table.querySelectorAll('tbody tr').forEach(tr => {
                    tr.addEventListener('click', function(e) {
                        // Avoid toggling if clicking a button, link, or input
                        if (e.target.closest('button') || e.target.closest('a') || e.target.closest('input')) return;
                        this.classList.toggle('is-expanded');
                    });
                    
                    Array.from(tr.querySelectorAll('td')).forEach((td, i) => {
                        if (headers[i] && headers[i] !== '') {
                            td.setAttribute('data-label', headers[i]);
                        }
                    });
                });
            });
        });
    </script>

    @stack('custom_scripts')
</body>

</html>

