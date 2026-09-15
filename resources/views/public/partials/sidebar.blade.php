@php

/*
|--------------------------------------------------------------------------
| PAGE SETTINGS
|--------------------------------------------------------------------------
*/

$pageSettings = $pageSettings
    ?? (
        isset($page) && is_object($page)
            ? ($page->settings ?? [])
            : []
    );

if (is_string($pageSettings)) {
    $pageSettings = json_decode($pageSettings, true) ?: [];
}

if (!is_array($pageSettings)) {
    $pageSettings = [];
}


/*
|--------------------------------------------------------------------------
| SIDEBAR SETTINGS
|--------------------------------------------------------------------------
*/

$sidebarSettings = data_get(
    $pageSettings,
    'settings.sidebar',
    []
);

if (empty($sidebarSettings)) {
    $sidebarSettings = data_get(
        $pageSettings,
        'sidebar',
        []
    );
}

if (is_string($sidebarSettings)) {
    $sidebarSettings = json_decode(
        $sidebarSettings,
        true
    ) ?: [];
}

if (!is_array($sidebarSettings)) {
    $sidebarSettings = [];
}


/*
|--------------------------------------------------------------------------
| SIDEBAR GENERAL
|--------------------------------------------------------------------------
*/

$sidebarEnabled = (bool) data_get(
    $sidebarSettings,
    'enabled',
    true
);

$sidebarPosition = data_get(
    $sidebarSettings,
    'position',
    'right'
);

$sidebarPosition = in_array(
    $sidebarPosition,
    ['left', 'right'],
    true
)
    ? $sidebarPosition
    : 'right';

$sidebarWidth = data_get(
    $sidebarSettings,
    'width',
    'md'
);

$sidebarSticky = (bool) data_get(
    $sidebarSettings,
    'sticky',
    true
);

$sidebarCollapsible = (bool) data_get(
    $sidebarSettings,
    'collapsible',
    true
);


/*
|--------------------------------------------------------------------------
| SIDEBAR APPEARANCE
|--------------------------------------------------------------------------
*/

$sidebarAppearance = data_get(
    $sidebarSettings,
    'appearance',
    []
);

if (!is_array($sidebarAppearance)) {
    $sidebarAppearance = [];
}

$sidebarStyle = data_get(
    $sidebarAppearance,
    'style',
    'glass'
);

$sidebarTheme = data_get(
    $sidebarAppearance,
    'theme',
    'dark'
);

$sidebarBackground = data_get(
    $sidebarAppearance,
    'background_color',
    '#111827'
);

$sidebarBackgroundSecondary = data_get(
    $sidebarAppearance,
    'background_secondary_color',
    '#1E293B'
);

$sidebarBackgroundOpacity = data_get(
    $sidebarAppearance,
    'background_opacity',
    88
);

$sidebarBlur = data_get(
    $sidebarAppearance,
    'blur',
    '18px'
);

$sidebarTextColor = data_get(
    $sidebarAppearance,
    'text_color',
    '#D1D5DB'
);

$sidebarHeadingColor = data_get(
    $sidebarAppearance,
    'heading_color',
    '#FFFFFF'
);

$sidebarMutedTextColor = data_get(
    $sidebarAppearance,
    'muted_text_color',
    '#94A3B8'
);

$sidebarLinkColor = data_get(
    $sidebarAppearance,
    'link_color',
    '#D1D5DB'
);

$sidebarLinkHoverColor = data_get(
    $sidebarAppearance,
    'link_hover_color',
    '#FFFFFF'
);

$sidebarLinkHoverBackground = data_get(
    $sidebarAppearance,
    'link_hover_background',
    '#FFFFFF1A'
);

$sidebarActiveColor = data_get(
    $sidebarAppearance,
    'active_color',
    '#FFFFFF'
);

$sidebarActiveBackground = data_get(
    $sidebarAppearance,
    'active_background',
    '#4F46E5'
);

$sidebarActiveBorderColor = data_get(
    $sidebarAppearance,
    'active_border_color',
    '#6366F1'
);

$sidebarActiveIndicator = data_get(
    $sidebarAppearance,
    'active_indicator',
    'left'
);

$sidebarIconColor = data_get(
    $sidebarAppearance,
    'icon_color',
    '#94A3B8'
);

$sidebarIconBackground = data_get(
    $sidebarAppearance,
    'icon_background',
    '#FFFFFF0D'
);

$sidebarIconActiveColor = data_get(
    $sidebarAppearance,
    'icon_active_color',
    '#FFFFFF'
);

$sidebarIconActiveBackground = data_get(
    $sidebarAppearance,
    'icon_active_background',
    '#4F46E5'
);

$sidebarIconStyle = data_get(
    $sidebarAppearance,
    'icon_style',
    'soft'
);

$sidebarBadgeBackground = data_get(
    $sidebarAppearance,
    'badge_background',
    '#4F46E5'
);

$sidebarBadgeTextColor = data_get(
    $sidebarAppearance,
    'badge_text_color',
    '#FFFFFF'
);

$sidebarBadgeStyle = data_get(
    $sidebarAppearance,
    'badge_style',
    'soft'
);

$sidebarBorderColor = data_get(
    $sidebarAppearance,
    'border_color',
    '#374151'
);

$sidebarBorderStyle = data_get(
    $sidebarAppearance,
    'border_style',
    'solid'
);

$sidebarBorderWidth = data_get(
    $sidebarAppearance,
    'border_width',
    '1px'
);

$sidebarBorderRadius = data_get(
    $sidebarAppearance,
    'border_radius',
    '2xl'
);

