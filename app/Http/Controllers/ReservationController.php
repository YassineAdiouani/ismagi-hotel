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
        // Load the related client, room, and payment data
        $reservation->load(['client', 'room', 'payment']);

        // Construct a custom response
        return response()->json([
            'id' => $reservation->id,
            'client_id' => $reservation->client_id,
            'client_name' => $reservation->client->first_name . ' ' . $reservation->client->last_name,
            'client_cin' => $reservation->client->cin,
            'room_id' => $reservation->room_id,
            'room_nbr' => $reservation->room->nbr,
            'room_type' => $reservation->room->type,
            'check_in' => $reservation->check_in,
            'check_out' => $reservation->check_out,
            'total_price' => $reservation->total_price,
            'status' => $reservation->status,
            'payment_method' => $reservation->payment->payment_method,
            'payment_status' => $reservation->payment->status,
            'payment_amount' => $reservation->payment->amount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Validate the reservation input data
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,canceled',
            'payment_method' => 'required|in:cash,credit_card,paypal,bank_transfer',
            'payment_status' => 'required|in:pending,completed,failed'
        ]);
    
        // Check if the room has changed and validate availability
        if ($reservation->room_id != $validated['room_id']) {
            $newRoom = Room::findOrFail($validated['room_id']);
            if ($newRoom->status !== 'available') {
                return response()->json(['errors' => ['room_id' => ['Room is not available']]], 400);
            }
    
            // Release the old room by setting its status to 'available'
            $oldRoom = Room::findOrFail($reservation->room_id);
            $oldRoom->update(['status' => 'available']);
    
            // Update the new room status to 'reserved'
            $newRoom->update(['status' => 'reserved']);
        }
    
        // Update the reservation record with the validated data
        $reservation->update($validated);
    
        // Update the related payment record
        $reservation->payment()->update([
            'amount' => $validated['total_price'],
            'payment_date' => $validated['check_in'], // Set payment date to check-in date
            'payment_method' => $validated['payment_method'],
            'status' => $validated['payment_status']
        ]);
    
        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation->fresh()  // Return the updated reservation
        ]);
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
