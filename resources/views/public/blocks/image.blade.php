@php

$data = $block->data ?? [];

$settings = $block->settings ?? [];



if (($settings['visible'] ?? true) === false) {
    return;
}



$image = $data['image'] ?? null;


if (!$image) {
    return;
}



$title = $data['title'] ?? '';

$description = $data['description'] ?? '';

$caption = $data['caption'] ?? '';

$alt = $data['alt'] ?? $title;



$position = match($data['position'] ?? 'center') {

    'left' => 'justify-start',

    'right' => 'justify-end',

    default => 'justify-center',

};



$style = match($data['style'] ?? 'normal') {

    'card' => 'bg-white p-4 rounded-2xl',

    'circle' => 'rounded-full overflow-hidden',

    'full' => 'w-full',

    default => '',

};



$ratio = match($data['ratio'] ?? 'auto') {

    'square' => 'aspect-square',

    '16/9' => 'aspect-video',

    '4/3' => 'aspect-[4/3]',

    '3/2' => 'aspect-[3/2]',

    default => '',

};



$radius = match($data['radius'] ?? 'medium') {

    'none' => 'rounded-none',

    'small' => 'rounded-md',

    'large' => 'rounded-3xl',

    'full' => 'rounded-full',

    default => 'rounded-xl',

};



$shadow = match($data['shadow'] ?? 'none') {

    'small' => 'shadow-sm',

    'medium' => 'shadow-md',

    'large' => 'shadow-xl',

    default => '',

};



$hover = match($data['hover'] ?? 'none') {

    'zoom' => 'transition duration-500 hover:scale-105',

    'lift' => 'transition duration-300 hover:-translate-y-2',

    'gray' => 'transition duration-500 grayscale hover:grayscale-0',

    default => '',

};



$fit = match($data['fit'] ?? 'cover') {

    'contain' => 'object-contain',

    default => 'object-cover',

};



$link = $data['link'] ?? null;


$newTab = ($data['new_tab'] ?? false)
    ? '_blank'
    : '';

@endphp




<section

id="{{ $settings['section_id'] ?? '' }}"

class="
w-full
{{ $settings['custom_class'] ?? '' }}
"

@if(!empty($settings['custom_css']))

style="{{ $settings['custom_css'] }}"

@endif

>


<div

class="
flex
{{ $position }}
w-full
"

>


@if($link)

<a

href="{{ $link }}"

@if($newTab)

target="{{ $newTab }}"

rel="noopener noreferrer"

@endif

class="block"

>

@endif





<figure

class="
overflow-hidden
{{ $style }}
{{ $radius }}
{{ $shadow }}
{{ $hover }}
"

>



<img

src="{{ asset('storage/'.$image) }}"

alt="{{ $alt }}"

loading="{{ ($data['lazy'] ?? true) ? 'lazy' : 'eager' }}"

class="
w-full
h-full
{{ $ratio }}
{{ $fit }}
"

>





@if($caption)

<figcaption

class="
text-sm
text-gray-500
mt-3
text-center
"

>

{{ $caption }}

</figcaption>

@endif



</figure>




@if($link)

</a>

@endif



</div>





@if($title || $description)

<div class="mt-6 text-center">


@if($title)

<h3 class="text-2xl font-bold">

{{ $title }}

</h3>

@endif



@if($description)

<p class="mt-3 text-gray-600">

{{ $description }}

</p>

@endif


</div>

@endif



</section>