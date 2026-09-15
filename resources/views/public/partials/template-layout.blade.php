@php

/*
|--------------------------------------------------------------------------
| TEMPLATE & LAYOUT SETTINGS
|--------------------------------------------------------------------------
|
| This partial controls the page structure and renders all page blocks.
| Block rendering exists only once in this file.
|
*/


/*
|--------------------------------------------------------------------------
| PAGE TYPE
|--------------------------------------------------------------------------
*/

$pageType = data_get(
    $pageSettings,
    'page.type',
    'default'
);


/*
|--------------------------------------------------------------------------
| DESIGN STYLE
|--------------------------------------------------------------------------
*/

$designStyle = data_get(
    $pageSettings,
    'design.style',
    'professional'
);


/*
|--------------------------------------------------------------------------
| LAYOUT MODE
|--------------------------------------------------------------------------
*/

$layoutMode = data_get(
    $pageSettings,
    'layout.mode',
    'standard'
);


/*
|--------------------------------------------------------------------------
| CONTAINER
|--------------------------------------------------------------------------
*/

$containerEnabled = data_get(
    $pageSettings,
    'layout.container.enabled',
    true
);

$containerPadding = data_get(
    $pageSettings,
    'layout.container.padding',
    '6'
);


/*
|--------------------------------------------------------------------------
| CONTENT WIDTH
|--------------------------------------------------------------------------
*/

$contentWidth = data_get(
    $pageSettings,
    'layout.width.max_width',
    '7xl'
);


/*
|--------------------------------------------------------------------------
| CONTENT SPACING
|--------------------------------------------------------------------------
*/

$contentSpacing = data_get(
    $pageSettings,
    'layout.spacing.content',
    '8'
);


/*
|--------------------------------------------------------------------------
| WIDTH CLASSES
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| HORIZONTAL PADDING CLASSES
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| VERTICAL SPACING CLASSES
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| LAYOUT CLASSES
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| DESIGN STYLE CLASSES
|--------------------------------------------------------------------------
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
|--------------------------------------------------------------------------
| CONTENT WRAPPER
|--------------------------------------------------------------------------
|
| The container settings only control the wrapper around the blocks.
| The blocks themselves are rendered once below.
|
*/

$contentWrapperClasses = collect([

    'w-full',

    $spacingClass,

    $containerEnabled
        ? 'mx-auto ' . $widthClass . ' ' . $paddingClass
        : null,

])
    ->filter()
    ->implode(' ');

@endphp


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
>


    {{-- =========================================================================
         CONTENT WRAPPER
    ============================================================================= --}}

    <div
        class="{{ $contentWrapperClasses }}"
    >


        {{-- =====================================================================
             PAGE BLOCKS
        ====================================================================== --}}

        @forelse ($blocks as $index => $block)

            @php

                /*
                |--------------------------------------------------------------------------
                | BLOCK VIEW
                |--------------------------------------------------------------------------
                */

                $blockType = is_object($block)
                    ? ($block->type ?? null)
                    : null;

                $view = filled($blockType)
                    ? 'public.blocks.' . $blockType
                    : null;


                /*
                |--------------------------------------------------------------------------
                | BLOCK DATA
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | BLOCK SETTINGS
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | BLOCK ID
                |--------------------------------------------------------------------------
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
                        relative
                        scroll-mt-24
                    "
                    data-block-type="{{ $blockType }}"
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
                    flex
                    min-h-[60vh]
                    items-center
                    justify-center
                    px-6
                "
            >

                <div
                    class="
                        mx-auto
                        max-w-2xl
                        text-center
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