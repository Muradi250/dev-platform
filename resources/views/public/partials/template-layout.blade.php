@php

 /*
| -------------------------------------------------------------------------- |
| TEMPLATE & RESPONSIVE LAYOUT ENGINE                                        |
| -------------------------------------------------------------------------- |
|                                                                            |
| This partial:                                                              |
|                                                                            |
| - Controls page template structure                                         |
| - Controls responsive container behavior                                   |
| - Controls responsive spacing                                              |
| - Controls responsive typography scale                                     |
| - Controls responsive alignment                                            |
| - Controls responsive breakpoints                                          |
| - Renders page blocks exactly once                                         |
|                                                                            |
| -------------------------------------------------------------------------- |
 */

 /*
| -------------------------------------------------------------------------- |
| PAGE TYPE                                                                  |
| -------------------------------------------------------------------------- |
 */

$pageType = data_get(
$pageSettings,
'settings.page.type',
data_get(
$pageSettings,
'page.type',
'default'
)
);

 /*
| -------------------------------------------------------------------------- |
| DESIGN STYLE                                                               |
| -------------------------------------------------------------------------- |
 */

$designStyle = data_get(
$pageSettings,
'settings.design.style',
data_get(
$pageSettings,
'design.style',
'professional'
)
);

 /*
| -------------------------------------------------------------------------- |
| LAYOUT MODE                                                                |
| -------------------------------------------------------------------------- |
 */

$layoutMode = data_get(
$pageSettings,
'settings.layout.mode',
data_get(
$pageSettings,
'layout.mode',
'standard'
)
);

 /*
| -------------------------------------------------------------------------- |
| GENERAL LAYOUT SETTINGS                                                    |
| -------------------------------------------------------------------------- |
 */

$containerEnabled = (bool) data_get(
$pageSettings,
'settings.layout.container.enabled',
data_get(
$pageSettings,
'layout.container.enabled',
true
)
);

$containerPadding = data_get(
$pageSettings,
'settings.layout.container.padding',
data_get(
$pageSettings,
'layout.container.padding',
'6'
)
);

$contentWidth = data_get(
$pageSettings,
'settings.layout.width.max_width',
data_get(
$pageSettings,
'layout.width.max_width',
'7xl'
)
);

$contentSpacing = data_get(
$pageSettings,
'settings.layout.spacing.content',
data_get(
$pageSettings,
'layout.spacing.content',
'8'
)
);

 /*
| -------------------------------------------------------------------------- |
| RESPONSIVE ENABLED SETTINGS                                                |
| -------------------------------------------------------------------------- |
 */

$mobileEnabled = (bool) data_get(
$pageSettings,
'settings.responsive.mobile',
data_get(
$pageSettings,
'responsive.mobile',
true
)
);

$tabletEnabled = (bool) data_get(
$pageSettings,
'settings.responsive.tablet',
data_get(
$pageSettings,
'responsive.tablet',
true
)
);

$desktopEnabled = (bool) data_get(
$pageSettings,
'settings.responsive.desktop',
data_get(
$pageSettings,
'responsive.desktop',
true
)
);

 /*
| -------------------------------------------------------------------------- |
| RESPONSIVE BREAKPOINTS                                                     |
| -------------------------------------------------------------------------- |
|                                                                            |
| These values are controlled from Page Settings.                            |
|                                                                            |
 */

$mobileMax = (int) data_get(
$pageSettings,
'settings.responsive.breakpoints.mobile_max',
data_get(
$pageSettings,
'responsive.breakpoints.mobile_max',
767
)
);

$tabletMin = (int) data_get(
$pageSettings,
'settings.responsive.breakpoints.tablet_min',
data_get(
$pageSettings,
'responsive.breakpoints.tablet_min',
768
)
);

$tabletMax = (int) data_get(
$pageSettings,
'settings.responsive.breakpoints.tablet_max',
data_get(
$pageSettings,
'responsive.breakpoints.tablet_max',
1023
)
);

$desktopMin = (int) data_get(
$pageSettings,
'settings.responsive.breakpoints.desktop_min',
data_get(
$pageSettings,
'responsive.breakpoints.desktop_min',
1024
)
);

 /*
| -------------------------------------------------------------------------- |
| MOBILE SETTINGS                                                            |
| -------------------------------------------------------------------------- |
 */

$mobileContainer = data_get(
$pageSettings,
'settings.responsive.mobile_container',
data_get(
$pageSettings,
'responsive.mobile_container',
'full'
)
);

