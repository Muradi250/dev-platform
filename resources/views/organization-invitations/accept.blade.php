<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Organization invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Join {{ $membership->organization->name }}
                </h1>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    You have been invited as a {{ $membership->role }}. Accepting will add this account to the organization.
                </p>

                @if ($errors->has('invitation'))
                    <p class="mt-4 text-sm text-red-600">
                        {{ $errors->first('invitation') }}
                    </p>
                @endif

                <form method="post" action="{{ request()->fullUrl() }}" class="mt-6">
                    @csrf
                    <x-primary-button>Accept invitation</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
