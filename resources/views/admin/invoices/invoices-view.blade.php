@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                    <span>لوحة التحكم</span>
                    <span class="text-slate-600">/</span>
                    <span class="text-blue-400 font-medium">الفواتير</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">إدارة الفواتير</h1>
                <p class="text-sm text-slate-400 mt-1">عرض ومتابعة الفواتير المسجلة.</p>
            </div>
            <a href="{{ route('export.invoices') }}"
                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all active:scale-95">تصدير Excel</a>
        </div>


        <livewire:invoices-search />
    </div>
@endsection
