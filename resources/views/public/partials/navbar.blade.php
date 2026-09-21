@php

$pageSettings = is_array($pageSettings ?? null) ? $pageSettings : [];

$headerEnabled = (bool) data_get(
$pageSettings,
'header.visibility.enabled',
data_get($pageSettings, 'header.enabled', true)
);

$headerStyle = data_get(
$pageSettings,
'header.appearance.style',
'default'
);

$headerWidth = data_get(
$pageSettings,
'header.appearance.width',
'container'
);

$headerHeight = data_get(
$pageSettings,
'header.appearance.height',
'80px'
);

$headerBackground = data_get(
$pageSettings,
'header.appearance.background',
null
);

$headerTextColor = data_get(
$pageSettings,
'header.appearance.text_color',
null
);

$headerSticky = (bool) data_get(
$pageSettings,
'header.behavior.sticky',
true
);

$headerHideOnScroll = (bool) data_get(
$pageSettings,
'header.behavior.hide_on_scroll',
false
);

$headerShrinkOnScroll = (bool) data_get(
$pageSettings,
'header.behavior.shrink_on_scroll',
false
);

$headerScrollOffset = (int) data_get(
$pageSettings,
'header.behavior.scroll_offset',
20
);

$showTitle = (bool) data_get(
$pageSettings,
'header.items.title',
true
);

$titleSource = data_get(
$pageSettings,
'header.title.source',
'page'
);

$customTitle = data_get(
$pageSettings,
'header.title.text',
''
);

$titleFontSize = data_get(
$pageSettings,
'header.title.font_size',
'lg'
);

$titleFontWeight = data_get(
$pageSettings,
'header.title.font_weight',
'bold'
);

$titleColor = data_get(
$pageSettings,
'header.title.color',
$headerTextColor ?: '#1e293b'
);

$titleMaxWidth = (int) data_get(
$pageSettings,
'header.title.max_width',
45
);

$showLogo = (bool) data_get(
$pageSettings,
'header.items.logo',
true
);

$logoType = data_get(
$pageSettings,
'header.logo.type',
'text'
);

$logoImage = data_get(
$pageSettings,
'header.logo.image',
null
);

$logoText = data_get(
$pageSettings,
'header.logo.text',
'Dev-Platform'
);

$logoUrl = data_get(
$pageSettings,
'header.logo.url',
'/'
);

$showSocial = (bool) data_get(
$pageSettings,
'header.items.social',
false
);

$socialIconSize = data_get(
$pageSettings,
'header.social.icon_size',
'md'
);

$socialColor = data_get(
$pageSettings,
'header.social.color',
'#475569'
);

$socialHoverColor = data_get(
$pageSettings,
'header.social.hover_color',
'#2563eb'
);

$socialNewTab = (bool) data_get(
$pageSettings,
'header.social.new_tab',
true
);

$socialLinks = data_get(
$pageSettings,
'header.social.links',
[]
);

$showCta = (bool) data_get(
$pageSettings,
'header.items.cta',
false
);

$ctaText = data_get(
$pageSettings,
'header.cta.text',
'Get Started'
);

$ctaUrl = data_get(
$pageSettings,
'header.cta.url',
'/register'
);

$showHeaderAction = (bool) data_get(
$pageSettings,
'header.actions.enabled',
false
);

$headerActionStyle = data_get(
$pageSettings,
'header.actions.style',
'primary'
);

$headerActionText = data_get(
$pageSettings,
'header.actions.text',
'Get Started'
);

$headerActionUrl = data_get(
$pageSettings,
'header.actions.url',
'/register'
);

$locale = app()->getLocale();

$isRtl = in_array($locale, ['fa', 'ps'], true);

$headerTitle = $titleSource === 'custom' && filled($customTitle)
? $customTitle
: ($page->title ?? 'Dev-Platform');

$titleSizeClass = match ($titleFontSize) {
'xs' => 'text-xs',
'sm' => 'text-sm',
'base' => 'text-base',
'lg' => 'text-lg',
'xl' => 'text-xl',
'2xl' => 'text-2xl',
'3xl' => 'text-3xl',
default => 'text-lg',
};

$titleWeightClass = match ($titleFontWeight) {
'normal' => 'font-normal',
'medium' => 'font-medium',
'semibold' => 'font-semibold',
'bold' => 'font-bold',
'extrabold' => 'font-extrabold',
default => 'font-bold',
};

$socialSizeClass = match ($socialIconSize) {
'sm' => 'w-4 h-4',
'md' => 'w-5 h-5',
'lg' => 'w-6 h-6',
'xl' => 'w-7 h-7',
default => 'w-5 h-5',
};

$socialButtonSize = match ($socialIconSize) {
'sm' => '32px',
'lg' => '40px',
'xl' => '44px',
default => '36px',
};

$containerClass = match ($headerWidth) {
'wide' => 'max-w-[1600px]',
'full' => 'max-w-none',
default => 'max-w-[1400px]',
};

$headerStyleClass = match ($headerStyle) {
'minimal' => 'bg-white border-b border-gray-100',
'transparent' => 'bg-transparent border-transparent',
'solid' => 'bg-white border-b border-gray-200',
default => 'bg-white/70 backdrop-blur-xl border-b border-white/60',
};

$actionClass = match ($headerActionStyle) {
'secondary' => 'bg-slate-700 text-white border border-slate-700 hover:bg-slate-800 hover:border-slate-800',
'outline' => 'bg-white text-blue-700 border-2 border-blue-700 hover:bg-blue-50 hover:border-blue-800',
'ghost' => 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 hover:border-blue-300',
default => 'bg-blue-700 text-white border border-blue-700 hover:bg-blue-800 hover:border-blue-800',
};

