@php

    /*
    |--------------------------------------------------------------------------
    | PAGE SETTINGS
    |--------------------------------------------------------------------------
    */

    $themeSettings = data_get(
        $pageSettings ?? [],
        'settings.theme',
        data_get(
            $pageSettings ?? [],
            'theme',
            []
        )
    );


    /*
    |--------------------------------------------------------------------------
    | THEME MODE
    |--------------------------------------------------------------------------
    */

    $themeMode = data_get(
        $themeSettings,
        'mode',
        'light'
    );


    /*
    |--------------------------------------------------------------------------
    | COLORS
    |--------------------------------------------------------------------------
    */

    $primaryColor = data_get(
        $themeSettings,
        'colors.primary',
        '#4f46e5'
    );

    $secondaryColor = data_get(
        $themeSettings,
        'colors.secondary',
        '#6366f1'
    );

    $accentColor = data_get(
        $themeSettings,
        'colors.accent',
        '#8b5cf6'
    );

    $successColor = data_get(
        $themeSettings,
        'colors.success',
        '#16a34a'
    );

    $warningColor = data_get(
        $themeSettings,
        'colors.warning',
        '#d97706'
    );

    $dangerColor = data_get(
        $themeSettings,
        'colors.danger',
        '#dc2626'
    );

    $infoColor = data_get(
        $themeSettings,
        'colors.info',
        '#0284c7'
    );


    /*
    |--------------------------------------------------------------------------
    | BACKGROUNDS
    |--------------------------------------------------------------------------
    */

    $pageBackground = data_get(
        $themeSettings,
        'backgrounds.page',
        '#f8fafc'
    );

    $contentBackground = data_get(
        $themeSettings,
        'backgrounds.content',
        '#ffffff'
    );

    $surfaceBackground = data_get(
        $themeSettings,
        'backgrounds.surface',
        '#ffffff'
    );

    $headerBackground = data_get(
        $themeSettings,
        'backgrounds.header',
        '#ffffff'
    );

    $footerBackground = data_get(
        $themeSettings,
        'backgrounds.footer',
        '#0f172a'
    );


    /*
    |--------------------------------------------------------------------------
    | TYPOGRAPHY
    |--------------------------------------------------------------------------
    */

    $fontFamily = data_get(
        $themeSettings,
        'typography.font_family'
    );

    $headingFont = data_get(
        $themeSettings,
        'typography.heading_font'
    );

    $baseFontSize = data_get(
        $themeSettings,
        'typography.base_font_size',
        '16px'
    );

    $bodyWeight = data_get(
        $themeSettings,
        'typography.body_weight',
        '400'
    );

    $lineHeight = data_get(
        $themeSettings,
        'typography.line_height',
        '1.625'
    );

    $letterSpacing = data_get(
        $themeSettings,
        'typography.letter_spacing',
        '0'
    );

    $headingWeight = data_get(
        $themeSettings,
        'typography.heading_weight',
        '700'
    );

    $headingLineHeight = data_get(
        $themeSettings,
        'typography.heading_line_height',
        '1.2'
    );

    $headingLetterSpacing = data_get(
        $themeSettings,
        'typography.heading_letter_spacing',
        '-0.025em'
    );


    /*
    |--------------------------------------------------------------------------
    | BORDERS
    |--------------------------------------------------------------------------
    */

    $borderColor = data_get(
        $themeSettings,
        'borders.color',
        '#e2e8f0'
    );

    $borderWidth = data_get(
        $themeSettings,
        'borders.width',
        '1px'
    );

    $borderRadius = data_get(
        $themeSettings,
        'borders.radius',
        '0.5rem'
    );

    $cardRadius = data_get(
        $themeSettings,
        'borders.card_radius',
        '0.75rem'
    );

    $buttonRadius = data_get(
        $themeSettings,
        'borders.button_radius',
        '0.5rem'
    );

    $inputRadius = data_get(
        $themeSettings,
        'borders.input_radius',
        '0.5rem'
    );


    /*
    |--------------------------------------------------------------------------
    | SHADOWS
    |--------------------------------------------------------------------------
    */

    $shadowDefault = data_get(
        $themeSettings,
        'shadows.default',
        'md'
    );

    $shadowCard = data_get(
        $themeSettings,
        'shadows.card',
        'sm'
    );

    $shadowButton = data_get(
        $themeSettings,
        'shadows.button',
        'none'
    );

    $shadowDropdown = data_get(
        $themeSettings,
        'shadows.dropdown',
        'lg'
    );

    $shadowModal = data_get(
        $themeSettings,
        'shadows.modal',
        '2xl'
    );

    $shadowHeader = data_get(
        $themeSettings,
        'shadows.header',
        'sm'
    );

    $shadowFooter = data_get(
        $themeSettings,
        'shadows.footer',
        'none'
    );

    $shadowSidebar = data_get(
        $themeSettings,
        'shadows.sidebar',
        'md'
    );


    /*
    |--------------------------------------------------------------------------
    | SHADOW PRESETS
    |--------------------------------------------------------------------------
    */

    $shadowPresets = [

        'none' => 'none',

        'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',

        'md' => '0 4px 6px -1px rgb(0 0 0 / 0.10), 0 2px 4px -2px rgb(0 0 0 / 0.10)',

        'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.10), 0 4px 6px -4px rgb(0 0 0 / 0.10)',

        'xl' => '0 20px 25px -5px rgb(0 0 0 / 0.10), 0 8px 10px -6px rgb(0 0 0 / 0.10)',

        '2xl' => '0 25px 50px -12px rgb(0 0 0 / 0.25)',

    ];


    /*
    |--------------------------------------------------------------------------
    | RESOLVE SHADOW VALUES
    |--------------------------------------------------------------------------
    */

    $defaultShadowValue = $shadowPresets[$shadowDefault]
        ?? $shadowPresets['md'];

    $cardShadowValue = $shadowPresets[$shadowCard]
        ?? $shadowPresets['sm'];

    $buttonShadowValue = $shadowPresets[$shadowButton]
        ?? $shadowPresets['none'];

    $dropdownShadowValue = $shadowPresets[$shadowDropdown]
        ?? $shadowPresets['lg'];

    $modalShadowValue = $shadowPresets[$shadowModal]
        ?? $shadowPresets['2xl'];

    $headerShadowValue = $shadowPresets[$shadowHeader]
        ?? $shadowPresets['sm'];

    $footerShadowValue = $shadowPresets[$shadowFooter]
        ?? $shadowPresets['none'];

    $sidebarShadowValue = $shadowPresets[$shadowSidebar]
        ?? $shadowPresets['md'];

