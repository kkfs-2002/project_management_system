<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ProjectAccount;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Collection;



class ProjectController extends Controller
{
    //Show the project name and type
    public function index(Request $request)
{
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    $projects = Project::when($month, function ($query, $month) {
        $query->whereMonth('start_date', Carbon::parse($month)->month)
              ->whereYear('start_date', Carbon::parse($month)->year);
    })->get();

    return view('superadmin.project.index', compact('projects', 'month'));
}

//View create.blade.php
public function create()
{
    return view('superadmin.project.create');
}

//Store added details in database
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string',
        'start_date' => 'required|date',
        'deadline' => 'required|date|after_or_equal:start_date',
    ]);

    Project::create($request->only('name', 'type', 'start_date','deadline'));

    return redirect()->route('superadmin.project.index')->with('success', 'Project added.');
}

//View financial views
    public function createFinancials(Project $project)
{
    return view('superadmin.project.financials.create', compact('project'));
}

//Store in database
//Store in database
public function storeFinancials(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'total_payment' => 'required|numeric|min:0',
        'advance' => 'required|numeric|min:0',
        'hosting_fee' => 'required|numeric|min:0',
        'developer_fee' => 'required|numeric|min:0',
        'renewal_date' => 'required|date',
    ]);

    // Auto calculate profit and balance
    $profit = $request->total_payment - ($request->hosting_fee + $request->developer_fee);
    $balance = $request->total_payment - $request->advance;

    ProjectAccount::updateOrCreate(
        ['project_id' => $request->project_id],
        [
            'total_payment' => $request->total_payment,
            'advance' => $request->advance,
            'hosting_fee' => $request->hosting_fee,
            'developer_fee' => $request->developer_fee,
            'profit' => $profit,
            'balance' => $balance,
            'renewal_date' => $request->renewal_date,
        ]
    );

    return redirect()->route('superadmin.project.index')->with('success', 'Financials added successfully.');
}
//View all transactions
public function transactions(Request $request)
{
    $month = $request->input('month', now()->format('Y-m'));

    
    $allAccounts = ProjectAccount::with('project')->get();

    // Group transactions by month (YYYY-MM format)
    $groupedAccounts = $allAccounts->groupBy(function ($acc) {
        return Carbon::parse($acc->project->start_date)->format('Y-m');
    });

    //Generate all 12 months for current year
    $allMonths = collect();
    $start = Carbon::createFromDate(now()->year, 1, 1); // Jan of current year
    $end = Carbon::createFromDate(now()->year, 12, 1); // Dec of current year

    while ($start <= $end) {
        $allMonths->push([
            'value' => $start->format('Y-m'),
            'label' => $start->format('F Y'),
        ]);
        $start->addMonth();
    }

    return view('superadmin.project.transactions', [
        'month' => $month,
        'accounts' => $groupedAccounts[$month] ?? collect(),
        'groupedAccounts' => $groupedAccounts,
        'allMonths' => $allMonths,
]);
}

// Show edit form
public function editFinancials(ProjectAccount $account)
{
    return view('superadmin.project.financials.edit', compact('account'));
}

// Update financial record
// Update financial record
public function updateFinancials(Request $request, ProjectAccount $account)
{
    $request->validate([
        'total_payment' => 'required|numeric|min:0',
        'advance' => 'required|numeric|min:0',
        'hosting_fee' => 'required|numeric|min:0',
        'developer_fee' => 'required|numeric|min:0',
        'renewal_date' => 'required|date',
    ]);

    // Auto calculate profit and balance
    $profit = $request->total_payment - ($request->hosting_fee + $request->developer_fee);
    $balance = $request->total_payment - $request->advance;

    $account->update([
        'total_payment' => $request->total_payment,
        'advance' => $request->advance,
        'hosting_fee' => $request->hosting_fee,
        'developer_fee' => $request->developer_fee,
        'profit' => $profit,
        'balance' => $balance,
        'renewal_date' => $request->renewal_date,
    ]);

    return redirect()->route('superadmin.project.transactions')->with('success', 'Financials updated.');
}
// Delete financial record
public function destroyFinancials(ProjectAccount $account)
{
    $account->delete();

    return redirect()->route('superadmin.project.transactions')->with('success', 'Financial record deleted.');
}

   // Download PDF for filtered month
    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::parse($month);

        $accounts = ProjectAccount::with('project')
            ->whereHas('project', function ($query) use ($selectedMonth) {
                $query->whereYear('start_date', $selectedMonth->year)
                      ->whereMonth('start_date', $selectedMonth->month);
            })->get();

        $pdf = PDF::loadView('superadmin.project.financials.transactions-pdf', [
    'accounts' => $accounts,
    'monthLabel' => $selectedMonth->format('F Y'),
    'generatedDate' => now()->format('F j, Y')
     ]);

        return $pdf->download("project-transactions-{$selectedMonth->format('Y-m')}.pdf");
}


 // ==================== MONTHLY PROFIT PAGE ====================
    public function monthlyProfit(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $year = Carbon::parse($month)->year;
        $monthNum = Carbon::parse($month)->month;
        
        // Get monthly data with single optimized query
        $monthlyData = ProjectAccount::with('project')
            ->whereHas('project', function ($query) use ($year, $monthNum) {
                $query->whereYear('start_date', $year)
                      ->whereMonth('start_date', $monthNum);
            })
            ->get();

        // Calculate summary
        $monthlySummary = [
            'total_projects' => $monthlyData->count(),
            'total_payment' => $monthlyData->sum('total_payment'),
            'total_advance' => $monthlyData->sum('advance'),
            'total_hosting' => $monthlyData->sum('hosting_fee'),
            'total_developer' => $monthlyData->sum('developer_fee'),
            'total_profit' => $monthlyData->sum('profit'),
            'total_balance' => $monthlyData->sum('balance'),
        ];

        // Get months for dropdown (last 12 months)
        $months = collect();
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ]);
        }

        return view('superadmin.project.monthly-profit', compact(
            'month',
            'monthlyData',
            'monthlySummary',
            'months'
        ));
    }

    // ==================== YEARLY PROFIT PAGE ====================