$sidebarShadow = data_get(
    $sidebarAppearance,
    'shadow',
    'xl'
);

$sidebarPadding = data_get(
    $sidebarAppearance,
    'padding',
    '20px'
);

$sidebarItemGap = data_get(
    $sidebarAppearance,
    'item_gap',
    '6px'
);

$sidebarItemRadius = data_get(
    $sidebarAppearance,
    'item_radius',
    '12px'
);

$sidebarHoverEffect = (bool) data_get(
    $sidebarAppearance,
    'hover_effect',
    true
);

$sidebarGlowEffect = (bool) data_get(
    $sidebarAppearance,
    'glow_effect',
    false
);

$sidebarIconAnimation = (bool) data_get(
    $sidebarAppearance,
    'icon_animation',
    true
);

$sidebarShowHeader = (bool) data_get(
    $sidebarAppearance,
    'show_header',
    true
);

$sidebarHeaderBackground = data_get(
    $sidebarAppearance,
    'header_background',
    '#FFFFFF08'
);

$sidebarHeaderBorderColor = data_get(
    $sidebarAppearance,
    'header_border_color',
    '#FFFFFF12'
);

$sidebarUseBackdropFilter = (bool) data_get(
    $sidebarAppearance,
    'use_backdrop_filter',
    true
);

$sidebarCustomClass = data_get(
    $sidebarAppearance,
    'custom_class',
    ''
);


/*
|--------------------------------------------------------------------------
| SIDEBAR BEHAVIOR
|--------------------------------------------------------------------------
*/

$sidebarAnimation = (bool) data_get(
    $sidebarSettings,
    'animation',
    true
);

$sidebarAnimationType = data_get(
    $sidebarSettings,
    'animation_type',
    'slide'
);

$sidebarAnimationDuration = data_get(
    $sidebarSettings,
    'animation_duration',
    '300ms'
);

$sidebarActiveItem = (bool) data_get(
    $sidebarSettings,
    'active_item',
    true
);

$sidebarSmoothScroll = (bool) data_get(
    $sidebarSettings,
    'smooth_scroll',
    true
);

$sidebarRememberState = (bool) data_get(
    $sidebarSettings,
    'remember_state',
    false
);

$sidebarHideWhenEmpty = (bool) data_get(
    $sidebarSettings,
    'hide_when_empty',
    true
);

$sidebarHideOnPrint = (bool) data_get(
    $sidebarSettings,
    'hide_on_print',
    true
);


/*
|--------------------------------------------------------------------------
| SIDEBAR ITEMS
|--------------------------------------------------------------------------
*/

$sidebarItems = data_get(
    $sidebarSettings,
    'items',
    []
);

if (is_string($sidebarItems)) {
    $sidebarItems = json_decode(
        $sidebarItems,
        true
    ) ?: [];
}

if (!is_array($sidebarItems)) {
    $sidebarItems = [];
}

$sidebarItems = collect($sidebarItems)
    ->filter(function ($item) {
        return is_array($item)
            && filled(data_get($item, 'label'));
    })
    ->values()
    ->all();

if (
    $sidebarHideWhenEmpty
    && empty($sidebarItems)
) {
    $sidebarEnabled = false;
}


/*
|--------------------------------------------------------------------------
| SIDEBAR WIDTH
|--------------------------------------------------------------------------
*/

$sidebarWidthValue = match ($sidebarWidth) {
    'sm' => '224px',
    'md' => '256px',
    'lg' => '288px',
    'xl' => '320px',
    default => '256px',
};


/*
|--------------------------------------------------------------------------
| SIDEBAR BORDER RADIUS
|--------------------------------------------------------------------------
*/

$sidebarRadiusValue = match ($sidebarBorderRadius) {
    'none' => '0',
    'sm' => '0.375rem',
    'md' => '0.5rem',
    'lg' => '0.75rem',
    'xl' => '1rem',
    '2xl' => '1.25rem',
    '3xl' => '1.5rem',
    default => '1.25rem',
};


/*
|--------------------------------------------------------------------------
| SIDEBAR SHADOW
|--------------------------------------------------------------------------
*/

$sidebarShadowValue = match ($sidebarShadow) {
    'none' => 'none',

    'sm' =>
        '0 1px 2px rgba(0,0,0,.05)',

    'md' =>
        '0 4px 6px -1px rgba(0,0,0,.10), 0 2px 4px -2px rgba(0,0,0,.10)',

    'lg' =>
        '0 10px 15px -3px rgba(0,0,0,.10), 0 4px 6px -4px rgba(0,0,0,.10)',

    'xl' =>
        '0 20px 25px -5px rgba(0,0,0,.10), 0 8px 10px -6px rgba(0,0,0,.10)',

    '2xl' =>
        '0 25px 50px -12px rgba(0,0,0,.25)',

    default =>
        '0 20px 25px -5px rgba(0,0,0,.10)',
};


/*
|--------------------------------------------------------------------------
| SIDEBAR OPACITY
|--------------------------------------------------------------------------
*/

$sidebarOpacity = is_numeric(
    $sidebarBackgroundOpacity
)
    ? max(
        0,
        min(
            100,
            (float) $sidebarBackgroundOpacity
        )
    ) / 100
    : 0.88;


/*
|--------------------------------------------------------------------------
| SIDEBAR THEME
|--------------------------------------------------------------------------
*/

$sidebarThemeClass = match ($sidebarTheme) {
    'light' => 'sidebar-theme-light',
    'auto' => 'sidebar-theme-auto',
    default => 'sidebar-theme-dark',
};


