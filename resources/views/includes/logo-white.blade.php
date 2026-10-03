@php
    $asText = $asText ?? false;
    $variant = (string) ($variant ?? '3');
    $logoSrc = asset('assets/images/home/' . ($variant === '2' ? 'LOGO-NIRO-2.png' : 'LOGO-NIRO-3.png'));
@endphp

<span class="niro-logo {{ $asText ? 'niro-logo--text' : 'niro-logo--image' }}" aria-label="{{ appName() }}">
    @if ($asText)
        <span class="niro-logo__wordmark" dir="ltr">
            <span class="niro-logo__word-base">Niro</span><span class="niro-logo__word-accent">Nex</span>
        </span>
    @else
        <img src="{{ $logoSrc }}" alt="{{ appName() }}" class="niro-logo__image" loading="eager" style="display:block;width:100%;max-width:112px;height:auto;object-fit:contain;">
    @endif
</span>
