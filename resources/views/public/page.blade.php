@extends('layouts.public')

@section('title', $page->seo_title ?: $page->title)

@section('description', $page->seo_description ?: '')

@section('keywords', $page->seo_keywords ?? '')

@section('content')

@php

/*
|--------------------------------------------------------------------------
| PAGE SETTINGS
|--------------------------------------------------------------------------
|
| Normalize page settings so Template & Layout receives
| one predictable array structure.
|
*/

$rawSettings = $settings ?? null;

if (
    ! is_array($rawSettings) &&
    isset($page) &&
    is_object($page)
) {
    $rawSettings = $page->settings ?? null;
}

if (is_string($rawSettings)) {

    $decodedSettings = json_decode(
        $rawSettings,
        true
    );

    $rawSettings = is_array($decodedSettings)
        ? $decodedSettings
        : [];

}

$pageSettings = is_array($rawSettings)
    ? $rawSettings
    : [];

@endphp


{{-- =========================================================================
     TEMPLATE & LAYOUT
============================================================================= --}}

@include('public.partials.template-layout', [
    'page' => $page,
    'blocks' => $blocks,
    'pageSettings' => $pageSettings,
])

@endsection