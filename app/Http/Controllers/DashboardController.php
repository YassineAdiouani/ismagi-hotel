<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        
        $totalRooms = Room::count();

        $totalClients = Client::count();

        $statusCounts = Room::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        $statuses = ['available', 'reserved', 'maintenance', 'occupied'];
        $statusTotals = array_merge(array_fill_keys($statuses, 0), $statusCounts->toArray());

        $typeCounts = Room::select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        $types = ['single', 'double', 'suite'];
        $typeTotals = array_merge(array_fill_keys($types, 0), $typeCounts->toArray());

        $topReservedRooms = DB::table('reservations')
            ->select( 'rooms.id', 'rooms.nbr', 'rooms.type', 'rooms.price', DB::raw('COUNT(reservations.id) as reservation_count'))
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->groupBy('rooms.id', 'rooms.nbr', 'rooms.type', 'rooms.price')
            ->orderByDesc('reservation_count')
            ->limit(5)
            ->get();

        $topClients = DB::table('reservations')
            ->select(
                'clients.id',
                DB::raw("CONCAT(clients.first_name, ' ', clients.last_name) as full_name"),
                'clients.cin',
                DB::raw('COUNT(reservations.id) as reservation_count'),
                DB::raw('SUM(reservations.total_price) as total_spent')
            )
            ->join('clients', 'reservations.client_id', '=', 'clients.id')
            ->groupBy('clients.id', 'clients.first_name', 'clients.last_name', 'clients.cin')
            ->orderByDesc('reservation_count')
            ->limit(5)
            ->get();

        $clients = Client::all();
        $rooms = Room::all();  

        return view('dashboard.index', compact('totalRooms', 'totalClients', 'statusTotals', 'typeTotals', 'topReservedRooms', 'topClients', 'clients', 'rooms'));
    }
}
