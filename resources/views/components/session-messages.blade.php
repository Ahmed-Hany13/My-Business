<div class="space-y-3 mb-6" id="session-alerts-wrapper" dir="rtl">
    {{-- رسالة النجاح (Success) --}}
    @if (session('success'))
        <div data-alert-card
            class="relative flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-900/90 border border-emerald-500/30 shadow-lg shadow-emerald-950/20 backdrop-blur-sm transition-all duration-300">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="min-w-0 text-right">
                    <h4 class="text-sm font-semibold text-white tracking-tight">تم بنجاح</h4>
                    <p class="text-xs sm:text-sm text-slate-300 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" onclick="dismissAlert(this)"
                class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors shrink-0"
                aria-label="إغلاق التنبيه">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- رسالة الخطأ (Error / Danger) --}}
    @if (session('error') || session('danger'))
        <div data-alert-card
            class="relative flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-900/90 border border-rose-500/30 shadow-lg shadow-rose-950/20 backdrop-blur-sm transition-all duration-300">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="min-w-0 text-right">
                    <h4 class="text-sm font-semibold text-white tracking-tight">حدث خطأ</h4>
                    <p class="text-xs sm:text-sm text-slate-300 mt-0.5 leading-relaxed">{{ session('error') ?? session('danger') }}</p>
                </div>
            </div>
            <button type="button" onclick="dismissAlert(this)"
                class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors shrink-0"
                aria-label="إغلاق التنبيه">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- رسالة التحذير (Warning) --}}
    @if (session('warning'))
        <div data-alert-card
            class="relative flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-900/90 border border-amber-500/30 shadow-lg shadow-amber-950/20 backdrop-blur-sm transition-all duration-300">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <div class="min-w-0 text-right">
                    <h4 class="text-sm font-semibold text-white tracking-tight">تنبيه</h4>
                    <p class="text-xs sm:text-sm text-slate-300 mt-0.5 leading-relaxed">{{ session('warning') }}</p>
                </div>
            </div>
            <button type="button" onclick="dismissAlert(this)"
                class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors shrink-0"
                aria-label="إغلاق التنبيه">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- رسالة المعلومات / الإشعار (Info / Status) --}}
    @if (session('info') || session('status'))
        <div data-alert-card
            class="relative flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-900/90 border border-blue-500/30 shadow-lg shadow-blue-950/20 backdrop-blur-sm transition-all duration-300">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0 text-right">
                    <h4 class="text-sm font-semibold text-white tracking-tight">إشعار</h4>
                    <p class="text-xs sm:text-sm text-slate-300 mt-0.5 leading-relaxed">{{ session('info') ?? session('status') }}</p>
                </div>
            </div>
            <button type="button" onclick="dismissAlert(this)"
                class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors shrink-0"
                aria-label="إغلاق التنبيه">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- قائمة أخطاء التحقق (Validation Errors) --}}
    @if (isset($errors) && $errors->any())
        <div data-alert-card
            class="relative flex items-start justify-between gap-3 p-4 rounded-2xl bg-slate-900/90 border border-rose-500/30 shadow-lg shadow-rose-950/20 backdrop-blur-sm transition-all duration-300">
            <div class="flex items-start gap-3.5 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="min-w-0 text-right">
                    <h4 class="text-sm font-semibold text-white tracking-tight">يرجى تصحيح الأخطاء التالية:</h4>
                    <ul class="mt-2 space-y-1 text-xs sm:text-sm text-slate-300 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" onclick="dismissAlert(this)"
                class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors shrink-0"
                aria-label="إغلاق التنبيه">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
</div>

<script>
    if (typeof dismissAlert === 'undefined') {
        function dismissAlert(btn) {
            const card = btn.closest('[data-alert-card]');
            if (card) {
                card.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '0';
                card.style.transform = 'translateY(-6px) scale(0.98)';
                setTimeout(() => {
                    card.remove();
                }, 250);
            }
        }
    }
</script>