$makeUrl = function ($url) {
if (!filled($url)) {
return '#';
}


$url = trim((string) $url);

if (
    str_starts_with($url, 'http://') ||
    str_starts_with($url, 'https://') ||
    str_starts_with($url, '#') ||
    str_starts_with($url, 'mailto:') ||
    str_starts_with($url, 'tel:') ||
    str_starts_with($url, 'javascript:')
) {
    return $url;
}

return url($url);


};

$localeUrl = function ($targetLocale) use ($page) {


$targetLocale = in_array($targetLocale, ['en', 'fa', 'ps'], true)
    ? $targetLocale
    : 'en';

if (! $page instanceof \App\Models\Page) {

    return url($targetLocale);

}

if ($page->locale === $targetLocale) {

    return url()->current();

}

$translation = $page->translation($targetLocale);

if ($translation) {

    return url(
        $targetLocale . '/' . ltrim(
            $translation->slug,
            '/'
        )
    );

}

return url()->current();


};

$navLabel = function ($key, $fallback) {


$translated = __($key);

return $translated !== $key
    ? $translated
    : $fallback;


};

$loginLabel = $navLabel(


'navigation.login',

$locale === 'fa'
    ? 'ورود'
    : ($locale === 'ps' ? 'ننوتل' : 'Login')


);

$demoLabel = $navLabel(


'navigation.request_demo',

$locale === 'fa'
    ? 'درخواست دمو'
    : ($locale === 'ps' ? 'د ډیمو غوښتنه' : 'Request Demo')


);

$homeLabel = $navLabel(


'navigation.home',

$locale === 'fa'
    ? 'خانه'
    : ($locale === 'ps' ? 'کور' : 'Home')


);


