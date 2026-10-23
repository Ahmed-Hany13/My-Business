<?php

use Livewire\Component;
use App\Models\Client;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(as: 'filter_start_date', except: null)]
    public ?string $startDate = null;

    #[Url(as: 'filter_end_date', except: null)]
    public ?string $endDate = null;

    #[Url(as: 'unpaid_month', except: null)]
    public ?string $unpaidMonth = null;

    public function updatedStartDate(): void
    {
        $this->resetPage();
    }

    public function updatedEndDate(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedUnpaidMonth(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'startDate', 'endDate', 'unpaidMonth']);
        $this->resetPage();
    }

    public function with(): array
    {
        $search = trim($this->search);

        return [
            'clients' => Client::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->when($this->startDate, function ($query, $startDate) {
                    $query->where('start_date', '>=', $startDate);
                })
                ->when($this->endDate, function ($query, $endDate) {
                    $query->where(function ($q) use ($endDate) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '<=', $endDate);
                    });
                })
                ->when($this->unpaidMonth, function ($query) {
                    $date = \Carbon\Carbon::createFromFormat('Y-m', $this->unpaidMonth);
                    $query->where('start_date', '<=', $date->copy()->endOfMonth())
                          ->where(function ($q) use ($date) {
                              $q->whereNull('end_date')
                                ->orWhere('end_date', '>=', $date->copy()->startOfMonth());
                          })
                          ->whereDoesntHave('invoices', function ($q) use ($date) {
                              $q->whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year);
                          });
                })
                ->latest()
                ->paginate(5),
        ];
    }
};
?>

