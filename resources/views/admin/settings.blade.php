@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section
            class="relative overflow-hidden rounded-2xl border border-blue-500/20 bg-gradient-to-l from-blue-950 via-slate-900 to-slate-900 p-6 shadow-xl sm:p-8">
            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="mb-2 text-sm font-semibold text-blue-300">الإعدادات</p>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">إعدادات النظام</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-300">
                        تنزيل نسخة احتياطية من بيانات النظام وإدارة خيارات حفظها.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-600 bg-slate-800/70 px-4 py-2.5 text-sm font-semibold text-slate-100 transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                        العودة إلى لوحة التحكم
                    </a>
                </div>
            </div>
            <div aria-hidden="true" class="absolute -left-12 -top-24 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800/80 bg-slate-900/90 shadow-xl">
            <div class="flex flex-col gap-2 border-b border-slate-800/80 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div>
                    <h2 class="text-lg font-bold text-white">إدارة البيانات</h2>
                    <p class="mt-1 text-xs text-slate-400">تنزيل نسخة من بيانات النظام للاحتفاظ بها عند الحاجة.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <div class="rounded-2xl border border-slate-800/80 bg-slate-950/80 p-4 sm:p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white">نسخة احتياطية من البيانات</h3>
                            <p class="mt-2 max-w-xl text-sm text-slate-400">
                                نزّل نسخة احتياطية بصيغة SQL تتضمن جداول قاعدة البيانات وبياناتها للاحتفاظ بها بأمان.
                            </p>
                        </div>

                        <a href="{{ route('backup.download') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/40 transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-900 sm:w-auto">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v12m0 0l-3-3m3 3l3-3M5 21h14" />
                            </svg>
                            تحميل النسخة الاحتياطية
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
