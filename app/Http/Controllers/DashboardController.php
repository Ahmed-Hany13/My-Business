<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
class DashboardController extends Controller
{
    public function index()
    {
        $clientCount = Client::query()->count();
        $balance = Client::query()->sum('balance');
        $totalDebt = Client::query()->sum('debt');
        $invoiceCount = Invoice::query()->count();
        $invoiceTotal = Invoice::query()->sum('total_amount');
        $totalExpenses = Expense::query()->sum('price');
        $totalBalance = $balance - $totalExpenses;
        $recentInvoices = Invoice::query()
            ->with('client')
            ->latest()
            ->limit(5)
            ->get();
        $monthProfit = Client::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('balance');
        $yearProfit = Client::query()
            ->whereYear('created_at', now()->year)
            ->sum('balance');
        $monthlyProfit = $monthProfit - $totalExpenses;
        $yearlyProfit = $yearProfit - $totalExpenses;
        return view('dashboard', compact(
            'clientCount',
            'totalBalance',
            'totalDebt',
            'invoiceCount',
            'invoiceTotal',
            'recentInvoices',
            'monthlyProfit',
            'yearlyProfit'
        ));
    }
}
