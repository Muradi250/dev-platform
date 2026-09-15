@php


$platform = strtolower(trim($platform ?? ''));


@endphp

@switch($platform)


@case('facebook')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.5 1.6-1.5h1.7V4.9c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1V11H8v3h2.4v8h3.1z"/>
    </svg>
    @break

@case('instagram')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="5"/>
        <circle cx="12" cy="12" r="4"/>
        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
    </svg>
    @break

@case('x')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.4L2.8 2h6.5l4.4 5.8L18.9 2zm-1.1 17.9h1.7L8.3 4H6.5l11.3 15.9z"/>
    </svg>
    @break

@case('linkedin')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M6.5 8.1A1.8 1.8 0 1 0 6.5 4.5a1.8 1.8 0 0 0 0 3.6zM5 9.5h3v9.8H5V9.5zm5 0h2.9v1.3h.1c.4-.8 1.4-1.7 2.9-1.7 3.1 0 3.7 2 3.7 4.6v5.6h-3v-5c0-1.2 0-2.7-1.7-2.7s-1.9 1.3-1.9 2.6v5.1H10V9.5z"/>
    </svg>
    @break

@case('youtube')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.6 15.6V8.4l6.3 3.6-6.3 3.6z"/>
    </svg>
    @break

@case('telegram')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M21.8 3.2 2.9 10.5c-1.3.5-1.3 1.3-.2 1.7l4.8 1.5 1.8 5.5c.2.6.1.8.7.8.5 0 .7-.2 1-.5l2.3-2.2 4.8 3.5c.9.5 1.5.2 1.7-.8l3.1-15c.3-1.2-.5-1.7-1.1-1.3zM8.3 13.3l10.8-6.8c.5-.3 1-.1.6.2l-8.8 8-.3 3.1-1.7-4.5-3.6-1.1 3-.9z"/>
    </svg>
    @break

@case('whatsapp')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M20.5 3.5A11.9 11.9 0 0 0 12 0C5.4 0 .1 5.3.1 11.9c0 2.1.5 4.1 1.6 5.9L0 24l6.4-1.7a12 12 0 0 0 5.6 1.4h.1c6.5 0 11.8-5.3 11.8-11.9 0-3.2-1.2-6.1-3.4-8.3zM12.1 21.7c-1.8 0-3.6-.5-5.1-1.4l-.4-.2-3.8 1 1-3.7-.2-.4a9.8 9.8 0 0 1-1.5-5.2C2.1 6.4 6.6 2 12.1 2c2.6 0 5.1 1 6.9 2.9 1.8 1.8 2.8 4.3 2.8 6.9 0 5.5-4.4 9.9-9.7 9.9zm5.4-7.4c-.3-.2-1.7-.8-2-.9-.3-.1-.5-.2-.7.2-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-1.6-.8-2.7-1.4-3.8-3.2-.3-.5.3-.5.8-1.7.1-.2.1-.4 0-.6-.1-.2-.7-1.6-1-2.2-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.1 1-1.1 2.5s1.1 2.9 1.2 3.1c.2.2 2.1 3.3 5.1 4.6 1.9.8 2.6.9 3.5.8.6-.1 1.7-.7 1.9-1.3.2-.6.2-1.2.1-1.3-.1-.1-.3-.2-.6-.4z"/>
    </svg>
    @break

@case('tiktok')
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M19.3 7.1a5.9 5.9 0 0 1-3.6-1.2v8.3a5.8 5.8 0 1 1-5-5.7v3a2.8 2.8 0 1 0 2.1 2.7V0h3a5.9 5.9 0 0 0 3.5 4.1v3z"/>
    </svg>
    @break

@default
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
        <circle cx="12" cy="12" r="9"/>
        <path d="M3 12h18M12 3c2.2 2.4 3.3 5.4 3.3 9s-1.1 6.6-3.3 9c-2.2-2.4-3.3-5.4-3.3-9S9.8 5.4 12 3z"/>
    </svg>
    @break


@endswitch
