{{-- § 7  PLATFORM / DEVICE ACCESS — mirrors PO Trade "Web application for any device" --}}
<section class="hp-devices">
    <div class="container">
        <div class="text-center mb-4 wow fadeInUp">
            <h2 class="hp-sec-title">تطبيق ويب لأي جهاز</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($platformData as $p)
            <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay=".{{ $loop->index + 1 }}s">
                <a href="{{ $p['url'] ?? '#' }}" class="hp-device-card">
                    <div class="hp-device-icon"><i class="{{ $p['icon'] }}"></i></div>
                    <div class="hp-device-name">{{ $p['name'] }}</div>
                    <div class="hp-device-lbl">{{ $p['label'] }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