$socialIconSvg = function ($platform) {
return match ($platform) {
'facebook' => ' <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"> <path d="M13.5 22v-8h2.75l.5-3h-3.25V9.05c0-.87.29-1.55 1.62-1.55h1.72V4.8c-.3-.04-1.33-.13-2.53-.13-2.5 0-4.21 1.53-4.21 4.34V11H7.25v3H10.1v8h3.4Z"/> </svg>
',


    'instagram' => '
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <rect x="3" y="3" width="18" height="18" rx="5"/>
            <circle cx="12" cy="12" r="4"/>
            <circle cx="17.4" cy="6.6" r="1" fill="currentColor" stroke="none"/>
        </svg>
    ',

    'x' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M18.9 2H22l-6.77 7.74L23.2 22h-6.24l-4.88-6.39L6.5 22H3.4l7.24-8.28L2.8 2h6.4l4.41 5.83L18.9 2Zm-1.09 17.9h1.73L8.28 3.98H6.43L17.81 19.9Z"/>
        </svg>
    ',

    'linkedin' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M6.5 8.1A2.1 2.1 0 1 0 6.5 4a2.1 2.1 0 0 0 0 4.1ZM4.7 9.6h3.6V20H4.7V9.6Zm5.8 0H14v1.42h.05c.56-1 1.93-2.05 3.98-2.05 4.25 0 5.04 2.8 5.04 6.45V20h-3.6v-4.05c0-.97-.02-2.22-1.35-2.22-1.35 0-1.56 1.05-1.56 2.15V20h-3.6V9.6Z"/>
        </svg>
    ',

    'youtube' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M23.5 6.2a3.1 3.1 0 0 0-2.18-2.18C19.4 3.5 12 3.5 12 3.5s-7.4 0-9.32.52A3.1 3.1 0 0 0 .5 6.2 32 32 0 0 0 0 12a32 32 0 0 0 .5 5.8 3.1 3.1 0 0 0 2.18 2.18c1.92.52 9.32.52 9.32.52s7.4 0 9.32-.52a3.1 3.1 0 0 0 2.18-2.18A32 32 0 0 0 24 12a32 32 0 0 0-.5-5.8ZM9.6 15.9V8.1l6.5 3.9-6.5 3.9Z"/>
        </svg>
    ',

    'github' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.05c-3.34.73-4.04-1.42-4.04-1.42-.55-1.4-1.34-1.77-1.34-1.77-1.09-.75.08-.74.08-.74 1.2.09 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48.99.11-.77.42-1.3.76-1.6-2.67-.3-5.47-1.34-5.47-5.95 0-1.31.47-2.38 1.23-3.22-.12-.3-.53-1.52.12-3.18 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.3-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.76.84 1.23 1.91 1.23 3.22 0 4.62-2.81 5.64-5.49 5.94.43.37.81 1.1.81 2.22v3.28c0 .32.22.69.83.58A12 12 0 0 0 12 .5Z" clip-rule="evenodd"/>
        </svg>
    ',

    'telegram' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21.7 3.3 2.5 10.7c-.9.35-.88.84-.16 1.06l4.93 1.54 1.88 5.73c.23.64.12.9.77.9.5 0 .72-.23.99-.5l2.38-2.31 4.95 3.66c.91.5 1.56.24 1.79-.84l3.16-14.92c.34-1.33-.51-1.94-1.49-1.72ZM8.02 12.96l10.96-6.91c.55-.34 1.05-.16.64.2l-8.88 8.02-.35 3.75-1.37-5.06Z"/>
        </svg>
    ',

    'whatsapp' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M20.52 3.48A11.87 11.87 0 0 0 12.08 0C5.52 0 .18 5.34.18 11.9c0 2.1.55 4.15 1.59 5.96L.08 24l6.28-1.65a11.9 11.9 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.47-8.43Zm-8.44 18.3h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.21-3.73.98 1-3.64-.23-.37a9.88 9.88 0 1 1 8.38 4.62Zm5.43-7.42c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z"/>
        </svg>
    ',

    'tiktok' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-3.77V2h-3.4v13.64a2.9 2.9 0 1 1-2-2.76V9.4a6.3 6.3 0 1 0 5.4 6.24V8.73a8.2 8.2 0 0 0 4.82 1.55V6.9a4.8 4.8 0 0 1-1.05-.21Z"/>
        </svg>
    ',

    'discord' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M19.54 5.06A16.8 16.8 0 0 0 15.4 3.8l-.5 1.03a15.5 15.5 0 0 0-5.8 0L8.6 3.8a16.8 16.8 0 0 0-4.14 1.26C1.84 8.92 1.13 12.94 1.49 16.9a16.8 16.8 0 0 0 5.08 2.58l1.23-1.68c-.68-.25-1.33-.56-1.94-.92l.48-.37a11.95 11.95 0 0 0 10.32 0l.49.37c-.61.36-1.26.67-1.94.92l1.23 1.68a16.8 16.8 0 0 0 5.08-2.58c.42-4.59-.72-8.57-2.48-11.84Zm-10.4 9.47c-1 0-1.82-.92-1.82-2.05s.8-2.05 1.82-2.05c1.02 0 1.83.92 1.82 2.05 0 1.13-.8 2.05-1.82 2.05Zm5.72 0c-1 0-1.82-.92-1.82-2.05s.8-2.05 1.82-2.05c1.02 0 1.83.92 1.82 2.05 0 1.13-.8 2.05-1.82 2.05Z"/>
        </svg>
    ',

    'reddit' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21.3 12.7c0-.94-.76-1.7-1.7-1.7-.46 0-.87.18-1.18.47-1.16-.83-2.73-1.36-4.48-1.43l.9-4.23 2.93.62a1.35 1.35 0 1 0 .27-1.28l-3.35-.71a.65.65 0 0 0-.76.49l-1.03 4.85c-1.72.1-3.26.63-4.4 1.46A1.7 1.7 0 1 0 5.7 14.1c0 2.74 2.82 4.96 6.3 4.96s6.3-2.22 6.3-4.96c0-.3-.03-.59-.1-.87.1.02.2.03.3.03.94 0 1.7-.76 1.7-1.7Z"/>
        </svg>
    ',

    'behance' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M9.3 11.2c1.2-.5 1.9-1.4 1.9-2.6 0-2.2-1.8-3.6-4.5-3.6H1.5v13h5.7c3.1 0 5.1-1.6 5.1-4 0-1.4-1-2.5-3-2.8ZM4.5 7.4h2.1c1.2 0 1.8.5 1.8 1.4 0 .9-.7 1.5-1.9 1.5H4.5V7.4Zm2.3 8.1H4.5v-2.8h2.3c1.5 0 2.2.5 2.2 1.4 0 .9-.8 1.4-2.2 1.4ZM17.1 8.5c-3.4 0-5.6 2.2-5.6 5.2 0 3.1 2.3 5.2 5.7 5.2 2.8 0 4.7-1.4 5.3-3.4h-3c-.4.7-1.1 1.1-2.3 1.1-1.4 0-2.4-.8-2.5-2.2h8v-.7c0-3.1-2.2-5.2-5.6-5.2Zm-2.4 4c.2-1.1 1-1.8 2.4-1.8 1.3 0 2.2.7 2.3 1.8h-4.7ZM15 6h4V7h-4V6Z"/>
        </svg>
    ',

    'dribbble' => '
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 1.5a10.5 10.5 0 1 0 0 21 10.5 10.5 0 0 0 0-21Zm6.9 4.85a8.7 8.7 0 0 1 1.72 4.7c-2.02-.1-3.8.02-5.32.28-.18-.43-.36-.85-.55-1.26 1.7-.7 3.08-1.7 4.15-3.72ZM12 3.25c2.08 0 3.98.78 5.42 2.07-1 1.85-2.2 2.84-3.48 3.39-1.03-1.9-2.12-3.54-3.16-4.96.4-.07.81-.1 1.22-.1ZM8.98 4.4c1.07 1.4 2.2 3.03 3.25 4.92-2.66.78-5.22.83-7.7.76A8.76 8.76 0 0 1 8.98 4.4ZM3.25 12c0-.16 0-.32.01-.48 2.74.08 5.68.03 8.68-.87.16.36.32.72.47 1.08-4.03 1.15-6.8 3.17-8.1 4.22A8.72 8.72 0 0 1 3.25 12Zm2.27 5.3c1.08-.91 3.5-2.77 7.56-3.96.8 2.13 1.35 4.2 1.65 6.2A8.76 8.76 0 0 1 5.52 17.3Zm10.95 1.3c-.32-2.14-.9-4.36-1.73-6.62 1.4-.23 3.03-.33 4.9-.22a8.76 8.76 0 0 1-3.17 6.84Z"/>
        </svg>
    ',

    default => '
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/>
            <path d="M3 12h18"/>
            <path d="M12 3a14 14 0 0 1 0 18"/>
            <path d="M12 3a14 14 0 0 0 0 18"/>
        </svg>
    ',
};


};

@endphp

@if ($headerEnabled)