$mobileHorizontalPadding = (int) data_get(
$pageSettings,
'settings.responsive.mobile_horizontal_padding',
data_get(
$pageSettings,
'responsive.mobile_horizontal_padding',
16
)
);

$mobileVerticalSpacing = (int) data_get(
$pageSettings,
'settings.responsive.mobile_vertical_spacing',
data_get(
$pageSettings,
'responsive.mobile_vertical_spacing',
16
)
);

$mobileFontScale = (float) data_get(
$pageSettings,
'settings.responsive.mobile_font_scale',
data_get(
$pageSettings,
'responsive.mobile_font_scale',
1
)
);

$mobileAlignment = data_get(
$pageSettings,
'settings.responsive.mobile_alignment',
data_get(
$pageSettings,
'responsive.mobile_alignment',
'auto'
)
);

 /*
| -------------------------------------------------------------------------- |
| TABLET SETTINGS                                                            |
| -------------------------------------------------------------------------- |
 */

$tabletContainer = data_get(
$pageSettings,
'settings.responsive.tablet_container',
data_get(
$pageSettings,
'responsive.tablet_container',
'contained'
)
);

$tabletHorizontalPadding = (int) data_get(
$pageSettings,
'settings.responsive.tablet_horizontal_padding',
data_get(
$pageSettings,
'responsive.tablet_horizontal_padding',
24
)
);

$tabletVerticalSpacing = (int) data_get(
$pageSettings,
'settings.responsive.tablet_vertical_spacing',
data_get(
$pageSettings,
'responsive.tablet_vertical_spacing',
24
)
);

$tabletFontScale = (float) data_get(
$pageSettings,
'settings.responsive.tablet_font_scale',
data_get(
$pageSettings,
'responsive.tablet_font_scale',
1
)
);

$tabletAlignment = data_get(
$pageSettings,
'settings.responsive.tablet_alignment',
data_get(
$pageSettings,
'responsive.tablet_alignment',
'auto'
)
);

/*
| -------------------------------------------------------------------------- |
| DESKTOP SETTINGS                                                           |
| -------------------------------------------------------------------------- |
 */

$desktopContainer = data_get(
$pageSettings,
'settings.responsive.desktop_container',
data_get(
$pageSettings,
'responsive.desktop_container',
'wide'
)
);

$desktopMaxWidth = (int) data_get(
$pageSettings,
'settings.responsive.desktop_max_width',
data_get(
$pageSettings,
'responsive.desktop_max_width',
1440
)
);

$desktopHorizontalPadding = (int) data_get(
$pageSettings,
'settings.responsive.desktop_horizontal_padding',
data_get(
$pageSettings,
'responsive.desktop_horizontal_padding',
32
)
);

$desktopVerticalSpacing = (int) data_get(
$pageSettings,
'settings.responsive.desktop_vertical_spacing',
data_get(
$pageSettings,
'responsive.desktop_vertical_spacing',
32
)
);

$desktopFontScale = (float) data_get(
$pageSettings,
'settings.responsive.desktop_font_scale',
data_get(
$pageSettings,
'responsive.desktop_font_scale',
1
)
);

$desktopAlignment = data_get(
$pageSettings,
'settings.responsive.desktop_alignment',
data_get(
$pageSettings,
'responsive.desktop_alignment',
'auto'
)
);

/*
| -------------------------------------------------------------------------- |
| SANITIZE RESPONSIVE VALUES                                                 |
| -------------------------------------------------------------------------- |
 */

$mobileMax = max(320, min(767, $mobileMax));

$tabletMin = max(
$mobileMax + 1,
min(1023, $tabletMin)
);

$tabletMax = max(
$tabletMin,
min(1439, $tabletMax)
);

$desktopMin = max(
$tabletMax + 1,
min(2560, $desktopMin)
);

$mobileHorizontalPadding = max(
0,
min(100, $mobileHorizontalPadding)
);

$tabletHorizontalPadding = max(
0,
min(150, $tabletHorizontalPadding)
);

$desktopHorizontalPadding = max(
0,
min(200, $desktopHorizontalPadding)
);

$mobileVerticalSpacing = max(
0,
min(200, $mobileVerticalSpacing)
);

$tabletVerticalSpacing = max(
0,
min(250, $tabletVerticalSpacing)
);

$desktopVerticalSpacing = max(
0,
min(300, $desktopVerticalSpacing)
);

