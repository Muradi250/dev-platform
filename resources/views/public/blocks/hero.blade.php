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




$textColor = $data['text_color']
    ?? $settings['text_color']
    ?? 'light';



$titleClass = $textColor === 'dark'
    ? 'text-gray-900'
    : 'text-white';



$descriptionClass = $textColor === 'dark'
    ? 'text-gray-700'
    : 'text-gray-200';




$layout = $data['layout'] ?? 'split';



$height = match($data['height'] ?? 'large') {


    'screen'=>'min-h-screen',

    'medium'=>'min-h-[70vh]',

    default=>'min-h-[85vh]',


};




$eyebrow = $data['eyebrow'] ?? null;

$badge = $data['badge'] ?? null;

$title = $data['title'] ?? 'Welcome';

$highlight = $data['highlight'] ?? null;

$description = $data['description'] ?? null;




$primaryText = $data['primary_button_text'] ?? null;

$primaryUrl = $data['primary_button_url'] ?? '#';



$secondaryText = $data['secondary_button_text'] ?? null;

$secondaryUrl = $data['secondary_button_url'] ?? '#';




$mediaType = $data['media_type'] ?? 'dashboard';

$mediaUrl = $data['media_url'] ?? null;




$animation = match($data['animation'] ?? 'none') {


    'fade'=>'animate-fade',

    'slide'=>'animate-slide',

    'zoom'=>'animate-zoom',

    default=>'',

};




$backgroundColor = $settings['background']['color'] ?? null;



$backgroundImage = null;


if(!empty($settings['background']['image'])) {


    $image = $settings['background']['image'];


    if(is_array($image)) {

        $image = reset($image);

    }


    $image = str_replace('livewire-file:','',$image);


    $backgroundImage = asset('storage/'.$image);

}




$customClass = $settings['custom_class'] ?? '';

$customCss = $settings['custom_css'] ?? '';



@endphp




<section

class="
relative
overflow-hidden
{{ $height }}
flex
items-center
{{ $customClass }}
"


@if($customCss)

style="{{ $customCss }}"

@endif

>



{{-- Background --}}


<div

class="
absolute
inset-0

@if($backgroundColor)

@endif

"

@if($backgroundColor)

style="background-color:{{ $backgroundColor }}"

@endif

>


@if($backgroundImage)


<div

class="
absolute
inset-0
bg-cover
bg-center
"

style="
background-image:url('{{ $backgroundImage }}');
">

</div>


@else


<div class="
absolute
inset-0
bg-gradient-to-br
from-slate-950
via-blue-900
to-indigo-900
">

</div>


@endif



<div class="
absolute
inset-0
bg-black/20
">

</div>



</div>







<div class="
relative
z-10
{{ $container }}
mx-auto
w-full
px-6
{{ $padding }}
">






@if($layout === 'center')



<div class="
max-w-5xl
mx-auto
text-center
{{ $animation }}
">


@if($eyebrow)

<p class="
text-sm
uppercase
tracking-widest
text-blue-300
mb-4
">

{{ $eyebrow }}

</p>

@endif




@if($badge)

<span class="
inline-flex
px-5
py-2
rounded-full
bg-white/10
border
border-white/20
text-white
mb-6
">

{{ $badge }}

</span>

@endif





<h1 class="
text-5xl
md:text-7xl
font-extrabold
leading-tight
{{ $titleClass }}
">


{{ $title }}


@if($highlight)


<span class="text-blue-400">

{{ $highlight }}

</span>


@endif


</h1>





<p class="
mt-6
text-xl
leading-relaxed
{{ $descriptionClass }}
">

{{ $description }}

</p>






<div class="
mt-10
flex
justify-center
gap-4
flex-wrap
">


@if($primaryText)

<a

href="{{ $primaryUrl }}"

class="
px-8
py-4
rounded-xl
bg-blue-600
text-white
font-semibold
hover:bg-blue-700
transition
">

{{ $primaryText }}

</a>

@endif




@if($secondaryText)

<a

href="{{ $secondaryUrl }}"

class="
px-8
py-4
rounded-xl
bg-white/10
border
border-white/20
text-white
">

{{ $secondaryText }}

</a>

@endif


</div>


</div>





@else



<div class="
grid
grid-cols-1
lg:grid-cols-2
gap-14
items-center
{{ $animation }}
">





<div>



@if($eyebrow)

<p class="
text-blue-300
uppercase
tracking-widest
mb-4
">

{{ $eyebrow }}

</p>

@endif



@if($badge)

<span class="
inline-flex
px-5
py-2
rounded-full
bg-white/10
border
border-white/20
text-white
mb-6
">

{{ $badge }}

</span>

@endif





<h1 class="
text-4xl
md:text-6xl
font-extrabold
leading-tight
{{ $titleClass }}
">


{{ $title }}


@if($highlight)

<span class="text-blue-400">

{{ $highlight }}

</span>

@endif


</h1>





<p class="
mt-6
text-lg
md:text-xl
{{ $descriptionClass }}
">

{{ $description }}

</p>





<div class="
mt-10
flex
gap-4
flex-wrap
">


@if($primaryText)

<a

href="{{ $primaryUrl }}"

class="
px-8
py-4
rounded-xl
bg-blue-600
text-white
font-semibold
">

{{ $primaryText }}

</a>

@endif



@if($secondaryText)

<a

href="{{ $secondaryUrl }}"

class="
px-8
py-4
rounded-xl
bg-white/10
text-white
border
border-white/20
">

{{ $secondaryText }}

</a>

@endif



</div>


</div>







<div class="flex justify-center">



@if($mediaType === 'image' && $mediaUrl)


<img

src="{{ $mediaUrl }}"

class="
rounded-3xl
shadow-2xl
max-w-full
"

>


@elseif($mediaType === 'video' && $mediaUrl)


<video

controls

class="
rounded-3xl
shadow-2xl
"

>

<source src="{{ $mediaUrl }}">

</video>



@else



<div class="
w-full
max-w-md
rounded-3xl
bg-white/10
backdrop-blur-xl
border
border-white/20
shadow-2xl
p-8
text-white
">


<h3 class="
text-2xl
font-bold
mb-6
">

{{ __('blocks.hero.dashboard_title') }}

</h3>



<div class="space-y-4">


<div class="bg-white/10 rounded-xl p-4">

Users

<strong class="float-right">

{{ $data['stats_users'] ?? 0 }}

</strong>

</div>



<div class="bg-white/10 rounded-xl p-4">

Organizations

<strong class="float-right">

{{ $data['stats_organizations'] ?? 0 }}

</strong>

</div>



<div class="bg-white/10 rounded-xl p-4">

Modules

<strong class="float-right">

{{ $data['stats_modules'] ?? 0 }}

</strong>

</div>


</div>


</div>



@endif



</div>




</div>




@endif



</div>


</section>



@if($customCss)

<style>

{!! $customCss !!}

</style>

@endif