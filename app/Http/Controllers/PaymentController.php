<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Invoice;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['customer', 'invoice'])->latest()->paginate(10);
        
        return Inertia::render('payments/index', [
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::with('customer')->where('status', '!=', 'paid')->get();
        
        return Inertia::render('payments/create', [
            'invoices' => $invoices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        
        // Get the invoice to determine customer
        $invoice = Invoice::findOrFail($validated['invoice_id']);
        $validated['customer_id'] = $invoice->customer_id;

        $payment = Payment::create($validated);

        // Update invoice status to paid if payment covers full amount
        if ($payment->amount >= $invoice->amount) {
            $invoice->update([
                'status' => 'paid',
                'paid_date' => $payment->payment_date
            ]);
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['customer', 'invoice']);
        
        return Inertia::render('payments/show', [
            'payment' => $payment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $invoices = Invoice::with('customer')->where('status', '!=', 'paid')->get();
        
        return Inertia::render('payments/edit', [
            'payment' => $payment,
            'invoices' => $invoices
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();
        
        // Get the invoice to determine customer
        $invoice = Invoice::findOrFail($validated['invoice_id']);
        $validated['customer_id'] = $invoice->customer_id;

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}