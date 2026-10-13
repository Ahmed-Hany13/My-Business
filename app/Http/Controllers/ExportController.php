<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Exports\ExpensesExport;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportClients()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
        }

    public function exportInvoices()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
    public function exportExpenses()
    {
        return Excel::download(new ExpensesExport, 'expenses.xlsx');
    }
}
