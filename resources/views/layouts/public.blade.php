<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'ps']) ? 'rtl' : 'ltr' }}"
>
<head>

{{-- BASIC META --}}

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>


{{-- PAGE BUILDER SETTINGS --}}

@php

    $rawPageSettings = $settings ?? null;

    if (
        ! is_array($rawPageSettings) &&
        isset($page) &&
        is_object($page)
    ) {
        $rawPageSettings = $page->settings ?? null;
    }

    if (is_string($rawPageSettings)) {

        $decodedSettings = json_decode(
            $rawPageSettings,
            true
        );

        $rawPageSettings = is_array($decodedSettings)
            ? $decodedSettings
            : [];

    }

    $pageSettings = is_array($rawPageSettings)
        ? $rawPageSettings
        : [];


    /*
    |--------------------------------------------------------------------------
    | GENERAL
    |--------------------------------------------------------------------------
    */

    $pageTitle = data_get(
        $pageSettings,
        'settings.general.title',
        data_get(
            $pageSettings,
            'general.title',
            $page->title ?? 'Dev-Platform'
        )
    );

    $author = data_get(
        $pageSettings,
        'settings.general.author',
        data_get(
            $pageSettings,
            'general.author',
            'Dev-Platform'
        )
    );

    $favicon = data_get(
        $pageSettings,
        'settings.general.favicon',
        data_get(
            $pageSettings,
            'general.favicon',
            null
        )
    );


    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    */

    $metaDescription = data_get(
        $pageSettings,
        'settings.seo.meta.description',
        data_get(
            $pageSettings,
            'seo.meta.description',
            data_get(
                $pageSettings,
                'seo.description',
                'Dev-Platform Digital Organization Management Platform'
            )
        )
    );

    $metaKeywords = data_get(
        $pageSettings,
        'settings.seo.meta.keywords',
        data_get(
            $pageSettings,
            'seo.meta.keywords',
            data_get(
                $pageSettings,
                'seo.keywords',
                'Laravel, ERP, HR, Finance, Accounting, Digital Platform'
            )
        )
    );

    $robots = data_get(
        $pageSettings,
        'settings.seo.robots.value',
        data_get(
            $pageSettings,
            'seo.robots.value',
            data_get(
                $pageSettings,
                'seo.robots',
                'index, follow'
            )
        )
    );

    $canonicalUrl = data_get(
        $pageSettings,
        'settings.seo.meta.canonical_url',
        data_get(
            $pageSettings,
            'seo.meta.canonical_url',
            data_get(
                $pageSettings,
                'seo.canonical_url',
                url()->current()
            )
        )
    );


    /*
    |--------------------------------------------------------------------------
    | OPEN GRAPH
    |--------------------------------------------------------------------------
    */

    $ogTitle = data_get(
        $pageSettings,
        'settings.seo.open_graph.title',
        data_get(
            $pageSettings,
            'seo.open_graph.title',
            $page->title ?? $pageTitle
        )
    );

    $ogDescription = data_get(
        $pageSettings,
        'settings.seo.open_graph.description',
        data_get(
            $pageSettings,
            'seo.open_graph.description',
            $metaDescription
        )
    );

    $ogImage = data_get(
        $pageSettings,
        'settings.seo.open_graph.image',
        data_get(
            $pageSettings,
            'seo.open_graph.image',
            null
        )
    );

    $ogType = data_get(
        $pageSettings,
        'settings.seo.open_graph.type',
        data_get(
            $pageSettings,
            'seo.open_graph.type',
            'website'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | THEME META CONTEXT
    |--------------------------------------------------------------------------
    |
    | Theme rendering itself is handled by:
    |
    | public.partials.theme
    |
    | Only the values required by this global layout remain here.
    |
    */

    $themeMode = data_get(
        $pageSettings,
        'settings.theme.mode',
        data_get(
            $pageSettings,
            'theme.mode',
            'light'
        )
    );

    $primaryColor = data_get(
        $pageSettings,
        'settings.theme.colors.primary',
        data_get(
            $pageSettings,
            'theme.colors.primary',
            data_get(
                $pageSettings,
                'theme.primary_color',
                '#4f46e5'
            )
        )
    );


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    $responsiveEnabled = (bool) data_get(
        $pageSettings,
        'settings.responsive.enabled',
        data_get(
            $pageSettings,
            'responsive.enabled',
            true
        )
    );

    $mobileEnabled = (bool) data_get(
        $pageSettings,
        'settings.responsive.mobile.enabled',
        data_get(
            $pageSettings,
            'responsive.mobile.enabled',
            true
        )
    );

    $tabletEnabled = (bool) data_get(
        $pageSettings,
        'settings.responsive.tablet.enabled',
        data_get(
            $pageSettings,
            'responsive.tablet.enabled',
            true
        )
    );

    $desktopEnabled = (bool) data_get(
        $pageSettings,
        'settings.responsive.desktop.enabled',
        data_get(
            $pageSettings,
            'responsive.desktop.enabled',
            true
        )
    );


    /*
    |--------------------------------------------------------------------------
    | LAYOUT
    |--------------------------------------------------------------------------
    |
    | مهم:
    |
    | Layout اختصاصی صفحه در:
    |
    | public.partials.template-layout
    |
    | کنترل می‌شود.
    |
    | این Layout عمومی دیگر container / width / padding / spacing
    | مربوط به محتوای صفحه را اعمال نمی‌کند.
    |
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

    $containerWidth = data_get(
        $pageSettings,
        'settings.layout.width.max_width',
        data_get(
            $pageSettings,
            'layout.width.max_width',
            data_get(
                $pageSettings,
                'layout.container.max_width',
                '7xl'
            )
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

    $layoutSpacing = data_get(
        $pageSettings,
        'settings.layout.spacing.content',
        data_get(
            $pageSettings,
            'layout.spacing.content',
            '6'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    $headerEnabled = (bool) data_get(
        $pageSettings,
        'settings.header.visibility.enabled',
        data_get(
            $pageSettings,
            'header.visibility.enabled',
            data_get(
                $pageSettings,
                'header.enabled',
                true
            )
        )
    );

    $headerSticky = (bool) data_get(
        $pageSettings,
        'settings.header.behavior.sticky',
        data_get(
            $pageSettings,
            'header.behavior.sticky',
            data_get(
                $pageSettings,
                'header.sticky',
                false
            )
        )
    );


    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    $announcementEnabled = (bool) data_get(
        $pageSettings,
        'settings.navigation.announcement.enabled',
        data_get(
            $pageSettings,
            'navigation.announcement.enabled',
            false
        )
    );

    $announcementText = data_get(
        $pageSettings,
        'settings.navigation.announcement.text',
        data_get(
            $pageSettings,
            'navigation.announcement.text',
            'Build smarter. Manage everything in one place.'
        )
    );

    $secondaryNavigationEnabled = (bool) data_get(
        $pageSettings,
        'settings.navigation.secondary.enabled',
        data_get(
            $pageSettings,
            'navigation.secondary.enabled',
            false
        )
    );

    $secondaryNavigationTitle = data_get(
        $pageSettings,
        'settings.navigation.secondary.title',
        data_get(
            $pageSettings,
            'navigation.secondary.title',
            ''
        )
    );

    $breadcrumbEnabled = (bool) data_get(
        $pageSettings,
        'settings.navigation.breadcrumb.enabled',
        data_get(
            $pageSettings,
            'navigation.breadcrumb.enabled',
            true
        )
    );


    /*
    |--------------------------------------------------------------------------
    | INFORMATION BAR
    |--------------------------------------------------------------------------
    */

    $informationBarEnabled = (bool) data_get(
        $pageSettings,
        'settings.navigation.information_bar.enabled',
        data_get(
            $pageSettings,
            'navigation.information_bar.enabled',
            false
        )
    );

    $informationBarText = data_get(
        $pageSettings,
        'settings.navigation.information_bar.text',
        data_get(
            $pageSettings,
            'navigation.information_bar.text',
            ''
        )
    );


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    |
    | مهم:
    |
    | این Layout هیچ فضای Layout برای Sidebar رزرو نمی‌کند.
    |
    | Sidebar به صورت مستقل توسط:
    |
    | public.partials.sidebar
    |
    | رندر می‌شود و خودش مسئول Drawer در تمام دستگاه‌ها است.
    |
    */

    $sidebarEnabled = (bool) data_get(
        $pageSettings,
        'settings.sidebar.enabled',
        data_get(
            $pageSettings,
            'sidebar.enabled',
            false
        )
    );

    $sidebarPosition = data_get(
        $pageSettings,
        'settings.sidebar.position',
        data_get(
            $pageSettings,
            'sidebar.position',
            'right'
        )
    );

    $sidebarPosition = in_array(
        $sidebarPosition,
        ['left', 'right'],
        true
    )
        ? $sidebarPosition
        : 'right';


    /*
    |--------------------------------------------------------------------------
    | FOOTER
    |--------------------------------------------------------------------------
    */

    $footerEnabled = (bool) data_get(
        $pageSettings,
        'settings.footer.enabled',
        data_get(
            $pageSettings,
            'footer.enabled',
            true
        )
    );

    $footerDesktop = (bool) data_get(
        $pageSettings,
        'settings.footer.visibility.desktop',
        data_get(
            $pageSettings,
            'footer.visibility.desktop',
            true
        )
    );

    $footerTablet = (bool) data_get(
        $pageSettings,
        'settings.footer.visibility.tablet',
        data_get(
            $pageSettings,
            'footer.visibility.tablet',
            true
        )
    );

    $footerMobile = (bool) data_get(
        $pageSettings,
        'settings.footer.visibility.mobile',
        data_get(
            $pageSettings,
            'footer.visibility.mobile',
            true
        )
    );

    $footerHomepage = (bool) data_get(
        $pageSettings,
        'settings.footer.visibility.homepage',
        data_get(
            $pageSettings,
            'footer.visibility.homepage',
            true
        )
    );

    $footerInnerPages = (bool) data_get(
        $pageSettings,
        'settings.footer.visibility.inner_pages',
        data_get(
            $pageSettings,
            'footer.visibility.inner_pages',
            true
        )
    );


    /*
    |--------------------------------------------------------------------------
    | ACCESS
    |--------------------------------------------------------------------------
    */

    $pageVisible = (bool) data_get(
        $pageSettings,
        'settings.access.visibility.enabled',
        data_get(
            $pageSettings,
            'access.visibility.enabled',
            true
        )
    );


    /*
    |--------------------------------------------------------------------------
    | ROUTE CONTEXT
    |--------------------------------------------------------------------------
    */

    $isHomepage = request()->routeIs('public.home');

    $isInnerPage = request()->routeIs('public.page');

@endphp


{{-- SEO --}}

<title>
    @yield('title', $pageTitle)
</title>

<meta
    name="description"
    content="@yield('description', $metaDescription)"
>

<meta
    name="keywords"
    content="@yield('keywords', $metaKeywords)"
>

<meta
    name="author"
    content="{{ $author }}"
>

<meta
    name="robots"
    content="@yield('robots', $robots)"
>


{{-- OPEN GRAPH --}}

<meta
    property="og:title"
    content="{{ $ogTitle }}"
>

<meta
    property="og:description"
    content="{{ $ogDescription }}"
>

<meta
    property="og:type"
    content="{{ $ogType }}"
>

<meta
    property="og:url"
    content="{{ $canonicalUrl }}"
>

@if (filled($ogImage))

    <meta
        property="og:image"
        content="{{ $ogImage }}"
    >

@endif


{{-- CANONICAL --}}

@if (filled($canonicalUrl))

    <link
        rel="canonical"
        href="{{ $canonicalUrl }}"
    >

@endif


{{-- THEME META --}}

<meta
    name="theme-color"
    content="{{ $primaryColor }}"
>

<meta
    name="color-scheme"
    content="{{ $themeMode === 'auto' ? 'light dark' : $themeMode }}"
>


{{-- FAVICON --}}

@if (filled($favicon))

    <link
        rel="icon"
        href="{{ $favicon }}"
    >

@endif


{{-- FONT AWESOME --}}

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
>


{{-- VITE --}}

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])


