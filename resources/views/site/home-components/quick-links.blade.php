{{-- § 5  QUICK-LINK GRID — mirrors PO Trade "Why choose us?" icon tile nav --}}
<section class="hp-quick-links">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="hp-sec-title">لماذا تختار {{ appName() }}؟</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($quickLinksData as $ql)
            <div class="col-6 col-sm-4 col-md-3 col-lg wow fadeInUp" data-wow-delay=".{{ $loop->index + 1 }}s">
                <a href="{{ $ql['url'] ?? '#' }}" class="hp-ql-card">
                    <i class="{{ $ql['icon'] }}"></i>
                    <span>{{ $ql['title'] }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
