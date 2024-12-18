<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        
        // Perform the search
        $clients = Client::where('first_name', 'LIKE', "%{$term}%")
            ->orWhere('last_name', 'LIKE', "%{$term}%")
            ->orWhere('cin', 'LIKE', "%{$term}%")
            ->get();

        // Map the results for Select2
        $results = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'text' => "{$client->first_name} {$client->last_name}",
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'cin' => $client->cin,
            ];
        });

        return response()->json($results);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        // Check if the request is an AJAX request
        if (request()->ajax()) {
            // Return clients data as JSON for AJAX requests
            return response()->json($clients);
        }
    
        // For non-AJAX requests, return the full view
        return view('clients.index', compact('clients'));
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
        $validatedData = $request->validate([
            'cin' => 'required|string|max:255|unique:clients,cin',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'phone' => 'required|string|max:20',
        ]);

        $client = Client::create($validatedData);

        return response()->json($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        return response()->json(['message' => 'Client updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
