@php


$data = is_array($block->data ?? null)
    ? $block->data
    : [];

$settings = is_array($block->settings ?? null)
    ? $block->settings
    : [];


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
| Content
|--------------------------------------------------------------------------
*/

$title = trim((string) ($data['title'] ?? ''));

$description = trim(
    (string) ($data['description'] ?? '')
);

$members = is_array($data['members'] ?? null)
    ? $data['members']
    : [];


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
| Padding
|--------------------------------------------------------------------------
*/

$desktopPadding = match ($settings['padding'] ?? 'medium') {
    'none' => 'md:py-0',
    'small' => 'md:py-10',
    'large' => 'md:py-32',
    default => 'md:py-20',
};

$mobilePadding = match ($settings['mobile_padding'] ?? 'medium') {
    'none' => 'py-0',
    'small' => 'py-8',
    'large' => 'py-20',
    default => 'py-14',
};


/*
|--------------------------------------------------------------------------
| Background
|--------------------------------------------------------------------------
*/

$backgroundColor =
    $settings['background']['color'] ?? null;

$backgroundImage = null;

if (!empty($settings['background']['image'])) {

    $image = $settings['background']['image'];

    if (is_array($image)) {
        $image = reset($image);
    }

    if (is_string($image) && $image !== '') {

        $image = str_replace(
            'livewire-file:',
            '',
            $image
        );

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

            $backgroundImage =
                asset('storage/' . $image);
        }
    }
}


/*
|--------------------------------------------------------------------------
| Custom Settings
|--------------------------------------------------------------------------
*/

$customClass = trim(
    (string) ($settings['custom_class'] ?? '')
);

$customCss = (string) (
    $settings['custom_css'] ?? ''
);

$sectionId = trim(
    (string) ($settings['section_id'] ?? '')
);


/*
|--------------------------------------------------------------------------
| Text Color
|--------------------------------------------------------------------------
*/

$textColor =
    $settings['text_color'] ?? 'dark';

$titleClass =
    $textColor === 'light'
        ? 'text-white'
        : 'text-gray-950';

$descriptionClass =
    $textColor === 'light'
        ? 'text-white/70'
        : 'text-gray-600';


/*
|--------------------------------------------------------------------------
| Section Style
|--------------------------------------------------------------------------
*/

$sectionStyle = '';

if ($backgroundColor) {

    $sectionStyle .=
        'background-color:' .
        e($backgroundColor) .
        ';';
}

if ($backgroundImage) {

    $sectionStyle .=
        'background-image:url("' .
        e($backgroundImage) .
        '");';

    $sectionStyle .=
        'background-size:cover;';

    $sectionStyle .=
        'background-position:center;';
}


@endphp

<section
    @if($sectionId)
        id="{{ $sectionId }}"
    @endif


class="
    team-block
    relative
    isolate
    overflow-hidden
    {{ $mobilePadding }}
    {{ $desktopPadding }}
    {{ $customClass }}
"

@if($sectionStyle)
    style="{{ $sectionStyle }}"
@endif


>

{{-- ================================================================
    BACKGROUND SYSTEM
================================================================= --}}

<div
    class="
        pointer-events-none
        absolute
        inset-0
        -z-20
        bg-gradient-to-br
        from-slate-50
        via-white
        to-indigo-50
    "
    aria-hidden="true"
></div>


{{-- Top glow --}}

<div
    class="
        pointer-events-none
        absolute
        -left-40
        -top-40
        -z-10
        h-[32rem]
        w-[32rem]
        rounded-full
        bg-indigo-400/20
        blur-[100px]
    "
    aria-hidden="true"
></div>


{{-- Right glow --}}

<div
    class="
        pointer-events-none
        absolute
        -right-40
        top-1/4
        -z-10
        h-[34rem]
        w-[34rem]
        rounded-full
        bg-purple-400/20
        blur-[110px]
    "
    aria-hidden="true"
></div>


{{-- Bottom glow --}}

