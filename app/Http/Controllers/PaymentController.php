<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('reservation')->get();
        return response()->json($payments);
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
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::create($validated);

        // Update reservation status if payment is completed
        if ($validated['status'] === 'completed') {
            $reservation = Reservation::find($validated['reservation_id']);
            $reservation->update(['status' => 'confirmed']);
        }

        return response()->json($payment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'numeric|min:0',
            'payment_date' => 'date|before_or_equal:today',
            'payment_method' => 'string|max:255',
            'status' => 'in:pending,completed,failed',
        ]);

        $payment->update($validated);

        // Update reservation status if payment is completed
        if (isset($validated['status']) && $validated['status'] === 'completed') {
            $payment->reservation->update(['status' => 'confirmed']);
        }

        return response()->json($payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
