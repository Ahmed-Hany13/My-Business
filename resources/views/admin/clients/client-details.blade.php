@extends('layouts.app')

@section('content')
    @php
        $invoiceTotal = $invoices->sum('total_amount');
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-1 flex items-center gap-2 text-xs text-slate-400">
                    <a href="{{ route('client.index') }}" class="transition hover:text-blue-400">العملاء</a>
                    <span class="text-slate-600">/</span>
                    <span class="font-medium text-blue-400">تفاصيل العميل</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    {{ $client->name }}
                </h1>
                <p class="mt-1 text-sm text-slate-400">بيانات العميل وسجل الفواتير والدفعات.</p>
            </div>

            <a href="{{ route('client.index') }}"
                class="inline-flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white sm:w-auto">
                العودة إلى العملاء
            </a>
        </div>

        <section aria-labelledby="client-summary-title"
            class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl shadow-slate-950/20 sm:p-6">
            <h2 id="client-summary-title" class="mb-4 text-lg font-semibold text-white">معلومات العميل</h2>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4">
                    <dt class="text-xs text-slate-400">اسم العميل</dt>
                    <dd class="mt-1 font-mono text-sm text-white">{{ $client->name }}</dd>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4">
                    <dt class="text-xs text-slate-400">الرصيد</dt>
                    <dd class="mt-1 font-mono text-sm text-emerald-400">
                        {{ number_format((float) ($client->balance ?? 0), 2) }} ج.م
                    </dd>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4">
                    <dt class="text-xs text-slate-400">المديونية</dt>
                    <dd class="mt-1 font-mono text-sm text-rose-400">
                        {{ number_format((float) ($client->debt ?? 0), 2) }} ج.م
                    </dd>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4">
                    <dt class="text-xs text-slate-400">ملاحظات</dt>
                    <dd class="mt-1 text-sm text-slate-300">
                        {{ filled($client->notes) ? $client->notes : '—' }}
                    </dd>
            </dl>
        </section>

        <section aria-labelledby="invoices-title"
            class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl shadow-slate-950/20">
            <div
                class="flex flex-col gap-3 border-b border-slate-800 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 id="invoices-title" class="text-lg font-semibold text-white">الفواتير والدفعات</h2>
                    <p class="mt-1 text-sm text-slate-400">سجل المبالغ المسجلة لهذا العميل.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span
                        class="rounded-full border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-xs font-medium text-blue-400">
                        {{ $invoices->count() }} فاتورة
                    </span>
                    <span
                        class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400">
                        الإجمالي: {{ number_format((float) $invoiceTotal, 2) }} ج.م
                    </span>
                </div>
            </div>

            @if ($invoices->isEmpty())
                <div class="px-6 py-14 text-center">
                    <p class="font-medium text-slate-300">لا توجد فواتير أو دفعات مسجلة لهذا العميل.</p>
                    <p class="mt-1 text-sm text-slate-500">ستظهر هنا عند تسجيل دفعة جديدة.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-right text-sm text-slate-300">
                        <thead class="border-b border-slate-800 bg-slate-800/60 text-xs text-slate-400">
                            <tr>
                                <th scope="col" class="px-5 py-3.5 font-semibold sm:px-6">رقم الفاتورة</th>
                                <th scope="col" class="px-4 py-3.5 font-semibold">المبلغ</th>
                                <th scope="col" class="px-4 py-3.5 font-semibold">التاريخ</th>
                                <th scope="col" class="px-5 py-3.5 font-semibold sm:px-6">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/70">
                            @foreach ($invoices as $invoice)
                                <tr class="transition hover:bg-slate-800/30">
                                    <td class="whitespace-nowrap px-5 py-4 font-mono text-xs text-white sm:px-6">
                                        #{{ $invoice->invoice_number ?: $invoice->id }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 font-mono text-emerald-400">
                                        {{ $invoice->total_amount !== null ? number_format((float) $invoice->total_amount, 2) . ' ج.م' : '—' }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-slate-300">
                                        {{ $invoice->created_at?->format('Y/m/d') ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-300 sm:px-6">
                                        {{ filled($invoice->notes) ? $invoice->notes : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>;
                    </table>
                </div>
            @endif
            <div class="p-4 sm:px-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-400">
                    عرض من <span class="font-semibold text-white">{{ $invoices->firstItem() ?? 0 }}</span>
                    إلى <span class="font-semibold text-white">{{ $invoices->lastItem() ?? 0 }}</span>
                    من أصل <span class="font-semibold text-white">{{ $invoices->total() }}</span> فاتورة
                </p>
                @if ($invoices->hasPages())
                    <div class="p-4 sm:px-6 border-t border-slate-800/80 flex justify-end">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
