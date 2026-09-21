@php


/*
|--------------------------------------------------------------------------
| UNPUBLISHED PAGE
|--------------------------------------------------------------------------
| Displayed when a page exists but has not been published yet.
|
*/

$locale = app()->getLocale();

$isRtl = in_array($locale, ['fa', 'ps'], true);

$homeUrl = url('/' . $locale);

/*
|--------------------------------------------------------------------------
| PAGE SETTINGS
|--------------------------------------------------------------------------
*/

$settings = isset($settings) && is_array($settings)
    ? $settings
    : [];

/*
|--------------------------------------------------------------------------
| THEME COLOR
|--------------------------------------------------------------------------
*/

$primaryColor = data_get(
    $settings,
    'theme.colors.primary',
    data_get(
        $settings,
        'theme.primary_color',
        '#4f46e5'
    )
);

/*
|--------------------------------------------------------------------------
| LANGUAGE CONTENT
|--------------------------------------------------------------------------
*/

$content = match ($locale) {

    'fa' => [
        'badge' => 'منتشر نشده',
        'title' => 'این صفحه هنوز آماده انتشار نیست',
        'description' => 'این صفحه در حال آماده‌سازی است. پس از تکمیل و انتشار، محتوای آن در دسترس شما قرار خواهد گرفت.',
        'button' => 'بازگشت به صفحه اصلی',
    ],

    'ps' => [
        'badge' => 'لا تر اوسه نه ده خپره شوې',
        'title' => 'دا پاڼه لا تر اوسه د خپرېدو لپاره چمتو نه ده',
        'description' => 'دا پاڼه د چمتو کېدو په حال کې ده. کله چې بشپړه او خپره شي، تاسو به وکولای شئ چې هغې ته لاسرسی ومومئ.',
        'button' => 'اصلي پاڼې ته ستنېدل',
    ],

    default => [
        'badge' => 'DRAFT • NOT PUBLISHED',
        'title' => 'This page is not available yet',
        'description' => 'This page is currently being prepared. Once it is completed and published, its content will become available.',
        'button' => 'Back to Home',
    ],

};


@endphp

<!DOCTYPE html>

<html
    lang="{{ $locale }}"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
>

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<meta
    name="robots"
    content="noindex, nofollow"
>

<meta
    name="theme-color"
    content="{{ $primaryColor }}"
>

<title>{{ $content['title'] }}</title>

<meta
    name="description"
    content="{{ $content['description'] }}"
>

<!--
|--------------------------------------------------------------------------
| VITE
|--------------------------------------------------------------------------
-->

@vite([
    'resources/css/app.css',
    'resources/js/app.js',
])

<!--
|--------------------------------------------------------------------------
| FONT AWESOME
|--------------------------------------------------------------------------
-->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
>

<!--
|--------------------------------------------------------------------------
| STYLES
|--------------------------------------------------------------------------
-->

