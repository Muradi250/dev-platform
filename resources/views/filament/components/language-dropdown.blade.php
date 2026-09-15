<div>
    <!-- An unexamined life is not worth living. - Socrates -->
</div>
<div
    x-data="{ open: false }"
    class="relative"
>

    <button
        @click="open = !open"
        class="flex items-center gap-2 w-full px-3 py-2 rounded-lg hover:bg-gray-100"
    >

        <span>
            🌐 Language
        </span>

        <span>
            ▾
        </span>

    </button>


    <div
        x-show="open"
        x-cloak
        class="mt-2 rounded-lg border bg-white shadow-lg overflow-hidden"
    >

        <a
           href="{{ route('admin.language', 'en') }}"
            class="block px-4 py-2 hover:bg-gray-100"
        >
            🇬🇧 English
        </a>


        <a
            href="{{ route('admin.language', 'fa') }}"
            class="block px-4 py-2 hover:bg-gray-100"
        >
            🇮🇷 فارسی
        </a>


        <a
            href="{{ route('admin.language', 'ps') }}"
            class="block px-4 py-2 hover:bg-gray-100"
        >
            🇦🇫 پښتو
        </a>


    </div>

</div>