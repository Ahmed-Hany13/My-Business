@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-1 flex items-center gap-2 text-xs text-slate-400">
                    <span>لوحة التحكم</span>
                    <span class="text-slate-600">/</span>
                    <span class="font-medium text-blue-400">المصروفات</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">المصروفات</h1>
                <p class="mt-1 text-sm text-slate-400">سجل المصروفات المسجلة في النظام.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="openExpenseModal()" aria-haspopup="dialog" aria-controls="add-expense-modal"
                    aria-label="إضافة مصروف جديد"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة مصروف جديد</span>

                </button>
                <a href="{{ route('export.expenses') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">تصدير
                    Excel</a>
            </div>
        </div>

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl shadow-slate-950/20"
            aria-labelledby="expenses-table-title">
            <div class="border-b border-slate-800 px-5 py-4 sm:px-6">
                <h2 id="expenses-table-title" class="font-semibold text-white">قائمة المصروفات</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-right text-sm text-slate-300">
                    <thead class="border-b border-slate-800 bg-slate-800/60 text-xs text-slate-400">
                        <tr>
                            <th scope="col" class="px-5 py-3.5 font-semibold sm:px-6">المنتج</th>
                            <th scope="col" class="px-4 py-3.5 font-semibold">المبلغ</th>
                            <th scope="col" class="px-5 py-3.5 font-semibold sm:px-6">تاريخ التسجيل</th>
                            <th scope="col" class="px-4 py-3.5 font-semibold">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/70">
                        @forelse ($expenses as $expense)
                            <tr class="transition hover:bg-slate-800/30">
                                <td class="px-5 py-4 font-medium text-white sm:px-6">
                                    {{ $expense->product }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 font-mono text-rose-400">
                                    {{ number_format((float) $expense->price, 2) }} ج.م
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-slate-400 sm:px-6">
                                    {{ $expense->created_at?->format('Y/m/d') ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-slate-400 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="openEditExpenseModal(this)"
                                            data-action="{{ route('expense.update', $expense) }}"
                                            data-expense-id="{{ $expense->id }}" data-product="{{ $expense->product }}"
                                            data-price="{{ number_format((float) $expense->price, 2, '.', '') }}"
                                            aria-label="تعديل مصروف {{ $expense->product }}"
                                            class="p-2 rounded-xl bg-slate-800/80 hover:bg-blue-600/20 text-slate-400 hover:text-blue-400 border border-slate-700/60 hover:border-blue-500/30 transition-all"
                                            title="تعديل المصروف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        {{-- Delete Button Form --}}
                                        <form action="{{ route('expense.destroy', $expense->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المصروف نهائياً؟')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="حذف مصروف {{ $expense->product }}"
                                                class="p-2 rounded-xl bg-slate-800/80 hover:bg-rose-600/20 text-slate-400 hover:text-rose-400 border border-slate-700/60 hover:border-rose-500/30 transition-all"
                                                title="حذف المصروف">
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
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <p class="font-medium text-slate-300">لا توجد مصروفات مسجلة حتى الآن.</p>
                                    <p class="mt-1 text-sm text-slate-500">ستظهر المصروفات هنا بعد تسجيلها.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($expenses->hasPages())
                <div class="border-t border-slate-800 px-5 py-4 sm:px-6">
                    {{ $expenses->links() }}
                </div>
            @endif
        </section>
    </div>

    <div id="add-expense-modal"
        class="{{ $errors->any() && !old('expense_id') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-black/80 p-3 backdrop-blur-sm sm:items-center sm:p-4"
        role="dialog" aria-modal="true" aria-labelledby="expense-modal-title">
        <div class="my-auto max-h-[calc(100dvh-1.5rem)] w-full max-w-lg overflow-y-auto rounded-2xl border border-slate-800 bg-slate-900 p-4 text-slate-200 shadow-2xl sm:p-6">
            <div class="mb-5 flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h2 id="expense-modal-title" class="text-lg font-bold text-white">إضافة مصروف جديد</h2>
                    <p class="mt-1 text-sm text-slate-400">أدخل بيانات المصروف لتسجيله.</p>
                </div>
                <button type="button" onclick="closeExpenseModal()"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-800 hover:text-white"
                    aria-label="إغلاق النافذة">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('expense.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="expense-product" class="mb-1.5 block text-sm font-medium text-slate-300">
                        اسم المنتج أو المصروف <span class="text-rose-400">*</span>
                    </label>
                    <input id="expense-product" name="product" type="text"
                        value="{{ old('expense_id') ? '' : old('product') }}" maxlength="255"
                        class="w-full rounded-xl border {{ $errors->has('product') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-800 px-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        placeholder="مثال: مستلزمات مكتبية">
                    @error('product')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expense-price" class="mb-1.5 block text-sm font-medium text-slate-300">
                        المبلغ (ج.م) <span class="text-rose-400">*</span>
                    </label>
                    <input id="expense-price" name="price" type="number"
                        value="{{ old('expense_id') ? '' : old('price') }}" min="0.01" max="99999999.99"
                        step="0.01" inputmode="decimal"
                        class="w-full rounded-xl border {{ $errors->has('price') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-800 px-3.5 py-2.5 font-mono text-sm text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        placeholder="0.00">
                    @error('price')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-800 pt-4 sm:flex-row sm:justify-end sm:gap-3">
                    <button type="button" onclick="closeExpenseModal()"
                        class="w-full rounded-xl bg-slate-800 px-4 py-2.5 text-sm text-slate-300 transition hover:bg-slate-700 hover:text-white sm:w-auto">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="w-full rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 sm:w-auto">
                        حفظ المصروف
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-expense-modal"
        class="{{ $errors->any() && old('expense_id') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-black/80 p-3 backdrop-blur-sm sm:items-center sm:p-4"
        role="dialog" aria-modal="true" aria-labelledby="edit-expense-modal-title">
        <div class="my-auto max-h-[calc(100dvh-1.5rem)] w-full max-w-lg overflow-y-auto rounded-2xl border border-slate-800 bg-slate-900 p-4 text-slate-200 shadow-2xl sm:p-6">
            <div class="mb-5 flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <h2 id="edit-expense-modal-title" class="text-lg font-bold text-white">تعديل المصروف</h2>
                    <p class="mt-1 text-sm text-slate-400">حدّث بيانات المصروف ثم احفظ التغييرات.</p>
                </div>
                <button type="button" onclick="closeEditExpenseModal()"
                    class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-800 hover:text-white"
                    aria-label="إغلاق النافذة">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="edit-expense-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="expense_id" value="{{ old('expense_id') }}">

                <div>
                    <label for="edit-expense-product" class="mb-1.5 block text-sm font-medium text-slate-300">
                        اسم المنتج أو المصروف <span class="text-rose-400">*</span>
                    </label>
                    <input id="edit-expense-product" name="product" type="text"
                        value="{{ old('expense_id') ? old('product') : '' }}" maxlength="255" required
                        class="w-full rounded-xl border {{ $errors->has('product') && old('expense_id') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-800 px-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        placeholder="مثال: مستلزمات مكتبية">
                    @if (old('expense_id'))
                        @error('product')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label for="edit-expense-price" class="mb-1.5 block text-sm font-medium text-slate-300">
                        المبلغ (ج.م) <span class="text-rose-400">*</span>
                    </label>
                    <input id="edit-expense-price" name="price" type="number"
                        value="{{ old('expense_id') ? old('price') : '' }}" min="0.01" max="99999999.99"
                        step="0.01" inputmode="decimal" required
                        class="w-full rounded-xl border {{ $errors->has('price') && old('expense_id') ? 'border-rose-500' : 'border-slate-700' }} bg-slate-800 px-3.5 py-2.5 font-mono text-sm text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        placeholder="0.00">
                    @if (old('expense_id'))
                        @error('price')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-800 pt-4 sm:flex-row sm:justify-end sm:gap-3">
                    <button type="button" onclick="closeEditExpenseModal()"
                        class="w-full rounded-xl bg-slate-800 px-4 py-2.5 text-sm text-slate-300 transition hover:bg-slate-700 hover:text-white sm:w-auto">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-500 sm:w-auto">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const expenseModal = document.getElementById('add-expense-modal');
        const editExpenseModal = document.getElementById('edit-expense-modal');

        function openExpenseModal() {
            editExpenseModal.classList.add('hidden');
            expenseModal.classList.remove('hidden');
            document.getElementById('expense-product').focus();
        }

        function closeExpenseModal() {
            expenseModal.classList.add('hidden');
        }

        function openEditExpenseModal(button) {
            closeExpenseModal();
            const form = document.getElementById('edit-expense-form');
            form.action = button.dataset.action;
            form.querySelector('[name="expense_id"]').value = button.dataset.expenseId;
            document.getElementById('edit-expense-product').value = button.dataset.product;
            document.getElementById('edit-expense-price').value = button.dataset.price;
            editExpenseModal.classList.remove('hidden');
            document.getElementById('edit-expense-product').focus();
        }

        function closeEditExpenseModal() {
            editExpenseModal.classList.add('hidden');
        }

        expenseModal.addEventListener('click', function(event) {
            if (event.target === expenseModal) {
                closeExpenseModal();
            }
        });

        editExpenseModal.addEventListener('click', function(event) {
            if (event.target === editExpenseModal) {
                closeEditExpenseModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (!expenseModal.classList.contains('hidden')) {
                    closeExpenseModal();
                }

                if (!editExpenseModal.classList.contains('hidden')) {
                    closeEditExpenseModal();
                }
            }
        });

        @if ($errors->any() && old('expense_id'))
            document.getElementById('edit-expense-form').action = @json(route('expense.update', old('expense_id')));
        @endif
    </script>
@endsection
