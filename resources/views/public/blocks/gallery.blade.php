@php


$data = $block->data ?? [];
$settings = $block->settings ?? [];

/*
|--------------------------------------------------------------------------
| Global Visibility
|--------------------------------------------------------------------------
*/

if (($settings['visible'] ?? true) === false) {
    return;
}

$showMobile = $settings['show_mobile'] ?? true;
$showDesktop = $settings['show_desktop'] ?? true;

/*
|--------------------------------------------------------------------------
| Gallery Data
|--------------------------------------------------------------------------
*/

$title = $data['title'] ?? null;
$description = $data['description'] ?? null;
$images = $data['images'] ?? [];

/*
|--------------------------------------------------------------------------
| Global Text Color
|--------------------------------------------------------------------------
*/

$textColor = match ($settings['text_color'] ?? 'dark') {
    'light' => [
        'title' => 'text-white',
        'description' => 'text-white/80',
        'captionTitle' => 'text-white',
        'caption' => 'text-white/80',
    ],

    default => [
        'title' => 'text-gray-900 dark:text-white',
        'description' => 'text-gray-600 dark:text-gray-300',
        'captionTitle' => 'text-gray-900 dark:text-white',
        'caption' => 'text-gray-600 dark:text-gray-400',
    ],
};

/*
|--------------------------------------------------------------------------
| Animation
|--------------------------------------------------------------------------
*/

$animation = match ($settings['animation'] ?? 'none') {
    'fade' => 'gallery-animate-fade',
    'slide' => 'gallery-animate-slide',
    'zoom' => 'gallery-animate-zoom',
    default => '',
};

/*
|--------------------------------------------------------------------------
| Gallery Layout
|--------------------------------------------------------------------------
*/

$layout = $data['layout'] ?? 'grid';

$columns = match ($data['columns'] ?? '3') {
    '2' => 'grid-cols-1 sm:grid-cols-2',

    '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',

    '5' => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5',

    default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
};

/*
|--------------------------------------------------------------------------
| Gap
|--------------------------------------------------------------------------
*/

$gap = match ($data['gap'] ?? 'medium') {
    'none' => 'gap-0',
    'small' => 'gap-4',
    'large' => 'gap-8',
    default => 'gap-6',
};

/*
|--------------------------------------------------------------------------
| Aspect Ratio
|--------------------------------------------------------------------------
*/

$aspectRatio = match ($data['aspect_ratio'] ?? '4/3') {
    'square' => 'aspect-square',
    '4/3' => 'aspect-[4/3]',
    '3/2' => 'aspect-[3/2]',
    '16/9' => 'aspect-video',
    default => '',
};

/*
|--------------------------------------------------------------------------
| Object Fit
|--------------------------------------------------------------------------
*/

$objectFit = match ($data['object_fit'] ?? 'cover') {
    'contain' => 'object-contain bg-gray-100 dark:bg-gray-800',
    default => 'object-cover',
};

/*
|--------------------------------------------------------------------------
| Border Radius
|--------------------------------------------------------------------------
*/

$radius = match ($data['radius'] ?? 'medium') {
    'none' => 'rounded-none',
    'small' => 'rounded-lg',
    'large' => 'rounded-3xl',
    'full' => 'rounded-[2rem]',
    default => 'rounded-xl',
};

/*
|--------------------------------------------------------------------------
| Shadow
|--------------------------------------------------------------------------
*/

$shadow = match ($data['shadow'] ?? 'small') {
    'none' => 'shadow-none',
    'medium' => 'shadow-lg',
    'large' => 'shadow-2xl',
    default => 'shadow-md',
};

/*
|--------------------------------------------------------------------------
| Hover Effect
|--------------------------------------------------------------------------
*/

$hover = match ($data['hover'] ?? 'zoom') {
    'none' => '',

    'lift' => '
        transition-all
        duration-500
        ease-out
        hover:-translate-y-2
        hover:shadow-2xl
    ',

    'grayscale' => '
        transition-all
        duration-500
        ease-out
    ',

    default => '
        transition-all
        duration-500
        ease-out
    ',
};

