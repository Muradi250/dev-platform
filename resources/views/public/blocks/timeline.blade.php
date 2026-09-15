@php
$data = is_array($block->data ?? null) ? $block->data : [];
$settings = is_array($block->settings ?? null) ? $block->settings : [];


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
$backgroundPosition = $settings['background']['position'] ?? 'center';
$backgroundOverlay = (bool) ($settings['background']['overlay'] ?? false);

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
$steps = $data['steps'] ?? [];

if (!is_array($steps)) {
    $steps = [];
}

/*
|--------------------------------------------------------------------------
| Timeline Icons
|--------------------------------------------------------------------------
*/

$icons = [
    'rocket' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.17m5.84-3.21a6 6 0 0 0 7.38-5.84h-4.17m-3.21 5.84L9.88 9.88m5.71 4.49L21 8.97m-5.41 5.4L8.97 21m0 0a6 6 0 0 1-7.38-5.84h4.17m3.21 5.84a6 6 0 0 0-5.84-7.38h4.17m3.21-3.21L21 3m0 0-3.97 3.97M21 3h-4.5M21 3v4.5"/>
    </svg>',

    'users' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a8.97 8.97 0 0 0-6-2.22 8.97 8.97 0 0 0-6 2.22"/>
        <circle cx="12" cy="7" r="4"/>
    </svg>',

    'code' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 8.25-3.5 3.75 3.5 3.75M15.75 8.25l3.5 3.75-3.5 3.75M14 5.5l-4 13"/>
    </svg>',

    'database' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <ellipse cx="12" cy="5" rx="8" ry="3"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5v7c0 1.66 3.58 3 8 3s8-1.34 8-3V5"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12v7c0 1.66 3.58 3 8 3s8-1.34 8-3v-7"/>
    </svg>',

    'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <circle cx="12" cy="12" r="9"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12 2.3 2.3 4.7-5"/>
    </svg>',

    'light-bulb' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18h6M10 22h4"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 14.5a6 6 0 1 1 7 0c-.8.65-1.25 1.45-1.4 2.5H9.9c-.15-1.05-.6-1.85-1.4-2.5Z"/>
    </svg>',

    'shield' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 20 6v5c0 5-3.2 8.4-8 10-4.8-1.6-8-5-8-10V6l8-3Z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/>
    </svg>',

    'chart' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5M4 19h16"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="m7 15 4-4 3 2 5-6"/>
    </svg>',

    'settings' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <circle cx="12" cy="12" r="3"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.9 1.9-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20h-2.7v-.09a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.9-1.9.06-.06A1.7 1.7 0 0 0 5.6 15a1.7 1.7 0 0 0-1.56-1.03H4v-2.7h.04A1.7 1.7 0 0 0 5.6 10a1.7 1.7 0 0 0-.34-1.88L5.2 8.06l1.9-1.9.06.06A1.7 1.7 0 0 0 9.04 6.56a1.7 1.7 0 0 0 1.03-1.56V5h2.7v.09a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.9 1.9-.06.06A1.7 1.7 0 0 0 17.94 10a1.7 1.7 0 0 0 1.56 1.03h.04v2.7h-.04A1.7 1.7 0 0 0 19.4 15Z"/>
    </svg>',

    'star' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.06 6.2L12 17.3 6.44 20.2 7.5 14 3 9.6l6.2-.9L12 3Z"/>
    </svg>',

    'check' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 7"/>
    </svg>',
];


@endphp

<section
    @if($sectionId)
        id="{{ $sectionId }}"
    @endif
    class="relative overflow-hidden {{ $mobilePadding }} {{ $desktopPadding }} {{ $customClass }}"
    @if($backgroundColor)
        style="background-color: {{ $backgroundColor }};"
    @elseif($backgroundImage)
        style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: {{ $backgroundPosition }};"
    @endif
>


@if($backgroundImage && $backgroundOverlay)
    <div
        class="absolute inset-0 bg-black/40"
        aria-hidden="true"
    ></div>
@endif

