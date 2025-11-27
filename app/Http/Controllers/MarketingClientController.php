<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf;

class MarketingClientController extends Controller
{
    public function dashboard()
{
    // Get authenticated marketing manager
    $marketing = Auth::user();
    
    if (!$marketing) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Client statistics (adjust based on your actual model)
    $totalClients = \App\Models\Client::count();
    $activeClients = \App\Models\Client::where('status', 'active')->count();
    $inactiveClients = \App\Models\Client::where('status', 'inactive')->count();
    $upcomingReminders = \App\Models\Client::whereNotNull('reminder_date')
        ->whereDate('reminder_date', '>=', now())
        ->count();

    // Get today's attendance
    $todayAttendance = Attendance::where('profile_id', $marketing->id)
        ->whereDate('date', Carbon::today())
        ->first();

    return view('marketing.dashboard', compact(
        'marketing',
        'totalClients',
        'activeClients',
        'inactiveClients',
        'upcomingReminders',
        'todayAttendance'
    ));
}

    public function index(Request $request)
    {
        $employeeId = session('employee_id');

        $query = Client::where('marketing_manager_id', $employeeId);

        if ($request->has('month') && $request->month) {
            try {
                $month = Carbon::parse($request->month);
                $query->whereYear('created_at', $month->year)
                      ->whereMonth('created_at', $month->month);
            } catch (\Exception $e) {
                // Ignore invalid month
            }
        }

        $clients = $query->whereIn('payment_status', ['Advance', 'Full'])
                         ->where('status', '!=', 'cancelled')
                         ->orderBy('created_at', 'desc')
                         ->get();

        $clientsByMonth = $clients->groupBy(function ($client) {
            return Carbon::parse($client->created_at)->format('F Y');
        });

        return view('marketing.clients.index', compact('clientsByMonth'));
    }

    public function create()
    {
        return view('marketing.clients.create');
    }

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

        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';
        $validated['marketing_manager_id'] = session('employee_id');

        Client::create($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client added successfully!');
    }

    public function edit(Client $client)
    {
        return view('marketing.clients.edit', compact('client'));
    }

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

        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';

        $client->update($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('marketing.clients.index')->with('success', 'Client deleted successfully!');
    }

    public function status($type)
    {
        $clients = Client::where('marketing_manager_id', session('employee_id'))
                         ->where('status', $type)
                         ->orderBy('created_at', 'desc')
                         ->get();

        $clientsByMonth = $clients->groupBy(function ($client) {
            return Carbon::parse($client->created_at)->format('F Y');
        });

        return view('marketing.clients.index', compact('clientsByMonth'));
    }

    // ✅ UPDATED: Show reminders only for No Payment + not cancelled + have reminder date
    public function reminders(Request $request)
    {
        $query = Client::where('marketing_manager_id', session('employee_id'))
                       ->where('payment_status', 'No Payment')
                       ->where('status', '!=', 'cancelled')
                       ->whereNotNull('reminder_date');

        if ($request->has('upcoming') && $request->upcoming == 1) {
            $today = Carbon::today();
            $next7 = Carbon::today()->addDays(7);

            $query->whereDate('reminder_date', '>=', $today)
                  ->whereDate('reminder_date', '<=', $next7);
        } elseif ($request->has('month') && $request->month) {
            try {
                $month = Carbon::parse($request->month);
                $query->whereYear('reminder_date', $month->year)
                      ->whereMonth('reminder_date', $month->month);
            } catch (\Exception $e) {
                // Ignore invalid month
            }
        }

        $clients = $query->orderBy('reminder_date')->get();

        return view('marketing.clients.reminders', compact('clients'));
    }

    // ✅ NEW: Cancel client (hide with reason)
    public function cancel(Request $request, Client $client)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        $client->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason
        ]);

        return redirect()->back()->with('success', 'Client marked as cancelled and hidden from active list.');
    }

    public function report(Request $request)
    {
        $employeeId = session('employee_id');
        $month = $request->input('month') ?? now()->format('Y-m');
        $date = Carbon::parse($month);

        $clients = Client::where('marketing_manager_id', $employeeId)
                         ->whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->get();

        $projectTypeData = $clients->groupBy('project_type')->map->count();

        if ($request->has('download')) {
            $pdf = Pdf::loadView('marketing.clients.report_pdf', [
                'clients' => $clients,
                'month' => $date->format('F Y')
            ]);
            return $pdf->download('Monthly_Client_Report.pdf');
        }

        return view('marketing.clients.report', compact('clients', 'projectTypeData', 'month'));
    }
    public function confirm(Client $client)
{
    $client->update([
        'status' => 'active',
        'payment_status' => 'Advance' // or 'Full' based on your logic
    ]);

    return redirect()->back()->with('success', 'Client marked as confirmed and active.');
}


public function cancelled()
{
    $employeeId = session('employee_id');

    $clients = Client::where('marketing_manager_id', $employeeId)
                     ->where('status', 'cancelled')
                     ->orderBy('updated_at', 'desc')
                     ->get();

    return view('marketing.clients.cancelled', compact('clients'));
}

public function summary(Request $request)
{
    $employeeId = session('employee_id');
    $month = $request->input('month') ?? now()->format('Y-m');
    $date = \Carbon\Carbon::parse($month);

    $clients = Client::where('marketing_manager_id', $employeeId)
        ->whereYear('created_at', $date->year)
        ->whereMonth('created_at', $date->month)
        ->get();

    $active = $clients->where('status', 'active')->count();
    $inactive = $clients->where('status', 'inactive')->count();
    $cancelled = $clients->where('status', 'cancelled')->count();

    return view('marketing.clients.summary', compact('month', 'active', 'inactive', 'cancelled'));
}


public function downloadSummaryPdf()
{
    $employeeId = session('employee_id');

    $total = Client::where('marketing_manager_id', $employeeId)->count();
    $active = Client::where('marketing_manager_id', $employeeId)->where('status', 'active')->count();
    $inactive = Client::where('marketing_manager_id', $employeeId)->where('status', 'inactive')->count();
    $cancelled = Client::where('marketing_manager_id', $employeeId)->where('status', 'cancelled')->count();

    $pdf = \PDF::loadView('marketing.clients.summary_pdf', compact('total', 'active', 'inactive', 'cancelled'));

    return $pdf->download('Client_Summary_Report.pdf');
}

public function exportPdf(Request $request)
{
    $employeeId = session('employee_id');
    $month = $request->input('month');
    
    $clientsQuery = Client::where('marketing_manager_id', $employeeId);

    if ($month) {
        $date = \Carbon\Carbon::parse($month);
        $clientsQuery->whereYear('created_at', $date->year)
                     ->whereMonth('created_at', $date->month);
    }

    $clients = $clientsQuery->orderBy('created_at', 'desc')->get();

    $pdf = Pdf::loadView('marketing.clients.index_pdf', compact('clients', 'month'));

    return $pdf->download('Client_List_' . ($month ?? now()->format('Y_m')) . '.pdf');
}


}


