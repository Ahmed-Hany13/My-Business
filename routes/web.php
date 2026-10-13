<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    Route::resource('/client',ClientController::class)->names('client');
    Route::post('client/{client}/pay', [ClientController::class, 'pay'])->name('client.pay');

    Route::resource('/invoice', InvoiceController::class)->names('invoice');
    Route::resource('/expenses', ExpenseController::class)->names('expense');
    Route::get('/admin/backup', [BackupController::class, 'download'])->name('backup.download');
    Route::get('/admin/export/clients', [ExportController::class, 'exportClients'])
    ->name('export.clients');
    Route::get('/admin/export/invoices', [ExportController::class, 'exportInvoices'])
    ->name('export.invoices');
    Route::get('/admin/export/expenses', [ExportController::class, 'exportExpenses'])
    ->name('export.expenses');
});


require __DIR__.'/auth.php';
