@php


$data = is_array($block->data ?? null)
    ? $block->data
    : [];

$settings = is_array($block->settings ?? null)
    ? $block->settings
    : [];

if (($settings['visible'] ?? true) === false) {
    return;
}

$eyebrow = trim((string) ($data['eyebrow'] ?? ''));
$title = trim((string) ($data['title'] ?? ''));
$description = trim((string) ($data['description'] ?? ''));

$features = is_array($data['features'] ?? null)
    ? $data['features']
    : [];

$columns = (int) ($data['columns'] ?? 3);

$columnsClass = match ($columns) {
    2 => 'lg:grid-cols-2',
    4 => 'lg:grid-cols-4',
    default => 'lg:grid-cols-3',
};

$cardStyle = $data['card_style'] ?? 'glass';
$iconStyle = $data['icon_style'] ?? 'gradient';

$container = match ($settings['container'] ?? 'default') {
    'wide' => 'max-w-[1600px]',
    'full' => 'max-w-full',
    default => 'max-w-7xl',
};

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

$backgroundColor = $settings['background']['color'] ?? null;

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

            $backgroundImage = asset(
                'storage/' . $image
            );
        }
    }
}

$customClass = trim(
    (string) ($settings['custom_class'] ?? '')
);

$customCss = (string) (
    $settings['custom_css'] ?? ''
);

$sectionId = trim(
    (string) ($settings['section_id'] ?? '')
);

$textColor = $settings['text_color'] ?? 'dark';

$titleClass = $textColor === 'light'
    ? 'text-white'
    : 'text-gray-950';

$descriptionClass = $textColor === 'light'
    ? 'text-white/70'
    : 'text-gray-600';

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


<div
    class="
        pointer-events-none
        absolute
        inset-0
        -z-20
        bg-gradient-to-br
        from-indigo-50
        via-white
        to-purple-50
    "
    aria-hidden="true"
></div>


<div
    class="
        pointer-events-none
        absolute
        -left-40
        -top-40
        -z-10
        h-[28rem]
        w-[28rem]
        rounded-full
        bg-indigo-400/20
        blur-3xl
    "
    aria-hidden="true"
></div>


<div
    class="
        pointer-events-none
        absolute
        -right-40
        top-1/3
        -z-10
        h-[30rem]
        w-[30rem]
        rounded-full
        bg-purple-400/20
        blur-3xl
    "
    aria-hidden="true"
></div>


<div
    class="
        pointer-events-none
        absolute
        bottom-0
        left-1/3
        -z-10
        h-72
        w-72
        rounded-full
        bg-cyan-400/10
        blur-3xl
    "
    aria-hidden="true"
