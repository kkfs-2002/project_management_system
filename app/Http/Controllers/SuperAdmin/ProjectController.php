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






}
