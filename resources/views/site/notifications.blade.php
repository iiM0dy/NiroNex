@extends('layouts.site-dash')

@section('title', 'الإشعارات')

@section('content')
    <div class="lira-notifications-page">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ brandAiName() }} · NOTIFICATIONS</span>
                <h1 class="lira-page-title">الإشعارات</h1>
                <p class="lira-page-subtitle">جميع التنبيهات والتحديثات الخاصة بحسابك.</p>
            </div>
        </div>

        @if($notifications->count())
            <div class="lira-notif-list">
                @foreach($notifications as $notif)
                    <div class="lira-notif-item {{ $notif->is_read ? 'is-read' : '' }} {{ $notif->tone }}">
                        <div class="lira-notif-icon">
                            <i class="fa-solid {{ $notif->icon }}"></i>
                        </div>
                        <div class="lira-notif-body">
                            <h6>{{ $notif->title }}</h6>
                            <p>{{ $notif->body }}</p>
                            <span class="lira-notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        @unless($notif->is_read)
                            <form action="{{ route('site.notifications.read', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="lira-notif-read-btn" title="تعليم كمقروء">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        @endunless
                    </div>
                @endforeach
            </div>

            <div class="lira-table-footer mt-3">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="card lira-table-card">
                <div class="card-body">
                    <div class="lira-empty-block">
                        <i class="fa-solid fa-bell-slash"></i>
                        <h5>لا توجد إشعارات</h5>
                        <p>ستظهر هنا تنبيهات الصفقات، حالة الروبوت، وتحديثات المعاملات المالية.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-notif-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lira-notif-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 20px;
            border-radius: var(--radius-md);
            background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.008)), var(--lira-surface);
            border: 1px solid var(--lira-border);
            transition: border-color 0.2s ease;
        }

        .lira-notif-item:not(.is-read) {
            border-left: 3px solid var(--lira-accent);
        }

        .lira-notif-item.is-read {
            opacity: 0.6;
        }

        .lira-notif-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex: 0 0 auto;
            background: rgba(255,255,255,0.04);
            color: var(--lira-text-muted);
        }

        .lira-notif-item.is-trade .lira-notif-icon {
            background: rgba(23,178,106,0.10);
            color: #5fe2a1;
        }

        .lira-notif-item.is-robot .lira-notif-icon {
            background: rgba(99,102,241,0.10);
            color: #818cf8;
        }

        .lira-notif-item.is-withdrawal .lira-notif-icon {
            background: rgba(0,230,167,0.10);
            color: var(--lira-accent);
        }

        .lira-notif-body {
            flex: 1;
            min-width: 0;
        }

        .lira-notif-body h6 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .lira-notif-body p {
            font-size: 13px;
            color: var(--lira-text-soft);
            margin-bottom: 6px;
            line-height: 1.6;
        }

        .lira-notif-time {
            font-size: 11px;
            color: var(--lira-text-muted);
        }

        .lira-notif-read-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--lira-border);
            color: var(--lira-text-muted);
            cursor: pointer;
            transition: all 0.22s ease;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lira-notif-read-btn:hover {
            background: rgba(23,178,106,0.12);
            border-color: rgba(23,178,106,0.3);
            color: #5fe2a1;
        }

        .lira-empty-block {
            min-height: 240px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 10px;
            color: var(--lira-text-muted);
            padding: 28px;
        }

        .lira-empty-block i {
            font-size: 34px;
            color: var(--lira-accent);
        }

        .lira-table-footer {
            padding: 18px 20px 20px;
        }
    </style>
@endpush

