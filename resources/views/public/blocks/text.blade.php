@php

/*
|--------------------------------------------------------------------------
| Text Block Renderer V2
|--------------------------------------------------------------------------
|
| مسئول نمایش Text Block در Page Builder
|
| Architecture:
|
| Page
|   |
|   └── PageBlock
|          |
|          ├── data
|          |     ├── badge
|          |     ├── heading
|          |     ├── content
|          |     ├── button_text
|          |     ├── button_url
|          |     ├── alignment
|          |     └── style
|          |
|          └── settings
|                ├── container
|                ├── padding
|                ├── background
|                ├── text_color
|                ├── visible
|                └── custom_class
|
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Block Data
|--------------------------------------------------------------------------
*/


$data = $block->data ?? [];


$settings = $block->settings ?? [];





/*
|--------------------------------------------------------------------------
| Visibility
|--------------------------------------------------------------------------
|
| اگر Block از پنل غیرفعال باشد
| چیزی رندر نمی‌شود.
|
|--------------------------------------------------------------------------
*/


if (
    ($settings['visible'] ?? true) === false
) {

    return;

}






/*
|--------------------------------------------------------------------------
| Container
|--------------------------------------------------------------------------
*/


$container = match(
    $settings['container'] ?? 'default'
)

{


    'wide'
        =>
        'max-w-[1600px]',


    'full'
        =>
        'max-w-full',



    default
        =>
        'max-w-7xl',


};








/*
|--------------------------------------------------------------------------
| Padding
|--------------------------------------------------------------------------
*/


$padding = match(
    $settings['padding'] ?? 'medium'
)

{


    'none'
        =>
        '',



    'small'
        =>
        'py-10',




    'large'
        =>
        'py-32',




    default
        =>
        'py-20',


};








/*
|--------------------------------------------------------------------------
| Text Color
|--------------------------------------------------------------------------
*/


$textColor =
    $settings['text_color']
    ??
    'dark';





$titleClass =
    $textColor === 'light'

    ? 'text-white'

    :

    'text-gray-900';





$contentClass =
    $textColor === 'light'

    ? 'text-gray-200'

    :

    'text-gray-600';









/*
|--------------------------------------------------------------------------
| Text Data
|--------------------------------------------------------------------------
*/


$badge =
    $data['badge']
    ??
    null;



$heading =
    $data['heading']
    ??
    '';



$content =
    $data['content']
    ??
    '';





/*
|--------------------------------------------------------------------------
| Button
|--------------------------------------------------------------------------
*/


$buttonText =
    $data['button_text']
    ??
    null;



$buttonUrl =
    $data['button_url']
    ??
    '#';







/*
|--------------------------------------------------------------------------
| Alignment
|--------------------------------------------------------------------------
*/


$alignment = match(
    $data['alignment'] ?? 'center'
)

{


    'left'
        =>
        'text-left',



    'right'
        =>
        'text-right',



    default
        =>
        'text-center',


};








/*
|--------------------------------------------------------------------------
| Style
|--------------------------------------------------------------------------
*/


$style =
    $data['style']
    ??
    'default';






/*
|--------------------------------------------------------------------------
| Background
|--------------------------------------------------------------------------
*/


$backgroundColor =
    $settings['background']['color']
    ??
    null;



$backgroundImage = null;




if (
    !empty(
        $settings['background']['image']
    )
)

{


    $image =
        $settings['background']['image'];



    if(
        is_array($image)
    )

    {

        $image =
            reset($image);

    }





    $backgroundImage =
        asset(
            'storage/'.$image
        );

}






/*
|--------------------------------------------------------------------------
| Custom Class
|--------------------------------------------------------------------------
*/


$customClass =
    $settings['custom_class']
    ??
    '';



@endphp
<!--
|--------------------------------------------------------------------------
| Text Block Layout
|--------------------------------------------------------------------------
|
| شروع HTML Renderer
|
|--------------------------------------------------------------------------
-->


<section

class="
relative
overflow-hidden
{{ $customClass }}
"

@if($backgroundColor)

style="
background-color: {{ $backgroundColor }};
"

@endif

>



{{-- 
|--------------------------------------------------------------------------
| Background Image
|--------------------------------------------------------------------------
|
| نمایش تصویر پس زمینه از:
|
| storage/app/public/blocks/backgrounds
|
| توسط:
|
| public/storage
|
|--------------------------------------------------------------------------
--}}



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


@endif







{{-- 
|--------------------------------------------------------------------------
| Background Overlay
|--------------------------------------------------------------------------
--}}



@if($backgroundImage)


<div

class="
absolute
inset-0
bg-black/30
">

</div>


@endif







<div

class="
relative
z-10
{{ $container }}
mx-auto
px-6
{{ $padding }}
">







@if($style === 'card')



<div

class="
bg-white
rounded-3xl
shadow-xl
border
border-gray-100
p-10
"

>


@endif







@if($style === 'glass')



<div

class="
bg-white/10
backdrop-blur-xl
rounded-3xl
border
border-white/20
p-10
"

>


@endif







@if($style === 'dark')



<div

class="
bg-gray-900
rounded-3xl
p-10
"

>


@endif







@if($style === 'gradient')


<div

class="
rounded-3xl
p-10
bg-gradient-to-br
from-blue-600
to-indigo-700
"

>


@endif







<div

class="
max-w-4xl
mx-auto
{{ $alignment }}
"

>







{{-- 
|--------------------------------------------------------------------------
| Badge
|--------------------------------------------------------------------------
--}}



@if($badge)


<span

class="
inline-flex
mb-6
px-5
py-2
rounded-full
bg-blue-100
text-blue-700
font-semibold
text-sm
"

>

{{ $badge }}

</span>


@endif







{{-- 
|--------------------------------------------------------------------------
| Heading
|--------------------------------------------------------------------------
--}}



@if($heading)


<h2

class="
text-4xl
md:text-6xl
font-extrabold
leading-tight
{{ $titleClass }}
"

>


{{ $heading }}


</h2>


@endif










{{-- 
|--------------------------------------------------------------------------
| Content
|--------------------------------------------------------------------------
|
| اجازه HTML ساده برای Editor آینده
|
|--------------------------------------------------------------------------
--}}



@if($content)


<div

class="
mt-6
text-xl
leading-relaxed
{{ $contentClass }}
"

>


{!! nl2br(e($content)) !!}


</div>


@endif











{{-- 
|--------------------------------------------------------------------------
| Button
|--------------------------------------------------------------------------
--}}



@if($buttonText)



<a

href="{{ $buttonUrl }}"

class="
inline-flex
mt-10
px-8
py-4
rounded-xl
bg-blue-600
hover:bg-blue-700
transition
text-white
font-semibold
shadow-lg
"

>


{{ $buttonText }}


</a>


@endif







</div>








{{-- 
|--------------------------------------------------------------------------
| Close Style Wrapper
|--------------------------------------------------------------------------
--}}



@if(
    in_array(
        $style,
        [
            'card',
            'glass',
            'dark',
            'gradient'
        ]
    )
)


</div>


@endif







</div>



</section>