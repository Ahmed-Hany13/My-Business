@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section
            class="relative overflow-hidden rounded-2xl border border-blue-500/20 bg-gradient-to-l from-blue-950 via-slate-900 to-slate-900 p-6 shadow-xl sm:p-8">
            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="mb-2 text-sm font-semibold text-blue-300">لوحة التحكم</p>
                    <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        مرحباً، {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-300">
                        نظرة سريعة على العملاء والأرصدة والمدفوعات المسجلة في نشاطك التجاري.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('client.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-950/40 transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                        إدارة العملاء
                    </a>
                    <a href="{{ route('invoice.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-600 bg-slate-800/70 px-4 py-2.5 text-sm font-semibold text-slate-100 transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                        عرض الفواتير
                    </a>
                </div>
            </div>
            <div aria-hidden="true" class="absolute -left-12 -top-24 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>
        </section>
        <section aria-label="ملخص النشاط التجاري" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-slate-800/80 bg-slate-900/90 p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">إجمالي العملاء</p>
                <p class="mt-3 text-3xl font-bold text-white">{{ number_format($clientCount) }}</p>
                <a href="{{ route('client.index') }}"
                    class="mt-3 inline-block text-xs font-semibold text-blue-400 hover:text-blue-300">
                    الانتقال إلى العملاء
                </a>
            </article>

            <article class="rounded-2xl border border-slate-800/80 bg-slate-900/90 p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">إجمالي الأرصدة</p>
                <p class="mt-3 text-3xl font-bold text-emerald-400">
                    {{ number_format((float) $totalBalance, 2) }}
                    <span class="text-sm font-medium">ج.م</span>
                </p>
                <p class="mt-3 text-xs text-slate-500">مجموع أرصدة العملاء الحالية</p>
            </article>

            <article class="rounded-2xl border border-slate-800/80 bg-slate-900/90 p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">إجمالي المديونيات</p>
                <p class="mt-3 text-3xl font-bold text-rose-400">
                    {{ number_format((float) $totalDebt, 2) }}
                    <span class="text-sm font-medium">ج.م</span>
                </p>
                <p class="mt-3 text-xs text-slate-500">المبالغ المستحقة على العملاء</p>
            </article>

            <article class="rounded-2xl border border-slate-800/80 bg-slate-900/90 p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-400">الفواتير المسجلة</p>
                <p class="mt-3 text-3xl font-bold text-white">{{ number_format($invoiceCount) }}</p>
                <p class="mt-3 text-xs text-slate-500">
                    إجمالي قيمتها {{ number_format((float) $invoiceTotal, 2) }} ج.م
                </p>
            </article>

        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800/80 bg-slate-900/90 shadow-xl">
            <div
                class="flex flex-col gap-2 border-b border-slate-800/80 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-lg font-bold text-white">أحدث الفواتير</h2>
                    <p class="mt-1 text-xs text-slate-400">آخر الفواتير التي تم تسجيلها.</p>
                </div>
                <a href="{{ route('invoice.index') }}"
                    class="text-sm font-semibold text-blue-400 transition hover:text-blue-300">
                    جميع الفواتير
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs text-slate-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-semibold">رقم الفاتورة</th>
                            <th scope="col" class="px-6 py-3 font-semibold">العميل</th>
                            <th scope="col" class="px-6 py-3 font-semibold">المبلغ</th>
                            <th scope="col" class="px-6 py-3 font-semibold">تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse ($recentInvoices as $invoice)
                            <tr wire:key="dashboard-invoice-{{ $invoice->id }}" class="transition hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-white">
                                    #{{ $invoice->invoice_number ?? $invoice->id }}
                                </td>
                                <td class="px-6 py-4">{{ $invoice->client?->name ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 font-mono text-emerald-400">
                                    {{ $invoice->total_amount !== null ? number_format((float) $invoice->total_amount, 2) . ' ج.م' : '—' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-slate-400">
                                    {{ $invoice->created_at?->format('Y/m/d') ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="font-semibold text-slate-300">لا توجد فواتير حتى الآن</p>
                                    <p class="mt-1 text-xs text-slate-500">ستظهر الفواتير هنا بعد تسجيل أول دفعة.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