public function yearlyProfit(Request $request)
{
    $year = $request->input('year', Carbon::now()->year);
    
    // Get yearly data with optimized query
    $yearlyData = ProjectAccount::with('project')
        ->whereHas('project', function ($query) use ($year) {
            $query->whereYear('start_date', $year);
        })
        ->get();

    // Debug: Check data
    \Log::info('Yearly Data Count: ' . $yearlyData->count());
    
    // Calculate yearly summary
    $yearlySummary = [
        'total_projects' => $yearlyData->count(),
        'total_payment' => $yearlyData->sum('total_payment'),
        'total_advance' => $yearlyData->sum('advance'),
        'total_hosting' => $yearlyData->sum('hosting_fee'),
        'total_developer' => $yearlyData->sum('developer_fee'),
        'total_profit' => $yearlyData->sum('profit'),
        'total_balance' => $yearlyData->sum('balance'),
    ];

    // Monthly breakdown for the year
    $monthlyBreakdown = [];
    $monthNames = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    for ($month = 1; $month <= 12; $month++) {
        $monthData = $yearlyData->filter(function ($account) use ($year, $month) {
            return Carbon::parse($account->project->start_date)->month == $month;
        });

        $totalExpenses = $monthData->sum('hosting_fee') + $monthData->sum('developer_fee');
        
        $monthlyBreakdown[$month] = [
            'month_name' => $monthNames[$month],
            'projects_count' => $monthData->count(),
            'total_payment' => $monthData->sum('total_payment'),
            'total_profit' => $monthData->sum('profit'),
            'total_expenses' => $totalExpenses,
        ];
        
        // Debug each month
        \Log::info("Month $month: " . json_encode($monthlyBreakdown[$month]));
    }

    // Get available years for dropdown
    $availableYears = Project::select(DB::raw('YEAR(start_date) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    return view('superadmin.project.yearly-profit', compact(
        'year',
        'yearlyData',
        'yearlySummary',
        'monthlyBreakdown',
        'availableYears'
    ));
} // Download Monthly PDF
    public function downloadMonthlyPdf(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($month);
        
        $monthlyData = ProjectAccount::with('project')
            ->whereHas('project', function ($query) use ($date) {
                $query->whereYear('start_date', $date->year)
                      ->whereMonth('start_date', $date->month);
            })
            ->get();

        $pdf = PDF::loadView('superadmin.project.pdf.monthly-profit-pdf', [
            'monthlyData' => $monthlyData,
            'month' => $date->format('F Y'),
            'generatedDate' => Carbon::now()->format('F j, Y')
        ]);

        return $pdf->download("monthly-profit-{$date->format('Y-m')}.pdf");
    }

    // Download Yearly PDF
    public function downloadYearlyPdf(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        
        $yearlyData = ProjectAccount::with('project')
            ->whereHas('project', function ($query) use ($year) {
                $query->whereYear('start_date', $year);
            })
            ->get();

        $pdf = PDF::loadView('superadmin.project.pdf.yearly-profit-pdf', [
            'yearlyData' => $yearlyData,
            'year' => $year,
            'generatedDate' => Carbon::now()->format('F j, Y')
        ]);

        return $pdf->download("yearly-profit-{$year}.pdf");
    }



}
