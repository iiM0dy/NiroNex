@extends('layouts.site-dash')

@section('title', 'منصة التداول')

@php
    $tradingSymbols = [
        'BTCUSD' => [
            'tab' => 'BTC/USD',
            'label' => 'BTC/USD OTC',
            'name' => 'Bitcoin / US Dollar',
            'rest' => 'BTCUSDT',
            'stream' => 'btcusdt',
            'basePrice' => 68450.00,
            'precision' => 2,
            'synthetic' => [
                'historyVolatility' => 0.00090,
                'runtimeVolatility' => 0.00280,
                'spreadFactor' => 0.00045,
                'meanPull' => 0.15,
                'driftMultiplier' => 2.50,
            ],
        ],
        'ETHUSD' => [
            'tab' => 'ETH/USD',
            'label' => 'ETH/USD OTC',
            'name' => 'Ethereum / US Dollar',
            'rest' => 'ETHUSDT',
            'stream' => 'ethusdt',
            'basePrice' => 3450.00,
            'precision' => 2,
            'synthetic' => [
                'historyVolatility' => 0.00105,
                'runtimeVolatility' => 0.00310,
                'spreadFactor' => 0.00055,
                'meanPull' => 0.16,
                'driftMultiplier' => 2.55,
            ],
        ],
        'SOLUSD' => [
            'tab' => 'SOL/USD',
            'label' => 'SOL/USD OTC',
            'name' => 'Solana / US Dollar',
            'rest' => 'SOLUSDT',
            'stream' => 'solusdt',
            'basePrice' => 155.00,
            'precision' => 2,
            'synthetic' => [
                'historyVolatility' => 0.00140,
                'runtimeVolatility' => 0.00410,
                'spreadFactor' => 0.00085,
                'meanPull' => 0.17,
                'driftMultiplier' => 2.65,
            ],
        ],
        'BNBUSD' => [
            'tab' => 'BNB/USD',
            'label' => 'BNB/USD OTC',
            'name' => 'BNB / US Dollar',
            'rest' => 'BNBUSDT',
            'stream' => 'bnbusdt',
            'basePrice' => 640.00,
            'precision' => 2,
            'synthetic' => [
                'historyVolatility' => 0.00088,
                'runtimeVolatility' => 0.00255,
                'spreadFactor' => 0.00042,
                'meanPull' => 0.14,
                'driftMultiplier' => 2.40,
            ],
        ],
        'XRPUSD' => [
            'tab' => 'XRP/USD',
            'label' => 'XRP/USD OTC',
            'name' => 'XRP / US Dollar',
            'rest' => 'XRPUSDT',
            'stream' => 'xrpusdt',
            'basePrice' => 0.6200,
            'precision' => 4,
            'synthetic' => [
                'historyVolatility' => 0.00155,
                'runtimeVolatility' => 0.00440,
                'spreadFactor' => 0.00125,
                'meanPull' => 0.18,
                'driftMultiplier' => 2.75,
            ],
        ],
        'ADAUSD' => [
            'tab' => 'ADA/USD',
            'label' => 'ADA/USD OTC',
            'name' => 'Cardano / US Dollar',
            'rest' => 'ADAUSDT',
            'stream' => 'adausdt',
            'basePrice' => 0.41000,
            'precision' => 5,
            'synthetic' => [
                'historyVolatility' => 0.00145,
                'runtimeVolatility' => 0.00420,
                'spreadFactor' => 0.00115,
                'meanPull' => 0.18,
                'driftMultiplier' => 2.70,
            ],
        ],
        'DOGEUSD' => [
            'tab' => 'DOGE/USD',
            'label' => 'DOGE/USD OTC',
            'name' => 'Dogecoin / US Dollar',
            'rest' => 'DOGEUSDT',
            'stream' => 'dogeusdt',
            'basePrice' => 0.18000,
            'precision' => 5,
            'synthetic' => [
                'historyVolatility' => 0.00195,
                'runtimeVolatility' => 0.00520,
                'spreadFactor' => 0.00155,
                'meanPull' => 0.19,
                'driftMultiplier' => 2.85,
            ],
        ],
        'LTCUSD' => [
            'tab' => 'LTC/USD',
            'label' => 'LTC/USD OTC',
            'name' => 'Litecoin / US Dollar',
            'rest' => 'LTCUSDT',
            'stream' => 'ltcusdt',
            'basePrice' => 82.00,
            'precision' => 2,
            'synthetic' => [
                'historyVolatility' => 0.00110,
                'runtimeVolatility' => 0.00320,
                'spreadFactor' => 0.00072,
                'meanPull' => 0.16,
                'driftMultiplier' => 2.55,
            ],
        ],
        'AVAXUSD' => [
            'tab' => 'AVAX/USD',
            'label' => 'AVAX/USD OTC',
            'name' => 'Avalanche / US Dollar',
            'rest' => 'AVAXUSDT',
            'stream' => 'avaxusdt',
            'basePrice' => 28.300,
            'precision' => 3,
            'synthetic' => [
                'historyVolatility' => 0.00160,
                'runtimeVolatility' => 0.00460,
                'spreadFactor' => 0.00120,
                'meanPull' => 0.18,
                'driftMultiplier' => 2.80,
            ],
        ],
        'LINKUSD' => [
            'tab' => 'LINK/USD',
            'label' => 'LINK/USD OTC',
            'name' => 'Chainlink / US Dollar',
            'rest' => 'LINKUSDT',
            'stream' => 'linkusdt',
            'basePrice' => 14.800,
            'precision' => 3,
            'synthetic' => [
                'historyVolatility' => 0.00135,
                'runtimeVolatility' => 0.00395,
                'spreadFactor' => 0.00105,
                'meanPull' => 0.17,
                'driftMultiplier' => 2.70,
            ],
        ],
        'TRXUSD' => [
            'tab' => 'TRX/USD',
            'label' => 'TRX/USD OTC',
            'name' => 'TRON / US Dollar',
            'rest' => 'TRXUSDT',
            'stream' => 'trxusdt',
            'basePrice' => 0.13000,
            'precision' => 5,
            'synthetic' => [
                'historyVolatility' => 0.00120,
                'runtimeVolatility' => 0.00340,
                'spreadFactor' => 0.00095,
                'meanPull' => 0.16,
                'driftMultiplier' => 2.60,
            ],
        ],
    ];
    $defaultTradingSymbolKey = array_key_first($tradingSymbols);
    $defaultTradingSymbol = $tradingSymbols[$defaultTradingSymbolKey];
    $tradingMobileNav = [
        [
            'label' => 'التداول',
            'desc' => 'الوضع المباشر الحالي',
            'icon' => 'fa-solid fa-bolt',
            'href' => route('site.trading'),
            'active' => request()->routeIs('site.trading'),
        ],
        [
            'label' => 'لوحة التحكم',
            'desc' => 'ملخص الحساب والنشاط',
            'icon' => 'fa-solid fa-house',
            'href' => route('site.dashboard'),
            'active' => request()->routeIs('site.dashboard'),
        ],
        [
            'label' => 'المحفظة',
            'desc' => 'الرصيد والتحويلات',
            'icon' => 'fa-solid fa-wallet',
            'href' => route('site.wallet'),
            'active' => request()->routeIs('site.wallet'),
        ],
        [
            'label' => 'الإيداع',
            'desc' => 'شحن حسابك بسرعة',
            'icon' => 'fa-solid fa-money-bill-wave',
            'href' => route('site.deposit'),
            'active' => request()->routeIs('site.deposit'),
        ],
        [
            'label' => 'الروبوت',
            'desc' => 'إدارة الاستراتيجيات',
            'icon' => 'fa-solid fa-robot',
            'href' => route('site.robot.index'),
            'active' => request()->routeIs('site.robot.*'),
        ],
        [
            'label' => 'الأداء',
            'desc' => 'متابعة النتائج',
            'icon' => 'fa-solid fa-chart-line',
            'href' => route('site.performance'),
            'active' => request()->routeIs('site.performance'),
        ],
        [
            'label' => 'الدعم',
            'desc' => 'الرسائل والمساعدة',
            'icon' => 'fa-solid fa-headset',
            'href' => route('site.messages.index'),
            'active' => request()->routeIs('site.messages.*'),
        ],
        [
            'label' => 'حسابي',
            'desc' => 'الإعدادات والملف الشخصي',
            'icon' => 'fa-solid fa-user-gear',
            'href' => route('profile'),
            'active' => request()->routeIs('profile'),
        ],
    ];
    $tradingBottomNav = [
        [
            'label' => 'الرئيسية',
            'icon' => 'dashboard',
            'href' => route('site.dashboard'),
            'active' => request()->routeIs('site.dashboard'),
            'tablet_only' => false,
        ],
        [
            'label' => 'المحفظة',
            'icon' => 'wallet',
            'href' => route('site.wallet'),
            'active' => request()->routeIs('site.wallet'),
            'tablet_only' => false,
        ],
        [
            'label' => 'تداول',
            'icon' => 'markets',
            'href' => route('site.trading'),
            'active' => request()->routeIs('site.trading'),
            'tablet_only' => false,
        ],
        [
            'label' => 'الروبوت',
            'icon' => 'robot',
            'href' => route('site.robot.index'),
            'active' => request()->routeIs('site.robot.*'),
            'tablet_only' => false,
        ],
        [
            'label' => 'الدعم',
            'icon' => 'support',
            'href' => route('site.messages.index'),
            'active' => request()->routeIs('site.messages.*'),
            'tablet_only' => true,
        ],
        [
            'label' => 'الأداء',
            'icon' => 'portfolio',
            'href' => route('site.performance'),
            'active' => request()->routeIs('site.performance'),
            'tablet_only' => true,
        ],
        [
            'label' => 'الخطط',
            'icon' => 'academy',
            'href' => route('site.plans'),
            'active' => request()->routeIs('site.plans'),
            'tablet_only' => false,
        ],
    ];
    $isDemoAccount = (bool) ($user->is_demo ?? false);
    $initialTradingMode = $isDemoAccount ? 'demo' : 'real';
    $realTradingBalance = (float) ($user->trading_balance ?? 0);
    $demoTradingBalance = (float) ($user->demo_trading_balance ?? 50000);
    $activeTradingBalance = $initialTradingMode === 'demo' ? $demoTradingBalance : $realTradingBalance;
@endphp

