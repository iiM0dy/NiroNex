@props([
    'label' => '',
    'value' => '',
    'icon' => 'fa-solid fa-chart-simple',
    'tone' => 'gold',
    'foot' => null,
])

<article class="lira-metric-tile is-{{ $tone }}">
    <div class="lira-metric-tile-top">
        <span class="lira-metric-tile-label">{{ $label }}</span>

        <span class="lira-metric-tile-icon">
            <i class="{{ $icon }}"></i>
        </span>
    </div>

    <div class="lira-metric-tile-value">{!! $value !!}</div>

    @if ($foot)
        <div class="lira-metric-tile-foot">{{ $foot }}</div>
    @endif
</article>
