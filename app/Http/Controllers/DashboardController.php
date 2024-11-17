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

        return view('dashboard.index', compact('totalRooms', 'totalClients', 'statusTotals', 'typeTotals'));
    }
}
