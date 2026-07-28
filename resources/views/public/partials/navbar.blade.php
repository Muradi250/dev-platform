{{-- ======================================================
     NAVBAR START
     تنظیمات Alpine + RTL/LTR + ظاهر کلی Navbar
====================================================== --}}

<nav 
    x-data="{ openMenu: null, mobileOpen: false }"
    dir="{{ in_array(app()->getLocale(), ['fa','ps']) ? 'rtl' : 'ltr' }}"
    class="sticky top-0 z-50 bg-white/70 supports-[backdrop-filter]:bg-white/55 backdrop-blur-xl border-b border-white/60 shadow-[0_14px_40px_-22px_rgba(37,99,235,0.45)] transition-all duration-300">


    {{-- Container اصلی Navbar --}}
    <div class="max-w-[1400px] mx-auto px-4 lg:px-6">


        {{-- ======================================================
             HEADER ROW
             Logo + Desktop Menu + Language + Buttons + Mobile Button
        ====================================================== --}}

        <div class="flex items-center h-20 gap-2 rtl:gap-1.5 w-full min-w-0">


            {{-- ======================================================
                 LOGO SECTION
            ====================================================== --}}

            <a href="{{ url(app()->getLocale()) }}"
               class="flex items-center gap-3 shrink-0 whitespace-nowrap rtl me-1 rounded-xl px-2 py-1 transition hover:bg-blue-50 min-w-0">

                <i data-lucide="layers"
                   class="w-8 h-8 shrink-0 text-blue-700">
                </i>

                <span class="text-2xl font-extrabold leading-none text-blue-700 tracking-tight">
                    Dev-Platform
                </span>

            </a>


            {{-- ======================================================
                 DESKTOP NAVIGATION
                 فقط در صفحه های بزرگ نمایش داده می شود
            ====================================================== --}}

            <div class="hidden lg:flex items-center gap-1.5 rtl:me-1 flex-1 justify-center min-w-0">


                {{-- Home Link --}}
                <a href="{{ url(app()->getLocale()) }}"
                   class="flex items-center gap-2 px-3 py-2 h-11 text-gray-700 hover:text-blue-700 transition whitespace-nowrap rounded-xl hover:bg-blue-50 font-semibold">

                    {{ __('navigation.home') }}

                </a>



                {{-- ======================================================
                     MAIN MENU LOOP
                     Platform / Modules / Solutions / ...
                ====================================================== --}}

                @foreach(config('navigation.main') as $index => $menu)


                    {{-- Single Menu Wrapper --}}
                    <div class="relative"
                         x-data
                         @mouseenter="openMenu = {{ $index }}"
                         @mouseleave="openMenu = null">



                        {{-- Menu Button --}}
                        <button type="button"
                                class="flex items-center gap-2 px-3 py-2 h-11 text-gray-700 hover:text-blue-700 transition whitespace-nowrap rounded-xl border border-transparent hover:border-blue-100 hover:bg-blue-50/70 font-semibold">


                            {{-- Menu Icon --}}
                            <i data-lucide="{{ $menu['icon'] }}"
                               class="w-5 h-5 shrink-0 text-blue-700">
                            </i>


                            {{-- Menu Title --}}
                            <span>
                                {{ __($menu['title']) }}
                            </span>



                            {{-- Dropdown Icon --}}
                            @if(isset($menu['children']) || isset($menu['mega']))

                                <i data-lucide="chevron-down"
                                   class="w-4 h-4">
                                </i>

                            @endif


                        </button>



                        {{-- ======================================================
                             NORMAL DROPDOWN MENU
                        ====================================================== --}}

                        @if(isset($menu['children']))

                            <div x-show="openMenu === {{ $index }}"
                                 x-transition
                                 x-cloak
                                 @click.outside="openMenu = null"
                                 class="absolute top-full mt-3 start-0 w-72 bg-white border rounded-2xl shadow-xl p-4 z-50">


                                @foreach($menu['children'] as $child)

                                    <a href="#"
                                       class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-50">

                                        <i data-lucide="{{ $child['icon'] ?? 'circle' }}"
                                           class="w-5 h-5 text-blue-700">
                                        </i>

                                        <span>
                                            {{ __($child['title']) }}
                                        </span>

                                    </a>

                                @endforeach


                            </div>

                        @endif




                        {{-- ======================================================
                             MEGA MENU
                        ====================================================== --}}

                        @if(isset($menu['mega']))


                            <div x-show="openMenu === {{ $index }}"
                                 x-transition
                                 x-cloak
                                 @click.outside="openMenu = null"
                                 class="absolute top-full mt-4 start-0 w-[900px] bg-white border rounded-2xl shadow-xl p-8 z-50">


                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                                    @foreach($menu['items'] as $section)


                                        {{-- Mega Menu Section --}}

                                        <div>


                                            <div class="flex items-center gap-3">

                                                <i data-lucide="{{ $section['icon'] ?? 'circle' }}"
                                                   class="w-5 h-5 text-blue-700">
                                                </i>


                                                <h3 class="font-semibold text-gray-900">
                                                    {{ __($section['title']) }}
                                                </h3>

                                            </div>



                                            {{-- Mega Menu Links --}}

                                            @foreach($section['children'] as $item)

                                                <a href="#"
                                                   class="block py-2 text-gray-700 hover:text-blue-700">

                                                    {{ __($item['title']) }}

                                                </a>

                                            @endforeach


                                        </div>


                                    @endforeach


                                </div>


                            </div>


                        @endif


                    </div>


                @endforeach


            </div>



            <div class="hidden lg:flex items-center gap-3 shrink-0 ms-auto">

                {{-- ======================================================
                     LANGUAGE SWITCHER
                     EN / FA / PS
                ====================================================== --}}

                <div class="relative shrink-0"
                     x-data="{ openLang:false }">


                    <button type="button"
                            @click="openLang=!openLang"
                            class="flex items-center gap-2 px-3 py-2 h-10 rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-blue-700 hover:text-blue-700 transition shadow-sm">


                        <i data-lucide="globe"
                           class="w-4 h-4">
                        </i>


                        <span class="text-sm font-medium">
                            {{ strtoupper(app()->getLocale()) }}
                        </span>


                        <i data-lucide="chevron-down"
                           class="w-4 h-4">
                        </i>


                    </button>



                    {{-- Language Dropdown --}}

                    <div x-show="openLang"
                         x-transition
                         x-cloak
                         @click.outside="openLang=false"
                         class="absolute top-full mt-2 end-0 w-40 bg-white border border-gray-200 rounded-xl shadow-lg p-2 z-50">

                        <div class="flex flex-col gap-1">
                            <a href="{{ url('en') }}"
                               class="block px-3 py-2 text-sm rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                English
                            </a>

                            <a href="{{ url('fa') }}"
                               class="block px-3 py-2 text-sm rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                فارسی
                            </a>

                            <a href="{{ url('ps') }}"
                               class="block px-3 py-2 text-sm rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                پښتو
                            </a>
                        </div>

                    </div>


                </div>




                {{-- ======================================================
                     AUTH BUTTONS
                     Login + Request Demo
                ====================================================== --}}

                <div class="flex items-center gap-1.5 sm:gap-2 shrink-0 min-w-0">


                    <a href="{{ url(app()->getLocale().'/login') }}"
                       class="px-2.5 sm:px-3 py-2 h-10 flex items-center justify-center rounded-xl border border-gray-300 text-gray-700 hover:border-blue-700 hover:text-blue-700 transition whitespace-nowrap shadow-sm text-sm sm:text-base">
                        {{ __('navigation.login') }}
                    </a>


                    <a href="#"
                       class="px-2.5 sm:px-3 py-2 h-10 flex items-center justify-center rounded-xl bg-blue-700 text-white hover:bg-blue-800 transition whitespace-nowrap shadow-sm shadow-blue-200 text-sm sm:text-base">
                        {{ __('navigation.request_demo') }}
                    </a>


                </div>

            </div>




            {{-- ======================================================
                 MOBILE MENU BUTTON
            ====================================================== --}}

            <button type="button"
                    @click="mobileOpen=!mobileOpen"
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-100 transition shadow-sm ms-auto">

                <i data-lucide="menu" class="w-5 h-5"></i>

            </button>



        </div>

    </div>





    {{-- ======================================================
         MOBILE NAVIGATION
         نمایش در موبایل
    ====================================================== --}}


    <div x-show="mobileOpen"
         x-transition
         x-cloak
         class="lg:hidden border-t border-blue-100 bg-white/95 backdrop-blur-md">

        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4">

            <div class="space-y-2 rounded-2xl border border-gray-200 bg-gray-50 p-2">
                <a href="{{ url('en') }}"
                   class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition font-medium">
                    EN
                </a>
                <a href="{{ url('fa') }}"
                   class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition font-medium">
                    FA
                </a>
                <a href="{{ url('ps') }}"
                   class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition font-medium">
                    PS
                </a>
            </div>

            <div class="space-y-2">
                <a href="{{ url(app()->getLocale()) }}"
                   class="flex items-center gap-2 px-2 py-2 h-10 text-gray-700 hover:text-blue-700 transition font-medium whitespace-nowrap rounded-lg hover:bg-gray-50">
                    {{ __('navigation.home') }}
                </a>

                @foreach(config('navigation.main') as $index => $menu)
                    <div x-data="{ openMobileMenu: false }"
                         class="border border-gray-200 rounded-2xl">

                        <button type="button"
                                @click="openMobileMenu = !openMobileMenu"
                                class="w-full flex items-center justify-between gap-2 px-4 py-3 text-start text-gray-700 hover:bg-gray-50 transition">

                            <div class="flex items-center gap-3">
                                <i data-lucide="{{ $menu['icon'] ?? 'grid' }}"
                                   class="w-5 h-5 text-blue-700"></i>
                                <span>{{ __($menu['title']) }}</span>
                            </div>

                            <i data-lucide="chevron-down"
                               class="w-4 h-4"
                               :class="{'rotate-180': openMobileMenu}"></i>
                        </button>

                        <div x-show="openMobileMenu"
                             x-transition
                             x-cloak
                             class="space-y-1 px-4 pb-4">

                            @if(isset($menu['children']))
                                @foreach($menu['children'] as $child)
                                    <a href="#"
                                       class="flex items-center gap-3 pl-4 py-2 rounded-lg text-gray-600 hover:text-blue-700 hover:bg-gray-50 transition">
                                        <i data-lucide="{{ $child['icon'] ?? 'circle' }}"
                                           class="w-4 h-4 text-blue-700"></i>
                                        <span>{{ __($child['title']) }}</span>
                                    </a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-2">
                <a href="{{ url(app()->getLocale().'/login') }}"
                   class="block w-full text-center px-4 py-3 border rounded-xl text-gray-700 hover:border-blue-700 transition">
                    {{ __('navigation.login') }}
                </a>
                <a href="#"
                   class="block w-full text-center px-4 py-3 bg-blue-700 text-white rounded-xl hover:bg-blue-800 transition">
                    {{ __('navigation.request_demo') }}
                </a>
            </div>
        </div>
    </div>


</nav>

{{-- ======================================================
     NAVBAR END
====================================================== --}}