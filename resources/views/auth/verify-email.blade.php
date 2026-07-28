<x-guest-layout>


    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">

        {{ __('auth.message_verify_intro') }}

    </div>




    @if (session('status') == 'verification-link-sent')


        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">

            {{ __('auth.message_verified') }}

        </div>


    @endif





    <div class="mt-4 flex items-center justify-between">





        <!-- Resend Verification Email -->


        <form method="POST" action="{{ route('verification.send', [
            'locale' => request()->route('locale') ?? app()->getLocale()
        ]) }}">


            @csrf



            <div>

                <x-primary-button>

                    {{ __('auth.button_resend_verification') }}

                </x-primary-button>


            </div>


        </form>







        <!-- Logout -->


        <form method="POST" action="{{ route('logout', [
            'locale' => request()->route('locale') ?? app()->getLocale()
        ]) }}">


            @csrf



            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">


                {{ __('auth.button_logout') }}


            </button>


        </form>




    </div>


</x-guest-layout>