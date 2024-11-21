<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
        return view('reservations.index',compact('reservations','clients','rooms'));
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
            'client_id' => 'required|exists:clients,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,canceled',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        if ($room->status !== 'available') {
            return response()->json(['error' => 'Room is not available'], 400);
        }

        $reservation = Reservation::create($validated);
        $room->update(['status' => 'reserved']);

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
