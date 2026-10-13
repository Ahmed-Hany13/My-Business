<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="h-full bg-slate-950">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Business') }} - Dashboard</title>

    <!-- Google Fonts: Cairo & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.8);
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(71, 85, 105, 1);
        }

        [class~="overflow-x-auto"] {
            max-width: 100%;
            overscroll-behavior-inline: contain;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 639px) {
            input:not([type="checkbox"]):not([type="radio"]),
            select,
            textarea {
                font-size: 16px;
            }
        }
    </style>
</head>
<body
class="h-full min-h-[100dvh] min-w-0 font-sans antialiased text-slate-200 selection:bg-blue-600 selection:text-white flex overflow-hidden">
    <!-- Mobile Sidebar Backdrop -->
    <div id="mobileBackdrop" onclick="toggleSidebar()"
        class="fixed inset-0 z-40 bg-black/70 backdrop-blur-sm hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation -->
    @include('partials.main-sidebar')

    <!-- Main Content Area -->
    @include('partials.navbar')
        <!-- Main Body Scroll Container -->
        <main
            class="min-h-0 min-w-0 w-full flex-1 overflow-y-auto overscroll-contain custom-scrollbar p-3 sm:p-6 lg:p-8 space-y-6">
            @include('components.session-messages')
            @hasSection('content')
                @yield('content')
            @elseif(isset($slot))
                {{ $slot }}
            @else
                <!-- DEFAULT DASHBOARD VIEW WITH METRICS & FAKE INFO TABLE -->

                <!-- Top Page Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white tracking-tight">Clients Directory</h1>
                        <p class="text-sm text-slate-400 mt-0.5">Manage your active business partners, contracts, and
                            accounts.</p>
                    </div>

                    <!-- Filter pills -->
                    <div class="flex items-center gap-2">
                        <button
                            class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-white border border-slate-700 hover:bg-slate-700 transition-colors">Export
                            CSV</button>
                        <button
                            class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-white border border-slate-700 hover:bg-slate-700 transition-colors">Filters</button>
                    </div>
                </div>

                <!-- KPI Metric Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800/80 shadow-sm">
                        <div class="flex items-center justify-between text-slate-400">
                            <span class="text-xs font-semibold uppercase tracking-wider">Total Clients</span>
                            <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-white">1,482</span>
                            <span class="text-xs text-emerald-400 font-medium flex items-center">↑ 12.5%</span>
                        </div>
                        <span class="text-[11px] text-slate-500">vs last month</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800/80 shadow-sm">
                        <div class="flex items-center justify-between text-slate-400">
                            <span class="text-xs font-semibold uppercase tracking-wider">Active Contracts</span>
                            <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-white">329</span>
                            <span class="text-xs text-emerald-400 font-medium flex items-center">↑ 4.1%</span>
                        </div>
                        <span class="text-[11px] text-slate-500">98.4% satisfaction</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800/80 shadow-sm">
                        <div class="flex items-center justify-between text-slate-400">
                            <span class="text-xs font-semibold uppercase tracking-wider">Revenue MTD</span>
                            <span class="p-2 rounded-xl bg-purple-500/10 text-purple-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-white">$94,250</span>
                            <span class="text-xs text-emerald-400 font-medium flex items-center">↑ 18.2%</span>
                        </div>
                        <span class="text-[11px] text-slate-500">Target $110,000</span>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800/80 shadow-sm">
                        <div class="flex items-center justify-between text-slate-400">
                            <span class="text-xs font-semibold uppercase tracking-wider">Pending Tasks</span>
                            <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-white">14</span>
                            <span class="text-xs text-amber-400 font-medium flex items-center">3 urgent</span>
                        </div>
                        <span class="text-[11px] text-slate-500">Requires review</span>
                    </div>
                </div>

                <!-- TABLE CARD WITH FAKE INFORMATION -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800/80 shadow-xl overflow-hidden">
                    <!-- Table Search & Filter Toolbar -->
                    <div
                        class="p-4 sm:p-5 border-b border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="w-full sm:w-80 relative">
                            <span
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="البحث عن عميل بالاسم أو الشركة..."
                                class="w-full pr-10 pl-4 py-2 rounded-xl bg-slate-800/80 border border-slate-700/80 text-xs text-slate-200 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <div class="w-full sm:w-auto flex items-center justify-end gap-2">
                            <select
                                class="px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700/80 text-xs text-slate-300 focus:outline-none focus:border-blue-500">
                                <option value="all">جميع الحالات</option>
                                <option value="active">نشط</option>
                                <option value="pending">معلق</option>
                                <option value="lead">عميل محتمل</option>
                                <option value="inactive">غير نشط</option>
                            </select>

                            <select
                                class="px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700/80 text-xs text-slate-300 focus:outline-none focus:border-blue-500">
                                <option>الترتيب: الأحدث</option>
                                <option>الأعلى قيمة</option>
                                <option>أبجدياً</option>
                            </select>
                        </div>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-right text-sm text-slate-300">
                            <thead
                                class="bg-slate-800/50 text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                                <tr>
                                    <th scope="col" class="py-3.5 pr-6 pl-3 font-semibold">اسم العميل</th>
                                    <th scope="col" class="px-4 py-3.5 font-semibold">الشركة</th>
                                    <th scope="col" class="px-4 py-3.5 font-semibold">الحالة</th>
                                    <th scope="col" class="px-4 py-3.5 font-semibold">قيمة العقد</th>
                                    <th scope="col" class="px-4 py-3.5 font-semibold">تاريخ الانضمام</th>
                                    <th scope="col" class="py-3.5 pr-3 pl-6 text-left font-semibold">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60">
                                <!-- Row 1 -->
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-cyan-500 flex items-center justify-center font-bold text-xs text-white shadow-sm">
                                                EH
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white">Elena Hernandez</div>
                                                <div class="text-xs text-slate-400">elena.h@vortextech.io</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-slate-200">
                                        Vortex Technologies Ltd.
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-bold text-white">
                                        $24,500 <span class="text-[10px] font-normal text-slate-400">/yr</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                                        Jan 14, 2026
                                    </td>
                                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white"
                                                title="View details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-blue-400"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center font-bold text-xs text-white shadow-sm">
                                                MK
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white">Marcus Sterling</div>
                                                <div class="text-xs text-slate-400">m.sterling@apexcapital.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-slate-200">
                                        Apex Capital Group
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-bold text-white">
                                        $68,000 <span class="text-[10px] font-normal text-slate-400">/yr</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                                        Feb 02, 2026
                                    </td>
                                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg></button>
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-blue-400"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center font-bold text-xs text-white shadow-sm">
                                                SL
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white">Sarah Jenkins</div>
                                                <div class="text-xs text-slate-400">s.jenkins@lumina-studio.co</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-slate-200">
                                        Lumina Creative Studio
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                            Pending Review
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-bold text-white">
                                        $12,400 <span class="text-[10px] font-normal text-slate-400">/one-off</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                                        Mar 09, 2026
                                    </td>
                                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg></button>
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-blue-400"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center font-bold text-xs text-white shadow-sm">
                                                AK
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white">Ahmed Al-Mansoor</div>
                                                <div class="text-xs text-slate-400">ahmed@zenithlogistics.ae</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-slate-200">
                                        Zenith Global Logistics
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                            New Lead
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-bold text-white">
                                        $45,000 <span class="text-[10px] font-normal text-slate-400">/project</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                                        Apr 18, 2026
                                    </td>
                                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg></button>
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-blue-400"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-tr from-slate-600 to-slate-500 flex items-center justify-center font-bold text-xs text-white shadow-sm">
                                                DR
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white">David Ross</div>
                                                <div class="text-xs text-slate-400">d.ross@novanordic.se</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-medium text-slate-200">
                                        Nova Nordic Systems
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-bold text-white">
                                        $8,900 <span class="text-[10px] font-normal text-slate-400">/yr</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                                        May 30, 2025
                                    </td>
                                    <td class="py-4 pl-3 pr-6 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg></button>
                                            <button
                                                class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-blue-400"><svg
                                                    class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Pagination Footer -->
                    <div
                        class="p-4 sm:px-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-slate-400">
                            Showing <span class="font-semibold text-white">1</span> to <span
                                class="font-semibold text-white">5</span> of <span
                                class="font-semibold text-white">1,482</span> clients
                        </p>
                        <div class="flex items-center gap-1.5">
                            <button
                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-slate-700/80 disabled:opacity-50"
                                disabled>Previous</button>
                            <button
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-600 text-white shadow-sm">1</button>
                            <button
                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700/80">2</button>
                            <button
                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700/80">3</button>
                            <span class="px-1.5 text-xs text-slate-500">...</span>
                            <button
                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700/80">42</button>
                            <button
                                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-slate-800 text-slate-300 hover:text-white border border-slate-700/80">Next</button>
                        </div>
                    </div>
                </div>
            @endif

        </main>
    </div>

    <!-- Interactive Mobile Drawer Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobileBackdrop');

            const isHidden = sidebar.classList.contains('translate-x-full') || sidebar.classList.contains('-translate-x-full');

            if (isHidden) {
                sidebar.classList.remove('translate-x-full', '-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
