    <!-- Start Header Area -->
    <header class="header navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="nav-inner">
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="/">
                                <span class="logo default-logo">@include('includes.logo-white')</span>
                                <span class="logo sticky-logo d-none">@include('includes.logo')</span>
                            </a>
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('site.index') }}" class="active">الرئيسية</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#whyUs">لماذا دولار؟</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/') }}#security">الأمان</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('site.messages.index') }}">تواصل معنا</a>
                                    </li>
                                    @if (auth()->check())
                                        <li class="nav-item d-block d-lg-none">
                                            <a href="{{ route('site.dashboard') }}">لوحة التحكم</a>
                                        </li>
                                    @else
                                        <li class="nav-item d-block d-lg-none">
                                            <a href="{{ route('register') }}">إنشاء حساب</a>
                                        </li>
                                        <li class="nav-item d-block">
                                            <a href="{{ route('login') }}">تسجيل دخول</a>
                                        </li>
                                    @endif
                                </ul>
                            </div> <!-- navbar collapse -->
                            <div class="button">
                                @if (auth()->check())
                                    <a href="{{ route('site.dashboard') }}" class="btn">لوحة التحكم</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn">إبدا الأن</a>
                                @endif
                            </div>
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    <!-- End Header Area -->
