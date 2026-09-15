@php

use App\Blocks\Helpers\DividerShapes;


$data = $block->data ?? [];

$settings = $block->settings ?? [];


if (($settings['visible'] ?? true) === false) {
    return;
}



$type = $data['type'] ?? 'line';

$style = $data['style'] ?? 'solid';

$shape = $data['shape'] ?? 'wave';

$color = $data['color'] ?? '#e5e7eb';

$thickness = $data['thickness'] ?? 1;



$height = match($data['height'] ?? 'medium') {

    'small' => 'py-4',

    'large' => 'py-16',

    'xl'    => 'py-24',

    default => 'py-8',

};



$width = match($data['width'] ?? 'full') {

    'small'  => 'max-w-xs',

    'medium' => 'max-w-xl',

    'large'  => 'max-w-5xl',

    default  => 'max-w-full',

};



$flip = ($data['flip'] ?? false)
    ? 'rotate-180'
    : '';



$customClass = $settings['custom_class'] ?? '';

$customCss = $settings['custom_css'] ?? '';

@endphp





<section

id="{{ $settings['section_id'] ?? '' }}"

class="
w-full
{{ $height }}
{{ $customClass }}
"

@if($customCss)

style="{{ $customCss }}"

@endif

>


<div class="
mx-auto
px-4
sm:px-6
lg:px-8
{{ $width }}
">



{{-- ================================= --}}
{{-- Shape Divider --}}
{{-- ================================= --}}

@if($type === 'shape')


<div

class="
w-full
overflow-hidden
{{ $flip }}
"

>

{!! DividerShapes::render(
    $shape,
    $color
) !!}

</div>





{{-- ================================= --}}
{{-- Spacer --}}
{{-- ================================= --}}

@elseif($type === 'space')


<div class="w-full"></div>





{{-- ================================= --}}
{{-- Gradient Divider --}}
{{-- ================================= --}}

@elseif($type === 'gradient')


<div

class="w-full"

style="
height: {{ $thickness }}px;

background:
linear-gradient(
90deg,
transparent,
{{ $color }},
transparent
);

"

></div>





{{-- ================================= --}}
{{-- Line Divider --}}
{{-- ================================= --}}

@else


<div

class="w-full"

style="

border-top-width:
{{ $thickness }}px;


border-color:
{{ $color }};


@if($style === 'dashed')

border-style:dashed;

@elseif($style === 'dotted')

border-style:dotted;

@else

border-style:solid;

@endif

"

></div>



@endif



</div>


</section>