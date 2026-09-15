@php
    $data = is_array($block->data ?? null)
        ? $block->data
        : [];

    $eyebrow = $data['eyebrow'] ?? 'Frequently Asked Questions';
    $title = $data['title'] ?? 'Everything You Need to Know';
    $description = $data['description'] ?? '';

    $columns = (string) ($data['columns'] ?? '1');
    $cardStyle = $data['card_style'] ?? 'glass';
    $iconStyle = $data['icon_style'] ?? 'circle';

    $questions = is_array($data['questions'] ?? null)
        ? $data['questions']
        : [];

    $visibleQuestions = array_values(
        array_filter(
            $questions,
            fn ($item) =>
                is_array($item)
                && ($item['visible'] ?? true)
                && filled($item['question'] ?? null)
        )
    );

    $sectionId = 'faq-' . ($block->id ?? uniqid());

    /*
    |--------------------------------------------------------------------------
    | Card appearance
    |--------------------------------------------------------------------------
    */

    $cardClasses = match ($cardStyle) {
        'solid' => [
            'wrapper' => 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm',
            'active' => 'border-primary-300 dark:border-primary-700 shadow-lg shadow-primary-500/10',
        ],

        'bordered' => [
            'wrapper' => 'bg-transparent border border-gray-200 dark:border-gray-700',
            'active' => 'border-primary-500 dark:border-primary-500 bg-primary-50/30 dark:bg-primary-950/20',
        ],

        'minimal' => [
            'wrapper' => 'bg-transparent border-b border-gray-200 dark:border-gray-800 rounded-none',
            'active' => 'border-primary-500 dark:border-primary-500',
        ],

        'gradient' => [
            'wrapper' => 'bg-gradient-to-br from-white via-primary-50/40 to-white dark:from-gray-900 dark:via-primary-950/20 dark:to-gray-900 border border-primary-100/70 dark:border-primary-900/50',
            'active' => 'border-primary-400 dark:border-primary-600 shadow-lg shadow-primary-500/10',
        ],

        default => [
            'wrapper' => 'bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl border border-white dark:border-gray-800 shadow-sm',
            'active' => 'border-primary-300/70 dark:border-primary-700 shadow-xl shadow-primary-500/10',
        ],
    };

    /*
    |--------------------------------------------------------------------------
    | Icon appearance
    |--------------------------------------------------------------------------
    */

    $iconClasses = match ($iconStyle) {
        'rounded' => 'rounded-xl',

        'soft' => 'rounded-2xl',

        'minimal' => 'rounded-none bg-transparent border-0',

        default => 'rounded-full',
    };

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    $gridClasses = $columns === '2'
        ? 'grid grid-cols-1 gap-5 lg:grid-cols-2 lg:gap-6'
        : 'mx-auto max-w-4xl space-y-4';
@endphp


<section
    id="{{ $sectionId }}"
    class="relative overflow-hidden py-20 sm:py-24 lg:py-28"
