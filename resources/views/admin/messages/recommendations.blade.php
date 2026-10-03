@extends('layouts.admin')
@section('title', 'التوصيات العامة')

@section('content')
    <div class="lira-admin-recommendations-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">RECOMMENDATIONS</span>
                <h2 class="lira-page-hero-title">التوصيات العامة</h2>
                <p class="lira-page-hero-subtitle">
                    بث رسالة أو توصية لجميع المستخدمين في النظام ومتابعة سجل التوصيات السابقة.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <span class="lira-page-hero-badge">
                    <i class="fa-solid fa-bullhorn ms-2"></i>
                    توصيات عامة
                </span>
            </div>
        </section>

        <div class="lira-data-panel mb-4">
            <div class="lira-data-panel-head">
                <div>
                    <h5 class="lira-data-panel-title">
                        <i class="fa-solid fa-paper-plane ms-2 ycolor"></i>
                        إرسال توصية جديدة
                    </h5>
                    <p class="lira-data-panel-subtitle">سيتم إرسال هذه التوصية لجميع المستخدمين المسجلين في النظام</p>
                </div>
            </div>

            <div class="lira-data-panel-body">
                <form action="{{ route('admin.messages.recommendations-post') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">عنوان التوصية (اختياري)</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="مثل: توصية الذهب اليوم">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">نص التوصية</label>
                            <textarea name="body" rows="4" class="form-control" required
                                placeholder="مثال: نوصي بشراء XAU/USD فوق مستوى 2320..."></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-5 py-3">
                                <i class="fa-solid fa-paper-plane ms-2"></i>
                                إرسال التوصية الآن
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (!$messages->isEmpty())
            <div class="lira-data-panel">
                <div class="lira-data-panel-head">
                    <div>
                        <h5 class="lira-data-panel-title">
                            <i class="fa-solid fa-clock-rotate-left ms-2 ycolor"></i>
                            سجل التوصيات المرسلة
                        </h5>
                        <p class="lira-data-panel-subtitle">{{ $messages->count() }} توصية مُرسلة</p>
                    </div>
                </div>

                <div class="lira-data-panel-body is-flush">
                    @foreach ($messages as $message)
                        <div class="lira-recommendation-item {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div class="flex-grow-1">
                                    @if ($message->title)
                                        <h6 class="fw-bold ycolor mb-2" style="font-size: 14px;">{{ $message->title }}</h6>
                                    @endif
                                    <p class="mb-0" style="color: var(--lira-text-soft); line-height: 1.8; font-size: 14px;">{{ $message->body }}</p>
                                </div>
                                <div class="text-start" style="min-width: 110px; flex: 0 0 auto;">
                                    <span class="lira-page-hero-badge" style="font-size: 11px; min-height: 32px; padding: 0 10px;">
                                        {{ formatDate($message->created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-recommendation-item {
            padding: 20px 22px;
            transition: background 0.2s ease;
        }

        .lira-recommendation-item:hover {
            background: rgba(255, 255, 255, 0.015);
        }
    </style>
@endpush
