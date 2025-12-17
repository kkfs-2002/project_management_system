<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Profile;
use Illuminate\Support\Facades\Http;

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

    // Show the add client/marketing project form
    public function create()
    {
        // Get all marketing managers
        $managers = Profile::where('role', 'Marketing Manager')->with('user')->get();
    
        return view('superadmin.clients.add', compact('managers'));
    }
    
    // Store new marketing project
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date' => 'required|date',
            'project_type' => 'required|string',
            'project_category' => 'required|string',
            'contact_method' => 'required|string',
            'call_sequence' => 'required|string',
            'comments' => 'required|string',
            'project_price' => 'required|numeric',
            'marketing_manager_id' => 'required|string|exists:profiles,employee_id',
        ]);

        // Create new client record
        $client = new Client();
        $client->name = $validated['client_name'];
        $client->contact_number = $validated['phone_number'];
        $client->project_name = $validated['project_category']; // Category as project name
        $client->project_type = $validated['project_type'];
        $client->technology = $validated['contact_method']; // Using technology field for contact method
        $client->reminder_date = $validated['date'];
        $client->note = $validated['comments'] . "\n\nCall Sequence: " . $validated['call_sequence'];
        $client->amount = $validated['project_price'];
        $client->payment_status = 'Pending'; // Default status
        $client->marketing_manager_id = $validated['marketing_manager_id'];
        $client->edit_permission = 'approved'; // Auto-approve since it's from superadmin
        $client->save();

        return redirect()->route('superadmin.clients.add')->with('success', 'Marketing project added successfully!');
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