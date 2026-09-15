@php

/*
|--------------------------------------------------------------------------
| FOOTER SETTINGS
|--------------------------------------------------------------------------
*/

$pageSettings = $pageSettings ?? [];

if (is_string($pageSettings)) {
    $decodedSettings = json_decode($pageSettings, true);

    $pageSettings = is_array($decodedSettings)
        ? $decodedSettings
        : [];
}

if (! is_array($pageSettings)) {
    $pageSettings = [];
}

/*
|--------------------------------------------------------------------------
| FOOTER DATA
|--------------------------------------------------------------------------
*/

$footerText = data_get(
    $pageSettings,
    'settings.footer.text',
    data_get($pageSettings, 'footer.text', '')
);

$items = data_get(
    $pageSettings,
    'settings.footer.items',
    data_get($pageSettings, 'footer.items', [])
);

$brandSocial = data_get(
    $pageSettings,
    'settings.footer.brand',
    data_get($pageSettings, 'footer.brand', [])
);

$appearance = data_get(
    $pageSettings,
    'settings.footer.appearance',
    data_get($pageSettings, 'footer.appearance', [])
);

$behavior = data_get(
    $pageSettings,
    'settings.footer.behavior',
    data_get($pageSettings, 'footer.behavior', [])
);

/*
|--------------------------------------------------------------------------
| THEME DATA
|--------------------------------------------------------------------------
*/

$themeSettings = data_get(
    $pageSettings,
    'settings.theme',
    data_get($pageSettings, 'theme', [])
);

if (! is_array($themeSettings)) {
    $themeSettings = [];
}

$themeColors = data_get(
    $themeSettings,
    'colors',
    []
);

$themeBackgrounds = data_get(
    $themeSettings,
    'backgrounds',
    []
);

$themeBorders = data_get(
    $themeSettings,
    'borders',
    []
);

$themeShadows = data_get(
    $themeSettings,
    'shadows',
    []
);

$themeTypography = data_get(
    $themeSettings,
    'typography',
    []
);

/*
|--------------------------------------------------------------------------
| THEME COLORS
|--------------------------------------------------------------------------
*/

$themePrimaryColor = data_get(
    $themeColors,
    'primary',
    '#4f46e5'
);

$themeSecondaryColor = data_get(
    $themeColors,
    'secondary',
    '#6366f1'
);

$themeAccentColor = data_get(
    $themeColors,
    'accent',
    '#8b5cf6'
);

/*
|--------------------------------------------------------------------------
| THEME BACKGROUNDS
|--------------------------------------------------------------------------
*/

$themePageBackground = data_get(
    $themeBackgrounds,
    'page',
    '#f8fafc'
);

$themeContentBackground = data_get(
    $themeBackgrounds,
    'content',
    '#ffffff'
);

$themeSurfaceBackground = data_get(
    $themeBackgrounds,
    'surface',
    '#ffffff'
);

$themeFooterBackground = data_get(
    $themeBackgrounds,
    'footer',
    '#0f172a'
);

/*
|--------------------------------------------------------------------------
| THEME BORDERS
|--------------------------------------------------------------------------
*/

$themeBorderColor = data_get(
    $themeBorders,
    'color',
    '#e2e8f0'
);

$themeBorderWidth = data_get(
    $themeBorders,
    'width',
    '1px'
);

$themeBorderRadius = data_get(
    $themeBorders,
    'radius',
    '0.5rem'
);

$themeCardRadius = data_get(
    $themeBorders,
    'card_radius',
    '0.75rem'
);

/*
|--------------------------------------------------------------------------
| THEME SHADOWS
|--------------------------------------------------------------------------
*/

$themeDefaultShadow = data_get(
    $themeShadows,
    'default',
    'md'
);

$themeCardShadow = data_get(
    $themeShadows,
    'card',
    'sm'
);

$themeFooterShadow = data_get(
    $themeShadows,
    'footer',
    'none'
);

/*
|--------------------------------------------------------------------------
| THEME TYPOGRAPHY
|--------------------------------------------------------------------------
*/

$themeFontFamily = data_get(
    $themeTypography,
    'font_family'
);

$themeHeadingFont = data_get(
    $themeTypography,
    'heading_font'
);

