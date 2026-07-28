<footer class="mt-10 border-t border-white/10 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white">

    <div class="max-w-[1400px] mx-auto px-4 lg:px-6 py-10">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-[1.3fr_1fr_1.1fr]">

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <i data-lucide="layers" class="w-8 h-8 text-blue-400"></i>
                    <h3 class="text-2xl font-extrabold tracking-tight text-white">Dev-Platform</h3>
                </div>

                <p class="max-w-md text-sm leading-6 text-slate-300">
                    Digital Organization Management Platform
                </p>

                <div class="flex flex-wrap gap-2">
                    <a href="mailto:Amuradi250@gmail.com"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm text-slate-200 transition hover:border-blue-400 hover:bg-blue-500/10 hover:text-white">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-300"></i>
                        Amuradi250@gmail.com
                    </a>

                    <a href="tel:+9870724775"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm text-slate-200 transition hover:border-blue-400 hover:bg-blue-500/10 hover:text-white">
                        <i data-lucide="phone" class="w-4 h-4 text-blue-300"></i>
                        +9870724775
                    </a>
                </div>
            </div>

            <div>
                <h4 class="mb-3 text-sm font-bold uppercase tracking-[0.2em] text-blue-300">
                    Navigation
                </h4>

                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                    @foreach(config('navigation.main') as $menu)
                        <a href="#"
                           class="rounded-lg px-3 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">
                            {{ __($menu['title']) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="mb-3 text-sm font-bold uppercase tracking-[0.2em] text-blue-300">
                    Social & Contact
                </h4>

                <div class="space-y-2 text-sm text-slate-300">
                    <a href="https://github.com/Amuradi250"
                       target="_blank"
                       rel="noreferrer"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">
                        <i data-lucide="github" class="w-4 h-4 text-blue-300"></i>
                        GitHub
                    </a>

                    <a href="https://linkedin.com/in/Amuradi250"
                       target="_blank"
                       rel="noreferrer"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">
                        <i data-lucide="linkedin" class="w-4 h-4 text-blue-300"></i>
                        LinkedIn
                    </a>

                    <a href="mailto:Amuradi250@gmail.com"
                       class="flex items-center gap-2 rounded-lg px-3 py-2 transition hover:bg-white/5 hover:text-white">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-300"></i>
                        Contact via email
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-8 flex flex-col gap-2 border-t border-white/10 pt-5 text-sm text-slate-400 md:flex-row md:items-center md:justify-between">
            <p>
                © {{ date('Y') }} Dev-Platform. All rights reserved.
            </p>

            <div class="flex flex-wrap items-center gap-3">
                <a href="#" class="transition hover:text-white">Privacy</a>
                <a href="#" class="transition hover:text-white">Terms</a>
            </div>
        </div>

    </div>

</footer>