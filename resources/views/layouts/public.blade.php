<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'ps']) ? 'rtl' : 'ltr' }}"
>
<head>

{{-- ==========================================================================
01. BASIC DOCUMENT META
========================================================================== --}}

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

{{-- ==========================================================================
02. PAGE BUILDER SETTINGS
========================================================================== --}}

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
| 03. GENERAL PAGE SETTINGS
|--------------------------------------------------------------------------
| ????? ????? ??????? ? Favicon
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
| 04. THEME META CONTEXT
|--------------------------------------------------------------------------
| Theme rendering ???? ????:
|
| public.partials.theme
|
| ?????? ??????.
|
| ??? ??? ??? ?????? ???? ???? Layout ????? ?? ????? ??????.
|--------------------------------------------------------------------------
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
| 05. SEO SETTINGS
|--------------------------------------------------------------------------
| Primary SEO values
|--------------------------------------------------------------------------
*/

$seoTitle = data_get(
    $pageSettings,
    'seo_title',
    $page->seo_title ?? null
);

$seoTitle = filled($seoTitle)
    ? $seoTitle
    : ($page->title ?? $pageTitle ?? 'Dev-Platform');


$metaDescription = data_get(
    $pageSettings,
    'seo_description',
    $page->seo_description ?? null
);

$metaDescription = filled($metaDescription)
    ? $metaDescription
    : 'Dev-Platform Digital Organization Management Platform';


$metaKeywords = data_get(
    $pageSettings,
    'seo_keywords',
    null
);

$metaKeywords = filled($metaKeywords)
    ? $metaKeywords
    : 'Laravel, ERP, HR, Finance, Accounting, Digital Platform';


$canonicalUrl = data_get(
    $pageSettings,
    'seo_canonical_url',
    null
);

$canonicalUrl = filled($canonicalUrl)
    ? $canonicalUrl
    : url()->current();


/*
|--------------------------------------------------------------------------
| 06. META SETTINGS
|--------------------------------------------------------------------------
*/

$metaAuthor = data_get(
    $pageSettings,
    'meta_author',
    null
);

$metaAuthor = filled($metaAuthor)
    ? $metaAuthor
    : $author;


$metaApplicationName = data_get(
    $pageSettings,
    'meta_application_name',
    'Dev-Platform'
);


$metaThemeColor = data_get(
    $pageSettings,
    'meta_theme_color',
    null
);

$metaThemeColor = filled($metaThemeColor)
    ? $metaThemeColor
    : $primaryColor;


$metaReferrer = data_get(
    $pageSettings,
    'meta_referrer',
    'strict-origin-when-cross-origin'
);


$customMeta = data_get(
    $pageSettings,
    'meta_custom',
    []
);

$customMeta = is_array($customMeta)
    ? $customMeta
    : [];


/*
|--------------------------------------------------------------------------
| 07. OPEN GRAPH SETTINGS
|--------------------------------------------------------------------------
*/

$ogTitle = data_get(
    $pageSettings,
    'og_title',
    null
);

$ogTitle = filled($ogTitle)
    ? $ogTitle
    : $seoTitle;


$ogDescription = data_get(
    $pageSettings,
    'og_description',
    null
);

$ogDescription = filled($ogDescription)
    ? $ogDescription
    : $metaDescription;


$ogImage = data_get(
    $pageSettings,
    'og_image',
    null
);


$ogUrl = data_get(
    $pageSettings,
    'og_url',
    null
);

$ogUrl = filled($ogUrl)
    ? $ogUrl
    : $canonicalUrl;


$ogType = data_get(
    $pageSettings,
    'og_type',
    'website'
);


$ogSiteName = data_get(
    $pageSettings,
    'og_site_name',
    'Dev-Platform'
);


$ogLocale = data_get(
    $pageSettings,
    'og_locale',
    null
);

$ogLocale = filled($ogLocale)
    ? $ogLocale
    : match (app()->getLocale()) {
        'fa' => 'fa_IR',
        'ps' => 'ps_AF',
        default => 'en_US',
    };


