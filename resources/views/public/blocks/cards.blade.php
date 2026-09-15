@php

/*
|--------------------------------------------------------------------------
| Cards Block Renderer
|--------------------------------------------------------------------------
|
| Compatible with:
| App\Blocks\Schemas\CardsBlock
|
| Data:
|
| data.title
| data.description
| data.cards[]
|
| card:
| - icon
| - title
| - description
| - button_text
| - button_url
|
|--------------------------------------------------------------------------
*/


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

$container = match($settings['container'] ?? 'default') {

    'wide' =>
        'max-w-[1600px]',

    'full' =>
        'max-w-full',

    default =>
        'max-w-7xl',

};



/*
|--------------------------------------------------------------------------
| Padding
|--------------------------------------------------------------------------
*/

$padding = match($settings['padding'] ?? 'medium') {

    'none' =>
        '',

    'small' =>
        'py-10',

    'large' =>
        'py-32',

    default =>
        'py-20',

};



/*
|--------------------------------------------------------------------------
| Colors
|--------------------------------------------------------------------------
*/

$textColor = $settings['text_color'] ?? 'dark';


$titleClass =
    $textColor === 'light'
        ? 'text-white'
        : 'text-gray-900';



$descriptionClass =
    $textColor === 'light'
        ? 'text-gray-200'
        : 'text-gray-600';




/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/


$title = $data['title'] ?? null;

$description = $data['description'] ?? null;

$cards = $data['cards'] ?? [];




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


    if(is_array($image)) {

        $image = reset($image);

    }


    $image =
        str_replace(
            'livewire-file:',
            '',
            $image
        );


    $backgroundImage =
        asset('storage/'.$image);

}




/*
|--------------------------------------------------------------------------
| Custom
|--------------------------------------------------------------------------
*/


$customClass =
    $settings['custom_class'] ?? '';


$customCss =
    $settings['custom_css'] ?? '';



@endphp





<section
    class="
        relative
        overflow-hidden
        {{ $customClass }}
    "

    @if($customCss)

        style="{{ $customCss }}"

    @endif
>



@if($backgroundColor)

<div
    class="absolute inset-0"
    style="
        background-color:
        {{ $backgroundColor }};
    "
></div>

@endif





@if($backgroundImage)

<div
    class="
        absolute
        inset-0
        bg-cover
        bg-center
    "

    style="
        background-image:
        url('{{ $backgroundImage }}');
    "
></div>

@endif





<div
    class="
        relative
        z-10
        {{ $container }}
        mx-auto
        px-6
        {{ $padding }}
    "
>



@if($title || $description)


<div
    class="
        max-w-3xl
        mx-auto
        text-center
        mb-12
    "
>


@if($title)

<h2
    class="
        text-3xl
        font-extrabold
        {{ $titleClass }}
    "
>

{{ $title }}

</h2>

@endif




@if($description)

<p
    class="
        mt-4
        text-lg
        {{ $descriptionClass }}
    "
>

{{ $description }}

</p>

@endif


</div>


@endif







@if(empty($cards))


<div
    class="
        text-center
        {{ $descriptionClass }}
    "
>

{{ __('blocks.cards.empty') }}

</div>



@else



<div
    class="
        grid
        grid-cols-1
        md:grid-cols-2
        lg:grid-cols-3
        gap-8
    "
>



@foreach($cards as $card)



<article
    class="
        bg-white
        dark:bg-slate-800
        rounded-2xl
        shadow
        p-6
        transition
        hover:-translate-y-1
    "
>



@if(!empty($card['icon']))


<div
    class="
        text-4xl
        mb-5
    "
>

{!! $card['icon'] !!}

</div>


@endif






@if(!empty($card['title']))


<h3
    class="
        text-xl
        font-bold
        {{ $titleClass }}
    "
>

{{ $card['title'] }}

</h3>


@endif






@if(!empty($card['description']))


<p
    class="
        mt-3
        text-sm
        {{ $descriptionClass }}
    "
>

{{ $card['description'] }}

</p>


@endif






@if(!empty($card['button_url']))


<a
    href="{{ $card['button_url'] }}"

    class="
        inline-flex
        items-center
        gap-2
        mt-6
        text-blue-600
        font-semibold
        hover:underline
    "
>


{{ $card['button_text'] ?? __('blocks.cards.read_more') }}


<svg
    xmlns="http://www.w3.org/2000/svg"
    class="w-4 h-4"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
>

<path
stroke-linecap="round"
stroke-linejoin="round"
stroke-width="2"
d="M9 5l7 7-7 7"
/>

</svg>


</a>


@endif






</article>



@endforeach


</div>



@endif




</div>


</section>