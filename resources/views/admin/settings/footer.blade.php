@extends('layouts.admin')

@section('title', 'إعدادات الفوتر')

@push('styles')
    <style>
        .lira-footer-settings-card {
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01)) !important;
            box-shadow: var(--shadow-soft);
        }

        .lira-footer-settings-card .card-header {
            background: transparent !important;
        }

        .lira-footer-settings-card .card-header h6,
        .lira-footer-settings-card .card-header p,
        .lira-footer-settings-card .form-label,
        .lira-footer-settings-card .invalid-feedback,
        .lira-page-header .lira-page-subtitle,
        .lira-footer-settings-card .lira-page-subtitle {
            color: var(--lira-text) !important;
        }

        .lira-footer-settings-card .form-control,
        .lira-footer-settings-card textarea {
            color: var(--lira-text) !important;
        }

        .lira-footer-settings-note {
            padding: 16px 18px;
            border-radius: 16px;
            background: rgba(0, 230, 167, 0.08);
            border: 1px solid rgba(0, 230, 167, 0.16);
            color: var(--lira-text) !important;
            font-size: 13px;
            line-height: 1.8;
        }

        .lira-footer-preview {
            display: grid;
            gap: 14px;
        }

        .lira-footer-preview-item {
            padding: 14px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .lira-footer-preview-label {
            display: block;
            margin-bottom: 6px;
            color: var(--lira-text) !important;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .lira-footer-preview-value {
            margin: 0;
            color: var(--lira-text);
            line-height: 1.8;
            word-break: break-word;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="lira-page-header mb-4">
            <div>
                <span class="lira-eyebrow">{{ appName() }} ADMIN · FOOTER SETTINGS</span>
                <h1 class="lira-page-title">إعدادات الفوتر</h1>
                <p class="lira-page-subtitle">من هنا يمكنك تعديل وصف المنصة، بريد الدعم، وروابط الشبكات الاجتماعية الظاهرة في الفوتر بدون لمس القالب.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.footer.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="card lira-footer-settings-card">
                        <div class="card-header border-0 pb-0">
                            <h6 class="mb-1">المحتوى الرئيسي</h6>
                            <p class="text-muted mb-0">أي حقل تتركه فارغاً سيتم إخفاؤه أو استبداله بالقيمة الافتراضية المناسبة.</p>
                        </div>

                        <div class="card-body">
                            <div class="mb-4">
                                <label for="site_description" class="form-label">وصف الموقع</label>
                                <textarea id="site_description" name="site_description" rows="5"
                                    class="form-control @error('site_description') is-invalid @enderror"
                                    placeholder="اكتب النص التعريفي الذي يظهر أسفل الشعار في الفوتر...">{{ old('site_description', $settings['site_description']) }}</textarea>
                                @error('site_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="support_email" class="form-label">بريد الدعم</label>
                                    <input id="support_email" type="email" name="support_email"
                                        value="{{ old('support_email', $settings['support_email']) }}"
                                        class="form-control @error('support_email') is-invalid @enderror"
                                        placeholder="support@example.com">
                                    @error('support_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="copyright_text" class="form-label">نص الحقوق</label>
                                    <input id="copyright_text" type="text" name="copyright_text"
                                        value="{{ old('copyright_text', $settings['copyright_text']) }}"
                                        class="form-control @error('copyright_text') is-invalid @enderror"
                                        placeholder="© {{ now()->year }} {{ appName() }} — جميع الحقوق محفوظة">
                                    @error('copyright_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="instagram_url" class="form-label">رابط Instagram</label>
                                    <input id="instagram_url" type="url" name="instagram_url"
                                        value="{{ old('instagram_url', $settings['instagram_url']) }}"
                                        class="form-control @error('instagram_url') is-invalid @enderror"
                                        placeholder="https://instagram.com/yourpage">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="telegram_url" class="form-label">رابط Telegram</label>
                                    <input id="telegram_url" type="url" name="telegram_url"
                                        value="{{ old('telegram_url', $settings['telegram_url']) }}"
                                        class="form-control @error('telegram_url') is-invalid @enderror"
                                        placeholder="https://t.me/yourchannel">
                                    @error('telegram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-0 pt-0">
                            <button type="submit" class="btn btn-primary px-4">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card lira-footer-settings-card mb-4">
                        <div class="card-header border-0 pb-0">
                            <h6 class="mb-1">معاينة سريعة</h6>
                            <p class="text-muted mb-0">ملخص للقيم الحالية المحفوظة في الفوتر.</p>
                        </div>

                        <div class="card-body">
                            <div class="lira-footer-preview">
                                <div class="lira-footer-preview-item">
                                    <span class="lira-footer-preview-label">الوصف</span>
                                    <p class="lira-footer-preview-value mb-0">{{ $settings['site_description'] }}</p>
                                </div>

                                <div class="lira-footer-preview-item">
                                    <span class="lira-footer-preview-label">بريد الدعم</span>
                                    <p class="lira-footer-preview-value mb-0">{{ $settings['support_email'] ?: 'مخفي حالياً' }}</p>
                                </div>

                                <div class="lira-footer-preview-item">
                                    <span class="lira-footer-preview-label">Instagram</span>
                                    <p class="lira-footer-preview-value mb-0">{{ $settings['instagram_url'] ?: 'غير مضاف' }}</p>
                                </div>

                                <div class="lira-footer-preview-item">
                                    <span class="lira-footer-preview-label">Telegram</span>
                                    <p class="lira-footer-preview-value mb-0">{{ $settings['telegram_url'] ?: 'غير مضاف' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lira-footer-settings-note">
                        روابط الشبكات الاجتماعية تُعرض فقط عند إدخال رابط صحيح. ويمكنك ترك البريد فارغاً إذا كنت لا تريد إظهاره داخل الفوتر حالياً.
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