/*
|--------------------------------------------------------------------------
| 08. ROBOTS SETTINGS
|--------------------------------------------------------------------------
*/

$robotsIndex = data_get(
    $pageSettings,
    'robots_index',
    'index'
);

$robotsFollow = data_get(
    $pageSettings,
    'robots_follow',
    'follow'
);

$robotsArchive = (bool) data_get(
    $pageSettings,
    'robots_archive',
    true
);

$robotsSnippet = (bool) data_get(
    $pageSettings,
    'robots_snippet',
    true
);

$robotsImageIndex = (bool) data_get(
    $pageSettings,
    'robots_image_index',
    true
);


$robotsDirectives = [];

$robotsDirectives[] = $robotsIndex === 'noindex'
    ? 'noindex'
    : 'index';

$robotsDirectives[] = $robotsFollow === 'nofollow'
    ? 'nofollow'
    : 'follow';

if (! $robotsArchive) {
    $robotsDirectives[] = 'noarchive';
}

if (! $robotsSnippet) {
    $robotsDirectives[] = 'nosnippet';
}

if (! $robotsImageIndex) {
    $robotsDirectives[] = 'noimageindex';
}

$robots = implode(
    ', ',
    $robotsDirectives
);


/*
|--------------------------------------------------------------------------
| 09. STRUCTURED DATA SETTINGS
|--------------------------------------------------------------------------
*/

$schemaType = data_get(
    $pageSettings,
    'schema_type',
    'WebPage'
);

$schemaDescription = data_get(
    $pageSettings,
    'schema_description',
    null
);

$schemaDescription = filled($schemaDescription)
    ? $schemaDescription
    : $metaDescription;


$schemaProperties = data_get(
    $pageSettings,
    'schema_properties',
    []
);

$schemaProperties = is_array($schemaProperties)
    ? $schemaProperties
    : [];


$schemaCustomJson = data_get(
    $pageSettings,
    'schema_custom_json',
    null
);


/*
|--------------------------------------------------------------------------
| 09.1 BUILD DEFAULT STRUCTURED DATA
|--------------------------------------------------------------------------
*/

$structuredData = [
    '@context' => 'https://schema.org',
    '@type' => $schemaType,
    'name' => $seoTitle,
    'description' => $schemaDescription,
    'url' => $canonicalUrl,
];

foreach ($schemaProperties as $property => $value) {

    if (
        filled($property) &&
        filled($value)
    ) {
        $structuredData[$property] = $value;
    }

}


/*
|--------------------------------------------------------------------------
| 09.2 CUSTOM JSON-LD
|--------------------------------------------------------------------------
|
| ??? JSON ????? ???? ??? ????? ?????? ?? ?? ???.
|--------------------------------------------------------------------------
*/

$customStructuredData = null;

if (filled($schemaCustomJson)) {

    $decodedStructuredData = json_decode(
        $schemaCustomJson,
        true
    );

    if (
        json_last_error() === JSON_ERROR_NONE &&
        is_array($decodedStructuredData)
    ) {
        $customStructuredData = $decodedStructuredData;
    }

}

 /*
| -------------------------------------------------------------------------- |
| 10. RESPONSIVE SETTINGS                                                    |
| -------------------------------------------------------------------------- |
| Responsive settings for mobile, tablet, and desktop.                       |
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
| 11. LAYOUT SETTINGS                                                        |
| -------------------------------------------------------------------------- |
| ???:                                                                       |
|                                                                            |
| Layout ??????? ???? ??:                                                    |
|                                                                            |
| public.partials.template-layout                                            |
|                                                                            |
| ????? ??????.                                                              |
|                                                                            |
| ??? Layout ????? ???? Container / Width / Padding /                        |
| Spacing ????? ?? ?????? ???? ?? ????? ???????.                             |
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
| 12. HEADER SETTINGS
|--------------------------------------------------------------------------
| ???? ???? Header
| Sticky ???? Header
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
| 13. NAVIGATION SETTINGS
|--------------------------------------------------------------------------
| Announcement
| Secondary Navigation
| Breadcrumb
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
| 14. INFORMATION BAR SETTINGS
|--------------------------------------------------------------------------
| ???? ???????? ?????
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
| 15. SIDEBAR SETTINGS
|--------------------------------------------------------------------------
| ??? Layout ??? ???? ????? ???? Sidebar ???? ???????.
|
| Sidebar ?? ???? ????? ????:
|
| public.partials.sidebar
|
| ???? ?????? ? ???? ????? Drawer ?? ?????????? ????? ???.
|--------------------------------------------------------------------------
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
| 16. FOOTER SETTINGS
|--------------------------------------------------------------------------
| ???? ???? Footer
|
| Visibility:
| Desktop
| Tablet
| Mobile
|
| Page Type:
| Homepage
| Inner Pages
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
| 17. ACCESS SETTINGS
|--------------------------------------------------------------------------
| ????? ???? ?????? ???? ????
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
| 18. ROUTE CONTEXT
|--------------------------------------------------------------------------
| ????? Homepage ? Inner Page
|--------------------------------------------------------------------------
*/