<div class="relative mx-auto w-full {{ $container }} px-6 lg:px-8">

    {{-- Section Header --}}
    @if($title || $description)
        <div class="mx-auto mb-16 max-w-3xl text-center">

            @if($title)
                <span
                    class="mb-4 inline-flex rounded-full border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-500 shadow-sm"
                >
                    Process
                </span>

                <h2
                    class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl {{ $titleClass }}"
                >
                    {{ $title }}
                </h2>
            @endif

            @if($description)
                <p
                    class="mx-auto mt-5 max-w-2xl text-base leading-8 {{ $descriptionClass }} sm:text-lg"
                >
                    {{ $description }}
                </p>
            @endif

        </div>
    @endif

    {{-- Timeline --}}
    @if(count($steps))

        <div class="relative mx-auto max-w-5xl">

            {{-- Timeline Line --}}
            <div
                class="absolute bottom-0 left-6 top-0 w-px bg-gray-200 md:left-1/2 md:-translate-x-1/2"
                aria-hidden="true"
            ></div>

            @foreach($steps as $index => $rawStep)

                @php
                    $step = is_array($rawStep) ? $rawStep : [];

                    if (($step['is_active'] ?? true) === false) {
                        continue;
                    }

                    $number = $step['number'] ?? ($index + 1);
                    $stepTitle = $step['title'] ?? '';
                    $stepDescription = $step['description'] ?? '';
                    $stepLabel = $step['label'] ?? '';
                    $duration = $step['duration'] ?? '';
                    $stepUrl = $step['url'] ?? '';
                    $icon = strtolower(trim((string) ($step['icon'] ?? '')));
                    $stepColor = $step['color'] ?? null;

                    $isEven = $index % 2 === 0;

                    $numberText = is_scalar($number)
                        ? (string) $number
                        : (string) ($index + 1);
                @endphp

                <div class="relative mb-12 last:mb-0 md:mb-16">

                    {{-- Timeline Marker --}}
                    <div
                        class="absolute left-6 top-6 z-20 flex h-12 w-12 -translate-x-1/2 items-center justify-center rounded-full border-4 border-white bg-gray-900 text-white shadow-lg md:left-1/2"
                        @if($stepColor)
                            style="background-color: {{ $stepColor }};"
                        @endif
                    >
                        @if(isset($icons[$icon]))
                            {!! $icons[$icon] !!}
                        @else
                            <span class="text-sm font-bold">
                                {{ $numberText }}
                            </span>
                        @endif
                    </div>

                    {{-- Step Card --}}
                    <div
                        class="ml-16 md:ml-0 md:w-[calc(50%-3rem)] {{ $isEven ? 'md:mr-auto md:pr-8' : 'md:ml-auto md:pl-8' }}"
                    >

                        @if($stepUrl)
                            <a
                                href="{{ $stepUrl }}"
                                class="group block rounded-3xl border border-gray-200 border-t-4 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:p-7"
                                @if($stepColor)
                                    style="border-top-color: {{ $stepColor }};"
                                @endif
                            >
                        @else
                            <div
                                class="group rounded-3xl border border-gray-200 border-t-4 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:p-7"
                                @if($stepColor)
                                    style="border-top-color: {{ $stepColor }};"
                                @endif
                            >
                        @endif

                            {{-- Step Meta --}}
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">

                                <div class="flex flex-wrap items-center gap-2">

                                    @if($stepLabel)
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            {{ $stepLabel }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Step {{ $numberText }}
                                        </span>
                                    @endif

                                    @if($duration)
                                        <span class="text-xs font-medium text-gray-400">
                                            {{ $duration }}
                                        </span>
                                    @endif

                                </div>

                                <span class="text-xs font-medium text-gray-400">
                                    {{ sprintf('%02d', $index + 1) }}
                                </span>

                            </div>

                            {{-- Title --}}
                            @if($stepTitle)
                                <h3 class="text-xl font-bold tracking-tight text-gray-900">
                                    {{ $stepTitle }}
                                </h3>
                            @endif

                            {{-- Description --}}
                            @if($stepDescription)
                                <p class="mt-3 text-sm leading-7 text-gray-600 sm:text-base">
                                    {{ $stepDescription }}
                                </p>
                            @endif

                            {{-- Accent --}}
                            <div
                                class="mt-6 h-1 w-12 rounded-full bg-gray-900 transition-all duration-300 group-hover:w-20"
                                @if($stepColor)
                                    style="background-color: {{ $stepColor }};"
                                @endif
                            ></div>

                        @if($stepUrl)
                            </a>
                        @else
                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="mx-auto max-w-2xl rounded-3xl border border-dashed border-gray-300 bg-gray-50 p-10 text-center">

            <h3 class="text-lg font-semibold text-gray-900">
                No process steps available
            </h3>

            <p class="mt-2 text-sm text-gray-600">
                Add process steps from the admin panel.
            </p>

        </div>

    @endif

</div>


</section>

@if($customCss) <style>
{!! $customCss !!} </style>
@endif
