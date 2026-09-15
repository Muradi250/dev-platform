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
    | Padding
    |--------------------------------------------------------------------------
    */

    $padding = match ($settings['padding'] ?? 'medium') {
        'none' => '',
        'small' => 'py-10',
        'large' => 'py-32',
        default => 'py-20',
    };


    /*
    |--------------------------------------------------------------------------
    | Text Colors
    |--------------------------------------------------------------------------
    */

    $textColor = $settings['text_color'] ?? 'dark';

    $titleClass = $textColor === 'dark'
        ? 'text-gray-900'
        : 'text-white';

    $descriptionClass = $textColor === 'dark'
        ? 'text-gray-600'
        : 'text-gray-200';


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

        $backgroundImage = asset('storage/' . $image);
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Settings
    |--------------------------------------------------------------------------
    */

    $customClass = $settings['custom_class'] ?? '';
    $customCss = $settings['custom_css'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | Contact Data
    |--------------------------------------------------------------------------
    */

    $title = $data['title'] ?? 'Get in Touch';

    $description = $data['description'] ?? null;

    $email = $data['email'] ?? null;
    $phone = $data['phone'] ?? null;
    $whatsapp = $data['whatsapp'] ?? null;
    $telegram = $data['telegram'] ?? null;

    $workingHours = $data['working_hours'] ?? null;

    $socialLinks = $data['social_links'] ?? [];


    /*
    |--------------------------------------------------------------------------
    | WhatsApp URL
    |--------------------------------------------------------------------------
    */

    $whatsappNumber = $whatsapp
        ? preg_replace('/[^0-9]/', '', $whatsapp)
        : null;


    /*
    |--------------------------------------------------------------------------
    | Telegram URL
    |--------------------------------------------------------------------------
    */

    $telegramUrl = null;

    if ($telegram) {

        $telegramValue = trim($telegram);

        if (str_starts_with($telegramValue, 'http')) {

            $telegramUrl = $telegramValue;

        } else {

            $telegramValue = ltrim($telegramValue, '@');

            if ($telegramValue !== '') {
                $telegramUrl = 'https://t.me/' . $telegramValue;
            }
        }
    }

@endphp


<section
    class="relative overflow-hidden {{ $padding }} {{ $customClass }}"
    @if($backgroundColor)
        style="background-color: {{ $backgroundColor }};"
    @elseif($backgroundImage)
        style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center;"
    @endif
>

    {{-- Decorative Background --}}

    <div
        class="pointer-events-none absolute -left-32 -top-32 h-80 w-80 rounded-full bg-indigo-500/10 blur-3xl"
    ></div>

    <div
        class="pointer-events-none absolute -bottom-32 -right-32 h-80 w-80 rounded-full bg-purple-500/10 blur-3xl"
    ></div>


    <div class="relative mx-auto w-full {{ $container }} px-6 lg:px-8">


        {{-- Header --}}

        <div class="mx-auto mb-14 max-w-2xl text-center">

            <h2
                class="text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl {{ $titleClass }}"
            >
                {{ $title }}
            </h2>

            @if($description)

                <p
                    class="mx-auto mt-5 max-w-xl text-lg leading-8 {{ $descriptionClass }}"
                >
                    {{ $description }}
                </p>

            @endif

        </div>


        {{-- Contact Cards --}}

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">


            {{-- Email --}}

            @if($email)

                <a
                    href="mailto:{{ $email }}"
                    class="group relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:bg-white/70 hover:shadow-2xl"
                >

                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/10 text-indigo-600 transition duration-300 group-hover:scale-110"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M3 7.5A2.5 2.5 0 015.5 5h13A2.5 2.5 0 0121 7.5v9a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 16.5v-9z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 7l8 6 8-6"
                            />
                        </svg>

                    </div>

                    <p class="text-sm font-medium text-gray-500">
                        Email
                    </p>

                    <p
                        class="mt-2 break-all font-semibold {{ $titleClass }}"
                    >
                        {{ $email }}
                    </p>

                    <span
                        class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-indigo-600"
                    >
                        Send Email

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </span>

                </a>

            @endif


            {{-- Phone --}}

            @if($phone)

                <a
                    href="tel:{{ $phone }}"
                    class="group relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:bg-white/70 hover:shadow-2xl"
                >

                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500/10 text-blue-600 transition duration-300 group-hover:scale-110"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 4h3l2 5-2 2a16 16 0 006 6l2-2 5 2v3a2 2 0 01-2 2C10.268 22 2 13.732 2 3a2 2 0 012-2h1z"
                            />
                        </svg>

                    </div>

                    <p class="text-sm font-medium text-gray-500">
                        Phone
                    </p>

                    <p class="mt-2 font-semibold {{ $titleClass }}">
                        {{ $phone }}
                    </p>

                    <span
                        class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-blue-600"
                    >
                        Call Now

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </span>

                </a>

            @endif


            {{-- WhatsApp --}}

            @if($whatsappNumber)

                <a
                    href="https://wa.me/{{ $whatsappNumber }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:bg-white/70 hover:shadow-2xl"
                >

                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600 transition duration-300 group-hover:scale-110"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M20 11.5a8 8 0 01-11.8 7L4 20l1.5-4.2A8 8 0 1120 11.5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8.5 9.5c.3-.7.7-.7 1.1-.6l.8.3c.3.1.4.4.3.7l-.4 1c.5 1 1.3 1.8 2.3 2.3l1-.4c.3-.1.6 0 .7.3l.3.8c.1.4.1.8-.6 1.1-1 .4-2.7-.4-4.1-1.8-1.4-1.4-2.2-3.1-1.8-4.1z"
                            />
                        </svg>

                    </div>

                    <p class="text-sm font-medium text-gray-500">
                        WhatsApp
                    </p>

                    <p class="mt-2 font-semibold {{ $titleClass }}">
                        {{ $whatsapp }}
                    </p>

                    <span
                        class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-emerald-600"
                    >
                        Chat on WhatsApp

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </span>

                </a>

            @endif


            {{-- Telegram --}}

            @if($telegramUrl)

                <a
                    href="{{ $telegramUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:bg-white/70 hover:shadow-2xl"
                >

                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-600 transition duration-300 group-hover:scale-110"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M21 3L3.8 9.6c-.9.3-.9 1.6 0 1.9l4.4 1.6 1.6 4.8c.2.7 1.1.9 1.6.4l2.4-2.4 4.5 3.3c.6.4 1.4.1 1.6-.6L22 4.3c.2-.8-.3-1.6-1-1.3z"
                            />
                        </svg>

                    </div>

                    <p class="text-sm font-medium text-gray-500">
                        Telegram
                    </p>

                    <p class="mt-2 font-semibold {{ $titleClass }}">
                        {{ $telegram }}
                    </p>

                    <span
                        class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-sky-600"
                    >
                        Message on Telegram

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </span>

                </a>

            @endif


            {{-- Availability --}}

            @if($workingHours)

                <div
                    class="relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl"
                >

                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-600"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M12 7v5l3 2"
                            />
                        </svg>

                    </div>

                    <p class="text-sm font-medium text-gray-500">
                        Availability
                    </p>

                    <p
                        class="mt-2 whitespace-pre-line font-semibold {{ $titleClass }}"
                    >
                        {{ $workingHours }}
                    </p>

                </div>

            @endif


            {{-- Social Links --}}

            @foreach($socialLinks as $social)

                @php

                    $socialUrl = $social['url'] ?? null;
                    $socialLabel = $social['label'] ?? null;
                    $socialIcon = $social['icon'] ?? 'website';

                @endphp

                @if($socialUrl && $socialLabel)

                    <a
                        href="{{ $socialUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group relative overflow-hidden rounded-3xl border border-white/50 bg-white/50 p-6 shadow-xl shadow-gray-900/5 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:bg-white/70 hover:shadow-2xl"
                    >

                        <div
                            class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-500/10 text-gray-700 transition duration-300 group-hover:scale-110"
                        >

                            @if($socialIcon === 'linkedin')

                                <span class="text-xl font-bold">
                                    in
                                </span>

                            @elseif($socialIcon === 'github')

                                <span class="text-lg font-bold">
                                    GH
                                </span>

                            @elseif($socialIcon === 'youtube')

                                <span class="text-lg font-bold">
                                    ▶
                                </span>

                            @elseif($socialIcon === 'instagram')

                                <span class="text-lg font-bold">
                                    ◎
                                </span>

                            @elseif($socialIcon === 'facebook')

                                <span class="text-xl font-bold">
                                    f
                                </span>

                            @elseif($socialIcon === 'x')

                                <span class="text-lg font-bold">
                                    𝕏
                                </span>

                            @else

                                <span class="text-lg font-bold">
                                    {{ strtoupper(substr($socialLabel, 0, 1)) }}
                                </span>

                            @endif

                        </div>

                        <p class="text-sm font-medium text-gray-500">
                            Social
                        </p>

                        <p class="mt-2 font-semibold {{ $titleClass }}">
                            {{ $socialLabel }}
                        </p>

                        <span
                            class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-gray-700"
                        >
                            Visit

                            <span class="transition group-hover:translate-x-1">
                                →
                            </span>
                        </span>

                    </a>

                @endif

            @endforeach

        </div>


        {{-- Bottom Message --}}

        @if($email || $phone || $whatsapp || $telegram)

            <div class="mt-24 sm:mt-28">

                <div
                    class="mx-auto max-w-3xl rounded-3xl border border-white/50 bg-white/30 p-6 text-center shadow-xl backdrop-blur-xl sm:p-8"
                >

                    <p
                        class="text-xl font-semibold {{ $titleClass }}"
                    >
                        Let’s connect and start a conversation.
                    </p>

                    <p
                        class="mt-2 text-sm {{ $descriptionClass }}"
                    >
                        We’re always happy to hear from you.
                    </p>

                </div>

            </div>

        @endif


    </div>

</section>


{{-- Custom CSS --}}

@if($customCss)

    <style>
        {!! $customCss !!}
    </style>

@endif