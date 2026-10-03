@extends(backendView('layouts.auth'))

@section('title', 'حساب جديد')

@section('content')
    <x-breadcrumbs title="حساب جديد" :links="[['label' => 'الرئيسة', 'url' => '/'], 'حساب جديد']" />
    <div class="account-login section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10 col-12">
                    <form class="card login-form inner-content" method="POST" action="{{ route('register') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>إنشاء حساب جديد الأن</h3>
                            </div>
                            <div class="input-head">
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <span class="mb-2">الاسم الأول</span>
                                            <div class="input-group">
                                                <label><i class="lni lni-user"></i></label>
                                                <input name="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    placeholder="الاسم الأول" value="{{ old('first_name') }}" required>
                                            </div>
                                            @error('first_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <span class="mb-2">الاسم الثاني</span>
                                            <div class="input-group">
                                                <label><i class="lni lni-user"></i></label>
                                                <input name="last_name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    placeholder="الاسم الثاني" value="{{ old('last_name') }}" required>
                                            </div>
                                            @error('last_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Birthdate -->
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <span class="mb-2">تاريخ الميلاد</span>
                                            <div class="input-group">
                                                <label><i class="lni lni-calendar"></i></label>
                                                <input name="birthdate" type="date"
                                                    class="form-control @error('birthdate') is-invalid @enderror"
                                                    value="{{ old('birthdate') }}" required>
                                            </div>
                                            @error('birthdate')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

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

                                    <!-- Phone -->
                                    <div class="form-group d-flex flex-column">
                                        <span class="mb-2">رقم الموبايل</span>
                                        <div class="d-flex flex-nowrap gap-2">
                                            <div class="input-group w-75">
                                                <label><i class="lni lni-phone"></i></label>
                                                <input name="phone" type="number"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    placeholder="رقم الموبايل" required value="{{ old('phone') }}">
                                            </div>
                                            <div class="input-group w-25">
                                                <select name="country_code" id="country-code"
                                                    class="form-control @error('country_code') is-invalid @enderror"
                                                    style="max-width: 120px;padding: 0 12px;" required>
                                                    <option value="">رمز الدولة</option>
                                                </select>
                                            </div>
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

                                    <!-- Confirm Password -->
                                    <div class="form-group">
                                        <span class="mb-2">تأكيد كلمة المرور</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-lock-alt"></i></label>
                                            <input name="password_confirmation" type="password" class="form-control"
                                                placeholder="تأكيد كلمة المرور" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <span class="mb-2">نوع الوثيقة</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-license"></i></label>
                                            @php
                                                use App\Enums\IDPhotoType;
                                                $documentTypes = IDPhotoType::cases();
                                            @endphp
                                            <select name="document_type"
                                                class="form-control @error('document_type') is-invalid @enderror" required>
                                                <option value="">اختر نوع الوثيقة</option>
                                                @foreach ($documentTypes as $type)
                                                    <option value="{{ $type->value }}"
                                                        {{ old('document_type') === $type->name ? 'selected' : '' }}>
                                                        {{ $type->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('document_type')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <span class="mb-2">صورة الوجه الأول</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-upload"></i></label>
                                            <input type="file" name="id_photo_front"
                                                class="form-control @error('id_photo_front') is-invalid @enderror"
                                                accept="image/*">
                                        </div>
                                        @error('id_photo_front')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <span class="mb-2">صورة الوجه الثاني</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-upload"></i></label>
                                            <input type="file" name="id_photo_back"
                                                class="form-control @error('id_photo_back') is-invalid @enderror"
                                                accept="image/*">
                                        </div>
                                        @error('id_photo_back')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <span class="mb-2">رفع صورة السيلفي مع الوثيقة</span>
                                        <div class="input-group">
                                            <label><i class="lni lni-camera"></i></label>
                                            <input type="file" name="selfie_with_document"
                                                class="form-control @error('selfie_with_document') is-invalid @enderror"
                                                accept="image/*">
                                        </div>
                                        @error('selfie_with_document')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="button">
                                    <button class="btn" type="submit">متابعة</button>
                                </div>
                                <h4 class="create-account">لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل
                                        الدخول</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const select = document.getElementById('country-code');

            try {
                const res = await fetch('https://restcountries.com/v3.1/all?fields=name,idd,translations');
                const countries = await res.json();

                // Filter countries with valid IDD info, then map to {name, code}
                const codes = countries
                    .filter(c => c.idd && c.idd.root)
                    .map(c => {
                        const code = c.idd.root + (c.idd.suffixes && c.idd.suffixes.length ? c.idd.suffixes[
                            0] : '');
                        // Use Arabic name if exists, otherwise fallback to English common name
                        const name = c.translations?.ara?.common || c.name?.common || 'Unknown';
                        return {
                            name,
                            code
                        };
                    })
                    .sort((a, b) => a.name.localeCompare(b.name));

                // Append options
                codes.forEach(({
                    name,
                    code
                }) => {
                    const option = document.createElement('option');
                    option.value = code.startsWith('+') ? code : `+${code}`;
                    option.textContent = `${name} (${option.value})`;
                    select.appendChild(option);
                });

                // Set default value if exists in options
                if ([...select.options].some(opt => opt.value === '+963')) {
                    select.value = '+963';
                }

            } catch (error) {
                console.error('Error fetching country codes:', error);
            }
        });
    </script>
@endpush