>
    {{-- Decorative background --}}

    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-x-0 top-0 -z-10 flex justify-center overflow-hidden"
    >
        <div
            class="h-72 w-72 rounded-full bg-primary-500/10 blur-3xl sm:h-96 sm:w-96"
        ></div>
    </div>


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- ==========================================================
             SECTION HEADER
        =========================================================== --}}

        <header class="mx-auto mb-14 max-w-3xl text-center lg:mb-16">

            @if(filled($eyebrow))

                <div class="mb-5 flex justify-center">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-primary-700 dark:border-primary-900/60 dark:bg-primary-950/40 dark:text-primary-300 sm:text-sm"
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full bg-primary-500"
                        ></span>

                        {{ $eyebrow }}
                    </span>
                </div>

            @endif


            @if(filled($title))

                <h2
                    class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-4xl lg:text-5xl"
                >
                    {{ $title }}
                </h2>

            @endif


            @if(filled($description))

                <p
                    class="mx-auto mt-5 max-w-2xl text-base leading-8 text-gray-600 dark:text-gray-400 sm:text-lg"
                >
                    {{ $description }}
                </p>

            @endif

        </header>


        {{-- ==========================================================
             FAQ LIST
        =========================================================== --}}

        @if(count($visibleQuestions) > 0)

            <div class="{{ $gridClasses }}">

                @foreach($visibleQuestions as $index => $item)

                    @php
                        $question = $item['question'] ?? '';
                        $answer = $item['answer'] ?? '';
                        $badge = $item['badge'] ?? '';
                        $featured = (bool) ($item['featured'] ?? false);

                        $number = str_pad(
                            (string) ($index + 1),
                            2,
                            '0',
                            STR_PAD_LEFT
                        );
                    @endphp


                    <article
                        x-data="{
                            open: {{ $featured ? 'true' : 'false' }}
                        }"
                        class="group relative overflow-hidden {{ $cardClasses['wrapper'] }} rounded-2xl transition-all duration-300"
                        :class="open ? '{{ $cardClasses['active'] }}' : ''"
                    >

                        {{-- ==================================================
                             TOP ACCENT
                        =================================================== --}}

                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-primary-500/70 to-transparent opacity-0 transition-opacity duration-300"
                            :class="{ 'opacity-100': open }"
                        ></div>


                        {{-- ==================================================
                             QUESTION
                        =================================================== --}}

                        <button
                            type="button"
                            class="flex w-full items-center gap-4 p-5 text-start sm:p-6"
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                        >

                            {{-- Number --}}

                            <span
                                class="hidden shrink-0 font-mono text-xs font-semibold tracking-wider text-gray-400 dark:text-gray-600 sm:block"
                            >
                                {{ $number }}
                            </span>


                            {{-- Icon --}}

                            <span
                                class="flex h-11 w-11 shrink-0 items-center justify-center {{ $iconClasses }} bg-gray-100 text-gray-600 transition-all duration-300 dark:bg-gray-800 dark:text-gray-400"
                                :class="{
                                    'bg-primary-600 text-white shadow-lg shadow-primary-500/25 dark:bg-primary-500 dark:text-white': open
                                }"
                            >

                                {{-- Plus --}}

                                <svg
                                    x-show="!open"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 5v14M5 12h14"
                                    />
                                </svg>


                                {{-- Minus --}}

                                <svg
                                    x-show="open"
                                    x-cloak
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12h14"
                                    />
                                </svg>

                            </span>


                            {{-- Question content --}}

                            <span class="min-w-0 flex-1">

                                <span class="flex flex-wrap items-center gap-2">

                                    <span
                                        class="text-sm font-semibold leading-6 text-gray-900 dark:text-white sm:text-base lg:text-[17px]"
                                    >
                                        {{ $question }}
                                    </span>


                                    @if(filled($badge))

                                        <span
                                            class="inline-flex items-center rounded-full border border-primary-200 bg-primary-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-primary-700 dark:border-primary-900/60 dark:bg-primary-950/40 dark:text-primary-300"
                                        >
                                            {{ $badge }}
                                        </span>

                                    @endif

                                </span>


                                @if($featured)

                                    <span
                                        class="mt-1.5 inline-flex items-center gap-1 text-[11px] font-medium text-primary-600 dark:text-primary-400"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-primary-500"
                                        ></span>

                                        Featured
                                    </span>

                                @endif

                            </span>


                            {{-- Chevron --}}

                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-gray-200 text-gray-400 transition-all duration-300 dark:border-gray-700 dark:text-gray-500"
                                :class="{
                                    'rotate-180 border-primary-200 bg-primary-50 text-primary-600 dark:border-primary-800 dark:bg-primary-950/40 dark:text-primary-400': open
                                }"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m6 9 6 6 6-6"
                                    />
                                </svg>

                            </span>

                        </button>


                        {{-- ==================================================
                             ANSWER
                        =================================================== --}}

                        <div
                            x-show="open"
                            x-collapse
                            x-cloak
                        >

                            <div class="px-5 pb-6 sm:px-6 sm:pb-7">

                                <div
                                    class="ml-0 border-l-2 border-primary-100 pl-5 dark:border-primary-900/50 sm:ml-[4.25rem]"
                                >

                                    @if(filled($answer))

                                        <p
                                            class="text-sm leading-7 text-gray-600 dark:text-gray-400 sm:text-base sm:leading-8"
                                        >
                                            {!! nl2br(e($answer)) !!}
                                        </p>

                                    @else

                                        <p
                                            class="text-sm italic text-gray-400 dark:text-gray-600"
                                        >
                                            No answer has been provided.
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


        @else

            {{-- ==========================================================
                 EMPTY STATE
            =========================================================== --}}

            <div class="mx-auto max-w-2xl">

                <div
                    class="rounded-3xl border border-dashed border-gray-300 bg-gray-50/70 px-6 py-14 text-center dark:border-gray-700 dark:bg-gray-900/40"
                >

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-7 w-7 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.228 9.247a4.5 4.5 0 0 1 7.544 0c.897 1.23.897 2.776 0 4.006-.593.814-1.42 1.358-2.272 1.747-.765.349-1.5.79-1.5 1.65V17"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21h.01"
                            />
                        </svg>

                    </div>


                    <h3
                        class="mt-5 text-lg font-semibold text-gray-900 dark:text-white"
                    >
                        No Frequently Asked Questions
                    </h3>


                    <p
                        class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400"
                    >
                        Add questions and answers from the admin panel to display them here.
                    </p>

                </div>

            </div>

        @endif

    </div>
</section>