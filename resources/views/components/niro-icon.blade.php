@props([
    'name' => 'dashboard',
    'size' => 20,
    'stroke' => 1.9,
])

@php
    $aliases = [
        'gauge' => 'dashboard',
        'trading' => 'markets',
        'chart' => 'markets',
        'robot' => 'robot',
        'bot' => 'robot',
        'alerts' => 'signals',
        'performance' => 'portfolio',
        'deposit' => 'wallet',
        'plans' => 'academy',
        'plan' => 'academy',
        'user' => 'users',
        'account' => 'settings',
        'messages' => 'support',
        'message' => 'support',
        'notifications' => 'bell',
        'notification' => 'bell',
        'shield' => 'security',
        'check' => 'status',
        'transactions' => 'transfer',
        'transaction' => 'transfer',
        'withdraw' => 'transfer',
        'site' => 'globe',
    ];

    $resolvedName = $aliases[$name] ?? $name;
    $iconAttributes = $attributes
        ->class([
            'niro-icon',
            'niro-icon--' . $resolvedName,
        ])
        ->merge([
            'viewBox' => '0 0 24 24',
            'width' => $size,
            'height' => $size,
            'fill' => 'none',
            'stroke' => 'currentColor',
            'stroke-width' => $stroke,
            'stroke-linecap' => 'round',
            'stroke-linejoin' => 'round',
            'aria-hidden' => 'true',
            'focusable' => 'false',
        ]);
@endphp

