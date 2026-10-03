@extends('layouts.site-dash')
@section('title', 'التوصيات')
@section('content')
    <div class="container py-4">
        @php
            $p = auth()->user()->plan;
        @endphp
        @if ($p && ($p->recommendation || $p->privet_manger))
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 d-flex align-items-center justify-content-center border border-primary border-opacity-25"
                            style="width: 55px; height: 55px;">
                            <i class="fas fa-bullhorn ycolor fs-3"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-white">مركز التوصيات</h3>
                            <p class="text-muted mb-0 small">إشارات السوق الذكية من خبراء {{ appName() }}</p>
                        </div>
                    </div>
                </div>
            </div><!-- Row end  -->

            @if ($messages->isEmpty())
                <div class="alert alert-info text-center">
                    لا توجد توصيات حالياً.
                </div>
            @else
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: var(--lira-card);">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach ($messages as $message)
                                        <div
                                            class="list-group-item bg-transparent border-white border-opacity-10 p-4 transition-all hover-translate-x">
                                            <div class="d-flex justify-content-between align-items-start gap-4">
                                                <div class="d-flex flex-column">
                                                    @if ($message->title)
                                                        <h5
                                                            class="fw-bold mb-2 {{ $message->is_read ? 'opacity-50 text-white' : 'ycolor' }}">
                                                            {{ $message->title }}</h5>
                                                    @endif
                                                    <div class="text-white {{ $message->is_read ? 'opacity-40 text-decoration-line-through' : 'opacity-80' }}"
                                                        style="line-height: 1.6;">
                                                        {!! $message->body !!}
                                                    </div>
                                                </div>
                                                <div class="text-start shrink-0">
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2 small">
                                                        <i class="far fa-clock me-1"></i> {{ formatDate($message->created_at) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Row end  -->
            @endif
        @else
            <div class="container-xxl">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: var(--lira-card);">
                        <div class="card-body text-center p-5">
                            <div class="rounded-circle bg-primary bg-opacity-5 d-flex align-items-center justify-content-center mx-auto mb-4"
                                style="width: 100px; height: 100px; border: 1px dashed var(--lira-accent);">
                                <i class="fas fa-lock ycolor fs-1"></i>
                            </div>
                            <div class="mt-4 mb-4">
                                <h4 class="text-white fw-bold mb-2">خدمة التوصيات غير مفعلة</h4>
                                <p class="text-muted mx-auto" style="max-width: 400px;">هذه الباقة لا تدعم الوصول لإشارات
                                    الخبراء. يمكنك ترقية خطتك الاستثمارية الآن للبدء في استلام توصيات السوق الاحترافية.</p>
                            </div>
                            <a href="{{ route('site.deposit') }}"
                                class="btn btn-primary px-5 py-3 rounded-3 fw-bold lift shadow-lg">
                                <i class="fas fa-rocket me-2 ms-2"></i> ترقية الخطة الآن
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
