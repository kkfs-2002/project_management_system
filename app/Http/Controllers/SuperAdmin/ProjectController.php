<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ProjectAccount;
use Illuminate\Support\Facades\DB;


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
        'start_date' => 'required|date'
    ]);

    Project::create($request->only('name', 'type', 'start_date'));

    return redirect()->route('superadmin.project.index')->with('success', 'Project added.');
}

//View financial views
    public function createFinancials(Project $project)
{
    return view('superadmin.project.financials.create', compact('project'));
}

//Store in database
    public function storeFinancials(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'total_payment' => 'required|numeric|min:0',
        'advance' => 'required|numeric|min:0',
        'hosting_fee' => 'required|numeric|min:0',
        'developer_fee' => 'required|numeric|min:0',
    ]);

    $credit = $request->total_payment - $request->advance;
    $profit = $request->total_payment - ($request->hosting_fee + $request->developer_fee);

    ProjectAccount::updateOrCreate(
        ['project_id' => $request->project_id],
        [
            'total_payment' => $request->total_payment,
            'advance' => $request->advance,
            'credit' => $credit,
            'hosting_fee' => $request->hosting_fee,
            'developer_fee' => $request->developer_fee,
            'profit' => $profit,
        ]
    );

    return redirect()->route('superadmin.project.index')->with('success', 'Financials added successfully.');
}


//View all the transactions
    public function transactions(Request $request)
{
    $month = $request->input('month', now()->format('Y-m'));

    $accounts = ProjectAccount::with('project')
        ->whereHas('project', function ($q) use ($month) {
            $q->whereMonth('start_date', \Carbon\Carbon::parse($month)->month)
              ->whereYear('start_date', \Carbon\Carbon::parse($month)->year);
        })->get();

    return view('superadmin.project.financials.transactions', compact('accounts', 'month'));
}

}