<style>
    .site-navbar {
        position: relative;
        width: 100%;
        z-index: 100;
        isolation: isolate;
        transition:
            transform 300ms ease,
            min-height 300ms ease,
            background-color 300ms ease,
            box-shadow 300ms ease;
    }

    .site-navbar.is-sticky {
        position: sticky;
        top: 0;
    }

    .site-navbar.navbar-hidden {
        transform: translateY(-100%);
    }

    .site-navbar.navbar-shrink .navbar-top-row {
        min-height: 64px !important;
    }

    .site-navbar.navbar-shrink .navbar-logo-image {
        height: 34px !important;
    }

    .navbar-top-row {
        min-height: 80px;
        transition:
            min-height 300ms ease,
            padding 300ms ease;
    }

    .navbar-navigation-row {
        position: relative;
        z-index: 300;
        border-top: 1px solid rgba(226, 232, 240, 0.65);
    }

    .navbar-navigation-inner {
        position: relative;
        z-index: 300;
    }

    .navbar-menu-wrapper {
        position: relative;
        z-index: 400;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        width: 100%;
    }

    .navbar-menu-item {
        position: relative;
        flex: 0 0 auto;
    }

    .navbar-dropdown,
    .navbar-mega-menu {
        position: absolute;
        z-index: 999999;
        pointer-events: auto;
    }

    .navbar-dropdown {
        min-width: 18rem;
    }

    .navbar-mega-menu {
        width: min(900px, calc(100vw - 2rem));
        max-width: calc(100vw - 2rem);
    }

    .navbar-mobile {
        position: relative;
        z-index: 999998;
    }

    .navbar-social-icon {
        flex: 0 0 auto;
    }

    .navbar-social-icon svg {
        width: 100%;
        height: 100%;
        display: block;
    }

    .navbar-nav-button {
        min-height: 42px;
    }

    [x-cloak] {
        display: none !important;
    }

    @media (max-width: 1279px) {
        .navbar-menu-wrapper {
            justify-content: flex-start;
        }

        .navbar-mega-menu {
            width: min(760px, calc(100vw - 2rem));
        }
    }

    @media (max-width: 1023px) {
        .navbar-navigation-row {
            display: none;
        }
    }
</style>

<nav
    x-data="{
        openMenu: null,
        mobileOpen: false
    }"


@if ($headerHideOnScroll || $headerShrinkOnScroll)
x-init="
    let lastScrollY = window.scrollY;

    const handleNavbarScroll = function () {
        const currentScrollY = window.scrollY;
        const offset = {{ $headerScrollOffset }};

        @if ($headerHideOnScroll)
        if (currentScrollY > lastScrollY && currentScrollY > offset) {
            $el.classList.add('navbar-hidden');
        } else if (currentScrollY < lastScrollY || currentScrollY <= offset) {
            $el.classList.remove('navbar-hidden');
        }
        @endif

        @if ($headerShrinkOnScroll)
        if (currentScrollY > offset) {
            $el.classList.add('navbar-shrink');
        } else {
            $el.classList.remove('navbar-shrink');
        }
        @endif

        lastScrollY = currentScrollY;
    };

    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
"
@endif

dir="{{ $isRtl ? 'rtl' : 'ltr' }}"

class="
    site-navbar
    {{ $headerSticky ? 'is-sticky' : '' }}
    {{ $headerStyleClass }}
    shadow-[0_14px_40px_-22px_rgba(37,99,235,0.45)]
"

style="
    min-height: {{ $headerHeight }};
    @if ($headerBackground)
    background-color: {{ $headerBackground }};
    @endif
    @if ($headerTextColor)
    color: {{ $headerTextColor }};
    @endif
"


>