$isHomepage = request()->routeIs('public.home');

$isInnerPage = request()->routeIs('public.page');

@endphp


{{-- ==========================================================================
19. SEO OUTPUT
|--------------------------------------------------------------------------
| ????? ????? Meta Tags ????? ?? SEO
========================================================================== --}}

<title>
    @yield('title', $seoTitle)
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
    content="{{ $metaAuthor }}"
>

<meta
    name="application-name"
    content="{{ $metaApplicationName }}"
>

<meta
    name="robots"
    content="@yield('robots', $robots)"
>

<meta
    name="referrer"
    content="{{ $metaReferrer }}"
>


{{-- ==========================================================================
20. CUSTOM META TAGS
========================================================================== --}}

@foreach ($customMeta as $metaName => $metaContent)

    @if (filled($metaName) && filled($metaContent))

        <meta
            name="{{ $metaName }}"
            content="{{ $metaContent }}"
        >

    @endif

@endforeach


{{-- ==========================================================================
21. OPEN GRAPH OUTPUT
========================================================================== --}}

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
    content="{{ $ogUrl }}"
>

<meta
    property="og:site_name"
    content="{{ $ogSiteName }}"
>

<meta
    property="og:locale"
    content="{{ $ogLocale }}"
>

@if (filled($ogImage))

    <meta
        property="og:image"
        content="{{ $ogImage }}"
    >

@endif


{{-- ==========================================================================
22. CANONICAL URL
========================================================================== --}}

@if (filled($canonicalUrl))

    <link
        rel="canonical"
        href="{{ $canonicalUrl }}"
    >

@endif


{{-- ==========================================================================
23. THEME META
|--------------------------------------------------------------------------
| Theme Color
| Color Scheme
========================================================================== --}}

<meta
    name="theme-color"
    content="{{ $metaThemeColor }}"
>

<meta
    name="color-scheme"
    content="{{ $themeMode === 'auto' ? 'light dark' : $themeMode }}"
>


{{-- ==========================================================================
24. FAVICON
========================================================================== --}}

@if (filled($favicon))

    <link
        rel="icon"
        href="{{ $favicon }}"
    >

@endif


{{-- ==========================================================================
25. STRUCTURED DATA
|--------------------------------------------------------------------------
| JSON-LD
|--------------------------------------------------------------------------
| ??? Custom JSON-LD ????? ????? ???? ??????? ??????.
| ?? ??? ??? ???? Structured Data ????????? ???? ??????? ??????? ??????.
========================================================================== --}}

<script type="application/ld+json">
@json(
    $customStructuredData ?? $structuredData,
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT
)
</script>


{{-- ==========================================================================
26. FONT AWESOME
========================================================================== --}}

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
>


{{-- ==========================================================================
27. VITE ASSETS
========================================================================== --}}

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])


{{-- ==========================================================================
28. PUBLIC THEME SYSTEM
|--------------------------------------------------------------------------
| ????? ???? Theme
========================================================================== --}}

