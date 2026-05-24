<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Owner;
use App\Models\Plot;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['owner', 'plot']);

        if ($request->filled('search')) {
            $query->whereHas('owner', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $owners = Owner::all();
        $paidPlotIds = Payment::where('status', 'paid')->pluck('plot_id')->toArray();
        $plots = Plot::with('owners')->whereNotIn('id', $paidPlotIds)->get();
        return view('payments.create', compact('owners', 'plots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'plot_id' => 'required|exists:plots,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,gcash,bank_transfer,check',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,pending',
        ]);

        $data['created_by'] = auth()->id();
        Payment::create($data);

        return redirect()->route('payments.index');
    }

    public function show(Payment $payment)
    {
        $payment->load(['owner', 'plot']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $owners = Owner::all();
        $paidPlotIds = Payment::where('status', 'paid')->where('id', '!=', $payment->id)->pluck('plot_id')->toArray();
        $plots = Plot::with('owners')->whereNotIn('id', $paidPlotIds)->get();
        return view('payments.edit', compact('payment', 'owners', 'plots'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'plot_id' => 'required|exists:plots,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,gcash,bank_transfer,check',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,pending',
        ]);

        $data['created_by'] = auth()->id();
        $payment->update($data);

        return redirect()->route('payments.index');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
