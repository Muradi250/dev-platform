@php
$icon = $icon ?? 'arrow';
@endphp

@switch($icon)


@case('home')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z"/>
    </svg>
    @break

@case('about')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <circle cx="12" cy="12" r="9"/>
        <path stroke-linecap="round" d="M12 10v6"/>
        <path stroke-linecap="round" d="M12 7h.01"/>
    </svg>
    @break

@case('user')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <circle cx="12" cy="8" r="3.5"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/>
    </svg>
    @break

@case('contact')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <rect x="4" y="5" width="16" height="14" rx="2"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/>
    </svg>
    @break

@case('phone')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 3.5h3l1.5 5-2 1.5a15 15 0 0 0 5 5l1.5-2 5 1.5v3c0 1.1-.9 2-2 2C10.5 19.5 4.5 13.5 4.5 6.5c0-1.7.9-3 2-3Z"/>
    </svg>
    @break

@case('mail')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <rect x="3" y="5" width="18" height="14" rx="2"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9 6 9-6"/>
    </svg>
    @break

@case('location')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 10c0 5-7 10-7 10S5 15 5 10a7 7 0 1 1 14 0Z"/>
        <circle cx="12" cy="10" r="2.5"/>
    </svg>
    @break

@case('services')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M18.4 5.6l-2.8 2.8M8.4 15.6l-2.8 2.8"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
    @break

@case('book')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z"/>
        <path stroke-linecap="round" d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/>
    </svg>
    @break

@case('document')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v14H7z"/>
        <path stroke-linecap="round" d="M14 3v5h5"/>
        <path stroke-linecap="round" d="M10 13h5M10 17h5"/>
    </svg>
    @break

@case('calendar')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <rect x="4" y="5" width="16" height="15" rx="2"/>
        <path stroke-linecap="round" d="M8 3v4M16 3v4M4 9h16"/>
    </svg>
    @break

@case('clock')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <circle cx="12" cy="12" r="9"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
    </svg>
    @break

@case('lock')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <rect x="5" y="10" width="14" height="10" rx="2"/>
        <path stroke-linecap="round" d="M8 10V7a4 4 0 0 1 8 0v3"/>
    </svg>
    @break

@case('arrow')
@default
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m13 6 6 6-6 6"/>
    </svg>
    @break


@endswitch
