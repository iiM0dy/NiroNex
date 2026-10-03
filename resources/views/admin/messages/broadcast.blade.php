@extends('layouts.admin')
@section('title', 'إرسال توصية جماعية')

@section('content')
    <div class="lira-admin-broadcast-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">BROADCAST</span>
                <h2 class="lira-page-hero-title">إرسال توصية جماعية</h2>
                <p class="lira-page-hero-subtitle">
                    بث رسالة أو توصية للمشتركين بخطط التوصيات والمدير الخاص. سيتم إرسالها لجميع المستفيدين المؤهلين.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <span class="lira-page-hero-badge">
                    <i class="fa-solid fa-bullhorn ms-2"></i>
                    بث جماعي
                </span>
            </div>
        </section>

        <div class="lira-data-panel mb-4">
            <div class="lira-data-panel-head">
                <div>
                    <h5 class="lira-data-panel-title">
                        <i class="fa-solid fa-paper-plane ms-2 ycolor"></i>
                        صياغة التوصية
                    </h5>
                    <p class="lira-data-panel-subtitle">سيتم إرسال هذه الرسالة لجميع المشتركين في خطط التوصيات</p>
                </div>
            </div>

            <div class="lira-data-panel-body">
                <form action="{{ route('admin.messages.broadcast') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">عنوان التوصية (اختياري)</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="مثل: توصية الذهب اليوم">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">نص التوصية</label>
                            <textarea name="body" rows="6" class="form-control" required
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
    </div>
@endsection