$themeBodyWeight = data_get(
    $themeTypography,
    'body_weight',
    '400'
);

$themeLineHeight = data_get(
    $themeTypography,
    'line_height',
    '1.625'
);

/*
|--------------------------------------------------------------------------
| BRAND
|--------------------------------------------------------------------------
*/

$brandEnabled = (bool) data_get(
    $brandSocial,
    'enabled',
    false
);

$logo = data_get(
    $brandSocial,
    'logo',
    ''
);

$logoWidth = (int) data_get(
    $brandSocial,
    'logo_width',
    160
);

$logoWidth = max(1, $logoWidth);

$brandName = data_get(
    $brandSocial,
    'brand_name',
    config('app.name', 'Dev-Platform')
);

$brandDescription = data_get(
    $brandSocial,
    'description',
    ''
);

$brandUrl = data_get(
    $brandSocial,
    'url',
    '/'
);

/*
|--------------------------------------------------------------------------
| SOCIAL
|--------------------------------------------------------------------------
*/

$socialEnabled = (bool) data_get(
    $brandSocial,
    'social.enabled',
    false
);

$socials = data_get(
    $brandSocial,
    'social.items',
    []
);

/*
|--------------------------------------------------------------------------
| FOOTER APPEARANCE
|--------------------------------------------------------------------------
|
| Priority:
|
| 1. Footer-specific setting
| 2. Global Theme
| 3. Safe default
|
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Layout
|--------------------------------------------------------------------------
*/

$layout = data_get(
    $appearance,
    'layout',
    'container'
);

$alignment = data_get(
    $appearance,
    'alignment',
    'left'
);

/*
|--------------------------------------------------------------------------
| Background
|--------------------------------------------------------------------------
|
| If Footer has its own background value, use it.
| Otherwise use the centralized Theme CSS variable.
|
|--------------------------------------------------------------------------
*/

$footerSpecificBackground = data_get(
    $appearance,
    'background_color',
    null
);

$backgroundColor = filled($footerSpecificBackground)
    ? $footerSpecificBackground
    : 'var(--page-footer-background, ' . $themeFooterBackground . ')';

/*
|--------------------------------------------------------------------------
| Text colors
|--------------------------------------------------------------------------
*/

$textColor = data_get(
    $appearance,
    'text_color',
    '#d1d5db'
);

$headingColor = data_get(
    $appearance,
    'heading_color',
    '#ffffff'
);

$linkColor = data_get(
    $appearance,
    'link_color',
    $themePrimaryColor
);

$linkHoverColor = data_get(
    $appearance,
    'link_hover_color',
    $themeAccentColor
);

/*
|--------------------------------------------------------------------------
| Border
|--------------------------------------------------------------------------
*/

$borderStyle = data_get(
    $appearance,
    'border_style',
    'none'
);

$borderColor = data_get(
    $appearance,
    'border_color',
    $themeBorderColor
);

$paddingTop = data_get(
    $appearance,
    'padding_top',
    '40px'
);

$paddingBottom = data_get(
    $appearance,
    'padding_bottom',
    '40px'
);

$customClass = data_get(
    $appearance,
    'custom_class',
    ''
);

/*
|--------------------------------------------------------------------------
| FOOTER BEHAVIOR
|--------------------------------------------------------------------------
*/

$sticky = (bool) data_get(
    $behavior,
    'sticky',
    false
);

$backToTop = (bool) data_get(
    $behavior,
    'back_to_top',
    true
);

$backToTopPosition = data_get(
    $behavior,
    'back_to_top_position',
    'right'
);

$showCopyright = (bool) data_get(
    $behavior,
    'show_copyright',
    true
);

$mobileCollapsible = (bool) data_get(
    $behavior,
    'mobile_collapsible',
    true
);

$externalLinksNewTab = (bool) data_get(
    $behavior,
    'external_links_new_tab',
    true
);

$animation = (bool) data_get(
    $behavior,
    'animation',
    false
);

$animationType = data_get(
    $behavior,
    'animation_type',
    'fade'
);

$animationDuration = data_get(
    $behavior,
    'animation_duration',
    '300ms'
);

/*
|--------------------------------------------------------------------------
| LAYOUT CLASSES
|--------------------------------------------------------------------------
*/

