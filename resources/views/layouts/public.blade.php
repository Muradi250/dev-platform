<!DOCTYPE html>
<html 
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['fa', 'ps']) ? 'rtl' : 'ltr' }}"
>

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>
        @yield('title', 'Dev-Platform')
    </title>


    <meta name="description"
          content="@yield('description', 'Dev-Platform Digital Organization Management Platform')">


    <meta name="keywords"
          content="@yield('keywords', 'Laravel, ERP, HR, Finance, Accounting, Digital Platform')">


    <meta name="author"
          content="Dev-Platform">


    {{-- 
        CSRF Token
        برای درخواست‌های آینده
    --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">



    {{-- 
        Vite Assets
        Tailwind + Alpine.js
    --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])



    {{-- Page Custom Styles --}}
    @stack('styles')


</head>



<body class="bg-white text-gray-900 antialiased">


    {{-- 
    |--------------------------------------------------------------------------
    | Public Navigation
    |--------------------------------------------------------------------------
    --}}

    @include('public.partials.navbar')




    {{-- 
    |--------------------------------------------------------------------------
    | Main Content
    |--------------------------------------------------------------------------
    --}}

    <main class="min-h-screen">

        @yield('content')

    </main>




    {{-- 
    |--------------------------------------------------------------------------
    | Public Footer
    |--------------------------------------------------------------------------
    --}}

    @include('public.partials.footer')




    {{-- Page Custom Scripts --}}
    @stack('scripts')


</body>


</html>