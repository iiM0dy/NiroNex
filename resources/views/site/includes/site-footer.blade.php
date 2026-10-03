@php
    $footerSettings = array_merge(\App\Models\Setting::footerDefaults(), $footerSettings ?? []);
    $siteDescription = brandText($footerSettings['site_description'] ?? '');
    $copyrightText = brandText($footerSettings['copyright_text'] ?? '');
    $supportEmail = $footerSettings['support_email'] ?? '';
    $socialLinks = [
        [
            'label' => 'Instagram',
            'icon' => 'fa-brands fa-instagram',
            'url' => $footerSettings['instagram_url'] ?? '',
        ],
        [
            'label' => 'Telegram',
            'icon' => 'fa-brands fa-telegram',
            'url' => $footerSettings['telegram_url'] ?? '',
        ],
    ];
    $socialLinks = array_filter($socialLinks, fn($link) => filled($link['url']));
@endphp

<style>
    .lira-site-footer {
        position: relative;
        margin-top: 0;
        padding-top: 0 !important;
        background: linear-gradient(180deg, #0a0f17 0%, #080c13 100%) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .lira-site-footer-main {
        padding: 48px 0 20px;
    }

    .lira-site-footer-main .row {
        align-items: flex-start;
        justify-content: space-between;
    }

    .hp-footer-row {
        row-gap: 28px;
    }

    .lira-site-footer-card,
    .lira-site-footer-brand {
        height: 100%;
    }

    .lira-site-footer-card {
        padding: 0;
    }

    .lira-site-footer-brand {
        max-width: 420px;
    }

    .lira-site-footer-brand p {
        margin: 20px 0 0;
        color: var(--lira-text-muted) !important;
        font-size: 14px !important;
        line-height: 2 !important;
    }

    .lira-site-footer-title {
        display: inline-block;
        margin: 0 0 18px !important;
        color: var(--lira-text) !important;
        font-size: 1rem !important;
        font-weight: 800 !important;
        position: relative;
    }

    .lira-site-footer-title::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: -8px;
        width: 28px;
        height: 2px;
        border-radius: 999px;
        background: var(--lira-accent);
    }

    .lira-site-footer-links,
    .lira-site-footer-contact,
    .lira-site-footer-social {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .lira-site-footer-links li,
    .lira-site-footer-contact li {
        margin-bottom: 12px;
    }

    .lira-site-footer-links a,
    .lira-site-footer-contact a {
        color: var(--lira-text-muted) !important;
        text-decoration: none !important;
        font-size: 14px !important;
        transition: 0.22s ease;
    }

    .lira-site-footer-links a:hover,
    .lira-site-footer-contact a:hover {
        color: var(--lira-accent) !important;
    }

    .lira-site-footer-contact a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        line-height: 1.8;
        word-break: break-word;
    }

    .lira-site-footer-contact i {
        width: 18px;
        text-align: center;
        color: var(--lira-accent) !important;
        flex: 0 0 auto;
    }

    .lira-site-footer-social {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
    }

    .lira-site-footer-social a {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.035);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: var(--lira-text) !important;
        text-decoration: none !important;
        transition: 0.22s ease;
    }

    .lira-site-footer-social a:hover {
        background: rgba(0, 230, 167, 0.10);
        border-color: rgba(0, 230, 167, 0.22);
        color: var(--lira-accent) !important;
        transform: translateY(-2px);
    }

    .lira-site-footer-note {
        margin-top: 20px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--lira-text-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .lira-site-footer-note i {
        color: var(--lira-accent);
        flex: 0 0 auto;
    }

    .lira-site-footer-bottom {
        padding: 18px 0 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .lira-site-footer-bottom-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .lira-site-footer-copy {
        color: var(--lira-text-muted);
        font-size: 13px;
        margin: 0;
    }

    .lira-site-footer-mini-links {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .lira-site-footer-mini-links a {
        color: var(--lira-text-muted) !important;
        text-decoration: none !important;
        font-size: 12px !important;
        transition: 0.22s ease;
    }

    .lira-site-footer-mini-links a:hover {
        color: var(--lira-accent) !important;
    }

    @media (max-width: 991.98px) {
        .lira-site-footer-main {
            padding: 35px 0 20px;
        }
    }

    @media (max-width: 767.98px) {
        .lira-site-footer-main {
            padding: 34px 0 18px;
        }

        .lira-site-footer-main .row > div {
            width: 100%;
            margin-bottom: 0;
        }

        .hp-footer-row {
            gap: 24px 0;
        }

        .lira-site-footer-brand,
        .lira-site-footer-card {
            text-align: center;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 380px;
        }

        .lira-site-footer-brand a {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .lira-site-footer-brand p {
            margin-top: 16px;
            font-size: 13px !important;
            line-height: 1.9 !important;
        }

        .lira-site-footer-title::after {
            right: 50%;
            transform: translateX(50%);
        }

        .lira-site-footer-social {
            justify-content: center;
        }

        .lira-site-footer-note {
            text-align: right;
            width: 100%;
            justify-content: center;
        }

        .lira-site-footer-bottom {
            padding: 16px 0 calc(18px + env(safe-area-inset-bottom, 0px));
        }

        .lira-site-footer-bottom-wrap {
            justify-content: center;
            text-align: center;
        }

        .lira-site-footer-copy {
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-site-footer-mini-links {
            justify-content: center;
        }
    }
</style>

<footer class="footer section lira-site-footer">
    <div class="lira-site-footer-main">
        <div class="container">
            <div class="row g-4 hp-footer-row">
                <div class="col-lg-5 col-md-12">
                    <div class="lira-site-footer-brand">
                        <a href="{{ route('site.index') }}">
                            @include('includes.logo-white', ['asText' => true])
                        </a>

                        <p>{{ $siteDescription }}</p>

                        @if ($socialLinks)
                            <ul class="lira-site-footer-social pt-2">
                                @foreach ($socialLinks as $link)
                                    <li>
                                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                                            aria-label="{{ $link['label'] }}">
                                            <i class="{{ $link['icon'] }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="lira-site-footer-card">
                        <h3 class="lira-site-footer-title">روابط سريعة</h3>
                        <ul class="lira-site-footer-links">
                            <li><a href="{{ route('site.index') }}">الرئيسية</a></li>
                            @auth
                                <li><a href="{{ route('site.trading') }}">منصة التداول</a></li>
                            @else
                                <li><a href="{{ route('register') }}">فتح حساب</a></li>
                            @endauth
                            <li><a href="{{ route('terms') }}">سياسة الاستخدام</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="lira-site-footer-card">
                        <h3 class="lira-site-footer-title">بيانات التواصل</h3>
                        <ul class="lira-site-footer-contact">
                            @if (filled($supportEmail))
                                <li>
                                    <a href="mailto:{{ $supportEmail }}">
                                        <i class="fa-regular fa-envelope"></i>
                                        <span>{{ $supportEmail }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lira-site-footer-bottom">
        <div class="container">
            <div class="lira-site-footer-bottom-wrap">
                <p class="lira-site-footer-copy">
                    {{ $copyrightText }}
                </p>

                <div class="lira-site-footer-mini-links">
                    <a href="{{ route('site.index') }}">الرئيسية</a>
                    <a href="{{ route('terms') }}">الشروط</a>
                    @if (filled($supportEmail))
                        <a href="mailto:{{ $supportEmail }}">الدعم</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
