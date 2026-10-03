@extends('layouts.admin')

@section('title', 'التحقق KYC')

@section('content')
    @php
        $statusTabs = [
            'all' => ['label' => 'الكل', 'count' => $stats['total'] ?? 0],
            'pending' => ['label' => 'قيد المراجعة', 'count' => $stats['pending'] ?? 0],
            'active' => ['label' => 'موافق عليه', 'count' => $stats['active'] ?? 0],
            'inactive' => ['label' => 'مرفوض', 'count' => $stats['inactive'] ?? 0],
            'missing_docs' => ['label' => 'ناقص الوثائق', 'count' => $stats['missing_docs'] ?? 0],
        ];

        $statusLabel = function ($user) {
            return match ($user->status) {
                \App\Enums\UserStatus::Active => ['label' => 'موافق عليه', 'class' => 'is-success'],
                \App\Enums\UserStatus::Inactive => ['label' => 'مرفوض / معطل', 'class' => 'is-danger'],
                default => ['label' => 'قيد المراجعة', 'class' => 'is-warning'],
            };
        };

        $docUrl = fn ($user, $field) => $user->{$field} ? $user->getStorageUrl($user->{$field}) : null;
    @endphp

    <div class="lira-kyc-page">
        <section class="lira-page-hero mb-4">
            <div class="lira-page-hero-copy">
                <span class="lira-kicker">KYC VERIFICATION</span>
                <h1 class="lira-page-hero-title">مراجعة وثائق التحقق</h1>
                <p class="lira-page-hero-subtitle">
                    متابعة العملاء الذين رفعوا وثائق الهوية، مراجعة الصور، واعتماد أو رفض حالة التحقق من صفحة مستقلة.
                </p>
            </div>

            <div class="lira-page-hero-side">
                <span class="lira-page-hero-badge">{{ number_format($stats['pending'] ?? 0) }} قيد المراجعة</span>
                <span class="lira-page-hero-badge">{{ number_format($stats['total'] ?? 0) }} ملف مرفوع</span>
            </div>
        </section>

        <section class="lira-filter-panel mb-4">
            <form method="GET" class="lira-filter-form">
                <div class="lira-filter-tabs" role="tablist" aria-label="KYC status filters">
                    @foreach ($statusTabs as $key => $tab)
                        <a href="{{ route('admin.verification-kyc.index', array_filter(['status' => $key, 'search' => request('search')])) }}"
                            class="lira-filter-tab {{ $status === $key ? 'is-active' : '' }}">
                            <span>{{ $tab['label'] }}</span>
                            <strong>{{ number_format($tab['count']) }}</strong>
                        </a>
                    @endforeach
                </div>

                <div class="lira-filter-search">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="بحث بالاسم، البريد، أو الهاتف...">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </form>
        </section>

        <section class="lira-kyc-grid">
            @forelse ($users as $user)
                @php
                    $badge = $statusLabel($user);
                    $frontUrl = $docUrl($user, 'id_photo_front');
                    $backUrl = $docUrl($user, 'id_photo_back');
                    $selfieUrl = $docUrl($user, 'selfie_photo');
                    $docsCount = collect([$frontUrl, $backUrl, $selfieUrl])->filter()->count();
                @endphp

                <article class="lira-kyc-card">
                    <div class="lira-kyc-card-head">
                        <div>
                            <span class="lira-kyc-id">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <h2>{{ $user->full_name }}</h2>
                            <p>{{ $user->email }}</p>
                        </div>
                        <span class="lira-status-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    </div>

                    <div class="lira-kyc-meta">
                        <span><strong>الهاتف</strong>{{ $user->phone ?: 'غير محدد' }}</span>
                        <span><strong>نوع الهوية</strong>{{ $user->id_photo_type ?: 'غير محدد' }}</span>
                        <span><strong>الوثائق</strong>{{ $docsCount }}/3</span>
                        <span><strong>التسجيل</strong>{{ formatDate($user->created_at) }}</span>
                    </div>

                    <div class="lira-kyc-docs">
                        @foreach ([['label' => 'الأمامية', 'url' => $frontUrl], ['label' => 'الخلفية', 'url' => $backUrl], ['label' => 'السيلفي', 'url' => $selfieUrl]] as $doc)
                            @if ($doc['url'])
                                <a href="{{ $doc['url'] }}" target="_blank" class="lira-kyc-doc">
                                    <img src="{{ $doc['url'] }}" alt="{{ $doc['label'] }} - {{ $user->full_name }}">
                                    <span>{{ $doc['label'] }}</span>
                                </a>
                            @else
                                <div class="lira-kyc-doc is-empty">
                                    <i class="fa-solid fa-image"></i>
                                    <span>{{ $doc['label'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="lira-kyc-actions">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-primary">ملف العميل</a>
                        <a href="{{ route('admin.messages.chat', $user) }}" class="btn btn-secondary">مراسلة</a>

                        @if ($user->status !== \App\Enums\UserStatus::Active)
                            <form method="POST" action="{{ route('admin.verification-kyc.approve', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">اعتماد</button>
                            </form>
                        @endif

                        @if ($user->status !== \App\Enums\UserStatus::Inactive)
                            <form method="POST" action="{{ route('admin.verification-kyc.reject', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">رفض</button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="lira-empty-state">لا توجد ملفات تحقق مطابقة للفلاتر الحالية.</div>
            @endforelse
        </section>

        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-filter-panel,
        .lira-kyc-card {
            border: 1px solid var(--lira-border);
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)), var(--lira-surface-2);
        }

        .lira-filter-panel {
            padding: 16px;
        }

        .lira-filter-form,
        .lira-filter-search {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lira-filter-tabs {
            display: flex;
            gap: 8px;
            flex: 1 1 auto;
            flex-wrap: wrap;
        }

        .lira-filter-tab {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 13px;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 999px;
            background: rgba(255,255,255,0.025);
            color: var(--lira-text-soft);
            font-size: 12px;
            font-weight: 800;
        }

        .lira-filter-tab.is-active {
            color: var(--lira-accent);
            border-color: rgba(0, 230, 167, 0.26);
            background: rgba(0, 230, 167, 0.1);
        }

        .lira-filter-search {
            flex: 0 1 430px;
        }

        .lira-filter-search .form-control {
            min-width: 240px;
        }

        .lira-kyc-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .lira-kyc-card {
            padding: 18px;
        }

        .lira-kyc-card-head,
        .lira-kyc-actions {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .lira-kyc-card h2 {
            margin: 4px 0 4px;
            font-size: 1.05rem;
        }

        .lira-kyc-card p,
        .lira-kyc-id {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 12px;
        }

        .lira-status-badge {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
        }

        .lira-status-badge.is-success { background: rgba(23, 178, 106, 0.12); color: #63ddab; }
        .lira-status-badge.is-warning { background: rgba(120, 97, 255, 0.12); color: #c4b6ff; }
        .lira-status-badge.is-danger { background: rgba(240, 68, 56, 0.12); color: #ff8a80; }

        .lira-kyc-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin: 16px 0;
        }

        .lira-kyc-meta span {
            padding: 10px 12px;
            border-radius: 14px;
            background: rgba(255,255,255,0.025);
            color: var(--lira-text-soft);
            font-size: 12px;
            line-height: 1.6;
        }

        .lira-kyc-meta strong {
            display: block;
            margin-bottom: 4px;
            color: var(--lira-text-muted);
            font-size: 10px;
        }

        .lira-kyc-docs {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .lira-kyc-doc {
            position: relative;
            display: block;
            height: 112px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            background: rgba(255,255,255,0.025);
        }

        .lira-kyc-doc img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lira-kyc-doc span {
            position: absolute;
            right: 8px;
            bottom: 8px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(5, 8, 14, 0.78);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
        }

        .lira-kyc-doc.is-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--lira-text-muted);
        }

        .lira-kyc-actions {
            justify-content: flex-start;
        }

        .lira-kyc-actions form,
        .lira-kyc-actions .btn {
            min-width: 98px;
        }

        .lira-kyc-actions form .btn {
            width: 100%;
        }

        @media (max-width: 1199.98px) {
            .lira-kyc-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .lira-filter-search,
            .lira-filter-search .form-control,
            .lira-filter-search .btn,
            .lira-kyc-actions,
            .lira-kyc-actions .btn,
            .lira-kyc-actions form {
                width: 100%;
            }

            .lira-kyc-card {
                padding: 14px;
                border-radius: 18px;
            }

            .lira-kyc-meta,
            .lira-kyc-docs {
                grid-template-columns: 1fr;
            }

            .lira-kyc-doc {
                height: 170px;
            }
        }
    </style>
@endpush