<style>

    :root {

        --unpublished-primary: {{ $primaryColor }};

        --unpublished-primary-soft:
            color-mix(
                in srgb,
                {{ $primaryColor }} 11%,
                transparent
            );

        --unpublished-primary-border:
            color-mix(
                in srgb,
                {{ $primaryColor }} 18%,
                transparent
            );

        --unpublished-background: #f8fafc;

        --unpublished-surface: #ffffff;

        --unpublished-surface-soft: #f8fafc;

        --unpublished-border:
            rgba(15, 23, 42, 0.08);

        --unpublished-heading:
            #0f172a;

        --unpublished-text:
            #64748b;

        --unpublished-muted:
            #94a3b8;

        --unpublished-shadow:
            rgba(15, 23, 42, 0.08);

        --unpublished-radius:
            28px;

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }


    html {
        min-height: 100%;
        scroll-behavior: smooth;
    }


    body {
        min-height: 100vh;
        margin: 0;
        padding: 0;

        font-family:
            Inter,
            ui-sans-serif,
            system-ui,
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            sans-serif;

        background:
            var(--unpublished-background);

        color:
            var(--unpublished-heading);

        -webkit-font-smoothing:
            antialiased;

        text-rendering:
            optimizeLegibility;
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE BACKGROUND
    |--------------------------------------------------------------------------
    */

    .unpublished-page {

        position: relative;

        min-height: 100vh;

        display: flex;

        align-items: center;

        justify-content: center;

        overflow: hidden;

        padding:
            48px 24px;

        background:

            radial-gradient(
                circle at 15% 10%,
                color-mix(
                    in srgb,
                    var(--unpublished-primary) 10%,
                    transparent
                ),
                transparent 30%
            ),

            radial-gradient(
                circle at 90% 85%,
                color-mix(
                    in srgb,
                    var(--unpublished-primary) 8%,
                    transparent
                ),
                transparent 32%
            ),

            var(--unpublished-background);
    }


    /*
    |--------------------------------------------------------------------------
    | DECORATIVE BACKGROUND ELEMENTS
    |--------------------------------------------------------------------------
    */

    .unpublished-decoration {

        position: absolute;

        pointer-events: none;

        border-radius: 9999px;

        opacity: 0.8;

        filter:
            blur(2px);
    }


    .unpublished-decoration-one {

        width: 460px;
        height: 460px;

        top: -300px;
        left: -180px;

        background:
            color-mix(
                in srgb,
                var(--unpublished-primary) 7%,
                transparent
            );
    }


    .unpublished-decoration-two {

        width: 520px;
        height: 520px;

        right: -260px;
        bottom: -300px;

        background:
            color-mix(
                in srgb,
                var(--unpublished-primary) 6%,
                transparent
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MAIN CONTAINER
    |--------------------------------------------------------------------------
    */

    .unpublished-container {

        position: relative;

        z-index: 2;

        width: min(
            100%,
            760px
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CARD
    |--------------------------------------------------------------------------
    */

    .unpublished-card {

        position: relative;

        overflow: hidden;

        padding:
            64px 56px;

        text-align: center;

        background:
            color-mix(
                in srgb,
                var(--unpublished-surface) 96%,
                transparent
            );

        border:
            1px solid
            var(--unpublished-border);

        border-radius:
            var(--unpublished-radius);

        box-shadow:

            0 30px 90px
            var(--unpublished-shadow),

            0 8px 24px
            rgba(15, 23, 42, 0.04);

        backdrop-filter:
            blur(18px);

        -webkit-backdrop-filter:
            blur(18px);

        animation:
            unpublished-card-enter
            500ms
            cubic-bezier(
                0.22,
                1,
                0.36,
                1
            )
            both;
    }


    /*
    |--------------------------------------------------------------------------
    | CARD TOP ACCENT
    |--------------------------------------------------------------------------
    */

    .unpublished-card::before {

        content: "";

        position: absolute;

        top: 0;
        left: 0;
        right: 0;

        height: 3px;

        background:
            linear-gradient(
                90deg,
                transparent,
                var(--unpublished-primary),
                transparent
            );

        opacity: 0.75;
    }


    /*
    |--------------------------------------------------------------------------
    | ICON
    |--------------------------------------------------------------------------
    */

    .unpublished-icon {

        width: 96px;
        height: 96px;

        margin:
            0 auto 28px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 28px;

        background:
            var(--unpublished-primary-soft);

        border:
            1px solid
            var(--unpublished-primary-border);

        color:
            var(--unpublished-primary);

        font-size:
            38px;

        box-shadow:
            0 12px 30px
            color-mix(
                in srgb,
                var(--unpublished-primary) 10%,
                transparent
            );

        animation:
            unpublished-icon-enter
            600ms
            150ms
            cubic-bezier(
                0.22,
                1,
                0.36,
                1
            )
            both;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS BADGE
    |--------------------------------------------------------------------------
    */

    .unpublished-badge {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        min-height: 32px;

        padding:
            7px 15px;

        margin-bottom:
            20px;

        border:
            1px solid
            var(--unpublished-primary-border);

        border-radius:
            9999px;

        background:
            var(--unpublished-primary-soft);

        color:
            var(--unpublished-primary);

        font-size:
            11px;

        font-weight:
            800;

        line-height:
            1;

        letter-spacing:
            0.07em;

        text-transform:
            uppercase;
    }


    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    .unpublished-title {

        max-width:
            650px;

        margin:
            0 auto;

        color:
            var(--unpublished-heading);

        font-size:
            clamp(
                32px,
                5vw,
                48px
            );

        font-weight:
            800;

        line-height:
            1.15;

        letter-spacing:
            -0.035em;
    }


    /*
    |--------------------------------------------------------------------------
    | RTL TITLE
    |--------------------------------------------------------------------------
    */

    html[dir="rtl"]
    .unpublished-title {

        letter-spacing:
            0;

        line-height:
            1.35;
    }


    /*
    |--------------------------------------------------------------------------
    | DESCRIPTION
    |--------------------------------------------------------------------------
    */

    .unpublished-description {

        max-width:
            560px;

        margin:
            22px auto 0;

        color:
            var(--unpublished-text);

        font-size:
            16px;

        font-weight:
            400;

        line-height:
            1.85;
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */

    .unpublished-actions {

        margin-top:
            36px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            12px;
    }


    /*
    |--------------------------------------------------------------------------
    | HOME BUTTON
    |--------------------------------------------------------------------------
    */

    .unpublished-button {

        min-height:
            52px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            11px;

        padding:
            0 24px;

        border:
            1px solid
            transparent;

        border-radius:
            15px;

        background:
            var(--unpublished-primary);

        color:
            #ffffff;

        text-decoration:
            none;

        font-size:
            14px;

        font-weight:
            700;

        line-height:
            1;

        box-shadow:
            0 12px 28px
            color-mix(
                in srgb,
                var(--unpublished-primary) 24%,
                transparent
            );

        transition:
            transform 180ms ease,
            box-shadow 180ms ease,
            filter 180ms ease;
    }


    .unpublished-button:hover {

        transform:
            translateY(-2px);

        filter:
            brightness(1.04);

        box-shadow:
            0 16px 34px
            color-mix(
                in srgb,
                var(--unpublished-primary) 30%,
                transparent
            );
    }


    .unpublished-button:active {

        transform:
            translateY(0);
    }


    .unpublished-button:focus-visible {

        outline:
            3px solid
            color-mix(
                in srgb,
                var(--unpublished-primary) 28%,
                transparent
            );

        outline-offset:
            4px;
    }


    /*
    |--------------------------------------------------------------------------
    | ICON DIRECTION
    |--------------------------------------------------------------------------
    */

    .unpublished-button i {

        font-size:
            13px;

        transition:
            transform 180ms ease;
    }


    html[dir="ltr"]
    .unpublished-button:hover i {

        transform:
            translateX(-3px);
    }


    html[dir="rtl"]
    .unpublished-button:hover i {

        transform:
            translateX(3px);
    }


    /*
    |--------------------------------------------------------------------------
    | FOOTNOTE
    |--------------------------------------------------------------------------
    */

    .unpublished-footnote {

        margin-top:
            24px;

        color:
            var(--unpublished-muted);

        font-size:
            12px;

        line-height:
            1.7;
    }


    /*
    |--------------------------------------------------------------------------
    | ANIMATIONS
    |--------------------------------------------------------------------------
    */

    @keyframes unpublished-card-enter {

        from {

            opacity:
                0;

            transform:
                translateY(18px)
                scale(0.985);
        }

        to {

            opacity:
                1;

            transform:
                translateY(0)
                scale(1);
        }

    }


    @keyframes unpublished-icon-enter {

        from {

            opacity:
                0;

            transform:
                translateY(12px)
                scale(0.92);
        }

        to {

            opacity:
                1;

            transform:
                translateY(0)
                scale(1);
        }

    }


    /*
    |--------------------------------------------------------------------------
    | TABLET
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {

        .unpublished-page {

            padding:
                36px 20px;
        }


        .unpublished-card {

            padding:
                52px 36px;

            border-radius:
                24px;
        }


        .unpublished-title {

            font-size:
                clamp(
                    30px,
                    6vw,
                    40px
                );
        }

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 560px) {

        .unpublished-page {

            padding:
                20px 14px;
        }


        .unpublished-card {

            padding:
                42px 22px;

            border-radius:
                22px;
        }


        .unpublished-icon {

            width:
                78px;

            height:
                78px;

            margin-bottom:
                22px;

            border-radius:
                22px;

            font-size:
                30px;
        }


        .unpublished-badge {

            margin-bottom:
                16px;

            padding:
                7px 12px;

            font-size:
                10px;
        }


        .unpublished-title {

            font-size:
                29px;

            line-height:
                1.25;
        }


        html[dir="rtl"]
        .unpublished-title {

            line-height:
                1.45;
        }


        .unpublished-description {

            margin-top:
                18px;

            font-size:
                14px;

            line-height:
                1.85;
        }


        .unpublished-actions {

            margin-top:
                30px;
        }


        .unpublished-button {

            width:
                100%;

            min-height:
                52px;
        }


        .unpublished-footnote {

            margin-top:
                20px;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | DARK MODE
    |--------------------------------------------------------------------------
    */

    @media (prefers-color-scheme: dark) {

        :root {

            --unpublished-background:
                #0b1120;

            --unpublished-surface:
                #111827;

            --unpublished-surface-soft:
                #172033;

            --unpublished-border:
                rgba(
                    255,
                    255,
                    255,
                    0.08
                );

            --unpublished-heading:
                #f8fafc;

            --unpublished-text:
                #94a3b8;

            --unpublished-muted:
                #64748b;

            --unpublished-shadow:
                rgba(
                    0,
                    0,
                    0,
                    0.28
                );
        }


        .unpublished-page {

            background:

                radial-gradient(
                    circle at 15% 10%,
                    color-mix(
                        in srgb,
                        var(--unpublished-primary) 13%,
                        transparent
                    ),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 85%,
                    color-mix(
                        in srgb,
                        var(--unpublished-primary) 10%,
                        transparent
                    ),
                    transparent 32%
                ),

                var(--unpublished-background);
        }


        .unpublished-card {

            background:
                rgba(
                    17,
                    24,
                    39,
                    0.88
                );
        }

    }


    /*
    |--------------------------------------------------------------------------
    | REDUCED MOTION
    |--------------------------------------------------------------------------
    */

    @media (prefers-reduced-motion: reduce) {

        html {
            scroll-behavior:
                auto;
        }


        .unpublished-card,
        .unpublished-icon {

            animation:
                none;
        }


        .unpublished-button,
        .unpublished-button i {

            transition:
                none;
        }

    }

</style>


</head>

<body>


<!--
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
-->

<main
    class="unpublished-page"
    aria-labelledby="unpublished-title"
>

    <!-- Decorative background -->

    <div
        class="unpublished-decoration unpublished-decoration-one"
        aria-hidden="true"
    ></div>


    <div
        class="unpublished-decoration unpublished-decoration-two"
        aria-hidden="true"
    ></div>


    <!-- Main container -->

    <div class="unpublished-container">

        <section class="unpublished-card">

            <!-- Status icon -->

            <div
                class="unpublished-icon"
                aria-hidden="true"
            >
                <i class="fa-solid fa-file-circle-exclamation"></i>
            </div>


            <!-- Status -->

            <div class="unpublished-badge">
                {{ $content['badge'] }}
            </div>


            <!-- Title -->

            <h1
                id="unpublished-title"
                class="unpublished-title"
            >
                {{ $content['title'] }}
            </h1>


            <!-- Description -->

            <p class="unpublished-description">
                {{ $content['description'] }}
            </p>


            <!-- Action -->

            <div class="unpublished-actions">

                <a
                    href="{{ $homeUrl }}"
                    class="unpublished-button"
                    aria-label="{{ $content['button'] }}"
                >

                    @if ($isRtl)

                        <i
                            class="fa-solid fa-arrow-right"
                            aria-hidden="true"
                        ></i>

                    @else

                        <i
                            class="fa-solid fa-arrow-left"
                            aria-hidden="true"
                        ></i>

                    @endif

                    <span>
                        {{ $content['button'] }}
                    </span>

                </a>

            </div>


            <!-- Small informational text -->

            <div class="unpublished-footnote">

                @if ($locale === 'fa')

                    وضعیت این صفحه: پیش‌نویس

                @elseif ($locale === 'ps')

                    د دې پاڼې حالت: مسوده

                @else

                    Page status: Draft

                @endif

            </div>

        </section>

    </div>

</main>


</body>

</html>
