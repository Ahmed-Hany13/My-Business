    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-950">

        <!-- Top Header / Bar -->
        <header
            class="h-16 shrink-0 bg-slate-900/80 border-b border-slate-800/80 backdrop-blur px-3 sm:px-6 flex items-center justify-between gap-2 sm:gap-4 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()"
                    class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800" aria-label="فتح القائمة">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Search Box -->
                <div class="relative hidden sm:block w-72">
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="البحث عن العملاء، الفواتير..."
                        class="w-full pr-10 pl-10 py-1.5 rounded-xl bg-slate-800/70 border border-slate-700/60 text-xs text-slate-200 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" />
                    <kbd
                        class="absolute left-2.5 top-2 hidden sm:inline-block px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-slate-700/50 rounded border border-slate-600">⌘K</kbd>
                </div>
            </div>


            <!-- Header Right Actions -->
            <div class="flex items-center gap-3">
                <!-- Quick Action Button -->
                <!-- Profile Button -->
                <a href="{{ Route::has('profile.edit') ? route('profile.edit') : (Route::has('profile.show') ? route('profile.show') : '/profile') }}"
                    class="flex shrink-0 items-center gap-2 px-2.5 sm:px-3.5 py-2 sm:py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="hidden sm:inline">الملف الشخصي</span>
                </a>
            </div>
        </header>