<div class="rounded-2xl bg-slate-900/90 border border-slate-800/80 shadow-2xl overflow-hidden backdrop-blur">

    <div class="space-y-3 p-4 sm:px-6 border-b border-slate-800/80">
        <div class="relative w-full">
            <label for="client-search" class="sr-only">ابحث باسم العميل </label>
            <input id="client-search" type="search" wire:model.live.debounce.300ms="search"
                placeholder="ابحث باسم العميل..." autocomplete="off"
                class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 placeholder:text-slate-500 focus:border-blue-500 focus:ring-blue-500" />
            <span wire:loading wire:target="search"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-500">
                جاري البحث...
            </span>
        </div>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div>
                <label for="filter_start_date" class="mb-1 block text-xs font-medium text-slate-400">بداية فترة البحث</label>
                <input id="filter_start_date" type="date" wire:model.live.debounce.300ms="startDate"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div>
                <label for="filter_end_date" class="mb-1 block text-xs font-medium text-slate-400">نهاية فترة البحث</label>
                <input id="filter_end_date" type="date" wire:model.live.debounce.300ms="endDate"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div>
                <label for="unpaid_month" class="mb-1 block text-xs font-medium text-amber-400">
                    <svg class="w-3.5 h-3.5 inline-block ml-0.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    المتأخرين عن الدفع
                </label>
                <input id="unpaid_month" type="month" wire:model.live.debounce.300ms="unpaidMonth"
                    class="w-full rounded-lg border border-amber-600/50 bg-slate-900/80 px-4 py-3 text-base text-slate-300 focus:border-amber-500 focus:ring-amber-500" />
            </div>
        </div>
        @if ($search !== '' || $startDate || $endDate || $unpaidMonth)
            <button type="button" wire:click="clearFilters"
                class="text-sm font-medium text-blue-400 transition hover:text-blue-300">
                مسح البحث والتصفية
            </button>
        @endif
    </div>
    <!-- Table View -->
    <div class="overflow-x-auto">
        <table class="w-full min-w-[820px] text-right text-sm text-slate-300" id="clientsTable">
            <thead
                class="bg-slate-800/70 text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                <tr>
                    <th scope="col" class="py-3.5 pr-6 pl-4 font-semibold">العميل</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">المنتج</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">الرصيد</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">المديونية</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">الدفع الشهري</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">فترة العقد</th>
                    <th scope="col" class="py-3.5 pr-4 pl-6 text-left font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse ($clients as $client)
                    @php
                        $initials = collect(explode(' ', trim($client->name ?? 'ع')))
                            ->map(fn($part) => mb_substr($part, 0, 1))
                            ->take(2)
                            ->implode(' ');

                        $isExpired = $client->end_date ? \Carbon\Carbon::parse($client->end_date)->isPast() : false;
                        $hasDebt = ($client->debt ?? 0) > 0;
                    @endphp
                    <tr wire:key="client-{{ $client->id }}" class="hover:bg-slate-800/40 transition-colors group">

                        <!-- Client Name & Avatar -->
                        <td class="py-4 pr-6 pl-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-bold text-xs text-white shadow-md shadow-blue-500/10 ring-1 ring-white/10 shrink-0">
                                    {{ $initials ?: 'ع' }}
                                </div>
                                <div>
                                    <div class="font-semibold text-white leading-tight">{{ $client->name }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Product -->
                        <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-300">
                            @if ($client->product)
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 font-mono">
                                    {{ $client->product }}
                                </span>
                            @else
                                <span class="text-slate-600">—</span>
                            @endif
                        </td>


                            <!-- Balance -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-mono">
                                {{ number_format($client->balance ?? 0, 2) }} ج.م
                            </span>
                        </td>

                        <!-- Debt -->
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if ($hasDebt)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20 font-mono">
                                    <span>{{ number_format($client->debt, 2) }} ج.م</span>
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-800 text-slate-400 font-mono">
                                    0.00 ج.م
                                </span>
                            @endif
                        </td>

                        {{-- Monthly Payment --}}
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 font-mono">
                                {{ number_format($client->monthly_payment ?? 0, 2) }} ج.م
                            </span>
                        </td>

                        <!-- Contract Duration -->
                        <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400">
                            <div class="flex flex-col gap-0.5 font-mono text-[11px]">
                                <span class="text-slate-300">من:
                                    {{ \Carbon\Carbon::parse($client->start_date)->format('Y/m/d') }}</span>
                            </div>
                        </td>



                        <!-- Actions -->
                        <td class="py-4 pr-4 pl-6 text-left whitespace-nowrap">
                            <div class="flex items-center justify-start gap-1.5">

                                {{-- Payment Button --}}
                                <button type="button" onclick="openPaymentModal(this)"
                                    data-action="{{ route('client.pay', $client->id) }}"
                                    data-client-id="{{ $client->id }}" data-client-name="{{ $client->name }}"
                                    data-monthly-payment="{{ number_format((float) ($client->monthly_payment ?? 0), 2, '.', '') }}"
                                    class="p-2 rounded-xl bg-slate-800/80 hover:bg-emerald-600/20 text-slate-400 hover:text-emerald-400 border border-slate-700/60 hover:border-emerald-500/30 transition-all"
                                    title="تسديد دفعة للعميل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>

                                {{-- View Details Button --}}
                                <a href="{{ route('client.show', $client->id) }}"
                                    class="p-2 rounded-xl bg-slate-800/80 hover:bg-blue-600/20 text-slate-400 hover:text-blue-400 border border-slate-700/60 hover:border-blue-500/30 transition-all"
                                    title="عرض تفاصيل العميل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                {{-- Edit Button --}}
                                <button type="button" onclick="openEditModal({{ json_encode($client) }})"
                                    class="p-2 rounded-xl bg-slate-800/80 hover:bg-blue-600/20 text-slate-400 hover:text-blue-400 border border-slate-700/60 hover:border-blue-500/30 transition-all"
                                    title="تعديل بيانات العميل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                {{-- Delete Button Form --}}
                                <form action="{{ route('client.destroy', $client->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف العميل ({{ $client->name }}) نهائياً؟');"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 rounded-xl bg-slate-800/80 hover:bg-rose-600/20 text-slate-400 hover:text-rose-400 border border-slate-700/60 hover:border-rose-500/30 transition-all"
                                        title="حذف العميل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyTableRow">
                        <td colspan="8" class="py-16 text-center text-slate-500">
                            <div
                                class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-slate-800/50 flex items-center justify-center text-slate-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            @if ($search !== '' || $startDate || $endDate || $unpaidMonth)
                                <p class="text-base font-semibold text-slate-300">لا توجد نتائج مطابقة لمعايير البحث والتصفية.</p>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">عدّل معايير البحث أو امسح
                                    التصفية لعرض جميع العملاء.</p>
                                <button type="button" wire:click="clearFilters"
                                    class="inline-block mt-4 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 border border-slate-700 transition-all shadow-md">
                                    عرض جميع العملاء
                                </button>
                            @else
                                <p class="text-base font-semibold text-slate-300">لا يوجد عملاء مضافين حالياً</p>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">ابدأ بإضافة أول عميل إلى نظامك
                                    لإدارة الحسابات والعقود بكل سهولة.</p>
                                <button onclick="toggleModal('addClientModal')"
                                    class="mt-4 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-semibold text-white transition-all shadow-md">
                                    + إضافة عميل الآن
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="p-4 sm:px-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-slate-400">
            عرض من <span class="font-semibold text-white">{{ $clients->firstItem() ?? 0 }}</span>
            إلى <span class="font-semibold text-white">{{ $clients->lastItem() ?? 0 }}</span>
            من أصل <span class="font-semibold text-white">{{ $clients->total() }}</span> عميل
        </p>
        @if ($clients->hasPages())
            <div class="p-4 sm:px-6 border-t border-slate-800/80 flex justify-end">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
