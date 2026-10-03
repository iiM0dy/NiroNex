@extends('layouts.site-dash')

@section('title', 'تأكيد عملية السحب')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card lira-table-card mt-5">
                <div class="card-header border-0 text-center pb-0">
                    <div class="lira-shield-icon mb-3 mx-auto" style="width: 64px; height: 64px; background: rgba(0,230,167,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets/images/icons/IMG_7725.PNG') }}" alt="Security" style="width: 32px; height: 32px; object-fit: contain;">
                    </div>
                    <h5 class="mb-2">تأكيد عملية السحب</h5>
                    <p class="text-muted small">
                        حفاظاً على أمان حسابك، قمنا بإرسال رمز تحقق (OTP) مكون من 6 أرقام إلى بريدك الإلكتروني. الرجاء إدخاله أدناه لإتمام طلب السحب.
                    </p>
                </div>
                <div class="card-body pt-4">
                    <form action="{{ route('site.transactions-requests.otp.verify') }}" method="POST">
                        @csrf

                        <div class="lira-input-wrap mb-4">
                            <i class="fa-solid fa-key lira-input-icon"></i>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   class="form-control text-center @error('code') is-invalid @enderror"
                                   placeholder="أدخل الرمز (6 أرقام)"
                                   maxlength="6"
                                   autocomplete="off"
                                   style="letter-spacing: 6px; font-size: 1.2rem; font-weight: 800;"
                                   required>
                            @error('code')
                                <div class="invalid-feedback d-block text-center mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 lira-site-main-btn mt-2">
                            تأكيد الطلب
                            <i class="fa-solid fa-check ms-2"></i>
                        </button>
                        
                        <a href="{{ route('site.transactions-requests.create') }}" class="btn btn-link text-muted text-decoration-none w-100 text-center mt-3" style="font-size: 13px;">
                            إلغاء والعودة
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

