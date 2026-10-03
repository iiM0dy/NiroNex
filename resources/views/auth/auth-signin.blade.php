@extends(backendView('layouts.auth'))

@section('title', 'تسجيل الدخول')

@section('content')
    <x-breadcrumbs title="تسجيل الدخول" :links="[['label' => 'الرئيسة', 'url' => '/'], 'تسجيل الدخول']" />
    <div class="account-login section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10 col-12">
                    <form class="card login-form inner-content" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>تسجيل الدخول</h3>
                            </div>
                            <div class="input-head">
                                <div class="row">

                                    <!-- Email -->
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <span class="mb-2">البريد الالكتروني</span>
                                            <div class="input-group">
                                                <label><i class="lni lni-envelope"></i></label>
                                                <input name="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="البريد الالكتروني" value="{{ old('email') }}" required>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <span class="mb-2">كلمة المرور</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-lock-alt"></i></label>
                                            <input name="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="كلمة المرور" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="button">
                                    <button class="btn" type="submit">متابعة</button>
                                </div>
                                <h4 class="create-account">ليس لديك حساب بعد؟ <a href="{{ route('register') }}">انضم
                                        الأن</a>
                                </h4>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_scripts')
@endpush
