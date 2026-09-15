
@php

$data = $block->data ?? [];
$settings = $block->settings ?? [];

if (($settings['visible'] ?? true) === false) {
    return;
}

$container = match ($settings['container'] ?? 'default') {
    'wide' => 'max-w-[1600px]',
    'full' => 'max-w-full',
    default => 'max-w-7xl',
};

$desktopPadding = match ($settings['padding'] ?? 'medium') {
    'none' => 'py-0',
    'small' => 'py-10',
    'large' => 'py-32',
    default => 'py-20',
};

$mobilePadding = match ($settings['mobile_padding'] ?? 'medium') {
    'none' => 'py-0',
    'small' => 'py-8',
    'large' => 'py-20',
    default => 'py-14',
};

$textColor = $settings['text_color'] ?? 'dark';

$titleClass = $textColor === 'light'
    ? 'text-white'
    : 'text-gray-900';

$descriptionClass = $textColor === 'light'
    ? 'text-gray-200'
    : 'text-gray-600';

$backgroundColor = $settings['background']['color'] ?? null;
$backgroundImage = null;

if (!empty($settings['background']['image'])) {

    $image = $settings['background']['image'];

    if (is_array($image)) {
        $image = reset($image);
    }

    $image = str_replace('livewire-file:', '', $image);

    if (
        str_starts_with($image, 'http://') ||
        str_starts_with($image, 'https://') ||
        str_starts_with($image, '//')
    ) {
        $backgroundImage = $image;
    } else {

        $image = ltrim($image, '/');

        $image = preg_replace(
            '#^(storage/|public/)#',
            '',
            $image
        );

        $backgroundImage = asset('storage/' . $image);
    }
}

$customClass = $settings['custom_class'] ?? '';
$customCss = $settings['custom_css'] ?? '';
$sectionId = $settings['section_id'] ?? null;

$title = $data['title'] ?? null;
$description = $data['description'] ?? null;
$videoUrl = $data['video_url'] ?? null;
$thumbnail = $data['thumbnail'] ?? null;
$provider = strtolower(trim($data['provider'] ?? ''));

$thumbnailUrl = null;

if (!empty($thumbnail)) {

    if (is_array($thumbnail)) {
        $thumbnail = reset($thumbnail);
    }

    $thumbnail = str_replace('livewire-file:', '', $thumbnail);

    if (
        str_starts_with($thumbnail, 'http://') ||
        str_starts_with($thumbnail, 'https://') ||
        str_starts_with($thumbnail, '//')
    ) {
        $thumbnailUrl = $thumbnail;
    } else {

        $thumbnail = ltrim($thumbnail, '/');

        $thumbnail = preg_replace(
            '#^(storage/|public/)#',
            '',
            $thumbnail
        );

        $thumbnailUrl = asset('storage/' . $thumbnail);
    }
}

$embedUrl = null;

/*
|--------------------------------------------------------------------------
| VIDEO PROVIDER DETECTION
|--------------------------------------------------------------------------
|
| اگر Provider از فرم ارسال نشده باشد، از روی URL تشخیص می‌دهیم.
|
|--------------------------------------------------------------------------
*/