/*
|--------------------------------------------------------------------------
| SIDEBAR ICON MAPPER
|--------------------------------------------------------------------------
*/

$sidebarIcon = function ($icon) {

    return match ($icon) {

        'home' =>
            'heroicon-o-home',

        'dashboard' =>
            'heroicon-o-squares-2x2',

        'user' =>
            'heroicon-o-user',

        'users' =>
            'heroicon-o-users',

        'profile' =>
            'heroicon-o-identification',

        'settings' =>
            'heroicon-o-cog-6-tooth',

        'document' =>
            'heroicon-o-document-text',

        'folder' =>
            'heroicon-o-folder',

        'calendar' =>
            'heroicon-o-calendar-days',

        'clock' =>
            'heroicon-o-clock',

        'mail' =>
            'heroicon-o-envelope',

        'bell' =>
            'heroicon-o-bell',

        'search' =>
            'heroicon-o-magnifying-glass',

        'chart' =>
            'heroicon-o-chart-bar',

        'briefcase' =>
            'heroicon-o-briefcase',

        'book' =>
            'heroicon-o-book-open',

        'lock' =>
            'heroicon-o-lock-closed',

        'help' =>
            'heroicon-o-question-mark-circle',

        'info' =>
            'heroicon-o-information-circle',

        'star' =>
            'heroicon-o-star',

        'heart' =>
            'heroicon-o-heart',

        'arrow' =>
            'heroicon-o-chevron-right',

        default =>
            'heroicon-o-chevron-right',
    };
};

@endphp