$containerClass = $layout === 'full'
    ? 'w-full px-4 sm:px-6 lg:px-8'
    : 'mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8';

$alignmentClass = match ($alignment) {
    'center' => 'text-center items-center',
    'right' => 'text-right items-end',
    default => 'text-left items-start',
};

$stickyClass = $sticky
    ? 'sticky bottom-0'
    : '';

$animationClass = $animation
    ? (
        $animationType === 'slide_up'
            ? 'footer-slide-up'
            : 'footer-fade'
    )
    : '';

/*
|--------------------------------------------------------------------------
| BORDER
|--------------------------------------------------------------------------
*/

$borderTop = $borderStyle === 'none'
    ? '0'
    : '1px ' . $borderStyle . ' ' . $borderColor;

/*
|--------------------------------------------------------------------------
| RADIUS
|--------------------------------------------------------------------------
*/

$radiusClasses = [
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    'full' => 'rounded-full',
];

$radiusClass = $radiusClasses[$themeBorderRadius]
    ?? 'rounded-lg';

$cardRadiusClasses = [
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    'full' => 'rounded-full',
];

$cardRadiusClass = $cardRadiusClasses[$themeCardRadius]
    ?? 'rounded-xl';

/*
|--------------------------------------------------------------------------
| SHADOW
|--------------------------------------------------------------------------
*/

$shadowClasses = [
    'none' => 'shadow-none',
    'sm' => 'shadow-sm',
    'md' => 'shadow-md',
    'lg' => 'shadow-lg',
    'xl' => 'shadow-xl',
    '2xl' => 'shadow-2xl',
];

$defaultShadowClass = $shadowClasses[$themeDefaultShadow]
    ?? 'shadow-md';

$cardShadowClass = $shadowClasses[$themeCardShadow]
    ?? 'shadow-sm';

$footerShadowClass = $shadowClasses[$themeFooterShadow]
    ?? 'shadow-none';

/*
|--------------------------------------------------------------------------
| FOOTER RENDER
|--------------------------------------------------------------------------
*/

@endphp

<footer
    class="
        relative
        z-20
        w-full
        overflow-hidden
        {{ $stickyClass }}
        {{ $customClass }}
        {{ $animationClass }}
        {{ $footerShadowClass }}
        {{ $radiusClass }}
    "
    style="
        background-color: {{ $backgroundColor }};
        color: {{ $textColor }};
        border-top: {{ $borderTop }};
        padding-top: {{ $paddingTop }};
        padding-bottom: {{ $paddingBottom }};
        --footer-link-color: {{ $linkColor }};
        --footer-link-hover-color: {{ $linkHoverColor }};
        --footer-heading-color: {{ $headingColor }};
        --footer-animation-duration: {{ $animationDuration }};
        --theme-primary-color: {{ $themePrimaryColor }};
        --theme-secondary-color: {{ $themeSecondaryColor }};
        --theme-accent-color: {{ $themeAccentColor }};
        --theme-page-background: {{ $themePageBackground }};
        --theme-content-background: {{ $themeContentBackground }};
        --theme-surface-background: {{ $themeSurfaceBackground }};
        --theme-footer-background: {{ $themeFooterBackground }};
        --theme-border-color: {{ $themeBorderColor }};
        --theme-border-width: {{ $themeBorderWidth }};
        --theme-border-radius: {{ $themeBorderRadius }};
        --theme-card-radius: {{ $themeCardRadius }};
    "
