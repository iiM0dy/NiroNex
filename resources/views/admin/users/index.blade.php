@extends('layouts.admin')
@section('title', 'العملاء')

@section('content')
    @php
        $usersCollection = collect(method_exists($users, 'items') ? $users->items() : $users);
        $totalUsersCount = method_exists($users, 'total') ? $users->total() : $usersCollection->count();

        $activeCount = $usersCollection->filter(fn($u) => $u->status === \App\Enums\UserStatus::Active)->count();
        $pendingCount = $usersCollection->filter(fn($u) => $u->status === \App\Enums\UserStatus::Pending)->count();
        $inactiveCount = $usersCollection->filter(fn($u) => $u->status === \App\Enums\UserStatus::Inactive)->count();
    @endphp

    <div class="lira-admin-users-page">
        <section class="lira-admin-users-hero mb-4">
            <div>
                <span class="lira-admin-users-kicker">CLIENTS CONTROL</span>
                <h2 class="lira-admin-users-title">إدارة العملاء</h2>
                <p class="lira-admin-users-subtitle">
                    متابعة المستثمرين المسجلين، مراجعة حالتهم، والوصول السريع إلى ملفاتهم التفصيلية.
                </p>
            </div>

            <div class="lira-admin-users-hero-side">
                <span class="lira-admin-users-total-badge">
                    {{ number_format($totalUsersCount) }} مستثمر
                </span>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="lira-admin-user-stat is-accent">
                    <div class="lira-admin-user-stat-top">
                        <span class="lira-admin-user-stat-label">إجمالي العملاء</span>
                        <div class="lira-admin-user-stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div class="lira-admin-user-stat-value">{{ number_format($totalUsersCount) }}</div>
                    <div class="lira-admin-user-stat-foot">إجمالي الحسابات في النظام</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-user-stat is-success">
                    <div class="lira-admin-user-stat-top">
                        <span class="lira-admin-user-stat-label">نشطون في النتائج الحالية</span>
                        <div class="lira-admin-user-stat-icon">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div class="lira-admin-user-stat-value">{{ number_format($activeCount) }}</div>
                    <div class="lira-admin-user-stat-foot">حسابات فعالة ضمن الصفحة الحالية</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-user-stat is-warning">
                    <div class="lira-admin-user-stat-top">
                        <span class="lira-admin-user-stat-label">معلّقون في النتائج الحالية</span>
                        <div class="lira-admin-user-stat-icon">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="lira-admin-user-stat-value">{{ number_format($pendingCount) }}</div>
                    <div class="lira-admin-user-stat-foot">حسابات تنتظر المراجعة أو التفعيل</div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="lira-admin-user-stat is-danger">
                    <div class="lira-admin-user-stat-top">
                        <span class="lira-admin-user-stat-label">معطّلون في النتائج الحالية</span>
                        <div class="lira-admin-user-stat-icon">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>
                    </div>
                    <div class="lira-admin-user-stat-value">{{ number_format($inactiveCount) }}</div>
                    <div class="lira-admin-user-stat-foot">حسابات موقوفة أو غير مفعلة</div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-12">
                @php
                    $handedData = $usersCollection->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'display_id' => '#' . str_pad($value->id, 4, '0', STR_PAD_LEFT),
                            'name' => trim($value->first_name . ' ' . $value->last_name),
                            'email' => $value->email,
                            'phone' => $value->phone,
                            'status' => renderStatusBadge($value->status),
                            'plan' => $value->plan->display_name ?? '—',
                        ];
                    });
                @endphp

                <x-table :nativeData="$users" title="قائمة العملاء" :columns="[
                    'display_id' => 'ID العميل',
                    'name' => 'اسم العميل',
                    'email' => 'البريد الالكتروني',
                    'phone' => 'رقم الموبايل',
                    'status' => 'حالة المستخدم',
                    'plan' => 'الخطة',
                ]" :rows="$handedData->toArray()" :actions="[
                    ['type' => 'show', 'route' => 'admin.users.show', 'key' => 'id'],
                    ['type' => 'delete', 'route' => 'admin.users.destroy', 'key' => 'id'],
                ]" />
            </div>
        </section>
    </div>
@endsection

@push('custom_styles')
    <style>
        .lira-admin-users-page {
            padding-bottom: 10px;
        }

        .lira-admin-users-hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .lira-admin-users-kicker {
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

        .lira-admin-users-title {
            margin: 0 0 10px;
            font-size: clamp(1.5rem, 2.2vw, 2rem);
            color: var(--lira-text);
        }

        .lira-admin-users-subtitle {
            margin: 0;
            color: var(--lira-text-muted);
            font-size: 14px;
            line-height: 1.9;
            max-width: 760px;
        }

        .lira-admin-users-total-badge {
            display: inline-flex;
            align-items: center;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(240, 68, 56, 0.10);
            border: 1px solid rgba(240, 68, 56, 0.18);
            color: #ff8a80;
            font-size: 13px;
            font-weight: 800;
        }

        .lira-admin-user-stat {
            height: 100%;
            min-height: 148px;
            padding: 20px;
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.01)),
                var(--lira-surface-2);
            border: 1px solid var(--lira-border);
            position: relative;
            overflow: hidden;
        }

        .lira-admin-user-stat::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 90px;
            height: 90px;
            background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 70%);
            pointer-events: none;
        }

        .lira-admin-user-stat.is-accent { border-top: 2px solid var(--lira-accent); }
        .lira-admin-user-stat.is-success { border-top: 2px solid var(--lira-success); }
        .lira-admin-user-stat.is-warning { border-top: 2px solid var(--lira-warning); }
        .lira-admin-user-stat.is-danger { border-top: 2px solid var(--lira-danger); }

        .lira-admin-user-stat-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .lira-admin-user-stat-label {
            display: block;
            color: var(--lira-text-muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lira-admin-user-stat-value {
            display: block;
            color: var(--lira-text);
            font-size: clamp(1.5rem, 2vw, 2rem);
            line-height: 1.1;
            font-weight: 800;
        }

        .lira-admin-user-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.04);
            flex: 0 0 auto;
        }

        .lira-admin-user-stat.is-accent .lira-admin-user-stat-icon {
            color: var(--lira-accent);
            background: rgba(0, 230, 167, 0.10);
        }

        .lira-admin-user-stat.is-success .lira-admin-user-stat-icon {
            color: var(--lira-success);
            background: rgba(23, 178, 106, 0.10);
        }

        .lira-admin-user-stat.is-warning .lira-admin-user-stat-icon {
            color: var(--lira-warning);
            background: rgba(120, 97, 255, 0.10);
        }

        .lira-admin-user-stat.is-danger .lira-admin-user-stat-icon {
            color: var(--lira-danger);
            background: rgba(240, 68, 56, 0.10);
        }

        .lira-admin-user-stat-foot {
            color: var(--lira-text-muted);
            font-size: 12px;
            line-height: 1.8;
        }
    </style>
@endpush