if ($videoUrl) {

    if ($provider === '') {

        if (
            str_contains($videoUrl, 'youtube.com') ||
            str_contains($videoUrl, 'youtu.be')
        ) {
            $provider = 'youtube';

        } elseif (str_contains($videoUrl, 'vimeo.com')) {
            $provider = 'vimeo';

        } elseif (
            str_contains($videoUrl, 'aparat.com') ||
            str_contains($videoUrl, 'aparat.ir')
        ) {
            $provider = 'aparat';

        } else {
            $provider = 'custom';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | YOUTUBE
    |--------------------------------------------------------------------------
    */

    if ($provider === 'youtube') {

        if (
            preg_match(
                '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([^&?\/]+)/',
                $videoUrl,
                $matches
            )
        ) {
            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VIMEO
    |--------------------------------------------------------------------------
    */

    elseif ($provider === 'vimeo') {

        if (
            preg_match(
                '/vimeo\.com\/(?:video\/)?([0-9]+)/',
                $videoUrl,
                $matches
            )
        ) {
            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | APARAT
    |--------------------------------------------------------------------------
    |
    | مثال:
    |
    | https://www.aparat.com/v/XXXXX
    |
    | تبدیل می‌شود به:
    |
    | https://www.aparat.com/video/video/embed/videohash/XXXXX
    |
    |--------------------------------------------------------------------------
    */

    elseif ($provider === 'aparat') {

        if (
            preg_match(
                '#aparat\.(?:com|ir)/(?:v|video)/([^/?]+)#i',
                $videoUrl,
                $matches
            )
        ) {
            $embedUrl = 'https://www.aparat.com/video/video/embed/videohash/' . $matches[1];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOM EMBED
    |--------------------------------------------------------------------------
    */

    elseif ($provider === 'custom') {

        $embedUrl = $videoUrl;
    }
}

@endphp


<section
    @if($sectionId)
        id="{{ $sectionId }}"
    @endif
    class="relative overflow-hidden {{ $desktopPadding }} {{ $mobilePadding }} {{ $customClass }}"
    @if($backgroundColor)
        style="background-color: {{ $backgroundColor }};"
    @elseif($backgroundImage)
        style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: {{ $settings['background']['position'] ?? 'center' }};"
    @endif
>

    @if($backgroundImage && ($settings['background']['overlay'] ?? false))

        <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>

    @endif


    <div class="relative mx-auto w-full {{ $container }} px-6 lg:px-8">


        @if($title || $description)

            <div class="mx-auto mb-12 max-w-3xl text-center">

                @if($title)

                    <h2
                        class="text-3xl font-bold tracking-tight sm:text-4xl {{ $titleClass }}"
                    >
                        {{ $title }}
                    </h2>

                @endif


                @if($description)

                    <p
                        class="mx-auto mt-4 max-w-2xl text-base leading-7 sm:text-lg {{ $descriptionClass }}"
                    >
                        {{ $description }}
                    </p>

                @endif

            </div>

        @endif


        @if($embedUrl)

            <div class="mx-auto max-w-5xl">

                <div class="relative overflow-hidden rounded-3xl border border-gray-200/70 bg-black shadow-2xl">

                    <div class="aspect-video">

                        <iframe
                            src="{{ $embedUrl }}"
                            title="{{ $title ?? 'Video' }}"
                            class="h-full w-full"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                    </div>

                </div>

            </div>


        @elseif($provider === 'custom' && $videoUrl)

            <div class="mx-auto max-w-5xl">

                <div class="overflow-hidden rounded-3xl border border-gray-200/70 bg-black shadow-2xl">

                    <video
                        controls
                        preload="metadata"
                        class="w-full"
                        @if($thumbnailUrl)
                            poster="{{ $thumbnailUrl }}"
                        @endif
                    >

                        <source src="{{ $videoUrl }}">

                        Your browser does not support the video element.

                    </video>

                </div>

            </div>


        @elseif($thumbnailUrl)

            <div class="mx-auto max-w-5xl">

                <div class="overflow-hidden rounded-3xl border border-gray-200/70 bg-gray-100 shadow-2xl">

                    <img
                        src="{{ $thumbnailUrl }}"
                        alt="{{ $title ?? 'Video thumbnail' }}"
                        title="{{ $title ?? 'Video thumbnail' }}"
                        loading="lazy"
                        class="h-auto w-full object-cover"
                    >

                </div>

            </div>


        @elseif($videoUrl)

            <div class="mx-auto max-w-5xl">

                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-8 text-center">

                    <a
                        href="{{ $videoUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-700"
                    >
                        Watch Video
                    </a>

                </div>

            </div>

        @endif


    </div>

</section>


@if($customCss)

    <style>
        {!! $customCss !!}
    </style>

@endif