@include(
    'public.partials.theme',
    [
        'pageSettings' => $pageSettings,
    ]
)


{{-- ==========================================================================
29. GLOBAL LAYOUT STYLES
|--------------------------------------------------------------------------
| CSS ????? Layout
========================================================================== --}}

<style>


/*
|--------------------------------------------------------------------------
| 29.1 GLOBAL RESPONSIVE CONTROL
|--------------------------------------------------------------------------
| ????? ????? ???? ?? ???? ??????? Responsive
|
| Mobile  : 0 - 767px
| Tablet  : 768 - 1023px
| Desktop : 1024px+
|--------------------------------------------------------------------------
*/

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
    | 29.2 HEADER STICKY
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
    | 29.3 SIDEBAR
    |--------------------------------------------------------------------------
    |
    | ??? Sidebar Layout Host ?? ??? ???? ???? ?????.
    |
    | Sidebar ?? ???? Drawer ????? ???? DOM ???? ???????.
    |
    |--------------------------------------------------------------------------
    */

</style>


{{-- ==========================================================================
30. STACKED STYLES
========================================================================== --}}

@stack('styles')

</head>


<body
    class="
        min-h-screen
        antialiased
    "
>


{{-- ==========================================================================
31. PAGE ACCESS CONTROL
|--------------------------------------------------------------------------
| ??? ???? ???? ?????? ?????? ???? Page unavailable ????? ???? ??????.
========================================================================== --}}

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


{{-- ==========================================================================
32. GLOBAL BACKGROUND
|--------------------------------------------------------------------------
| Background Decoration ????? ????
========================================================================== --}}

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


{{-- ==========================================================================
33. ANNOUNCEMENT BAR
|--------------------------------------------------------------------------
| ???? ????? ????? Header
========================================================================== --}}

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


{{-- ==========================================================================
34. HEADER
|--------------------------------------------------------------------------
| Header ???? ????
========================================================================== --}}

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


        {{-- ------------------------------------------------------------------
        34.1 MAIN NAVIGATION BAR
        ------------------------------------------------------------------ --}}

        @include(
            'public.partials.navbar',
            [
                'page' => $page ?? null,
                'pageSettings' => $pageSettings,
            ]
        )

    </div>

@endif


{{-- ==========================================================================
35. SECONDARY NAVIGATION
========================================================================== --}}

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


{{-- ==========================================================================
36. INFORMATION BAR
========================================================================== --}}

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


{{-- ==========================================================================
37. BREADCRUMB
========================================================================== --}}

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


{{-- ==========================================================================
38. SIDEBAR DRAWER
|--------------------------------------------------------------------------
| Sidebar ????? ?? Layout ???? ????
========================================================================== --}}

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


{{-- ==========================================================================
39. MAIN CONTENT
|--------------------------------------------------------------------------
| Page-specific Template & Layout ????? ????? ??? ???:
|
| - Container
| - Content Width
| - Horizontal Padding
| - Content Spacing
| - Layout Mode
| - Design Style
|
| ??? Layout ????? ??? Main Content Host ?? ????? ??????.
========================================================================== --}}

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


{{-- ==========================================================================
40. PRE-FOOTER
|--------------------------------------------------------------------------
| ?????? ??????? ??? ?? Footer
========================================================================== --}}

@hasSection('pre-footer')

    <section class="relative z-10">

        @yield('pre-footer')

    </section>

@endif


{{-- ==========================================================================
41. FOOTER
|--------------------------------------------------------------------------
| Footer ?? ???? ????? ??? ????? ??????:
|
| - Footer Enabled
| - Homepage / Inner Page
| - Desktop / Tablet / Mobile
========================================================================== --}}

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


{{-- ==========================================================================
42. GLOBAL PAGE SCRIPTS
========================================================================== --}}

@stack('scripts')


{{-- ==========================================================================
43. OPTIONAL PAGE SCRIPTS
|--------------------------------------------------------------------------
| Script??? ??????? ?? Page
========================================================================== --}}

@hasSection('page-scripts')

    @yield('page-scripts')

@endif


@endif

</body>
</html>
