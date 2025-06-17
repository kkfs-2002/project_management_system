<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientController extends Controller
{
    // Show clients grouped by month-year, with pending requests
    public function index(Request $request)
    {
        $query = Client::query();
    
        // Filter by selected month if provided
        if ($request->has('month') && $request->month) {
            try {
                $month = Carbon::parse($request->month);
                $query->whereYear('created_at', $month->year)
                      ->whereMonth('created_at', $month->month);
            } catch (\Exception $e) {
                // Optional: handle invalid input
            }
        }
    
        // Get filtered clients
        $clients = $query->orderBy('created_at', 'desc')->get();
    
        // Group clients by Month-Year
        $clientsByMonth = $clients->groupBy(function ($client) {
            return Carbon::parse($client->created_at)->format('F Y');
        });
    
        // Sort groups by latest
        $clientsByMonth = $clientsByMonth->sortByDesc(function ($clients, $monthYear) {
            return Carbon::createFromFormat('F Y', $monthYear);
        });
    
        // Pending requests (regardless of filter)
        $pendingRequests = Client::where('edit_permission', 'pending')->get();
    
        return view('superadmin.clients.index', compact('clientsByMonth', 'pendingRequests'));
    }
    

    // Approve permission request
    public function approvePermission(Client $client)
    {
        $client->edit_permission = 'approved';
        $client->save();

        return back()->with('success', 'Permission approved.');
    }

    // Reject permission request
    public function rejectPermission(Client $client)
    {
        $client->edit_permission = 'rejected';
        $client->save();

        return back()->with('success', 'Permission rejected.');
    }
}
