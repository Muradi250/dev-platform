@extends('layouts.public')

@section('content')
    <main class="min-h-screen bg-gray-50 py-16 dark:bg-gray-950">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <header class="mb-10 text-center">
                <span class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">
                    <x-filament::icon icon="heroicon-o-play-circle" class="h-5 w-5" />
                    {{ __('demo_requests.eyebrow') }}
                </span>

                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('demo_requests.title') }}
                </h1>

                <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-gray-600 dark:text-gray-400">
                    {{ __('demo_requests.intro') }}
                </p>
            </header>

            @if (session('demo_request_success'))
                <div
                    class="mb-8 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-800 dark:bg-green-950/40 dark:text-green-300"
                    role="status"
                >
                    {{ __('demo_requests.success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-8 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300"
                    role="alert"
                >
                    <p class="font-semibold">{{ __('demo_requests.error_heading') }}</p>
                    <ul class="mt-2 list-disc space-y-1 ps-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <form
                    method="POST"
                    action="{{ route('demo-requests.store', ['locale' => app()->getLocale()]) }}"
                    class="space-y-6 p-6 sm:p-8"
                >
                    @csrf

                    <div
                        aria-hidden="true"
                        style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;"
                    >
                        <label for="demo-website">{{ __('demo_requests.website') }}</label>
                        <input id="demo-website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.name') }} *
                            </label>
                            <input id="name" name="name" type="text" required maxlength="255" autocomplete="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.email') }} *
                            </label>
                            <input id="email" name="email" type="email" required maxlength="255" autocomplete="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </div>

                        <div>
                            <label for="company" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.company') }} *
                            </label>
                            <input id="company" name="company" type="text" required maxlength="255" autocomplete="organization"
                                value="{{ old('company') }}"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </div>

                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.phone') }}
                            </label>
                            <input id="phone" name="phone" type="tel" maxlength="50" autocomplete="tel"
                                value="{{ old('phone') }}"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="team_size" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.team_size') }}
                            </label>
                            <select id="team_size" name="team_size"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                                <option value="">{{ __('demo_requests.select_team_size') }}</option>
                                @foreach (['1-10', '11-50', '51-200', '201+'] as $size)
                                    <option value="{{ $size }}" @selected(old('team_size') === $size)>{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="message" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ __('demo_requests.message') }}
                            </label>
                            <textarea id="message" name="message" rows="4" maxlength="2000"
                                class="w-full rounded-xl border-gray-300 bg-white text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-950 dark:text-white">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 border-t border-gray-100 pt-6 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                            {{ __('demo_requests.privacy') }}
                        </p>
                        <button type="submit"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <x-filament::icon icon="heroicon-o-paper-airplane" class="h-5 w-5" />
                            {{ __('demo_requests.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
