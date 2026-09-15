
@php

    /*
    |--------------------------------------------------------------------------
    | Statistics Block
    |--------------------------------------------------------------------------
    */

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

    $statistics = is_array($data['statistics'] ?? null)
        ? $data['statistics']
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

    $backgroundColor = $settings['background']['color'] ?? null;

    $backgroundImage = null;

    if (!empty($settings['background']['image'])) {

        $image = $settings['background']['image'];

        if (is_array($image)) {
            $image = reset($image);
        }

        if (is_string($image) && $image !== '') {

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
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Settings
    |--------------------------------------------------------------------------
    */

    $customClass = trim((string) ($settings['custom_class'] ?? ''));

    $customCss = (string) ($settings['custom_css'] ?? '');

    $sectionId = trim((string) ($settings['section_id'] ?? ''));


    /*
    |--------------------------------------------------------------------------
    | Text Color
    |--------------------------------------------------------------------------
    */

    $textColor = $settings['text_color'] ?? 'dark';

    $titleClass = $textColor === 'light'
        ? 'text-white'
        : 'text-slate-900';


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

        $sectionStyle .= 'background-size:cover;';
        $sectionStyle .= 'background-position:center;';
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

    {{-- ==============================================================
        BACKGROUND
    ============================================================== --}}

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


    {{-- Large decorative glow --}}

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
            bg-indigo-500/10
            blur-[100px]
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
            bg-purple-500/10
            blur-[110px]
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
            h-80
            w-80
            rounded-full
            bg-cyan-400/10
            blur-[100px]
        "
        aria-hidden="true"
    ></div>


    {{-- ==============================================================
        CONTAINER
    ============================================================== --}}

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


        {{-- ==========================================================
            HEADER
        =========================================================== --}}

        @if($title)

            <div
                class="
                    mx-auto
                    mb-12
                    max-w-3xl
                    text-center
                    sm:mb-16
                "
            >

                {{-- Header badge --}}

                <div
                    class="
                        mx-auto
                        mb-5
                        inline-flex
                        items-center
                        gap-2.5
                        rounded-full
                        border
                        border-indigo-100
                        bg-white/70
                        px-4
                        py-2
                        text-xs
                        font-bold
                        uppercase
                        tracking-[0.18em]
                        text-indigo-600
                        shadow-[0_8px_30px_rgba(79,70,229,0.08)]
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

                    <span>
                        Platform Statistics
                    </span>

                </div>


                {{-- Header title --}}

                <h2
                    class="
                        bg-gradient-to-r
                        from-slate-950
                        via-indigo-700
                        to-purple-700
                        bg-clip-text
                        text-4xl
                        font-black
                        leading-tight
                        tracking-tight
                        text-transparent
                        sm:text-5xl
                        lg:text-6xl
                    "
                >
                    {{ $title }}
                </h2>


                {{-- Header line --}}

                <div
                    class="
                        mx-auto
                        mt-6
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
                            bg-indigo-500
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
                            bg-purple-500
                        "
                    ></span>

                </div>

            </div>

        @endif


        {{-- ==========================================================
            STATISTICS GRID
        =========================================================== --}}

        @if(count($statistics))

            <div
                class="
                    grid
                    grid-cols-1
                    gap-5
                    sm:grid-cols-2
                    lg:grid-cols-4
                "
            >

                @foreach($statistics as $index => $stat)

                    @php

                        $value = trim(
                            (string) ($stat['value'] ?? '')
                        );

                        $label = trim(
                            (string) ($stat['label'] ?? '')
                        );

                        $icon = strtolower(
                            trim(
                                (string) ($stat['icon'] ?? '')
                            )
                        );

                    @endphp


                    {{-- ==================================================
                        STATISTIC CARD
                    =================================================== --}}

                    <div
                        class="
                            group
                            relative
                            overflow-hidden
                            rounded-[2rem]
                            border
                            border-white/80
                            bg-white/65
                            p-6
                            shadow-[0_15px_50px_rgba(15,23,42,0.08)]
                            backdrop-blur-2xl
                            transition-all
                            duration-500
                            ease-out
                            hover:-translate-y-2
                            hover:border-indigo-100
                            hover:bg-white/85
                            hover:shadow-[0_25px_70px_rgba(79,70,229,0.16)]
                            sm:p-7
                        "
                    >

                        {{-- Top shine --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                inset-x-0
                                top-0
                                h-px
                                bg-gradient-to-r
                                from-transparent
                                via-indigo-300
                                to-transparent
                                opacity-60
                            "
                        ></div>


                        {{-- Card glow --}}

                        <div
                            class="
                                pointer-events-none
                                absolute
                                -right-12
                                -top-12
                                h-36
                                w-36
                                rounded-full
                                bg-indigo-500/10
                                blur-3xl
                                transition-all
                                duration-500
                                group-hover:scale-150
                                group-hover:bg-purple-500/15
                            "
                        ></div>


                        {{-- Card number --}}

                        <div
                            class="
                                absolute
                                right-6
                                top-5
                                text-[10px]
                                font-black
                                tracking-[0.2em]
                                text-slate-300
                            "
                            aria-hidden="true"
                        >
                            {{ sprintf('%02d', $index + 1) }}
                        </div>


                        {{-- ==================================================
                            ICON
                        =================================================== --}}

                        <div
                            class="
                                relative
                                mb-6
                                flex
                                h-16
                                w-16
                                items-center
                                justify-center
                                rounded-2xl
                                border
                                border-indigo-100
                                bg-gradient-to-br
                                from-indigo-50
                                to-purple-50
                                text-indigo-600
                                shadow-[0_10px_30px_rgba(79,70,229,0.10)]
                                transition-all
                                duration-500
                                group-hover:scale-110
                                group-hover:rotate-3
                                group-hover:shadow-[0_15px_35px_rgba(79,70,229,0.18)]
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
                                        aria-hidden="true"
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


                                @case('cube')
                                @case('box')
                                @case('modules')
                                @case('module')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m21 16-9 5-9-5V8l9-5 9 5v8Z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m3 8 9 5 9-5M12 13v8"
                                        />
                                    </svg>

                                    @break


                                @case('countries')
                                @case('globe')
                                @case('world')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.6 9h16.8M3.6 15h16.8M12 3c2.2 2.4 3.3 5.4 3.3 9s-1.1 6.6-3.3 9c-2.2-2.4-3.3-5.4-3.3-9S9.8 5.4 12 3Z"
                                        />
                                    </svg>

                                    @break


                                @case('projects')
                                @case('project')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.75 6.75h16.5v12.5H3.75z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 6.75V5.5A1.75 1.75 0 0 1 9.75 3.75h4.5A1.75 1.75 0 0 1 16 5.5v1.25"
                                        />
                                    </svg>

                                    @break


                                @case('growth')
                                @case('chart')
                                @case('analytics')
                                @case('trend')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
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


                                @case('check')
                                @case('success')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m5 12 4.5 4.5L19 7"
                                        />
                                    </svg>

                                    @break


                                @case('setting')
                                @case('settings')
                                @case('cog')

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
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


                                @default

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor"
                                        class="h-7 w-7"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 13.5 9 7l4 4 8-8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 3v6h-6"
                                        />
                                    </svg>

                                    @break

                            @endswitch

                        </div>


                        {{-- ==================================================
                            VALUE
                        =================================================== --}}

                        @if($value)

                            <div
                                class="
                                    relative
                                    text-4xl
                                    font-black
                                    tracking-tight
                                    text-slate-900
                                    transition-all
                                    duration-300
                                    group-hover:text-indigo-600
                                    sm:text-5xl
                                "
                            >
                                {{ $value }}
                            </div>

                        @endif


                        {{-- ==================================================
                            LABEL
                        =================================================== --}}

                        @if($label)

                            <div
                                class="
                                    relative
                                    mt-2
                                    text-sm
                                    font-semibold
                                    leading-6
                                    text-slate-500
                                "
                            >
                                {{ $label }}
                            </div>

                        @endif


                        {{-- Bottom accent --}}

                        <div
                            class="
                                relative
                                mt-7
                                h-1
                                w-12
                                overflow-hidden
                                rounded-full
                                bg-indigo-100
                            "
                        >

                            <div
                                class="
                                    h-full
                                    w-3/5
                                    rounded-full
                                    bg-gradient-to-r
                                    from-indigo-500
                                    to-purple-500
                                    transition-all
                                    duration-700
                                    group-hover:w-full
                                "
                            ></div>

                        </div>

                    </div>

                @endforeach

            </div>


        @else

            {{-- ==========================================================
                EMPTY STATE
            =========================================================== --}}

            <div
                class="
                    mx-auto
                    max-w-xl
                    rounded-[2rem]
                    border
                    border-dashed
                    border-slate-300
                    bg-white/60
                    p-10
                    text-center
                    shadow-sm
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
                        text-indigo-500
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.6"
                        stroke="currentColor"
                        class="h-8 w-8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 13.5 9 7l4 4 8-8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 3v6h-6"
                        />
                    </svg>

                </div>


                <h3
                    class="
                        mt-5
                        text-lg
                        font-bold
                        text-slate-900
                    "
                >
                    No statistics available
                </h3>


                <p
                    class="
                        mt-2
                        text-sm
                        leading-6
                        text-slate-500
                    "
                >
                    Add statistics from the admin panel.
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

