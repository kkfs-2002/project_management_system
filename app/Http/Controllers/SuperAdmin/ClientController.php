<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientController extends Controller
{
    // Show clients grouped by month-year, with pending requests
    public function index()
    {
        // Get all clients ordered by creation date (newest first)
        $clients = Client::orderBy('created_at', 'desc')->get();

        // Group clients by month-year
        $clientsByMonth = $clients->groupBy(function ($client) {
            return $client->created_at->format('F Y'); // e.g., "June 2025"
        });

        // Sort the grouped clients by date descending
        $clientsByMonth = $clientsByMonth->sortByDesc(function ($clients, $monthYear) {
            return Carbon::createFromFormat('F Y', $monthYear);
        });

        // Fetch pending requests
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
