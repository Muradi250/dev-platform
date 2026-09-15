@php
/*
|--------------------------------------------------------------------------
| HEADER SETTINGS
|--------------------------------------------------------------------------
|
| Header-specific settings have priority over global Theme settings.
| Theme settings are used as fallback values.
|
*/

$settings = $settings ?? ($page->settings ?? []);

if (is_string($settings)) {
    $decodedSettings = json_decode($settings, true);

    $settings = is_array($decodedSettings)
        ? $decodedSettings
        : [];
}

if (! is_array($settings)) {
    $settings = [];
}

/*
|--------------------------------------------------------------------------
| THEME SETTINGS
|--------------------------------------------------------------------------
*/

$themeSettings = data_get(
    $settings,
    'settings.theme',
    data_get($settings, 'theme', [])
);

if (is_string($themeSettings)) {
    $decodedThemeSettings = json_decode($themeSettings, true);

    $themeSettings = is_array($decodedThemeSettings)
        ? $decodedThemeSettings
        : [];
}

if (! is_array($themeSettings)) {
    $themeSettings = [];
}

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

/*
|--------------------------------------------------------------------------
| HEADER VISIBILITY
|--------------------------------------------------------------------------
*/

$headerEnabled = (bool) data_get(
    $settings,
    'settings.header.visibility.enabled',
    data_get($settings, 'header.visibility.enabled', true)
);

$headerShowOnDesktop = (bool) data_get(
    $settings,
    'settings.header.visibility.show_on_desktop',
    data_get($settings, 'header.visibility.show_on_desktop', true)
);

$headerShowOnTablet = (bool) data_get(
    $settings,
    'settings.header.visibility.show_on_tablet',
    data_get($settings, 'header.visibility.show_on_tablet', true)
);

$headerShowOnMobile = (bool) data_get(
    $settings,
    'settings.header.visibility.show_on_mobile',
    data_get($settings, 'header.visibility.show_on_mobile', true)
);

/*
|--------------------------------------------------------------------------
| HEADER BEHAVIOR
|--------------------------------------------------------------------------
*/

$headerSticky = (bool) data_get(
    $settings,
    'settings.header.behavior.sticky',
    data_get($settings, 'header.behavior.sticky', false)
);

$headerBlur = (bool) data_get(
    $settings,
    'settings.header.appearance.blur',
    data_get($settings, 'header.appearance.blur', true)
);

/*
|--------------------------------------------------------------------------
| HEADER BACKGROUND
|--------------------------------------------------------------------------
|
| Priority:
|
| 1. Header-specific background
| 2. Global Theme header background
| 3. Safe default
|
*/

$headerBackgroundSetting = data_get(
    $settings,
    'settings.header.appearance.background_color',
    data_get(
        $settings,
        'header.appearance.background_color',
        null
    )
);

$themeHeaderBackground = data_get(
    $themeBackgrounds,
    'header',
    null
);

$headerBackgroundIsDefault =
    blank($headerBackgroundSetting)
    || $headerBackgroundSetting === 'rgba(15, 23, 42, 0.72)';

$headerBackground = $headerBackgroundIsDefault
    ? (
        filled($themeHeaderBackground)
            ? 'var(--page-header-background)'
            : 'rgba(15, 23, 42, 0.72)'
    )
    : $headerBackgroundSetting;

/*
|--------------------------------------------------------------------------
| HEADER BORDER
|--------------------------------------------------------------------------
|
| Priority:
|
| 1. Header-specific border
| 2. Global Theme border color
| 3. Safe default
|
*/

$headerBorderSetting = data_get(
    $settings,
    'settings.header.appearance.border_color',
    data_get(
        $settings,
        'header.appearance.border_color',
        null
    )
);

$themeBorderColor = data_get(
    $themeBorders,
    'color',
    null
);

$headerBorderIsDefault =
    blank($headerBorderSetting)
    || $headerBorderSetting === 'rgba(255, 255, 255, 0.10)';

