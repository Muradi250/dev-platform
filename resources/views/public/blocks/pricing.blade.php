@php

$data = $block->data ?? [];

$settings = $block->settings ?? [];


if (($settings['visible'] ?? true) === false) {
    return;
}



$container = match($settings['container'] ?? 'default') {

    'wide' => 'max-w-[1600px]',

    'full' => 'max-w-full',

    default => 'max-w-7xl',

};



$padding = match($settings['padding'] ?? 'medium') {

    'none' => '',

    'small' => 'py-10',

    'large' => 'py-32',

    default => 'py-20',

};



$textColor = $settings['text_color'] ?? 'dark';


$titleClass = $textColor === 'dark'
    ? 'text-gray-900'
    : 'text-white';


$descriptionClass = $textColor === 'dark'
    ? 'text-gray-600'
    : 'text-gray-200';




$backgroundColor = $settings['background']['color'] ?? null;


$backgroundImage = null;


if (!empty($settings['background']['image'])) {


    $image = $settings['background']['image'];


    if(is_array($image)) {

        $image = reset($image);

    }


    $image = str_replace('livewire-file:', '', $image);


    $backgroundImage = asset('storage/'.$image);

}




$customClass = $settings['custom_class'] ?? '';

$customCss = $settings['custom_css'] ?? '';



$badge = $data['badge'] ?? null;

$title = $data['title'] ?? 'Choose Your Plan';

$description = $data['description'] ?? null;

$currency = $data['currency'] ?? '$';

$plans = $data['plans'] ?? [];

@endphp



<section

class="
{{ $padding }}
{{ $customClass }}
relative
"

@if($backgroundColor)

style="background-color:{{ $backgroundColor }}"

@endif


@if($backgroundImage)

style="
background-image:url('{{ $backgroundImage }}');
background-size:cover;
background-position:center;
"

@endif

>



<div class="
{{ $container }}
mx-auto
px-6
">


{{-- Header --}}


<div class="text-center mb-16">


@if($badge)

<div class="
inline-flex
px-4
py-2
rounded-full
bg-blue-100
text-blue-600
text-sm
font-semibold
mb-5
">

{{ $badge }}

</div>

@endif



<h2 class="
text-4xl
md:text-5xl
font-bold
{{ $titleClass }}
">

{{ $title }}

</h2>



@if($description)

<p class="
mt-5
max-w-3xl
mx-auto
text-lg
{{ $descriptionClass }}
">

{{ $description }}

</p>

@endif


</div>




@if(empty($plans))


<div class="text-center text-gray-500">

{{ __('blocks.pricing.empty') }}

</div>



@else



<div class="
grid
grid-cols-1
md:grid-cols-2
lg:grid-cols-3
gap-8
">



@foreach($plans as $plan)


@php

$featured = $plan['featured'] ?? false;

$features = $plan['features'] ?? [];

@endphp




<div class="
relative
bg-white
rounded-3xl
p-8
shadow-xl
transition
duration-300
hover:-translate-y-2

@if($featured)

ring-2
ring-blue-600

@endif

">



{{-- Badge --}}


@if(!empty($plan['badge']))


<div class="
inline-flex
mb-5
px-4
py-2
rounded-full
text-sm
font-bold

@if($featured)

bg-blue-600
text-white

@else

bg-gray-100
text-gray-700

@endif

">

{{ $plan['badge'] }}

</div>


@endif




{{-- Name --}}


<h3 class="
text-2xl
font-bold
text-gray-900
">

{{ $plan['name'] ?? '' }}

</h3>




@if(!empty($plan['description']))


<p class="
mt-3
text-gray-600
">

{{ $plan['description'] }}

</p>


@endif






{{-- Price --}}


<div class="
mt-6
flex
items-end
gap-2
">


@if(!empty($plan['old_price']))


<span class="
text-gray-400
line-through
text-lg
">

{{ $currency }}{{ $plan['old_price'] }}

</span>


@endif



<span class="
text-5xl
font-bold
text-gray-900
">

{{ $currency }}{{ $plan['price'] ?? '' }}

</span>



@if(!empty($plan['period']))


<span class="
text-gray-500
mb-2
">

{{ $plan['period'] }}

</span>


@endif


</div>






{{-- Features --}}


<ul class="
mt-8
space-y-4
">


@foreach($features as $feature)


<li class="
flex
items-center
gap-3
">


@if(($feature['included'] ?? true))


<span class="text-green-600 font-bold">

✓

</span>


@else


<span class="text-red-500 font-bold">

×

</span>


@endif



<span class="text-gray-700">

{{ $feature['feature'] ?? '' }}

</span>



</li>


@endforeach


</ul>






{{-- Button --}}


@if(!empty($plan['button_text']))


<a

href="{{ $plan['button_url'] ?? '#' }}"

class="
mt-10
block
w-full
text-center
rounded-xl
px-6
py-3
font-semibold
transition

@if($featured)

bg-blue-600
text-white
hover:bg-blue-700

@else

bg-gray-900
text-white
hover:bg-gray-800

@endif

"

>

{{ $plan['button_text'] }}

</a>


@endif




</div>



@endforeach



</div>



@endif



</div>


</section>




@if($customCss)

<style>

{!! $customCss !!}

</style>

@endif