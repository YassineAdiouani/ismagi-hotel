<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['client', 'room'])->get();
        $clients = Client::all();
        $rooms = Room::all();
        return view('reservations.index', compact('reservations', 'clients', 'rooms'));
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
        // Validate the reservation input data
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,canceled',
            'payment_method' => 'required|in:cash,credit_card,paypal,bank_transfer',
            'payment_status' => 'required|in:pending,completed,failed' // Add this validation
        ]);

        // Find the room and check if it is available
        $room = Room::findOrFail($validated['room_id']);
        if ($room->status !== 'available') {
            return response()->json(['errors' => ['room_id' => ['Room is not available']]], 400);
        }

        // Create the reservation record
        $reservation = Reservation::create($validated);

        // Update the room status to reserved
        $room->update(['status' => 'reserved']);

        // Automatically create the payment record using check-in date
        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $validated['total_price'],
            'payment_date' => $validated['check_in'],  // Payment date set to check-in date
            'payment_method' => $validated['payment_method'],
            'status' => $validated['payment_status']  // Use the selected payment status
        ]);

        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'check_in' => 'date|after_or_equal:today',
            'check_out' => 'date|after:check_in',
            'total_price' => 'numeric|min:0',
            'status' => 'in:pending,confirmed,canceled',
        ]);

        $reservation->update($validated);

        // Update room status if reservation is canceled
        if (isset($validated['status']) && $validated['status'] === 'canceled') {
            $reservation->room->update(['status' => 'available']);
        }

        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->room->update(['status' => 'available']);
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