<div class="{{ $containerClass }} mx-auto px-4 lg:px-6">

    <div class="navbar-top-row flex items-center gap-4 w-full min-w-0">

        @if ($showLogo)

            <a
                href="{{ $makeUrl($logoUrl ?: '/') }}"
                class="
                    flex
                    items-center
                    gap-3
                    shrink-0
                    whitespace-nowrap
                    rounded-xl
                    px-2
                    py-1
                    transition
                    hover:bg-blue-50
                    min-w-0
                "
            >

                @if (
                    in_array($logoType, ['image', 'image_text'], true) &&
                    filled($logoImage)
                )

                    <img
                        src="{{ str_starts_with($logoImage, 'http') ? $logoImage : asset('storage/' . ltrim($logoImage, '/')) }}"
                        alt="{{ $logoText ?: 'Logo' }}"
                        class="
                            navbar-logo-image
                            h-10
                            w-auto
                            max-w-[180px]
                            object-contain
                            transition-all
                        "
                    >

                @endif

                @if ($logoType === 'text' || $logoType === 'image_text')

                    <span
                        class="
                            text-2xl
                            font-extrabold
                            leading-none
                            tracking-tight
                        "
                        style="color: {{ $headerTextColor ?: '#1d4ed8' }};"
                    >
                        {{ $logoText }}
                    </span>

                @endif

            </a>

        @endif

        @if ($showTitle)

            <div
                class="
                    flex
                    items-center
                    min-w-0
                    flex-1
                    px-2
                    lg:px-4
                "
                style="max-width: {{ max(10, min(100, $titleMaxWidth)) }}%;"
            >

                <span
                    class="
                        {{ $titleSizeClass }}
                        {{ $titleWeightClass }}
                        truncate
                        min-w-0
                    "
                    style="color: {{ $titleColor }};"
                    title="{{ $headerTitle }}"
                >
                    {{ $headerTitle }}
                </span>

            </div>

        @endif

        <div
            class="
                hidden
                lg:flex
                items-center
                gap-2
                shrink-0
                ms-auto
            "
        >

            @if ($showSocial && is_array($socialLinks))

                <div class="flex items-center gap-1">

                    @foreach ($socialLinks as $social)

                        @if (
                            is_array($social) &&
                            ($social['enabled'] ?? true) &&
                            filled($social['url'] ?? null)
                        )

                            @php
                                $platform = strtolower(trim($social['platform'] ?? ''));
                                $svg = $socialIconSvg($platform);
                            @endphp

                            <a
                                href="{{ $makeUrl($social['url']) }}"
                                class="
                                    navbar-social-icon
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-full
                                    p-2
                                    transition
                                    hover:bg-blue-50
                                "
                                style="
                                    color: {{ $socialColor }};
                                    width: {{ $socialButtonSize }};
                                    height: {{ $socialButtonSize }};
                                "
                                onmouseover="this.style.color='{{ $socialHoverColor }}'"
                                onmouseout="this.style.color='{{ $socialColor }}'"
                                @if ($socialNewTab)
                                target="_blank"
                                rel="noopener noreferrer"
                                @endif
                                aria-label="{{ ucfirst($platform) }}"
                            >
                                {!! $svg !!}
                            </a>

                        @endif

                    @endforeach

                </div>

            @endif

            @if ($showCta && filled($ctaText))

                <a
                    href="{{ $makeUrl($ctaUrl) }}"
                    class="
                        px-3
                        py-2
                        h-10
                        flex
                        items-center
                        justify-center
                        rounded-xl
                        bg-blue-700
                        text-white
                        hover:bg-blue-800
                        transition
                        whitespace-nowrap
                        shadow-sm
                        text-sm
                    "
                >
                    {{ $ctaText }}
                </a>

            @endif

            @if ($showHeaderAction && filled($headerActionText))

                <a
                    href="{{ $makeUrl($headerActionUrl) }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        h-10
                        px-4
                        rounded-xl
                        text-sm
                        font-semibold
                        whitespace-nowrap
                        shadow-md
                        transition-all
                        duration-200
                        {{ $actionClass }}
                    "
                >
                    {{ $headerActionText }}
                </a>

            @endif

            <a
                href="{{ url($locale . '/login') }}"
                class="
                    px-3
                    py-2
                    h-10
                    flex
                    items-center
                    justify-center
                    rounded-xl
                    border
                    border-gray-300
                    text-gray-700
                    hover:border-blue-700
                    hover:text-blue-700
                    transition
                    whitespace-nowrap
                    shadow-sm
                    text-sm
                "
            >
                {{ $loginLabel }}
            </a>

            <a
                href="#"
                class="
                    px-3
                    py-2
                    h-10
                    flex
                    items-center
                    justify-center
                    rounded-xl
                    bg-blue-700
                    text-white
                    hover:bg-blue-800
                    transition
                    whitespace-nowrap
                    shadow-sm
                    text-sm
                "
            >
                {{ $demoLabel }}
            </a>

        </div>

        <button
            type="button"
            @click="mobileOpen = !mobileOpen"
            class="
                lg:hidden
                inline-flex
                items-center
                justify-center
                w-10
                h-10
                rounded-full
                bg-blue-50
                text-blue-700
                hover:bg-blue-100
                transition
                shadow-sm
                ms-auto
                shrink-0
            "
            :aria-expanded="mobileOpen.toString()"
            aria-label="Toggle navigation"
        >

            <i
                data-lucide="menu"
                class="w-5 h-5"
            ></i>

        </button>

    </div>

</div>

