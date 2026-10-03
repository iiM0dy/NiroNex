@extends('layouts.site-dash')

@section('title', 'محادثة الدعم')

@section('content')
    <div class="lira-support-page">
        <div class="lira-support-hero mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} SUPPORT · DIRECT CHAT</span>
                <h1 class="lira-page-title">الدعم المباشر</h1>
                <p class="lira-page-subtitle">
                    قناة تواصل مباشرة مع فريق الدعم لمتابعة الاستفسارات الفنية والمالية وحالة الحساب.
                </p>
            </div>

            <div class="lira-hero-note">
                <img src="{{ asset('assets/images/icons/IMG_7723.svg') }}" alt="Support" style="width: 32px; height: 32px; object-fit: contain; margin-inline-end: 16px;">
                <div>
                    <strong>جلسة دعم نشطة</strong>
                    <span>يتم تحديث المحادثة بشكل دوري لعرض الرسائل الجديدة.</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-9">
                <div class="card lira-chat-shell">
                    <div class="lira-chat-header">
                        <div class="lira-chat-header-main">
                            <div class="lira-chat-header-avatar">
                                <img src="{{ asset('assets/images/icons/IMG_7723.svg') }}" alt="Support" style="width: 24px; height: 24px; object-fit: contain;">
                                <span class="lira-chat-online-dot"></span>
                            </div>

                            <div class="lira-chat-header-meta">
                                <h6>الدعم المباشر</h6>
                                <div class="lira-chat-header-status">
                                    <span class="lira-status-pill is-online">متاح الآن</span>
                                    <small>للأسئلة والاستفسارات المتعلقة بحسابك</small>
                                </div>
                            </div>
                        </div>

                        <div class="lira-chat-header-actions">
                            <a href="{{ route('site.dashboard') }}" class="btn lira-ghost-btn">
                                <i class="fa-solid fa-grid-2 ms-2"></i>
                                لوحة التحكم
                            </a>
                        </div>
                    </div>

                    <div class="lira-chat-body">
                        @include('site.messages.partials.messages')
                    </div>

                    <div class="lira-chat-footer">
                        <div class="lira-chat-input-wrap">
                            <input
                                id="message-input"
                                class="form-control"
                                type="text"
                                placeholder="اكتب رسالتك هنا..."
                                autocomplete="off"
                            >

                            <button id="send-message" class="btn btn-primary lira-send-btn">
                                <i class="fas fa-paper-plane ms-1"></i>
                                <span>إرسال</span>
                            </button>
                        </div>

                        <div class="lira-chat-footer-note">
                            نحاول الرد خلال أقصر وقت ممكن. اذكر تفاصيل واضحة لتسريع المعالجة.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="d-flex flex-column gap-3">
                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">متى تستخدم الدعم؟</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-guidelines">
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>عند وجود مشكلة في الإيداع أو السحب أو حالة الطلب.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>عند الحاجة لتوضيح متعلق بالهوية أو الحساب أو الوصول.</span>
                                </div>
                                <div class="lira-guideline-item">
                                    <i class="fa-solid fa-check"></i>
                                    <span>عند وجود استفسار عن الخطة أو الرصيد أو سجل العمليات.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0 pb-0">
                            <h6 class="mb-0">ساعات العمل</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-0">
                                فريق الدعم متاح للمساعدة الفنية على مدار الساعة 24/7.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-support-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .lira-hero-note {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-radius: var(--radius-md);
            background: rgba(0,230,167,0.06);
            border: 1px solid rgba(0,230,167,0.18);
        }

        .lira-hero-note i {
            font-size: 24px;
            color: var(--lira-accent);
        }

        .lira-hero-note strong {
            display: block;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .lira-hero-note span {
            font-size: 12px;
            color: var(--lira-text-muted);
        }

        .lira-chat-shell {
            height: 700px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--lira-border);
            overflow: hidden;
            background: var(--lira-surface);
        }

        .lira-chat-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--lira-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: rgba(255,255,255,0.015);
        }

        .lira-chat-header-main {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .lira-chat-header-avatar {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(0,230,167,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--lira-accent);
            font-size: 20px;
        }

        .lira-chat-online-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: #17b26a;
            border: 2px solid var(--lira-surface);
            border-radius: 50%;
        }

        .lira-chat-header-meta h6 {
            margin-bottom: 4px;
            font-weight: 700;
        }

        .lira-chat-header-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lira-chat-header-status small {
            color: var(--lira-text-muted);
        }

        .lira-status-pill {
            font-size: 10px;
            font-weight: 800;
            padding: 1px 8px;
            border-radius: 99px;
            background: rgba(23,178,106,0.1);
            color: #5fe2a1;
        }

        .lira-chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, transparent 100%);
        }

        .lira-chat-footer {
            padding: 20px 24px 24px;
            border-top: 1px solid var(--lira-border);
            background: rgba(255,255,255,0.005);
        }

        .lira-chat-input-wrap {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .lira-chat-input-wrap .form-control {
            height: 52px;
            background: var(--lira-surface-2) !important;
            border-color: var(--lira-border) !important;
            border-radius: 14px;
            padding: 0 20px;
            font-size: 14px;
        }

        .lira-send-btn {
            min-width: 110px;
            border-radius: 14px !important;
            font-weight: 700 !important;
        }

        .lira-chat-footer-note {
            font-size: 11px;
            color: var(--lira-text-muted);
            text-align: center;
        }

        .lira-guidelines {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lira-guideline-item {
            display: flex;
            gap: 10px;
            font-size: 13px;
            line-height: 1.6;
        }

        .lira-guideline-item i {
            color: var(--lira-accent);
            margin-top: 4px;
            font-size: 12px;
        }

        @media (max-width: 1399.98px) {
            .lira-hero-note {
                width: 100%;
            }
        }
    </style>
@endpush

