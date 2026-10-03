@props([
    'kicker' => null,
    'title' => '',
    'subtitle' => null,
    'badge' => null,
])

<section class="lira-page-hero">
    <div class="lira-page-hero-copy">
        @if ($kicker)
            <span class="lira-kicker">{{ $kicker }}</span>
        @endif

        <h1 class="lira-page-hero-title">{{ $title }}</h1>

        @if ($subtitle)
            <p class="lira-page-hero-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="lira-page-hero-side">
        @if ($badge)
            <div class="lira-page-hero-badge">{{ $badge }}</div>
        @endif

        @if (trim((string) $slot) !== '')
            <div class="lira-page-hero-actions">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>
