@extends('layouts.public')

@section('content')

<div class="min-h-screen bg-gray-50 py-16 dark:bg-gray-950">

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-10 text-center">

            <span class="mb-3 inline-block text-sm font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                Customer Feedback
            </span>

            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Share Your Experience
            </h1>

            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-gray-600 dark:text-gray-400">
                We would love to hear about your experience with our platform.
                Your testimonial may be published on our website after review.
            </p>

        </div>


        {{-- Success Message --}}
        @if (session('testimonial_success'))

            <div
                class="mb-8 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-800 dark:bg-green-950/40 dark:text-green-300"
                role="alert"
            >
                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                    <div>
                        <p class="font-semibold">
                            Thank you!
                        </p>

                        <p class="mt-1 text-sm">
                            {{ session('testimonial_success') }}
                        </p>
                    </div>

                </div>
            </div>

        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div
                class="mb-8 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300"
                role="alert"
            >

                <p class="font-semibold">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-disc space-y-1 ps-5 text-sm">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form
                method="POST"
                action="{{ route('testimonials.store', ['locale' => app()->getLocale()]) }}"
                enctype="multipart/form-data"
                class="p-6 sm:p-8"
            >

                @csrf


                {{-- Customer Information --}}
                <div class="mb-8">

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Your Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Basic information about you.
                    </p>

                </div>


                <div class="grid gap-6 sm:grid-cols-2">


                    {{-- Name --}}
                    <div>

                        <label
                            for="name"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            maxlength="255"
                            autocomplete="name"
                            placeholder="Your name"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                    </div>


                    {{-- Email --}}
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            maxlength="255"
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                    </div>


                    {{-- Company --}}
                    <div>

                        <label
                            for="company"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Company
                        </label>

                        <input
                            type="text"
                            id="company"
                            name="company"
                            value="{{ old('company') }}"
                            maxlength="255"
                            placeholder="Company name"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                    </div>


                    {{-- Position --}}
                    <div>

                        <label
                            for="position"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Position
                        </label>

                        <input
                            type="text"
                            id="position"
                            name="position"
                            value="{{ old('position') }}"
                            maxlength="255"
                            placeholder="Your position"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                    </div>

                </div>


                {{-- Avatar --}}
                <div class="mt-6">

                    <label
                        for="avatar"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Profile Photo
                    </label>

                    <input
                        type="file"
                        id="avatar"
                        name="avatar"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 file:me-4 file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-sm file:font-medium dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:file:bg-gray-700"
                    >

                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        JPG, JPEG, PNG or WEBP. Maximum size: 2 MB.
                    </p>

                </div>


                {{-- Rating --}}
                <div class="mt-8">

                    <label
                        for="rating"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Your Rating
                    </label>

                    <select
                        id="rating"
                        name="rating"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:max-w-xs"
                    >

                        <option value="">
                            Select rating
                        </option>

                        @for ($i = 5; $i >= 1; $i--)

                            <option
                                value="{{ $i }}"
                                @selected(old('rating') == $i)
                            >
                                {{ str_repeat('★', $i) }} — {{ $i }}/5
                            </option>

                        @endfor

                    </select>

                </div>


                {{-- Message --}}
                <div class="mt-8">

                    <label
                        for="message"
                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Your Testimonial
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="7"
                        required
                        minlength="10"
                        maxlength="2000"
                        placeholder="Tell us about your experience..."
                        class="block w-full resize-y rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm leading-6 text-gray-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >{{ old('message') }}</textarea>

                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Your testimonial should be between 10 and 2000 characters.
                    </p>

                </div>


                {{-- Notice --}}
                <div class="mt-8 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z"
                            />
                        </svg>

                        <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                            Your testimonial will first be reviewed by our team.
                            Only approved testimonials may appear publicly on the website.
                        </p>

                    </div>

                </div>


                {{-- Submit --}}
                <div class="mt-8 flex items-center justify-end">

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                    >

                        Submit Testimonial

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection