@props([
    'title' => '',
    'subtitle' => null,
    'flush' => false,
])

<section class="lira-data-panel">
    <div class="lira-data-panel-head">
        <div>
            <h3 class="lira-data-panel-title">{{ $title }}</h3>

            @if ($subtitle)
                <p class="lira-data-panel-subtitle">{{ $subtitle }}</p>
            @endif
        </div>

        @isset($toolbar)
            <div class="lira-data-panel-toolbar">
                {{ $toolbar }}
            </div>
        @endisset
    </div>

    <div class="lira-data-panel-body {{ $flush ? 'is-flush' : '' }}">
        {{ $slot }}
    </div>
</section>