@endphp


<style>

    /*
    |--------------------------------------------------------------------------
    | THEME ROOT
    |--------------------------------------------------------------------------
    */

    :root {

        /*
        |----------------------------------------------------------------------
        | Mode
        |----------------------------------------------------------------------
        */

        --page-theme-mode: {{ $themeMode }};


        /*
        |----------------------------------------------------------------------
        | Brand Colors
        |----------------------------------------------------------------------
        */

        --page-primary-color: {{ $primaryColor }};
        --page-secondary-color: {{ $secondaryColor }};
        --page-accent-color: {{ $accentColor }};


        /*
        |----------------------------------------------------------------------
        | Semantic Colors
        |----------------------------------------------------------------------
        */

        --page-success-color: {{ $successColor }};
        --page-warning-color: {{ $warningColor }};
        --page-danger-color: {{ $dangerColor }};
        --page-info-color: {{ $infoColor }};


        /*
        |----------------------------------------------------------------------
        | Backgrounds
        |----------------------------------------------------------------------
        */

        --page-background: {{ $pageBackground }};
        --page-content-background: {{ $contentBackground }};
        --page-surface-background: {{ $surfaceBackground }};
        --page-header-background: {{ $headerBackground }};
        --page-footer-background: {{ $footerBackground }};


        /*
        |----------------------------------------------------------------------
        | Typography
        |----------------------------------------------------------------------
        */

        --page-font-family:
            {{ filled($fontFamily) ? '"' . $fontFamily . '"' : 'inherit' }};

        --page-heading-font-family:
            {{ filled($headingFont) ? '"' . $headingFont . '"' : 'var(--page-font-family)' }};

        --page-base-font-size: {{ $baseFontSize }};
        --page-body-weight: {{ $bodyWeight }};
        --page-line-height: {{ $lineHeight }};
        --page-letter-spacing: {{ $letterSpacing }};

        --page-heading-weight: {{ $headingWeight }};
        --page-heading-line-height: {{ $headingLineHeight }};
        --page-heading-letter-spacing: {{ $headingLetterSpacing }};


        /*
        |----------------------------------------------------------------------
        | Borders
        |----------------------------------------------------------------------
        */

        --page-border-color: {{ $borderColor }};
        --page-border-width: {{ $borderWidth }};

        --page-border-radius: {{ $borderRadius }};
        --page-card-radius: {{ $cardRadius }};
        --page-button-radius: {{ $buttonRadius }};
        --page-input-radius: {{ $inputRadius }};


        /*
        |----------------------------------------------------------------------
        | Shadows
        |----------------------------------------------------------------------
        */

        --page-shadow-default: {{ $defaultShadowValue }};
        --page-shadow-card: {{ $cardShadowValue }};
        --page-shadow-button: {{ $buttonShadowValue }};
        --page-shadow-dropdown: {{ $dropdownShadowValue }};
        --page-shadow-modal: {{ $modalShadowValue }};
        --page-shadow-header: {{ $headerShadowValue }};
        --page-shadow-footer: {{ $footerShadowValue }};
        --page-shadow-sidebar: {{ $sidebarShadowValue }};

    }


    /*
    |--------------------------------------------------------------------------
    | PUBLIC PAGE BASE
    |--------------------------------------------------------------------------
    */

    body {

        background-color: var(--page-background);

        font-size: var(--page-base-font-size);

        font-weight: var(--page-body-weight);

        line-height: var(--page-line-height);

        letter-spacing: var(--page-letter-spacing);

        @if (filled($fontFamily))
            font-family: var(--page-font-family), sans-serif;
        @endif

    }


    /*
    |--------------------------------------------------------------------------
    | HEADINGS
    |--------------------------------------------------------------------------
    */

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {

        @if (filled($headingFont))
            font-family: var(--page-heading-font-family), sans-serif;
        @endif

        font-weight: var(--page-heading-weight);

        line-height: var(--page-heading-line-height);

        letter-spacing: var(--page-heading-letter-spacing);

    }


    /*
    |--------------------------------------------------------------------------
    | BRAND COLORS
    |--------------------------------------------------------------------------
    */

    .page-primary-bg {
        background-color: var(--page-primary-color);
    }

    .page-primary-text {
        color: var(--page-primary-color);
    }

    .page-primary-border {
        border-color: var(--page-primary-color);
    }


    .page-secondary-bg {
        background-color: var(--page-secondary-color);
    }

    .page-secondary-text {
        color: var(--page-secondary-color);
    }

    .page-secondary-border {
        border-color: var(--page-secondary-color);
    }


    .page-accent-bg {
        background-color: var(--page-accent-color);
    }

    .page-accent-text {
        color: var(--page-accent-color);
    }

    .page-accent-border {
        border-color: var(--page-accent-color);
    }


    /*
    |--------------------------------------------------------------------------
    | SEMANTIC COLORS
    |--------------------------------------------------------------------------
    */

    .page-success-bg {
        background-color: var(--page-success-color);
    }

    .page-success-text {
        color: var(--page-success-color);
    }

    .page-success-border {
        border-color: var(--page-success-color);
    }


    .page-warning-bg {
        background-color: var(--page-warning-color);
    }

    .page-warning-text {
        color: var(--page-warning-color);
    }

    .page-warning-border {
        border-color: var(--page-warning-color);
    }


    .page-danger-bg {
        background-color: var(--page-danger-color);
    }

    .page-danger-text {
        color: var(--page-danger-color);
    }

    .page-danger-border {
        border-color: var(--page-danger-color);
    }


    .page-info-bg {
        background-color: var(--page-info-color);
    }

    .page-info-text {
        color: var(--page-info-color);
    }

    .page-info-border {
        border-color: var(--page-info-color);
    }


    /*
    |--------------------------------------------------------------------------
    | SURFACES
    |--------------------------------------------------------------------------
    */

    .page-content-area {
        background-color: var(--page-content-background);
    }

    .page-surface {
        background-color: var(--page-surface-background);
    }

    .page-header-background {
        background-color: var(--page-header-background);
    }

    .page-footer-background {
        background-color: var(--page-footer-background);
    }


    /*
    |--------------------------------------------------------------------------
    | BORDER SYSTEM
    |--------------------------------------------------------------------------
    */

    .page-border {

        border-width: var(--page-border-width);

        border-style: solid;

        border-color: var(--page-border-color);

    }

    .page-radius {
        border-radius: var(--page-border-radius);
    }

    .page-card-radius {
        border-radius: var(--page-card-radius);
    }

    .page-button-radius {
        border-radius: var(--page-button-radius);
    }

    .page-input-radius {
        border-radius: var(--page-input-radius);
    }


    /*
    |--------------------------------------------------------------------------
    | SHADOW SYSTEM
    |--------------------------------------------------------------------------
    */

    .page-shadow {
        box-shadow: var(--page-shadow-default);
    }

    .page-card-shadow {
        box-shadow: var(--page-shadow-card);
    }

    .page-button-shadow {
        box-shadow: var(--page-shadow-button);
    }

    .page-dropdown-shadow {
        box-shadow: var(--page-shadow-dropdown);
    }

    .page-modal-shadow {
        box-shadow: var(--page-shadow-modal);
    }

    .page-header-shadow {
        box-shadow: var(--page-shadow-header);
    }

    .page-footer-shadow {
        box-shadow: var(--page-shadow-footer);
    }

    .page-sidebar-shadow {
        box-shadow: var(--page-shadow-sidebar);
    }


    /*
    |--------------------------------------------------------------------------
    | AUTO MODE
    |--------------------------------------------------------------------------
    */

    @if ($themeMode === 'auto')

        @media (prefers-color-scheme: dark) {

            :root {

                --page-background: #020617;

                --page-content-background: #0f172a;

                --page-surface-background: #1e293b;

                --page-header-background: #0f172a;

                --page-footer-background: #020617;

            }

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | DARK MODE
    |--------------------------------------------------------------------------
    */

    @if ($themeMode === 'dark')

        :root {

            --page-background: #020617;

            --page-content-background: #0f172a;

            --page-surface-background: #1e293b;

            --page-header-background: #0f172a;

            --page-footer-background: #020617;

        }

    @endif

</style>