<div class="navbar-navigation-row hidden lg:block bg-white/40">

    <div class="{{ $containerClass }} mx-auto px-4 lg:px-6">

        <div class="navbar-navigation-inner py-2">

            <div class="navbar-menu-wrapper">

                <a
                    href="{{ url($locale) }}"
                    class="
                        navbar-nav-button
                        flex
                        items-center
                        gap-2
                        px-3
                        py-2
                        text-gray-700
                        hover:text-blue-700
                        transition
                        whitespace-nowrap
                        rounded-xl
                        hover:bg-blue-50
                        font-semibold
                    "
                >

                    <i
                        data-lucide="home"
                        class="w-5 h-5 shrink-0 text-blue-700"
                    ></i>

                    <span>
                        {{ $homeLabel }}
                    </span>

                </a>

                @foreach (config('navigation.main', []) as $index => $menu)

                    @php
                        $hasChildren = isset($menu['children']) && is_array($menu['children']);
                        $hasMega = isset($menu['mega']);
                    @endphp

                    <div
                        class="navbar-menu-item"
                        x-data
                        @mouseenter="openMenu = {{ $index }}"
                        @mouseleave="openMenu = null"
                    >

                        <button
                            type="button"
                            @click="openMenu = openMenu === {{ $index }} ? null : {{ $index }}"
                            class="
                                navbar-nav-button
                                flex
                                items-center
                                gap-2
                                px-3
                                py-2
                                text-gray-700
                                hover:text-blue-700
                                transition
                                whitespace-nowrap
                                rounded-xl
                                border
                                border-transparent
                                hover:border-blue-100
                                hover:bg-blue-50/70
                                font-semibold
                            "
                        >

                            <i
                                data-lucide="{{ $menu['icon'] ?? 'grid-2x2' }}"
                                class="w-5 h-5 shrink-0 text-blue-700"
                            ></i>

                            <span>
                                {{ __($menu['title'] ?? '') }}
                            </span>

                            @if ($hasChildren || $hasMega)

                                <i
                                    data-lucide="chevron-down"
                                    class="
                                        w-4
                                        h-4
                                        shrink-0
                                        transition-transform
                                    "
                                    :class="{
                                        'rotate-180': openMenu === {{ $index }}
                                    }"
                                ></i>

                            @endif

                        </button>

                        @if ($hasChildren)

                            <div
                                x-show="openMenu === {{ $index }}"
                                x-transition.opacity.duration.150ms
                                x-cloak
                                @click.outside="openMenu = null"
                                class="
                                    navbar-dropdown
                                    top-full
                                    start-0
                                    mt-2
                                    w-72
                                    max-w-[calc(100vw-2rem)]
                                    bg-white
                                    border
                                    border-gray-200
                                    rounded-2xl
                                    shadow-2xl
                                    p-3
                                "
                            >

                                <div class="flex flex-col gap-1">

                                    @foreach ($menu['children'] as $child)

                                        <a
                                            href="{{ $makeUrl($child['url'] ?? '#') }}"
                                            class="
                                                flex
                                                items-center
                                                gap-3
                                                px-3
                                                py-3
                                                rounded-xl
                                                text-gray-700
                                                hover:text-blue-700
                                                hover:bg-blue-50
                                                transition
                                            "
                                        >

                                            <i
                                                data-lucide="{{ $child['icon'] ?? 'circle' }}"
                                                class="
                                                    w-5
                                                    h-5
                                                    text-blue-700
                                                    shrink-0
                                                "
                                            ></i>

                                            <span class="truncate">
                                                {{ __($child['title'] ?? '') }}
                                            </span>

                                        </a>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                        @if ($hasMega)

                            <div
                                x-show="openMenu === {{ $index }}"
                                x-transition.opacity.duration.150ms
                                x-cloak
                                @click.outside="openMenu = null"
                                class="
                                    navbar-mega-menu
                                    top-full
                                    start-0
                                    mt-2
                                    bg-white
                                    border
                                    border-gray-200
                                    rounded-2xl
                                    shadow-2xl
                                    p-6
                                "
                            >

                                <div
                                    class="
                                        grid
                                        grid-cols-1
                                        sm:grid-cols-2
                                        lg:grid-cols-3
                                        gap-6
                                    "
                                >

                                    @foreach ($menu['items'] ?? [] as $section)

                                        <div class="min-w-0">

                                            <div
                                                class="
                                                    flex
                                                    items-center
                                                    gap-3
                                                    mb-3
                                                    px-2
                                                "
                                            >

                                                <i
                                                    data-lucide="{{ $section['icon'] ?? 'circle' }}"
                                                    class="
                                                        w-5
                                                        h-5
                                                        text-blue-700
                                                        shrink-0
                                                    "
                                                ></i>

                                                <h3
                                                    class="
                                                        font-semibold
                                                        text-gray-900
                                                        truncate
                                                    "
                                                >
                                                    {{ __($section['title'] ?? '') }}
                                                </h3>

                                            </div>

                                            <div class="space-y-1">

                                                @foreach ($section['children'] ?? [] as $item)

                                                    <a
                                                        href="{{ $makeUrl($item['url'] ?? '#') }}"
                                                        class="
                                                            flex
                                                            items-center
                                                            gap-2
                                                            rounded-xl
                                                            px-3
                                                            py-2.5
                                                            text-gray-700
                                                            hover:text-blue-700
                                                            hover:bg-blue-50
                                                            transition
                                                        "
                                                    >

                                                        @if (isset($item['icon']))

                                                            <i
                                                                data-lucide="{{ $item['icon'] }}"
                                                                class="
                                                                    w-4
                                                                    h-4
                                                                    text-blue-600
                                                                    shrink-0
                                                                "
                                                            ></i>

                                                        @endif

                                                        <span class="truncate">
                                                            {{ __($item['title'] ?? '') }}
                                                        </span>

                                                    </a>

                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                @endforeach

                <div
                    x-data="{ openLang: false }"
                    class="relative shrink-0"
                >

                    <button
                        type="button"
                        @click="openLang = !openLang"
                        class="
                            navbar-nav-button
                            flex
                            items-center
                            gap-2
                            px-3
                            py-2
                            rounded-xl
                            border
                            border-transparent
                            text-gray-700
                            hover:border-blue-100
                            hover:bg-blue-50
                            hover:text-blue-700
                            transition
                            font-semibold
                        "
                        :aria-expanded="openLang.toString()"
                    >

                        <i
                            data-lucide="globe-2"
                            class="w-5 h-5 text-blue-700"
                        ></i>

                        <span class="text-sm">
                            {{ strtoupper($locale) }}
                        </span>

                        <i
                            data-lucide="chevron-down"
                            class="w-4 h-4"
                        ></i>

                    </button>

                    <div
                        x-show="openLang"
                        x-transition.opacity.duration.150ms
                        x-cloak
                        @click.outside="openLang = false"
                        class="
                            absolute
                            top-full
                            {{ $isRtl ? 'start-0' : 'end-0' }}
                            mt-2
                            w-44
                            bg-white
                            border
                            border-gray-200
                            rounded-2xl
                            shadow-2xl
                            p-2
                            z-[999999]
                        "
                    >

                        <div class="space-y-1">

                            <a
                                href="{{ $localeUrl('en') }}"
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    px-3
                                    py-2.5
                                    rounded-xl
                                    text-sm
                                    text-gray-700
                                    hover:bg-blue-50
                                    hover:text-blue-700
                                    transition
                                    {{ $locale === 'en' ? 'bg-blue-50 text-blue-700 font-semibold' : '' }}
                                "
                            >
                                <span>EN</span>
                                <span>English</span>
                            </a>

                            <a
                                href="{{ $localeUrl('fa') }}"
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    px-3
                                    py-2.5
                                    rounded-xl
                                    text-sm
                                    text-gray-700
                                    hover:bg-blue-50
                                    hover:text-blue-700
                                    transition
                                    {{ $locale === 'fa' ? 'bg-blue-50 text-blue-700 font-semibold' : '' }}
                                "
                            >
                                <span>FA</span>
                                <span>فارسی</span>
                            </a>

                            <a
                                href="{{ $localeUrl('ps') }}"
                                class="
                                    flex
                                    items-center
                                    gap-3
                                    px-3
                                    py-2.5
                                    rounded-xl
                                    text-sm
                                    text-gray-700
                                    hover:bg-blue-50
                                    hover:text-blue-700
                                    transition
                                    {{ $locale === 'ps' ? 'bg-blue-50 text-blue-700 font-semibold' : '' }}
                                "
                            >
                                <span>PS</span>
                                <span>پښتو</span>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div
    x-show="mobileOpen"
    x-transition
    x-cloak
    class="
        navbar-mobile
        lg:hidden
        border-t
        border-blue-100
        bg-white/95
        backdrop-blur-md
    "
