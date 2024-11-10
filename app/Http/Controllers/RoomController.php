<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){

        $search = $request->input('search');
        $type = $request->input('type');
        $status = $request->input('status');

        $query = Room::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nbr', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $rooms = $query->orderBy('nbr')->paginate(8);

        $types = Room::select('type')->distinct()->get();
        $statuses = Room::select('status')->distinct()->get();

        return view('rooms.index', compact('rooms', 'types', 'statuses'));
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
    public function store(Request $request){

        $validatedData = $request->validate([
            'nbr' => 'required|string|max:255',
            'floor' => 'required|integer',
            'price' => 'required|numeric',
            'type' => 'required|in:single,double,suite',
            'status' => 'required|in:available,reserved,maintenance,occupied',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('room_images', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        $validatedData['images'] = json_encode($imagePaths);

        $room = Room::create($validatedData);

        return response()->json($room);
    }



    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $room->update($request->all());
        return response()->json(['message' => 'Room updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}
