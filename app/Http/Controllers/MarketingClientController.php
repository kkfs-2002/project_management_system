<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MarketingClientController extends Controller
{
public function dashboard()
{
    $employeeId = session('employee_id'); // Get the logged-in marketing manager's ID

    // ✅ Count clients added by this manager
    $totalClients = Client::where('marketing_manager_id', $employeeId)->count();

    // ✅ Count only reminders for clients with 'No Payment' and reminder set
    $totalReminders = Client::where('marketing_manager_id', $employeeId)
                            ->where('payment_status', 'No Payment')
                            ->whereNotNull('reminder_date')
                            ->count();

    return view('marketing.dashboard', compact('totalClients', 'totalReminders'));
}

    // View all clients
    public function index(Request $request)
{
    $employeeId = session('employee_id'); // Ensure we get the correct manager ID

    // ✅ Always filter by marketing_manager_id since this controller is ONLY for Marketing Managers
    $query = Client::where('marketing_manager_id', $employeeId);

    // Optional month filter
    if ($request->has('month') && $request->month) {
        try {
            $month = Carbon::parse($request->month);
            $query->whereYear('created_at', $month->year)
                  ->whereMonth('created_at', $month->month);
        } catch (\Exception $e) {
            // Optional: log error or ignore
        }
    }

   $clients = $query->whereIn('payment_status', ['Advance', 'Full'])  // ✅ Only show active clients
                 ->orderBy('created_at', 'desc')
                 ->get();


    // Group by Month-Year
    $clientsByMonth = $clients->groupBy(function ($client) {
        return Carbon::parse($client->created_at)->format('F Y');
    });

    return view('marketing.clients.index', compact('clientsByMonth'));
}

    
    // Show create client form
    public function create()
    {
        return view('marketing.clients.create');
    }

    // Store new client
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'project_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|in:Website,System,Mobile App,Other',
            'technology' => 'nullable|string|max:255',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:No Payment,Advance,Full',
        ]);

        // Auto-set status based on payment_status
        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';

         // ✅ Add marketing manager ID from session
         $validated['marketing_manager_id'] = session('employee_id');

        Client::create($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client added successfully!');
    }

    // Show edit form
    public function edit(Client $client)
    {
        return view('marketing.clients.edit', compact('client'));
    }

    // Update client
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'project_name' => 'nullable|string|max:255',
           'project_type' => 'required|in:Website,System,Mobile App,Other',
            'technology' => 'nullable|string|max:255',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:No Payment,Advance,Full',
        ]);

        // Auto-set status based on payment_status
        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';
        
       

        $client->update($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client updated successfully!');
    }

    // Delete client
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('marketing.clients.index')->with('success', 'Client deleted successfully!');
    }

    // Filter by status
    public function status($type)
{
    $clients = Client::where('marketing_manager_id', session('employee_id'))
    ->where('status', $type)
    ->orderBy('created_at', 'desc')
    ->get();

    // Group clients by month-year
    $clientsByMonth = $clients->groupBy(function ($client) {
        return \Carbon\Carbon::parse($client->created_at)->format('F Y');
    });

    return view('marketing.clients.index', compact('clientsByMonth'));
}


public function reminders(Request $request)
{
    $query = Client::where('marketing_manager_id', session('employee_id'))
                   ->where('payment_status', 'No Payment') // ✅ Only No Payment clients
                   ->whereNotNull('reminder_date');        // ✅ Ensure reminder is set

    // 📅 Upcoming 7 days filter
    if ($request->has('upcoming') && $request->upcoming == 1) {
        $today = \Carbon\Carbon::today();
        $next7 = \Carbon\Carbon::today()->addDays(7);

        $query->whereDate('reminder_date', '>=', $today)
              ->whereDate('reminder_date', '<=', $next7);
    }
    // 📆 Optional month filter
    elseif ($request->has('month') && $request->month) {
        try {
            $month = \Carbon\Carbon::parse($request->month);
            $query->whereYear('reminder_date', $month->year)
                  ->whereMonth('reminder_date', $month->month);
        } catch (\Exception $e) {
            // Handle invalid month
        }
    }

    $clients = $query->orderBy('reminder_date')->get();

    return view('marketing.clients.reminders', compact('clients'));
}



public function report(Request $request)
{
    // Get the logged-in marketing manager's employee_id
    $employeeId = session('employee_id');

    // Filter month or default to current month
    $month = $request->input('month') ?? now()->format('Y-m');
    $date = Carbon::parse($month);

    // Get clients for this marketing manager in that month
    $clients = Client::where('marketing_manager_id', $employeeId)
                     ->whereYear('created_at', $date->year)
                     ->whereMonth('created_at', $date->month)
                     ->get();

    // Prepare data for chart or summary if needed
    $projectTypeData = $clients->groupBy('project_type')->map->count();

    // If user wants PDF download
    if ($request->has('download')) {
        $pdf = Pdf::loadView('marketing.clients.report_pdf', [
            'clients' => $clients,
            'month' => $date->format('F Y')
        ]);
        return $pdf->download('Monthly_Client_Report.pdf');
    }

    // Show report view
    return view('marketing.clients.report', compact('clients', 'projectTypeData', 'month'));
}

   

}