@if ($sidebarEnabled)

    {{-- ================================================================
         GLOBAL SIDEBAR TOGGLE
         Desktop + Tablet + Mobile
         ================================================================ --}}

    <button
        type="button"
        id="mobile-sidebar-toggle"
        class="mobile-sidebar-toggle"
        aria-label="{{ __('Open sidebar') }}"
        aria-controls="public-sidebar"
        aria-expanded="false"
        data-open-label="{{ __('Open sidebar') }}"
        data-close-label="{{ __('Close sidebar') }}"
    >
        <x-heroicon-o-bars-3
            class="mobile-sidebar-toggle-icon mobile-sidebar-toggle-open"
        />

        <x-heroicon-o-x-mark
            class="mobile-sidebar-toggle-icon mobile-sidebar-toggle-close"
        />
    </button>


    {{-- ================================================================
         SIDEBAR
         ================================================================ --}}

    <aside
        id="public-sidebar"
        class="
            public-sidebar
            public-sidebar-position-{{ $sidebarPosition }}
            {{ $sidebarThemeClass }}
            sidebar-style-{{ $sidebarStyle }}
            sidebar-width-{{ $sidebarWidth }}
            {{ $sidebarSticky ? 'sidebar-is-sticky' : '' }}
            {{ $sidebarCollapsible ? 'sidebar-is-collapsible' : '' }}
            {{ $sidebarCustomClass }}
        "
        data-sidebar-position="{{ $sidebarPosition }}"
        data-sidebar-width="{{ $sidebarWidth }}"
        data-sidebar-animation="{{ $sidebarAnimation ? 'true' : 'false' }}"
        data-sidebar-animation-type="{{ $sidebarAnimationType }}"
        data-sidebar-animation-duration="{{ $sidebarAnimationDuration }}"
        style="
            --sidebar-width: {{ $sidebarWidthValue }};
            --sidebar-padding: {{ $sidebarPadding }};
            --sidebar-item-gap: {{ $sidebarItemGap }};
            --sidebar-item-radius: {{ $sidebarItemRadius }};
            --sidebar-radius: {{ $sidebarRadiusValue }};
            --sidebar-shadow: {{ $sidebarShadowValue }};
            --sidebar-bg: {{ $sidebarBackground }};
            --sidebar-bg-secondary: {{ $sidebarBackgroundSecondary }};
            --sidebar-bg-opacity: {{ $sidebarOpacity }};
            --sidebar-blur: {{ $sidebarBlur }};
            --sidebar-text: {{ $sidebarTextColor }};
            --sidebar-heading: {{ $sidebarHeadingColor }};
            --sidebar-muted: {{ $sidebarMutedTextColor }};
            --sidebar-link: {{ $sidebarLinkColor }};
            --sidebar-link-hover: {{ $sidebarLinkHoverColor }};
            --sidebar-link-hover-bg: {{ $sidebarLinkHoverBackground }};
            --sidebar-active: {{ $sidebarActiveColor }};
            --sidebar-active-bg: {{ $sidebarActiveBackground }};
            --sidebar-active-border: {{ $sidebarActiveBorderColor }};
            --sidebar-icon: {{ $sidebarIconColor }};
            --sidebar-icon-bg: {{ $sidebarIconBackground }};
            --sidebar-icon-active: {{ $sidebarIconActiveColor }};
            --sidebar-icon-active-bg: {{ $sidebarIconActiveBackground }};
            --sidebar-badge-bg: {{ $sidebarBadgeBackground }};
            --sidebar-badge-text: {{ $sidebarBadgeTextColor }};
            --sidebar-border-color: {{ $sidebarBorderColor }};
            --sidebar-border-style: {{ $sidebarBorderStyle }};
            --sidebar-border-width: {{ $sidebarBorderWidth }};
            --sidebar-header-bg: {{ $sidebarHeaderBackground }};
            --sidebar-header-border: {{ $sidebarHeaderBorderColor }};
            --sidebar-animation-duration: {{ $sidebarAnimationDuration }};
        "
    >

        <div class="public-sidebar-inner">

            {{-- =========================================================
                 SIDEBAR HEADER
                 ========================================================= --}}

            @if ($sidebarShowHeader)

                <div class="public-sidebar-header">

                    <div class="public-sidebar-header-content">

                        <div class="public-sidebar-title">
                            {{ $page->title ?? config('app.name') }}
                        </div>

                    </div>


                    @if ($sidebarCollapsible)

                        <button
                            type="button"
                            id="sidebar-collapse-button"
                            class="sidebar-collapse-button"
                            aria-label="{{ __('Collapse sidebar') }}"
                            aria-expanded="true"
                        >
                            <x-heroicon-o-chevron-double-left />
                        </button>

                    @endif

                </div>

            @endif


            {{-- =========================================================
                 SIDEBAR NAVIGATION
                 ========================================================= --}}

            <nav
                class="public-sidebar-navigation"
                aria-label="{{ __('Sidebar navigation') }}"
            >

                <ul class="public-sidebar-list">

                    @foreach ($sidebarItems as $item)

                        @php

                            $itemLabel = data_get(
                                $item,
                                'label',
                                ''
                            );

                            $itemUrl = data_get(
                                $item,
                                'url',
                                '#'
                            );

                            $itemIcon = data_get(
                                $item,
                                'icon',
                                'arrow'
                            );

                            $itemActive = (bool) data_get(
                                $item,
                                'active',
                                true
                            );

                            $itemNewTab = (bool) data_get(
                                $item,
                                'new_tab',
                                false
                            );

                            $itemBadgeEnabled = (bool) data_get(
                                $item,
                                'badge_enabled',
                                false
                            );

                            $itemBadge = data_get(
                                $item,
                                'badge',
                                ''
                            );

                            $itemBadgeStyle = data_get(
                                $item,
                                'badge_style',
                                'default'
                            );


                            if (!$itemActive) {
                                continue;
                            }


                            $currentPath = trim(
                                parse_url(
                                    request()->url(),
                                    PHP_URL_PATH
                                ) ?? '',
                                '/'
                            );


                            $itemPath = trim(
                                parse_url(
                                    $itemUrl,
                                    PHP_URL_PATH
                                ) ?? '',
                                '/'
                            );


                            $isCurrentItem =
                                $sidebarActiveItem
                                &&
                                $itemPath !== ''
                                &&
                                (
                                    $currentPath === $itemPath
                                    ||
                                    str_starts_with(
                                        $currentPath . '/',
                                        $itemPath . '/'
                                    )
                                );


                            $itemIconName =
                                $sidebarIcon($itemIcon);

                        @endphp


                        <li class="public-sidebar-list-item">

                            <a
                                href="{{ $itemUrl }}"
                                class="
                                    public-sidebar-item
                                    {{ $isCurrentItem ? 'is-active' : '' }}
                                "
                                @if ($itemNewTab)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                @if ($isCurrentItem)
                                    aria-current="page"
                                @endif
                            >

                                @if (
                                    $isCurrentItem
                                    && $sidebarActiveIndicator !== 'none'
                                )

                                    <span
                                        class="
                                            sidebar-active-indicator
                                            sidebar-active-indicator-{{ $sidebarActiveIndicator }}
                                        "
                                    ></span>

                                @endif


                                <span
                                    class="
                                        public-sidebar-item-icon
                                        sidebar-icon-style-{{ $sidebarIconStyle }}
                                    "
                                >

                                    <x-dynamic-component
                                        :component="$itemIconName"
                                    />

                                </span>


                                <span class="public-sidebar-item-label">
                                    {{ $itemLabel }}
                                </span>


                                @if (
                                    $itemBadgeEnabled
                                    && filled($itemBadge)
                                )

                                    <span
                                        class="
                                            public-sidebar-item-badge
                                            sidebar-badge-{{ $itemBadgeStyle }}
                                        "
                                    >
                                        {{ $itemBadge }}
                                    </span>

                                @endif

                            </a>

                        </li>

                    @endforeach

                </ul>

            </nav>

        </div>

    </aside>


    {{-- ================================================================
         SIDEBAR STYLES
         ================================================================ --}}

    <style>

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR ROOT
        |--------------------------------------------------------------------------
        */

        .public-sidebar {

            position: fixed !important;

            top: 20px;
            bottom: 20px;

            z-index: 1100;

            width: var(--sidebar-width);
            max-width: min(
                var(--sidebar-width),
                calc(100vw - 32px)
            );

            height: calc(100vh - 40px);
            height: calc(100dvh - 40px);

            color: var(--sidebar-text);

            background:
                linear-gradient(
                    180deg,
                    color-mix(
                        in srgb,
                        var(--sidebar-bg)
                        calc(var(--sidebar-bg-opacity) * 100%),
                        transparent
                    ),
                    color-mix(
                        in srgb,
                        var(--sidebar-bg-secondary)
                        calc(var(--sidebar-bg-opacity) * 100%),
                        transparent
                    )
                );

            border:
                var(--sidebar-border-width)
                var(--sidebar-border-style)
                var(--sidebar-border-color);

            box-shadow: var(--sidebar-shadow);

            border-radius: var(--sidebar-radius);

            overflow: hidden;

            isolation: isolate;

            box-sizing: border-box;

            transform: translateX(0);

            transition:
                transform var(--sidebar-animation-duration) ease,
                width var(--sidebar-animation-duration) ease,
                box-shadow 180ms ease;
        }


        /*
        |--------------------------------------------------------------------------
        | LEFT / RIGHT POSITION
        |--------------------------------------------------------------------------
        */

        .public-sidebar-position-left {

            left: 20px;
            right: auto;

        }


        .public-sidebar-position-right {

            right: 20px;
            left: auto;

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSED STATE
        |--------------------------------------------------------------------------
        */

        .public-sidebar-position-left:not(.sidebar-open) {

            transform: translateX(
                calc(-100% - 24px)
            );

        }


        .public-sidebar-position-right:not(.sidebar-open) {

            transform: translateX(
                calc(100% + 24px)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | OPEN STATE
        |--------------------------------------------------------------------------
        */

        .public-sidebar.sidebar-open {

            transform: translateX(0);

        }


        /*
        |--------------------------------------------------------------------------
        | NO ANIMATION
        |--------------------------------------------------------------------------
        */

        @if (!$sidebarAnimation)

            .public-sidebar {

                transition: none !important;

            }

        @endif


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR STYLES
        |--------------------------------------------------------------------------
        */

        .sidebar-style-glass {

            background:
                linear-gradient(
                    145deg,
                    color-mix(
                        in srgb,
                        var(--sidebar-bg)
                        calc(var(--sidebar-bg-opacity) * 100%),
                        transparent
                    ),
                    color-mix(
                        in srgb,
                        var(--sidebar-bg-secondary)
                        calc(var(--sidebar-bg-opacity) * 100%),
                        transparent
                    )
                );

        }


        .sidebar-style-solid {

            background: var(--sidebar-bg);

        }


        .sidebar-style-transparent {

            background: transparent;

            box-shadow: none;

        }


        .sidebar-style-gradient {

            background:
                linear-gradient(
                    160deg,
                    var(--sidebar-bg),
                    var(--sidebar-bg-secondary)
                );

        }


        /*
        |--------------------------------------------------------------------------
        | BACKDROP FILTER
        |--------------------------------------------------------------------------
        */

        @supports (
            (-webkit-backdrop-filter: blur(1px))
            or
            (backdrop-filter: blur(1px))
        ) {

            .public-sidebar {

                @if ($sidebarUseBackdropFilter)

                    -webkit-backdrop-filter:
                        blur(var(--sidebar-blur));

                    backdrop-filter:
                        blur(var(--sidebar-blur));

                @endif

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR INNER
        |--------------------------------------------------------------------------
        */

        .public-sidebar-inner {

            width: 100%;
            height: 100%;
            max-height: 100%;

            display: flex;

            flex-direction: column;

            min-height: 0;

            padding: var(--sidebar-padding);

            box-sizing: border-box;

            overflow: hidden;

        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .public-sidebar-header {

            position: relative;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            min-height: 54px;

            margin-bottom: 16px;

            padding: 10px 12px;

            color: var(--sidebar-heading);

            background: var(--sidebar-header-bg);

            border:
                1px solid
                var(--sidebar-header-border);

            border-radius:
                var(--sidebar-item-radius);

            flex-shrink: 0;

        }


        .public-sidebar-header-content {

            min-width: 0;

            flex: 1;

        }


        .public-sidebar-title {

            overflow: hidden;

            font-size: 0.95rem;

            font-weight: 700;

            line-height: 1.4;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        /*
        |--------------------------------------------------------------------------
        | INTERNAL COLLAPSE BUTTON
        |--------------------------------------------------------------------------
        */

        .sidebar-collapse-button {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            border:
                1px solid
                var(--sidebar-border-color);

            border-radius: 10px;

            color: var(--sidebar-muted);

            background:
                var(--sidebar-icon-bg);

            cursor: pointer;

            transition:
                color 180ms ease,
                background 180ms ease,
                transform 180ms ease,
                border-color 180ms ease;

        }


        .sidebar-collapse-button svg {

            width: 18px;
            height: 18px;

        }


        .sidebar-collapse-button:hover {

            color: var(--sidebar-heading);

            background:
                var(--sidebar-link-hover-bg);

            border-color:
                var(--sidebar-active-border);

            transform: scale(1.04);

        }


        /*
        |--------------------------------------------------------------------------
        | NAVIGATION
        |--------------------------------------------------------------------------
        */

        .public-sidebar-navigation {

            flex: 1;

            min-height: 0;

            overflow-y: auto;
            overflow-x: hidden;

            scrollbar-width: thin;

        }


        .public-sidebar-navigation::-webkit-scrollbar {

            width: 5px;

        }


        .public-sidebar-navigation::-webkit-scrollbar-thumb {

            background:
                var(--sidebar-border-color);

            border-radius: 999px;

        }


        /*
        |--------------------------------------------------------------------------
        | LIST
        |--------------------------------------------------------------------------
        */

        .public-sidebar-list {

            display: flex;

            flex-direction: column;

            gap: var(--sidebar-item-gap);

            margin: 0;
            padding: 0;

            list-style: none;

        }


        .public-sidebar-list-item {

            position: relative;

            width: 100%;

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR ITEM
        |--------------------------------------------------------------------------
        */

        .public-sidebar-item {

            position: relative;

            display: flex;

            align-items: center;

            gap: 11px;

            width: 100%;

            min-height: 46px;

            padding: 8px 12px;

            color: var(--sidebar-link);

            background: transparent;

            border:
                1px solid transparent;

            border-radius:
                var(--sidebar-item-radius);

            text-decoration: none;

            transition:
                color 180ms ease,
                background 180ms ease,
                border-color 180ms ease,
                box-shadow 180ms ease,
                transform 180ms ease;

            box-sizing: border-box;

        }


        @if ($sidebarHoverEffect)

            .public-sidebar-item:hover {

                color: var(--sidebar-link-hover);

                background:
                    var(--sidebar-link-hover-bg);

                border-color:
                    color-mix(
                        in srgb,
                        var(--sidebar-border-color) 70%,
                        transparent
                    );

            }

        @endif


        /*
        |--------------------------------------------------------------------------
        | ACTIVE ITEM
        |--------------------------------------------------------------------------
        */

        .public-sidebar-item.is-active {

            color: var(--sidebar-active);

            background:
                var(--sidebar-active-bg);

            border-color:
                var(--sidebar-active-border);

            box-shadow:
                0 8px 20px
                color-mix(
                    in srgb,
                    var(--sidebar-active-bg) 22%,
                    transparent
                );

        }


        @if ($sidebarGlowEffect)

            .public-sidebar-item.is-active {

                box-shadow:
                    0 0 0 1px
                    var(--sidebar-active-border),

                    0 0 24px
                    color-mix(
                        in srgb,
                        var(--sidebar-active-bg) 30%,
                        transparent
                    );

            }

        @endif


        /*
        |--------------------------------------------------------------------------
        | ITEM ICON
        |--------------------------------------------------------------------------
        */

        .public-sidebar-item-icon {

            position: relative;

            z-index: 1;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            color:
                var(--sidebar-icon);

            background:
                var(--sidebar-icon-bg);

            border-radius: 10px;

            transition:
                color 180ms ease,
                background 180ms ease,
                transform 180ms ease;

        }


        .public-sidebar-item-icon svg {

            width: 18px;
            height: 18px;

        }


        .public-sidebar-item.is-active
        .public-sidebar-item-icon {

            color:
                var(--sidebar-icon-active);

            background:
                var(--sidebar-icon-active-bg);

        }


        @if ($sidebarIconAnimation)

            .public-sidebar-item:hover
            .public-sidebar-item-icon {

                transform:
                    translateX(-2px);

            }

        @endif


        /*
        |--------------------------------------------------------------------------
        | ITEM LABEL
        |--------------------------------------------------------------------------
        */

        .public-sidebar-item-label {

            min-width: 0;

            flex: 1;

            overflow: hidden;

            font-size: 0.9rem;

            font-weight: 500;

            line-height: 1.4;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE INDICATOR
        |--------------------------------------------------------------------------
        */

        .sidebar-active-indicator {

            position: absolute;

            z-index: 3;

            background:
                var(--sidebar-active-border);

            border-radius: 999px;

        }


        .sidebar-active-indicator-left {

            top: 8px;
            bottom: 8px;
            left: 0;

            width: 3px;

        }


        .sidebar-active-indicator-right {

            top: 8px;
            right: 0;
            bottom: 8px;

            width: 3px;

        }


        .sidebar-active-indicator-border {

            inset: 0;

            background: transparent;

            border:
                1px solid
                var(--sidebar-active-border);

        }


        .sidebar-active-indicator-glow {

            top: 8px;
            bottom: 8px;
            left: 0;

            width: 3px;

            box-shadow:
                0 0 12px
                var(--sidebar-active-border);

        }


        /*
        |--------------------------------------------------------------------------
        | BADGES
        |--------------------------------------------------------------------------
        */

        .public-sidebar-item-badge {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 24px;
            min-height: 22px;

            padding: 2px 7px;

            font-size: 0.7rem;

            font-weight: 700;

            line-height: 1;

            border-radius: 999px;

            white-space: nowrap;

        }


        .sidebar-badge-default {

            color:
                var(--sidebar-badge-text);

            background:
                var(--sidebar-badge-bg);

        }


        .sidebar-badge-success {

            color: #ffffff;

            background: #16a34a;

        }


        .sidebar-badge-warning {

            color: #111827;

            background: #f59e0b;

        }


        .sidebar-badge-danger {

            color: #ffffff;

            background: #dc2626;

        }


        .sidebar-badge-info {

            color: #ffffff;

            background: #2563eb;

        }


        /*
        |--------------------------------------------------------------------------
        | COLLAPSED SIDEBAR
        |--------------------------------------------------------------------------
        */

        .public-sidebar.sidebar-collapsed {

            width: 82px;

        }


        .public-sidebar.sidebar-collapsed
        .public-sidebar-title,

        .public-sidebar.sidebar-collapsed
        .public-sidebar-item-label,

        .public-sidebar.sidebar-collapsed
        .public-sidebar-item-badge {

            display: none;

        }


        .public-sidebar.sidebar-collapsed
        .public-sidebar-item {

            justify-content: center;

            padding-inline: 6px;

        }


        .public-sidebar.sidebar-collapsed
        .public-sidebar-item-icon {

            flex-basis: 38px;

            width: 38px;
            height: 38px;

        }


        /*
        |--------------------------------------------------------------------------
        | STICKY COMPATIBILITY
        |--------------------------------------------------------------------------
        |
        | Sidebar is now always fixed.
        | This class remains only for compatibility with the setting.
        |
        */

        .sidebar-is-sticky {

            position: fixed !important;

        }


        /*
        |--------------------------------------------------------------------------
        | GLOBAL HAMBURGER
        |--------------------------------------------------------------------------
        |
        | Desktop + Tablet + Mobile
        |
        */

        .mobile-sidebar-toggle {

            position: fixed;

            top: 20px;

            z-index: 1200;

            display: flex;

            align-items: center;

            justify-content: center;

            width: 44px;
            height: 44px;

            padding: 0;

            color:
                var(--sidebar-heading);

            background:
                color-mix(
                    in srgb,
                    var(--sidebar-bg) 90%,
                    transparent
                );

            border:
                1px solid
                var(--sidebar-border-color);

            border-radius: 12px;

            box-shadow:
                0 8px 24px
                rgba(0, 0, 0, 0.16);

            cursor: pointer;

            backdrop-filter:
                blur(12px);

            -webkit-backdrop-filter:
                blur(12px);

            transition:
                left var(--sidebar-animation-duration) ease,
                right var(--sidebar-animation-duration) ease,
                transform 180ms ease,
                box-shadow 180ms ease,
                background 180ms ease;

        }


        /*
        |--------------------------------------------------------------------------
        | HAMBURGER POSITION
        |--------------------------------------------------------------------------
        */

        .mobile-sidebar-toggle {

            @if ($sidebarPosition === 'left')

                left: 20px;
                right: auto;

            @else

                right: 20px;
                left: auto;

            @endif

        }


        /*
        |--------------------------------------------------------------------------
        | HAMBURGER WHEN SIDEBAR IS OPEN
        |--------------------------------------------------------------------------
        */

        body:has(
            #public-sidebar.sidebar-open.public-sidebar-position-left
        )
        #mobile-sidebar-toggle {

            @if ($sidebarPosition === 'left')

                left:
                    calc(
                        var(--sidebar-width)
                        + 36px
                    );

            @endif

        }


        body:has(
            #public-sidebar.sidebar-open.public-sidebar-position-right
        )
        #mobile-sidebar-toggle {

            @if ($sidebarPosition === 'right')

                right:
                    calc(
                        var(--sidebar-width)
                        + 36px
                    );

            @endif

        }


        /*
        |--------------------------------------------------------------------------
        | HAMBURGER HOVER
        |--------------------------------------------------------------------------
        */

        .mobile-sidebar-toggle:hover {

            transform:
                scale(1.05);

            box-shadow:
                0 10px 28px
                rgba(0, 0, 0, 0.22);

        }


        .mobile-sidebar-toggle:focus-visible {

            outline:
                2px solid
                var(--sidebar-active-border);

            outline-offset: 3px;

        }


        .mobile-sidebar-toggle-icon {

            width: 22px;
            height: 22px;

        }


        .mobile-sidebar-toggle-close {

            display: none;

        }


        .mobile-sidebar-toggle.is-open
        .mobile-sidebar-toggle-open {

            display: none;

        }


        .mobile-sidebar-toggle.is-open
        .mobile-sidebar-toggle-close {

            display: block;

        }


        /*
        |--------------------------------------------------------------------------
        | RTL
        |--------------------------------------------------------------------------
        */

        [dir="rtl"]
        .sidebar-active-indicator-left {

            right: 0;
            left: auto;

        }


        [dir="rtl"]
        .sidebar-active-indicator-right {

            right: auto;
            left: 0;

        }


        [dir="rtl"]
        .public-sidebar-item:hover
        .public-sidebar-item-icon {

            transform:
                translateX(2px);

        }


        [dir="rtl"]
        .sidebar-collapse-button svg {

            transform:
                rotate(180deg);

        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (min-width: 768px)
        and (max-width: 1023px) {

            .public-sidebar {

                top: 0;
                bottom: 0;

                height: 100vh;
                height: 100dvh;

                border-radius: 0;

                max-width: 88vw;

                width:
                    min(
                        var(--sidebar-width),
                        88vw
                    );

            }


            .public-sidebar-position-left {

                left: 0;

            }


            .public-sidebar-position-right {

                right: 0;

            }


            .public-sidebar-position-left:not(.sidebar-open) {

                transform:
                    translateX(-105%);

            }


            .public-sidebar-position-right:not(.sidebar-open) {

                transform:
                    translateX(105%);

            }


            .public-sidebar.sidebar-collapsed {

                width:
                    min(
                        var(--sidebar-width),
                        88vw
                    );

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-title,

            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-label,

            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-badge {

                display: initial;

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-item {

                justify-content: flex-start;

                padding-inline: 12px;

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-icon {

                flex-basis: 34px;

                width: 34px;
                height: 34px;

            }


            .sidebar-collapse-button {

                display: none !important;

            }


            .public-sidebar-inner {

                height: 100%;

                max-height: 100%;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 767px) {

            .public-sidebar {

                top: 0;
                bottom: 0;

                height: 100vh;
                height: 100dvh;

                border-radius: 0;

                max-width: 88vw;

                width:
                    min(
                        var(--sidebar-width),
                        88vw
                    );

            }


            .public-sidebar-position-left {

                left: 0;

            }


            .public-sidebar-position-right {

                right: 0;

            }


            .public-sidebar-position-left:not(.sidebar-open) {

                transform:
                    translateX(-105%);

            }


            .public-sidebar-position-right:not(.sidebar-open) {

                transform:
                    translateX(105%);

            }


            .public-sidebar.sidebar-collapsed {

                width:
                    min(
                        var(--sidebar-width),
                        88vw
                    );

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-title,

            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-label,

            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-badge {

                display: initial;

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-item {

                justify-content: flex-start;

                padding-inline: 12px;

            }


            .public-sidebar.sidebar-collapsed
            .public-sidebar-item-icon {

                flex-basis: 34px;

                width: 34px;
                height: 34px;

            }


            .sidebar-collapse-button {

                display: none !important;

            }


            .public-sidebar-inner {

                height: 100%;

                max-height: 100%;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | PRINT
        |--------------------------------------------------------------------------
        */

        @media print {

            @if ($sidebarHideOnPrint)

                .public-sidebar,
                .mobile-sidebar-toggle {

                    display: none !important;

                }

            @endif

        }

    </style>


    {{-- ================================================================
         SIDEBAR JAVASCRIPT
         ================================================================ --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const sidebar =
                    document.getElementById(
                        'public-sidebar'
                    );

                const toggle =
                    document.getElementById(
                        'mobile-sidebar-toggle'
                    );

                const collapseButton =
                    document.getElementById(
                        'sidebar-collapse-button'
                    );


                if (!sidebar || !toggle) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | CONFIGURATION
                |--------------------------------------------------------------------------
                */

                const rememberState =
                    @json($sidebarRememberState);

                const smoothScroll =
                    @json($sidebarSmoothScroll);


                const desktopBreakpoint =
                    1024;


                /*
                |--------------------------------------------------------------------------
                | LABELS
                |--------------------------------------------------------------------------
                */

                const openLabel =
                    toggle.getAttribute(
                        'data-open-label'
                    ) || 'Open sidebar';


                const closeLabel =
                    toggle.getAttribute(
                        'data-close-label'
                    ) || 'Close sidebar';


                /*
                |--------------------------------------------------------------------------
                | SIDEBAR STATE
                |--------------------------------------------------------------------------
                */

                function setSidebarState(
                    isOpen
                ) {

                    sidebar.classList.toggle(
                        'sidebar-open',
                        isOpen
                    );


                    toggle.classList.toggle(
                        'is-open',
                        isOpen
                    );


                    toggle.setAttribute(
                        'aria-expanded',
                        isOpen
                            ? 'true'
                            : 'false'
                    );


                    toggle.setAttribute(
                        'aria-label',
                        isOpen
                            ? closeLabel
                            : openLabel
                    );


                    if (collapseButton) {

                        collapseButton.setAttribute(
                            'aria-expanded',
                            isOpen
                                ? 'true'
                                : 'false'
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | INITIAL STATE
                |--------------------------------------------------------------------------
                |
                | Desktop:
                | Sidebar starts open.
                |
                | Tablet / Mobile:
                | Sidebar starts closed.
                |
                */

                if (
                    window.innerWidth
                    >= desktopBreakpoint
                ) {

                    setSidebarState(true);

                } else {

                    setSidebarState(false);

                }


                /*
                |--------------------------------------------------------------------------
                | HAMBURGER CLICK
                |--------------------------------------------------------------------------
                */

                toggle.addEventListener(
                    'click',
                    function () {

                        const isOpen =
                            sidebar.classList.contains(
                                'sidebar-open'
                            );


                        setSidebarState(
                            !isOpen
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | ESCAPE KEY
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape'
                            &&
                            sidebar.classList.contains(
                                'sidebar-open'
                            )
                        ) {

                            setSidebarState(false);

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | CLOSE SIDEBAR AFTER LINK CLICK
                |--------------------------------------------------------------------------
                |
                | Tablet + Mobile only.
                |
                */

                sidebar
                    .querySelectorAll('a')
                    .forEach(
                        function (link) {

                            link.addEventListener(
                                'click',
                                function () {

                                    if (
                                        window.innerWidth
                                        < desktopBreakpoint
                                    ) {

                                        setSidebarState(
                                            false
                                        );

                                    }

                                }
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | SMOOTH SCROLL
                |--------------------------------------------------------------------------
                */

                if (smoothScroll) {

                    sidebar
                        .querySelectorAll(
                            'a[href^="#"]'
                        )
                        .forEach(
                            function (link) {

                                link.addEventListener(
                                    'click',
                                    function (event) {

                                        const href =
                                            link.getAttribute(
                                                'href'
                                            );


                                        if (
                                            !href
                                            ||
                                            href === '#'
                                        ) {

                                            return;

                                        }


                                        let target = null;


                                        try {

                                            target =
                                                document.querySelector(
                                                    href
                                                );

                                        } catch (error) {

                                            return;

                                        }


                                        if (!target) {

                                            return;

                                        }


                                        event.preventDefault();


                                        target.scrollIntoView({
                                            behavior:
                                                'smooth',

                                            block:
                                                'start'
                                        });


                                    }
                                );

                            }
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | COLLAPSE STATE
                |--------------------------------------------------------------------------
                */

                if (collapseButton) {

                    const savedState =
                        rememberState
                            ? localStorage.getItem(
                                'public-sidebar-collapsed'
                            )
                            : null;


                    if (
                        savedState === 'true'
                    ) {

                        sidebar.classList.add(
                            'sidebar-collapsed'
                        );

                    }


                    collapseButton.addEventListener(
                        'click',
                        function () {

                            sidebar.classList.toggle(
                                'sidebar-collapsed'
                            );


                            if (
                                rememberState
                            ) {

                                localStorage.setItem(
                                    'public-sidebar-collapsed',
                                    sidebar.classList.contains(
                                        'sidebar-collapsed'
                                    )
                                        ? 'true'
                                        : 'false'
                                );

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | RESPONSIVE RESIZE
                |--------------------------------------------------------------------------
                */

                let previousWidth =
                    window.innerWidth;


                window.addEventListener(
                    'resize',
                    function () {

                        const currentWidth =
                            window.innerWidth;


                        /*
                        |--------------------------------------------------------------------------
                        | Crossing Desktop / Tablet Breakpoint
                        |--------------------------------------------------------------------------
                        */

                        if (
                            previousWidth
                            < desktopBreakpoint
                            &&
                            currentWidth
                            >= desktopBreakpoint
                        ) {

                            setSidebarState(true);

                        }


                        if (
                            previousWidth
                            >= desktopBreakpoint
                            &&
                            currentWidth
                            < desktopBreakpoint
                        ) {

                            setSidebarState(false);

                        }


                        previousWidth =
                            currentWidth;

                    }
                );

            }
        );

    </script>

@endif