{{-- PUBLIC THEME SYSTEM --}}

@include(
    'public.partials.theme',
    [
        'pageSettings' => $pageSettings,
    ]
)


{{-- GLOBAL LAYOUT STYLES --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | GLOBAL RESPONSIVE CONTROL
    |--------------------------------------------------------------------------
    */

    @if (! $responsiveEnabled)

        body {
            min-width: 1024px;
        }

    @endif


    @if (! $mobileEnabled)

        @media (max-width: 767px) {

            body {
                display: none;
            }

        }

    @endif


    @if (! $tabletEnabled)

        @media (min-width: 768px) and (max-width: 1023px) {

            body {
                display: none;
            }

        }

    @endif


    @if (! $desktopEnabled)

        @media (min-width: 1024px) {

            body {
                display: none;
            }

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | HEADER STICKY
    |--------------------------------------------------------------------------
    */

    @if ($headerSticky)

        .page-header-sticky {

            position: sticky;
            top: 0;
            z-index: 50;

        }

    @endif


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    |
    | هیچ Sidebar Layout Host در این فایل وجود ندارد.
    |
    | Sidebar به صورت Drawer مستقل داخل DOM قرار می‌گیرد.
    |
    */

</style>


@stack('styles')

</head>


<body
    class="
        min-h-screen
        antialiased
    "
>


@if (! $pageVisible)

    <main
        class="
            flex
            min-h-screen
            items-center
            justify-center
            px-6
        "
    >

        <div class="max-w-xl text-center">

            <div
                class="
                    mb-5
                    text-5xl
                    text-slate-300
                "
            >

                <i class="fa-solid fa-lock"></i>

            </div>


            <h1 class="text-2xl font-bold">

                Page unavailable

            </h1>


            <p class="mt-3 text-slate-500">

                This page is currently unavailable.

            </p>

        </div>

    </main>

@else


{{-- GLOBAL BACKGROUND --}}

<div
    class="
        pointer-events-none
        fixed
        inset-0
        -z-10
        overflow-hidden
    "
    aria-hidden="true"
>


@if ($themeMode !== 'dark')

    <div
        class="
            absolute
            left-1/2
            top-0
            h-[500px]
            w-[900px]
            -translate-x-1/2
            rounded-full
            bg-indigo-200/30
            blur-3xl
        "
    ></div>


    <div
        class="
            absolute
            -right-40
            top-[35%]
            h-[420px]
            w-[420px]
            rounded-full
            bg-purple-200/20
            blur-3xl
        "
    ></div>


    <div
        class="
            absolute
            -left-40
            top-[65%]
            h-[420px]
            w-[420px]
            rounded-full
            bg-blue-200/20
            blur-3xl
        "
    ></div>

@endif


</div>


{{-- ANNOUNCEMENT --}}

@if (
    $announcementEnabled &&
    filled($announcementText)
)

    <div
        class="
            relative
            z-50
            border-b
            border-indigo-100
            bg-indigo-50/80
            backdrop-blur-md
        "
    >

        <div
            class="
                mx-auto
                flex
                min-h-9
                max-w-7xl
                items-center
                justify-center
                px-6
                text-center
                text-xs
                font-medium
                text-indigo-700
            "
        >

            <span
                class="
                    inline-flex
                    items-center
                    gap-2
                "
            >

                <span
                    class="
                        inline-flex
                        h-5
                        w-5
                        items-center
                        justify-center
                        rounded-full
                        bg-indigo-600
                        text-[10px]
                        text-white
                    "
                >

                    <i class="fa-solid fa-sparkles"></i>

                </span>


                <span>

                    {{ $announcementText }}

                </span>

            </span>

        </div>

    </div>

@endif


{{-- HEADER --}}

@if ($headerEnabled)

    <div
        @class([
            'page-header-sticky' => $headerSticky,
        ])
    >

        @include(
            'public.partials.header',
            [
                'page' => $page ?? null,
                'settings' => $pageSettings,
            ]
        )


        {{-- MAIN NAVIGATION BAR --}}

        @include(
            'public.partials.navbar',
            [
                'page' => $page ?? null,
                'pageSettings' => $pageSettings,
            ]
        )

    </div>

@endif


{{-- SECONDARY NAVIGATION --}}

@if (
    $secondaryNavigationEnabled &&
    filled($secondaryNavigationTitle)
)

    <div
        class="
            relative
            z-30
            border-b
            border-slate-200
            bg-white/80
            backdrop-blur-md
        "
    >

        <div
            class="
                mx-auto
                max-w-7xl
                px-6
                py-3
                text-sm
                font-medium
            "
        >

            {{ $secondaryNavigationTitle }}

        </div>

    </div>

@endif


{{-- INFORMATION BAR --}}

@if (
    $informationBarEnabled &&
    filled($informationBarText)
)

    <div
        class="
            relative
            z-30
            border-b
            border-slate-200
            bg-slate-100
        "
    >

        <div
            class="
                mx-auto
                max-w-7xl
                px-6
                py-3
                text-center
                text-sm
                text-slate-600
            "
        >

            {{ $informationBarText }}

        </div>

    </div>

@endif


{{-- BREADCRUMB --}}

@if (
    $breadcrumbEnabled &&
    isset($page)
)

    <div
        class="
            relative
            z-20
            mx-auto
            max-w-7xl
            px-6
            pt-4
        "
    >

        <nav
            aria-label="Breadcrumb"
            class="text-sm text-slate-500"
        >

            <span>

                {{ $pageTitle }}

            </span>

        </nav>

    </div>

@endif


{{-- SIDEBAR DRAWER --}}

@if ($sidebarEnabled)

    @include(
        'public.partials.sidebar',
        [
            'pageSettings' => $pageSettings,
            'page' => $page ?? null,
            'sidebarPosition' => $sidebarPosition,
        ]
    )

@endif


{{-- MAIN CONTENT --}}
{{--
Page-specific Template & Layout is responsible for:
- Container
- Content Width
- Horizontal Padding
- Content Spacing
- Layout Mode
- Design Style

This global layout only provides the main content host.
--}}

<main
    id="main-content"
    class="
        relative
        min-h-screen
        w-full
        overflow-visible
    "
>

    @yield('content')

</main>


{{-- PRE FOOTER --}}

@hasSection('pre-footer')

    <section class="relative z-10">

        @yield('pre-footer')

    </section>

@endif


{{-- FOOTER --}}

@if ($footerEnabled)

    @if (
        ($isHomepage && $footerHomepage) ||
        ($isInnerPage && $footerInnerPages)
    )

        <div
            class="
                relative
                z-20
                {{ ! $footerDesktop
                    ? 'lg:hidden'
                    : ''
                }}
                {{ ! $footerTablet
                    ? 'md:max-lg:hidden'
                    : ''
                }}
                {{ ! $footerMobile
                    ? 'max-md:hidden'
                    : ''
                }}
            "
        >

            @include(
                'public.partials.footer',
                [
                    'pageSettings' => $pageSettings,
                    'page' => $page ?? null,
                ]
            )

        </div>

    @endif

@endif


{{-- GLOBAL PAGE SCRIPTS --}}

@stack('scripts')


{{-- OPTIONAL PAGE SCRIPTS --}}

@hasSection('page-scripts')

    @yield('page-scripts')

@endif


@endif

</body>
</html>