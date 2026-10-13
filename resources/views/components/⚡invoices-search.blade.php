<?php

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(as: 'filter_start_date', except: null)]
    public ?string $startDate = null;

    #[Url(as: 'filter_end_date', except: null)]
    public ?string $endDate = null;

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
    public function clearFilters(): void
    {
        $this->reset(['search', 'startDate', 'endDate']);
        $this->resetPage();
    }

    public function with(): array
    {
        $search = trim($this->search);

        return [
            'invoices' => Invoice::query()
                ->with('client')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('invoice_number', 'like', "%{$search}%")->orWhereHas('client', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                    });
                })
                ->when($this->startDate, function ($query, $startDate) {
                    $query->where('created_at', '>=', $startDate);
                })
                ->when($this->endDate, function ($query, $endDate) {
                    $query->where('created_at', '<=', $endDate);
                })
                ->latest()
                ->paginate(5),
        ];
    }
};
?>

<div class="rounded-2xl bg-slate-900/90 border border-slate-800/80 shadow-2xl overflow-hidden backdrop-blur">
    <div class="p-4 sm:px-6 border-b border-slate-800/80">
        <div class="relative w-full">
            <label for="invoice-search" class="sr-only">ابحث باسم العميل أو رقم الفاتورة</label>
            <input id="invoice-search" type="search" wire:model.live.debounce.300ms="search"
                placeholder="ابحث باسم العميل أو رقم الفاتورة..." autocomplete="off"
                class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 placeholder:text-slate-500 focus:border-blue-500 focus:ring-blue-500" />
            <span wire:loading wire:target="search"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-500">
                جاري البحث...
            </span>
        </div>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div>
                <label for="filter_start_date" class="mb-1 block text-xs font-medium text-slate-400">بداية فترة
                    البحث</label>
                <input id="filter_start_date" type="date" wire:model.live.debounce.300ms="startDate"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div>
                <label for="filter_end_date" class="mb-1 block text-xs font-medium text-slate-400">نهاية فترة
                    البحث</label>
                <input id="filter_end_date" type="date" wire:model.live.debounce.300ms="endDate"
                    class="w-full rounded-lg border border-slate-700 bg-slate-900/80 px-4 py-3 text-base text-slate-300 focus:border-blue-500 focus:ring-blue-500" />
            </div>
        </div>
        @if ($search !== '' || $startDate || $endDate)
            <button type="button" wire:click="clearFilters"
                class="text-sm font-medium text-blue-400 transition hover:text-blue-300">
                مسح البحث والتصفية
            </button>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-right text-sm text-slate-300">
            <thead
                class="bg-slate-800/70 text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                <tr>
                    <th scope="col" class="py-3.5 pr-6 pl-4 font-semibold">رقم الفاتورة</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">اسم العميل</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">المبلغ الإجمالي</th>
                    <th scope="col" class="px-4 py-3.5 font-semibold">تاريخ الإنشاء</th>
                    <th scope="col" class="py-3.5 pl-3 pr-4 sm:pr-6 font-semibold">ملاحظات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse ($invoices as $invoice)
                    <tr wire:key="invoice-{{ $invoice->id }}" class="hover:bg-slate-800/40 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-white">
                            #{{ $invoice->invoice_number ?? $invoice->id }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-zinc-300 leading-tight">{{ $invoice->client?->name ?? '—' }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-emerald-400">
                            {{ $invoice->total_amount !== null ? number_format((float) $invoice->total_amount, 2) . ' ج.م' : '—' }}
                        </td>
                        <td class="px-4 py-4 text-slate-300">{{ $invoice->created_at?->format('Y/m/d') ?? '—' }}</td>
                        <td class="py-4 pl-3 pr-4 sm:pr-6 text-slate-300">
                            @if ($invoice->notes)
                                <span
                                    class="inline-block px-2 py-1 text-xs font-medium bg-blue-500/20 text-blue-400 rounded-lg">
                                    {{ $invoice->notes }}
                                </span>
                            @else
                                <span class="text-slate-500">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-slate-500">
                            <p class="text-base font-semibold text-slate-300">
                                {{ trim($search) !== '' ? 'لا توجد نتائج مطابقة للبحث.' : 'لا توجد فواتير مسجلة حالياً' }}
                            </p>
                            @if (trim($search) === '')
                                <p class="text-xs text-slate-500 mt-1">ستظهر الفواتير هنا عند تسجيلها.</p>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
</div>
