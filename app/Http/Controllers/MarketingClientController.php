<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Salary; // Fix: Capital 'S' for Salary model
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

        // Client statistics
        $totalClients = Client::count();
        $activeClients = Client::where('status', 'active')->count();
        $inactiveClients = Client::where('status', 'inactive')->count();
        $upcomingReminders = Client::whereNotNull('reminder_date')
            ->whereDate('reminder_date', '>=', now())
            ->count();

        // Get today's attendance
        $todayAttendance = Attendance::where('profile_id', $marketing->id)
            ->whereDate('date', Carbon::today())
            ->first();

        // SALARY SECTION - FIXED
        $salaryDetails = Salary::where('profile_id', $marketing->id)
            ->orderBy('salary_month', 'desc')
            ->take(6)
            ->get();

        // Convert salary summary values to floats
        $salarySummary = [
            'current_month' => (float) Salary::where('profile_id', $marketing->id)
                ->whereYear('salary_month', Carbon::now()->year)
                ->whereMonth('salary_month', Carbon::now()->month)
                ->sum('amount'),
            'last_month' => (float) Salary::where('profile_id', $marketing->id)
                ->whereYear('salary_month', Carbon::now()->subMonth()->year)
                ->whereMonth('salary_month', Carbon::now()->subMonth()->month)
                ->sum('amount'),
            'year_total' => (float) Salary::where('profile_id', $marketing->id)
                ->whereYear('salary_month', Carbon::now()->year)
                ->where('status', 'paid')
                ->sum('amount'),
            'pending' => (float) Salary::where('profile_id', $marketing->id)
                ->where('status', 'pending')
                ->sum('amount')
        ];

        // Get current month salary record
        $currentMonthSalary = Salary::where('profile_id', $marketing->id)
            ->whereYear('salary_month', Carbon::now()->year)
            ->whereMonth('salary_month', Carbon::now()->month)
            ->first();

        // Get last paid salary record
        $lastPaidSalary = Salary::where('profile_id', $marketing->id)
            ->where('status', 'paid')
            ->latest('updated_at')
            ->first();

        return view('marketing.dashboard', compact(
            'marketing',
            'totalClients',
            'activeClients',
            'inactiveClients',
            'upcomingReminders',
            'todayAttendance',
            'salaryDetails',
            'salarySummary',
            'currentMonthSalary',
            'lastPaidSalary'
        ));
    }

    // SALARY HISTORY METHOD - FIXED
    public function salaryHistory(Request $request)
    {
        // Get authenticated marketing manager
        $marketing = Auth::user();
        
        if (!$marketing) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get salary history with pagination
        $salaries = Salary::where('profile_id', $marketing->id)
            ->orderBy('salary_month', 'desc')
            ->paginate(12);

        // Convert summary values to floats
        $totalPaid = (float) Salary::where('profile_id', $marketing->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalPending = (float) Salary::where('profile_id', $marketing->id)
            ->where('status', 'pending')
            ->sum('amount');

        $currentYearEarnings = (float) Salary::where('profile_id', $marketing->id)
            ->whereYear('salary_month', Carbon::now()->year)
            ->where('status', 'paid')
            ->sum('amount');

        $monthlyBreakdown = Salary::where('profile_id', $marketing->id)
            ->whereYear('salary_month', Carbon::now()->year)
            ->selectRaw('MONTH(salary_month) as month, 
                        MONTHNAME(salary_month) as month_name,
                        SUM(amount) as total,
                        status')
            ->groupBy('month', 'month_name', 'status')
            ->orderBy('month')
            ->get();

        return view('marketing.salary-history', compact(
            'marketing',
            'salaries',
            'totalPaid',
            'totalPending',
            'currentYearEarnings',
            'monthlyBreakdown'
        ));
    }

    // VIEW SALARY SLIP - FIXED
    public function viewSalarySlip($id)
    {
        // Get authenticated marketing manager
        $marketing = Auth::user();
        
        if (!$marketing) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get the specific salary record
        $salary = Salary::where('id', $id)
            ->where('profile_id', $marketing->id)
            ->firstOrFail();

        // Convert amounts to floats
        $basicSalary = (float) $salary->amount;
        $housingAllowance = $basicSalary * 0.15; // 15% housing allowance
        $transportAllowance = $basicSalary * 0.10; // 10% transport allowance
        $otherAllowances = $basicSalary * 0.05; // 5% other allowances
        $totalAllowances = $housingAllowance + $transportAllowance + $otherAllowances;
        
        $epfDeduction = $basicSalary * 0.08; // 8% EPF
        $taxDeduction = $basicSalary * 0.05; // 5% tax
        $otherDeductions = $basicSalary * 0.02; // 2% other deductions
        $totalDeductions = $epfDeduction + $taxDeduction + $otherDeductions;
        
        $grossSalary = $basicSalary + $totalAllowances;
        $netSalary = $grossSalary - $totalDeductions;

        return view('marketing.salary-slip', compact(
            'marketing',
            'salary',
            'basicSalary',
            'housingAllowance',
            'transportAllowance',
            'otherAllowances',
            'totalAllowances',
            'epfDeduction',
            'taxDeduction',
            'otherDeductions',
            'totalDeductions',
            'grossSalary',
            'netSalary'
        ));
    }

    // DOWNLOAD SALARY REPORT - FIXED
    public function downloadSalaryReport(Request $request)
    {
        // Get authenticated marketing manager
        $marketing = Auth::user();
        
        if (!$marketing) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $year = $request->input('year', Carbon::now()->year);

        // Get salary data for the specified year
        $salaries = Salary::where('profile_id', $marketing->id)
            ->whereYear('salary_month', $year)
            ->orderBy('salary_month', 'desc')
            ->get();

        $totalEarnings = (float) $salaries->where('status', 'paid')->sum('amount');
        $pendingAmount = (float) $salaries->where('status', 'pending')->sum('amount');

        $monthlySummary = $salaries->groupBy(function($salary) {
            return Carbon::parse($salary->salary_month)->format('F Y');
        })->map(function($monthSalaries) {
            return [
                'paid' => (float) $monthSalaries->where('status', 'paid')->sum('amount'),
                'pending' => (float) $monthSalaries->where('status', 'pending')->sum('amount'),
                'count' => $monthSalaries->count()
            ];
        });

        $pdf = Pdf::loadView('marketing.salary-report', [
            'marketing' => $marketing,
            'salaries' => $salaries,
            'totalEarnings' => $totalEarnings,
            'pendingAmount' => $pendingAmount,
            'monthlySummary' => $monthlySummary,
            'year' => $year
        ]);

        return $pdf->download('salary-report-' . $marketing->id . '-' . $year . '.pdf');
    }

    // EXISTING CLIENT METHODS (UNCHANGED)
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
            'payment_status' => 'Advance'
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
        $date = Carbon::parse($month);

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

        $pdf = Pdf::loadView('marketing.clients.summary_pdf', compact('total', 'active', 'inactive', 'cancelled'));

        return $pdf->download('Client_Summary_Report.pdf');
    }

    public function exportPdf(Request $request)
    {
        $employeeId = session('employee_id');
        $month = $request->input('month');
        
        $clientsQuery = Client::where('marketing_manager_id', $employeeId);

        if ($month) {
            $date = Carbon::parse($month);
            $clientsQuery->whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month);
        }

        $clients = $clientsQuery->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('marketing.clients.index_pdf', compact('clients', 'month'));

        return $pdf->download('Client_List_' . ($month ?? now()->format('Y_m')) . '.pdf');
    }
}