></div>


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

    @if($eyebrow || $title || $description)

        <div
            class="
                mx-auto
                mb-12
                max-w-3xl
                text-center
                sm:mb-16
            "
        >

            @if($eyebrow)

                <div
                    class="
                        mb-5
                        inline-flex
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-indigo-200/70
                        bg-white/60
                        px-4
                        py-2
                        text-xs
                        font-bold
                        uppercase
                        tracking-[0.18em]
                        text-indigo-600
                        shadow-sm
                        backdrop-blur-xl
                    "
                >

                    <span
                        class="
                            h-2
                            w-2
                            rounded-full
                            bg-indigo-500
                            shadow-[0_0_14px_rgba(99,102,241,0.8)]
                        "
                        aria-hidden="true"
                    ></span>

                    {{ $eyebrow }}

                </div>

            @endif


            @if($title)

                <h2
                    class="
                        text-3xl
                        font-black
                        leading-tight
                        tracking-tight
                        {{ $titleClass }}
                        sm:text-4xl
                        lg:text-5xl
                    "
                >
                    {{ $title }}
                </h2>

            @endif


            @if($description)

                <p
                    class="
                        mx-auto
                        mt-5
                        max-w-2xl
                        text-base
                        leading-7
                        {{ $descriptionClass }}
                        sm:text-lg
                    "
                >
                    {{ $description }}
                </p>

            @endif

        </div>

    @endif


    @if(count($features))

        <div
            class="
                grid
                grid-cols-1
                gap-5
                sm:grid-cols-2
                {{ $columnsClass }}
            "
        >

            @foreach($features as $index => $feature)

                @php

                    $featureTitle = trim(
                        (string) ($feature['title'] ?? '')
                    );

                    $featureDescription = trim(
                        (string) ($feature['description'] ?? '')
                    );

                    $icon = strtolower(
                        trim(
                            (string) ($feature['icon'] ?? '')
                        )
                    );

                    $badge = trim(
                        (string) ($feature['badge'] ?? '')
                    );

                    $accent = strtolower(
                        trim(
                            (string) (
                                $feature['accent'] ?? 'indigo'
                            )
                        )
                    );

                    $featured = ($feature['featured'] ?? false) === true;

                    $visible = ($feature['visible'] ?? true) !== false;

                    $link = trim(
                        (string) ($feature['link'] ?? '')
                    );

                    if (!$visible) {
                        continue;
                    }

                    $accentClasses = match ($accent) {

                        'purple' => [
                            'icon' => 'text-purple-600',
                            'iconBg' => 'from-purple-500/20 to-fuchsia-500/20',
                            'glow' => 'bg-purple-500/20',
                            'badge' => 'text-purple-700 bg-purple-100/70',
                            'line' => 'from-purple-500 to-fuchsia-500',
                        ],

                        'blue' => [
                            'icon' => 'text-blue-600',
                            'iconBg' => 'from-blue-500/20 to-cyan-500/20',
                            'glow' => 'bg-blue-500/20',
                            'badge' => 'text-blue-700 bg-blue-100/70',
                            'line' => 'from-blue-500 to-cyan-500',
                        ],

                        'cyan' => [
                            'icon' => 'text-cyan-600',
                            'iconBg' => 'from-cyan-500/20 to-blue-500/20',
                            'glow' => 'bg-cyan-500/20',
                            'badge' => 'text-cyan-700 bg-cyan-100/70',
                            'line' => 'from-cyan-500 to-blue-500',
                        ],

                        'emerald' => [
                            'icon' => 'text-emerald-600',
                            'iconBg' => 'from-emerald-500/20 to-teal-500/20',
                            'glow' => 'bg-emerald-500/20',
                            'badge' => 'text-emerald-700 bg-emerald-100/70',
                            'line' => 'from-emerald-500 to-teal-500',
                        ],

                        'amber' => [
                            'icon' => 'text-amber-600',
                            'iconBg' => 'from-amber-500/20 to-orange-500/20',
                            'glow' => 'bg-amber-500/20',
                            'badge' => 'text-amber-700 bg-amber-100/70',
                            'line' => 'from-amber-500 to-orange-500',
                        ],

                        'rose' => [
                            'icon' => 'text-rose-600',
                            'iconBg' => 'from-rose-500/20 to-pink-500/20',
                            'glow' => 'bg-rose-500/20',
                            'badge' => 'text-rose-700 bg-rose-100/70',
                            'line' => 'from-rose-500 to-pink-500',
                        ],

                        default => [
                            'icon' => 'text-indigo-600',
                            'iconBg' => 'from-indigo-500/20 to-purple-500/20',
                            'glow' => 'bg-indigo-500/20',
                            'badge' => 'text-indigo-700 bg-indigo-100/70',
                            'line' => 'from-indigo-500 to-purple-500',
                        ],
                    };

                    $cardClasses = match ($cardStyle) {

                        'solid' =>
                            'border-gray-200 bg-white shadow-xl shadow-gray-900/5',

                        'bordered' =>
                            'border-gray-200 bg-white/60 shadow-sm',

                        'minimal' =>
                            'border-transparent bg-transparent shadow-none',

                        'gradient' =>
                            'border-white/40 bg-gradient-to-br from-white/80 via-white/50 to-indigo-50/70 shadow-xl',

                        default =>
                            'border-white/70 bg-white/50 shadow-[0_12px_50px_rgba(31,38,135,0.10)] backdrop-blur-2xl',
                    };

                @endphp


                @if($link)

                    <a
                        href="{{ $link }}"
                        class="
                            group
                            relative
                            block
                            overflow-hidden
                            rounded-3xl
                            border
                            p-6
                            transition-all
                            duration-500
                            hover:-translate-y-2
                            hover:shadow-2xl
                            sm:p-7
                            {{ $cardClasses }}
                            {{ $featured ? 'ring-2 ring-indigo-400/40' : '' }}
                        "
                    >

                @else

                    <div
                        class="
                            group
                            relative
                            overflow-hidden
                            rounded-3xl
                            border
                            p-6
                            transition-all
                            duration-500
                            hover:-translate-y-2
                            hover:shadow-2xl
                            sm:p-7
                            {{ $cardClasses }}
                            {{ $featured ? 'ring-2 ring-indigo-400/40' : '' }}
                        "
                    >

                @endif


                    <div
                        class="
                            pointer-events-none
                            absolute
                            -right-12
                            -top-12
                            h-36
                            w-36
                            rounded-full
                            {{ $accentClasses['glow'] }}
                            opacity-60
                            blur-3xl
                            transition-all
                            duration-700
                            group-hover:scale-150
                            group-hover:opacity-90
                        "
                        aria-hidden="true"
                    ></div>


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
                        "
                        aria-hidden="true"
                    ></div>


                    <div class="relative z-10">

                        <div class="flex items-start justify-between gap-4">

                            @if($icon)

                                <div
                                    class="
                                        flex
                                        h-14
                                        w-14
                                        shrink-0
                                        items-center
                                        justify-center
                                        rounded-2xl
                                        border
                                        border-white/70
                                        bg-gradient-to-br
                                        {{ $accentClasses['iconBg'] }}
                                        {{ $accentClasses['icon'] }}
                                        shadow-lg
                                        backdrop-blur-xl
                                        transition-all
                                        duration-500
                                        group-hover:scale-110
                                        group-hover:rotate-3
                                    "
                                >

                                    @switch($icon)

                                        @case('users')
                                        @case('user')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-.113-.002-.226-.006-.338a9.374 9.374 0 0 0-2.244-5.05M15 19.128a9.37 9.37 0 0 1-3.58-.71M12.75 8.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4.5 19.5a4.5 4.5 0 0 1 9 0"
                                                />
                                            </svg>

                                            @break

                                        @case('shield')
                                        @case('security')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 3l7 3v5c0 4.5-2.8 7.9-7 10-4.2-2.1-7-5.5-7-10V6l7-3Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m9 12 2 2 4-4"
                                                />
                                            </svg>

                                            @break

                                        @case('bolt')
                                        @case('zap')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m13 2-9 12h7l-1 8 9-12h-7l1-8Z"
                                                />
                                            </svg>

                                            @break

                                        @case('chart')
                                        @case('analytics')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 17.25 8.25 12l3.5 3.5L21 6.25"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M16 6.25h5v5"
                                                />
                                            </svg>

                                            @break

                                        @case('cloud')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M7 18h10a4 4 0 0 0 .7-7.94A6 6 0 0 0 6.08 8.2 4 4 0 0 0 7 18Z"
                                                />
                                            </svg>

                                            @break

                                        @case('database')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <ellipse
                                                    cx="12"
                                                    cy="5"
                                                    rx="7"
                                                    ry="3"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 5v7c0 1.66 3.13 3 7 3s7-1.34 7-3V5"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 12v7c0 1.66 3.13 3 7 3s7-1.34 7-3v-7"
                                                />
                                            </svg>

                                            @break

                                        @case('settings')
                                        @case('setting')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9.594 3.94a1.5 1.5 0 0 1 2.812 0l.25.735a1.5 1.5 0 0 0 1.88.932l.737-.239a1.5 1.5 0 0 1 1.987 1.987l-.239.737a1.5 1.5 0 0 0 .932 1.88l.735.25a1.5 1.5 0 0 1 0 2.812l-.735.25a1.5 1.5 0 0 0-.932 1.88l.239.737a1.5 1.5 0 0 1-1.987 1.987l-.737-.239a1.5 1.5 0 0 0-1.88.932l-.25.735a1.5 1.5 0 0 1-2.812 0l-.25-.735a1.5 1.5 0 0 0-1.88-.932l-.737.239a1.5 1.5 0 0 1-1.987-1.987l.239-.737a1.5 1.5 0 0 0-.932-1.88l-.735-.25a1.5 1.5 0 0 1 0-2.812l.735-.25a1.5 1.5 0 0 0 .932-1.88l-.239-.737a1.5 1.5 0 0 1 1.987-1.987l.737.239a1.5 1.5 0 0 0 1.88-.932l.25-.735Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                />
                                            </svg>

                                            @break

                                        @case('check')
                                        @case('success')

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m5 12 4.5 4.5L19 7"
                                                />
                                            </svg>

                                            @break

                                        @default

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-7 w-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 3v18M3 12h18"
                                                />
                                            </svg>

                                    @endswitch

                                </div>

                            @endif


                            @if($badge)

                                <span
                                    class="
                                        rounded-full
                                        px-3
                                        py-1
                                        text-[10px]
                                        font-bold
                                        uppercase
                                        tracking-wider
                                        {{ $accentClasses['badge'] }}
                                    "
                                >
                                    {{ $badge }}
                                </span>

                            @endif

                        </div>


                        @if($featureTitle)

                            <h3
                                class="
                                    relative
                                    mt-7
                                    text-xl
                                    font-extrabold
                                    tracking-tight
                                    text-gray-900
                                    transition-colors
                                    duration-300
                                    group-hover:text-indigo-600
                                "
                            >
                                {{ $featureTitle }}
                            </h3>

                        @endif


                        @if($featureDescription)

                            <p
                                class="
                                    relative
                                    mt-3
                                    text-sm
                                    leading-7
                                    text-gray-600
                                "
                            >
                                {{ $featureDescription }}
                            </p>

                        @endif


                        <div
                            class="
                                mt-7
                                flex
                                items-center
                                justify-between
                            "
                        >

                            <div
                                class="
                                    h-1
                                    w-12
                                    overflow-hidden
                                    rounded-full
                                    bg-gray-200
                                "
                            >

                                <div
                                    class="
                                        h-full
                                        w-0
                                        rounded-full
                                        bg-gradient-to-r
                                        {{ $accentClasses['line'] }}
                                        transition-all
                                        duration-700
                                        group-hover:w-full
                                    "
                                ></div>

                            </div>


                            @if($link)

                                <span
                                    class="
                                        flex
                                        h-9
                                        w-9
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-white/70
                                        text-gray-500
                                        shadow-sm
                                        transition-all
                                        duration-300
                                        group-hover:translate-x-1
                                        group-hover:text-indigo-600
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
                                            d="M13.5 6H18v4.5M18 6l-7.5 7.5"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M18 13.5V18H6V6h4.5"
                                        />
                                    </svg>

                                </span>

                            @endif

                        </div>

                    </div>


                @if($link)

                    </a>

                @else

                    </div>

                @endif

            @endforeach

        </div>

    @else

        <div
            class="
                mx-auto
                max-w-xl
                rounded-3xl
                border
                border-dashed
                border-gray-300
                bg-white/50
                p-10
                text-center
                backdrop-blur-xl
            "
        >

            <div
                class="
                    mx-auto
                    flex
                    h-14
                    w-14
                    items-center
                    justify-center
                    rounded-2xl
                    bg-gray-100
                    text-gray-400
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v18M3 12h18"
                    />
                </svg>

            </div>


            <h3
                class="
                    mt-5
                    text-lg
                    font-bold
                    text-gray-900
                "
            >
                No features available
            </h3>


            <p
                class="
                    mt-2
                    text-sm
                    leading-6
                    text-gray-500
                "
            >
                Add features from the admin panel.
            </p>

        </div>

    @endif

</div>


</section>

@if($customCss)


<style>
    {!! $customCss !!}
</style>


@endif