@push('custom_styles')
    <style>
        .lira-trading-page {
            max-width: var(--dash-content-max-width, 1120px);
            margin: 0 auto;
            width: 100%;
        }

        .lira-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
        }

        .lira-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--lira-accent);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .lira-page-title {
            margin: 0;
            font-size: clamp(1.7rem, 2.2vw, 2.6rem);
            line-height: 1.08;
        }

        .lira-page-subtitle {
            margin: 10px 0 0;
            max-width: 760px;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .lira-fs-wrapper {
            position: relative;
        }

        .lira-terminal-shell {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background: #0f1422;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
        }

        .lira-terminal-header {
            padding: 18px 18px 10px;
        }

        .lira-terminal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .lira-terminal-nav {
            margin-bottom: 14px;
            padding: 10px 12px;
            border-radius: 20px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.018)),
                rgba(11, 16, 27, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.04),
                0 12px 26px rgba(0, 0, 0, 0.18);
            overflow: hidden;
        }

        .lira-terminal-nav__track {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow-x: auto;
            overflow-y: hidden;
            overscroll-behavior-x: contain;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .lira-terminal-nav__track::-webkit-scrollbar {
            display: none;
        }

        .lira-terminal-nav__item {
            min-height: 44px;
            padding: 0 16px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            flex: 0 0 auto;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            transition: 0.2s ease;
        }

        .lira-terminal-nav__item i {
            font-size: 13px;
            color: rgba(0, 230, 167, 0.85);
        }

        .lira-terminal-nav__item:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(0, 230, 167, 0.12);
            transform: translateY(-1px);
        }

        .lira-terminal-nav__item.is-active {
            color: #fff;
            background: rgba(0, 230, 167, 0.16);
            border-color: rgba(0, 230, 167, 0.22);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.14);
        }

        .lira-terminal-nav__item.is-active i {
            color: var(--lira-accent);
        }

        .lira-terminal-left,
        .lira-terminal-right,
        .lira-terminal-symbol-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            min-width: 0;
        }

        .lira-market-selector {
            min-width: 0;
            max-width: 100%;
            padding: 10px 14px;
            border-radius: 18px;
            background: 
                linear-gradient(180deg, rgba(255, 255, 255, 0.04) 0%, rgba(255, 255, 255, 0.01) 100%),
                #131a2b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        @media (min-width: 1200px) {
            .lira-market-selector {
                padding: 12px 20px;
                border-radius: 20px;
            }
        }

        .lira-market-selector__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .lira-market-selector__eyebrow {
            color: var(--lira-accent);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .lira-market-selector__count {
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .lira-symbol-tabs,
        .lira-timeframe-group {
            display: inline-flex;
            gap: 8px;
            padding: 6px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-symbol-tabs {
            display: flex;
            gap: 6px;
            padding: 4px;
            overflow-x: auto;
            overflow-y: hidden;
            flex-wrap: nowrap;
            scrollbar-width: none;
            -ms-overflow-style: none;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        @media (min-width: 992px) {
            .lira-symbol-tabs {
                gap: 8px;
                padding: 5px;
                border-radius: 16px;
                max-width: 100%; /* Use full width */
                flex-wrap: wrap; /* Show all options */
                overflow-x: visible;
            }
        }

        .lira-symbol-tabs::-webkit-scrollbar {
            display: none;
        }

        .lira-symbol-tab,
        .lira-timeframe-chip {
            min-width: 64px;
            height: 40px;
            padding: 0 14px;
            border: 0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            color: #f8f9ff;
            font-size: 12px;
            font-weight: 800;
            transition: 0.22s ease;
        }

        .lira-symbol-tab {
            min-width: 94px;
            flex: 0 0 auto;
            white-space: nowrap;
            position: relative;
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid transparent;
        }

        .lira-symbol-tab:hover,
        .lira-timeframe-chip:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .lira-symbol-tab.active,
        .lira-timeframe-chip.active {
            color: #fff;
            background: rgba(0, 230, 167, 0.14);
            border: 1px solid rgba(0, 230, 167, 0.24);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.08);
            font-weight: 900;
        }

        .lira-terminal-market-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lira-terminal-market {
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .lira-terminal-price {
            color: #fff;
            font-size: clamp(1.8rem, 2.4vw, 2.8rem);
            font-weight: 900;
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .lira-btn-expand {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.78);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.22s ease;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .lira-btn-expand:hover {
            background: rgba(0, 230, 167, 0.16);
            color: var(--lira-accent);
        }

        .lira-terminal-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-terminal-stat {
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-terminal-stat span {
            display: block;
            margin-bottom: 6px;
            color: var(--lira-text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .lira-terminal-stat strong {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
        }

        .lira-terminal-stat strong.is-up {
            color: #63ddab;
        }

        .lira-terminal-stat strong.is-down {
            color: #ff9a8f;
        }

        #chartAreaWrapper {
            position: relative;
            padding: 0 18px 18px;
        }

        .lira-lwc-stage {
            position: relative;
            height: 480px;
            /* Reduced from 620px for a more compact desktop look */
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            background: #090c15;
            border: 1px solid rgba(255, 255, 255, 0.04);
            box-shadow: inset 0 4px 24px rgba(0, 0, 0, 0.2);
        }

        .lira-lwc-stage::before {
            display: none;
        }

        .lira-lwc-chart {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .lira-draw-layer {
            position: absolute;
            inset: 0;
            z-index: 3;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .lira-trade-tooltip {
            position: absolute;
            z-index: 8;
            min-width: 190px;
            display: none;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(10, 14, 24, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            color: #fff;
            pointer-events: none;
        }

        .lira-trade-tooltip__time {
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 11px;
        }

        .lira-trade-tooltip__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 12px;
        }

        .lira-trade-tooltip__item span {
            display: block;
            margin-bottom: 2px;
            color: rgba(255, 255, 255, 0.55);
            font-size: 10px;
            text-transform: uppercase;
        }

        .lira-trade-tooltip__item strong {
            font-size: 13px;
        }

        .lira-draw-toolbar-wrap {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 9;
            display: block;
        }

        .lira-draw-toggle {
            min-width: 286px;
            min-height: 48px;
            padding: 8px 10px;
            border: 0;
            border-radius: 14px;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            background: #151b2b;
            color: #eef2ff;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
        }

        .lira-draw-toggle__icon {
            width: 32px;
            height: 32px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgba(93, 148, 255, 0.26), rgba(93, 148, 255, 0.14));
            color: #8db8ff;
            font-size: 14px;
            box-shadow: inset 0 0 0 1px rgba(93, 148, 255, 0.2);
        }

        .lira-draw-toggle__meta {
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
            text-align: start;
        }

        .lira-draw-toggle__meta strong {
            display: block;
            color: #f4f7ff;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-draw-toggle__meta span {
            display: block;
            color: rgba(214, 224, 243, 0.62);
            font-size: 11px;
            font-weight: 700;
        }

        .lira-draw-toggle__count {
            min-width: 34px;
            height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            color: #d8e1f2;
            font-size: 11px;
            font-weight: 800;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .lira-draw-toggle:hover,
        .lira-draw-toggle.is-open,
        .lira-draw-toggle.is-drawing {
            border-color: rgba(93, 148, 255, 0.4);
            background: #181f33;
        }

        .lira-draw-menu {
            display: none;
            position: absolute;
            top: 56px;
            left: 0;
            width: 320px;
            padding: 12px;
            border-radius: 16px;
            background: #151b2b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
        }

        .lira-draw-menu.is-open {
            display: block;
        }

        .lira-draw-menu-close {
            display: none; /* hidden on desktop */
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .lira-draw-menu-close:active {
            background: rgba(255, 255, 255, 0.08);
        }

        .lira-draw-menu__section-label {
            display: block;
            padding: 4px 10px 8px;
            color: rgba(166, 180, 210, 0.74);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .lira-draw-item {
            width: 100%;
            min-height: 56px;
            padding: 10px 12px;
            border: 0;
            border-radius: 16px;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            background: transparent;
            color: #d7deee;
            font-size: 13px;
            font-weight: 700;
            text-align: start;
        }

        .lira-draw-item__icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.04);
            color: #c5d2ee;
            font-size: 14px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
            transition: 0.2s ease;
        }

        .lira-draw-item__body {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lira-draw-item__body strong {
            display: block;
            color: inherit;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-draw-item__body small {
            display: block;
            color: rgba(184, 196, 220, 0.58);
            font-size: 11px;
            font-weight: 700;
        }

        .lira-draw-item__key {
            min-width: 44px;
            padding: 0 10px;
            height: 26px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.04);
            color: rgba(214, 224, 243, 0.62);
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .lira-draw-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .lira-draw-item:hover .lira-draw-item__icon,
        .lira-draw-item.is-active .lira-draw-item__icon {
            background: rgba(93, 148, 255, 0.18);
            color: #9ac0ff;
            box-shadow: inset 0 0 0 1px rgba(93, 148, 255, 0.2);
        }

        .lira-draw-item.is-active {
            background: rgba(93, 148, 255, 0.14);
            color: #eaf2ff;
            box-shadow: inset 0 0 0 1px rgba(93, 148, 255, 0.22);
        }

        .lira-draw-item.is-danger:hover {
            background: rgba(240, 68, 56, 0.12);
            color: #ffb1aa;
        }

        .lira-draw-item.is-danger:hover .lira-draw-item__icon {
            background: rgba(240, 68, 56, 0.16);
            color: #ffb1aa;
            box-shadow: inset 0 0 0 1px rgba(240, 68, 56, 0.2);
        }

        .lira-draw-item:disabled {
            opacity: 0.42;
            cursor: not-allowed;
        }

        .lira-draw-sep {
            height: 1px;
            margin: 8px 0;
            background: rgba(255, 255, 255, 0.08);
        }

        /* ─── Quick Trade Dock ─────────────────────────────────── */
        .lira-trade-dock {
            position: relative;
            margin: 18px auto 0;
            /* Centered horizontally */
            width: 100%;
            overflow: hidden;
            padding: 12px 18px;
            /* Slimmed down height */
            border-radius: 20px;
            background: #0d1626;
            border: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .lira-trade-dock::before,
        .lira-trade-dock::after {
            display: none;
        }

        /* Head row hidden per previous cleanup */
        .lira-trade-dock__head {
            margin-bottom: 16px;
        }

        .lira-trade-dock__lead {
            min-width: 0;
            flex: 1 1 auto;
        }

        .lira-trade-dock__eyebrow {
            display: block;
            margin-bottom: 4px;
            color: rgba(130, 155, 195, 0.7);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .lira-trade-dock__title {
            display: block;
            color: #fff;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.2;
        }

        .lira-trade-dock__subtitle {
            display: none;
        }

        .lira-trade-dock__meta {
            display: none;
        }

        .lira-trade-dock__hint {
            display: none;
        }

        .lira-trade-mode-pill {
            display: none;
        }

        .lira-trade-mode-pill.is-simulated {
            display: none;
        }

        .lira-account-mode-switch {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .lira-account-mode-switch button {
            min-height: 32px;
            padding: 0 13px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: rgba(230, 236, 248, 0.7);
            font-size: 12px;
            font-weight: 900;
            transition: background 0.16s ease, color 0.16s ease;
        }

        .lira-account-mode-switch button.is-active {
            background: linear-gradient(135deg, rgba(0, 230, 167, 0.95), rgba(20, 239, 179, 0.84));
            color: #071018;
        }

        .lira-account-mode-switch button:disabled {
            cursor: not-allowed;
            opacity: 0.45;
        }

        /* ─── Desktop Trade Form: clean vertical stack ─── */
        .lira-trade-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            /* Reduced gap from 12px */
        }

        /* ─── Trade Fields ─────────────────────────────────────── */
        .lira-trade-field {
            padding: 0;
            border-radius: 0;
            background: transparent;
            border: 0;
            box-shadow: none;
        }

        .lira-trade-field label {
            display: block;
            margin-bottom: 7px;
            color: rgba(130, 155, 195, 0.7);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ─── Two-column top deck (Amount | Time) ─────────────── */
        .lira-desk-top-deck {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .lira-desk-input-card {
            display: flex;
            flex-direction: column;
            padding: 8px 12px;
            /* Slimmer input cards */
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            gap: 4px;
        }

        .lira-desk-input-card__label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(130, 155, 195, 0.7);
        }

        .lira-desk-input-card__value {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lira-desk-input-card__icon {
            color: rgba(180, 200, 230, 0.55);
            font-size: 14px;
            flex: 0 0 auto;
        }

        .lira-desk-input-card__value input {
            flex: 1 1 auto;
            background: transparent;
            border: 0;
            outline: 0;
            color: #fff;
            font-size: 16px;
            /* Slightly smaller text for slim look */
            font-weight: 900;
            min-width: 0;
            -moz-appearance: textfield;
        }

        .lira-desk-input-card__value input::-webkit-outer-spin-button,
        .lira-desk-input-card__value input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        /* ─── Desktop Trade Panel Refinement ─── */
        .lira-trade-dock {
            background: #0f1423 !important;
            border-left: 1px solid rgba(255, 255, 255, 0.06);
            padding: 12px !important;
            /* Slimmer dock */
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100% !important;
        }

        .lira-desk-top-deck {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-desk-input-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 8px 12px;
            /* Slimmer cards */
            transition: border-color 0.2s;
        }

        .lira-desk-input-card:focus-within {
            border-color: rgba(80, 140, 255, 0.4);
        }

        .lira-desk-input-card__label {
            display: block;
            font-size: 10px;
            font-weight: 800;
            color: rgba(140, 165, 205, 0.6);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .lira-desk-input-card__value {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lira-desk-input-card__icon {
            font-size: 14px;
            color: #9ab2dc;
        }

        .lira-desk-input-card__value input {
            background: transparent;
            border: 0;
            color: #fff;
            font-size: 20px;
            font-weight: 900;
            width: 100%;
            outline: none;
            padding: 0;
        }

        .lira-desk-input-card__value input::-webkit-inner-spin-button,
        .lira-desk-input-card__value input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .lira-desk-input-card__unit {
            font-size: 12px;
            font-weight: 800;
            color: #9ab2dc;
        }

        .lira-desk-stepper-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
        }

        .lira-stepper-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.06);
            border: 0;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .lira-stepper-btn:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .lira-duration-spinner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
        }

        .lira-duration-unit {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .lira-duration-unit input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            font-weight: 900;
            text-align: center;
            width: 100%;
            padding: 4px 0;
            outline: none;
        }

        .lira-duration-sep {
            color: #9ab2dc;
            font-size: 16px;
            font-weight: 900;
        }

        .lira-desk-payout-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(16, 185, 129, 0.05);
            border-radius: 12px;
            padding: 8px 14px;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .lira-desk-payout-strip div {
            display: flex;
            flex-direction: column;
        }

        .lira-desk-payout-strip span {
            font-size: 9px;
            font-weight: 800;
            color: rgba(140, 165, 205, 0.6);
            text-transform: uppercase;
        }

        .lira-desk-payout-strip strong {
            font-size: 14px;
            color: #fff;
            font-weight: 900;
        }

        .lira-payout-highlight {
            color: #10b981 !important;
            font-size: 18px !important;
        }

        .lira-trade-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .lira-order-btn {
            height: 48px;
            /* Reduced further for slim look */
            border-radius: 12px;
            border: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 900;
            color: #fff;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .lira-order-btn i {
            font-size: 18px;
        }

        .lira-order-btn.is-buy {
            background: #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .lira-order-btn.is-sell {
            background: #f43f5e;
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3);
        }

        .lira-order-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .lira-order-btn:active {
            transform: translateY(0);
            filter: brightness(0.9);
        }

        .lira-amount-chip {
            min-height: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.75);
            font-size: 12px;
            font-weight: 800;
            flex: 1;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0 4px;
        }

        .lira-amount-chip:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateY(-1px);
        }

        .lira-amount-chip.active {
            background: rgba(0, 230, 167, 0.15);
            color: #00e6a7;
            border-color: #00e6a7;
            box-shadow: 0 0 10px rgba(0, 230, 167, 0.2);
            transform: translateY(0);
        }

        /* Duration Presets (Global/Desktop) */
        .lira-desk-duration-presets {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 6px !important;
            margin-top: 14px !important;
            padding: 10px !important;
            background: rgba(0, 0, 0, 0.2) !important;
            border-radius: 8px !important;
            border: 1px solid rgba(255,255,255,0.04) !important;
        }

        .lira-duration-chip {
            min-height: 36px !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 6px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            color: rgba(255, 255, 255, 0.75) !important;
            font-size: 12px !important;
            font-weight: 800 !important;
            font-family: inherit !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            white-space: nowrap !important;
            padding: 0 4px !important;
        }

        .lira-duration-chip:hover {
            background: rgba(255,255,255,0.08) !important;
            border-color: rgba(255,255,255,0.15) !important;
            color: #fff !important;
            transform: translateY(-1px) !important;
        }

        .lira-duration-chip.active {
            background: rgba(0, 230, 167, 0.15) !important;
            color: #00e6a7 !important;
            border-color: #00e6a7 !important;
            box-shadow: 0 0 10px rgba(0, 230, 167, 0.2) !important;
            transform: translateY(0) !important;
        }



        .lira-trade-sentiment {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #9fb0cc;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-trade-sentiment__track {
            position: relative;
            flex: 1 1 auto;
            height: 8px;
            border-radius: 999px;
            overflow: hidden;
            background: #f43f5e;
        }

        .lira-trade-sentiment__fill {
            display: block;
            height: 100%;
            width: 50%;
            border-radius: inherit;
            background: #10b981;
        }

        .lira-trade-sentiment__track::after {
            content: '';
            position: absolute;
            top: -2px;
            bottom: -2px;
            left: 50%;
            width: 2px;
            transform: translateX(-1px);
            background: rgba(255, 255, 255, 0.55);
        }

        .lira-mobile-action-bar {
            display: none;
        }

        .lira-mobile-action-gap {
            min-height: 62px;
            padding: 0 16px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            background: linear-gradient(180deg, rgba(48, 157, 255, 0.92), rgba(17, 102, 255, 0.92));
            color: #fff;
            box-shadow:
                0 16px 30px rgba(20, 103, 255, 0.24),
                inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .lira-mobile-action-gap span {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .lira-mobile-action-gap strong {
            font-size: 14px;
            font-weight: 900;
        }

        .lira-mobile-appbar,
        .lira-mobile-chart-top,
        .lira-mobile-chart-meta,
        .lira-mobile-chart-bolt,
        .lira-mobile-chart-side,
        .lira-mobile-trade-panel {
            display: none;
        }

        .lira-mobile-appbar {
            align-items: center;
            gap: 10px;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .lira-mobile-appbar__actions {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .lira-mobile-appbar__avatar {
            width: 42px;
            height: 42px;
            padding: 2px;
            border-radius: 50%;
            background: linear-gradient(180deg, #43d45f, #1e8d39);
            box-shadow: 0 0 0 2px rgba(67, 212, 95, 0.16);
            flex: 0 0 auto;
        }

        .lira-mobile-appbar__avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
            background: #d4d9df;
        }

        .lira-mobile-appbar__icon {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 27, 47, 0.94);
            color: #63a7ff;
            font-size: 18px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
        }

        .lira-mobile-appbar__icon.is-wallet {
            background: #0f7a43;
            color: #d9ffe8;
        }

        .lira-mobile-balance {
            flex: 1 1 auto;
            min-width: 0;
            height: 42px;
            padding: 0 14px;
            border: 0;
            border-radius: 10px;
            display: grid;
            grid-template-columns: auto auto 1fr;
            align-items: center;
            gap: 8px;
            background: rgba(16, 27, 47, 0.94);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
            color: #fff;
            cursor: default;
        }

        .lira-mobile-balance span,
        .lira-mobile-balance small {
            font-size: 11px;
            color: #9db0cf;
        }

        .lira-mobile-balance strong {
            min-width: 0;
            font-size: 22px;
            line-height: 1;
            text-align: center;
            color: #fff;
            font-weight: 800;
        }

        .lira-mobile-chart-top {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            z-index: 6;
            display: none;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            pointer-events: none;
        }

        .lira-mobile-chart-top .lira-account-mode-switch,
        .lira-mobile-chart-controls,
        .lira-mobile-expiry {
            pointer-events: auto;
        }

        .lira-mobile-chart-controls {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .lira-mobile-pair-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .lira-mobile-pair,
        .lira-mobile-overflow {
            height: 32px;
            border: 0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            color: #eef3ff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .lira-mobile-pair {
            min-height: 36px;
            padding: 0 11px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0;
            transition: background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .lira-mobile-pair i {
            color: var(--lira-accent);
            font-size: 10px;
            transition: transform 0.18s ease;
        }

        .lira-mobile-pair.is-open {
            background: rgba(0, 230, 167, 0.12);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.28);
        }

        .lira-mobile-pair.is-open i {
            transform: rotate(180deg);
        }

        .lira-mobile-pair-meta {
            padding-inline-start: 4px;
        }

        .lira-mobile-pair-meta strong,
        .lira-mobile-pair-meta span {
            display: block;
        }

        .lira-mobile-pair-meta strong {
            color: #bfc8db;
            font-size: 13px;
            font-weight: 700;
        }

        .lira-mobile-pair-meta span {
            color: #95a0ba;
            font-size: 11px;
        }

        .lira-mobile-chart-frame {
            display: none; /* shown on mobile via media query */
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 11px;
            border: 0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            color: #eef3ff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
            font-size: 12px;
            font-weight: 900;
            transition: background 0.18s ease, color 0.18s ease;
        }

        .lira-mobile-chart-frame i:first-child {
            color: #78a3ff;
            font-size: 11px;
        }

        .lira-mobile-chart-frame.is-open {
            background: rgba(93, 148, 255, 0.12);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(93, 148, 255, 0.28);
        }

        .lira-mobile-overflow {
            width: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .lira-mobile-expiry {
            text-align: end;
        }

        .lira-mobile-expiry--button {
            min-width: 122px;
            padding: 8px 10px;
            border-radius: 12px;
            background: rgba(24, 30, 49, 0.5);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
            color: inherit;
            transition: background 0.18s ease, box-shadow 0.18s ease;
        }

        .lira-mobile-expiry--button.is-open {
            background: rgba(28, 40, 68, 0.84);
            box-shadow: inset 0 0 0 1px rgba(87, 155, 255, 0.22);
        }

        .lira-mobile-expiry span {
            display: block;
            margin-bottom: 4px;
            color: #8ea0c4;
            font-size: 11px;
        }

        .lira-mobile-expiry strong {
            color: #cfd7eb;
            font-size: 14px;
            font-weight: 700;
        }

        .lira-mobile-expiry small {
            display: block;
            margin-top: 5px;
            color: #7fb4ff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lira-mobile-symbol-menu {
            position: absolute;
            top: 52px;
            left: 12px;
            width: min(340px, calc(100vw - 24px));
            max-height: min(56svh, 420px);
            overflow: auto;
            padding: 8px;
            border-radius: 16px;
            display: none;
            flex-direction: column;
            gap: 6px;
            background: rgba(15, 20, 34, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 36px rgba(0, 0, 0, 0.32);
            backdrop-filter: blur(14px);
            z-index: 13;
        }

        .lira-mobile-symbol-menu.is-open {
            display: flex;
        }

        .lira-mobile-symbol-menu__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 4px;
            padding: 8px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-mobile-symbol-menu__head strong {
            color: #f6f8ff;
            font-size: 12px;
            font-weight: 900;
        }

        .lira-mobile-symbol-menu__head span {
            color: var(--lira-accent);
            font-size: 10px;
            font-weight: 700;
        }

        .lira-mobile-symbol-option {
            width: 100%;
            padding: 11px 12px;
            border: 0;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 3px;
            background: rgba(255, 255, 255, 0.035);
            color: #ffffff;
            text-align: start;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.055);
            transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
        }

        .lira-mobile-symbol-option:hover {
            background: rgba(255, 255, 255, 0.055);
        }

        .lira-mobile-symbol-option strong {
            font-size: 13px;
            font-weight: 800;
        }

        .lira-mobile-symbol-option span {
            color: #9aa9c7;
            font-size: 11px;
        }

        .lira-mobile-symbol-option.is-active {
            background: rgba(0, 230, 167, 0.12);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.24);
        }

        .lira-mobile-timeframe-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: flex-end;
            justify-content: center;
            padding: 16px 12px 120px;
            background: rgba(5, 9, 16, 0.5);
            z-index: 100;
        }

        .lira-mobile-timeframe-modal.is-open {
            display: flex;
        }

        .lira-mobile-timeframe-sheet {
            width: min(100%, 360px);
            max-height: min(72vh, 430px);
            overflow: auto;
            padding: 16px;
            border-radius: 22px;
            background: rgba(11, 15, 21, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 26px 50px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(16px);
        }

        .lira-mobile-timeframe-sheet__nav {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .chart-settings-modal__nav-link {
            color: #96a4c1;
            font-size: 13px;
            font-weight: 700;
        }

        .chart-settings-modal__nav-link.active {
            color: #f4f7ff;
        }

        .lira-mobile-timeframe-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .lira-interval-option {
            min-height: 42px;
            border: 0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            color: var(--lira-text-soft);
            font-size: 13px;
            font-weight: 800;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.03);
            transition: all 0.2s;
        }

        .lira-interval-option.is-active {
            background: rgba(0, 230, 167, 0.15);
            color: var(--lira-accent);
            box-shadow: inset 0 0 0 1px rgba(0, 230, 167, 0.3);
        }

        .lira-mobile-chart-meta {
            position: absolute;
            top: 54px;
            left: 12px;
            z-index: 5;
            display: none;
            flex-direction: column;
            gap: 3px;
            padding: 8px 10px;
            border-radius: 8px;
            background: rgba(44, 51, 76, 0.4);
            backdrop-filter: blur(4px);
        }

        .lira-mobile-chart-meta strong {
            color: #bfc8db;
            font-size: 15px;
            font-weight: 700;
        }

        .lira-mobile-chart-meta span {
            color: #95a0ba;
            font-size: 11px;
        }

        .lira-mobile-chart-bolt,
        .lira-mobile-chart-side {
            position: absolute;
            z-index: 5;
            border: 0;
            border-radius: 12px;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 12px 24px rgba(2, 9, 20, 0.2),
                inset 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .lira-mobile-chart-bolt {
            top: 96px;
            left: 12px;
            width: 30px;
            height: 30px;
            background: rgba(36, 48, 74, 0.92);
            color: #78a3ff;
            font-size: 13px;
        }

        .lira-mobile-chart-bolt.is-active {
            background: rgba(56, 129, 255, 0.95);
            color: #fff;
        }

        .lira-mobile-chart-side {
            top: 46%;
            right: 10px;
            width: 36px;
            height: 36px;
            background: linear-gradient(180deg, rgba(94, 84, 43, 0.94), rgba(62, 57, 38, 0.94));
            color: #f0dd63;
            font-size: 16px;
        }

        .lira-mobile-chart-side.is-active {
            background: linear-gradient(180deg, rgba(110, 146, 255, 0.96), rgba(62, 111, 255, 0.96));
            color: #fff;
        }

        .lira-mobile-trade-panel {
            margin-top: 6px;
            padding: 6px 10px 4px;
            border-radius: 16px;
            background: #1a2236;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .lira-mobile-editor-stack {
            display: grid;
            gap: 0;
            margin-bottom: 0;
        }

        .lira-mobile-editor-panel {
            display: none;
            padding: 12px;
            border-radius: 12px;
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .lira-mobile-editor-panel.is-open {
            display: block;
            margin-bottom: 6px;
            animation: lira-mobile-panel-in 0.18s ease;
        }

        @keyframes lira-mobile-panel-in {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .lira-mobile-duration-columns {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr;
            gap: 8px;
            align-items: center;
        }

        .lira-mobile-duration-unit {
            min-width: 0;
            padding: 8px 6px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.03);
        }

        .lira-mobile-duration-unit strong {
            color: #fff;
            font-size: 28px;
            font-weight: 900;
            line-height: 1;
        }

        .lira-mobile-duration-sep {
            color: #9ab2dc;
            font-size: 28px;
            font-weight: 800;
        }

        .lira-mobile-stepper {
            width: 34px;
            height: 26px;
            border: 0;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            color: #dfe7f8;
            font-size: 11px;
        }

        .lira-mobile-stepper.is-down {
            background: rgba(255, 255, 255, 0.035);
        }

        .lira-mobile-duration-presets {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 8px;
            margin-top: 12px;
        }

        .lira-mobile-duration-preset {
            min-height: 34px;
            border: 0;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            color: #b8c6df;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-mobile-duration-preset.is-active {
            background: rgba(56, 129, 255, 0.18);
            color: #f4f8ff;
            box-shadow: inset 0 0 0 1px rgba(56, 129, 255, 0.22);
        }

        .lira-mobile-amount-display {
            min-height: 72px;
            padding: 12px 14px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: rgba(14, 20, 33, 0.42);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        }

        .lira-mobile-amount-display strong {
            color: #fff;
            font-size: 18px;
            font-weight: 900;
        }

        .lira-mobile-amount-display__steps {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .lira-mobile-keypad {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            margin-top: 12px;
        }

        .lira-mobile-keypad__key {
            min-height: 44px;
            border: 0;
            border-radius: 12px;
            background: rgba(18, 24, 40, 0.66);
            color: #dbe5f8;
            font-size: 18px;
            font-weight: 800;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        }

        .lira-mobile-keypad__key.is-backspace {
            font-size: 14px;
        }

        .lira-mobile-trade-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .lira-mobile-trade-field span {
            display: block;
            margin-bottom: 8px;
            color: #8ea0c4;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lira-mobile-trade-field__box {
            width: 100%;
            height: 52px;
            padding: 0 14px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: rgba(14, 19, 31, 0.58);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
            border: 0;
            text-align: start;
        }

        .lira-mobile-trade-field__box strong {
            color: #fff;
            font-size: 15px;
            font-weight: 900;
        }

        .lira-mobile-trade-field__box i {
            color: #cdd4e7;
            font-size: 14px;
        }

        .lira-mobile-trade-field__box.is-open {
            box-shadow:
                inset 0 0 0 1px rgba(56, 129, 255, 0.42),
                0 0 0 2px rgba(56, 129, 255, 0.08);
            background: rgba(20, 28, 49, 0.92);
        }

        .lira-mobile-payout-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            color: #92a2bf;
            font-size: 11px;
        }

        .lira-mobile-payout-row strong {
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-mobile-payout-row>.is-positive,
        .lira-mobile-payout-row strong.is-positive {
            color: #82eea7;
            font-size: 18px;
            font-weight: 900;
        }

        .lira-trade-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .lira-trade-mini-stat {
            padding: 14px 16px;
            border-radius: 18px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.035), rgba(255, 255, 255, 0.02));
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .lira-trade-mini-stat span {
            display: block;
            margin-bottom: 5px;
            color: rgba(162, 178, 204, 0.78);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .lira-trade-mini-stat strong {
            display: block;
            color: #fff;
            font-size: 16px;
            font-weight: 900;
        }

        .lira-trade-mini-stat strong.is-positive {
            color: #63ddab;
        }

        .lira-trade-mini-stat strong.is-negative {
            color: #ff9a8f;
        }

        .lira-trade-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 16px;
            max-height: 280px;
            overflow: auto;
            padding-right: 4px;
        }

        .lira-trade-row {
            display: block;
            padding: 16px 18px;
            border-radius: 20px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.018));
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow:
                0 14px 28px rgba(5, 12, 25, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.02);
        }

        .lira-trade-row.is-buy {
            border-color: rgba(49, 196, 141, 0.12);
        }

        .lira-trade-row.is-sell {
            border-color: rgba(249, 112, 102, 0.12);
        }

        .lira-trade-row__top {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 12px;
            align-items: center;
        }

        .lira-trade-row__symbol strong,
        .lira-trade-row__meta strong {
            display: block;
            color: #fff;
            font-size: 14px;
            font-weight: 900;
        }

        .lira-trade-row__symbol span,
        .lira-trade-row__meta span {
            display: block;
            margin-top: 4px;
            color: var(--lira-text-muted);
            font-size: 11px;
        }

        .lira-trade-row__meta {
            text-align: end;
        }

        .lira-trade-side {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .lira-trade-side.is-buy {
            background: rgba(23, 178, 106, 0.14);
            color: #63ddab;
        }

        .lira-trade-side.is-sell {
            background: rgba(240, 68, 56, 0.14);
            color: #ff9a8f;
        }

        .lira-trade-row__progress {
            height: 6px;
            margin-top: 12px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.06);
        }

        .lira-trade-row__progress span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, rgba(0, 230, 167, 0.35), rgba(0, 230, 167, 0.95));
        }

        .lira-trade-row.is-buy .lira-trade-row__progress span {
            background: linear-gradient(90deg, rgba(23, 178, 106, 0.35), rgba(99, 221, 171, 0.95));
        }

        .lira-trade-row.is-sell .lira-trade-row__progress span {
            background: linear-gradient(90deg, rgba(240, 68, 56, 0.35), rgba(255, 154, 143, 0.95));
        }

        .lira-empty-trades {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 86px;
            border-radius: 18px;
            background: rgba(16, 21, 36, 0.5);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            color: rgba(170, 184, 208, 0.76);
            text-align: center;
            font-size: 13px;
            line-height: 1.5;
        }

        .lira-fs-wrapper:fullscreen,
        .lira-fs-wrapper:-webkit-full-screen,
        .lira-fs-wrapper.is-mobile-expanded {
            background: #0b1020;
            padding: 0;
            overflow: hidden;
        }

        .lira-fs-wrapper:fullscreen .lira-terminal-shell,
        .lira-fs-wrapper:-webkit-full-screen .lira-terminal-shell,
        .lira-fs-wrapper.is-mobile-expanded .lira-terminal-shell {
            min-height: 100dvh;
            height: 100dvh;
            border-radius: 0;
            border: 0;
            display: flex;
            flex-direction: column;
        }

        .lira-fs-wrapper:fullscreen .lira-terminal-header,
        .lira-fs-wrapper:-webkit-full-screen .lira-terminal-header,
        .lira-fs-wrapper.is-mobile-expanded .lira-terminal-header {
            position: sticky;
            top: 0;
            z-index: 20;
            padding: 12px 12px 10px;
            background: linear-gradient(180deg, rgba(10, 14, 24, 0.98), rgba(10, 14, 24, 0.84));
            backdrop-filter: blur(12px);
        }

        .lira-fs-wrapper:fullscreen #chartAreaWrapper,
        .lira-fs-wrapper:-webkit-full-screen #chartAreaWrapper,
        .lira-fs-wrapper.is-mobile-expanded #chartAreaWrapper {
            flex: 1 1 auto;
            min-height: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .lira-fs-wrapper:fullscreen .lira-lwc-stage,
        .lira-fs-wrapper:-webkit-full-screen .lira-lwc-stage,
        .lira-fs-wrapper.is-mobile-expanded .lira-lwc-stage {
            flex: 1 1 auto;
            min-height: 0;
            height: auto;
            border-radius: 0;
        }

        .lira-fs-wrapper.is-fullscreen-tools .lira-draw-toolbar-wrap {
            display: block;
        }

        body.lira-mobile-chart-open {
            overflow: hidden;
            touch-action: none;
        }

        @media (max-width: 1199.98px) {
            .lira-trade-form {
                grid-template-columns: 1fr;
            }

            .lira-lwc-stage {
                height: 540px;
            }
        }

        @media (max-width: 1024.98px) {
            body.page-trading {
                --lira-trading-bottom-nav-height: calc(70px + env(safe-area-inset-bottom));
            }

            html,
            body.page-trading {
                height: 100svh;
                height: 100dvh;
                overflow: hidden;
                overscroll-behavior: none;
            }

            body.page-trading {
                padding-bottom: 0 !important;
            }

            body.page-trading .sidebar-overlay,
            body.page-trading .header,
            body.page-trading .lira-bottom-nav:not(.lira-trading-bottom-nav) {
                display: none !important;
            }

            body.page-trading .lira-dash-wrapper,
            body.page-trading .lira-main-content,
            body.page-trading .lira-page-shell,
            body.page-trading .lira-page-shell .container-xxl,
            body.page-trading .lira-trading-page,
            body.page-trading #chartFullscreenTarget,
            body.page-trading .lira-terminal-shell,
            body.page-trading #chartAreaWrapper {
                min-height: 100svh;
                min-height: 100dvh;
                height: 100svh;
                height: 100dvh;
                overflow: hidden !important;
            }

            body.page-trading .lira-main-content {
                width: 100% !important;
                margin-right: 0 !important;
            }

            body.page-trading .lira-main-content {
                height: 100dvh;
                min-height: 100dvh;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }

            body.page-trading .lira-page-shell {
                flex: 1;
                display: flex;
                flex-direction: column;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden;
            }

            body.page-trading .lira-page-shell .container-xxl {
                flex: 1;
                display: flex;
                flex-direction: column;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden;
            }

            .lira-trading-page {
                flex: 1;
                display: flex;
                flex-direction: column;
                max-width: none;
                width: 100%;
                margin: 0;
                min-height: 100dvh;
                height: 100dvh;
            }

            .lira-page-header {
                display: none;
            }

            .lira-terminal-shell {
                flex: 1;
                display: flex;
                flex-direction: column;
                border-radius: 0;
                border-inline: 0;
                border-bottom: 0;
                margin-bottom: 0 !important;
                background: #0f1422;
                min-height: 100dvh;
                height: 100dvh;
                position: relative;
                /* Context for absolute dock */
            }

            .lira-terminal-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 0;
            }

            .lira-trade-dock {
                position: relative;
                width: 100% !important;
                flex: none;
                overflow: visible;
                padding-bottom: 0 !important;
                display: block !important;
                min-height: 0 !important;
                height: auto !important;
                z-index: 10;
                /* Ensure dock stays within viewport bounds on mobile */
                max-width: 100vw;
                box-sizing: border-box;
                margin-left: 0;
                margin-right: 0;
            }

            .lira-trade-chart-wrap {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 0;
                position: relative;
            }

            #tradeChart {
                flex: 1;
                height: auto !important;
                min-height: 0;
                width: 100%;
            }

            .lira-terminal-header {
                padding: calc(env(safe-area-inset-top) + 8px) 0 0;
            }

            .lira-mobile-appbar,
            .lira-mobile-chart-top,
            .lira-mobile-chart-meta,
            .lira-mobile-chart-bolt,
            .lira-mobile-trade-panel {
                display: flex;
            }

            .lira-mobile-chart-side {
                display: none !important;
            }

            .lira-mobile-chart-frame {
                display: inline-flex;
            }

            .lira-mobile-trade-panel {
                display: block;
            }

            .lira-mobile-appbar {
                justify-content: flex-end;
                padding: 0 6px 4px;
                margin-bottom: 0;
            }

            .lira-terminal-nav {
                display: none;
            }

            .lira-terminal-topbar,
            .lira-terminal-stats,
            .lira-trade-dock__head,
            .lira-trade-form,
            .lira-trade-payout,
            .lira-trade-summary,
            .lira-trade-list {
                display: none;
            }

            .lira-terminal-topbar {
                gap: 10px;
                margin-bottom: 10px;
            }

            .lira-terminal-left,
            .lira-terminal-right,
            .lira-terminal-symbol-group {
                width: 100%;
                justify-content: space-between;
            }

            .lira-symbol-tabs,
            .lira-timeframe-group {
                width: 100%;
                justify-content: space-between;
                gap: 6px;
                padding: 4px;
                border-radius: 14px;
            }

            .lira-market-selector {
                width: 100%;
                padding: 10px;
                border-radius: 18px;
            }

            .lira-symbol-tab,
            .lira-timeframe-chip {
                flex: 1 1 0;
                min-width: 0;
                height: 40px;
                padding: 0 10px;
                font-size: 12px;
            }

            .lira-terminal-market-wrap {
                width: 100%;
                gap: 2px;
            }

            .lira-terminal-market {
                font-size: 11px;
            }

            .lira-terminal-price {
                font-size: 1.6rem;
            }

            .lira-terminal-stat {
                padding: 11px 12px;
                border-radius: 14px;
            }

            .lira-terminal-stat span {
                margin-bottom: 4px;
                font-size: 10px;
            }

            .lira-terminal-stat strong {
                font-size: 13px;
            }

            #chartAreaWrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
                position: relative;
                padding: 0 !important;
                min-height: 100px;
                /* Ensure it doesn't collapse to 0 */
                overflow: hidden;
            }

            .lira-lwc-stage {
                flex: 1;
                height: auto;
                min-height: 0;
                border-radius: 0;
                border-left: 0;
                border-right: 0;
                background: #090c15;
            }

            .lira-draw-toolbar-wrap {
                top: 96px;
                right: 10px;
                left: auto;
                bottom: auto;
                display: block;
                z-index: 12;
            }

            .lira-draw-toggle {
                display: none;
            }

            .lira-draw-menu {
                top: calc(100% + 8px);
                right: 0;
                left: auto;
                bottom: auto;
                width: min(280px, calc(100vw - 32px));
                max-height: min(46dvh, 360px);
                overflow: auto;
                border-radius: 16px;
                padding: 10px;
            }

            /* Mobile close overlay for draw menu */
            .lira-draw-menu-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 11;
                background: rgba(0, 0, 0, 0.3);
            }
            .lira-draw-menu-backdrop.is-open {
                display: block;
            }

            .lira-draw-menu-close {
                display: flex;
            }

            .lira-trade-tooltip {
                display: none !important;
            }

            .lira-trade-dock {
                position: fixed;
                bottom: calc(var(--lira-trading-bottom-nav-height) + 20px);
                left: 50%;
                right: auto;
                transform: translateX(-50%);
                width: min(calc(100vw - 16px), 286px);
                max-width: calc(100vw - 16px);
                z-index: 20;
                margin: 0 !important;
                display: block !important;
                overflow: visible;
                gap: 0;
                padding: 3px;
                min-height: 0 !important;
                height: auto !important;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 28px;
                background: rgba(15, 20, 34, 0.94);
                backdrop-filter: blur(12px);
                box-shadow: 0 10px 26px rgba(0, 0, 0, 0.28);
                pointer-events: auto;
                box-sizing: border-box;
            }

            .lira-mobile-trade-panel {
                margin-top: 0;
                padding: 0;
                border-radius: 0;
                background: transparent;
                border: 0;
                box-shadow: none;
            }

            .lira-mobile-action-bar {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                margin-top: 8px;
                /* Reduced margin */
            }

            .lira-trading-bottom-nav {
                display: flex !important;
                height: var(--lira-trading-bottom-nav-height);
                align-items: center;
                justify-content: space-around;
                padding: 0 10px;
                padding-bottom: env(safe-area-inset-bottom);
                background: rgba(11, 15, 21, 0.95);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(255,255,255,0.06);
                box-shadow: 0 -10px 40px rgba(0,0,0,0.8);
                z-index: 1100;
            }

            .lira-trading-bottom-nav .lira-bottom-nav-item {
                height: 100%;
            }

            .lira-order-btn--mobile {
                height: 48px;
                /* Reduced for slim look */
                padding: 0 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                border-radius: 12px;
                position: relative;
                overflow: hidden;
                transition: transform 0.15s ease;
                box-shadow: none !important;
                border: 0;
                margin-bottom: 0;
            }

            .lira-order-btn--mobile:active {
                transform: scale(0.97);
                filter: brightness(0.9);
            }

            .lira-order-btn--mobile.is-buy {
                background: #10b981 !important;
            }

            .lira-order-btn--mobile.is-sell {
                background: #f43f5e !important;
            }

            .lira-order-btn--mobile i {
                font-size: 20px;
                margin: 0;
            }

            .lira-order-btn-text {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                line-height: 1.1;
                text-align: start;
            }

            .lira-order-btn-text span {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                opacity: 0.9;
                letter-spacing: 0.02em;
            }

            .lira-order-btn-text strong {
                font-size: 16px;
                font-weight: 800;
            }

            .lira-trade-sentiment {
                gap: 8px;
                margin-top: 0;
                margin-bottom: 10px;
                padding: 10px 12px;
                font-size: 10px;
            }

            .lira-trade-sentiment__track {
                height: 8px;
            }

            .lira-trade-sentiment__track::after {
                top: -1px;
                bottom: -1px;
            }

            .lira-fs-wrapper.is-mobile-expanded .lira-draw-toolbar-wrap {
                top: 96px;
                right: 10px;
                bottom: auto;
            }

            .lira-fs-wrapper.is-mobile-expanded .lira-draw-menu {
                top: 0;
                right: 0;
                bottom: auto;
                max-height: min(50dvh, 380px);
                overflow: auto;
            }
        }

        /* ─── Reference-image Mobile Trade Dock ───────────────────────── */
        .lira-ref-dock {
            display: none;
            /* only visible on mobile via overrides below */
        }

        @media (max-width: 1024.98px) {

            /* Hide old desktop-form content in mobile dock */
            .lira-trade-dock .lira-trade-dock__head {
                display: none;
            }

            .lira-trade-dock .lira-trade-form {
                display: none;
            }

            .lira-trade-dock .lira-trade-payout {
                display: none !important;
            }

            .lira-trade-dock .lira-trade-sentiment {
                display: none !important;
            }

            /* Show ref-dock layout */
            .lira-ref-dock {
                display: flex;
                flex-direction: column;
                gap: 8px;
                padding: 10px 10px 8px;
                background: rgba(11,16,25,0.95);
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 26px;
                overflow: hidden;
            }

            /* Premium Input Row */
            .lira-ref-dock__input-row {
                display: flex;
                align-items: center;
                background: rgba(9, 12, 21, 0.5) !important;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 14px;
                overflow: hidden;
                box-shadow: inset 0 2px 10px rgba(0,0,0,0.5) !important;
                backdrop-filter: blur(8px) !important;
            }

            .lira-ref-dock__half {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 12px;
                background: transparent;
                border: 0;
                cursor: pointer;
                transition: background 0.15s;
                position: relative;
            }

            .lira-ref-dock__half:active {
                background: rgba(255, 255, 255, 0.05);
            }

            .lira-ref-dock__half.is-open {
                background: rgba(255, 255, 255, 0.1);
            }

            .lira-ref-dock__sym {
                font-size: 12px;
                color: var(--lira-accent, #00e6a7) !important;
                opacity: 0.8;
                flex: 0 0 auto;
            }

            .lira-ref-dock__val {
                color: #fff;
                font-size: 16px;
                font-weight: 900;
                letter-spacing: -0.02em;
                font-family: monospace;
            }

            .lira-ref-dock__divider {
                width: 1px;
                height: 24px;
                background: rgba(255, 255, 255, 0.1);
                flex: 0 0 auto;
            }

            .lira-mobile-duration-columns {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                direction: ltr !important;
                gap: 8px !important;
            }

            .lira-mobile-duration-unit {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                gap: 4px !important;
            }

            .lira-mobile-duration-unit strong {
                font-size: 20px !important;
                font-weight: 900 !important;
                color: #fff !important;
                font-family: monospace !important;
            }

            .lira-mobile-duration-sep {
                font-size: 20px !important;
                font-weight: 900 !important;
                color: rgba(255,255,255,0.3) !important;
            }

            .lira-mobile-stepper {
                width: 32px !important;
                height: 24px !important;
                background: rgba(255,255,255,0.05) !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-radius: 4px !important;
                color: #fff !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 10px !important;
            }

            /* Premium Profit / Payout row */
            .lira-ref-dock__payout {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 12px;
                font-size: 10px;
                font-weight: 700;
                color: rgba(255, 255, 255, 0.6);
                background: linear-gradient(180deg, rgba(38, 166, 154, 0.1), rgba(38, 166, 154, 0.05));
                border: 1px solid rgba(38, 166, 154, 0.2);
                border-radius: 14px;
            }

            .lira-ref-dock__payout strong {
                color: #fff;
                font-weight: 900;
                font-size: 13px;
                margin-left: 2px;
            }
            #mobileProfitAmount { color: #26a69a !important; }

            .lira-ref-dock__pct {
                font-size: 18px;
                font-weight: 900;
                color: #26a69a;
                text-shadow: 0 0 15px rgba(38, 166, 154, 0.4);
            }

            /* Action bar — Sell left, Buy right (match reference) */
            .lira-mobile-action-bar {
                position: static !important;
                bottom: auto !important;
                left: auto !important;
                right: auto !important;
                padding: 0 10px 10px !important;
                background: transparent !important;
                border-top: 0 !important;
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 8px !important;
                margin-top: 0 !important;
                z-index: auto !important;
                pointer-events: auto !important;
            }

            .lira-order-btn--mobile {
                height: 42px;
                width: 100%;
                min-width: 0;
                border-radius: 16px;
                border: 0;
                color: #fff;
                font-weight: 900;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                flex: 1;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
                transition: transform 0.1s, filter 0.2s !important;
            }
            .lira-order-btn--mobile:active {
                transform: translateY(1px);
            }

            .lira-order-btn--mobile.is-sell {
                background: #ef5350 !important;
                box-shadow: 0 6px 14px rgba(239, 83, 80, 0.22) !important;
            }

            .lira-order-btn--mobile.is-buy {
                background: #26a69a !important;
                box-shadow: 0 6px 14px rgba(38, 166, 154, 0.22) !important;
            }

            .lira-order-btn--mobile i {
                font-size: 14px;
            }

            .lira-order-btn-text {
                display: flex;
                flex-direction: column;
                align-items: center;
                line-height: 1;
            }

            .lira-order-btn-text span {
                display: block !important;
                font-size: 14px;
                font-weight: 900;
                text-transform: uppercase;
            }

            .lira-order-btn-text strong {
                display: none !important;
            }
        }

        @media (min-width: 768px) and (max-width: 1024.98px) {
            .lira-mobile-symbol-menu {
                width: min(440px, calc(100vw - 24px));
            }

            .lira-trade-dock {
                max-width: 300px;
                bottom: calc(var(--lira-trading-bottom-nav-height) + 22px);
            }
        }

        @media (max-width: 575.98px) {
            .lira-mobile-appbar__actions {
                gap: 8px;
            }

            .lira-mobile-appbar__icon,
            .lira-mobile-balance {
                height: 40px;
            }

            .lira-mobile-balance {
                padding: 0 12px;
            }

            .lira-mobile-balance strong {
                font-size: 18px;
            }

            .lira-terminal-nav {
                margin: 0 8px 8px;
                padding: 7px 8px;
                border-radius: 16px;
            }

            .lira-terminal-nav__item {
                min-height: 40px;
                padding: 0 12px;
                gap: 8px;
            }

            .lira-market-selector {
                padding: 8px;
                border-radius: 16px;
            }

            .lira-market-selector__head {
                margin-bottom: 8px;
            }

            .lira-trade-dock {
                bottom: calc(var(--lira-trading-bottom-nav-height) + 22px);
                width: calc(100% - 10px);
                max-width: 274px;
                padding: 0 !important;
                border-radius: 28px;
            }

            .lira-mobile-trade-panel {
                padding: 0;
            }

            .lira-ref-dock__half {
                padding: 6px 7px;
            }

            .lira-ref-dock__val {
                font-size: 12px;
            }

        }

        /* ─── Premium Fund Modal (Global) ─── */
        .lira-modal-premium .modal-content {
            background: #0d1421 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-radius: 28px !important;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6) !important;
            overflow: hidden;
        }

        .lira-modal-premium .modal-header {
            padding: 24px 30px !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        .lira-balance-preview {
            padding: 20px !important;
            border-radius: 20px !important;
            background: linear-gradient(135deg, rgba(82, 148, 255, 0.08) 0%, rgba(82, 148, 255, 0.02) 100%) !important;
            border: 1px solid rgba(82, 148, 255, 0.15) !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .lira-amount-input-wrap {
            position: relative;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px !important;
            padding: 12px 18px !important;
            transition: all 0.2s ease;
        }

        .lira-amount-input-wrap:focus-within {
            border-color: #00e6a7 !important;
            background: rgba(0, 230, 167, 0.05) !important;
            box-shadow: 0 0 0 4px rgba(0, 230, 167, 0.1) !important;
        }

        .lira-amount-input-wrap input {
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
            color: #ffffff !important;
            font-size: 24px !important;
            font-weight: 900 !important;
            padding: 0 !important;
            text-align: center;
        }

        .lira-modal-premium .lira-amount-pill {
            min-width: 68px !important;
            height: 38px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            transition: all 0.2s ease !important;
        }

        .lira-modal-premium .lira-amount-pill:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            transform: translateY(-2px) !important;
            color: #ffffff !important;
        }

        .lira-modal-premium .lira-amount-pill:active {
            transform: translateY(0) !important;
        }

        /* ── Desktop Immersive Trading ── */
        @media (min-width: 1025px) {
            body.page-trading .sidebar-overlay,
            body.page-trading .lira-sidebar,
            body.page-trading .header,
            body.page-trading .lira-bottom-nav:not(.lira-trading-bottom-nav) {
                display: none !important;
            }

            body.page-trading .lira-main-content {
                width: 100% !important;
                margin-right: 0 !important;
            }

            html body.page-trading,
            body.page-trading .lira-dash-wrapper,
            body.page-trading .lira-main-content,
            body.page-trading .lira-page-shell,
            body.page-trading .lira-page-shell .container-xxl,
            body.page-trading .lira-trading-page,
            body.page-trading #chartFullscreenTarget,
            body.page-trading .lira-terminal-shell,
            body.page-trading #chartAreaWrapper {
                height: 100vh;
                min-height: 100vh;
                overflow: hidden;
            }

            body.page-trading .lira-page-shell {
                padding: 0 !important;
                margin: 0 !important;
            }

            body.page-trading .lira-page-shell .container-xxl {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .lira-page-header {
                display: none !important;
            }

            /* Desktop top navigation bar */
            .lira-desktop-trading-topnav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: 60px;
                padding: 0;
                background: rgba(11, 15, 21, 0.96);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.06);
                gap: 0;
                flex: none;
                margin-bottom: 0;
            }

            .lira-dtn-right {
                display: flex;
                align-items: center;
                gap: 0;
                flex: 1 1 auto;
            }

            .lira-dtn-brand {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 180px; /* same as dock */
                margin: 0;
                gap: 10px;
                color: #fff;
                font-weight: 900;
                font-size: 15px;
                text-decoration: none;
                transition: opacity 0.2s;
            }

            .lira-dtn-brand i {
                font-size: 13px;
                color: var(--lira-accent);
            }

            .lira-dtn-brand:hover {
                opacity: 0.8;
                color: #fff;
            }

            .lira-dtn-links {
                display: flex;
                align-items: center;
                gap: 12px;
                flex: 1;
                justify-content: center;
                padding: 0 24px;
            }

            .lira-dtn-links a {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 1;
                max-width: 140px;
                gap: 8px;
                padding: 10px 14px;
                border-radius: 12px;
                color: var(--lira-text-soft);
                background: transparent;
                border: 0;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all 0.2s;
            }
            
            .lira-dtn-links a:hover {
                background: rgba(255, 255, 255, 0.04);
                color: #fff;
            }
            
            .lira-dtn-links a.is-active {
                background: rgba(0, 230, 167, 0.15);
                color: var(--lira-accent);
            }

            .lira-dtn-links a i {
                font-size: 13px;
                color: rgba(255,255,255,0.4);
            }
            .lira-dtn-links a .niro-icon {
                width: 15px;
                height: 15px;
                color: rgba(255,255,255,0.4);
                flex: 0 0 auto;
            }

            .lira-dtn-links a:hover i,
            .lira-dtn-links a:hover .niro-icon {
                color: rgba(255,255,255,0.7);
            }

            .lira-dtn-links a.is-active i,
            .lira-dtn-links a.is-active .niro-icon {
                color: var(--lira-accent);
            }

            .lira-dtn-left {
                display: flex;
                align-items: center;
                gap: 20px;
                padding: 0;
                padding-left: 8px; /* 8px from left edge (physical) */
            }

            .lira-dtn-balance {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                line-height: 1.1;
                margin-right: 8px;
            }
            .lira-dtn-balance span {
                font-size: 9px;
                font-weight: 800;
                color: var(--lira-text-muted);
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .lira-dtn-balance strong {
                font-size: 15px;
                font-weight: 900;
                color: #fff;
            }

            .lira-dtn-fund-btn {
                display: flex;
                align-items: center;
                gap: 8px;
                height: 38px;
                padding: 0 16px;
                border-radius: 10px;
                background: #00e6a7;
                color: #0d1117;
                font-size: 13px;
                font-weight: 800;
                border: none;
                box-shadow: 0 4px 12px rgba(0, 230, 167, 0.16);
                transition: all 0.2s;
            }
            .lira-dtn-fund-btn:hover {
                background: #1af0b5;
                transform: translateY(-1px);
                color: #0d1117;
            }

            .lira-trading-page {
                max-width: none;
                display: flex;
                flex-direction: column;
                height: 100vh;
            }

            .lira-fs-wrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 0;
            }

            .lira-terminal-shell {
                flex: 1;
                border-radius: 0;
                border: 0;
                display: flex;
                flex-direction: column;
                margin-bottom: 0 !important;
            }

            /* Hide the duplicate balance/fund on desktop since we have topnav now */
            .lira-balance-display.d-lg-flex,
            a.btn-primary.d-lg-flex {
                display: none !important;
            }
            /* --- Horizontal Split Layout for Desktop --- */
            .lira-terminal-shell {
                display: grid !important;
                grid-template-columns: 180px 1fr;
                grid-template-rows: 48px 1fr;
                align-items: stretch;
            }
            
            #chartAreaWrapper {
                display: contents !important;
            }

            /* Ultra-Thin Chart Toolbar */
            .lira-terminal-header {
                grid-column: 2;
                grid-row: 1;
                width: 100%;
                padding: 0 8px !important;
                height: 48px; /* slim strip */
                display: flex;
                align-items: center;
                border-bottom: 1px solid rgba(255,255,255,0.06);
                background: rgba(11,15,21,0.6);
            }
            
            .lira-terminal-topbar {
                display: flex;
                flex-wrap: nowrap !important;
                justify-content: space-between !important;
                align-items: center;
                gap: 8px !important;
                margin-bottom: 0 !important;
                width: 100%;
            }
            
            .lira-terminal-left {
                display: flex;
                flex: 1;
                min-width: 0;
            }

            .lira-terminal-right {
                display: flex;
                align-items: center;
                gap: 8px;
                flex: none;
            }

            /* Chart Area - Full bleed */
            .lira-lwc-stage {
                grid-column: 2;
                grid-row: 2;
                height: 100% !important;
                width: 100% !important;
                flex: 1;
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
                background: #090c15;
            }

            /* Ultra-Narrow Trade Panel */
            .lira-trade-dock {
                grid-column: 1;
                grid-row: 1 / 3;
                width: 100% !important;
                min-width: 0 !important;
                max-width: none !important;
                margin: 0 !important;
                border-radius: 0 !important;
                border: none !important;
                border-left: 1px solid rgba(255, 255, 255, 0.06) !important;
                padding: 10px !important;
                height: auto;
                background: rgba(11,16,25,0.95) !important;
                box-shadow: none !important;
                display: flex;
                flex-direction: column;
            }

            /* Hide unnecessary elements on desktop */
            .lira-trade-dock__head,
            .lira-terminal-stats,
            .lira-mobile-trade-panel,
            .lira-trade-payout,
            .lira-trade-sentiment,
            .lira-trade-summary,
            .lira-trade-list,
            .lira-mobile-action-bar,
            .lira-desk-stepper-row {
                display: none !important;
            }

            /* Compact Market Selector */
            .lira-market-selector {
                background: transparent !important;
                border: 0 !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            
            .lira-market-selector__head {
                display: none !important;
            }
            
            .lira-symbol-tabs {
                background: transparent !important;
                border: 0 !important;
                padding: 0 !important;
                gap: 4px !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
            }
            
            .lira-symbol-tab {
                height: 28px !important;
                min-width: 56px !important;
                padding: 0 10px !important;
                font-size: 11px !important;
                border-radius: 6px !important;
            }

            /* Compact timeframe and market display */
            .lira-timeframe-group {
                padding: 3px !important;
                border-radius: 8px !important;
                gap: 4px !important;
            }
            .lira-timeframe-chip {
                height: 28px !important;
                min-width: 36px !important;
                font-size: 11px !important;
                border-radius: 6px !important;
            }
            
            .lira-terminal-market-wrap { gap: 2px !important; align-items: center; justify-content: center; }
            .lira-terminal-market { font-size: 11px !important; }
            .lira-terminal-price { font-size: 14px !important; }
            .lira-btn-expand { width: 32px !important; height: 32px !important; border-radius: 8px !important; }

            /* Stack trade form tightly */
            .lira-trade-form { gap: 6px !important; }
            .lira-desk-top-deck { flex-direction: column !important; gap: 8px !important; }
            
            /* Sleek Input Cards */
            .lira-desk-input-card {
                background: rgba(9, 12, 21, 0.5) !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                padding: 10px 12px !important;
                border-radius: 8px !important;
                box-shadow: inset 0 2px 10px rgba(0,0,0,0.5) !important;
                backdrop-filter: blur(8px) !important;
            }
            .lira-desk-input-card__label { 
                font-size: 10px !important; 
                color: rgba(255,255,255,0.5) !important; 
                margin-bottom: 8px !important; 
                display: flex;
                align-items: center;
                gap: 6px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-weight: 700 !important;
            }
            .lira-desk-input-card__value {
                background: transparent !important;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 !important;
            }
            .lira-desk-input-card__value input { 
                font-size: 20px !important;
                font-weight: 900 !important;
                color: #fff !important;
                background: transparent !important;
                border: none !important;
                text-align: center;
                width: 70px !important;
                font-family: monospace;
            }
            .lira-desk-input-card__icon, 
            .lira-desk-input-card__unit {
                color: var(--lira-accent, #00e6a7) !important;
                font-weight: 800 !important;
                font-size: 11px !important;
                opacity: 0.8;
            }
            
            /* Amount steppers styling */
            .lira-desk-stepper-row {
                display: flex !important;
                justify-content: space-between !important;
                margin-top: 8px !important;
            }
            .lira-amount-quick { display: none !important; } /* Hidden to keep UI clean */
            .lira-desk-stepper-row .lira-stepper-btn {
                background: rgba(255,255,255,0.05) !important;
                color: #fff !important;
                width: 36px !important;
                height: 28px !important;
                border-radius: 6px !important;
                font-size: 12px !important;
                border: 1px solid rgba(255,255,255,0.05) !important;
                transition: all 0.2s !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .lira-desk-stepper-row .lira-stepper-btn:hover {
                background: rgba(255,255,255,0.15) !important;
                border-color: rgba(255,255,255,0.2) !important;
            }

            /* Compact payout strip - Premium */
            .lira-desk-payout-strip {
                flex-direction: column !important;
                text-align: center !important;
                padding: 10px 8px !important;
                gap: 8px !important;
                border-radius: 8px !important;
                background: linear-gradient(180deg, rgba(38, 166, 154, 0.1), rgba(38, 166, 154, 0.05)) !important;
                border: 1px solid rgba(38, 166, 154, 0.2) !important;
                margin-top: 4px !important;
            }
            .lira-desk-payout-strip div { 
                display: flex;
                align-items: center; 
                justify-content: space-between !important;
                border-bottom: 1px dashed rgba(255,255,255,0.05) !important; 
                padding-bottom: 6px !important;
                font-size: 11px !important;
                color: rgba(255,255,255,0.6) !important;
            }
            .lira-desk-payout-strip div:last-child { 
                border-bottom: none !important; 
                padding-bottom: 0px !important;
            }
            .lira-desk-payout-strip strong {
                font-size: 13px !important;
                color: #fff !important;
            }
            .lira-desk-payout-strip #profitValue { color: #26a69a !important; }
            .lira-payout-highlight {
                font-size: 22px !important;
                font-weight: 900 !important;
                color: #26a69a !important;
                text-shadow: 0 0 15px rgba(38, 166, 154, 0.4) !important;
                margin: 4px 0 !important;
            }

            /* BUY/SELL buttons vertically stacked */
            .lira-trade-actions {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }
            .lira-order-btn {
                height: 48px !important;
                border-radius: 8px !important;
                font-size: 14px !important;
                font-weight: 900 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                border: none !important;
                box-shadow: 0 8px 16px rgba(0,0,0,0.3) !important;
                transition: transform 0.1s, filter 0.2s !important;
            }
            .lira-order-btn:hover { filter: none !important; transform: none !important; }
            .lira-order-btn:active { transform: none !important; }
            .lira-order-btn.is-buy { background: #26a69a !important; color: #fff !important; box-shadow: 0 8px 16px rgba(38, 166, 154, 0.18) !important; }
            .lira-order-btn.is-sell { background: #ef5350 !important; color: #fff !important; box-shadow: 0 8px 16px rgba(239, 83, 80, 0.18) !important; }

            /* Duration spinner compact locking */
            .lira-duration-spinner { 
                display: flex !important;
                gap: 4px !important;
                align-items: center !important;
                justify-content: center !important;
                direction: ltr !important; /* ALWAYS keep time LTR (HH:MM:SS) */
                width: 100%;
            }
            .lira-duration-unit {
                background: rgba(255,255,255,0.03) !important;
                border-radius: 4px !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                padding: 4px !important;
                border: 1px solid transparent !important;
            }
            .lira-duration-unit:hover { border-color: rgba(255,255,255,0.08) !important; }
            .lira-duration-unit input { 
                font-size: 16px !important; 
                font-weight: 800 !important;
                padding: 4px 0 !important;
                width: 32px !important;
                text-align: center !important;
                background: transparent !important;
                border: none !important;
                color: #fff !important;
            }
            .lira-duration-spinner .lira-stepper-btn { 
                width: 28px !important; 
                height: 20px !important; 
                font-size: 10px !important; 
                border-radius: 4px !important; 
                background: rgba(255,255,255,0.05) !important;
                color: rgba(255,255,255,0.6) !important;
                border: 1px solid transparent !important;
                display: flex; align-items: center; justify-content: center;
                transition: 0.1s !important;
            }
            .lira-duration-spinner .lira-stepper-btn:hover {
                background: rgba(255,255,255,0.15) !important;
                color: #fff !important;
            }
            .lira-duration-sep { font-size: 16px !important; font-weight: bold !important; color: rgba(255,255,255,0.3) !important; }

            /* Hide native number input arrows */
            .lira-desk-input-card__value input::-webkit-outer-spin-button,
            .lira-desk-input-card__value input::-webkit-inner-spin-button,
            .lira-duration-unit input::-webkit-outer-spin-button,
            .lira-duration-unit input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            .lira-desk-input-card__value input[type=number],
            .lira-duration-unit input[type=number] {
                -moz-appearance: textfield;
            }
        }

        @media (max-width: 1024.98px) {
            body.page-trading .header,
            body.page-trading .lira-topbar {
                display: none !important;
            }

            body.page-trading .lira-main-content,
            body.page-trading .lira-page-shell,
            body.page-trading .lira-page-shell .container-xxl,
            body.page-trading .lira-trading-page {
                height: 100dvh !important;
                min-height: 100dvh !important;
            }

            body.page-trading .lira-trading-page {
                display: flex;
                flex-direction: column;
            }

            body.page-trading #chartFullscreenTarget {
                flex: 1 1 auto;
                min-height: 0 !important;
                height: auto !important;
                display: flex;
                flex-direction: column;
            }

            body.page-trading .lira-terminal-shell {
                flex: 1 1 auto;
                min-height: 0 !important;
                height: auto !important;
                display: flex;
                flex-direction: column;
            }

            body.page-trading #chartAreaWrapper {
                flex: 1 1 auto;
                min-height: 0 !important;
                height: auto !important;
                display: flex;
                flex-direction: column;
            }

            .lira-page-header {
                display: none !important;
            }

            .lira-desktop-trading-topnav {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 12px;
                padding: 12px 14px;
                height: auto;
                background: #0b0f15;
                backdrop-filter: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.06);
                flex: none;
                box-shadow: none;
            }

            .lira-dtn-right,
            .lira-dtn-left {
                width: auto;
                min-width: 0;
            }

            .lira-dtn-right {
                display: flex;
                align-items: center;
                gap: 0;
                flex: 0 1 auto;
            }

            .lira-dtn-brand {
                gap: 8px;
                font-size: 14px;
                white-space: nowrap;
                padding: 0;
                color: rgba(244, 246, 250, 0.9);
            }

            .lira-dtn-links {
                display: none !important;
            }

            .lira-dtn-left {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 8px;
                flex: 1 1 auto;
            }

            .lira-dtn-balance {
                margin-right: 0;
                display: inline-flex;
                flex-direction: row;
                align-items: center;
                gap: 6px;
                padding: 0 12px;
                min-height: 34px;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.025);
                border: 1px solid rgba(255, 255, 255, 0.06);
                min-width: 0;
                flex: 0 1 auto;
            }

            .lira-dtn-balance span {
                font-size: 9px;
                line-height: 1;
            }

            .lira-dtn-balance strong {
                font-size: 13px;
                line-height: 1;
            }

            .lira-dtn-fund-btn {
                height: 34px;
                padding: 0 14px;
                font-size: 12px;
                border-radius: 9px;
                background: #00e6a7 !important;
                color: #0d1117 !important;
                border: 1px solid rgba(0, 230, 167, 0.22) !important;
                box-shadow: none !important;
                flex: 0 0 auto;
                white-space: nowrap;
            }

            .lira-dtn-fund-btn:hover,
            .lira-dtn-fund-btn:focus,
            .lira-dtn-fund-btn:active {
                background: #00e6a7 !important;
                color: #0d1117 !important;
                box-shadow: none !important;
                transform: none !important;
            }

            .lira-mobile-appbar,
            .lira-terminal-nav {
                display: none !important;
            }

            .lira-terminal-header {
                display: none !important;
                padding: 0 !important;
                margin: 0 !important;
                min-height: 0 !important;
                height: 0 !important;
                border: 0 !important;
                overflow: hidden !important;
            }

            .lira-trade-dock {
                padding: 0 !important;
            }
        }

        @media (max-width: 575.98px) {
            .lira-desktop-trading-topnav {
                gap: 8px;
                padding: 10px 12px;
            }

            .lira-dtn-brand {
                font-size: 13px;
            }

            .lira-dtn-brand i {
                font-size: 12px;
            }

            .lira-dtn-left {
                gap: 6px;
            }

            .lira-dtn-balance {
                padding: 0 10px;
                min-height: 32px;
                border-radius: 9px;
            }

            .lira-dtn-balance strong {
                font-size: 12px;
            }

            .lira-dtn-fund-btn {
                height: 32px;
                padding: 0 11px;
                font-size: 11px;
                gap: 6px;
                border-radius: 8px;
            }
        }

        #tradeDock,
        #tradeDock *,
        #tradeDock::before,
        #tradeDock::after {
            box-shadow: none !important;
            text-shadow: none !important;
        }

        #tradeDock .lira-order-btn:hover,
        #tradeDock .lira-order-btn--mobile:hover,
        #tradeDock .lira-order-btn:active,
        #tradeDock .lira-order-btn--mobile:active {
            filter: none !important;
        }

        .lira-draw-toggle.items__link--drawings {
            width: 38px !important;
            min-width: 38px !important;
            height: 38px !important;
            min-height: 38px !important;
            padding: 0 !important;
            border: 0 !important;
            border-radius: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative;
            overflow: visible;
            background: rgba(255, 255, 255, 0.04) !important;
            color: #eef3ff !important;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08) !important;
        }

        .lira-draw-toggle.items__link--drawings:hover,
        .lira-draw-toggle.items__link--drawings.is-open,
        .lira-draw-toggle.items__link--drawings.is-drawing {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.14) !important;
        }

        .lira-draw-toggle.items__link--drawings .items__fa {
            color: var(--lira-accent, #00e6a7);
            font-size: 16px;
            line-height: 1;
        }

        .lira-draw-toggle.items__link--drawings .lira-draw-toggle__meta,
        .lira-draw-toggle.items__link--drawings .lira-draw-toggle__count {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .lira-draw-toggle.items__link--drawings .tooltip-content {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            z-index: 60;
            display: block;
            min-width: 74px;
            padding: 7px 10px;
            border-radius: 8px;
            background: rgba(9, 12, 21, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -4px);
            transition: opacity 0.16s ease, transform 0.16s ease;
        }

        .lira-draw-toggle.items__link--drawings:hover .tooltip-content,
        .lira-draw-toggle.items__link--drawings:focus-visible .tooltip-content {
            opacity: 1;
            transform: translate(-50%, 0);
        }

        @media (min-width: 1025px) {
            .lira-terminal-header .lira-terminal-symbol-group {
                display: none !important;
            }

            .lira-lwc-stage .lira-mobile-chart-top {
                top: 10px !important;
                left: 10px !important;
                right: auto !important;
                z-index: 11 !important;
                display: flex !important;
                align-items: flex-start !important;
                justify-content: flex-start !important;
                gap: 8px !important;
                pointer-events: none;
            }

            .lira-lwc-stage .lira-mobile-chart-top .lira-account-mode-switch {
                display: none !important;
            }

            .lira-lwc-stage .lira-mobile-chart-controls {
                display: flex !important;
                align-items: flex-start !important;
                gap: 8px !important;
                pointer-events: auto;
            }

            .lira-lwc-stage .lira-mobile-pair {
                min-width: 132px !important;
                min-height: 38px !important;
                height: 38px !important;
                justify-content: space-between !important;
                border-radius: 10px !important;
                background: rgba(255, 255, 255, 0.04) !important;
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08) !important;
            }

            .lira-lwc-stage .lira-mobile-pair-meta {
                display: block !important;
                padding-inline-start: 4px !important;
            }

            .lira-lwc-stage .lira-mobile-pair-meta strong {
                color: #d5deef !important;
                font-size: 13px !important;
                font-weight: 800 !important;
                line-height: 1.15 !important;
            }

            .lira-lwc-stage .lira-mobile-pair-meta span {
                color: #8d9bb8 !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            .lira-lwc-stage .lira-draw-toolbar-wrap {
                top: 10px !important;
                left: 152px !important;
                right: auto !important;
                z-index: 12 !important;
            }

            .lira-lwc-stage .lira-draw-menu {
                top: 46px !important;
                left: 0 !important;
                right: auto !important;
            }

            #tradeDock {
                position: relative !important;
                overflow: visible !important;
                z-index: 80 !important;
            }

            #tradeDock .lira-mobile-trade-panel {
                display: block !important;
                position: fixed !important;
                top: var(--lira-editor-popover-top, 128px);
                left: var(--lira-editor-popover-left, 188px);
                right: auto;
                width: min(344px, calc(100vw - 28px));
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
                z-index: 12020;
                pointer-events: none;
            }

            #tradeDock .lira-mobile-editor-stack {
                display: block !important;
                margin: 0 !important;
                pointer-events: none;
            }

            #tradeDock .lira-mobile-editor-panel {
                width: 100%;
                position: relative;
                overflow: hidden;
                padding: 14px !important;
                border-radius: 16px !important;
                background: rgba(17, 24, 39, 0.98) !important;
                border: 1px solid rgba(0, 230, 167, 0.16) !important;
                box-shadow: 0 16px 32px rgba(0, 0, 0, 0.34) !important;
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                pointer-events: auto;
            }

            #tradeDock .lira-mobile-editor-panel::before {
                display: none;
            }

            #tradeDock .lira-mobile-editor-panel::after {
                content: "";
                position: absolute;
                top: var(--lira-editor-arrow-top, 20px);
                left: -6px;
                width: 12px;
                height: 12px;
                transform: rotate(45deg);
                background: rgba(17, 24, 39, 0.98);
                border-left: 1px solid rgba(0, 230, 167, 0.16);
                border-bottom: 1px solid rgba(0, 230, 167, 0.16);
                pointer-events: none;
            }

            #tradeDock .lira-mobile-editor-panel > * {
                position: relative;
                z-index: 1;
            }

            #tradeDock .lira-ref-dock {
                display: none !important;
            }

            #tradeDock .lira-desk-top-deck {
                display: flex !important;
                flex-direction: column !important;
                gap: 10px !important;
                padding: 0 !important;
                border: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            #tradeDock .lira-desk-input-card {
                min-height: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 5px !important;
                cursor: pointer;
            }

            #tradeDock .lira-desk-input-card--duration {
                order: 1;
            }

            #tradeDock .lira-desk-input-card--amount {
                order: 2;
            }

            #tradeDock .lira-desk-input-card__label {
                width: 100%;
                margin: 0 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 5px !important;
                color: #aab6cf !important;
                font-size: 10px !important;
                font-weight: 800 !important;
                letter-spacing: 0 !important;
                line-height: 1.2 !important;
                text-transform: none !important;
            }

            #tradeDock .lira-desk-input-card__help {
                color: #6f7b96;
                font-size: 10px;
            }

            #tradeDock .lira-desk-input-card__value {
                width: 100%;
                min-height: 34px;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 8px !important;
                padding: 0 7px 0 12px !important;
                border-radius: 7px !important;
                background: #151c2e !important;
                border: 1px solid rgba(255, 255, 255, 0.055) !important;
                direction: ltr;
            }

            #tradeDock .lira-desk-input-card__icon {
                order: 2;
                width: 26px;
                height: 26px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 26px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.04);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
                color: var(--lira-accent, #00e6a7) !important;
                font-size: 12px !important;
                opacity: 1;
            }

            #tradeDock .lira-desk-input-card__currency {
                font-family: Arial, sans-serif;
                font-size: 12px !important;
                font-weight: 900;
                line-height: 1;
            }

            #tradeDock .lira-desk-input-card__value input {
                order: 1;
                flex: 1 1 auto !important;
                width: 100% !important;
                min-width: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                background: transparent !important;
                color: #fff !important;
                font-family: monospace !important;
                font-size: 14px !important;
                font-weight: 900 !important;
                line-height: 1 !important;
                text-align: left !important;
                pointer-events: none;
            }

            #tradeDock .lira-desk-input-card__unit,
            #tradeDock .lira-desk-stepper-row,
            #tradeDock .lira-duration-spinner,
            #tradeDock .lira-desk-duration-presets {
                display: none !important;
            }

            #tradeDock .lira-desk-duration-display {
                order: 1;
                flex: 1 1 auto;
                color: #fff;
                font-family: monospace;
                font-size: 14px;
                font-weight: 900;
                line-height: 1;
                white-space: nowrap;
                text-align: left;
            }

            #tradeDock .lira-mobile-duration-columns,
            #tradeDock .lira-mobile-amount-display {
                background: rgba(4, 8, 16, 0.3) !important;
                border: 1px solid rgba(255, 255, 255, 0.06);
                border-radius: 14px;
                box-shadow: none !important;
            }

            #tradeDock .lira-mobile-duration-unit strong {
                text-shadow: none !important;
            }

            #tradeDock .lira-mobile-keypad__key,
            #tradeDock .lira-mobile-duration-preset,
            #tradeDock .lira-mobile-stepper {
                box-shadow: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="lira-trading-page">
        <div class="lira-page-header">
            <div>
                <span class="lira-eyebrow">Niro Trade · {{ appName() }}</span>
                <h1 class="lira-page-title">مركز التداول المباشر</h1>
                <p class="lira-page-subtitle">
                    واجهة التداول هنا أصبحت مبنية على نفس روح وتصرف الشارت الموجود في الملف المرجعي، مع
                    تخطيط مخصص للموبايل حتى يظهر بشكل أقرب للتصميم الذي أرسلته.
                </p>
            </div>
        </div>

        <!-- Desktop Immersive Top Nav -->
        <div class="lira-desktop-trading-topnav">
            <div class="lira-dtn-right">
                <a href="{{ route('site.dashboard') }}" class="lira-dtn-brand">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Niro Trade</span>
                </a>
                <nav class="lira-dtn-links">
                    @foreach ($tradingBottomNav as $item)
                        @if (empty($item['tablet_only']))
                            <a href="{{ $item['href'] }}" class="{{ $item['active'] ? 'is-active' : '' }}">
                                <x-niro-icon name="{{ $item['icon'] }}" />
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
            
            <div class="lira-dtn-left">
                <div class="lira-dtn-balance">
                    <span>Balance</span>
                    <strong id="topNavBalanceValue">{{ '$' . number_format($activeTradingBalance, 2) }}</strong>
                </div>
                <button class="lira-dtn-fund-btn" onclick="bootstrap.Modal.getOrCreateInstance(document.getElementById('fundTradingModal')).show()">
                    <i class="fa-solid fa-plus"></i> شحن الرصيد
                </button>
            </div>
        </div>

        <div id="chartFullscreenTarget" class="lira-fs-wrapper">
            <div class="lira-terminal-shell">
                <div class="lira-terminal-header">
                    <div class="lira-mobile-appbar">
                        <div class="lira-mobile-appbar__actions">
                            <div class="lira-mobile-balance" id="mobileBalanceChip" data-href="{{ route('site.wallet') }}">
                            <span id="mobileBalanceModeLabel">QT {{ ucfirst($initialTradingMode) }}</span>
                            <small>USD</small>
                            <strong
                                id="mobileBalanceValue">{{ '$' . number_format($activeTradingBalance, 2) }}</strong>
                            </div>

                            <button type="button" class="lira-mobile-appbar__icon is-wallet" id="mobileWalletShortcut"
                                onclick="bootstrap.Modal.getOrCreateInstance(document.getElementById('fundTradingModal')).show()">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <nav class="lira-terminal-nav d-lg-none" aria-label="صفحات التداول">
                        <div class="lira-terminal-nav__track">
                            @foreach ($tradingMobileNav as $item)
                                <a href="{{ $item['href'] }}"
                                    class="lira-terminal-nav__item {{ $item['active'] ? 'is-active' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </nav>

                    <div class="lira-terminal-topbar">
                        <div class="lira-terminal-left">
                            <div class="lira-terminal-symbol-group">
                                <div class="lira-market-selector">
                                    <div class="lira-market-selector__head">
                                        <span class="lira-market-selector__eyebrow">الأسواق المتاحة</span>
                                        <span class="lira-market-selector__count">{{ count($tradingSymbols) }} سوق</span>
                                    </div>
                                    <div class="lira-symbol-tabs">
                                        @foreach ($tradingSymbols as $symbolKey => $symbol)
                                            <button type="button"
                                                class="lira-symbol-tab {{ $symbolKey === $defaultTradingSymbolKey ? 'active' : '' }}"
                                                data-symbol="{{ $symbolKey }}">{{ $symbol['tab'] }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="lira-terminal-market-wrap">
                                    <span class="lira-terminal-market" id="marketLabel">{{ $defaultTradingSymbol['name'] }}</span>
                                    <strong class="lira-terminal-price" id="goldSpotPrice">--</strong>
                                </div>
                            </div>
                        </div>

                            <div class="lira-terminal-right">
                            <div class="lira-account-mode-switch" data-account-mode-switch>
                                <button type="button" data-trade-account-mode="real" class="{{ $initialTradingMode === 'real' ? 'is-active' : '' }}" {{ $isDemoAccount ? 'disabled' : '' }}>Real</button>
                                <button type="button" data-trade-account-mode="demo" class="{{ $initialTradingMode === 'demo' ? 'is-active' : '' }}">Demo</button>
                            </div>
                            <a href="{{ route('site.performance') }}" class="lira-balance-display d-none d-lg-flex text-decoration-none" style="align-items:center; gap:8px; padding:6px 14px; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.05); border-radius:12px; margin-right: 8px; transition: 0.2s; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                                <span style="font-size:10px; color:rgba(154, 178, 220, 0.7); font-weight:800; letter-spacing:1px; text-transform:uppercase;">Balance</span>
                                <strong id="desktopBalanceValue" style="color:#fff; font-size:15px; font-weight:900;">{{ '$' . number_format($activeTradingBalance, 2) }}</strong>
                                <i class="fa-solid fa-chart-pie" style="color:#10b981; font-size: 13px; margin-left: 4px;"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="bootstrap.Modal.getOrCreateInstance(document.getElementById('fundTradingModal')).show()" class="btn btn-primary d-none d-lg-flex align-items-center gap-2" style="height: 40px; border-radius: 12px; font-weight: 800; font-size: 13px; padding: 0 16px;">
                                <i class="fa-solid fa-plus"></i>
                                شحن الرصيد
                            </a>
                            <div class="lira-timeframe-group">
                                <button type="button" class="lira-timeframe-chip" data-interval="1m">1M</button>
                                <button type="button" class="lira-timeframe-chip active" data-interval="5m">5M</button>
                                <button type="button" class="lira-timeframe-chip" data-interval="1h">1H</button>
                            </div>

                            <button id="toggleFullscreenBtn" class="lira-btn-expand" title="ملء الشاشة">
                                <i class="fa-solid fa-expand"></i>
                            </button>
                        </div>
                    </div>

                    <div class="lira-terminal-stats">
                        <div class="lira-terminal-stat">
                            <span>Change</span>
                            <strong id="goldPriceChange" class="{{ $priceChange >= 0 ? 'is-up' : 'is-down' }}">
                                {{ $priceChange >= 0 ? '+' : '' }}{{ number_format($priceChange, 2) }}
                                ({{ $priceChangePct >= 0 ? '+' : '' }}{{ number_format($priceChangePct, 2) }}%)
                            </strong>
                        </div>

                        <div class="lira-terminal-stat">
                            <span>Hovered</span>
                            <strong id="goldHoveredPrice">--</strong>
                        </div>

                        <div class="lira-terminal-stat">
                            <span>Time</span>
                            <strong id="goldHoveredTime">--</strong>
                        </div>

                        <div class="lira-terminal-stat">
                            <span>Range</span>
                            <strong id="goldRangeText">--</strong>
                        </div>
                    </div>
                </div>

                <div id="chartAreaWrapper">
                    <div class="lira-lwc-stage" id="tradeChartStage">
                        <div class="lira-mobile-chart-top">
                            <div class="lira-account-mode-switch" data-account-mode-switch>
                                <button type="button" data-trade-account-mode="real" class="{{ $initialTradingMode === 'real' ? 'is-active' : '' }}" {{ $isDemoAccount ? 'disabled' : '' }}>Real</button>
                                <button type="button" data-trade-account-mode="demo" class="{{ $initialTradingMode === 'demo' ? 'is-active' : '' }}">Demo</button>
                            </div>
                            <div class="lira-mobile-chart-controls">
                                <div class="lira-mobile-pair-wrap">
                                    <button type="button" class="lira-mobile-pair" id="mobileSymbolButton">
                                        <span id="mobileSymbolLabel">{{ $defaultTradingSymbol['label'] }}</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>

                                    <div class="lira-mobile-pair-meta">
                                        <strong id="mobilePairPrice">--</strong>
                                        <span id="mobilePairTime">--</span>
                                    </div>
                                </div>

                                <button type="button" class="lira-mobile-chart-frame" id="mobileTimeframeTrigger">
                                    <i class="fa-solid fa-clock"></i>
                                    <span id="mobileChartFrameValue">M5</span>
                                    <i class="fa-solid fa-chevron-down" style="font-size:8px; opacity:0.5;"></i>
                                </button>
                            </div>


                        </div>

                        <button type="button" class="lira-mobile-chart-side" id="mobileToolsButton">
                            <i class="fa-solid fa-pen-ruler"></i>
                        </button>

                        <div class="lira-mobile-symbol-menu" id="mobileSymbolMenu">
                            <div class="lira-mobile-symbol-menu__head">
                                <strong>اختر السوق</strong>
                                <span>{{ count($tradingSymbols) }} أصل متاح</span>
                            </div>
                            @foreach ($tradingSymbols as $symbolKey => $symbol)
                                <button type="button"
                                    class="lira-mobile-symbol-option {{ $symbolKey === $defaultTradingSymbolKey ? 'is-active' : '' }}"
                                    data-symbol="{{ $symbolKey }}">
                                    <strong>{{ $symbol['label'] }}</strong>
                                    <span>{{ $symbol['name'] }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="lira-mobile-timeframe-modal" id="mobileTimeframeModal">
                            <div class="lira-mobile-timeframe-sheet">
                                <div class="lira-mobile-timeframe-sheet__nav">
                                    <span class="chart-settings-modal__nav-link">Chart types</span>
                                    <span class="chart-settings-modal__nav-link active" id="mobileTimeframeSheetTitle">Time
                                        frames (M5)</span>
                                </div>

                                <div class="lira-mobile-timeframe-list">
                                    <button type="button" class="lira-interval-option" data-interval="5s">S5</button>
                                    <button type="button" class="lira-interval-option" data-interval="10s">S10</button>
                                    <button type="button" class="lira-interval-option" data-interval="15s">S15</button>
                                    <button type="button" class="lira-interval-option" data-interval="30s">S30</button>
                                    <button type="button" class="lira-interval-option" data-interval="1m">M1</button>
                                    <button type="button" class="lira-interval-option" data-interval="2m">M2</button>
                                    <button type="button" class="lira-interval-option" data-interval="3m">M3</button>
                                    <button type="button" class="lira-interval-option is-active"
                                        data-interval="5m">M5</button>
                                    <button type="button" class="lira-interval-option" data-interval="10m">M10</button>
                                    <button type="button" class="lira-interval-option" data-interval="15m">M15</button>
                                    <button type="button" class="lira-interval-option" data-interval="30m">M30</button>
                                    <button type="button" class="lira-interval-option" data-interval="1h">H1</button>
                                    <button type="button" class="lira-interval-option" data-interval="4h">H4</button>
                                    <button type="button" class="lira-interval-option" data-interval="1d">D1</button>
                                </div>
                            </div>
                        </div>

                        <div class="lira-draw-menu-backdrop" id="drawMenuBackdrop"></div>
                        <div class="lira-draw-toolbar-wrap">
                            <button type="button" class="lira-draw-toggle tooltip2 block1__item items__link items__link--drawings" id="drawMenuToggle" aria-label="الرسومات">
                                <i class="items__fa fa fa-paint-brush" aria-hidden="true"></i>
                                <span class="lira-draw-toggle__meta">
                                    <strong id="activeToolLabel">Cursor</strong>
                                    <span id="drawingsCountLabel">0 drawings</span>
                                </span>
                                <span class="lira-draw-toggle__count" id="drawingsCountBadge">0</span>
                                <div class="tooltip-content tooltip-status-on position-down" aria-hidden="true">
                                    <div class="tooltip-text">الرسومات</div>
                                </div>
                            </button>

                            <div class="lira-draw-menu" id="drawMenu">
                                <span class="lira-draw-menu__section-label">Draw Tools</span>
                                <button type="button" class="lira-draw-item is-active" data-tool="cursor">
                                    <span class="lira-draw-item__icon">
                                        <i class="fa-solid fa-arrow-pointer"></i>
                                    </span>
                                    <span class="lira-draw-item__body">
                                        <strong>Cursor</strong>
                                        <small>Inspect the chart and follow price</small>
                                    </span>
                                    <span class="lira-draw-item__key">Esc</span>
                                </button>
                                <button type="button" class="lira-draw-item" data-tool="hline">
                                    <span class="lira-draw-item__icon">
                                        <i class="fa-solid fa-grip-lines"></i>
                                    </span>
                                    <span class="lira-draw-item__body">
                                        <strong>Horizontal Line</strong>
                                        <small>Mark support or resistance zones</small>
                                    </span>
                                    <span class="lira-draw-item__key">H</span>
                                </button>
                                <button type="button" class="lira-draw-item" data-tool="vline">
                                    <span class="lira-draw-item__icon">
                                        <i class="fa-solid fa-up-down"></i>
                                    </span>
                                    <span class="lira-draw-item__body">
                                        <strong>Vertical Line</strong>
                                        <small>Pin key time points on the chart</small>
                                    </span>
                                    <span class="lira-draw-item__key">V</span>
                                </button>
                                <button type="button" class="lira-draw-item" data-tool="trend">
                                    <span class="lira-draw-item__icon">
                                        <i class="fa-solid fa-arrow-trend-up"></i>
                                    </span>
                                    <span class="lira-draw-item__body">
                                        <strong>Trend Line</strong>
                                        <small>Track breakouts and direction shifts</small>
                                    </span>
                                    <span class="lira-draw-item__key">T</span>
                                </button>
                                <button type="button" class="lira-draw-item" data-tool="rect">
                                    <span class="lira-draw-item__icon">
                                        <i class="fa-regular fa-square"></i>
                                    </span>
                                    <span class="lira-draw-item__body">
                                        <strong>Rectangle</strong>
                                        <small>Highlight supply and demand ranges</small>
                                    </span>
                                    <span class="lira-draw-item__key">R</span>
                                </button>

                                <button type="button" class="lira-draw-menu-close" id="drawMenuCloseBtn"><i class="fa-solid fa-xmark" style="margin-left:6px"></i> إغلاق</button>

                                <div class="lira-draw-actions-group" style="display:none;">
                                    <div class="lira-draw-sep"></div>
                                    <span class="lira-draw-menu__section-label">Actions</span>
                                    <button type="button" class="lira-draw-item" data-action="follow-live">
                                        <span class="lira-draw-item__icon"><i class="fa-solid fa-satellite-dish"></i></span>
                                        <span class="lira-draw-item__body"><strong>Follow Live</strong><small>Jump back to the latest candle</small></span>
                                        <span class="lira-draw-item__key">Now</span>
                                    </button>
                                    <button type="button" class="lira-draw-item" data-action="undo">
                                        <span class="lira-draw-item__icon"><i class="fa-solid fa-rotate-left"></i></span>
                                        <span class="lira-draw-item__body"><strong>Undo Last</strong><small>Remove the most recent drawing</small></span>
                                        <span class="lira-draw-item__key">Ctrl+Z</span>
                                    </button>
                                    <button type="button" class="lira-draw-item" data-action="delete-selected">
                                        <span class="lira-draw-item__icon"><i class="fa-regular fa-trash-can"></i></span>
                                        <span class="lira-draw-item__body"><strong>Delete Selected</strong><small>Remove the currently selected object</small></span>
                                        <span class="lira-draw-item__key">Del</span>
                                    </button>
                                    <button type="button" class="lira-draw-item is-danger" data-action="clear">
                                        <span class="lira-draw-item__icon"><i class="fa-solid fa-trash"></i></span>
                                        <span class="lira-draw-item__body"><strong>Clear Drawings</strong><small>Reset the overlay back to a clean chart</small></span>
                                        <span class="lira-draw-item__key">Reset</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="tradeChart" class="lira-lwc-chart"></div>
                        <canvas id="tradeDrawLayer" class="lira-draw-layer"></canvas>
                        <div id="tradeTooltip" class="lira-trade-tooltip"></div>
                    </div>

                    <div class="lira-trade-dock" id="tradeDock">
                        <div class="lira-trade-dock__head">
                            <div class="lira-trade-dock__lead">
                                <span class="lira-trade-dock__eyebrow">Quick Trade Panel</span>
                                <strong class="lira-trade-dock__title">Enter deals directly from the live chart</strong>
                                <p class="lira-trade-dock__subtitle">Adjust amount, expiry, and direction without leaving
                                    the market view.</p>
                            </div>

                            <div class="lira-trade-dock__meta" style="display: none !important;">
                                <div class="lira-trade-mode-pill" id="tradeModePill">Live</div>
                                <div class="lira-trade-dock__hint">
                                    <i class="fa-solid fa-bolt"></i>
                                    Fast execution
                                </div>
                            </div>
                        </div>

                        <div class="lira-mobile-trade-panel">
                            <!-- ─── Expandable editor panels (hidden, triggered by tapping input row) ── -->
                            <div class="lira-mobile-editor-stack">
                                <div class="lira-mobile-editor-panel" id="mobileDurationPanel">
                                    <div class="lira-mobile-duration-columns">
                                        <div class="lira-mobile-duration-unit">
                                            <button type="button" class="lira-mobile-stepper is-down"
                                                data-duration-adjust="-1" data-unit="hours"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <strong id="mobileDurationHours">00</strong>
                                            <button type="button" class="lira-mobile-stepper" data-duration-adjust="1"
                                                data-unit="hours"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <span class="lira-mobile-duration-sep">:</span>
                                        <div class="lira-mobile-duration-unit">
                                            <button type="button" class="lira-mobile-stepper is-down"
                                                data-duration-adjust="-1" data-unit="minutes"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <strong id="mobileDurationMinutes">00</strong>
                                            <button type="button" class="lira-mobile-stepper" data-duration-adjust="1"
                                                data-unit="minutes"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <span class="lira-mobile-duration-sep">:</span>
                                        <div class="lira-mobile-duration-unit">
                                            <button type="button" class="lira-mobile-stepper is-down"
                                                data-duration-adjust="-1" data-unit="seconds"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <strong id="mobileDurationSecondsValue">03</strong>
                                            <button type="button" class="lira-mobile-stepper" data-duration-adjust="1"
                                                data-unit="seconds"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="lira-mobile-duration-presets">
                                        <button type="button" class="lira-mobile-duration-preset is-active"
                                            data-mobile-duration="3">S3</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="15">S15</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="30">S30</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="60">M1</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="180">M3</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="300">M5</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="1800">M30</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="3600">H1</button>
                                        <button type="button" class="lira-mobile-duration-preset"
                                            data-mobile-duration="14400">H4</button>
                                    </div>
                                </div>

                                <div class="lira-mobile-editor-panel" id="mobileAmountPanel">
                                    <div class="lira-mobile-amount-display">
                                        <strong id="mobileAmountEditorValue">50 USD</strong>
                                        <div class="lira-mobile-amount-display__steps">
                                            <button type="button" class="lira-mobile-stepper"
                                                data-amount-editor-step="10"><i class="fa-solid fa-plus"></i></button>
                                            <button type="button" class="lira-mobile-stepper is-down"
                                                data-amount-editor-step="-10"><i class="fa-solid fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="lira-mobile-keypad">
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="7">7</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="8">8</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="9">9</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="4">4</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="5">5</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="6">6</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="1">1</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="2">2</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="3">3</button>
                                        <button type="button" class="lira-mobile-keypad__key"
                                            data-amount-key="clear">C</button>
                                        <button type="button" class="lira-mobile-keypad__key" data-amount-key="0">0</button>
                                        <button type="button" class="lira-mobile-keypad__key is-backspace"
                                            data-amount-key="backspace"><i class="fa-solid fa-delete-left"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- ─── NEW: Reference-image-style compact layout ── -->
                            <div class="lira-ref-dock">
                                <!-- Unified input row -->
                                <div class="lira-ref-dock__input-row">
                                    <button type="button" class="lira-ref-dock__half" id="mobileAmountTrigger">
                                        <i class="fa-solid fa-dollar-sign lira-ref-dock__sym"></i>
                                        <span class="lira-ref-dock__val" id="mobileAmountDisplay">$50</span>
                                    </button>
                                    <div class="lira-ref-dock__divider"></div>
                                    <button type="button" class="lira-ref-dock__half" id="mobileDurationTrigger">
                                        <i class="fa-regular fa-clock lira-ref-dock__sym"></i>
                                        <span class="lira-ref-dock__val" id="mobileDurationDisplay">00:00:03</span>
                                    </button>
                                </div>

                                <!-- Profit / Payout row -->
                                <div class="lira-ref-dock__payout">
                                    <span>Profit <strong id="mobileProfitAmount">+$46</strong></span>
                                    <span class="lira-ref-dock__pct" id="mobilePayoutPercent">92%+</span>
                                    <span>Payout <strong id="mobilePayoutAmount">$96</strong></span>
                                </div>

                            </div>
                        </div>

                        <div class="lira-trade-form">

                            <!-- Hidden amount input that JS depends on -->
                            <input type="number" id="tradeAmountInput" min="1" step="1" value="50" style="display:none;">

                            <!-- ── Two-column top deck: Amount | Time ── -->
                            <div class="lira-desk-top-deck">
                                <!-- Amount card -->
                                <div class="lira-desk-input-card lira-desk-input-card--amount" data-mobile-editor-trigger="amount" role="button" tabindex="0">
                                    <span class="lira-desk-input-card__label">المبلغ <i class="fa-regular fa-circle-question lira-desk-input-card__help" aria-hidden="true"></i></span>
                                    <div class="lira-desk-input-card__value">
                                        <span class="lira-desk-input-card__icon lira-desk-input-card__currency">$</span>
                                        <input type="number" id="tradeAmountDisplay" min="1" step="1" value="50" readonly tabindex="-1" aria-hidden="true">
                                        <span class="lira-desk-input-card__unit">USD</span>
                                    </div>
                                    <div class="lira-desk-stepper-row">
                                        <button type="button" class="lira-stepper-btn" data-amount-step="-10"><i
                                                class="fa-solid fa-minus"></i></button>
                                        <div class="lira-amount-quick" style="flex:1;margin-top:0;display:flex;gap:4px;">
                                            <button type="button" class="lira-amount-chip" data-amount="10">$10</button>
                                            <button type="button" class="lira-amount-chip" data-amount="50">$50</button>
                                            <button type="button" class="lira-amount-chip" data-amount="100">$100</button>
                                            <button type="button" class="lira-amount-chip" data-amount="500">$500</button>
                                        </div>
                                        <button type="button" class="lira-stepper-btn" data-amount-step="10"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>

                                <!-- Time card (HH:MM:SS spinner) -->
                                <div class="lira-desk-input-card lira-desk-input-card--duration" data-mobile-editor-trigger="duration" role="button" tabindex="0">
                                    <span class="lira-desk-input-card__label">الزمن <i class="fa-regular fa-circle-question lira-desk-input-card__help" aria-hidden="true"></i></span>
                                    <div class="lira-desk-input-card__value lira-desk-input-card__value--duration">
                                        <i class="fa-regular fa-clock lira-desk-input-card__icon"></i>
                                        <span class="lira-desk-duration-display" id="deskDurationDisplay">00:00:03</span>
                                    </div>
                                    <div class="lira-duration-spinner">
                                        <div class="lira-duration-unit">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="-3600"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="deskDurationHours" value="00" min="0" max="23">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="3600"><i
                                                    class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <span class="lira-duration-sep">:</span>
                                        <div class="lira-duration-unit">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="-60"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="deskDurationMinutes" value="00" min="0" max="59">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="60"><i
                                                    class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <span class="lira-duration-sep">:</span>
                                        <div class="lira-duration-unit">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="-1"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="deskDurationSecondsValue" value="03" min="0" max="59">
                                            <button type="button" class="lira-stepper-btn" data-desk-dur-adj="1"><i
                                                    class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="lira-desk-duration-presets">
                                        <button type="button" class="lira-duration-chip" data-seconds="3">S3</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="15">S15</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="30">S30</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="60">M1</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="180">M3</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="300">M5</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="600">M10</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="900">M15</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="1800">M30</button>
                                        <button type="button" class="lira-duration-chip" data-seconds="3600">H1</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden legacy duration fields JS needs -->
                            <div style="display:none;">
                                <button type="button" id="customDurationBtn"></button>
                                <input type="number" id="customDurationInput" value="3">
                            </div>

                            <!-- ── Payout strip ── -->
                            <div class="lira-desk-payout-strip">
                                <div>
                                    <span>Your Profit</span>
                                    <strong id="profitValue">+$46.00</strong>
                                </div>
                                <strong class="lira-payout-highlight" id="payoutPct">92%+</strong>
                                <div style="text-align:right;">
                                    <span>Total Payout</span>
                                    <strong id="tradeAmountMirror">$96.00</strong>
                                </div>
                            </div>

                            <!-- ── Sell | Buy buttons ── -->
                            <div class="lira-trade-field lira-trade-field--actions" style="margin-top:10px;">
                                <div class="lira-trade-actions">
                                    <button type="button" class="lira-order-btn is-sell" id="sellTradeBtn">
                                        <i class="fa-solid fa-arrow-down"></i>
                                        <strong>Sell Down</strong>
                                    </button>
                                    <button type="button" class="lira-order-btn is-buy" id="buyTradeBtn">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        <strong>Buy Up</strong>
                                    </button>
                                </div>
                            </div>

                        </div>
                        
                        <div class="lira-trade-payout" style="display: none !important;">
                            <div class="lira-payout-card">
                                <span>Amount</span>
                                <strong id="tradeAmountMirror">$50.00</strong>
                            </div>

                            <div class="lira-payout-card">
                                <span>Payout</span>
                                <strong class="is-positive" id="payoutPct">+92%</strong>
                            </div>

                            <div class="lira-payout-card">
                                <span>Profit</span>
                                <strong class="is-positive" id="profitValue">+$46.00</strong>
                            </div>
                        </div>

                        <div class="lira-trade-sentiment" style="display: none !important;">
                            <span id="buySentimentValue">50%</span>
                            <div class="lira-trade-sentiment__track">
                                <span class="lira-trade-sentiment__fill" id="tradeSentimentFill"></span>
                            </div>
                            <span id="sellSentimentValue">50%</span>
                        </div>

                        <div class="lira-mobile-action-bar">
                            <button type="button" class="lira-order-btn lira-order-btn--mobile is-sell"
                                id="sellTradeBtnMobile">
                                <i class="fa-solid fa-arrow-trend-down"></i>
                                <div class="lira-order-btn-text">
                                    <span>Sell</span>
                                    <strong>Down</strong>
                                </div>
                            </button>

                            <button type="button" class="lira-order-btn lira-order-btn--mobile is-buy"
                                id="buyTradeBtnMobile">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                                <div class="lira-order-btn-text">
                                    <span>Buy</span>
                                    <strong>Up</strong>
                                </div>
                            </button>
                        </div>

                        <div class="lira-trade-summary" style="display: none !important;">
                            <div class="lira-trade-mini-stat">
                                <span>Open Trades</span>
                                <strong id="openTradesCount">0</strong>
                            </div>

                            <div class="lira-trade-mini-stat">
                                <span>Winning Trades</span>
                                <strong id="winTradesCount">0</strong>
                            </div>

                            <div class="lira-trade-mini-stat">
                                <span>Net P/L</span>
                                <strong id="tradePnlValue">$0.00</strong>
                            </div>
                        </div>

                        <div class="lira-trade-list" id="tradePositionsList" style="display: none !important;">
                            <div class="lira-empty-trades">No open trades yet. Your active positions will appear here.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lira-bottom-nav lira-trading-bottom-nav">
                @foreach ($tradingBottomNav as $item)
                    <a href="{{ $item['href'] }}"
                        class="lira-bottom-nav-item {{ $item['tablet_only'] ? 'is-tablet-only ' : '' }}{{ $item['active'] ? 'active' : '' }}">
                        <x-niro-icon name="{{ $item['icon'] }}" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Quick Fund Trading Modal -->
    <div class="modal fade lira-modal-premium" id="fundTradingModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 10000; max-width: 440px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">شحن رصيد التداول</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Current balance preview -->
                    <div class="lira-balance-preview mb-4">
                        <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">رصيد الحساب الأساسي</span>
                        <strong class="h3 mb-0 text-white font-monospace" id="mainWalletBalanceDisplay">{{ formatCurrency($user->deposit_balance) }}</strong>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label small text-muted fw-bold mb-3 d-block">المبلغ المراد تحويله</label>
                        
                        <div class="lira-amount-input-wrap mb-3">
                            <input type="number" id="fundAmount" class="form-control" placeholder="0.00">
                            <div class="text-center mt-1">
                                <span class="text-muted small">$ USD</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <button type="button" class="btn lira-amount-pill" onclick="document.getElementById('fundAmount').value = 10">10$</button>
                            <button type="button" class="btn lira-amount-pill" onclick="document.getElementById('fundAmount').value = 50">50$</button>
                            <button type="button" class="btn lira-amount-pill" onclick="document.getElementById('fundAmount').value = 100">100$</button>
                            <button type="button" class="btn lira-amount-pill" onclick="document.getElementById('fundAmount').value = 500">500$</button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary w-100 py-3 fw-bold rounded-4 shadow-lg" id="confirmFundBtn" onclick="transferToTrading()">
                            <i class="fa-solid fa-arrow-right-arrow-left me-2"></i> تأكيد التحويل الآن
                        </button>
                    </div>

                    <div class="mt-4 p-3 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.04);">
                        <div class="d-flex align-items-center gap-3 text-muted">
                            <i class="fa-solid fa-circle-info text-primary"></i>
                            <p class="small mb-0">
                                سيتم نقل الأموال من محفظة الإيداع إلى رصيد التداول بشكل فوري وبدون أي رسوم.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('custom_scripts')
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script>
        // ─── Global Wallet Functions ────────────────────────────────
        async function transferToTrading() {
            if (@json($isDemoAccount)) {
                if (window.showNotification) {
                    window.showNotification('الحساب التجريبي لا يمكنه تنفيذ عمليات مالية. يرجى إنشاء حساب حقيقي أو تسجيل الدخول بحساب حقيقي.', 'warning');
                }
                return;
            }

            const amountInput = document.getElementById('fundAmount');
            if (!amountInput) return;
            
            const amount = amountInput.value;
            if (!amount || amount < 1) {
                if (typeof showNotification === 'function') {
                    showNotification('يرجى إدخال مبلغ صحيح', 'error');
                } else {
                    alert('يرجى إدخال مبلغ صحيح');
                }
                return;
            }

            const btn = document.getElementById('confirmFundBtn');
            if (!btn) return;

            const originalText = btn.innerText;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري التحويل...';

            try {
                console.log('Sending transfer request for amount:', amount);
                const response = await fetch('{{ route('site.trading.fund') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ amount: amount })
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    console.error('Server error:', errorData);
                    if (window.showNotification) {
                        window.showNotification(errorData.message || 'حدث خطأ في الخادم (Error ' + response.status + ')', 'error');
                    } else {
                        alert(errorData.message || 'Error ' + response.status);
                    }
                    return;
                }

                const data = await response.json();
                console.log('Transfer data received:', data);

                if (data.success) {
                    accountBalances.real = Number(String(data.trading_balance).replace(/,/g, '')) || accountBalances.real;
                    if (activeAccountMode === 'real') {
                        updateDisplayedTradingBalance(accountBalances.real);
                    }
                    
                    const mainBalEl = document.getElementById('mainWalletBalanceDisplay');
                    if (mainBalEl) mainBalEl.innerText = '$' + data.wallet_balance;

                    // Close Modal using native BS5
                    const modalEl = document.getElementById('fundTradingModal');
                    if (modalEl && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modalInstance.hide();
                    }

                    // Force remove backdrop if it gets stuck
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.paddingRight = '';

                    if (window.showNotification) {
                        window.showNotification(data.message || 'تمت العملية بنجاح', 'success');
                    } else {
                        alert(data.message || 'Success');
                    }
                } else {
                    console.warn('Transfer failed:', data.message);
                    if (window.showNotification) {
                        window.showNotification(data.message || 'فشل التحويل', 'error');
                    } else {
                        alert(data.message || 'Failed');
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
                if (window.showNotification) {
                    window.showNotification('حدث خطأ أثناء الاتصال بالخادم', 'error');
                } else {
                    alert('Network error');
                }
            } finally {
                btn.disabled = false;
                btn.innerText = originalText;
            }
        }
        window.transferToTrading = transferToTrading;

        document.addEventListener('DOMContentLoaded', async function () {
            const chartHost = document.getElementById('tradeChart');
            if (!chartHost || typeof LightweightCharts === 'undefined') return;

            const {
                createChart,
                CrosshairMode,
                LineStyle,
                CandlestickSeries,
            } = LightweightCharts;

            const defaultSymbol = @json($defaultTradingSymbolKey);
            const symbolMap = @json($tradingSymbols);
            const isDemoAccount = @json($isDemoAccount);
            const accountBalances = {
                real: Number(@json($realTradingBalance)),
                demo: Number(@json($demoTradingBalance)),
            };
            const syntheticDefaults = {
                historyVolatility: 0.00090,
                runtimeVolatility: 0.00280,
                spreadFactor: 0.00045,
                meanPull: 0.15,
                driftMultiplier: 2.50,
            };

            const timeframeConfig = {
                '5s': { id: '5s', label: 'S5', candleMs: 5000, binanceInterval: null, syntheticRuntimeMs: 4600 },
                '10s': { id: '10s', label: 'S10', candleMs: 10000, binanceInterval: null, syntheticRuntimeMs: 7600 },
                '15s': { id: '15s', label: 'S15', candleMs: 15000, binanceInterval: null, syntheticRuntimeMs: 10800 },
                '30s': { id: '30s', label: 'S30', candleMs: 30000, binanceInterval: null, syntheticRuntimeMs: 16500 },
                '1m': { id: '1m', label: 'M1', candleMs: 60000, binanceInterval: '1m', syntheticRuntimeMs: 24500 },
                '2m': { id: '2m', label: 'M2', candleMs: 120000, binanceInterval: null, syntheticRuntimeMs: 32000 },
                '3m': { id: '3m', label: 'M3', candleMs: 180000, binanceInterval: '3m', syntheticRuntimeMs: 40500 },
                '5m': { id: '5m', label: 'M5', candleMs: 300000, binanceInterval: '5m', syntheticRuntimeMs: 52000 },
                '10m': { id: '10m', label: 'M10', candleMs: 600000, binanceInterval: null, syntheticRuntimeMs: 62000 },
                '15m': { id: '15m', label: 'M15', candleMs: 900000, binanceInterval: '15m', syntheticRuntimeMs: 72000 },
                '30m': { id: '30m', label: 'M30', candleMs: 1800000, binanceInterval: '30m', syntheticRuntimeMs: 85000 },
                '1h': { id: '1h', label: 'H1', candleMs: 3600000, binanceInterval: '1h', syntheticRuntimeMs: 98000 },
                '4h': { id: '4h', label: 'H4', candleMs: 14400000, binanceInterval: '4h', syntheticRuntimeMs: 116000 },
                '1d': { id: '1d', label: 'D1', candleMs: 86400000, binanceInterval: '1d', syntheticRuntimeMs: 138000 },
            };

            const priceEl = document.getElementById('goldSpotPrice');
            const changeEl = document.getElementById('goldPriceChange');
            const hoveredPriceEl = document.getElementById('goldHoveredPrice');
            const hoveredTimeEl = document.getElementById('goldHoveredTime');
            const rangeEl = document.getElementById('goldRangeText');
            const marketEl = document.getElementById('marketLabel');
            const tradeAmountInput = document.getElementById('tradeAmountInput');
            const tradeAmountMirror = document.getElementById('tradeAmountMirror');
            const buyTradeBtn = document.getElementById('buyTradeBtn');
            const sellTradeBtn = document.getElementById('sellTradeBtn');
            const buyTradeBtnMobile = document.getElementById('buyTradeBtnMobile');
            const sellTradeBtnMobile = document.getElementById('sellTradeBtnMobile');
            const tradePositionsList = document.getElementById('tradePositionsList');
            const openTradesCountEl = document.getElementById('openTradesCount');
            const winTradesCountEl = document.getElementById('winTradesCount');
            const tradePnlValueEl = document.getElementById('tradePnlValue');
            const tradeModePill = document.getElementById('tradeModePill');
            const payoutPctEl = document.getElementById('payoutPct');
            const profitValueEl = document.getElementById('profitValue');
            const tradeSentimentFill = document.getElementById('tradeSentimentFill');
            const buySentimentValueEl = document.getElementById('buySentimentValue');
            const sellSentimentValueEl = document.getElementById('sellSentimentValue');
            const fsTarget = document.getElementById('chartFullscreenTarget');
            const fsBtn = document.getElementById('toggleFullscreenBtn');
            const customDurationBtn = document.getElementById('customDurationBtn');
            const customDurationInput = document.getElementById('customDurationInput');
            const drawMenuToggle = document.getElementById('drawMenuToggle');
            const drawMenu = document.getElementById('drawMenu');
            const drawMenuBackdrop = document.getElementById('drawMenuBackdrop');
            const drawMenuCloseBtn = document.getElementById('drawMenuCloseBtn');
            const activeToolLabel = document.getElementById('activeToolLabel');
            const drawingsCountLabel = document.getElementById('drawingsCountLabel');
            const drawingsCountBadge = document.getElementById('drawingsCountBadge');
            const drawLayer = document.getElementById('tradeDrawLayer');
            const tooltipEl = document.getElementById('tradeTooltip');
            const symbolTabs = document.querySelectorAll('.lira-symbol-tab');
            const timeframeBtns = document.querySelectorAll('.lira-timeframe-chip');
            const durationChips = document.querySelectorAll('.lira-duration-chip[data-seconds]');
            const amountStepButtons = document.querySelectorAll('[data-amount-step]');
            const amountQuickButtons = document.querySelectorAll('.lira-amount-chip');
            const mobileSymbolLabel = document.getElementById('mobileSymbolLabel');
            const mobileSymbolButton = document.getElementById('mobileSymbolButton');
            const mobileSymbolMenu = document.getElementById('mobileSymbolMenu');
            const mobileSymbolOptions = document.querySelectorAll('.lira-mobile-symbol-option');
            const mobileTimeframeTrigger = document.getElementById('mobileTimeframeTrigger');
            const mobileTimeframeModal = document.getElementById('mobileTimeframeModal');
            const mobileTimeframeSheetTitle = document.getElementById('mobileTimeframeSheetTitle');
            const mobileTimeframeOptions = document.querySelectorAll('.lira-interval-option');
            const mobileWalletShortcut = document.getElementById('mobileWalletShortcut');
            const mobileBalanceChip = document.getElementById('mobileBalanceChip');
            const mobileBalanceValue = document.getElementById('mobileBalanceValue');
            const mobileToolsButton = document.getElementById('mobileToolsButton');
            const mobilePairPrice = document.getElementById('mobilePairPrice');
            const mobilePairTime = document.getElementById('mobilePairTime');
            const mobileExpiryTime = document.getElementById('mobileExpiryTime');
            const mobileChartFrameValue = document.getElementById('mobileChartFrameValue');
            const mobileDurationDisplay = document.getElementById('mobileDurationDisplay');
            const mobileAmountDisplay = document.getElementById('mobileAmountDisplay');
            const mobilePayoutAmount = document.getElementById('mobilePayoutAmount');
            const mobilePayoutPercent = document.getElementById('mobilePayoutPercent');
            const mobileProfitAmount = document.getElementById('mobileProfitAmount');
            const mobileDurationTrigger = document.getElementById('mobileDurationTrigger');
            const mobileAmountTrigger = document.getElementById('mobileAmountTrigger');
            const mobileDurationPanel = document.getElementById('mobileDurationPanel');
            const mobileAmountPanel = document.getElementById('mobileAmountPanel');
            const mobileDurationHours = document.getElementById('mobileDurationHours');
            const mobileDurationMinutes = document.getElementById('mobileDurationMinutes');
            const mobileDurationSecondsValue = document.getElementById('mobileDurationSecondsValue');
            const mobileAmountEditorValue = document.getElementById('mobileAmountEditorValue');
            const mobileDurationAdjustButtons = document.querySelectorAll('[data-duration-adjust]');
            const mobileDurationPresetButtons = document.querySelectorAll('[data-mobile-duration]');
            const mobileAmountEditorStepButtons = document.querySelectorAll('[data-amount-editor-step]');
            const mobileAmountKeyButtons = document.querySelectorAll('[data-amount-key]');
            const desktopEditorTriggers = document.querySelectorAll('[data-mobile-editor-trigger]');
            const mobileTradePanel = document.querySelector('#tradeDock .lira-mobile-trade-panel');

            const ctx = drawLayer.getContext('2d');
            const payoutRatio = 0.92;

            let currentSymbol = defaultSymbol;
            let activeAccountMode = @json($initialTradingMode);
            let activeInterval = '5m';
            let bars = [];
            let currentTool = 'cursor';
            let followLive = true;
            let socket = null;
            let syntheticTimer = null;
            let livePulseTimer = null;
            let syntheticMode = false;
            let tradeDurationSeconds = 3;
            let tradeId = 1;
            let trades = [];
            let closedTrades = [];
            let priceLines = new Map();
            let drawings = [];
            let draftDrawing = null;
            let pointer = null;
            let selectedDrawingIndex = -1;
            let dragTarget = null;
            let dragStartPoint = null;
            let dragSnapshot = null;
            let isDraggingDrawing = false;
            let syntheticBarOpenedAtMs = 0;
            let syntheticLastPrice = null;
            let livePulsePrice = null;
            let liveLastServerTickAt = 0;
            let barAnimationFrame = null;
            let isPlacingTrade = false;
            let openMobileEditor = null;
            let activeDesktopEditorTrigger = null;
            let amountEditorBuffer = String(Math.max(1, Math.floor(Number(tradeAmountInput?.value || 50))));
            let chart;
            let candleSeries;
            let resizeObserver;
            let rebuildToken = 0;
            let reconnectTimer = null;

            function formatNum(n, digits = 2) {
                return Number(n).toLocaleString('en-US', {
                    minimumFractionDigits: digits,
                    maximumFractionDigits: digits,
                });
            }

            function formatUsd(value, digits = 2, signed = false) {
                const numericValue = Number(value) || 0;
                const amount = Math.abs(numericValue);
                const prefix = signed
                    ? (numericValue > 0 ? '+' : numericValue < 0 ? '-' : '')
                    : '';

                return `${prefix}$${formatNum(amount, digits)}`;
            }

            function updateDisplayedTradingBalance(balance = accountBalances[activeAccountMode]) {
                accountBalances[activeAccountMode] = Number(balance) || 0;

                document.querySelectorAll('#mobileBalanceValue, #desktopBalanceValue, #topNavBalanceValue').forEach(el => {
                    el.innerText = formatUsd(accountBalances[activeAccountMode]);
                });

                const mobileModeLabel = document.getElementById('mobileBalanceModeLabel');
                if (mobileModeLabel) {
                    mobileModeLabel.innerText = `QT ${activeAccountMode === 'demo' ? 'Demo' : 'Real'}`;
                }

                document.querySelectorAll('[data-trade-account-mode]').forEach(button => {
                    button.classList.toggle('is-active', button.dataset.tradeAccountMode === activeAccountMode);
                });
            }

            function setAccountMode(mode) {
                const nextMode = mode === 'demo' ? 'demo' : 'real';

                if (isDemoAccount && nextMode === 'real') {
                    if (window.showNotification) {
                        window.showNotification('الحساب التجريبي يمكنه التداول التجريبي فقط. افتح حساباً حقيقياً لاستخدام الرصيد الحقيقي.', 'warning');
                    }
                    return;
                }

                activeAccountMode = nextMode;
                updateDisplayedTradingBalance();
            }

            function formatTime(ts) {
                return new Date(ts * 1000).toLocaleString('en-GB', {
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                });
            }

            function formatChartClock(ts) {
                return new Date(ts * 1000).toLocaleTimeString('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                });
            }

            function formatRemaining(seconds) {
                const total = Math.max(0, Math.ceil(seconds));
                const minutes = Math.floor(total / 60);
                const secs = total % 60;
                return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            function formatDuration(seconds) {
                if (seconds < 60) return `${seconds}s`;
                if (seconds >= 3600) return `${Math.round(seconds / 3600)}h`;
                return `${Math.round(seconds / 60)}m`;
            }

            function formatClockDuration(seconds) {
                const total = Math.max(0, Math.floor(seconds));
                const hours = Math.floor(total / 3600);
                const minutes = Math.floor((total % 3600) / 60);
                const secs = total % 60;
                return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            function formatExpiryTime(timestamp) {
                return new Date(timestamp).toLocaleTimeString('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                });
            }

            function getSymbolConfig(symbol = currentSymbol) {
                return symbolMap[symbol] || symbolMap[defaultSymbol];
            }

            function getSymbolSyntheticConfig(symbol = currentSymbol) {
                return {
                    ...syntheticDefaults,
                    ...(getSymbolConfig(symbol).synthetic || {}),
                };
            }

            function getTimeframeConfig(interval = activeInterval) {
                return timeframeConfig[interval] || timeframeConfig['5m'];
            }

            function getSymbolLabel(symbol = currentSymbol) {
                return getSymbolConfig(symbol).label;
            }

            function getTimeframeLabel(interval = activeInterval) {
                return getTimeframeConfig(interval).label;
            }

            function getSymbolPrecision(symbol = currentSymbol) {
                return getSymbolConfig(symbol).precision ?? 2;
            }

            function normalizePrice(value, symbol = currentSymbol) {
                return +Number(value).toFixed(getSymbolPrecision(symbol));
            }

            function intervalToMs(interval) {
                return getTimeframeConfig(interval).candleMs;
            }

            function getStreamInterval(interval = activeInterval) {
                return getTimeframeConfig(interval).binanceInterval;
            }

            function getSyntheticRuntimeMs(interval = activeInterval) {
                return getTimeframeConfig(interval).syntheticRuntimeMs;
            }

            function toBar(kline, symbol = currentSymbol) {
                return {
                    time: Math.floor(kline[0] / 1000),
                    open: normalizePrice(kline[1], symbol),
                    high: normalizePrice(kline[2], symbol),
                    low: normalizePrice(kline[3], symbol),
                    close: normalizePrice(kline[4], symbol),
                };
            }

            function normalizeBar(bar, symbol = currentSymbol) {
                return {
                    time: Math.floor(bar.time),
                    open: normalizePrice(bar.open, symbol),
                    high: normalizePrice(bar.high, symbol),
                    low: normalizePrice(bar.low, symbol),
                    close: normalizePrice(bar.close, symbol),
                };
            }

            function getBaseSyntheticPrice(symbol) {
                return getSymbolConfig(symbol).basePrice || 2000;
            }

            function syncAmountQuickButtons(amount) {
                amountQuickButtons.forEach(button => {
                    button.classList.toggle('active', Number(button.dataset.amount || 0) === amount);
                });
            }

            function syncSymbolButtons() {
                symbolTabs.forEach(button => {
                    button.classList.toggle('active', button.dataset.symbol === currentSymbol);
                });

                mobileSymbolOptions.forEach(button => {
                    button.classList.toggle('is-active', button.dataset.symbol === currentSymbol);
                });

                mobileSymbolLabel.textContent = getSymbolLabel();
                marketEl.textContent = getSymbolConfig().name;
            }

            function hasOpenTradesForOtherMarkets(nextSymbol) {
                return trades.some(t => t.symbol !== nextSymbol);
            }

            function selectSymbol(symbol) {
                if (!symbolMap[symbol]) return;

                if (hasOpenTradesForOtherMarkets(symbol)) {
                    showNotification('أغلق الصفقات المفتوحة أولاً قبل الانتقال إلى سوق آخر.', 'error');
                    return;
                }

                setSymbolMenuOpen(false);

                if (symbol === currentSymbol) {
                    syncSymbolButtons();
                    return;
                }

                currentSymbol = symbol;
                syncSymbolButtons();
                rebuild();
            }

            function syncTimeframeUi() {
                timeframeBtns.forEach(button => {
                    button.classList.toggle('active', button.dataset.interval === activeInterval);
                });

                mobileTimeframeOptions.forEach(button => {
                    button.classList.toggle('is-active', button.dataset.interval === activeInterval);
                });

                if (mobileChartFrameValue) mobileChartFrameValue.textContent = getTimeframeLabel();
                if (mobileTimeframeSheetTitle) mobileTimeframeSheetTitle.textContent = `Time frames (${getTimeframeLabel()})`;

                if (chart) {
                    const candleMs = intervalToMs(activeInterval);
                    chart.applyOptions({
                        timeScale: {
                            secondsVisible: candleMs < 60000,
                            barSpacing: candleMs < 60000 ? 10 : candleMs >= 3600000 ? 12 : 9,
                            minBarSpacing: candleMs < 60000 ? 5 : 4,
                        },
                    });
                }
            }

            function syncMobileDurationEditor() {
                const total = Math.max(3, Math.floor(tradeDurationSeconds));
                const hours = Math.floor(total / 3600);
                const minutes = Math.floor((total % 3600) / 60);
                const seconds = total % 60;

                mobileDurationHours.textContent = String(hours).padStart(2, '0');
                mobileDurationMinutes.textContent = String(minutes).padStart(2, '0');
                mobileDurationSecondsValue.textContent = String(seconds).padStart(2, '0');

                mobileDurationPresetButtons.forEach(button => {
                    button.classList.toggle('is-active', Number(button.dataset.mobileDuration || 0) === total);
                });
            }

            function syncAmountEditorDisplay() {
                const hasBuffer = amountEditorBuffer !== '';
                const bufferValue = Math.max(0, Math.floor(Number(amountEditorBuffer || 0)));
                const currentAmount = Math.max(1, Math.floor(Number(tradeAmountInput.value || 0)));
                const amount = hasBuffer ? bufferValue : currentAmount;

                mobileAmountEditorValue.textContent = amount > 0 ? formatUsd(amount, 0) : '$0';
            }

            function setSymbolMenuOpen(isOpen) {
                mobileSymbolMenu?.classList.toggle('is-open', isOpen);
                mobileSymbolButton?.classList.toggle('is-open', isOpen);
            }

            function setTimeframeModalOpen(isOpen) {
                mobileTimeframeModal?.classList.toggle('is-open', isOpen);
                mobileTimeframeTrigger?.classList.toggle('is-open', isOpen);
            }

            function isDesktopEditorPopover() {
                return window.matchMedia('(min-width: 1025px)').matches;
            }

            function positionDesktopEditorPopover(trigger = activeDesktopEditorTrigger) {
                if (!trigger || !mobileTradePanel || !isDesktopEditorPopover()) return;

                const panelWidth = Math.min(344, Math.max(280, window.innerWidth - 28));
                const panelHeight = openMobileEditor === 'amount' ? 326 : 244;
                const triggerRect = trigger.getBoundingClientRect();
                const gap = 12;
                const margin = 14;

                let left = triggerRect.right + gap;
                if (left + panelWidth > window.innerWidth - margin) {
                    left = Math.max(margin, triggerRect.left - panelWidth - gap);
                }

                let top = triggerRect.top - 6;
                top = Math.max(margin, Math.min(top, window.innerHeight - panelHeight - margin));

                const arrowTop = Math.max(18, Math.min(54, triggerRect.top + (triggerRect.height / 2) - top - 6));

                mobileTradePanel.style.setProperty('--lira-editor-popover-left', `${left}px`);
                mobileTradePanel.style.setProperty('--lira-editor-popover-top', `${top}px`);
                mobileTradePanel.style.setProperty('--lira-editor-arrow-top', `${arrowTop}px`);
            }

            function setMobileEditorOpen(name = null) {
                openMobileEditor = name;

                mobileDurationPanel?.classList.toggle('is-open', name === 'duration');
                mobileAmountPanel?.classList.toggle('is-open', name === 'amount');
                mobileDurationTrigger?.classList.toggle('is-open', name === 'duration');
                mobileAmountTrigger?.classList.toggle('is-open', name === 'amount');
                desktopEditorTriggers.forEach(trigger => {
                    trigger.classList.toggle('is-open', trigger.dataset.mobileEditorTrigger === name);
                });

                if (name === 'amount') {
                    amountEditorBuffer = String(Math.max(1, Math.floor(Number(tradeAmountInput.value || 0))));
                    syncAmountEditorDisplay();
                }

                if (name && activeDesktopEditorTrigger) {
                    positionDesktopEditorPopover(activeDesktopEditorTrigger);
                } else if (!name) {
                    activeDesktopEditorTrigger = null;
                }
            }

            function toggleMobileEditor(name) {
                setMobileEditorOpen(openMobileEditor === name ? null : name);
            }

            function closeMobileEditors() {
                setMobileEditorOpen(null);
            }

            function setTradeAmount(value, options = {}) {
                const amount = Math.max(1, Math.floor(Number(value || 0)));

                tradeAmountInput.value = String(amount);

                if (!options.keepBuffer) {
                    amountEditorBuffer = String(amount);
                }

                updatePayoutUI();
                return amount;
            }

            function updateAmountEditorBuffer(value) {
                const raw = String(value ?? '').replace(/[^\d]/g, '');
                amountEditorBuffer = raw.replace(/^0+(?=\d)/, '');

                const nextAmount = Math.floor(Number(amountEditorBuffer || 0));
                if (nextAmount > 0) {
                    setTradeAmount(nextAmount, { keepBuffer: true });
                    return;
                }

                syncAmountEditorDisplay();
            }

            function updatePayoutUI() {
                const amountInput = document.getElementById('tradeAmountInput');
                const amount = Math.max(1, Math.floor(Number(amountInput.value || 0)));
                const profit = amount * payoutRatio;
                const payoutTotal = amount + profit;

                // Sync base input
                amountInput.value = String(amount);

                // Sync Desktop UI
                const deskAmountDisplay = document.getElementById('tradeAmountDisplay');
                if (deskAmountDisplay) deskAmountDisplay.value = String(amount);

                const deskProfitEl = document.getElementById('profitValue');
                if (deskProfitEl) deskProfitEl.textContent = formatUsd(profit, 2, true);

                const deskPayoutPctEl = document.getElementById('payoutPct');
                if (deskPayoutPctEl) deskPayoutPctEl.textContent = `${Math.round(payoutRatio * 100)}%+`;

                const deskPayoutMirror = document.getElementById('tradeAmountMirror');
                if (deskPayoutMirror) deskPayoutMirror.textContent = formatUsd(payoutTotal, 0);

                // Sync Mobile UI
                const mobAmountDisplay = document.getElementById('mobileAmountDisplay');
                if (mobAmountDisplay) mobAmountDisplay.textContent = formatUsd(amount, 0);

                const mobProfitEl = document.getElementById('mobileProfitAmount');
                if (mobProfitEl) mobProfitEl.textContent = formatUsd(profit, 0, true);

                const mobPayoutPctEl = document.getElementById('mobilePayoutPercent');
                if (mobPayoutPctEl) mobPayoutPctEl.textContent = `${Math.round(payoutRatio * 100)}%+`;

                const mobPayoutAmountEl = document.getElementById('mobilePayoutAmount');
                if (mobPayoutAmountEl) mobPayoutAmountEl.textContent = formatUsd(payoutTotal, 0);

                // Sync amount editor buffer if not active
                if (openMobileEditor !== 'amount') {
                    amountEditorBuffer = String(amount);
                }
                syncAmountEditorDisplay();
                syncAmountQuickButtons(amount);
            }

            function navigateFromButton(button) {
                const href = button?.dataset?.href;
                if (href) {
                    window.location.href = href;
                }
            }

            function updateMobileTradeMeta() {
                if (mobileDurationDisplay) mobileDurationDisplay.textContent = formatClockDuration(tradeDurationSeconds);
                if (mobileExpiryTime) mobileExpiryTime.textContent = formatExpiryTime(Date.now() + (tradeDurationSeconds * 1000));
                syncMobileDurationEditor();
            }

            function syncDesktopDurationUi() {
                const presetChip = Array.from(durationChips).find(button => {
                    return Number(button.dataset.seconds || 0) === tradeDurationSeconds;
                });

                if (customDurationInput) customDurationInput.value = String(tradeDurationSeconds);
                setActiveDurationChip(presetChip || customDurationBtn);

                const dh = document.getElementById('deskDurationHours');
                if (dh) {
                    const total = Math.max(3, Math.floor(tradeDurationSeconds));
                    dh.value = String(Math.floor(total / 3600)).padStart(2, '0');
                    document.getElementById('deskDurationMinutes').value = String(Math.floor((total % 3600) / 60)).padStart(2, '0');
                    document.getElementById('deskDurationSecondsValue').value = String(total % 60).padStart(2, '0');
                }

                const desktopDurationDisplay = document.getElementById('deskDurationDisplay');
                if (desktopDurationDisplay) {
                    desktopDurationDisplay.textContent = formatClockDuration(tradeDurationSeconds);
                }
            }

            function applyTradeDuration(seconds) {
                tradeDurationSeconds = Math.max(3, Math.floor(Number(seconds || 3)));
                syncDesktopDurationUi();
                updateMobileTradeMeta();
                return tradeDurationSeconds;
            }

            function applyChartInterval(interval) {
                if (!timeframeConfig[interval]) return;

                setTimeframeModalOpen(false);

                if (interval === activeInterval) {
                    syncTimeframeUi();
                    return;
                }

                activeInterval = interval;
                syncTimeframeUi();
                rebuild();
            }

            function updateSentiment(data = bars) {
                const sample = data.slice(-20);

                if (!sample.length) {
                    tradeSentimentFill.style.width = '50%';
                    buySentimentValueEl.textContent = '50%';
                    sellSentimentValueEl.textContent = '50%';
                    return;
                }

                const bullish = sample.filter(bar => bar.close >= bar.open).length;
                const buyPct = Math.max(5, Math.min(95, Math.round((bullish / sample.length) * 100)));
                const sellPct = 100 - buyPct;

                tradeSentimentFill.style.width = `${buyPct}%`;
                buySentimentValueEl.textContent = `${buyPct}%`;
                sellSentimentValueEl.textContent = `${sellPct}%`;
            }

            function updateTopMeta(data) {
                if (!data.length) return;

                const first = data[0].open;
                const last = data[data.length - 1].close;
                const diff = last - first;
                const pct = first ? (diff / first) * 100 : 0;
                const high = Math.max(...data.map(item => item.high));
                const low = Math.min(...data.map(item => item.low));

                const precision = getSymbolPrecision();

                priceEl.textContent = formatNum(last, precision);
                changeEl.className = pct >= 0 ? 'is-up' : 'is-down';
                changeEl.textContent = `${diff >= 0 ? '+' : ''}${formatNum(diff, precision)} (${pct >= 0 ? '+' : ''}${pct.toFixed(2)}%)`;
                rangeEl.textContent = `${formatNum(low, precision)} - ${formatNum(high, precision)}`;
                mobilePairPrice.textContent = formatNum(last, precision);
                mobilePairTime.textContent = `${formatChartClock(data[data.length - 1].time)} UTC+2`;
                syncSymbolButtons();

                updateSentiment(data);
            }

            function setHovered(bar) {
                if (!bar) return;
                const precision = getSymbolPrecision();

                hoveredPriceEl.textContent = formatNum(bar.close, precision);
                hoveredTimeEl.textContent = formatTime(bar.time);
                mobilePairPrice.textContent = formatNum(bar.close, precision);
                mobilePairTime.textContent = `${formatChartClock(bar.time)} UTC+2`;
            }

            function setTradeModePill() {
                const label = syntheticMode ? 'Simulation' : 'Live';
                tradeModePill.textContent = label;
                tradeModePill.classList.toggle('is-simulated', syntheticMode);
            }

            function setDrawMenuOpen(isOpen) {
                drawMenu.classList.toggle('is-open', isOpen);
                drawMenuToggle.classList.toggle('is-open', isOpen);
                mobileToolsButton?.classList.toggle('is-active', isOpen);
                if (drawMenuBackdrop) drawMenuBackdrop.classList.toggle('is-open', isOpen);
            }

            function syncDrawLayerMode() {
                drawLayer.style.pointerEvents = currentTool === 'cursor' ? 'none' : 'auto';
                drawLayer.style.touchAction = currentTool === 'cursor' ? 'auto' : 'none'; // Better mobile dragging UX
                drawLayer.style.cursor = currentTool === 'cursor'
                    ? 'default'
                    : (isDraggingDrawing ? 'grabbing' : 'crosshair');
            }

            function syncDrawControlState() {
                const total = drawings.length;
                const hasSelection = selectedDrawingIndex >= 0 && selectedDrawingIndex < total;

                if (drawingsCountLabel) {
                    drawingsCountLabel.textContent = `${total} ${total === 1 ? 'drawing' : 'drawings'}`;
                }

                if (drawingsCountBadge) {
                    drawingsCountBadge.textContent = String(total);
                }

                drawMenuToggle.classList.toggle('is-drawing', currentTool !== 'cursor');
                drawMenu.querySelector('[data-action="undo"]').disabled = !total;
                drawMenu.querySelector('[data-action="clear"]').disabled = !total;
                drawMenu.querySelector('[data-action="delete-selected"]').disabled = !hasSelection;
            }

            function setTool(tool) {
                currentTool = tool;

                const labelMap = {
                    cursor: 'Cursor',
                    hline: 'Horizontal Line',
                    vline: 'Vertical Line',
                    trend: 'Trend Line',
                    rect: 'Rectangle',
                };

                activeToolLabel.textContent = labelMap[tool] || 'Cursor';

                document.querySelectorAll('.lira-draw-item[data-tool]').forEach(btn => {
                    btn.classList.toggle('is-active', btn.dataset.tool === tool);
                });

                draftDrawing = null;
                dragTarget = null;
                dragStartPoint = null;
                dragSnapshot = null;
                isDraggingDrawing = false;
                syncDrawLayerMode();
                syncDrawControlState();
                requestOverlayDraw();
            }

            function syncCanvasSize() {
                const rect = drawLayer.getBoundingClientRect();
                const dpr = window.devicePixelRatio || 1;

                drawLayer.width = Math.round(rect.width * dpr);
                drawLayer.height = Math.round(rect.height * dpr);
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                requestOverlayDraw();
            }

            function logicalToX(logical) {
                return chart.timeScale().logicalToCoordinate(logical);
            }

            function xToLogical(x) {
                return chart.timeScale().coordinateToLogical(x);
            }

            function priceToY(price) {
                return candleSeries.priceToCoordinate(price);
            }

            function yToPrice(y) {
                return candleSeries.coordinateToPrice(y);
            }

            function domainPointFromEvent(evt) {
                const rect = drawLayer.getBoundingClientRect();
                const x = evt.clientX - rect.left;
                const y = evt.clientY - rect.top;

                return {
                    x,
                    y,
                    logical: xToLogical(x),
                    price: yToPrice(y),
                };
            }

            function requestOverlayDraw() {
                window.requestAnimationFrame(drawOverlay);
            }

            function drawLine(x1, y1, x2, y2, color = '#00e6a7', width = 1.5, dashed = false) {
                if ([x1, y1, x2, y2].some(value => value === null || value === undefined)) return;

                ctx.save();
                ctx.strokeStyle = color;
                ctx.lineWidth = width;
                if (dashed) ctx.setLineDash([6, 6]);
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                ctx.restore();
            }

            function drawRect(x1, y1, x2, y2, options = {}) {
                if ([x1, y1, x2, y2].some(value => value === null || value === undefined)) return;

                const left = Math.min(x1, x2);
                const top = Math.min(y1, y2);
                const width = Math.abs(x2 - x1);
                const height = Math.abs(y2 - y1);

                ctx.save();
                ctx.fillStyle = options.fill || 'rgba(0, 230, 167, 0.10)';
                ctx.strokeStyle = options.stroke || 'rgba(0, 230, 167, 0.85)';
                ctx.lineWidth = options.width || 1.2;
                ctx.fillRect(left, top, width, height);
                ctx.strokeRect(left, top, width, height);
                ctx.restore();
            }

            function drawAnchor(x, y, color = '#fff') {
                if ([x, y].some(value => value == null)) return;

                ctx.save();
                ctx.fillStyle = color;
                ctx.strokeStyle = '#07101d';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.arc(x, y, 4.5, 0, Math.PI * 2);
                ctx.fill();
                ctx.stroke();
                ctx.restore();
            }

            function drawTradeLabel(x, y, text, color) {
                ctx.save();
                ctx.font = '800 12px Cairo, sans-serif';
                const paddingX = 14;
                const paddingY = 6;
                const metrics = ctx.measureText(text);
                const textHeight = 12; // Approximation for middle alignment
                const width = metrics.width + (paddingX * 2);
                const height = 28;
                const left = x - width;
                const top = y - (height / 2);

                // Shadow for depth
                ctx.shadowColor = 'rgba(0, 0, 0, 0.35)';
                ctx.shadowBlur = 12;
                ctx.shadowOffsetY = 4;

                // Pill background
                ctx.fillStyle = color;
                if (typeof ctx.roundRect === 'function') {
                    ctx.beginPath();
                    ctx.roundRect(left, top, width, height, height / 2);
                    ctx.fill();
                } else {
                    // Fallback for older browsers
                    ctx.fillRect(left, top, width, height);
                }

                // Reset shadow for text
                ctx.shadowBlur = 0;
                ctx.shadowOffsetY = 0;

                // Text
                ctx.fillStyle = '#ffffff';
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';
                ctx.fillText(text, left + (width / 2), y);
                ctx.restore();
            }

            function distanceToSegment(px, py, x1, y1, x2, y2) {
                const dx = x2 - x1;
                const dy = y2 - y1;

                if (dx === 0 && dy === 0) {
                    return Math.hypot(px - x1, py - y1);
                }

                const t = Math.max(0, Math.min(1, (((px - x1) * dx) + ((py - y1) * dy)) / ((dx * dx) + (dy * dy))));
                const projX = x1 + (t * dx);
                const projY = y1 + (t * dy);

                return Math.hypot(px - projX, py - projY);
            }

            function findDrawingHit(x, y) {
                const tolerance = 24; // Increased from 10 to make grabbing objects much smoother on all devices

                for (let index = drawings.length - 1; index >= 0; index -= 1) {
                    const item = drawings[index];

                    if (item.type === 'hline') {
                        const yy = priceToY(item.price);
                        if (yy != null && Math.abs(y - yy) <= tolerance) {
                            return { index, type: 'hline' };
                        }
                    }

                    if (item.type === 'vline') {
                        const xx = logicalToX(item.logical);
                        if (xx != null && Math.abs(x - xx) <= tolerance) {
                            return { index, type: 'vline' };
                        }
                    }

                    if (item.type === 'trend') {
                        const x1 = logicalToX(item.startLogical);
                        const y1 = priceToY(item.startPrice);
                        const x2 = logicalToX(item.endLogical);
                        const y2 = priceToY(item.endPrice);

                        if ([x1, y1, x2, y2].every(value => value != null)) {
                            // Check anchors first
                            if (Math.hypot(x - x1, y - y1) <= tolerance) {
                                return { index, type: 'trend', part: 'start' };
                            }
                            if (Math.hypot(x - x2, y - y2) <= tolerance) {
                                return { index, type: 'trend', part: 'end' };
                            }
                            // Then check the full line
                            if (distanceToSegment(x, y, x1, y1, x2, y2) <= tolerance) {
                                return { index, type: 'trend', part: 'body' };
                            }
                        }
                    }

                    if (item.type === 'rect') {
                        const startX = logicalToX(item.startLogical);
                        const startY = priceToY(item.startPrice);
                        const endX = logicalToX(item.endLogical);
                        const endY = priceToY(item.endPrice);
                        const left = Math.min(startX, endX);
                        const right = Math.max(startX, endX);
                        const top = Math.min(startY, endY);
                        const bottom = Math.max(startY, endY);

                        if ([left, right, top, bottom].every(value => value != null)) {
                            const inside = x >= (left - tolerance) && x <= (right + tolerance) && y >= (top - tolerance) && y <= (bottom + tolerance);

                            // Allow picking up the rectangle by clicking *anywhere* inside it, 
                            // not just on its very thin edges, for a much smoother drag experience.
                            if (inside) {
                                return { index, type: 'rect' };
                            }
                        }
                    }
                }

                return null;
            }

            function cloneDrawing(item) {
                return item ? JSON.parse(JSON.stringify(item)) : null;
            }

            function beginDraggingDrawing(hit, point, event) {
                selectedDrawingIndex = hit.index;
                dragTarget = hit;
                dragStartPoint = point;
                dragSnapshot = cloneDrawing(drawings[hit.index]);
                isDraggingDrawing = true;
                syncDrawLayerMode();
                syncDrawControlState();
                requestOverlayDraw();
                drawLayer.setPointerCapture(event.pointerId);
            }

            function updateDraggedDrawing(hit, point) {
                if (!hit || !point || !dragSnapshot || !dragStartPoint) return;

                const item = drawings[hit.index];
                if (!item) return;

                if (item.type === 'hline' && point.price != null) {
                    item.price = point.price;
                }

                if (item.type === 'vline' && point.logical != null) {
                    item.logical = point.logical;
                }

                if (item.type === 'trend' && point.logical != null && point.price != null) {
                    if (hit.part === 'start') {
                        item.startLogical = point.logical;
                        item.startPrice = point.price;
                    } else if (hit.part === 'end') {
                        item.endLogical = point.logical;
                        item.endPrice = point.price;
                    } else {
                        const logicalShift = point.logical - dragStartPoint.logical;
                        const priceShift = point.price - dragStartPoint.price;

                        item.startLogical = dragSnapshot.startLogical + logicalShift;
                        item.endLogical = dragSnapshot.endLogical + logicalShift;
                        item.startPrice = dragSnapshot.startPrice + priceShift;
                        item.endPrice = dragSnapshot.endPrice + priceShift;
                    }
                }

                if (item.type === 'rect' && point.logical != null && point.price != null) {
                    const logicalShift = point.logical - dragStartPoint.logical;
                    const priceShift = point.price - dragStartPoint.price;

                    item.startLogical = dragSnapshot.startLogical + logicalShift;
                    item.endLogical = dragSnapshot.endLogical + logicalShift;
                    item.startPrice = dragSnapshot.startPrice + priceShift;
                    item.endPrice = dragSnapshot.endPrice + priceShift;
                }

                requestOverlayDraw();
            }

            function drawOverlay() {
                if (!chart || !candleSeries) return;

                const rect = drawLayer.getBoundingClientRect();
                ctx.clearRect(0, 0, rect.width, rect.height);

                drawings.forEach((item, index) => {
                    const isSelected = index === selectedDrawingIndex;

                    if (item.type === 'hline') {
                        const y = priceToY(item.price);
                        const color = isSelected ? '#38bdf8' : '#00e6a7';
                        drawLine(0, y, rect.width, y, color, isSelected ? 1.9 : 1.35, false);
                        if (isSelected) drawAnchor(rect.width - 22, y, color);
                    }

                    if (item.type === 'vline') {
                        const x = logicalToX(item.logical);
                        const color = isSelected ? '#d9e5ff' : 'rgba(255,255,255,0.7)';
                        drawLine(x, 0, x, rect.height, color, isSelected ? 1.8 : 1.2, false);
                        if (isSelected) drawAnchor(x, 22, color);
                    }

                    if (item.type === 'trend') {
                        const startX = logicalToX(item.startLogical);
                        const startY = priceToY(item.startPrice);
                        const endX = logicalToX(item.endLogical);
                        const endY = priceToY(item.endPrice);
                        const color = isSelected ? '#82c3ff' : '#4fe0a5';

                        drawLine(
                            startX,
                            startY,
                            endX,
                            endY,
                            color,
                            isSelected ? 2.2 : 1.6,
                            false
                        );

                        if (isSelected) {
                            drawAnchor(startX, startY, color);
                            drawAnchor(endX, endY, color);
                        }
                    }

                    if (item.type === 'rect') {
                        const startX = logicalToX(item.startLogical);
                        const startY = priceToY(item.startPrice);
                        const endX = logicalToX(item.endLogical);
                        const endY = priceToY(item.endPrice);
                        const stroke = isSelected ? '#38bdf8' : 'rgba(0, 230, 167, 0.85)';

                        drawRect(
                            startX,
                            startY,
                            endX,
                            endY,
                            {
                                fill: isSelected ? 'rgba(0, 230, 167, 0.16)' : 'rgba(0, 230, 167, 0.10)',
                                stroke,
                                width: isSelected ? 1.9 : 1.2,
                            }
                        );

                        if (isSelected) {
                            drawAnchor(startX, startY, stroke);
                            drawAnchor(endX, startY, stroke);
                            drawAnchor(startX, endY, stroke);
                            drawAnchor(endX, endY, stroke);
                        }
                    }
                });

                if (!draftDrawing && pointer) {
                    if (currentTool === 'hline') {
                        drawLine(0, pointer.y, rect.width, pointer.y, 'rgba(255, 217, 120, 0.86)', 1.25, false);
                    }

                    if (currentTool === 'vline') {
                        drawLine(pointer.x, 0, pointer.x, rect.height, 'rgba(226, 235, 255, 0.8)', 1.15, false);
                    }
                }

                if (draftDrawing && pointer) {
                    if (draftDrawing.type === 'trend') {
                        drawLine(
                            logicalToX(draftDrawing.startLogical),
                            priceToY(draftDrawing.startPrice),
                            pointer.x,
                            pointer.y,
                            '#7aa2ff',
                            1.5,
                            false
                        );
                    }

                    if (draftDrawing.type === 'rect') {
                        drawRect(
                            logicalToX(draftDrawing.startLogical),
                            priceToY(draftDrawing.startPrice),
                            pointer.x,
                            pointer.y,
                            {
                                fill: 'rgba(122, 162, 255, 0.12)',
                                stroke: 'rgba(122, 162, 255, 0.88)',
                                width: 1.4,
                            }
                        );
                    }
                }

                // Native lightweight-charts price lines
                syncPriceLines();
            }

            function clearDrawings() {
                drawings = [];
                draftDrawing = null;
                selectedDrawingIndex = -1;
                dragTarget = null;
                dragStartPoint = null;
                dragSnapshot = null;
                isDraggingDrawing = false;
                syncDrawLayerMode();
                syncDrawControlState();
                requestOverlayDraw();
            }

            function undoLastDrawing() {
                if (!drawings.length) return;

                drawings.pop();
                selectedDrawingIndex = drawings.length ? Math.min(selectedDrawingIndex, drawings.length - 1) : -1;
                syncDrawControlState();
                requestOverlayDraw();
            }

            function deleteSelectedDrawing() {
                if (selectedDrawingIndex < 0 || selectedDrawingIndex >= drawings.length) return;

                drawings.splice(selectedDrawingIndex, 1);
                selectedDrawingIndex = drawings.length ? Math.min(selectedDrawingIndex, drawings.length - 1) : -1;
                syncDrawControlState();
                requestOverlayDraw();
            }

            function setActiveDurationChip(target) {
                document.querySelectorAll('.lira-duration-chip').forEach(btn => {
                    btn.classList.remove('active');
                });

                if (target) {
                    target.classList.add('active');
                }
            }

            function generateSyntheticCandles(symbol, interval, count = 600) {
                const output = [];
                const stepMs = intervalToMs(interval);
                const syntheticConfig = getSymbolSyntheticConfig(symbol);
                let price = getBaseSyntheticPrice(symbol);
                let time = Date.now() - (count * stepMs);
                const volatility = syntheticConfig.historyVolatility;

                for (let index = 0; index < count; index += 1) {
                    const drift = price * ((Math.random() - 0.5) * volatility);
                    const spread = Math.abs(price * volatility * (0.45 + (Math.random() * 0.55)));
                    const open = price;
                    const close = Math.max(1, open + drift);
                    const high = Math.max(open, close) + spread;
                    const low = Math.max(0.01, Math.min(open, close) - spread);

                    output.push(normalizeBar({
                        time: time / 1000,
                        open,
                        high,
                        low,
                        close,
                    }, symbol));

                    price = close;
                    time += stepMs;
                }

                return output;
            }

            async function fetchCandles(symbol, interval) {
                const pair = symbolMap[symbol];
                const streamInterval = getStreamInterval(interval);

                if (!streamInterval) {
                    return generateSyntheticCandles(symbol, interval, 600);
                }

                try {
                    const response = await fetch(
                        `https://api.binance.com/api/v3/klines?symbol=${pair.rest}&interval=${streamInterval}&limit=800`,
                        { cache: 'no-store' }
                    );

                    if (!response.ok) throw new Error('Failed to fetch candles');

                    const data = await response.json();
                    return data.map(item => toBar(item, symbol));
                } catch (_) {
                    return generateSyntheticCandles(symbol, interval, 600);
                }
            }

            function getSyntheticBarRuntimeMs() {
                return getSyntheticRuntimeMs(activeInterval);
            }

            function nextSyntheticPrice() {
                const anchor = bars.length ? bars[bars.length - 1].close : getBaseSyntheticPrice(currentSymbol);
                const syntheticConfig = getSymbolSyntheticConfig(currentSymbol);

                if (syntheticLastPrice == null) {
                    syntheticLastPrice = anchor;
                }

                const runtimeFactor = Math.max(0.55, Math.min(1.6, intervalToMs(activeInterval) / 300000));
                const volatility = syntheticConfig.runtimeVolatility * runtimeFactor * 1.12;
                const drift = syntheticLastPrice * ((Math.random() - 0.5) * volatility * syntheticConfig.driftMultiplier);
                const meanPull = (anchor - syntheticLastPrice) * syntheticConfig.meanPull;

                syntheticLastPrice = Math.max(1, syntheticLastPrice + drift + meanPull);
                return normalizePrice(syntheticLastPrice);
            }

            function nextLivePulsePrice() {
                const anchor = bars.length ? bars[bars.length - 1].close : getBaseSyntheticPrice(currentSymbol);
                const syntheticConfig = getSymbolSyntheticConfig(currentSymbol);

                if (livePulsePrice == null) {
                    livePulsePrice = anchor;
                }

                const staleMs = Date.now() - liveLastServerTickAt;
                const staleBoost = Math.max(0.25, Math.min(0.95, staleMs / 1400));
                const volatility = syntheticConfig.runtimeVolatility * 0.08 * staleBoost;
                const drift = livePulsePrice * ((Math.random() - 0.5) * volatility * syntheticConfig.driftMultiplier);
                const meanPull = (anchor - livePulsePrice) * Math.min(0.20, syntheticConfig.meanPull);

                livePulsePrice = Math.max(1, livePulsePrice + drift + meanPull);
                return normalizePrice(livePulsePrice);
            }

            function commitRealtimeBar(bar) {
                const last = bars[bars.length - 1];

                if (!last || last.time !== bar.time) {
                    bars.push(bar);
                    if (bars.length > 2000) bars.shift();
                } else {
                    bars[bars.length - 1] = bar;
                }

                candleSeries.update(bar);
                updateTopMeta(bars);
                setHovered(bar);

                if (followLive) {
                    // Optimized tracking: Center the indicator by maintaining a large right offset
                    // This creates the 'tracking better' effect requested by the user
                    chart.timeScale().scrollToRealTime();
                }

                settleExpiredTrades();
                renderTrades();
                requestOverlayDraw();
            }

            function getRealtimeAnimationDuration() {
                return syntheticMode ? 95 : 140;
            }

            function animateRealtimeBarUpdate(previousBar, targetBar) {
                if (barAnimationFrame) {
                    cancelAnimationFrame(barAnimationFrame);
                    barAnimationFrame = null;
                }

                const start = performance.now();
                const duration = getRealtimeAnimationDuration();
                const baseBars = bars.slice(0, -1);

                function frame(now) {
                    const progress = Math.min(1, (now - start) / duration);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const interimBar = normalizeBar({
                        time: targetBar.time,
                        open: previousBar.open,
                        high: previousBar.high + ((targetBar.high - previousBar.high) * eased),
                        low: previousBar.low + ((targetBar.low - previousBar.low) * eased),
                        close: previousBar.close + ((targetBar.close - previousBar.close) * eased),
                    });

                    candleSeries.update(interimBar);
                    updateTopMeta([...baseBars, interimBar]);
                    setHovered(interimBar);
                    requestOverlayDraw();

                    if (progress < 1) {
                        barAnimationFrame = window.requestAnimationFrame(frame);
                        return;
                    }

                    barAnimationFrame = null;
                    commitRealtimeBar(targetBar);
                }

                barAnimationFrame = window.requestAnimationFrame(frame);
            }

            function applyRealtimeBar(bar) {
                const normalizedBar = normalizeBar(bar, currentSymbol);
                const last = bars[bars.length - 1];

                if (last && last.time === normalizedBar.time) {
                    animateRealtimeBarUpdate(last, normalizedBar);
                    return;
                }

                commitRealtimeBar(normalizedBar);
            }

            function startSyntheticStream() {
                if (syntheticTimer) {
                    clearInterval(syntheticTimer);
                }

                if (!bars.length) return;

                syntheticBarOpenedAtMs = Date.now();
                syntheticLastPrice = bars[bars.length - 1].close;

                syntheticTimer = setInterval(() => {
                    const last = bars[bars.length - 1];
                    if (!last) return;

                    const nextPrice = nextSyntheticPrice();
                    const elapsed = Date.now() - syntheticBarOpenedAtMs;
                    const runtimeMs = getSyntheticBarRuntimeMs();
                    const barStepSeconds = intervalToMs(activeInterval) / 1000;
                    const spreadFactor = getSymbolSyntheticConfig(currentSymbol).spreadFactor;
                    const spread = Math.max(0.01, nextPrice * spreadFactor);

                    if (elapsed >= runtimeMs) {
                        syntheticBarOpenedAtMs = Date.now();

                        const nextBar = normalizeBar({
                            time: last.time + barStepSeconds,
                            open: last.close,
                            high: Math.max(last.close, nextPrice) + (Math.random() * spread),
                            low: Math.min(last.close, nextPrice) - (Math.random() * spread),
                            close: nextPrice,
                        }, currentSymbol);

                        applyRealtimeBar(nextBar);
                        return;
                    }

                    const draftBar = normalizeBar({
                        time: last.time,
                        open: last.open,
                        high: Math.max(last.high, nextPrice),
                        low: Math.min(last.low, nextPrice),
                        close: nextPrice,
                    }, currentSymbol);

                    applyRealtimeBar(draftBar);
                }, 90);
            }

            function startLivePulse() {
                if (livePulseTimer) {
                    clearInterval(livePulseTimer);
                }

                if (!bars.length) return;

                livePulsePrice = bars[bars.length - 1].close;
                liveLastServerTickAt = Date.now();

                livePulseTimer = setInterval(() => {
                    if (syntheticMode || !socket || !bars.length) return;

                    const last = bars[bars.length - 1];
                    const nextPrice = nextLivePulsePrice();
                    const spread = Math.max(0.01, nextPrice * getSymbolSyntheticConfig(currentSymbol).spreadFactor * 0.35);

                    applyRealtimeBar(normalizeBar({
                        time: last.time,
                        open: last.open,
                        high: Math.max(last.high, nextPrice) + (Math.random() * spread),
                        low: Math.min(last.low, nextPrice) - (Math.random() * spread),
                        close: nextPrice,
                    }, currentSymbol));
                }, 260);
            }

            function stopStream() {
                if (reconnectTimer) {
                    clearTimeout(reconnectTimer);
                    reconnectTimer = null;
                }

                if (barAnimationFrame) {
                    cancelAnimationFrame(barAnimationFrame);
                    barAnimationFrame = null;
                }

                if (syntheticTimer) {
                    clearInterval(syntheticTimer);
                    syntheticTimer = null;
                }

                if (livePulseTimer) {
                    clearInterval(livePulseTimer);
                    livePulseTimer = null;
                }

                if (socket) {
                    socket.onclose = null;
                    socket.onerror = null;
                    socket.onmessage = null;
                    socket.close();
                    socket = null;
                }
            }

            function startStream() {
                stopStream();

                const streamInterval = getStreamInterval(activeInterval);
                if (!streamInterval) {
                    syntheticMode = true;
                    setTradeModePill();
                    startSyntheticStream();
                    return;
                }

                const stream = symbolMap[currentSymbol].stream;
                const socketUrl = `wss://stream.binance.com:9443/ws/${stream}@kline_${streamInterval}`;

                const connect = () => {
                    socket = new WebSocket(socketUrl);

                    socket.onopen = () => {
                        syntheticMode = false;
                        livePulsePrice = bars.length ? bars[bars.length - 1].close : null;
                        liveLastServerTickAt = Date.now();
                        setTradeModePill();
                        startLivePulse();
                    };

                    socket.onmessage = event => {
                        const payload = JSON.parse(event.data);
                        const kline = payload.k;
                        const liveBar = normalizeBar({
                            time: kline.t / 1000,
                            open: kline.o,
                            high: kline.h,
                            low: kline.l,
                            close: kline.c,
                        });

                        livePulsePrice = liveBar.close;
                        liveLastServerTickAt = Date.now();
                        applyRealtimeBar(liveBar);
                    };

                    socket.onerror = () => {
                        try { socket.close(); } catch (_) { }
                    };

                    socket.onclose = () => {
                        syntheticMode = true;
                        setTradeModePill();
                        startSyntheticStream();

                        reconnectTimer = setTimeout(() => {
                            stopStream();
                            connect();
                        }, 2000);
                    };
                };

                connect();
            }

            function getCurrentPrice() {
                return bars.length ? bars[bars.length - 1].close : null;
            }

            function notifyTradeClosed(trade, closeData, fallbackExitPrice) {
                if (trade.resultNotified) return;
                trade.resultNotified = true;

                const result = closeData?.result || (closeData?.isWin ? 'win' : 'loss');
                const isWin = result === 'win';
                const symbol = closeData?.symbol || trade.symbol || currentSymbol;
                const pnl = Number(closeData?.pnl ?? trade.pnl ?? 0);
                const direction = trade.side === 'buy' ? 'BUY' : 'SELL';
                const balance = closeData?.balance !== undefined ? ` Balance: ${formatUsd(closeData.balance)}.` : '';
                const title = isWin ? 'Deal won' : 'Deal lost';
                const message = `${getSymbolLabel(symbol)} ${direction} finished. ${isWin ? 'Profit' : 'Loss'}: ${formatUsd(pnl, 2, true)}.${balance}`;

                if (window.showNotification) {
                    window.showNotification(message, isWin ? 'success' : 'warning', {
                        title,
                        duration: 5600,
                    });
                    return;
                }

                alert(`${title}\n${message}`);
            }

            function placeTrade(side) {
                if (isPlacingTrade) return;

                const price = getCurrentPrice();
                if (price == null) return;

                const amount = Math.max(1, Math.floor(Number(tradeAmountInput.value || 0)));
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                isPlacingTrade = true;
                [buyTradeBtn, buyTradeBtnMobile, sellTradeBtn, sellTradeBtnMobile].forEach(button => {
                    if (button) button.disabled = true;
                });

                fetch('/trading/open', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ amount: amount, type: side, strike_price: price, symbol: currentSymbol, mode: activeAccountMode })
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        if (window.showNotification) {
                            window.showNotification(data.message || 'Trade failed', 'error');
                        } else {
                            alert(data.message || 'Trade failed');
                        }
                        return;
                    }

                    accountBalances[data.mode || activeAccountMode] = Number(data.balance) || 0;
                    updateDisplayedTradingBalance(accountBalances[activeAccountMode]);

                    // Add to simulated front-end array only if success
                    trades.unshift({
                        id: data.ticket || (tradeId++),
                        side,
                        symbol: currentSymbol,
                        mode: data.mode || activeAccountMode,
                        entryPrice: price,
                        amount,
                        payoutRatio,
                        durationSeconds: tradeDurationSeconds,
                        openedAt: Date.now(),
                        expireAt: Date.now() + (tradeDurationSeconds * 1000),
                        apiTicket: data.ticket // Store API ticket to close later
                    });

                    renderTrades();
                    requestOverlayDraw();
                })
                .catch(e => {
                    console.error(e);
                    if (window.showNotification) {
                        window.showNotification("A network error occurred while opening the trade.", 'error');
                    } else {
                        alert("Network error");
                    }
                })
                .finally(() => {
                    isPlacingTrade = false;
                    [buyTradeBtn, buyTradeBtnMobile, sellTradeBtn, sellTradeBtnMobile].forEach(button => {
                        if (button) button.disabled = false;
                    });
                });
            }
            window.placeTrade = placeTrade;

            function settleExpiredTrades() {
                if (!trades.length) return;

                const now = Date.now();
                const exitPrice = getCurrentPrice();
                if (exitPrice == null) return;

                const stillOpen = [];

                trades.forEach(trade => {
                    if (now < trade.expireAt) {
                        stillOpen.push(trade);
                        return;
                    }

                    const isWin = trade.side === 'buy'
                        ? exitPrice > trade.entryPrice
                        : exitPrice < trade.entryPrice;

                    const closedRecord = {
                        ...trade,
                        closedAt: now,
                        exitPrice,
                        result: isWin ? 'win' : 'loss',
                        pnl: isWin ? trade.amount * trade.payoutRatio : -trade.amount,
                        closeStatus: trade.apiTicket ? 'pending' : 'settled',
                    };

                    // Immediately close via backend
                    if (trade.apiTicket) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                        fetch('/trading/close/' + trade.apiTicket, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                            body: JSON.stringify({ close_price: exitPrice, mode: trade.mode || activeAccountMode })
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success && data.balance !== undefined) {
                                accountBalances[data.mode || trade.mode || activeAccountMode] = Number(data.balance) || 0;
                                updateDisplayedTradingBalance(accountBalances[activeAccountMode]);

                                closedRecord.pnl = Number(data.pnl ?? closedRecord.pnl);
                                closedRecord.result = data.result || (data.isWin ? 'win' : 'loss');
                                closedRecord.exitPrice = Number(data.close_price ?? exitPrice);
                                closedRecord.closeStatus = 'settled';
                                notifyTradeClosed(closedRecord, data, exitPrice);
                                renderTrades();
                                requestOverlayDraw();
                                return;
                            }

                            closedRecord.closeStatus = 'failed';
                            if (window.showNotification) {
                                window.showNotification(data.message || 'Trade closed locally, but the server did not confirm the result.', 'error');
                            }
                        })
                        .catch(err => {
                            closedRecord.closeStatus = 'failed';
                            console.error("Close Error:", err);
                            if (window.showNotification) {
                                window.showNotification('A network error occurred while closing the trade. Please refresh to confirm the final result.', 'error');
                            }
                        });
                    } else {
                        notifyTradeClosed(closedRecord, null, exitPrice);
                    }

                    closedTrades.unshift(closedRecord);
                });

                trades = stillOpen;
            }

            function renderTrades() {
                openTradesCountEl.textContent = trades.length;

                const wins = closedTrades.filter(trade => trade.result === 'win').length;
                const pnl = closedTrades.reduce((sum, trade) => sum + trade.pnl, 0);

                winTradesCountEl.textContent = wins;
                tradePnlValueEl.textContent = formatUsd(pnl, 2, true);
                tradePnlValueEl.classList.toggle('is-positive', pnl > 0);
                tradePnlValueEl.classList.toggle('is-negative', pnl < 0);

                if (!trades.length) {
                    tradePositionsList.innerHTML = '<div class="lira-empty-trades">No open trades yet. Your active positions will appear here.</div>';
                    return;
                }

                tradePositionsList.innerHTML = trades.map(trade => {
                    const remainingSeconds = Math.max(0, (trade.expireAt - Date.now()) / 1000);
                    const progress = Math.max(
                        4,
                        Math.min(
                            100,
                            100 - ((trade.expireAt - Date.now()) / (trade.durationSeconds * 1000) * 100)
                        )
                    );

                    return `
                                                    <article class="lira-trade-row is-${trade.side}">
                                                        <div class="lira-trade-row__top">
                                                            <div class="lira-trade-side is-${trade.side}">${trade.side === 'buy' ? 'BUY' : 'SELL'}</div>
                                                            <div class="lira-trade-row__symbol">
                                                                <strong>${getSymbolLabel(trade.symbol)}</strong>
                                                                <span>${formatDuration(trade.durationSeconds)} · ${formatNum(trade.entryPrice, getSymbolPrecision(trade.symbol))}</span>
                                                            </div>
                                                            <div class="lira-trade-row__meta">
                                                                <strong>${formatUsd(trade.amount)}</strong>
                                                                <span>${formatRemaining(remainingSeconds)}</span>
                                                            </div>
                                                        </div>
                                                        <div class="lira-trade-row__progress">
                                                            <span style="width:${progress}%"></span>
                                                        </div>
                                                    </article>
                                                `;
                }).join('');
            }

            function syncPriceLines() {
                if (!candleSeries || typeof LightweightCharts === 'undefined') return;

                const curPrice = getCurrentPrice();
                const now = Date.now();

                // Remove closed trades
                for (const [id, line] of priceLines.entries()) {
                    if (!trades.find(t => t.id === id)) {
                        candleSeries.removePriceLine(line);
                        priceLines.delete(id);
                    }
                }

                // Add or update open trades
                trades.forEach(trade => {
                    const price = trade.entryPrice;
                    const isWinning = trade.side === 'buy' ? (curPrice > price) : (curPrice < price);
                    // Match standard trading platforms: green for winning, red for losing
                    const dynamicColor = isWinning ? '#31c48d' : '#f97066';
                    const remaining = Math.max(0, Math.ceil((trade.expireAt - now) / 1000));
                    
                    const labelTitle = `${trade.side === 'buy' ? 'UP' : 'DOWN'} $${trade.amount} · ${remaining}s`;

                    if (!priceLines.has(trade.id)) {
                        const line = candleSeries.createPriceLine({
                            price: price,
                            color: dynamicColor,
                            lineWidth: 2,
                            lineStyle: LightweightCharts.LineStyle.Solid,
                            axisLabelVisible: true,
                            title: labelTitle,
                        });
                        priceLines.set(trade.id, line);
                    } else {
                        const line = priceLines.get(trade.id);
                        line.applyOptions({
                            color: dynamicColor,
                            title: labelTitle,
                        });
                    }
                });
            }

            function initChart() {
                chart = createChart(chartHost, {
                    autoSize: true,
                    layout: {
                        background: { type: 'solid', color: 'transparent' },
                        textColor: '#8d96a5',
                        fontFamily: 'Cairo, sans-serif',
                        attributionLogo: false,
                    },
                    grid: {
                        vertLines: { color: 'rgba(255,255,255,0.07)', style: LineStyle.Solid },
                        horzLines: { color: 'rgba(255,255,255,0.07)', style: LineStyle.Solid },
                    },
                    crosshair: {
                        mode: CrosshairMode.Normal,
                        vertLine: { color: 'rgba(255,255,255,0.26)', style: LineStyle.Solid, width: 1 },
                        horzLine: { color: 'rgba(255,255,255,0.26)', style: LineStyle.Solid, width: 1 },
                    },
                    rightPriceScale: {
                        borderColor: 'rgba(255,255,255,0.08)',
                        scaleMargins: { 
                            top: 0.1, 
                            bottom: window.innerWidth < 1024 ? 0.45 : 0.12 // Push up more on mobile to avoid dock overlap
                        },
                    },
                    timeScale: {
                        borderColor: 'rgba(255,255,255,0.08)',
                        timeVisible: true,
                        secondsVisible: false,
                        rightOffset: 25, // Increased offset to keep price more centered
                        barSpacing: 9,
                        minBarSpacing: 4,
                        lockVisibleTimeRangeOnResize: true,
                        shiftVisibleRangeOnNewBar: true,
                    },
                    handleScroll: {
                        mouseWheel: true,
                        pressedMouseMove: true,
                        horzTouchDrag: true,
                        vertTouchDrag: false,
                    },
                    handleScale: {
                        mouseWheel: true,
                        pinch: true,
                        axisPressedMouseMove: { time: true, price: true },
                    },
                });

                candleSeries = chart.addSeries(CandlestickSeries, {
                    upColor: '#31c48d',
                    downColor: '#f97066',
                    borderVisible: false,
                    wickUpColor: '#31c48d',
                    wickDownColor: '#f97066',
                    priceLineVisible: true,
                    lastValueVisible: true,
                });

                chart.subscribeCrosshairMove(param => {
                    if (
                        !param.point ||
                        !param.time ||
                        param.point.x < 0 ||
                        param.point.y < 0 ||
                        !param.seriesData.has(candleSeries)
                    ) {
                        tooltipEl.style.display = 'none';
                        return;
                    }

                    const data = param.seriesData.get(candleSeries);
                    if (!data) {
                        tooltipEl.style.display = 'none';
                        return;
                    }

                    const bar = {
                        time: param.time,
                        open: data.open,
                        high: data.high,
                        low: data.low,
                        close: data.close,
                    };
                    const precision = getSymbolPrecision();

                    setHovered(bar);

                    tooltipEl.innerHTML = `
                                                    <div class="lira-trade-tooltip__time">${formatTime(bar.time)}</div>
                                                    <div class="lira-trade-tooltip__grid">
                                                        <div class="lira-trade-tooltip__item"><span>Open</span><strong>${formatNum(bar.open, precision)}</strong></div>
                                                        <div class="lira-trade-tooltip__item"><span>High</span><strong>${formatNum(bar.high, precision)}</strong></div>
                                                        <div class="lira-trade-tooltip__item"><span>Low</span><strong>${formatNum(bar.low, precision)}</strong></div>
                                                        <div class="lira-trade-tooltip__item"><span>Close</span><strong>${formatNum(bar.close, precision)}</strong></div>
                                                    </div>
                                                `;

                    tooltipEl.style.display = window.matchMedia('(max-width: 1024.98px)').matches ? 'none' : 'block';

                    const stageRect = chartHost.getBoundingClientRect();
                    let left = param.point.x + 18;
                    let top = param.point.y + 18;

                    if (left + 210 > stageRect.width) left = param.point.x - 210;
                    if (top + 110 > stageRect.height) top = param.point.y - 110;

                    tooltipEl.style.left = `${left}px`;
                    tooltipEl.style.top = `${top}px`;
                });

                chart.timeScale().subscribeVisibleLogicalRangeChange(range => {
                    requestOverlayDraw();

                    if (!range) return;

                    const info = candleSeries.barsInLogicalRange(range);
                    if (info && typeof info.barsAfter === 'number') {
                        followLive = info.barsAfter <= 1;
                    }
                });

                resizeObserver = new ResizeObserver(() => {
                    syncCanvasSize();
                    requestOverlayDraw();
                });

                resizeObserver.observe(chartHost);
                syncCanvasSize();
                syncTimeframeUi();
            }

            function syncResponsiveChartLayout() {
                if (!chart) return;

                const rect = chartHost.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    chart.resize(rect.width, rect.height);
                }

                syncCanvasSize();
                requestOverlayDraw();
            }

            async function loadInitialData(token = rebuildToken) {
                const nextBars = await fetchCandles(currentSymbol, activeInterval);

                // Ignore stale async responses
                if (token !== rebuildToken) return false;

                bars = nextBars;
                candleSeries.setData(bars);
                syncSymbolButtons();
                syncTimeframeUi();
                updateTopMeta(bars);
                setHovered(bars[bars.length - 1]);
                chart.timeScale().scrollToRealTime();
                requestOverlayDraw();
                return true;
            }

            function rebuild() {
                const token = ++rebuildToken;

                followLive = true;
                drawings = [];
                draftDrawing = null;
                selectedDrawingIndex = -1;
                dragTarget = null;
                dragStartPoint = null;
                dragSnapshot = null;
                isDraggingDrawing = false;
                syntheticLastPrice = null;
                syntheticBarOpenedAtMs = 0;
                if (barAnimationFrame) {
                    cancelAnimationFrame(barAnimationFrame);
                    barAnimationFrame = null;
                }
                tooltipEl.style.display = 'none';
                setSymbolMenuOpen(false);
                setTimeframeModalOpen(false);
                closeMobileEditors();
                setDrawMenuOpen(false);
                syncDrawLayerMode();
                syncDrawControlState();
                stopStream();

                loadInitialData(token).then(ok => {
                    if (ok) startStream();
                });
            }

            function isExpandedFallback() {
                return fsTarget.classList.contains('is-mobile-expanded');
            }

            function isExpanded() {
                return document.fullscreenElement === fsTarget || isExpandedFallback();
            }

            function updateExpandButton() {
                fsTarget.classList.toggle('is-fullscreen-tools', isExpanded());
                fsBtn.innerHTML = isExpanded()
                    ? '<i class="fa-solid fa-compress"></i>'
                    : '<i class="fa-solid fa-expand"></i>';
            }

            function openMobileExpanded() {
                fsTarget.classList.add('is-mobile-expanded');
                document.body.classList.add('lira-mobile-chart-open');
                updateExpandButton();
            }

            function closeMobileExpanded() {
                fsTarget.classList.remove('is-mobile-expanded');
                document.body.classList.remove('lira-mobile-chart-open');
                updateExpandButton();
            }

            async function toggleChartExpansion() {
                if (document.fullscreenElement === fsTarget) {
                    await document.exitFullscreen();
                    return;
                }

                if (isExpandedFallback()) {
                    closeMobileExpanded();
                    setTimeout(syncResponsiveChartLayout, 160);
                    return;
                }

                try {
                    if (fsTarget.requestFullscreen) {
                        await fsTarget.requestFullscreen();
                    } else {
                        openMobileExpanded();
                    }
                } catch (_) {
                    openMobileExpanded();
                }

                setTimeout(syncResponsiveChartLayout, 200);
            }

            if (drawMenuToggle) {
                drawMenuToggle.addEventListener('click', event => {
                    event.stopPropagation();
                    setDrawMenuOpen(!drawMenu.classList.contains('is-open'));
                });
            }

            if (drawMenuCloseBtn) {
                drawMenuCloseBtn.addEventListener('click', event => {
                    event.stopPropagation();
                    setDrawMenuOpen(false);
                });
            }

            if (drawMenuBackdrop) {
                drawMenuBackdrop.addEventListener('click', event => {
                    event.stopPropagation();
                    setDrawMenuOpen(false);
                });
            }

            document.addEventListener('click', event => {
                const target = event.target;

                if (
                    !drawMenu.contains(target)
                    && !drawMenuToggle.contains(target)
                    && !(mobileToolsButton && mobileToolsButton.contains(target))
                ) {
                    setDrawMenuOpen(false);
                }

                if (
                    mobileSymbolMenu
                    && !mobileSymbolMenu.contains(target)
                    && !(mobileSymbolButton && mobileSymbolButton.contains(target))
                ) {
                    setSymbolMenuOpen(false);
                }

                if (mobileTimeframeModal?.classList.contains('is-open')) {
                    const timeframeSheet = mobileTimeframeModal.querySelector('.lira-mobile-timeframe-sheet');
                    const clickedInsideSheet = timeframeSheet?.contains(target);
                    const clickedTimeframeTrigger = mobileTimeframeTrigger?.contains(target);

                    if (!clickedInsideSheet && !clickedTimeframeTrigger) {
                        setTimeframeModalOpen(false);
                    }
                }

                if (openMobileEditor) {
                    const clickedDuration = mobileDurationPanel?.contains(target) || mobileDurationTrigger?.contains(target);
                    const clickedAmount = mobileAmountPanel?.contains(target) || mobileAmountTrigger?.contains(target);
                    const clickedDesktopEditor = target.closest?.('[data-mobile-editor-trigger]');

                    if (!clickedDuration && !clickedAmount && !clickedDesktopEditor) {
                        closeMobileEditors();
                    }
                }
            });

            drawMenu.querySelectorAll('[data-tool]').forEach(button => {
                button.addEventListener('click', () => {
                    setTool(button.dataset.tool);
                    setDrawMenuOpen(false);
                });
            });

            drawMenu.querySelector('[data-action="clear"]').addEventListener('click', () => {
                clearDrawings();
                setDrawMenuOpen(false);
            });

            drawMenu.querySelector('[data-action="follow-live"]').addEventListener('click', () => {
                followLive = true;
                chart.timeScale().scrollToRealTime();
                setDrawMenuOpen(false);
            });

            drawMenu.querySelector('[data-action="undo"]').addEventListener('click', () => {
                undoLastDrawing();
            });

            drawMenu.querySelector('[data-action="delete-selected"]').addEventListener('click', () => {
                deleteSelectedDrawing();
            });

            drawLayer.addEventListener('pointerdown', event => {
                if (currentTool === 'cursor') return;

                const point = domainPointFromEvent(event);
                if (point.logical == null || point.price == null) return;

                const hit = findDrawingHit(point.x, point.y);

                if (hit) {
                    selectedDrawingIndex = hit.index;
                    syncDrawControlState();
                    requestOverlayDraw();

                    if (currentTool === hit.type) {
                        beginDraggingDrawing(hit, point, event);
                    }

                    return;
                }

                if (currentTool === 'hline') {
                    drawings.push({ type: 'hline', price: point.price });
                    selectedDrawingIndex = drawings.length - 1;
                    syncDrawControlState();
                    requestOverlayDraw();
                    return;
                }

                if (currentTool === 'vline') {
                    drawings.push({ type: 'vline', logical: point.logical });
                    selectedDrawingIndex = drawings.length - 1;
                    syncDrawControlState();
                    requestOverlayDraw();
                    return;
                }

                if (currentTool === 'trend' || currentTool === 'rect') {
                    if (!draftDrawing) {
                        draftDrawing = {
                            type: currentTool,
                            startLogical: point.logical,
                            startPrice: point.price,
                            isDragDraw: true, // Enables smooth drag-to-draw behavior
                        };
                        try {
                            drawLayer.setPointerCapture(event.pointerId);
                        } catch (_) { }
                    } else {
                        drawings.push({
                            type: currentTool,
                            startLogical: draftDrawing.startLogical,
                            startPrice: draftDrawing.startPrice,
                            endLogical: point.logical,
                            endPrice: point.price,
                        });
                        selectedDrawingIndex = drawings.length - 1;
                        draftDrawing = null;
                        syncDrawControlState();
                    }

                    requestOverlayDraw();
                    return;
                }
            });

            drawLayer.addEventListener('pointermove', event => {
                pointer = domainPointFromEvent(event);

                if (isDraggingDrawing && dragTarget && pointer) {
                    updateDraggedDrawing(dragTarget, pointer);
                    return;
                }

                requestOverlayDraw();
            });

            drawLayer.addEventListener('pointerup', event => {
                if (draftDrawing && draftDrawing.isDragDraw) {
                    const point = domainPointFromEvent(event);
                    if (point.logical != null && point.price != null && pointer) {
                        const startX = logicalToX(draftDrawing.startLogical);
                        const startY = priceToY(draftDrawing.startPrice);
                        const dx = Math.abs(startX - pointer.x);
                        const dy = Math.abs(startY - pointer.y);

                        // If user actually dragged a sufficient amount, finish the drawing immediately.
                        // Otherwise, it was just a click, so drop into click-to-draw mode.
                        if (dx > 8 || dy > 8) {
                            drawings.push({
                                type: draftDrawing.type,
                                startLogical: draftDrawing.startLogical,
                                startPrice: draftDrawing.startPrice,
                                endLogical: point.logical,
                                endPrice: point.price,
                            });
                            selectedDrawingIndex = drawings.length - 1;
                            draftDrawing = null;
                            syncDrawControlState();
                        } else {
                            draftDrawing.isDragDraw = false;
                        }
                        requestOverlayDraw();
                    }
                }

                if (!isDraggingDrawing) {
                    try {
                        drawLayer.releasePointerCapture(event.pointerId);
                    } catch (_) { }
                    return;
                }

                isDraggingDrawing = false;
                dragTarget = null;
                dragStartPoint = null;
                dragSnapshot = null;
                syncDrawLayerMode();

                try {
                    drawLayer.releasePointerCapture(event.pointerId);
                } catch (_) {
                }
            });

            drawLayer.addEventListener('pointerleave', () => {
                pointer = null;
                requestOverlayDraw();
            });

            symbolTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    selectSymbol(tab.dataset.symbol);
                });
            });

            mobileSymbolButton?.addEventListener('click', event => {
                event.stopPropagation();
                closeMobileEditors();
                setTimeframeModalOpen(false);
                setSymbolMenuOpen(!mobileSymbolMenu.classList.contains('is-open'));
            });

            mobileSymbolOptions.forEach(button => {
                button.addEventListener('click', () => {
                    selectSymbol(button.dataset.symbol);
                });
            });

            [mobileWalletShortcut, mobileBalanceChip].forEach(button => {
                button?.addEventListener('click', () => navigateFromButton(button));
            });

            timeframeBtns.forEach(button => {
                button?.addEventListener('click', () => {
                    applyChartInterval(button.dataset.interval);
                });
            });

            mobileTimeframeTrigger?.addEventListener('click', event => {
                event.stopPropagation();
                closeMobileEditors();
                setSymbolMenuOpen(false);
                setTimeframeModalOpen(!mobileTimeframeModal.classList.contains('is-open'));
            });

            mobileTimeframeOptions.forEach(button => {
                button.addEventListener('click', () => {
                    applyChartInterval(button.dataset.interval);
                });
            });

            mobileToolsButton?.addEventListener('click', event => {
                event.stopPropagation();
                setDrawMenuOpen(!drawMenu.classList.contains('is-open'));
            });

            durationChips.forEach(button => {
                button?.addEventListener('click', () => {
                    applyTradeDuration(Number(button.dataset.seconds || 30));
                });
            });

            customDurationBtn?.addEventListener('click', () => {
                applyTradeDuration(customDurationInput?.value);
            });

            customDurationInput?.addEventListener('focus', () => {
                customDurationBtn?.click();
            });

            customDurationInput?.addEventListener('input', () => {
                applyTradeDuration(customDurationInput?.value);
            });

            // Desktop Duration Inputs (HH:MM:SS)
            ['deskDurationHours', 'deskDurationMinutes', 'deskDurationSecondsValue'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', () => {
                        const h = Number(document.getElementById('deskDurationHours').value || 0);
                        const m = Number(document.getElementById('deskDurationMinutes').value || 0);
                        const s = Number(document.getElementById('deskDurationSecondsValue').value || 0);
                        applyTradeDuration((h * 3600) + (m * 60) + s);
                    });
                }
            });

            // Desktop Amount Display Input
            const deskAmountDisplay = document.getElementById('tradeAmountDisplay');
            if (deskAmountDisplay) {
                deskAmountDisplay.addEventListener('input', () => {
                    setTradeAmount(deskAmountDisplay.value);
                });
            }

            // Desktop Duration Stepper Buttons
            document.querySelectorAll('[data-desk-dur-adj]').forEach(button => {
                button.addEventListener('click', () => {
                    const delta = Number(button.dataset.deskDurAdj || 0);
                    applyTradeDuration(tradeDurationSeconds + delta);
                });
            });

            mobileDurationTrigger?.addEventListener('click', event => {
                event.stopPropagation();
                activeDesktopEditorTrigger = null;
                setSymbolMenuOpen(false);
                setTimeframeModalOpen(false);
                toggleMobileEditor('duration');
            });

            mobileAmountTrigger?.addEventListener('click', event => {
                event.stopPropagation();
                activeDesktopEditorTrigger = null;
                setSymbolMenuOpen(false);
                setTimeframeModalOpen(false);
                toggleMobileEditor('amount');
            });

            desktopEditorTriggers.forEach(trigger => {
                const openFromTrigger = event => {
                    event.preventDefault();
                    event.stopPropagation();
                    const editorName = trigger.dataset.mobileEditorTrigger;
                    const shouldOpen = openMobileEditor !== editorName;

                    activeDesktopEditorTrigger = shouldOpen ? trigger : null;
                    setSymbolMenuOpen(false);
                    setTimeframeModalOpen(false);
                    setMobileEditorOpen(shouldOpen ? editorName : null);
                };

                trigger.addEventListener('click', openFromTrigger);
                trigger.addEventListener('keydown', event => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        openFromTrigger(event);
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (openMobileEditor && activeDesktopEditorTrigger) {
                    positionDesktopEditorPopover(activeDesktopEditorTrigger);
                }
            });

            window.addEventListener('scroll', () => {
                if (openMobileEditor && activeDesktopEditorTrigger) {
                    positionDesktopEditorPopover(activeDesktopEditorTrigger);
                }
            }, true);

            mobileDurationAdjustButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const unit = button.dataset.unit;
                    const delta = Number(button.dataset.durationAdjust || 0);
                    const unitMap = {
                        hours: 3600,
                        minutes: 60,
                        seconds: 1,
                    };

                    applyTradeDuration(tradeDurationSeconds + (delta * (unitMap[unit] || 1)));
                });
            });

            mobileDurationPresetButtons.forEach(button => {
                button.addEventListener('click', () => {
                    applyTradeDuration(button.dataset.mobileDuration);
                });
            });

            tradeAmountInput.addEventListener('input', () => {
                setTradeAmount(tradeAmountInput.value);
            });

            amountStepButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const currentAmount = Math.max(1, Math.floor(Number(tradeAmountInput.value || 0)));
                    setTradeAmount(currentAmount + Number(button.dataset.amountStep || 0));
                });
            });

            amountQuickButtons.forEach(button => {
                button.addEventListener('click', () => {
                    setTradeAmount(button.dataset.amount || '50');
                });
            });

            mobileAmountEditorStepButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const currentAmount = Math.max(1, Math.floor(Number(tradeAmountInput.value || 0)));
                    setTradeAmount(currentAmount + Number(button.dataset.amountEditorStep || 0));
                });
            });

            mobileAmountKeyButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const key = button.dataset.amountKey;

                    if (key === 'clear') {
                        updateAmountEditorBuffer('0');
                        return;
                    }

                    if (key === 'backspace') {
                        updateAmountEditorBuffer(amountEditorBuffer.slice(0, -1) || '0');
                        return;
                    }

                    const nextValue = amountEditorBuffer === '0'
                        ? key
                        : `${amountEditorBuffer}${key}`;

                    updateAmountEditorBuffer(nextValue);
                });
            });

            [buyTradeBtn, buyTradeBtnMobile].forEach(button => {
                button?.addEventListener('click', (e) => {
                    e.preventDefault();
                    placeTrade('buy');
                });
            });

            [sellTradeBtn, sellTradeBtnMobile].forEach(button => {
                button?.addEventListener('click', (e) => {
                    e.preventDefault();
                    placeTrade('sell');
                });
            });

            document.querySelectorAll('[data-trade-account-mode]').forEach(button => {
                button.addEventListener('click', () => setAccountMode(button.dataset.tradeAccountMode));
            });

            fsBtn?.addEventListener('click', toggleChartExpansion);

            document.addEventListener('fullscreenchange', () => {
                if (!document.fullscreenElement) {
                    document.body.classList.remove('lira-mobile-chart-open');
                } else {
                    document.body.classList.add('lira-mobile-chart-open');
                }

                updateExpandButton();
                setTimeout(syncResponsiveChartLayout, 200);
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && isExpandedFallback()) {
                    closeMobileExpanded();
                    setTimeout(syncResponsiveChartLayout, 160);
                    return;
                }

                const activeTag = document.activeElement?.tagName;
                const isTyping = activeTag === 'INPUT' || activeTag === 'TEXTAREA';

                if (isTyping) return;

                if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'z') {
                    event.preventDefault();
                    undoLastDrawing();
                    return;
                }

                if (event.key === 'Delete' || event.key === 'Backspace') {
                    if (selectedDrawingIndex >= 0) {
                        event.preventDefault();
                        deleteSelectedDrawing();
                    }
                    return;
                }

                if (event.key === 'Escape') {
                    if (mobileTimeframeModal?.classList.contains('is-open')) {
                        setTimeframeModalOpen(false);
                        return;
                    }

                    if (mobileSymbolMenu?.classList.contains('is-open')) {
                        setSymbolMenuOpen(false);
                        return;
                    }

                    if (openMobileEditor) {
                        closeMobileEditors();
                        return;
                    }

                    draftDrawing = null;
                    setTool('cursor');
                    setDrawMenuOpen(false);
                }
            });



            window.addEventListener('resize', () => {
                setTimeout(syncResponsiveChartLayout, 120);
            });

            window.addEventListener('orientationchange', () => {
                setTimeout(syncResponsiveChartLayout, 240);
            });

            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', () => {
                    setTimeout(syncResponsiveChartLayout, 120);
                });
            }

            setInterval(() => {
                settleExpiredTrades();
                renderTrades();
                updateMobileTradeMeta();
                requestOverlayDraw();
            }, 1000);

            updatePayoutUI();
            updateDisplayedTradingBalance();
            updateSentiment([]);
            syncSymbolButtons();
            syncTimeframeUi();
            applyTradeDuration(tradeDurationSeconds);
            setTradeModePill();
            syncDrawControlState();
            setTool('cursor');
            updateExpandButton();
            initChart();
            await loadInitialData();
            startStream();
        });
    </script>
@endpush