<div
    class="
        pointer-events-none
        absolute
        bottom-[-10rem]
        left-1/3
        -z-10
        h-[28rem]
        w-[28rem]
        rounded-full
        bg-cyan-400/10
        blur-[100px]
    "
    aria-hidden="true"
></div>


{{-- ================================================================
    CONTAINER
================================================================= --}}

<div
    class="
        relative
        z-10
        mx-auto
        w-full
        {{ $container }}
        px-5
        sm:px-6
        lg:px-8
    "
>


    {{-- ============================================================
        HEADER
    ============================================================= --}}

    @if($title || $description)

        <div
            class="
                mx-auto
                mb-12
                max-w-4xl
                text-center
                sm:mb-16
                lg:mb-20
            "
        >


            {{-- Eyebrow --}}

            <div
                class="
                    mb-5
                    inline-flex
                    items-center
                    gap-3
                    rounded-full
                    border
                    border-white/70
                    bg-white/60
                    px-4
                    py-2
                    shadow-lg
                    shadow-indigo-500/5
                    backdrop-blur-xl
                "
            >

                <span
                    class="
                        relative
                        flex
                        h-2.5
                        w-2.5
                    "
                >

                    <span
                        class="
                            absolute
                            inline-flex
                            h-full
                            w-full
                            animate-ping
                            rounded-full
                            bg-indigo-400
                            opacity-60
                        "
                    ></span>

                    <span
                        class="
                            relative
                            inline-flex
                            h-2.5
                            w-2.5
                            rounded-full
                            bg-indigo-600
                        "
                    ></span>

                </span>


                <span
                    class="
                        text-[11px]
                        font-bold
                        uppercase
                        tracking-[0.2em]
                        text-indigo-600
                    "
                >
                    Our Team
                </span>

            </div>


            {{-- Title --}}

            @if($title)

                <h2
                    class="
                        text-4xl
                        font-black
                        tracking-tight
                        {{ $titleClass }}
                        sm:text-5xl
                        lg:text-6xl
                    "
                >
                    {{ $title }}
                </h2>

            @endif


            {{-- Description --}}

            @if($description)

                <p
                    class="
                        mx-auto
                        mt-5
                        max-w-2xl
                        text-base
                        leading-8
                        {{ $descriptionClass }}
                        sm:text-lg
                    "
                >
                    {{ $description }}
                </p>

            @endif


            {{-- Header accent --}}

            <div
                class="
                    mx-auto
                    mt-7
                    flex
                    items-center
                    justify-center
                    gap-2
                "
                aria-hidden="true"
            >

                <span
                    class="
                        h-1
                        w-10
                        rounded-full
                        bg-indigo-200
                    "
                ></span>

                <span
                    class="
                        h-1
                        w-20
                        rounded-full
                        bg-gradient-to-r
                        from-indigo-500
                        to-purple-500
                    "
                ></span>

                <span
                    class="
                        h-1
                        w-10
                        rounded-full
                        bg-purple-200
                    "
                ></span>

            </div>

        </div>

    @endif


    {{-- ============================================================
        TEAM GRID
    ============================================================= --}}

    @if(count($members))

        <div
            class="
                grid
                grid-cols-1
                gap-7
                sm:grid-cols-2
                lg:grid-cols-3
            "
        >


            @foreach($members as $index => $member)

                @php

                    $name = trim(
                        (string) ($member['name'] ?? '')
                    );

                    $position = trim(
                        (string) ($member['position'] ?? '')
                    );

                    $bio = trim(
                        (string) ($member['bio'] ?? '')
                    );

                    $image = $member['image'] ?? null;

                    if (is_array($image)) {
                        $image = reset($image);
                    }

                    $imageUrl = null;

                    if (
                        is_string($image) &&
                        $image !== ''
                    ) {

                        $image = str_replace(
                            'livewire-file:',
                            '',
                            $image
                        );

                        if (
                            str_starts_with($image, 'http://') ||
                            str_starts_with($image, 'https://') ||
                            str_starts_with($image, '//')
                        ) {

                            $imageUrl = $image;

                        } else {

                            $image = ltrim(
                                $image,
                                '/'
                            );

                            $image = preg_replace(
                                '#^(storage/|public/)#',
                                '',
                                $image
                            );

                            $imageUrl =
                                asset(
                                    'storage/' . $image
                                );
                        }
                    }

                @endphp


                {{-- =================================================
                    TEAM CARD
                ================================================== --}}

                <article
                    class="
                        group
                        relative
                        overflow-hidden
                        rounded-[2rem]
                        border
                        border-white/70
                        bg-white/55
                        shadow-[0_20px_70px_rgba(30,41,59,0.10)]
                        backdrop-blur-2xl
                        transition-all
                        duration-700
                        ease-out
                        hover:-translate-y-3
                        hover:shadow-[0_35px_90px_rgba(79,70,229,0.18)]
                    "
                >


                    {{-- Card Glow --}}

                    <div
                        class="
                            pointer-events-none
                            absolute
                            -right-20
                            -top-20
                            h-48
                            w-48
                            rounded-full
                            bg-indigo-400/10
                            blur-3xl
                            transition-all
                            duration-700
                            group-hover:bg-indigo-400/25
                        "
                        aria-hidden="true"
                    ></div>


                    {{-- =================================================
                        IMAGE
                    ================================================== --}}

                    <div
                        class="
                            relative
                            aspect-[4/4.2]
                            overflow-hidden
                        "
                    >

                        @if($imageUrl)

                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $name ?: 'Team member' }}"
                                loading="lazy"
                                class="
                                    h-full
                                    w-full
                                    object-cover
                                    object-center
                                    transition-transform
                                    duration-700
                                    ease-out
                                    group-hover:scale-110
                                "
                            >

                        @else

                            {{-- Placeholder --}}

                            <div
                                class="
                                    flex
                                    h-full
                                    w-full
                                    items-center
                                    justify-center
                                    bg-gradient-to-br
                                    from-indigo-100
                                    via-white
                                    to-purple-100
                                "
                            >

                                <div
                                    class="
                                        flex
                                        h-28
                                        w-28
                                        items-center
                                        justify-center
                                        rounded-full
                                        border
                                        border-white/80
                                        bg-white/60
                                        text-indigo-400
                                        shadow-xl
                                        backdrop-blur-xl
                                    "
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-14 w-14"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"
                                        />
                                    </svg>

                                </div>

                            </div>

                        @endif


                        {{-- Image gradient --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-0
                                bg-gradient-to-t
                                from-slate-950/70
                                via-transparent
                                to-transparent
                                opacity-70
                            "
                        ></div>


                        {{-- Top glass line --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                top-0
                                h-px
                                bg-gradient-to-r
                                from-transparent
                                via-white
                                to-transparent
                                opacity-80
                            "
                        ></div>


                        {{-- Member number --}}

                        <div
                            class="
                                absolute
                                left-5
                                top-5
                                flex
                                h-10
                                w-10
                                items-center
                                justify-center
                                rounded-xl
                                border
                                border-white/40
                                bg-black/20
                                text-xs
                                font-bold
                                text-white
                                shadow-lg
                                backdrop-blur-xl
                            "
                            aria-hidden="true"
                        >
                            {{ sprintf('%02d', $index + 1) }}
                        </div>


                        {{-- Position badge --}}

                        @if($position)

                            <div
                                class="
                                    absolute
                                    bottom-5
                                    left-5
                                    max-w-[calc(100%-2.5rem)]
                                    rounded-full
                                    border
                                    border-white/30
                                    bg-black/25
                                    px-4
                                    py-2
                                    text-xs
                                    font-semibold
                                    text-white
                                    shadow-lg
                                    backdrop-blur-xl
                                "
                            >
                                {{ $position }}
                            </div>

                        @endif


                        {{-- Hover shine --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-y-0
                                -left-full
                                w-1/2
                                skew-x-[-20deg]
                                bg-gradient-to-r
                                from-transparent
                                via-white/30
                                to-transparent
                                transition-all
                                duration-1000
                                group-hover:left-[130%]
                            "
                            aria-hidden="true"
                        ></div>

                    </div>


                    {{-- =================================================
                        CONTENT
                    ================================================== --}}

                    <div
                        class="
                            relative
                            p-6
                            sm:p-7
                        "
                    >

                        @if($name)

                            <h3
                                class="
                                    text-xl
                                    font-black
                                    tracking-tight
                                    text-gray-950
                                    transition-colors
                                    duration-300
                                    group-hover:text-indigo-600
                                    sm:text-2xl
                                "
                            >
                                {{ $name }}
                            </h3>

                        @endif


                        @if($position)

                            <div
                                class="
                                    mt-2
                                    flex
                                    items-center
                                    gap-2
                                "
                            >

                                <span
                                    class="
                                        h-1.5
                                        w-1.5
                                        rounded-full
                                        bg-indigo-500
                                    "
                                ></span>

                                <span
                                    class="
                                        text-sm
                                        font-semibold
                                        text-indigo-600
                                    "
                                >
                                    {{ $position }}
                                </span>

                            </div>

                        @endif


                        @if($bio)

                            <p
                                class="
                                    mt-4
                                    line-clamp-3
                                    text-sm
                                    leading-7
                                    text-gray-500
                                "
                            >
                                {{ $bio }}
                            </p>

                        @endif


                        {{-- Bottom divider --}}

                        <div
                            class="
                                mt-6
                                flex
                                items-center
                                justify-between
                            "
                        >

                            <div
                                class="
                                    h-px
                                    flex-1
                                    bg-gradient-to-r
                                    from-indigo-100
                                    via-purple-100
                                    to-transparent
                                "
                            ></div>


                            <div
                                class="
                                    ml-4
                                    flex
                                    h-9
                                    w-9
                                    items-center
                                    justify-center
                                    rounded-xl
                                    border
                                    border-indigo-100
                                    bg-indigo-50/70
                                    text-indigo-500
                                    transition-all
                                    duration-300
                                    group-hover:rotate-45
                                    group-hover:bg-indigo-600
                                    group-hover:text-white
                                "
                                aria-hidden="true"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="h-4 w-4"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m13.5 6 6 6-6 6M4.5 12h15"
                                    />
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- Bottom accent --}}

                    <div
                        class="
                            absolute
                            inset-x-8
                            bottom-0
                            h-1
                            origin-left
                            scale-x-0
                            rounded-full
                            bg-gradient-to-r
                            from-indigo-500
                            via-purple-500
                            to-cyan-400
                            transition-transform
                            duration-500
                            group-hover:scale-x-100
                        "
                        aria-hidden="true"
                    ></div>

                </article>

            @endforeach

        </div>


    @else

        {{-- =========================================================
            EMPTY STATE
        ========================================================== --}}

        <div
            class="
                mx-auto
                max-w-xl
                rounded-[2rem]
                border
                border-dashed
                border-gray-300/70
                bg-white/50
                p-12
                text-center
                shadow-lg
                backdrop-blur-xl
            "
        >

            <div
                class="
                    mx-auto
                    flex
                    h-16
                    w-16
                    items-center
                    justify-center
                    rounded-2xl
                    bg-indigo-50
                    text-indigo-400
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-8 w-8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"
                    />
                </svg>

            </div>


            <h3
                class="
                    mt-5
                    text-xl
                    font-bold
                    text-gray-900
                "
            >
                No team members available
            </h3>


            <p
                class="
                    mt-2
                    text-sm
                    leading-7
                    text-gray-500
                "
            >
                Add team members from the admin panel.
            </p>

        </div>

    @endif

</div>


</section>

{{-- ================================================================
CUSTOM CSS
================================================================= --}}

@if($customCss)


<style>
    {!! $customCss !!}
</style>


@endif
