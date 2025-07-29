<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Profile;

class ClientController extends Controller
{
    // Show clients grouped by month-year, with pending requests
    public function index(Request $request)
    {
       
        // Correct role string (adjust this to match your DB)
        $managers = Profile::where('role', 'Marketing Manager')->with('user')->get();

    
        $query = Client::whereIn('payment_status', ['Advance', 'Full']);

    
        // Filter by selected month if provided
        if ($request->filled('month')) {
            try {
                $month = Carbon::parse($request->month);
                $query->whereYear('created_at', $month->year)
                      ->whereMonth('created_at', $month->month);
            } catch (\Exception $e) {
                // Optionally handle invalid month input here
            }
        }
    
        // Filter by marketing manager if provided
        if ($request->filled('manager')) {
            $query->where('marketing_manager_id', $request->manager);
        }
    
        // Get filtered clients ordered by newest
        $clients = $query->orderBy('created_at', 'desc')->get();
    
        // Group clients by Month-Year string, e.g. "June 2025"
        $clientsByMonth = $clients->groupBy(function ($client) {
            return Carbon::parse($client->created_at)->format('F Y');
        });
    
        // Sort groups descending by date (latest month first)
        $clientsByMonth = $clientsByMonth->sortByDesc(function ($clients, $monthYear) {
            return Carbon::createFromFormat('F Y', $monthYear);
        });
    
        // Get all pending requests regardless of filter
        $pendingRequests = Client::where('edit_permission', 'pending')->get();
    
        
    
        // Return view with all necessary data
        return view('superadmin.clients.index', compact('clientsByMonth', 'pendingRequests', 'managers'));
    }

    public function create()
    {
        $managers = Profile::all(); // or however you get marketing managers
    
        return view('superadmin.clients.create', compact('managers'));
    }
    
    public function store(Request $request)
{
    $validated = $request->validate([
        'marketing_manager_id' => 'required|string|exists:profiles,employee_id',
        'name' => 'required|string|max:255',
        'contact_number' => 'nullable|string',
        'project_name' => 'nullable|string',
        'project_type' => 'nullable|string',
        'technology' => 'nullable|string',
        'reminder_date' => 'nullable|date',
        'note' => 'nullable|string',
        'amount' => 'nullable|numeric',
        'payment_status' => 'nullable|string',
    ]);

    $client = new Client($validated);
    $client->marketing_manager_id = $request->marketing_manager_id;
    $client->save();

    return redirect()->route('superadmin.clients.index')->with('success', 'Client sent to manager.');
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
