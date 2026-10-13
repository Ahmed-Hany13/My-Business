<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use WithPagination;

    public function index(Request $request)
    {
        $dateFilterRules = [
            'filter_start_date' => ['nullable', 'date'],
            'filter_end_date' => ['nullable', 'date'],
        ];

        if ($request->filled('filter_start_date')) {
            $dateFilterRules['filter_end_date'][] = 'after_or_equal:filter_start_date';
        }

        $request->validate($dateFilterRules);

        $query = Client::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('filter_start_date')) {
            $query->where('end_date', '>=', $request->input('filter_start_date'));
        }

        if ($request->filled('filter_end_date')) {
            $query->where('start_date', '<=', $request->input('filter_end_date'));
        }

        $clients = (clone $query)->paginate(5);
        $sumBalance   = (clone $query)->sum('balance');
        $sumDebt = (clone $query)->sum('debt');
        return view('admin.clients.clients-view',compact('clients','sumBalance','sumDebt'));
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
    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validated();
        Client::create($validatedData);
        return redirect()->back()->with('success', 'تم إضافة العميل بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client = Client::with('invoices')->findOrFail($client->id);
        $invoices = $client->invoices()->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.clients.client-details', compact('client','invoices'));
    }

    public function pay(PayRequest $request, Client $client)
    {
        $validatedData = $request->validated();

        $amount = (float) $validatedData['amount'];

        DB::transaction(function () use ($client, $amount, $validatedData) {
            $client = Client::query()->lockForUpdate()->findOrFail($client->id);
            $client->balance = (float) ($client->balance ?? 0) + $amount;
            $client->debt = (float) ($client->debt ?? 0) - $amount;
            $client->save();

            $client->invoices()->create([
                'invoice_number' => 'INV-' . time(),
                'client_id' => $client->id,
                'total_amount' => $amount,
                'notes' => $validatedData['notes'] ?? null,
            ]);
        });

        $client->refresh();

        return redirect()->back()->with('success', 'تم تسديد دفعة بقيمة ' .
            number_format($amount, 2) . ' ج.م بنجاح. الرصيد الحالي: ' .
            number_format($client->balance, 2) . ' ج.م، المديونية الحالية: ' .
            number_format($client->debt, 2) . ' ج.م');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validatedData = $request->validated();


        $client->update($validatedData);
        return redirect()->back()->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف العميل بنجاح.');
    }
}
