<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
        ], [
            'product.required' => 'يرجى إدخال اسم المنتج أو المصروف.',
            'product.max' => 'يجب ألا يتجاوز اسم المصروف 255 حرفاً.',
            'price.required' => 'يرجى إدخال مبلغ المصروف.',
            'price.numeric' => 'يجب أن يكون المبلغ قيمة رقمية.',
            'price.min' => 'يجب أن يكون مبلغ المصروف أكبر من صفر.',
            'price.max' => 'المبلغ يتجاوز الحد المسموح.',
        ]);

        Expense::create($validated);

        return redirect()->route('expense.index')->with('success', 'تم تسجيل المصروف بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'product' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
        ], [
            'product.required' => 'يرجى إدخال اسم المنتج أو المصروف.',
            'product.max' => 'يجب ألا يتجاوز اسم المصروف 255 حرفاً.',
            'price.required' => 'يرجى إدخال مبلغ المصروف.',
            'price.numeric' => 'يجب أن يكون المبلغ قيمة رقمية.',
            'price.min' => 'يجب أن يكون مبلغ المصروف أكبر من صفر.',
            'price.max' => 'المبلغ يتجاوز الحد المسموح.',
        ]);

        $expense->update($validated);

        return redirect()->route('expense.index')->with('success', 'تم تحديث المصروف بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'تم حذف المصروف بنجاح.');
    }
}
