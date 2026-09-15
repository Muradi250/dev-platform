
@php  

    $data = $block->data ?? [];
    $settings = $block->settings ?? [];

    /*
    |--------------------------------------------------------------------------
    | Visibility
    |--------------------------------------------------------------------------
    */

    if (($settings['visible'] ?? true) === false) {
        return;
    }


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
    | Desktop / Mobile Padding
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Text Color
    |--------------------------------------------------------------------------
    */

    $textColor = $settings['text_color'] ?? 'dark';

    $titleClass = $textColor === 'light'
        ? 'text-white'
        : 'text-gray-900';

    $descriptionClass = $textColor === 'light'
        ? 'text-gray-200'
        : 'text-gray-600';


    /*
    |--------------------------------------------------------------------------
    | Background
    |--------------------------------------------------------------------------
    */

    $backgroundColor = $settings['background']['color'] ?? null;

    $backgroundImage = null;

    if (!empty($settings['background']['image'])) {

        $image = $settings['background']['image'];

        if (is_array($image)) {
            $image = reset($image);
        }

        $image = str_replace('livewire-file:', '', $image);

        $backgroundImage = asset(
            'storage/' . ltrim($image, '/')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Settings
    |--------------------------------------------------------------------------
    */

    $customClass = $settings['custom_class'] ?? '';
    $customCss = $settings['custom_css'] ?? '';

    $sectionId = $settings['section_id'] ?? null;


    /*
    |--------------------------------------------------------------------------
    | Content
    |--------------------------------------------------------------------------
    */

    $title = $data['title'] ?? null;

    $description = $data['description'] ?? null;

    $logos = $data['logos'] ?? [];


    /*
    |--------------------------------------------------------------------------
    | Logo Image URL
    |--------------------------------------------------------------------------
    |
    | Filament stores the file path like:
    |
    | blocks/logos/example.png
    |
    | The public URL becomes:
    |
    | /storage/blocks/logos/example.png
    |
    |--------------------------------------------------------------------------
    */

    $logoUrl = function ($image) {

        if (empty($image)) {
            return null;
        }

        if (is_array($image)) {
            $image = reset($image);
        }

        $image = str_replace('livewire-file:', '', $image);

        /*
        | Already a full URL
        */

        if (
            str_starts_with($image, 'http://') ||
            str_starts_with($image, 'https://') ||
            str_starts_with($image, '//')
        ) {
            return $image;
        }

        /*
        | Remove unnecessary prefixes
        */

        $image = ltrim($image, '/');

        $image = preg_replace(
            '#^(storage/|public/)#',
            '',
            $image
        );

        /*
        | Final public storage URL
        */

        return asset('storage/' . $image);
    };

@endphp


<section
    @if($sectionId)
        id="{{ $sectionId }}"
    @endif

    class="relative overflow-hidden {{ $desktopPadding }} {{ $mobilePadding }} {{ $customClass }}"

    @if($backgroundColor)
        style="background-color: {{ $backgroundColor }};"
    @elseif($backgroundImage)
        style="
            background-image: url('{{ $backgroundImage }}');
            background-size: cover;
            background-position: {{ $settings['background']['position'] ?? 'center' }};
        "
    @endif
>


    {{-- Background Overlay --}}

    @if($backgroundImage && ($settings['background']['overlay'] ?? false))

        <div
            class="absolute inset-0 bg-black/30 pointer-events-none"
        ></div>

    @endif


    <div
        class="relative mx-auto w-full {{ $container }} px-6 lg:px-8"
    >


        {{-- Section Header --}}

        @if($title || $description)

            <div class="mx-auto mb-12 max-w-2xl text-center">

                @if($title)

                    <h2
                        class="text-3xl font-bold tracking-tight sm:text-4xl {{ $titleClass }}"
                    >
                        {{ $title }}
                    </h2>

                @endif


                @if($description)

                    <p
                        class="mx-auto mt-4 max-w-xl text-base leading-7 sm:text-lg {{ $descriptionClass }}"
                    >
                        {{ $description }}
                    </p>

                @endif

            </div>

        @endif


        {{-- Logos --}}

        @if(!empty($logos))

            <div
                class="
                    grid
                    grid-cols-2
                    items-center
                    gap-6
                    sm:grid-cols-3
                    md:grid-cols-4
                    lg:grid-cols-5
                "
            >

                @foreach($logos as $logo)

                    @php

                        $name = $logo['name'] ?? 'Company';

                        $image = $logo['image'] ?? null;

                        $url = $logo['url'] ?? null;

                        $imageUrl = $logoUrl($image);

                    @endphp


                    @if($imageUrl)

                        @if($url)

                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="
                                    group
                                    flex
                                    min-h-24
                                    items-center
                                    justify-center
                                    rounded-2xl
                                    border
                                    border-gray-200/70
                                    bg-white/70
                                    p-6
                                    shadow-sm
                                    backdrop-blur
                                    transition
                                    duration-300
                                    hover:-translate-y-1
                                    hover:bg-white
                                    hover:shadow-lg
                                "
                            >

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $name }}"
                                    title="{{ $name }}"
                                    loading="lazy"
                                    class="
                                        max-h-12
                                        max-w-[150px]
                                        object-contain
                                        opacity-70
                                        grayscale
                                        transition
                                        duration-300
                                        group-hover:opacity-100
                                        group-hover:grayscale-0
                                    "
                                >

                            </a>

                        @else

                            <div
                                class="
                                    group
                                    flex
                                    min-h-24
                                    items-center
                                    justify-center
                                    rounded-2xl
                                    border
                                    border-gray-200/70
                                    bg-white/70
                                    p-6
                                    shadow-sm
                                    backdrop-blur
                                    transition
                                    duration-300
                                    hover:-translate-y-1
                                    hover:bg-white
                                    hover:shadow-lg
                                "
                            >

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $name }}"
                                    title="{{ $name }}"
                                    loading="lazy"
                                    class="
                                        max-h-12
                                        max-w-[150px]
                                        object-contain
                                        opacity-70
                                        grayscale
                                        transition
                                        duration-300
                                        group-hover:opacity-100
                                        group-hover:grayscale-0
                                    "
                                >

                            </div>

                        @endif

                    @endif

                @endforeach

            </div>

        @endif


    </div>

</section>


@if($customCss)

    <style>
        {!! $customCss !!}
    </style>

@endif