$desktopMaxWidth = max(
800,
min(3000, $desktopMaxWidth)
);

 /*
| -------------------------------------------------------------------------- |
| WIDTH CLASSES                                                              |
| -------------------------------------------------------------------------- |
 */

$widthClasses = [


'sm' => 'max-w-sm',
'md' => 'max-w-md',
'lg' => 'max-w-lg',
'xl' => 'max-w-xl',
'2xl' => 'max-w-2xl',
'3xl' => 'max-w-3xl',
'4xl' => 'max-w-4xl',
'5xl' => 'max-w-5xl',
'6xl' => 'max-w-6xl',
'7xl' => 'max-w-7xl',
'full' => 'max-w-full',


];

$widthClass = $widthClasses[$contentWidth]
?? 'max-w-7xl';

 /*
| -------------------------------------------------------------------------- |
| HORIZONTAL PADDING CLASSES                                                 |
| -------------------------------------------------------------------------- |
 */

$paddingClasses = [


'0' => 'px-0',
'1' => 'px-1',
'2' => 'px-2',
'3' => 'px-3',
'4' => 'px-4',
'5' => 'px-5',
'6' => 'px-6',
'8' => 'px-8',
'10' => 'px-10',
'12' => 'px-12',


];

$paddingClass = $paddingClasses[$containerPadding]
?? 'px-6';

 /*
| -------------------------------------------------------------------------- |
| VERTICAL SPACING CLASSES                                                   |
| -------------------------------------------------------------------------- |
 */

$spacingClasses = [


'0' => 'py-0',
'1' => 'py-1',
'2' => 'py-2',
'3' => 'py-3',
'4' => 'py-4',
'5' => 'py-5',
'6' => 'py-6',
'8' => 'py-8',
'10' => 'py-10',
'12' => 'py-12',
'16' => 'py-16',


];

$spacingClass = $spacingClasses[$contentSpacing]
?? 'py-8';

 /*
| -------------------------------------------------------------------------- |
| LAYOUT CLASSES                                                             |
| -------------------------------------------------------------------------- |
 */

$layoutClasses = [


'standard' => 'w-full',
'wide' => 'w-full',
'full_width' => 'w-full',
'sidebar_left' => 'w-full',
'sidebar_right' => 'w-full',


];

$layoutClass = $layoutClasses[$layoutMode]
?? 'w-full';

 /*
| -------------------------------------------------------------------------- |
| DESIGN STYLE CLASSES                                                       |
| -------------------------------------------------------------------------- |
 */

$designClasses = [


'modern' => 'template-style-modern',
'professional' => 'template-style-professional',
'corporate' => 'template-style-corporate',
'saas' => 'template-style-saas',
'minimal' => 'template-style-minimal',
'creative' => 'template-style-creative',
'editorial' => 'template-style-editorial',


];

$designClass = $designClasses[$designStyle]
?? 'template-style-professional';
 /*
| -------------------------------------------------------------------------- |
| RESPONSIVE ALIGNMENT                                                       |
| -------------------------------------------------------------------------- |
 */

$alignmentMap = [


'left' => 'left',
'center' => 'center',
'right' => 'right',
'auto' => 'start',


];

$mobileAlignmentValue = $alignmentMap[$mobileAlignment]
?? 'start';

$tabletAlignmentValue = $alignmentMap[$tabletAlignment]
?? 'start';

$desktopAlignmentValue = $alignmentMap[$desktopAlignment]
?? 'start';

/*
| -------------------------------------------------------------------------- |
| RESPONSIVE CONTAINER WIDTHS                                                |
| -------------------------------------------------------------------------- |
|                                                                            |
| These values define the actual maximum width of the content wrapper.       |
|                                                                            |
 */

$mobileMaxContentWidth = match ($mobileContainer) {


'narrow' => '640px',

'contained' => '100%',

default => '100%',


};

$tabletMaxContentWidth = match ($tabletContainer) {


'narrow' => '768px',

'wide' => '1200px',

'contained' => '1024px',

default => '100%',


};

$desktopMaxContentWidthValue = match ($desktopContainer) {


'narrow' => '1024px',

'contained' => '1280px',

'wide' => $desktopMaxWidth . 'px',

'full' => '100%',

default => $desktopMaxWidth . 'px',


};

 /*
| -------------------------------------------------------------------------- |
| CONTENT WRAPPER                                                            |
| -------------------------------------------------------------------------- |
 */

