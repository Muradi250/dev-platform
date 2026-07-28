@extends('layouts.public')


@section('title', 'Dev-Platform')


@section('description', 'Digital Organization Management Platform')


@section('content')

<section class="py-20 text-center">

    <h1 class="text-4xl font-bold text-blue-600">
        Dev-Platform
    </h1>


    <p class="mt-5 text-gray-600">

        Digital Organization Management Platform

    </p>


    <p class="mt-3">

        Current Language:
        {{ app()->getLocale() }}

    </p>


</section>

@endsection