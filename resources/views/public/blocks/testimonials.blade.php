@php

    /*
    |--------------------------------------------------------------------------
    | Testimonials Block
    |--------------------------------------------------------------------------
    | Data source:
    | App\Models\Testimonial
    |
    | Database fields:
    | name, email, company, position, avatar, rating,
    | message, status, featured, approved_at, locale
    |--------------------------------------------------------------------------
    */

    use App\Models\Testimonial;


    /*
    |--------------------------------------------------------------------------
    | Block Data
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
    | Section Settings
    |--------------------------------------------------------------------------
    */

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

    $backgroundColor =
        $settings['background']['color'] ?? null;

    $backgroundImage = null;

    $backgroundPosition =
        $settings['background']['position'] ?? 'center';

    $backgroundOverlay =
        (bool) ($settings['background']['overlay'] ?? false);


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

    $customClass =
        $settings['custom_class'] ?? '';

    $customCss =
        $settings['custom_css'] ?? '';

    $sectionId =
        $settings['section_id'] ?? null;


    /*
    |--------------------------------------------------------------------------
    | Section Content
    |--------------------------------------------------------------------------
    */

    $title =
        $data['title'] ?? 'What Our Customers Say';

    $description =
        $data['description'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | Display Settings
    |--------------------------------------------------------------------------
    */

    $display =
        is_array($data['display'] ?? null)
            ? $data['display']
            : [];


    $displayEnabled =
        (bool) ($display['enabled'] ?? true);


    $layout =
        $display['layout'] ?? 'grid';


    $limit =
        (int) ($display['limit'] ?? 6);


    $showRating =
        (bool) ($display['show_rating'] ?? true);


    $showAvatar =
        (bool) ($display['show_avatar'] ?? true);


    $showCompany =
        (bool) ($display['show_company'] ?? true);


    $showPosition =
        (bool) ($display['show_position'] ?? true);


    $featuredOnly =
        (bool) ($display['featured_only'] ?? false);


    /*
    |--------------------------------------------------------------------------
    | Load Testimonials
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | The real database column is "featured".
    | There is NO "is_featured" column.
    |--------------------------------------------------------------------------
    */

    $query = Testimonial::query()
        ->approved()
        ->where('locale', app()->getLocale());


    /*
    |--------------------------------------------------------------------------
    | Featured Filter
    |--------------------------------------------------------------------------
    */

    if ($featuredOnly) {
        $query->featured();
    }


    /*
    |--------------------------------------------------------------------------
    | Limit
    |--------------------------------------------------------------------------
    */

    if ($limit > 0) {
        $query->limit($limit);
    }


    /*
    |--------------------------------------------------------------------------
    | Final Collection
    |--------------------------------------------------------------------------
    */

    $items = $query
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Avatar URL Helper
    |--------------------------------------------------------------------------
    */

    $getAvatarUrl = function ($avatar) {

        if (empty($avatar)) {
            return null;
        }

        if (is_array($avatar)) {
            $avatar = reset($avatar);
        }

        if (!is_string($avatar) || $avatar === '') {
            return null;
        }

        $avatar = str_replace(
            'livewire-file:',
            '',
            $avatar
        );

        if (
            str_starts_with($avatar, 'http://') ||
            str_starts_with($avatar, 'https://') ||
            str_starts_with($avatar, '//')
        ) {
            return $avatar;
        }

        $avatar = ltrim($avatar, '/');

        $avatar = preg_replace(
            '#^(storage/|public/)#',
            '',
            $avatar
        );

        return asset('storage/' . $avatar);
    };


@endphp


@if($displayEnabled)

<section
    @if($sectionId)
        id="{{ $sectionId }}"
    @endif

    class="
        relative
        overflow-hidden
        {{ $mobilePadding }}
        {{ $desktopPadding }}
        {{ $customClass }}
    "

    @if($backgroundColor)
        style="background-color: {{ $backgroundColor }};"
    @elseif($backgroundImage)
        style="
            background-image: url('{{ $backgroundImage }}');
            background-size: cover;
            background-position: {{ $backgroundPosition }};
        "
    @endif
>


    {{-- Background Overlay --}}

    @if($backgroundImage && $backgroundOverlay)

        <div
            class="absolute inset-0 bg-black/50"
            aria-hidden="true"
        ></div>

    @endif


    {{-- Decorative Background --}}

    @if(!$backgroundImage)

        <div
            class="pointer-events-none absolute inset-0 overflow-hidden"
            aria-hidden="true"
        >

            <div
                class="
                    absolute
                    -left-24
                    -top-24
                    h-72
                    w-72
                    rounded-full
                    bg-indigo-500/10
                    blur-3xl
                "
            ></div>


            <div
                class="
                    absolute
                    -bottom-24
                    -right-24
                    h-72
                    w-72
                    rounded-full
                    bg-purple-500/10
                    blur-3xl
                "
            ></div>

        </div>

    @endif


    {{-- ================================================================
         CONTAINER
    ================================================================= --}}

    <div
        class="
            relative
            mx-auto
            w-full
            {{ $container }}
            px-6
            lg:px-8
        "
    >


        {{-- ==========================================================
             SECTION HEADER
        =========================================================== --}}

        @if($title || $description)

            <div
                class="
                    mx-auto
                    mb-14
                    max-w-3xl
                    text-center
                    sm:mb-16
                "
            >

                {{-- Badge --}}

                @if($title)

                    <span
                        class="
                            inline-flex
                            items-center
                            gap-2
                            rounded-full
                            border
                            border-gray-200
                            bg-white/90
                            px-4
                            py-1.5
                            text-xs
                            font-semibold
                            uppercase
                            tracking-[0.18em]
                            text-gray-500
                            shadow-sm
                            backdrop-blur
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

                        Testimonials

                    </span>

                @endif


                {{-- Title --}}

                @if($title)

                    <h2
                        class="
                            mt-5
                            text-3xl
                            font-bold
                            tracking-tight
                            sm:text-4xl
                            lg:text-5xl
                            {{ $titleClass }}
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

            </div>

        @endif


        {{-- ==========================================================
             TESTIMONIALS
        =========================================================== --}}

        @if($items->count())


            {{-- ======================================================
                 GRID LAYOUT
            ======================================================= --}}

            @if($layout === 'grid')

                <div
                    class="
                        grid
                        grid-cols-1
                        items-stretch
                        gap-6
                        md:grid-cols-2
                        xl:grid-cols-3
                    "
                >

                    @foreach($items as $index => $testimonial)

                        @php

                            $name = trim(
                                (string) ($testimonial->name ?? '')
                            );

                            $position = trim(
                                (string) ($testimonial->position ?? '')
                            );

                            $company = trim(
                                (string) ($testimonial->company ?? '')
                            );

                            $message = trim(
                                (string) ($testimonial->message ?? '')
                            );

                            $avatar = $getAvatarUrl(
                                $testimonial->avatar ?? null
                            );

                            $rating = (int) (
                                $testimonial->rating ?? 0
                            );

                            /*
                            |--------------------------------------------------
                            | Initials
                            |--------------------------------------------------
                            */

                            $initials = 'U';

                            if ($name !== '') {

                                $parts = preg_split(
                                    '/\s+/',
                                    $name
                                );

                                if (count($parts) >= 2) {

                                    $initials =
                                        mb_strtoupper(
                                            mb_substr($parts[0], 0, 1) .
                                            mb_substr(end($parts), 0, 1)
                                        );

                                } else {

                                    $initials =
                                        mb_strtoupper(
                                            mb_substr($name, 0, 2)
                                        );
                                }
                            }

                        @endphp


                        {{-- ==================================================
                             CARD
                        =================================================== --}}

                        <article
                            class="
                                group
                                relative
                                flex
                                h-full
                                min-w-0
                                flex-col
                                overflow-hidden
                                rounded-3xl
                                border
                                border-gray-200
                                bg-white
                                p-6
                                shadow-sm
                                transition-all
                                duration-300
                                hover:-translate-y-1
                                hover:border-gray-300
                                hover:shadow-xl
                                sm:p-7
                            "
                        >


                            {{-- Top Accent --}}

                            <div
                                class="
                                    absolute
                                    inset-x-0
                                    top-0
                                    h-1
                                    bg-gradient-to-r
                                    from-indigo-500
                                    via-purple-500
                                    to-pink-500
                                "
                                aria-hidden="true"
                            ></div>


                            {{-- Quote Icon --}}

                            <div
                                class="
                                    pointer-events-none
                                    absolute
                                    right-5
                                    top-5
                                    z-0
                                    flex
                                    h-10
                                    w-10
                                    items-center
                                    justify-center
                                    rounded-2xl
                                    bg-gray-50
                                    text-gray-300
                                    transition
                                    duration-300
                                    group-hover:bg-indigo-50
                                    group-hover:text-indigo-400
                                "
                                aria-hidden="true"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    class="h-5 w-5"
                                >

                                    <path
                                        d="M9.17 6.17A6 6 0 0 0 4 12v6h6v-6H7.5A3.5 3.5 0 0 1 11 8.5V6.17A6 6 0 0 0 9.17 6.17ZM20.17 6.17A6 6 0 0 0 15 12v6h6v-6h-2.5A3.5 3.5 0 0 1 22 8.5V6.17a6 6 0 0 0-1.83 0Z"
                                    />

                                </svg>

                            </div>


                            {{-- ==================================================
                                 CONTENT
                            =================================================== --}}

                            <div
                                class="
                                    relative
                                    z-10
                                    flex
                                    min-w-0
                                    flex-1
                                    flex-col
                                "
                            >


                                {{-- Message --}}

                                @if($message)

                                    <blockquote
                                        class="
                                            min-w-0
                                            pr-10
                                            text-sm
                                            leading-7
                                            text-gray-600
                                            sm:text-base
                                            sm:leading-8
                                        "
                                    >
                                        “{{ $message }}”
                                    </blockquote>

                                @endif


                                {{-- Rating --}}

                                @if($showRating && $rating > 0)

                                    <div
                                        class="
                                            mt-5
                                            flex
                                            shrink-0
                                            items-center
                                            gap-0.5
                                            text-sm
                                            text-amber-400
                                        "
                                        aria-label="Rating: {{ $rating }} out of 5"
                                    >

                                        @for($star = 1; $star <= 5; $star++)

                                            <span>
                                                {{ $star <= $rating ? '★' : '☆' }}
                                            </span>

                                        @endfor

                                    </div>

                                @endif


                            </div>


                            {{-- ==================================================
                                 CUSTOMER
                            =================================================== --}}

                            <div
                                class="
                                    relative
                                    z-10
                                    mt-8
                                    flex
                                    min-w-0
                                    shrink-0
                                    items-center
                                    gap-4
                                    border-t
                                    border-gray-100
                                    pt-6
                                "
                            >


                                {{-- Avatar --}}

                                @if($showAvatar)

                                    <div class="shrink-0">

                                        @if($avatar)

                                            <img
                                                src="{{ $avatar }}"
                                                alt="{{ $name ?: 'Customer' }}"
                                                class="
                                                    block
                                                    h-12
                                                    w-12
                                                    rounded-2xl
                                                    object-cover
                                                    ring-4
                                                    ring-gray-50
                                                "
                                                loading="lazy"
                                            >

                                        @else

                                            <div
                                                class="
                                                    flex
                                                    h-12
                                                    w-12
                                                    items-center
                                                    justify-center
                                                    rounded-2xl
                                                    bg-gradient-to-br
                                                    from-indigo-500
                                                    to-purple-600
                                                    text-sm
                                                    font-bold
                                                    text-white
                                                    ring-4
                                                    ring-indigo-50
                                                "
                                                aria-hidden="true"
                                            >
                                                {{ $initials }}
                                            </div>

                                        @endif

                                    </div>

                                @endif


                                {{-- Customer Info --}}

                                <div
                                    class="
                                        min-w-0
                                        flex-1
                                        overflow-hidden
                                    "
                                >

                                    @if($name)

                                        <h3
                                            class="
                                                truncate
                                                text-sm
                                                font-bold
                                                leading-6
                                                text-gray-900
                                            "
                                        >
                                            {{ $name }}
                                        </h3>

                                    @endif


                                    @if(
                                        ($showPosition && $position) ||
                                        ($showCompany && $company)
                                    )

                                        <div
                                            class="
                                                mt-0.5
                                                flex
                                                min-w-0
                                                flex-wrap
                                                items-center
                                                gap-x-2
                                                gap-y-1
                                                text-xs
                                                leading-5
                                                text-gray-500
                                            "
                                        >

                                            @if($showPosition && $position)

                                                <span class="min-w-0">
                                                    {{ $position }}
                                                </span>

                                            @endif


                                            @if(
                                                $showPosition &&
                                                $position &&
                                                $showCompany &&
                                                $company
                                            )

                                                <span
                                                    class="shrink-0 text-gray-300"
                                                    aria-hidden="true"
                                                >
                                                    •
                                                </span>

                                            @endif


                                            @if($showCompany && $company)

                                                <span
                                                    class="
                                                        min-w-0
                                                        font-medium
                                                        text-gray-600
                                                    "
                                                >
                                                    {{ $company }}
                                                </span>

                                            @endif

                                        </div>

                                    @endif

                                </div>


                                {{-- Verified Mark --}}

                                <div
                                    class="
                                        flex
                                        h-8
                                        w-8
                                        shrink-0
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-emerald-50
                                        text-emerald-600
                                    "
                                    title="Verified customer"
                                    aria-label="Verified customer"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="h-4 w-4"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m9 12 2 2 4-4"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 3l2.5 1.5L17.5 4l1 2.8L21 8.5l-1.5 2.5L21 13.5l-2.5 1.7-3-.5-1 2.8L12 19l-2.5-1.5-3 .5-1-2.8L3 13.5l1.5-2.5L3 8.5l2.5-1.7L6.5 4l3 .5L12 3Z"
                                        />

                                    </svg>

                                </div>


                            </div>


                            {{-- Bottom Index --}}

                            <div
                                class="
                                    pointer-events-none
                                    absolute
                                    bottom-4
                                    right-5
                                    text-[10px]
                                    font-bold
                                    tracking-widest
                                    text-gray-200
                                "
                                aria-hidden="true"
                            >
                                {{ sprintf('%02d', $index + 1) }}
                            </div>


                        </article>

                    @endforeach

                </div>


            {{-- ======================================================
                 LIST LAYOUT
            ======================================================= --}}

            @elseif($layout === 'list')

                <div class="space-y-6">

                    @foreach($items as $index => $testimonial)

                        @php

                            $name = trim((string) ($testimonial->name ?? ''));
                            $position = trim((string) ($testimonial->position ?? ''));
                            $company = trim((string) ($testimonial->company ?? ''));
                            $message = trim((string) ($testimonial->message ?? ''));
                            $avatar = $getAvatarUrl($testimonial->avatar ?? null);
                            $rating = (int) ($testimonial->rating ?? 0);

                            $initials = 'U';

                            if ($name !== '') {

                                $parts = preg_split('/\s+/', $name);

                                if (count($parts) >= 2) {

                                    $initials = mb_strtoupper(
                                        mb_substr($parts[0], 0, 1) .
                                        mb_substr(end($parts), 0, 1)
                                    );

                                } else {

                                    $initials = mb_strtoupper(
                                        mb_substr($name, 0, 2)
                                    );
                                }
                            }

                        @endphp


                        <article
                            class="
                                flex
                                min-w-0
                                flex-col
                                gap-6
                                rounded-3xl
                                border
                                border-gray-200
                                bg-white
                                p-6
                                shadow-sm
                                sm:flex-row
                                sm:items-start
                                sm:p-8
                            "
                        >

                            {{-- Avatar --}}

                            @if($showAvatar)

                                <div class="shrink-0">

                                    @if($avatar)

                                        <img
                                            src="{{ $avatar }}"
                                            alt="{{ $name ?: 'Customer' }}"
                                            class="
                                                block
                                                h-16
                                                w-16
                                                rounded-2xl
                                                object-cover
                                            "
                                            loading="lazy"
                                        >

                                    @else

                                        <div
                                            class="
                                                flex
                                                h-16
                                                w-16
                                                items-center
                                                justify-center
                                                rounded-2xl
                                                bg-gradient-to-br
                                                from-indigo-500
                                                to-purple-600
                                                font-bold
                                                text-white
                                            "
                                        >
                                            {{ $initials }}
                                        </div>

                                    @endif

                                </div>

                            @endif


                            {{-- Content --}}

                            <div class="min-w-0 flex-1">

                                @if($message)

                                    <blockquote
                                        class="
                                            text-base
                                            leading-8
                                            text-gray-600
                                        "
                                    >
                                        “{{ $message }}”
                                    </blockquote>

                                @endif


                                @if($showRating && $rating > 0)

                                    <div
                                        class="
                                            mt-4
                                            flex
                                            gap-0.5
                                            text-amber-400
                                        "
                                    >

                                        @for($star = 1; $star <= 5; $star++)

                                            <span>
                                                {{ $star <= $rating ? '★' : '☆' }}
                                            </span>

                                        @endfor

                                    </div>

                                @endif


                                <div class="mt-5 min-w-0">

                                    @if($name)

                                        <h3
                                            class="
                                                text-sm
                                                font-bold
                                                text-gray-900
                                            "
                                        >
                                            {{ $name }}
                                        </h3>

                                    @endif


                                    @if(
                                        ($showPosition && $position) ||
                                        ($showCompany && $company)
                                    )

                                        <div
                                            class="
                                                mt-1
                                                flex
                                                flex-wrap
                                                gap-x-2
                                                gap-y-1
                                                text-xs
                                                text-gray-500
                                            "
                                        >

                                            @if($showPosition && $position)
                                                <span>{{ $position }}</span>
                                            @endif

                                            @if(
                                                $showPosition &&
                                                $position &&
                                                $showCompany &&
                                                $company
                                            )
                                                <span class="text-gray-300">•</span>
                                            @endif

                                            @if($showCompany && $company)
                                                <span class="font-medium">
                                                    {{ $company }}
                                                </span>
                                            @endif

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


            {{-- ======================================================
                 CAROUSEL
            ======================================================= --}}

            @else

                <div
                    class="
                        flex
                        gap-6
                        overflow-x-auto
                        pb-6
                        snap-x
                        snap-mandatory
                    "
                >

                    @foreach($items as $index => $testimonial)

                        @php

                            $name = trim((string) ($testimonial->name ?? ''));
                            $position = trim((string) ($testimonial->position ?? ''));
                            $company = trim((string) ($testimonial->company ?? ''));
                            $message = trim((string) ($testimonial->message ?? ''));
                            $avatar = $getAvatarUrl($testimonial->avatar ?? null);
                            $rating = (int) ($testimonial->rating ?? 0);

                            $initials = 'U';

                            if ($name !== '') {

                                $parts = preg_split('/\s+/', $name);

                                if (count($parts) >= 2) {

                                    $initials = mb_strtoupper(
                                        mb_substr($parts[0], 0, 1) .
                                        mb_substr(end($parts), 0, 1)
                                    );

                                } else {

                                    $initials = mb_strtoupper(
                                        mb_substr($name, 0, 2)
                                    );
                                }
                            }

                        @endphp


                        <article
                            class="
                                flex
                                w-[85%]
                                min-w-[85%]
                                snap-start
                                flex-col
                                rounded-3xl
                                border
                                border-gray-200
                                bg-white
                                p-6
                                shadow-sm
                                sm:w-[55%]
                                sm:min-w-[55%]
                                lg:w-[38%]
                                lg:min-w-[38%]
                            "
                        >

                            <div class="flex-1 min-w-0">

                                @if($message)

                                    <blockquote
                                        class="
                                            text-sm
                                            leading-7
                                            text-gray-600
                                            sm:text-base
                                            sm:leading-8
                                        "
                                    >
                                        “{{ $message }}”
                                    </blockquote>

                                @endif


                                @if($showRating && $rating > 0)

                                    <div class="mt-5 flex gap-0.5 text-amber-400">

                                        @for($star = 1; $star <= 5; $star++)

                                            <span>
                                                {{ $star <= $rating ? '★' : '☆' }}
                                            </span>

                                        @endfor

                                    </div>

                                @endif

                            </div>


                            <div
                                class="
                                    mt-8
                                    flex
                                    min-w-0
                                    shrink-0
                                    items-center
                                    gap-4
                                    border-t
                                    border-gray-100
                                    pt-6
                                "
                            >

                                @if($showAvatar)

                                    @if($avatar)

                                        <img
                                            src="{{ $avatar }}"
                                            alt="{{ $name ?: 'Customer' }}"
                                            class="
                                                block
                                                h-12
                                                w-12
                                                shrink-0
                                                rounded-2xl
                                                object-cover
                                            "
                                            loading="lazy"
                                        >

                                    @else

                                        <div
                                            class="
                                                flex
                                                h-12
                                                w-12
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-2xl
                                                bg-indigo-600
                                                text-sm
                                                font-bold
                                                text-white
                                            "
                                        >
                                            {{ $initials }}
                                        </div>

                                    @endif

                                @endif


                                <div class="min-w-0 flex-1">

                                    @if($name)

                                        <h3
                                            class="
                                                truncate
                                                text-sm
                                                font-bold
                                                text-gray-900
                                            "
                                        >
                                            {{ $name }}
                                        </h3>

                                    @endif


                                    @if(
                                        ($showPosition && $position) ||
                                        ($showCompany && $company)
                                    )

                                        <div
                                            class="
                                                mt-1
                                                flex
                                                flex-wrap
                                                gap-x-2
                                                gap-y-1
                                                text-xs
                                                text-gray-500
                                            "
                                        >

                                            @if($showPosition && $position)
                                                <span>{{ $position }}</span>
                                            @endif

                                            @if(
                                                $showPosition &&
                                                $position &&
                                                $showCompany &&
                                                $company
                                            )
                                                <span class="text-gray-300">•</span>
                                            @endif

                                            @if($showCompany && $company)
                                                <span>{{ $company }}</span>
                                            @endif

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

            @endif


        @else


            {{-- ==========================================================
                 EMPTY STATE
            =========================================================== --}}

            <div
                class="
                    mx-auto
                    max-w-2xl
                    rounded-3xl
                    border
                    border-dashed
                    border-gray-300
                    bg-gray-50
                    p-10
                    text-center
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
                        bg-white
                        text-gray-400
                        shadow-sm
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
                            d="M7 8h10M7 12h6m-8 7 3-3h8a4 4 0 0 0 4-4V8a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v8a4 4 0 0 0 1 3Z"
                        />

                    </svg>

                </div>


                <h3
                    class="
                        mt-5
                        text-lg
                        font-semibold
                        text-gray-900
                    "
                >
                    No customer reviews available
                </h3>


                <p
                    class="
                        mt-2
                        text-sm
                        leading-6
                        text-gray-600
                    "
                >
                    Customer testimonials will appear here after approval.
                </p>

            </div>


        @endif


    </div>

</section>

@endif


{{-- ================================================================
     CUSTOM CSS
================================================================= --}}

@if($customCss)

    <style>
        {!! $customCss !!}
    </style>

@endif