@switch($resolvedName)
    @case('dashboard')
        <svg {{ $iconAttributes }}>
            <path d="M4 13.4a8 8 0 1 1 16 0" />
            <path d="M4.9 17.8h14.2" />
            <path d="m12 12.6 3.25-4.15" />
            <circle cx="12" cy="12.6" r="1.55" />
            <path d="M7.25 13.5h.01" />
            <path d="M16.75 13.5h.01" />
        </svg>
        @break

    @case('home')
        <svg {{ $iconAttributes }}>
            <path d="M3.8 11.1 12 4.25l8.2 6.85" />
            <path d="M6.2 10.4v8.2A1.4 1.4 0 0 0 7.6 20h8.8a1.4 1.4 0 0 0 1.4-1.4v-8.2" />
            <path d="M10 20v-5.2h4V20" />
        </svg>
        @break

    @case('markets')
        <svg {{ $iconAttributes }}>
            <path d="M4 19.5H20" />
            <path d="M4.5 19.5V5.5" />
            <path d="M7.5 15.5 11 12l3.2 3.1L19 9.2" />
            <path d="M15.8 9.2H19V12.4" />
        </svg>
        @break

    @case('signals')
        <svg {{ $iconAttributes }}>
            <circle cx="12" cy="12" r="6.75" />
            <circle cx="12" cy="12" r="1.6" />
            <path d="M12 2.75V5.2" />
            <path d="M12 18.8V21.25" />
            <path d="M2.75 12H5.2" />
            <path d="M18.8 12H21.25" />
        </svg>
        @break

    @case('portfolio')
        <svg {{ $iconAttributes }}>
            <path d="M12 3.5A8.5 8.5 0 1 1 3.5 12H12z" />
            <path d="M12 3.5A8.5 8.5 0 0 1 20.5 12H12z" />
            <path d="M12 12v8.5" />
        </svg>
        @break

    @case('academy')
        <svg {{ $iconAttributes }}>
            <path d="M3 9.5 12 5l9 4.5-9 4.5z" />
            <path d="M7 11.75v4c1.25 1.2 3 1.85 5 1.85s3.75-.65 5-1.85v-4" />
            <path d="M18.5 10.9v4.4" />
        </svg>
        @break

    @case('wallet')
        <svg {{ $iconAttributes }}>
            <path d="M4 8.5A2.5 2.5 0 0 1 6.5 6h10A2.5 2.5 0 0 1 19 8.5v7A2.5 2.5 0 0 1 16.5 18h-10A2.5 2.5 0 0 1 4 15.5z" />
            <path d="M14.5 12.5H19" />
            <circle cx="14.5" cy="12.5" r="0.7" fill="currentColor" stroke="none" />
        </svg>
        @break

    @case('settings')
        <svg {{ $iconAttributes }}>
            <circle cx="12" cy="12" r="3.1" />
            <path d="M12 2.9v2.2" />
            <path d="M12 18.9v2.2" />
            <path d="m5.55 5.55 1.55 1.55" />
            <path d="m16.9 16.9 1.55 1.55" />
            <path d="M2.9 12h2.2" />
            <path d="M18.9 12h2.2" />
            <path d="m5.55 18.45 1.55-1.55" />
            <path d="m16.9 7.1 1.55-1.55" />
        </svg>
        @break

    @case('profile')
        <svg {{ $iconAttributes }}>
            <circle cx="12" cy="8.2" r="3.2" />
            <path d="M5.4 19.5c.75-3.35 3.35-5.35 6.6-5.35s5.85 2 6.6 5.35" />
            <path d="M8.2 19.5h7.6" />
        </svg>
        @break

    @case('support')
        <svg {{ $iconAttributes }}>
            <path d="M6 18.5H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-8l-5 3z" />
            <path d="M8.25 11.75h.01" />
            <path d="M12 11.75h.01" />
            <path d="M15.75 11.75h.01" />
        </svg>
        @break

    @case('bell')
        <svg {{ $iconAttributes }}>
            <path d="M18 10.8c0-3.4-2.05-5.8-6-5.8s-6 2.4-6 5.8v2.7l-1.7 2.8h15.4L18 13.5z" />
            <path d="M9.6 19.1c.45.9 1.25 1.4 2.4 1.4s1.95-.5 2.4-1.4" />
            <path d="M12 3.5V2.4" />
        </svg>
        @break

    @case('security')
        <svg {{ $iconAttributes }}>
            <path d="M12 3.5 18.5 6v5.35c0 4.25-2.8 8.05-6.5 9.15-3.7-1.1-6.5-4.9-6.5-9.15V6z" />
            <path d="m9.35 12.4 1.8 1.8 3.55-3.55" />
        </svg>
        @break

    @case('users')
        <svg {{ $iconAttributes }}>
            <circle cx="9" cy="9" r="2.9" />
            <path d="M4.9 18.1c.55-2.3 2.55-3.9 4.1-3.9s3.55 1.6 4.1 3.9" />
            <circle cx="16.9" cy="10" r="2.2" />
            <path d="M15.1 18c.45-1.5 1.7-2.6 3.45-3" />
        </svg>
        @break

    @case('robot')
        <svg {{ $iconAttributes }}>
            <rect x="6" y="8" width="12" height="9" rx="2.4" />
            <path d="M12 4.5v2.2" />
            <path d="M9 17v2.2" />
            <path d="M15 17v2.2" />
            <path d="M6 12H4.25" />
            <path d="M19.75 12H18" />
            <circle cx="10" cy="12" r="0.9" fill="currentColor" stroke="none" />
            <circle cx="14" cy="12" r="0.9" fill="currentColor" stroke="none" />
            <path d="M9.6 14.6c.7.45 1.5.65 2.4.65s1.7-.2 2.4-.65" />
        </svg>
        @break

    @case('transfer')
        <svg {{ $iconAttributes }}>
            <path d="M5 8h12" />
            <path d="m13.75 4.75 3.25 3.25-3.25 3.25" />
            <path d="M19 16H7" />
            <path d="M10.25 12.75 7 16l3.25 3.25" />
        </svg>
        @break

    @case('login')
        <svg {{ $iconAttributes }}>
            <path d="M10 5H6.5A2.5 2.5 0 0 0 4 7.5v9A2.5 2.5 0 0 0 6.5 19H10" />
            <path d="m13 8.75 3.75 3.25L13 15.25" />
            <path d="M8.5 12h8.25" />
        </svg>
        @break

    @case('logout')
        <svg {{ $iconAttributes }}>
            <path d="M14 5h3.5A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19H14" />
            <path d="m11 8.75-3.75 3.25L11 15.25" />
            <path d="M15.5 12H7.25" />
        </svg>
        @break

    @case('status')
        <svg {{ $iconAttributes }}>
            <circle cx="12" cy="12" r="8.5" />
            <path d="m8.5 12.2 2.2 2.2 4.9-4.9" />
        </svg>
        @break

    @case('globe')
        <svg {{ $iconAttributes }}>
            <circle cx="12" cy="12" r="8.5" />
            <path d="M3.5 12h17" />
            <path d="M12 3.5c2.2 2.25 3.3 5.1 3.3 8.5S14.2 18.25 12 20.5" />
            <path d="M12 3.5C9.8 5.75 8.7 8.6 8.7 12s1.1 6.25 3.3 8.5" />
        </svg>
        @break

    @default
        <svg {{ $iconAttributes }}>
            <rect x="3.5" y="3.5" width="7" height="7" rx="1.8" />
            <rect x="13.5" y="3.5" width="7" height="7" rx="1.8" />
            <rect x="3.5" y="13.5" width="7" height="7" rx="1.8" />
            <rect x="13.5" y="13.5" width="7" height="7" rx="1.8" />
        </svg>
@endswitch