$contentWrapperClasses = collect([


'w-full',

$containerEnabled
    ? 'mx-auto'
    : null,


])
->filter()
->implode(' ');

@endphp

{{-- =========================================================================
RESPONSIVE LAYOUT ENGINE
============================================================================= --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE ROOT VARIABLES
    |--------------------------------------------------------------------------
    */

    #page-content {

        --page-mobile-padding: {{ $mobileHorizontalPadding }}px;
        --page-tablet-padding: {{ $tabletHorizontalPadding }}px;
        --page-desktop-padding: {{ $desktopHorizontalPadding }}px;

        --page-mobile-spacing: {{ $mobileVerticalSpacing }}px;
        --page-tablet-spacing: {{ $tabletVerticalSpacing }}px;
        --page-desktop-spacing: {{ $desktopVerticalSpacing }}px;

        --page-mobile-font-scale: {{ $mobileFontScale }};
        --page-tablet-font-scale: {{ $tabletFontScale }};
        --page-desktop-font-scale: {{ $desktopFontScale }};

        --page-mobile-max-width: {{ $mobileMaxContentWidth }};
        --page-tablet-max-width: {{ $tabletMaxContentWidth }};
        --page-desktop-max-width: {{ $desktopMaxContentWidthValue }};

        --page-mobile-alignment: {{ $mobileAlignmentValue }};
        --page-tablet-alignment: {{ $tabletAlignmentValue }};
        --page-desktop-alignment: {{ $desktopAlignmentValue }};

        --page-current-padding: var(--page-desktop-padding);
        --page-current-spacing: var(--page-desktop-spacing);
        --page-current-font-scale: var(--page-desktop-font-scale);
        --page-current-max-width: var(--page-desktop-max-width);
        --page-current-alignment: var(--page-desktop-alignment);

    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE CONTENT WRAPPER
    |--------------------------------------------------------------------------
    */

    #page-content .page-responsive-wrapper {

        width: 100%;

        max-width: var(--page-current-max-width);

        margin-left: auto;
        margin-right: auto;

        padding-left: var(--page-current-padding);
        padding-right: var(--page-current-padding);

        padding-top: var(--page-current-spacing);
        padding-bottom: var(--page-current-spacing);

        font-size: calc(
            1rem * var(--page-current-font-scale)
        );

        text-align: var(--page-current-alignment);

        transition:
            max-width 180ms ease,
            padding 180ms ease,
            font-size 180ms ease;

    }


    /*
    |--------------------------------------------------------------------------
    | BLOCK SPACING
    |--------------------------------------------------------------------------
    */

    #page-content .page-responsive-block + .page-responsive-block {

        margin-top: var(--page-current-spacing);

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: {{ $mobileMax }}px) {

        #page-content {

            --page-current-padding: var(--page-mobile-padding);
            --page-current-spacing: var(--page-mobile-spacing);
            --page-current-font-scale: var(--page-mobile-font-scale);
            --page-current-max-width: var(--page-mobile-max-width);
            --page-current-alignment: var(--page-mobile-alignment);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | TABLET
    |--------------------------------------------------------------------------
    */

    @media (
        min-width: {{ $tabletMin }}px
    ) and (
        max-width: {{ $tabletMax }}px
    ) {

        #page-content {

            --page-current-padding: var(--page-tablet-padding);
            --page-current-spacing: var(--page-tablet-spacing);
            --page-current-font-scale: var(--page-tablet-font-scale);
            --page-current-max-width: var(--page-tablet-max-width);
            --page-current-alignment: var(--page-tablet-alignment);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | DESKTOP
    |--------------------------------------------------------------------------
    */

    @media (min-width: {{ $desktopMin }}px) {

        #page-content {

            --page-current-padding: var(--page-desktop-padding);
            --page-current-spacing: var(--page-desktop-spacing);
            --page-current-font-scale: var(--page-desktop-font-scale);
            --page-current-max-width: var(--page-desktop-max-width);
            --page-current-alignment: var(--page-desktop-alignment);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | DISABLE MOBILE
    |--------------------------------------------------------------------------
    */

    @if (! $mobileEnabled)

        @media (max-width: {{ $mobileMax }}px) {

            #page-content {

                display: none !important;

            }

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | DISABLE TABLET
    |--------------------------------------------------------------------------
    */

    @if (! $tabletEnabled)

        @media (
            min-width: {{ $tabletMin }}px
        ) and (
            max-width: {{ $tabletMax }}px
        ) {

            #page-content {

                display: none !important;

            }

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | DISABLE DESKTOP
    |--------------------------------------------------------------------------
    */

    @if (! $desktopEnabled)

        @media (min-width: {{ $desktopMin }}px) {

            #page-content {

                display: none !important;

            }

        }

    @endif

</style>

{{-- =========================================================================
TEMPLATE & LAYOUT
============================================================================= --}}

<main
    id="page-content"
    class="
        relative
        z-0
        w-full
        min-w-0
        {{ $layoutClass }}
        {{ $designClass }}
    "
    data-page-type="{{ $pageType }}"
    data-design-style="{{ $designStyle }}"
    data-layout-mode="{{ $layoutMode }}"
    data-responsive-mobile="{{ $mobileEnabled ? 'true' : 'false' }}"
    data-responsive-tablet="{{ $tabletEnabled ? 'true' : 'false' }}"
    data-responsive-desktop="{{ $desktopEnabled ? 'true' : 'false' }}"
>


{{-- =========================================================================
     CONTENT WRAPPER
============================================================================= --}}

<div
    class="{{ $contentWrapperClasses }} page-responsive-wrapper"
>


    {{-- =====================================================================
         PAGE BLOCKS
    ====================================================================== --}}

    @forelse ($blocks as $index => $block)

        @php

            /*
            |------------------------------------------------------------------
            | BLOCK VIEW
            |------------------------------------------------------------------
            */

            $blockType = is_object($block)
                ? ($block->type ?? null)
                : null;

            $view = filled($blockType)
                ? 'public.blocks.' . $blockType
                : null;


            /*
            |------------------------------------------------------------------
            | BLOCK DATA
            |------------------------------------------------------------------
            */

            $blockData = is_object($block)
                ? $block->data
                : [];

            if (is_string($blockData)) {

                $decodedBlockData = json_decode(
                    $blockData,
                    true
                );

                $blockData = is_array($decodedBlockData)
                    ? $decodedBlockData
                    : [];

            }

            $blockData = is_array($blockData)
                ? $blockData
                : [];


            /*
            |------------------------------------------------------------------
            | BLOCK SETTINGS
            |------------------------------------------------------------------
            */

            $blockSettings = is_object($block)
                ? $block->settings
                : [];

            if (is_string($blockSettings)) {

                $decodedBlockSettings = json_decode(
                    $blockSettings,
                    true
                );

                $blockSettings = is_array($decodedBlockSettings)
                    ? $decodedBlockSettings
                    : [];

            }

            $blockSettings = is_array($blockSettings)
                ? $blockSettings
                : [];


            /*
            |------------------------------------------------------------------
            | BLOCK ID
            |------------------------------------------------------------------
            */

            $blockId = 'block-' . (
                is_object($block)
                    ? ($block->id ?? $index)
                    : $index
            );

        @endphp


        {{-- =================================================================
             BLOCK
        ================================================================== --}}

        @if (
            filled($view) &&
            view()->exists($view)
        )

            <section
                id="{{ $blockId }}"
                class="
                    page-responsive-block
                    relative
                    scroll-mt-24
                "
                data-block-type="{{ $blockType }}"
                data-block-index="{{ $index }}"
            >

                @include($view, [
                    'block' => $block,
                    'data' => $blockData,
                    'settings' => $blockSettings,
                    'page' => $page,
                    'pageSettings' => $pageSettings,
                ])

            </section>

        @endif


    @empty

        {{-- ================================================================
             EMPTY PAGE
        ================================================================= --}}

        <section
            class="
                page-responsive-block
                flex
                min-h-[60vh]
                items-center
                justify-center
            "
        >

            <div
                class="
                    mx-auto
                    max-w-2xl
                "
            >

                <div
                    class="
                        mb-6
                        text-5xl
                        text-slate-300
                        dark:text-slate-600
                    "
                    aria-hidden="true"
                >

                    <i class="fa-regular fa-file-lines"></i>

                </div>


                <h1
                    class="
                        text-2xl
                        font-bold
                        text-slate-800
                        dark:text-white
                    "
                >

                    {{ $page->title }}

                </h1>


                <p
                    class="
                        mt-3
                        text-slate-500
                        dark:text-slate-400
                    "
                >

                    This page has no content yet.

                </p>

            </div>

        </section>

    @endforelse


</div>


</main>