/*
|--------------------------------------------------------------------------
| Container
|--------------------------------------------------------------------------
*/

$container = match ($settings['container'] ?? 'default') {
    'wide' => 'max-w-[1600px]',
    'full' => 'max-w-full',
    default => 'max-w-7xl',
};

/*
|--------------------------------------------------------------------------
| Desktop Padding
|--------------------------------------------------------------------------
*/

$padding = match ($settings['padding'] ?? 'medium') {
    'none' => '',
    'small' => 'py-8',
    'large' => 'py-20',
    default => 'py-12',
};

/*
|--------------------------------------------------------------------------
| Mobile Padding
|--------------------------------------------------------------------------
*/

$mobilePadding = match ($settings['mobile_padding'] ?? 'small') {
    'none' => 'max-sm:py-0',
    'medium' => 'max-sm:py-8',
    'large' => 'max-sm:py-12',
    default => 'max-sm:py-4',
};

/*
|--------------------------------------------------------------------------
| Section ID
|--------------------------------------------------------------------------
*/

$sectionId = $settings['section_id'] ?? '';

/*
|--------------------------------------------------------------------------
| Custom Class
|--------------------------------------------------------------------------
*/

$customClass = $settings['custom_class'] ?? '';

/*
|--------------------------------------------------------------------------
| Custom CSS
|--------------------------------------------------------------------------
*/

$customCss = $settings['custom_css'] ?? '';

/*
|--------------------------------------------------------------------------
| Global Background
|--------------------------------------------------------------------------
*/

$background = $settings['background'] ?? [];

$backgroundColor = $background['color'] ?? null;

$backgroundImage = $background['image'] ?? null;

$backgroundOverlay = $background['overlay'] ?? false;

$backgroundPosition = match ($background['position'] ?? 'center') {
    'top' => 'center top',
    'bottom' => 'center bottom',
    default => 'center center',
};

/*
|--------------------------------------------------------------------------
| Background Image URL
|--------------------------------------------------------------------------
*/

$backgroundImageUrl = null;

if ($backgroundImage) {

    if (is_array($backgroundImage)) {

        $backgroundPath =
            $backgroundImage['path']
            ?? $backgroundImage['url']
            ?? $backgroundImage['name']
            ?? null;

    } else {

        $backgroundPath = $backgroundImage;

    }

    if ($backgroundPath) {

        if (
            str_starts_with($backgroundPath, 'http://')
            ||
            str_starts_with($backgroundPath, 'https://')
            ||
            str_starts_with($backgroundPath, '/')
        ) {

            $backgroundImageUrl = $backgroundPath;

        } else {

            $backgroundImageUrl = asset(
                'storage/' . ltrim($backgroundPath, '/')
            );

        }

    }

}

/*
|--------------------------------------------------------------------------
| Background Style
|--------------------------------------------------------------------------
*/

$sectionStyle = [];

if ($backgroundColor) {
    $sectionStyle[] = 'background-color: ' . $backgroundColor . ';';
}

if ($backgroundImageUrl) {

    $sectionStyle[] =
        'background-image: url("' .
        e($backgroundImageUrl) .
        '");';

    $sectionStyle[] =
        'background-position: ' .
        $backgroundPosition .
        ';';

    $sectionStyle[] =
        'background-size: cover;';

    $sectionStyle[] =
        'background-repeat: no-repeat;';

    $sectionStyle[] =
        'background-attachment: scroll;';

}

if ($customCss) {
    $sectionStyle[] = $customCss;
}

$sectionStyleString = implode(' ', $sectionStyle);


@endphp

