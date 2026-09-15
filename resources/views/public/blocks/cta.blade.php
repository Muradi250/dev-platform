@php
    $data = $block->data ?? [];

    /*
    |--------------------------------------------------------------------------
    | CTA Content
    |--------------------------------------------------------------------------
    */

    $eyebrow = $data['eyebrow'] ?? '';
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | Primary Button
    |--------------------------------------------------------------------------
    */

    $showPrimaryButton = (bool) ($data['show_primary_button'] ?? true);
    $buttonText = $data['button_text'] ?? '';
    $buttonUrl = $data['button_url'] ?? '#';
    $buttonIcon = $data['button_icon'] ?? '';
    $buttonNewTab = (bool) ($data['button_new_tab'] ?? false);

    /*
    |--------------------------------------------------------------------------
    | Secondary Button
    |--------------------------------------------------------------------------
    */

    $showSecondaryButton = (bool) ($data['show_secondary_button'] ?? false);
    $secondaryButtonText = $data['secondary_button_text'] ?? '';
    $secondaryButtonUrl = $data['secondary_button_url'] ?? '#';
    $secondaryButtonIcon = $data['secondary_button_icon'] ?? '';
    $secondaryButtonNewTab = (bool) ($data['secondary_button_new_tab'] ?? false);

    /*
    |--------------------------------------------------------------------------
    | Appearance
    |--------------------------------------------------------------------------
    */

    $style = $data['style'] ?? 'gradient';
    $alignment = $data['alignment'] ?? 'center';
    $size = $data['size'] ?? 'large';
    $radius = $data['radius'] ?? 'large';
    $width = $data['width'] ?? 'default';
    $shadow = $data['shadow'] ?? 'medium';

    /*
    |--------------------------------------------------------------------------
    | CTA Icon
    |--------------------------------------------------------------------------
    |
    | Support both possible field names:
    | show_cta_icon
    | show_icon
    |
    */

    $showIcon = (bool) (
        $data['show_cta_icon']
        ?? $data['show_icon']
        ?? true
    );

    $showPattern = (bool) ($data['show_pattern'] ?? true);

    $showBadge = (bool) ($data['show_badge'] ?? false);
    $badge = $data['badge'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | Background
    |--------------------------------------------------------------------------
    */

    $background = $data['background'] ?? 'gradient';
    $gradient = $data['gradient'] ?? 'indigo-purple';
    $border = $data['border'] ?? 'subtle';

    /*
    |--------------------------------------------------------------------------
    | Spacing
    |--------------------------------------------------------------------------
    */

    $padding = $data['padding'] ?? 'large';
    $marginTop = $data['margin_top'] ?? 'medium';
    $marginBottom = $data['margin_bottom'] ?? 'medium';

    /*
    |--------------------------------------------------------------------------
    | Alignment Classes
    |--------------------------------------------------------------------------
    */

    $alignmentClasses = [
        'left' => 'text-left items-start',
        'center' => 'text-center items-center',
        'right' => 'text-right items-end',
    ];

    $buttonAlignmentClasses = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Width
    |--------------------------------------------------------------------------
    */

    $widthClasses = [
        'narrow' => 'max-w-3xl',
        'default' => 'max-w-5xl',
        'wide' => 'max-w-6xl',
        'full' => 'max-w-full',
    ];

    /*
    |--------------------------------------------------------------------------
    | Radius
    |--------------------------------------------------------------------------
    */

    $radiusClasses = [
        'none' => 'rounded-none',
        'small' => 'rounded-lg',
        'medium' => 'rounded-2xl',
        'large' => 'rounded-3xl',
    ];

    /*
    |--------------------------------------------------------------------------
    | Shadow
    |--------------------------------------------------------------------------
    */

    $shadowClasses = [
        'none' => 'shadow-none',
        'small' => 'shadow-sm',
        'medium' => 'shadow-lg',
        'large' => 'shadow-2xl',
    ];

    /*
    |--------------------------------------------------------------------------
    | CTA Size
    |--------------------------------------------------------------------------
    */

    $sizeClasses = [
        'compact' => [
            'container' => 'min-h-[220px]',
            'title' => 'text-2xl sm:text-3xl md:text-4xl',
            'description' => 'text-sm md:text-base',
            'button' => 'px-5 py-2.5',
        ],

        'default' => [
            'container' => 'min-h-[280px]',
            'title' => 'text-3xl sm:text-4xl md:text-5xl',
            'description' => 'text-base md:text-lg',
            'button' => 'px-6 py-3',
        ],

        'large' => [
            'container' => 'min-h-[340px]',
            'title' => 'text-3xl sm:text-4xl md:text-5xl lg:text-6xl',
            'description' => 'text-base md:text-lg',
            'button' => 'px-6 py-3.5',
        ],
    ];

    $currentSize = $sizeClasses[$size] ?? $sizeClasses['large'];

    /*
    |--------------------------------------------------------------------------
    | Padding
    |--------------------------------------------------------------------------
    */

    $paddingClasses = [
        'small' => 'px-6 py-8',
        'medium' => 'px-8 py-12',
        'large' => 'px-8 py-16 md:px-12',
        'extra-large' => 'px-8 py-20 md:px-16 md:py-24',
    ];

    /*
    |--------------------------------------------------------------------------
    | Margin
    |--------------------------------------------------------------------------
    */

    $marginTopClasses = [
        'none' => 'mt-0',
        'small' => 'mt-4',
        'medium' => 'mt-8',
        'large' => 'mt-12',
    ];

    $marginBottomClasses = [
        'none' => 'mb-0',
        'small' => 'mb-4',
        'medium' => 'mb-8',
        'large' => 'mb-12',
    ];

    /*
    |--------------------------------------------------------------------------
    | Gradients
    |--------------------------------------------------------------------------
    */

    $gradientClasses = [
        'indigo-purple' =>
            'bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700',

        'blue-cyan' =>
            'bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700',

        'purple-pink' =>
            'bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600',

        'green-teal' =>
            'bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700',

        'orange-red' =>
            'bg-gradient-to-r from-orange-500 via-red-600 to-rose-700',
    ];

    /*
    |--------------------------------------------------------------------------
    | Background
    |--------------------------------------------------------------------------
    */

    $backgroundClasses = match ($background) {
        'solid' =>
            'bg-gray-900 text-white',

        'transparent' =>
            'bg-transparent text-gray-900',

        'default' =>
            'bg-white text-gray-900',

        'gradient' =>
            ($gradientClasses[$gradient] ?? $gradientClasses['indigo-purple'])
            . ' text-white',

        default =>
            ($gradientClasses[$gradient] ?? $gradientClasses['indigo-purple'])
            . ' text-white',
    };

    /*
    |--------------------------------------------------------------------------
    | Style Overrides
    |--------------------------------------------------------------------------
    */

    if ($style === 'dark') {
        $backgroundClasses = 'bg-gray-900 text-white';
    }

    if ($style === 'gradient') {
        $backgroundClasses =
            ($gradientClasses[$gradient] ?? $gradientClasses['indigo-purple'])
            . ' text-white';
    }

    if ($style === 'glass') {
        $backgroundClasses =
            'bg-white/70 text-gray-900 backdrop-blur-xl';
    }

    if ($style === 'minimal') {
        $backgroundClasses =
            'bg-gray-50 text-gray-900';
    }

    /*
    |--------------------------------------------------------------------------
    | Border
    |--------------------------------------------------------------------------
    */

    $borderClasses = [
        'none' => 'border-0',
        'subtle' => 'border border-white/20',
        'strong' => 'border-2 border-white/30',
    ];

    if (in_array($style, ['default', 'minimal', 'glass'], true)) {
        $borderClasses = [
            'none' => 'border-0',
            'subtle' => 'border border-gray-200',
            'strong' => 'border-2 border-gray-300',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Text Colors
    |--------------------------------------------------------------------------
    */

    $isDark = in_array($style, ['dark', 'gradient'], true);

    $descriptionClass = $isDark
        ? 'text-white/80'
        : 'text-gray-600';

    $eyebrowClass = $isDark
        ? 'text-white/80'
        : 'text-indigo-600';

    /*
    |--------------------------------------------------------------------------
    | Button Colors
    |--------------------------------------------------------------------------
    */

    $primaryButtonClass = $isDark
        ? 'bg-white text-gray-900 hover:bg-gray-100'
        : 'bg-indigo-600 text-white hover:bg-indigo-700';

    $secondaryButtonClass = $isDark
        ? 'border border-white/40 text-white hover:bg-white/10'
        : 'border border-gray-300 text-gray-700 hover:bg-gray-100';

    /*
    |--------------------------------------------------------------------------
    | SVG Icon Renderer
    |--------------------------------------------------------------------------
    |
    | This does NOT depend on Heroicons.
    | Every icon is rendered directly as inline SVG.
    |
    */

    $icon = function ($name) {
        $name = strtolower(trim((string) $name));

        /*
        | Normalize common Heroicon names
        */

        $name = str_replace(
            [
                'heroicon-o-',
                'heroicon-m-',
                'heroicon-s-',
                'heroicons-',
                'heroicon-',
            ],
            '',
            $name
        );

        /*
        | Convert spaces and underscores
        */

        $name = str_replace(
            [' ', '_'],
            '-',
            $name
        );

        $icons = [

            'arrow-right' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 5l7 7-7 7M20 12H4"
                    />
                </svg>
            ',

            'arrow-left' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11 19l-7-7 7-7M4 12h16"
                    />
                </svg>
            ',

            'arrow-up-right' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 17L17 7M7 7h10v10"
                    />
                </svg>
            ',

            'arrow-down' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 5v14m7-7l-7 7-7-7"
                    />
                </svg>
            ',

            'check' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            ',

            'check-circle' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 12l2.5 2.5L16 9"
                    />
                </svg>
            ',

            'plus' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        d="M12 5v14M5 12h14"
                    />
                </svg>
            ',

            'rocket' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14 5c3-3 6-2 6-2s1 3-2 6l-4 4-3-3 3-5z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11 13l-4 4M7 17l-2 1 1-2M9 8l-3-1-2 2 4 2"
                    />
                </svg>
            ',

            'sparkles' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3l1.5 5.5L19 10l-5.5 1.5L12 17l-1.5-5.5L5 10l5.5-1.5L12 3z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 16l.6 2.4L22 19l-2.4.6L19 22l-.6-2.4L16 19l2.4-.6L19 16z"
                    />
                </svg>
            ',

            'star' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5z"/>
                </svg>
            ',

            'heart' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.8 8.8c0 5-8.8 10.2-8.8 10.2S3.2 13.8 3.2 8.8A4.8 4.8 0 0112 6a4.8 4.8 0 018.8 2.8z"
                    />
                </svg>
            ',

            'play' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path d="M8 5v14l11-7L8 5z"/>
                </svg>
            ',

            'download' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v11m0 0l-4-4m4 4l4-4M5 20h14"
                    />
                </svg>
            ',

            'external-link' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14 5h5v5M19 5l-8 8"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 13v5a1 1 0 01-1 1H6a1 1 0 01-1-1V6a1 1 0 011-1h5"
                    />
                </svg>
            ',

            'mail' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <rect
                        x="4"
                        y="6"
                        width="16"
                        height="12"
                        rx="2"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 7l8 6 8-6"
                    />
                </svg>
            ',

            'phone' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.5 3.5l3 1.5-1.5 4-2-1c1 3 3 5 6 6l-1-2 4-1.5 1.5 3c.5 1-1 3-2.5 3-6.5 0-11-5-11-11 0-1.5 2-2 2.5-1.5z"
                    />
                </svg>
            ',

            'calendar' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <rect
                        x="4"
                        y="5"
                        width="16"
                        height="15"
                        rx="2"
                    />
                    <path
                        stroke-linecap="round"
                        d="M8 3v4M16 3v4M4 10h16"
                    />
                </svg>
            ',

            'user' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="8" r="3"/>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 20a7 7 0 0114 0"
                    />
                </svg>
            ',

            'users' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <circle cx="9" cy="8" r="3"/>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 20a6 6 0 0112 0M16 11a3 3 0 013 3M17 18a5 5 0 014 2"
                    />
                </svg>
            ',

            'info' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path
                        stroke-linecap="round"
                        d="M12 10v6M12 7h.01"
                    />
                </svg>
            ',

            'settings' => '
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 8a4 4 0 100 8 4 4 0 000-8z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M4 12H2M22 12h-2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4M12 2v2M12 20v2"
                    />
                </svg>
            ',
        ];

        return $icons[$name] ?? $icons['arrow-right'];
    };
@endphp


<section
    class="w-full
        {{ $marginTopClasses[$marginTop] ?? 'mt-8' }}
        {{ $marginBottomClasses[$marginBottom] ?? 'mb-8' }}"
>
    <div
        class="mx-auto w-full
            {{ $widthClasses[$width] ?? $widthClasses['default'] }}"
    >
        <div
            class="relative isolate overflow-hidden
                {{ $currentSize['container'] }}
                {{ $backgroundClasses }}
                {{ $borderClasses[$border] ?? $borderClasses['subtle'] }}
                {{ $radiusClasses[$radius] ?? $radiusClasses['large'] }}
                {{ $shadowClasses[$shadow] ?? $shadowClasses['medium'] }}
                {{ $paddingClasses[$padding] ?? $paddingClasses['large'] }}"
        >

            @if($showPattern)
                <div
                    class="pointer-events-none absolute inset-0 z-0 overflow-hidden"
                    aria-hidden="true"
                >
                    <div
                        class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"
                    ></div>

                    <div
                        class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-white/10 blur-3xl"
                    ></div>

                    <div class="absolute inset-0 opacity-10">
                        <div
                            class="h-full w-full"
                            style="
                                background-image:
                                    linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px),
                                    linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px);
                                background-size: 32px 32px;
                            "
                        ></div>
                    </div>
                </div>
            @endif


            <div
                class="relative z-10 mx-auto flex w-full flex-col
                    {{ $alignmentClasses[$alignment] ?? $alignmentClasses['center'] }}"
            >

                @if($showBadge && $badge)
                    <div class="mb-5">
                        <span
                            class="inline-flex items-center rounded-full
                                border border-current/20
                                bg-white/10
                                px-4 py-1.5
                                text-sm font-medium
                                backdrop-blur-sm"
                        >
                            @if($showIcon)
                                <span
                                    class="mr-2 h-2 w-2 rounded-full bg-current"
                                ></span>
                            @endif

                            {{ $badge }}
                        </span>
                    </div>
                @endif


                @if($eyebrow)
                    <div class="mb-3">
                        <span
                            class="text-sm font-semibold uppercase tracking-wider
                                {{ $eyebrowClass }}"
                        >
                            {{ $eyebrow }}
                        </span>
                    </div>
                @endif


                @if($title)
                    <h2
                        class="max-w-4xl font-bold tracking-tight
                            {{ $currentSize['title'] }}"
                    >
                        {{ $title }}
                    </h2>
                @endif


                @if($description)
                    <p
                        class="mt-5 max-w-3xl leading-7
                            {{ $currentSize['description'] }}
                            {{ $descriptionClass }}"
                    >
                        {{ $description }}
                    </p>
                @endif


                @if(
                    ($showPrimaryButton && $buttonText)
                    ||
                    ($showSecondaryButton && $secondaryButtonText)
                )

                    <div
                        class="mt-8 flex w-full flex-wrap items-center gap-4
                            {{ $buttonAlignmentClasses[$alignment] ?? $buttonAlignmentClasses['center'] }}"
                    >

                        @if($showPrimaryButton && $buttonText)

                            <a
                                href="{{ $buttonUrl }}"
                                @if($buttonNewTab)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                class="inline-flex items-center justify-center
                                    gap-2
                                    rounded-xl
                                    text-sm font-semibold
                                    shadow-sm
                                    transition duration-200
                                    hover:-translate-y-0.5
                                    hover:shadow-lg
                                    {{ $currentSize['button'] }}
                                    {{ $primaryButtonClass }}"
                            >

                                <span>
                                    {{ $buttonText }}
                                </span>

                                @if($showIcon)
                                    <span
                                        class="inline-flex h-5 w-5 shrink-0
                                            items-center justify-center"
                                        aria-hidden="true"
                                    >
                                        {!! $icon($buttonIcon ?: 'arrow-right') !!}
                                    </span>
                                @endif

                            </a>

                        @endif


                        @if($showSecondaryButton && $secondaryButtonText)

                            <a
                                href="{{ $secondaryButtonUrl }}"
                                @if($secondaryButtonNewTab)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                class="inline-flex items-center justify-center
                                    gap-2
                                    rounded-xl
                                    text-sm font-semibold
                                    transition duration-200
                                    hover:-translate-y-0.5
                                    {{ $currentSize['button'] }}
                                    {{ $secondaryButtonClass }}"
                            >

                                <span>
                                    {{ $secondaryButtonText }}
                                </span>

                                @if($showIcon)
                                    <span
                                        class="inline-flex h-5 w-5 shrink-0
                                            items-center justify-center"
                                        aria-hidden="true"
                                    >
                                        {!! $icon($secondaryButtonIcon ?: 'arrow-right') !!}
                                    </span>
                                @endif

                            </a>

                        @endif

                    </div>

                @endif

            </div>
        </div>
    </div>
</section>