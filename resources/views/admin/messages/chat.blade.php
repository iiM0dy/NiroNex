@extends('layouts.admin')
@section('title', 'محادثة مع ' . $user->full_name)

@section('content')
    <div class="lira-support-page">
        <div class="lira-support-hero mb-4">
            <div>
                <span class="lira-eyebrow">ADMIN · USER COMMUNICATIONS</span>
                <h1 class="lira-page-title">محادثة مع {{ $user->full_name }}</h1>
                <p class="lira-page-subtitle">
                    تواصل مباشر مع العميل لتقديم الدعم أو متابعة الاستفسارات المالية والفنية.
                </p>
            </div>

            <div class="lira-hero-note">
                <i class="fa-solid fa-user-gear"></i>
                <div>
                    <strong>إدارة المحادثة</strong>
                    <span>سيتم إرسال ردودك مباشرة إلى لوحة تحكم العميل.</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-9">
                <!-- Chat Container -->
                <div class="card lira-chat-shell border-0">
                    <div class="lira-chat-header">
                        <div class="lira-chat-header-main">
                            <div class="lira-chat-header-avatar">
                                <i class="fa-solid fa-headset"></i>
                                <span class="lira-chat-online-dot"></span>
                            </div>

                            <div class="lira-chat-header-meta">
                                <h6>الدعم المباشر · {{ $user->full_name }}</h6>
                                <div class="lira-chat-header-status">
                                    <span class="lira-status-pill is-online">متاح الآن</span>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="lira-chat-header-actions">
                            <a href="{{ route('admin.messages.index') }}" class="btn lira-ghost-btn">
                                <i class="fa-solid fa-arrow-right ms-2 mt-1"></i>
                                العودة للقائمة
                            </a>
                        </div>
                    </div>

                    <div class="lira-chat-body">
                        @include('admin.messages.partials.messages')
                    </div>

                    <div class="lira-chat-footer">
                        <div class="lira-chat-input-wrap">
                            <input
                                id="message-input"
                                class="form-control"
                                type="text"
                                placeholder="اكتب ردك هنا..."
                                autocomplete="off"
                            >

                            <button id="send-message" class="btn btn-primary lira-send-btn">
                                <i class="fas fa-paper-plane ms-1"></i>
                                إرسال
                            </button>
                        </div>

                        <div class="lira-chat-footer-note">
                            يتم إرسال الردود مباشرة للعميل. اذكر تفاصيل واضحة لتسريع حل المشكلة.
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
                        <div class="card-header border-0">
                            <h6 class="mb-0">نصيحة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-inline-note">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>
                                    عند مراسلة الدعم، اذكر رقم الطلب أو نوع المشكلة والوقت التقريبي لظهورها إن أمكن.
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card lira-side-card">
                        <div class="card-header border-0">
                            <h6 class="mb-0">روابط سريعة</h6>
                        </div>
                        <div class="card-body">
                            <div class="lira-quick-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-primary">
                                    ملف المستخدم
                                </a>
                                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-primary">
                                    المعاملات المالية
                                </a>
                                <a href="{{ route('admin.messages.index') }}" class="btn lira-ghost-btn text-center">
                                    كل الرسائل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-support-page {
            padding-bottom: 10px;
        }

        .lira-support-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .lira-hero-note {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-width: 280px;
        }

        .lira-hero-note i {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            flex: 0 0 auto;
        }

        .lira-hero-note strong {
            display: block;
            margin-bottom: 3px;
            font-size: 13px;
            color: var(--lira-text);
        }

        .lira-hero-note span {
            color: var(--lira-text-muted);
            font-size: 11px;
            line-height: 1.8;
        }

        /* ─── Chat Shell ─── */
        .lira-chat-shell,
        .lira-side-card {
            overflow: hidden;
        }

        .lira-chat-shell {
            height: calc(100vh - 280px);
            min-height: 500px;
            display: flex;
            flex-direction: column;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.005)),
                var(--lira-surface) !important;
            border: 1px solid var(--lira-border) !important;
            border-radius: var(--lira-radius) !important;
        }

        /* ─── Chat Header ─── */
        .lira-chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--lira-border) !important;
            flex-wrap: wrap;
        }

        .lira-chat-header-main {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .lira-chat-header-avatar {
            position: relative;
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 230, 167, 0.10);
            color: var(--lira-accent);
            font-size: 20px;
            flex: 0 0 auto;
        }

        .lira-chat-online-dot {
            position: absolute;
            left: -1px;
            bottom: -1px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #17b26a;
            border: 2px solid var(--lira-surface);
        }

        .lira-chat-header-meta h6 {
            margin-bottom: 4px;
            font-size: 15px;
            color: var(--lira-text);
        }

        .lira-chat-header-status {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lira-chat-header-status small {
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-status-pill {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-status-pill.is-online {
            background: rgba(23, 178, 106, 0.12);
            color: #5fe2a1;
        }

        .lira-chat-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ─── Chat Body ─── */
        .lira-chat-body {
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at top right, rgba(0, 230, 167, 0.03), transparent 20%),
                rgba(255, 255, 255, 0.01);
        }

        /* ─── Chat Footer ─── */
        .lira-chat-footer {
            padding: 18px 20px 20px;
            border-top: 1px solid var(--lira-border) !important;
            background: rgba(255, 255, 255, 0.015);
        }

        .lira-chat-input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-chat-input-wrap .form-control {
            height: 48px;
            border: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            color: var(--lira-text) !important;
        }

        .lira-send-btn {
            min-width: 110px;
            height: 48px;
            border-radius: 16px !important;
            font-weight: 800;
            flex: 0 0 auto;
        }

        .lira-chat-footer-note {
            margin-top: 10px;
            color: var(--lira-text-muted);
            font-size: 11px;
            text-align: center;
        }

        /* ─── Ghost Button ─── */
        .lira-ghost-btn {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: var(--lira-text-soft) !important;
            border-radius: 12px !important;
            padding: 10px 16px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            transition: all 0.2s ease;
        }

        .lira-ghost-btn:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
        }

        /* ─── Side Cards ─── */
        .lira-side-card {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.005)),
                var(--lira-surface) !important;
            border: 1px solid var(--lira-border) !important;
            border-radius: 20px !important;
        }

        .lira-side-card .card-header {
            background: rgba(255, 255, 255, 0.02) !important;
            padding: 16px 20px !important;
            border-bottom: 1px solid var(--lira-border) !important;
        }

        .lira-side-card h6 {
            color: var(--lira-text);
            font-size: 14px;
            font-weight: 800;
        }

        .lira-guidelines {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lira-guideline-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--lira-text-soft);
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-guideline-item i {
            color: var(--lira-accent);
            margin-top: 4px;
            font-size: 12px;
            flex: 0 0 auto;
        }

        .lira-inline-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .lira-inline-note i {
            color: var(--lira-accent);
            margin-top: 2px;
            flex: 0 0 auto;
        }

        .lira-quick-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .lira-quick-actions .btn {
            border-radius: 14px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
        }

        /* ─── Responsive ─── */
        @media (max-width: 991.98px) {
            .lira-support-hero {
                align-items: flex-start;
            }
        }

        @media (max-width: 767.98px) {
            .lira-chat-shell {
                height: calc(100vh - 200px);
            }

            .lira-chat-header,
            .lira-chat-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .lira-chat-input-wrap {
                flex-direction: column;
                align-items: stretch;
            }

            .lira-send-btn {
                width: 100%;
            }
        }
    </style>
@endpush