<style>

    /*
    |--------------------------------------------------------------------------
    | Gallery Block Animations
    |--------------------------------------------------------------------------
    */

    .gallery-animate-fade {
        animation: galleryFadeIn 0.8s ease-out both;
    }

    .gallery-animate-slide {
        animation: gallerySlideUp 0.8s ease-out both;
    }

    .gallery-animate-zoom {
        animation: galleryZoomIn 0.8s ease-out both;
    }

    @keyframes galleryFadeIn {

        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }

    }

    @keyframes gallerySlideUp {

        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }

    }

    @keyframes galleryZoomIn {

        from {
            opacity: 0;
            transform: scale(0.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }

    }

</style>

<section


@if($sectionId)
    id="{{ $sectionId }}"
@endif

class="
    relative
    isolate
    w-full
    overflow-hidden
    {{ $padding }}
    {{ $mobilePadding }}
    {{ $animation }}
    {{ $customClass }}

    @if(!$showMobile)
        max-sm:hidden
    @endif

    @if(!$showDesktop)
        sm:hidden
    @endif
"

@if($sectionStyleString)
    style="{{ $sectionStyleString }}"
@endif


>


{{-- ========================================================= --}}
{{-- Background Overlay --}}
{{-- ========================================================= --}}

@if($backgroundImageUrl && $backgroundOverlay)

    <div
        class="
            pointer-events-none
            absolute
            inset-0
            -z-10
            bg-black/35
        "
        aria-hidden="true"
    ></div>

@endif


{{-- ========================================================= --}}
{{-- Content Container --}}
{{-- ========================================================= --}}

<div
    class="
        relative
        z-10
        mx-auto
        w-full
        px-4
        sm:px-6
        lg:px-8
        {{ $container }}
    "
>


    {{-- ===================================================== --}}
    {{-- Gallery Header --}}
    {{-- ===================================================== --}}

    @if($title || $description)

        <div class="mb-10 text-center">

            @if($title)

                <h2
                    class="
                        text-3xl
                        font-bold
                        tracking-tight
                        sm:text-4xl
                        {{ $textColor['title'] }}
                    "
                >
                    {{ $title }}
                </h2>

            @endif


            @if($description)

                <p
                    class="
                        mx-auto
                        mt-4
                        max-w-2xl
                        text-base
                        leading-7
                        {{ $textColor['description'] }}
                    "
                >
                    {{ $description }}
                </p>

            @endif

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- Empty Gallery --}}
    {{-- ===================================================== --}}

    @if(empty($images))

        <div
            class="
                rounded-2xl
                border
                border-dashed
                border-gray-300/70
                bg-white/70
                p-12
                text-center
                backdrop-blur-sm
                dark:border-gray-700/70
                dark:bg-gray-900/70
            "
        >

            <p class="text-gray-500 dark:text-gray-400">
                No gallery images available.
            </p>

        </div>


    @else


        {{-- ================================================= --}}
        {{-- Gallery Grid --}}
        {{-- ================================================= --}}

        <div
            class="
                grid
                {{ $columns }}
                {{ $gap }}
            "
        >


            @foreach($images as $item)

                @php

                    $image = $item['image'] ?? null;

                    $imageTitle = $item['title'] ?? '';

                    $imageAlt =
                        $item['alt']
                        ?? $imageTitle
                        ?? $title
                        ?? 'Gallery Image';

                    $imageDescription =
                        $item['description'] ?? '';

                    $caption =
                        $item['caption'] ?? '';


                    if (!$image) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Gallery Image Path
                    |--------------------------------------------------------------------------
                    */

                    if (is_array($image)) {

                        $imagePath =
                            $image['path']
                            ?? $image['url']
                            ?? $image['name']
                            ?? null;

                    } else {

                        $imagePath = $image;

                    }


                    if (!$imagePath) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Gallery Image URL
                    |--------------------------------------------------------------------------
                    */

                    if (
                        str_starts_with($imagePath, 'http://')
                        ||
                        str_starts_with($imagePath, 'https://')
                        ||
                        str_starts_with($imagePath, '/')
                    ) {

                        $imageUrl = $imagePath;

                    } else {

                        $imageUrl = asset(
                            'storage/' .
                            ltrim($imagePath, '/')
                        );

                    }

                @endphp


                {{-- ================================================= --}}
                {{-- Gallery Card --}}
                {{-- ================================================= --}}

                <article
                    class="
                        group
                        relative
                        overflow-hidden
                        {{ $radius }}
                        {{ $shadow }}
                        {{ $hover }}

                        bg-white/95
                        backdrop-blur-sm

                        dark:bg-gray-900/95

                        ring-1
                        ring-black/5
                        dark:ring-white/10
                    "
                >


                    {{-- ================================================= --}}
                    {{-- Image Wrapper --}}
                    {{-- ================================================= --}}

                    <div
                        class="
                            relative
                            overflow-hidden
                            {{ $aspectRatio }}
                            bg-gray-100
                            dark:bg-gray-800
                        "
                    >


                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $imageAlt }}"

                            @if(($data['lazy_loading'] ?? true) === true)
                                loading="lazy"
                            @else
                                loading="eager"
                            @endif

                            class="
                                h-full
                                w-full
                                {{ $objectFit }}

                                transition-transform
                                duration-700
                                ease-out

                                @if(($data['hover'] ?? 'zoom') === 'zoom')
                                    group-hover:scale-110
                                @endif

                                @if(($data['hover'] ?? 'zoom') === 'lift')
                                    group-hover:scale-[1.03]
                                @endif

                                @if(($data['hover'] ?? 'zoom') === 'grayscale')
                                    group-hover:grayscale
                                @endif
                            "
                        />


                        {{-- ================================================= --}}
                        {{-- Image Gradient --}}
                        {{-- ================================================= --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                bottom-0
                                h-1/2
                                bg-gradient-to-t
                                from-black/45
                                via-black/10
                                to-transparent
                                opacity-0
                                transition-opacity
                                duration-500
                                group-hover:opacity-100
                            "
                        ></div>


                        {{-- ================================================= --}}
                        {{-- Image Overlay --}}
                        {{-- ================================================= --}}

                        @if(($data['overlay'] ?? false) === true)

                            <div
                                class="
                                    pointer-events-none
                                    absolute
                                    inset-0
                                    flex
                                    items-center
                                    justify-center
                                    opacity-0
                                    transition-all
                                    duration-500
                                    group-hover:opacity-100
                                "
                                style="
                                    background-color:
                                    {{ $data['overlay_color'] ?? '#000000' }};
                                    opacity:
                                    0.55;
                                "
                            >

                                <div
                                    class="
                                        rounded-full
                                        bg-white/20
                                        p-4
                                        backdrop-blur-md
                                        ring-1
                                        ring-white/30
                                        transition-transform
                                        duration-500
                                        group-hover:scale-100
                                        scale-90
                                    "
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-7 w-7 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />

                                    </svg>

                                </div>

                            </div>

                        @endif


                    </div>


                    {{-- ================================================= --}}
                    {{-- Caption --}}
                    {{-- ================================================= --}}

                    @if(
                        ($data['show_caption'] ?? true)
                        &&
                        ($caption || $imageTitle || $imageDescription)
                    )

                        <div class="p-5 sm:p-6">


                            @if($imageTitle)

                                <h3
                                    class="
                                        text-lg
                                        font-semibold
                                        leading-6
                                        {{ $textColor['captionTitle'] }}
                                    "
                                >
                                    {{ $imageTitle }}
                                </h3>

                            @endif


                            @if($caption)

                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        leading-6
                                        {{ $textColor['caption'] }}
                                    "
                                >
                                    {{ $caption }}
                                </p>

                            @endif


                            @if($imageDescription)

                                <p
                                    class="
                                        mt-3
                                        text-sm
                                        leading-6
                                        {{ $textColor['caption'] }}
                                    "
                                >
                                    {{ $imageDescription }}
                                </p>

                            @endif


                        </div>

                    @endif


                </article>


            @endforeach


        </div>


    @endif


</div>


</section>