$headerBorderColor = $headerBorderIsDefault
    ? (
        filled($themeBorderColor)
            ? 'var(--page-border-color)'
            : 'rgba(255, 255, 255, 0.10)'
    )
    : $headerBorderSetting;

/*
|--------------------------------------------------------------------------
| HEADER TEXT COLOR
|--------------------------------------------------------------------------
|
| Theme currently does not have a dedicated Header Text Color.
| Therefore Header-specific text color remains the source.
|
*/

$headerTextColor = data_get(
    $settings,
    'settings.header.appearance.text_color',
    data_get(
        $settings,
        'header.appearance.text_color',
        '#FFFFFF'
    )
);

if (blank($headerTextColor)) {
    $headerTextColor = '#FFFFFF';
}

$headerCustomClass = data_get(
    $settings,
    'settings.header.appearance.custom_class',
    data_get(
        $settings,
        'header.appearance.custom_class',
        ''
    )
);

/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
*/

$logoEnabled = (bool) data_get(
    $settings,
    'settings.header.logo.enabled',
    data_get($settings, 'header.logo.enabled', true)
);

$logoImage = data_get(
    $settings,
    'settings.header.logo.image',
    data_get($settings, 'header.logo.image', null)
);

$logoAlt = data_get(
    $settings,
    'settings.header.logo.alt',
    data_get($settings, 'header.logo.alt', $page->title ?? 'Logo')
);

$logoUrl = data_get(
    $settings,
    'settings.header.logo.url',
    data_get($settings, 'header.logo.url', '/')
);

$logoSize = data_get(
    $settings,
    'settings.header.logo.size',
    data_get($settings, 'header.logo.size', 'md')
);

$logoUseFallback = (bool) data_get(
    $settings,
    'settings.header.logo.use_fallback',
    data_get($settings, 'header.logo.use_fallback', true)
);

$logoFallbackText = data_get(
    $settings,
    'settings.header.logo.fallback_text',
    data_get($settings, 'header.logo.fallback_text', 'D')
);

/*
|--------------------------------------------------------------------------
| BRANDING
|--------------------------------------------------------------------------
*/

$brandingEnabled = (bool) data_get(
    $settings,
    'settings.header.branding.enabled',
    data_get($settings, 'header.branding.enabled', true)
);

$brandingName = data_get(
    $settings,
    'settings.header.branding.name',
    data_get(
        $settings,
        'header.branding.name',
        $page->title ?? 'Dev-Platform'
    )
);

$brandingTagline = data_get(
    $settings,
    'settings.header.branding.tagline',
    data_get($settings, 'header.branding.tagline', '')
);

$brandingUrl = data_get(
    $settings,
    'settings.header.branding.url',
    data_get($settings, 'header.branding.url', '/')
);

$brandingShowTagline = (bool) data_get(
    $settings,
    'settings.header.branding.show_tagline',
    data_get($settings, 'header.branding.show_tagline', true)
);

/*
|--------------------------------------------------------------------------
| SAFE VALUES
|--------------------------------------------------------------------------
*/

$logoSizeClasses = match ($logoSize) {
    'xs' => 'h-7 w-7',
    'sm' => 'h-8 w-8',
    'lg' => 'h-12 w-12',
    'xl' => 'h-14 w-14',
    default => 'h-10 w-10',
};

$headerVisibilityClasses = implode(' ', array_filter([
    ! $headerShowOnDesktop ? 'lg:hidden' : '',
    ! $headerShowOnTablet ? 'md:hidden' : '',
    ! $headerShowOnMobile ? 'hidden md:flex' : '',
]));

$headerPositionClass = $headerSticky
    ? 'sticky top-0'
    : 'relative';

$headerBlurClass = $headerBlur
    ? 'backdrop-blur-xl'
    : '';

$headerStyle = implode('; ', array_filter([
    "background: {$headerBackground}",
    "border-color: {$headerBorderColor}",
    "color: {$headerTextColor}",
]));

/*
|--------------------------------------------------------------------------
| HEADER RENDER
|--------------------------------------------------------------------------
*/