>

    <div class="{{ $containerClass }} mx-auto px-4 py-4 space-y-4">

        @if ($showTitle)

            <div
                class="
                    px-2
                    py-2
                    {{ $titleSizeClass }}
                    {{ $titleWeightClass }}
                "
                style="color: {{ $titleColor }};"
            >
                {{ $headerTitle }}
            </div>

        @endif

        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-2">

            <div class="flex items-center gap-2 px-2 py-2 text-sm font-semibold text-gray-800">

                <i
                    data-lucide="globe-2"
                    class="w-4 h-4 text-blue-700"
                ></i>

                <span>
                    {{ $locale === 'fa' ? 'زبان' : ($locale === 'ps' ? 'ژبه' : 'Language') }}
                </span>

            </div>

            <div class="grid grid-cols-3 gap-2">

                <a
                    href="{{ $localeUrl('en') }}"
                    class="
                        flex
                        flex-col
                        items-center
                        justify-center
                        gap-1
                        rounded-xl
                        px-3
                        py-2
                        text-sm
                        transition
                        {{ $locale === 'en'
                            ? 'bg-blue-700 text-white'
                            : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}
                    "
                >
                    <span class="font-bold">EN</span>
                    <span class="text-xs">English</span>
                </a>

                <a
                    href="{{ $localeUrl('fa') }}"
                    class="
                        flex
                        flex-col
                        items-center
                        justify-center
                        gap-1
                        rounded-xl
                        px-3
                        py-2
                        text-sm
                        transition
                        {{ $locale === 'fa'
                            ? 'bg-blue-700 text-white'
                            : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}
                    "
                >
                    <span class="font-bold">FA</span>
                    <span class="text-xs">فارسی</span>
                </a>

                <a
                    href="{{ $localeUrl('ps') }}"
                    class="
                        flex
                        flex-col
                        items-center
                        justify-center
                        gap-1
                        rounded-xl
                        px-3
                        py-2
                        text-sm
                        transition
                        {{ $locale === 'ps'
                            ? 'bg-blue-700 text-white'
                            : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}
                    "
                >
                    <span class="font-bold">PS</span>
                    <span class="text-xs">پښتو</span>
                </a>

            </div>

        </div>

        @if ($showSocial && is_array($socialLinks))

            <div class="flex flex-wrap items-center gap-2 px-2">

                @foreach ($socialLinks as $social)

                    @if (
                        is_array($social) &&
                        ($social['enabled'] ?? true) &&
                        filled($social['url'] ?? null)
                    )

                        @php
                            $platform = strtolower(trim($social['platform'] ?? ''));
                            $svg = $socialIconSvg($platform);
                        @endphp

                        <a
                            href="{{ $makeUrl($social['url']) }}"
                            class="
                                navbar-social-icon
                                inline-flex
                                items-center
                                justify-center
                                p-2
                                rounded-full
                                hover:bg-blue-50
                                transition
                            "
                            style="
                                color: {{ $socialColor }};
                                width: 36px;
                                height: 36px;
                            "
                            onmouseover="this.style.color='{{ $socialHoverColor }}'"
                            onmouseout="this.style.color='{{ $socialColor }}'"
                            @if ($socialNewTab)
                            target="_blank"
                            rel="noopener noreferrer"
                            @endif
                            aria-label="{{ ucfirst($platform) }}"
                        >
                            {!! $svg !!}
                        </a>

                    @endif

                @endforeach

            </div>

        @endif

        <div class="space-y-2">

            <a
                href="{{ url($locale) }}"
                class="
                    flex
                    items-center
                    gap-3
                    px-4
                    py-3
                    text-gray-700
                    hover:text-blue-700
                    transition
                    font-medium
                    rounded-xl
                    hover:bg-gray-50
                    border
                    border-transparent
                "
            >

                <i
                    data-lucide="home"
                    class="w-5 h-5 text-blue-700"
                ></i>

                <span>
                    {{ $homeLabel }}
                </span>

            </a>

            @foreach (config('navigation.main', []) as $index => $menu)

                @php
                    $hasChildren = isset($menu['children']) && is_array($menu['children']);
                    $hasMega = isset($menu['mega']);
                    $hasMobileContent = $hasChildren || $hasMega;
                @endphp

                <div
                    x-data="{ openMobileMenu: false }"
                    class="
                        border
                        border-gray-200
                        rounded-2xl
                        overflow-hidden
                        bg-white
                    "
                >

                    @if ($hasMobileContent)

                        <button
                            type="button"
                            @click="openMobileMenu = !openMobileMenu"
                            class="
                                w-full
                                flex
                                items-center
                                justify-between
                                gap-3
                                px-4
                                py-3
                                text-start
                                text-gray-700
                                hover:bg-gray-50
                                transition
                            "
                        >

                            <div class="flex items-center gap-3 min-w-0">

                                <i
                                    data-lucide="{{ $menu['icon'] ?? 'grid-2x2' }}"
                                    class="
                                        w-5
                                        h-5
                                        text-blue-700
                                        shrink-0
                                    "
                                ></i>

                                <span class="truncate">
                                    {{ __($menu['title'] ?? '') }}
                                </span>

                            </div>

                            <i
                                data-lucide="chevron-down"
                                class="
                                    w-4
                                    h-4
                                    shrink-0
                                    transition-transform
                                "
                                :class="{ 'rotate-180': openMobileMenu }"
                            ></i>

                        </button>

                    @else

                        <a
                            href="{{ $makeUrl($menu['url'] ?? '#') }}"
                            class="
                                flex
                                items-center
                                gap-3
                                px-4
                                py-3
                                text-gray-700
                                hover:bg-gray-50
                                hover:text-blue-700
                                transition
                            "
                        >

                            <i
                                data-lucide="{{ $menu['icon'] ?? 'grid-2x2' }}"
                                class="w-5 h-5 text-blue-700 shrink-0"
                            ></i>

                            <span class="truncate">
                                {{ __($menu['title'] ?? '') }}
                            </span>

                        </a>

                    @endif

                    @if ($hasMobileContent)

                        <div
                            x-show="openMobileMenu"
                            x-transition
                            x-cloak
                            class="
                                space-y-1
                                px-3
                                pb-3
                                pt-1
                                border-t
                                border-gray-100
                            "
                        >

                            @if ($hasChildren)

                                @foreach ($menu['children'] as $child)

                                    <a
                                        href="{{ $makeUrl($child['url'] ?? '#') }}"
                                        class="
                                            flex
                                            items-center
                                            gap-3
                                            px-3
                                            py-2.5
                                            rounded-xl
                                            text-gray-600
                                            hover:text-blue-700
                                            hover:bg-gray-50
                                            transition
                                        "
                                    >

                                        <i
                                            data-lucide="{{ $child['icon'] ?? 'circle' }}"
                                            class="
                                                w-4
                                                h-4
                                                text-blue-700
                                                shrink-0
                                            "
                                        ></i>

                                        <span>
                                            {{ __($child['title'] ?? '') }}
                                        </span>

                                    </a>

                                @endforeach

                            @endif

                            @if ($hasMega)

                                @foreach ($menu['items'] ?? [] as $section)

                                    <div class="pt-2">

                                        <div
                                            class="
                                                flex
                                                items-center
                                                gap-2
                                                px-3
                                                py-2
                                                font-semibold
                                                text-gray-900
                                            "
                                        >

                                            <i
                                                data-lucide="{{ $section['icon'] ?? 'circle' }}"
                                                class="
                                                    w-4
                                                    h-4
                                                    text-blue-700
                                                    shrink-0
                                                "
                                            ></i>

                                            <span>
                                                {{ __($section['title'] ?? '') }}
                                            </span>

                                        </div>

                                        @foreach ($section['children'] ?? [] as $item)

                                            <a
                                                href="{{ $makeUrl($item['url'] ?? '#') }}"
                                                class="
                                                    flex
                                                    items-center
                                                    gap-2
                                                    px-3
                                                    py-2
                                                    text-sm
                                                    rounded-lg
                                                    text-gray-600
                                                    hover:text-blue-700
                                                    hover:bg-gray-50
                                                "
                                            >

                                                @if (isset($item['icon']))

                                                    <i
                                                        data-lucide="{{ $item['icon'] }}"
                                                        class="
                                                            w-4
                                                            h-4
                                                            text-blue-600
                                                            shrink-0
                                                        "
                                                    ></i>

                                                @endif

                                                <span>
                                                    {{ __($item['title'] ?? '') }}
                                                </span>

                                            </a>

                                        @endforeach

                                    </div>

                                @endforeach

                            @endif

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

        @if ($showCta && filled($ctaText))

            <a
                href="{{ $makeUrl($ctaUrl) }}"
                class="
                    block
                    w-full
                    text-center
                    px-4
                    py-3
                    bg-blue-700
                    text-white
                    rounded-xl
                    hover:bg-blue-800
                    transition
                "
            >
                {{ $ctaText }}
            </a>

        @endif

        @if ($showHeaderAction && filled($headerActionText))

            <a
                href="{{ $makeUrl($headerActionUrl) }}"
                class="
                    block
                    w-full
                    text-center
                    px-4
                    py-3
                    rounded-xl
                    transition
                    {{ $actionClass }}
                "
            >
                {{ $headerActionText }}
            </a>

        @endif

        <div class="space-y-2">

            <a
                href="{{ url($locale . '/login') }}"
                class="
                    block
                    w-full
                    text-center
                    px-4
                    py-3
                    border
                    border-gray-300
                    rounded-xl
                    text-gray-700
                    hover:border-blue-700
                    hover:text-blue-700
                    transition
                "
            >
                {{ $loginLabel }}
            </a>

            <a
                href="#"
                class="
                    block
                    w-full
                    text-center
                    px-4
                    py-3
                    bg-blue-700
                    text-white
                    rounded-xl
                    hover:bg-blue-800
                    transition
                "
            >
                {{ $demoLabel }}
            </a>

        </div>

    </div>

</div>


</nav>

<script>
(function () {
    function renderNavbarIcons() {
        if (
            typeof window !== 'undefined' &&
            window.lucide &&
            typeof window.lucide.createIcons === 'function'
        ) {
            window.lucide.createIcons();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            renderNavbarIcons,
            { once: true }
        );
    } else {
        renderNavbarIcons();
    }

    document.addEventListener(
        'alpine:initialized',
        renderNavbarIcons,
        { once: true }
    );

    window.addEventListener(
        'load',
        renderNavbarIcons,
        { once: true }
    );
})();
</script>

@endif
