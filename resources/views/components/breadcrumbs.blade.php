<div class="breadcrumbs">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ $title }}</h1>
                    <ul class="breadcrumb-nav">
                        @foreach ($links as $link)
                            @if (is_array($link))
                                <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                            @else
                                <li>{{ $link }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