if ($headerEnabled):


@endphp

<header
    id="site-header"
    class="site-header {{ $headerPositionClass }} {{ $headerBlurClass }} {{ $headerVisibilityClasses }} {{ $headerCustomClass }} z-50 w-full border-b"
    style="{{ $headerStyle }}"
    data-header="true"
>
    <div class="mx-auto flex min-h-16 w-full max-w-screen-2xl items-center gap-4 px-4 sm:px-6 lg:px-8">

        {{-- Logo + Branding --}}
        <div class="flex min-w-0 shrink-0 items-center gap-3">

            @if ($logoEnabled || $brandingEnabled)

                {{-- Logo --}}
                @if ($logoEnabled)
                    <a
                        href="{{ $logoUrl }}"
                        class="site-header__logo group flex shrink-0 items-center justify-center overflow-hidden rounded-xl transition-all duration-200 hover:scale-[1.03]"
                        aria-label="{{ $logoAlt }}"
                    >
                        @if ($logoImage)
                            @php
                                $logoSrc = is_array($logoImage)
                                    ? ($logoImage[0] ?? null)
                                    : $logoImage;

                                if (
                                    $logoSrc
                                    && ! str_starts_with($logoSrc, 'http')
                                    && ! str_starts_with($logoSrc, '/')
                                ) {
                                    $logoSrc = \Illuminate\Support\Facades\Storage::url($logoSrc);
                                }
                            @endphp

                            @if ($logoSrc)
                                <img
                                    src="{{ $logoSrc }}"
                                    alt="{{ $logoAlt }}"
                                    class="{{ $logoSizeClasses }} object-contain"
                                    loading="eager"
                                >
                            @elseif ($logoUseFallback)
                                <span
                                    class="{{ $logoSizeClasses }} flex items-center justify-center rounded-xl bg-white/10 text-sm font-bold text-current ring-1 ring-white/10"
                                >
                                    {{ $logoFallbackText }}
                                </span>
                            @endif
                        @elseif ($logoUseFallback)
                            <span
                                class="{{ $logoSizeClasses }} flex items-center justify-center rounded-xl bg-white/10 text-sm font-bold text-current ring-1 ring-white/10"
                            >
                                {{ $logoFallbackText }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- Branding --}}
                @if ($brandingEnabled)
                    <div class="site-header__branding min-w-0">
                        <a
                            href="{{ $brandingUrl }}"
                            class="block min-w-0 no-underline"
                        >
                            <div class="truncate text-sm font-bold leading-tight text-current sm:text-base">
                                {{ $brandingName }}
                            </div>

                            @if ($brandingShowTagline && filled($brandingTagline))
                                <div class="mt-0.5 hidden truncate text-xs opacity-60 sm:block">
                                    {{ $brandingTagline }}
                                </div>
                            @endif
                        </a>
                    </div>
                @endif

            @endif

        </div>

        {{-- Main Header Navigation Slot --}}
        <div class="site-header__navigation flex min-w-0 flex-1 items-center justify-center">
            @if (isset($headerNavigation))
                {{ $headerNavigation }}
            @endif
        </div>

        {{-- Header Actions Slot --}}
        <div class="site-header__actions flex shrink-0 items-center gap-2">
            @if (isset($headerActions))
                {{ $headerActions }}
            @endif
        </div>

    </div>

</header>

@push('styles')

<style>
    .site-header {
        transition:
            background-color 200ms ease,
            border-color 200ms ease,
            box-shadow 200ms ease,
            backdrop-filter 200ms ease;
    }

    .site-header__logo img {
        display: block;
        max-width: 100%;
        height: 100%;
    }

    .site-header__branding a {
        color: inherit;
    }

    .site-header__navigation:empty,
    .site-header__actions:empty {
        display: none;
    }

    @media print {
        .site-header {
            position: relative !important;
            backdrop-filter: none !important;
            box-shadow: none !important;
        }
    }
</style>

@endpush

@php
endif;
@endphp