>

    <div class="{{ $containerClass }}">

        @if ($brandEnabled)

            <div
                class="
                    mb-10
                    grid
                    grid-cols-1
                    gap-8
                    lg:grid-cols-[minmax(0,1fr)_auto]
                    lg:items-start
                    lg:gap-12
                "
            >

                <div
                    class="
                        flex
                        min-w-0
                        max-w-2xl
                        flex-col
                        {{ $alignmentClass }}
                    "
                >

                    @if (filled($logo))

                        <a
                            href="{{ $brandUrl }}"
                            class="
                                group
                                mb-4
                                inline-flex
                                max-w-full
                                items-center
                                overflow-hidden
                                rounded-xl
                            "
                            aria-label="{{ $brandName }}"
                        >

                            <img
                                src="{{ asset('storage/' . ltrim($logo, '/')) }}"
                                alt="{{ $brandName }}"
                                class="
                                    block
                                    h-auto
                                    max-w-full
                                    object-contain
                                    transition-transform
                                    duration-300
                                    group-hover:scale-[1.02]
                                "
                                style="
                                    width: min({{ $logoWidth }}px, 100%);
                                "
                            >

                        </a>

                    @elseif (filled($brandName))

                        <a
                            href="{{ $brandUrl }}"
                            class="
                                mb-3
                                inline-flex
                                max-w-full
                                items-center
                                text-xl
                                font-bold
                                transition-opacity
                                duration-200
                                hover:opacity-80
                            "
                            style="
                                color: {{ $headingColor }};
                                @if (filled($themeHeadingFont))
                                    font-family: '{{ $themeHeadingFont }}', sans-serif;
                                @endif
                            "
                        >
                            {{ $brandName }}
                        </a>

                    @endif

                    @if (filled($brandDescription))

                        <p
                            class="
                                max-w-2xl
                                text-sm
                                leading-7
                                sm:text-[15px]
                            "
                            style="
                                color: {{ $textColor }};
                                @if (filled($themeFontFamily))
                                    font-family: '{{ $themeFontFamily }}', sans-serif;
                                @endif
                                font-weight: {{ $themeBodyWeight }};
                                line-height: {{ $themeLineHeight }};
                            "
                        >
                            {{ $brandDescription }}
                        </p>

                    @endif

                </div>

                @if ($socialEnabled && filled($socials))

                    <div
                        class="
                            flex
                            w-full
                            flex-col
                            gap-3
                            lg:w-auto
                            {{ $alignmentClass }}
                        "
                    >

                        <span
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-[0.18em]
                            "
                            style="
                                color: {{ $headingColor }};
                                @if (filled($themeHeadingFont))
                                    font-family: '{{ $themeHeadingFont }}', sans-serif;
                                @endif
                            "
                        >
                            Social
                        </span>

                        <div
                            class="
                                flex
                                w-full
                                flex-wrap
                                items-center
                                gap-2
                                sm:gap-3
                                lg:w-auto
                            "
                        >

                            @foreach ($socials as $social)

                                @php

                                    $socialEnabledItem = $social['enabled'] ?? true;

                                    $socialUrl = $social['url'] ?? '#';

                                    $socialLabel =
                                        $social['label']
                                        ?? $social['name']
                                        ?? $social['platform']
                                        ?? 'Social';

                                    $socialNewTab = $social['new_tab'] ?? true;

                                    $platform = strtolower(
                                        trim($social['platform'] ?? '')
                                    );

                                @endphp

                                @if ($socialEnabledItem && filled($socialUrl))

                                    <a
                                        href="{{ $socialUrl }}"
                                        aria-label="{{ $socialLabel }}"
                                        title="{{ $socialLabel }}"
                                        class="
                                            group
                                            relative
                                            inline-flex
                                            h-10
                                            w-10
                                            shrink-0
                                            items-center
                                            justify-center
                                            overflow-hidden
                                            rounded-xl
                                            border
                                            shadow-sm
                                            backdrop-blur-md
                                            transition-all
                                            duration-300
                                            ease-out
                                            hover:-translate-y-1
                                            hover:scale-105
                                            active:translate-y-0
                                            active:scale-95
                                            sm:h-11
                                            sm:w-11
                                        "
                                        style="
                                            color: var(--footer-link-color);
                                            border-color: color-mix(
                                                in srgb,
                                                var(--theme-border-color) 35%,
                                                transparent
                                            );
                                            background-color: color-mix(
                                                in srgb,
                                                var(--theme-surface-background) 8%,
                                                transparent
                                            );
                                        "
                                        @if ($socialNewTab)
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        @endif
                                        onmouseover="this.style.color='var(--footer-link-hover-color)'"
                                        onmouseout="this.style.color='var(--footer-link-color)'"
                                    >

                                        <span
                                            class="
                                                pointer-events-none
                                                absolute
                                                inset-0
                                                rounded-xl
                                                opacity-0
                                                transition-opacity
                                                duration-300
                                                group-hover:opacity-100
                                            "
                                            style="
                                                background:
                                                    linear-gradient(
                                                        135deg,
                                                        color-mix(
                                                            in srgb,
                                                            var(--theme-primary-color) 18%,
                                                            transparent
                                                        ),
                                                        transparent
                                                    );
                                            "
                                        ></span>

                                        <span
                                            class="
                                                relative
                                                z-10
                                                flex
                                                h-5
                                                w-5
                                                items-center
                                                justify-center
                                                transition-transform
                                                duration-300
                                                group-hover:scale-110
                                            "
                                        >

                                            @include(
                                                'public.partials.social-icons',
                                                [
                                                    'platform' => $platform,
                                                ]
                                            )

                                        </span>

                                        <span
                                            class="
                                                pointer-events-none
                                                absolute
                                                bottom-full
                                                left-1/2
                                                z-50
                                                mb-2
                                                hidden
                                                -translate-x-1/2
                                                translate-y-1
                                                whitespace-nowrap
                                                rounded-lg
                                                px-2.5
                                                py-1.5
                                                text-[11px]
                                                font-medium
                                                opacity-0
                                                shadow-xl
                                                backdrop-blur-md
                                                transition-all
                                                duration-200
                                                sm:block
                                                group-hover:translate-y-0
                                                group-hover:opacity-100
                                            "
                                            style="
                                                background-color: rgba(15, 23, 42, 0.92);
                                                color: #ffffff;
                                            "
                                        >
                                            {{ $socialLabel }}
                                        </span>

                                    </a>

                                @endif

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        @endif

        @if (filled($footerText))

            <div class="mb-8 max-w-3xl">

                <p
                    class="text-sm leading-7"
                    style="
                        color: {{ $textColor }};
                        @if (filled($themeFontFamily))
                            font-family: '{{ $themeFontFamily }}', sans-serif;
                        @endif
                        font-weight: {{ $themeBodyWeight }};
                        line-height: {{ $themeLineHeight }};
                    "
                >
                    {{ $footerText }}
                </p>

            </div>

        @endif

        @if (filled($items))

            <div
                class="
                    grid
                    grid-cols-1
                    gap-6
                    sm:grid-cols-2
                    lg:grid-cols-3
                    xl:grid-cols-4
                "
            >

                @foreach ($items as $column)

                    @php

                        $columnTitle = $column['title'] ?? '';

                        $links = $column['links'] ?? [];

                    @endphp

                    <div
                        class="
                            min-w-0
                            border
                            p-5
                            {{ $cardRadiusClass }}
                            {{ $cardShadowClass }}
                            transition-colors
                            duration-300
                            sm:p-6
                        "
                        style="
                            border-color:
                                color-mix(
                                    in srgb,
                                    var(--theme-border-color) 55%,
                                    transparent
                                );

                            background-color:
                                color-mix(
                                    in srgb,
                                    var(--theme-surface-background) 8%,
                                    transparent
                                );
                        "
                    >

                        @if (filled($columnTitle))

                            <h3
                                class="
                                    mb-4
                                    text-sm
                                    font-bold
                                    uppercase
                                    tracking-[0.16em]
                                "
                                style="
                                    color: {{ $headingColor }};
                                    @if (filled($themeHeadingFont))
                                        font-family: '{{ $themeHeadingFont }}', sans-serif;
                                    @endif
                                "
                            >
                                {{ $columnTitle }}
                            </h3>

                        @endif

                        @if (filled($links))

                            <div
                                class="
                                    space-y-1
                                    {{ $mobileCollapsible
                                        ? 'max-md:space-y-1'
                                        : ''
                                    }}
                                "
                            >

                                @foreach ($links as $link)

                                    @php

                                        $label = $link['label'] ?? '';

                                        $url = $link['url'] ?? '#';

                                        $active = $link['active'] ?? true;

                                        $newTab = $link['new_tab'] ?? false;

                                        $isExternal =
                                            filled($url)
                                            && (
                                                str_starts_with($url, 'http://')
                                                || str_starts_with($url, 'https://')
                                                || str_starts_with($url, '//')
                                            );

                                        $openNewTab =
                                            $newTab
                                            || (
                                                $externalLinksNewTab
                                                && $isExternal
                                            );

                                        $footerIcon =
                                            $link['icon']
                                            ?? 'arrow';

                                    @endphp

                                    @if ($active && filled($label))

                                        <a
                                            href="{{ $url }}"
                                            class="
                                                group
                                                flex
                                                min-w-0
                                                w-full
                                                items-center
                                                rounded-lg
                                                px-2.5
                                                py-2
                                                text-sm
                                                leading-6
                                                transition-all
                                                duration-200
                                            "
                                            style="
                                                color: var(--footer-link-color);
                                            "
                                            @if ($openNewTab)
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            @endif
                                            onmouseover="this.style.color='var(--footer-link-hover-color)'"
                                            onmouseout="this.style.color='var(--footer-link-color)'"
                                        >

                                            <span
                                                class="
                                                    shrink-0
                                                    transition-transform
                                                    duration-200
                                                    group-hover:translate-x-1
                                                "
                                            >

                                                @include(
                                                    'public.partials.footer-icons',
                                                    [
                                                        'icon' => $footerIcon,
                                                    ]
                                                )

                                            </span>

                                            <span
                                                class="
                                                    min-w-0
                                                    truncate
                                                "
                                            >
                                                {{ $label }}
                                            </span>

                                        </a>

                                    @endif

                                @endforeach

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @endif

        @if ($showCopyright)

            <div
                class="
                    mt-10
                    flex
                    flex-col
                    gap-4
                    border-t
                    pt-6
                    text-sm
                    md:flex-row
                    md:items-center
                    md:justify-between
                "
                style="
                    border-color: {{ $borderColor }};
                "
            >

                <p
                    class="
                        min-w-0
                        break-words
                        leading-6
                    "
                    style="
                        color: {{ $textColor }};
                    "
                >
                    © {{ date('Y') }}
                    {{ config('app.name', 'Dev-Platform') }}.
                    All rights reserved.
                </p>

                @if (filled($footerText))

                    <div
                        class="
                            min-w-0
                            max-w-full
                            text-sm
                            leading-6
                            md:max-w-md
                            {{
                                $alignment === 'center'
                                    ? 'md:text-center'
                                    : ''
                            }}
                        "
                    >

                        <span
                            class="break-words"
                            style="
                                color: {{ $textColor }};
                            "
                        >
                            {{ $footerText }}
                        </span>

                    </div>

                @endif

            </div>

        @endif

        @if ($backToTop)

            <div
                class="
                    mt-6
                    flex
                    w-full
                    {{
                        match ($backToTopPosition) {
                            'left' => 'justify-start',
                            'center' => 'justify-center',
                            default => 'justify-end',
                        }
                    }}
                "
            >

                <button
                    type="button"
                    onclick="window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    })"
                    class="
                        group
                        inline-flex
                        max-w-full
                        items-center
                        gap-2
                        rounded-xl
                        border
                        px-4
                        py-2
                        text-sm
                        {{ $defaultShadowClass }}
                        backdrop-blur-md
                        transition-all
                        duration-300
                        hover:-translate-y-0.5
                    "
                    style="
                        color: {{ $linkColor }};

                        border-color:
                            color-mix(
                                in srgb,
                                var(--theme-border-color) 45%,
                                transparent
                            );

                        background-color:
                            color-mix(
                                in srgb,
                                var(--theme-surface-background) 8%,
                                transparent
                            );
                    "
                >

                    <span>
                        Back to Top
                    </span>

                    <i
                        class="
                            fa-solid
                            fa-arrow-up
                            transition-transform
                            duration-300
                            group-hover:-translate-y-0.5
                        "
                        aria-hidden="true"
                    ></i>

                </button>

            </div>

        @endif

    </div>

</footer>

@if ($animation)

    <style>

        .footer-fade {
            animation:
                footerFadeIn
                var(--footer-animation-duration)
                ease-out
                both;
        }

        .footer-slide-up {
            animation:
                footerSlideUp
                var(--footer-animation-duration)
                cubic-bezier(.22, 1, .36, 1)
                both;
        }

        @keyframes footerFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes footerSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .footer-fade,
            .footer-slide-up {
                animation: none;
            }

            footer *,
            footer *::before,
            footer *::after {
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
            }

        }

    </style>

@endif