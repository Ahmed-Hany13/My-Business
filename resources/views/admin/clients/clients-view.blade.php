@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Page Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                    <span>لوحة التحكم</span>
                    <span class="text-slate-600">/</span>
                    <span class="text-blue-400 font-medium">العملاء</span>
                </div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">إدارة العملاء</h1>
                    <span
                        class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        {{ $clients->total() }} عميل
                    </span>
                </div>
                <p class="text-sm text-slate-400 mt-1">عرض وبحث وتعديل وإدارة كافة حسابات العملاء وأرصدتهم ومديونياتهم.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <button onclick="toggleModal('addClientModal')"
                    class="inline-flex flex-1 sm:flex-none items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة عميل جديد</span>
                </button>
                <a href="{{ route('export.clients') }}" class="inline-flex flex-1 sm:flex-none items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">تصدير Excel</a>
            </div>
        </div>
        <livewire:client-search />
    </div>
    </div>

    <!-- 1. Add Client Modal -->
    <div id="addClientModal"
        class="{{ $errors->hasAny(['name', 'product', 'balance', 'debt', 'monthly_payment', 'start_date', 'end_date', 'notes']) && !session('is_edit') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-start sm:items-center justify-center overflow-y-auto p-3 sm:p-4 bg-black/80 backdrop-blur-sm transition-opacity">
        <div class="my-auto max-h-[calc(100dvh-1.5rem)] w-full max-w-xl overflow-y-auto rounded-2xl bg-slate-900 border border-slate-800 shadow-2xl p-4 sm:p-6 text-slate-200">
            <div class="flex items-center justify-between mb-5 border-b border-slate-800/80 pb-3">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">إضافة عميل جديد</h3>
                </div>
                <button onclick="toggleModal('addClientModal')"
                    class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('client.store') }}" method="POST" class="space-y-4">
                @csrf
                {{-- Name & product in 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">اسم العميل <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="مثال: أحمد محمد"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('name') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('name')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">المنتج</label>
                        <input type="text" name="product" value="{{ old('product') }}" placeholder="مثال: iproduct 13"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('product') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('product')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Balance & Debt in 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">الرصيد المالي (ج.م)</label>
                        <input type="number" step="0.01" name="balance" value="{{ old('balance', '0.00') }}"
                            placeholder="0.00"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('balance') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                        @error('balance')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">المديونية (ج.م)</label>
                        <input type="number" step="0.01" name="debt" value="{{ old('debt', '0.00') }}"
                            placeholder="0.00"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('debt') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                        @error('debt')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">الدفع الشهري (ج.م)</label>
                        <input type="number" step="0.01" name="monthly_payment"
                            value="{{ old('monthly_payment', '0.00') }}" placeholder="0.00"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('monthly_payment') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                        @error('monthly_payment')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Start Date & End Date in 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">تاريخ البدء <span
                                class="text-rose-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('start_date') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('start_date')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">تاريخ الانتهاء <span
                                class="text-rose-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('end_date') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        @error('end_date')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">ملاحظات</label>
                        <textarea name="notes" rows="3" placeholder="أضف أي ملاحظات إضافية عن العميل..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border {{ $errors->has('notes') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-700' }} text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"></textarea>
                        @error('notes')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-800/80">
                    <button type="button" onclick="toggleModal('addClientModal')"
                        class="px-5 py-2.5 rounded-xl bg-slate-800 text-xs sm:text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">إلغاء</button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">حفظ
                        العميل</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment Confirmation Modal -->
    <div id="paymentModal"
        class="{{ $errors->hasAny(['amount', 'notes']) ? '' : 'hidden' }} fixed inset-0 z-50 flex items-start sm:items-center justify-center overflow-y-auto p-3 sm:p-4 bg-black/80 backdrop-blur-sm transition-opacity">
        <div class="my-auto max-h-[calc(100dvh-1.5rem)] w-full max-w-md overflow-y-auto rounded-2xl bg-slate-900 border border-slate-800 shadow-2xl p-4 sm:p-6 text-slate-200">
            <div class="flex items-center justify-between mb-5 border-b border-slate-800/80 pb-3">
                <h3 class="text-lg font-bold text-white">تأكيد تسديد الدفعة</h3>
                <button type="button" onclick="toggleModal('paymentModal')"
                    class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors"
                    aria-label="إغلاق">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="paymentForm" action="{{ route('client.index') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="paymentClientId" name="client_id" value="{{ old('client_id') }}">
                <p class="text-sm text-slate-300">
                    تأكيد دفعة للعميل: <span id="paymentClientName" class="font-semibold text-white"></span>
                </p>
                <div>
                    <label for="paymentAmount" class="block text-xs font-semibold text-slate-300 mb-1.5">
                        مبلغ الدفعة (ج.م)
                    </label>
                    <input id="paymentAmount" type="number" name="amount" value="{{ old('amount') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                    @error('amount')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1.5">يمكن تعديل المبلغ لهذه الدفعة فقط؛ لن تتغير قيمة القسط الشهري.
                    </p>
                </div>
                <div>
                    <label for="paymentNotes" class="block text-xs font-semibold text-slate-300 mb-1.5">
                        ملاحظات (اختياري)
                    </label>
                    <textarea id="paymentNotes" name="notes" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800/80">
                    <button type="button" onclick="toggleModal('paymentModal')"
                        class="px-5 py-2.5 rounded-xl bg-slate-800 text-xs sm:text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-emerald-600/30 transition-all active:scale-95">
                        تأكيد التسديد
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Edit Client Modal -->
    <div id="editClientModal"
        class="hidden fixed inset-0 z-50 overflow-y-auto p-3 sm:p-4 bg-black/80 backdrop-blur-sm transition-opacity">
        <div class="mx-auto my-0 max-h-[calc(100dvh-1.5rem)] w-full max-w-xl overflow-y-auto rounded-2xl bg-slate-900 border border-slate-800 shadow-2xl p-4 sm:my-[5vh] sm:p-6 text-slate-200">
            <div class="flex items-center justify-between mb-5 border-b border-slate-800/80 pb-3">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">تعديل بيانات العميل</h3>
                </div>
                <button onclick="toggleModal('editClientModal')"
                    class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editClientForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Name & product in 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">اسم العميل <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="edit_name"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">المنتج</label>
                        <input type="text" name="product" id="edit_product"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                    </div>
                </div>

                {{-- Balance, Debt & Monthly Payment --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">الرصيد المالي (ج.م)</label>
                        <input type="number" step="0.01" name="balance" id="edit_balance"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">المديونية (ج.م)</label>
                        <input type="number" step="0.01" name="debt" id="edit_debt"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">الدفع الشهري (ج.م)</label>
                        <input type="number" step="0.01" name="monthly_payment" id="edit_monthly_payment"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono">
                    </div>
                </div>

                {{-- Start Date & End Date in 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">تاريخ البدء <span
                                class="text-rose-500">*</span></label>
                        <input type="date" name="start_date" id="edit_start_date"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">تاريخ الانتهاء <span
                                class="text-rose-500">*</span></label>
                        <input type="date" name="end_date" id="edit_end_date"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">ملاحظات</label>
                    <textarea name="notes" id="edit_notes" rows="3"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-800/80">
                    <button type="button" onclick="toggleModal('editClientModal')"
                        class="px-5 py-2.5 rounded-xl bg-slate-800 text-xs sm:text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">إلغاء</button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-emerald-600/30 transition-all active:scale-95">تحديث
                        البيانات</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Scripts -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function openEditModal(client) {
            const form = document.getElementById('editClientForm');
            form.action = `/client/${client.id}`;
            document.getElementById('edit_name').value = client.name || '';
            document.getElementById('edit_product').value = client.product || '';
            document.getElementById('edit_balance').value = client.balance || '0.00';
            document.getElementById('edit_debt').value = client.debt || '0.00';
            document.getElementById('edit_monthly_payment').value = client.monthly_payment || '0.00';
            document.getElementById('edit_notes').value = client.notes || '';
            document.getElementById('edit_start_date').value = client.start_date || '';
            document.getElementById('edit_end_date').value = client.end_date || '';
            toggleModal('editClientModal');
        }

        function openPaymentModal(button) {
            const paymentAmountInput = document.getElementById('paymentAmount');
            const monthlyPayment = button.dataset.monthlyPayment || '0.00';

            document.getElementById('paymentForm').action = button.dataset.action;
            document.getElementById('paymentClientId').value = button.dataset.clientId;
            document.getElementById('paymentClientName').textContent = button.dataset.clientName;
            paymentAmountInput.value = monthlyPayment;
            document.getElementById('paymentNotes').value = '';
            document.getElementById('paymentModal').classList.remove('hidden');
            paymentAmountInput.focus();
        }

        @if ($errors->hasAny(['amount', 'notes']) && old('client_id'))
            const paymentButton = Array.from(document.querySelectorAll('[data-client-id]'))
                .find(button => button.dataset.clientId === @json((string) old('client_id')));

            if (paymentButton) {
                openPaymentModal(paymentButton);
                document.getElementById('paymentAmount').value = @json(old('amount'));
                document.getElementById('paymentNotes').value = @json(old('notes', ''));
            }
        @endif

        // Close modals on Escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const addModal = document.getElementById('addClientModal');
                const editModal = document.getElementById('editClientModal');
                const paymentModal = document.getElementById('paymentModal');
                if (addModal && !addModal.classList.contains('hidden')) addModal.classList.add('hidden');
                if (editModal && !editModal.classList.contains('hidden')) editModal.classList.add('hidden');
                if (paymentModal && !paymentModal.classList.contains('hidden')) paymentModal.classList.add(
                    'hidden');
            }
        });
    </script>
@endsection
