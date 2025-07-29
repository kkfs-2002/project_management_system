<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    // Show all expenses with optional month filter
    public function index(Request $request)
{
    // Use current year or the one from selected month
    $selectedMonth = $request->input('month', now()->format('Y-m'));
    $year = \Carbon\Carbon::parse($selectedMonth)->format('Y');

    // Get all expenses for that year
    $expenses = Expense::whereYear('expense_date', $year)->get();

    // Group by month (01 to 12)
    $expensesByMonth = collect();
    for ($m = 1; $m <= 12; $m++) {
        $monthName = \Carbon\Carbon::createFromDate($year, $m, 1)->format('F Y');
        $monthExpenses = $expenses->filter(function ($expense) use ($m) {
            return \Carbon\Carbon::parse($expense->expense_date)->month == $m;
        });

        $expensesByMonth[$monthName] = $monthExpenses;
    }

    $total = $expenses->sum('amount');

    return view('superadmin.expenses.index', compact('expensesByMonth', 'total', 'selectedMonth'));
}



    // Show create form
    public function create()
    {
        return view('superadmin.expenses.create');
    }

    // Store a new expense
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create($validated);

        return redirect()->route('superadmin.expenses.index')->with('success', 'Expense added successfully.');
    }

 

public function downloadPdf(Request $request)
{
    $selectedMonth = $request->input('month', now()->format('Y-m'));
    $year = \Carbon\Carbon::parse($selectedMonth)->format('Y');

    $expenses = Expense::whereYear('expense_date', $year)->get();

    $expensesByMonth = collect();
    for ($m = 1; $m <= 12; $m++) {
        $monthName = \Carbon\Carbon::createFromDate($year, $m, 1)->format('F Y');
        $monthExpenses = $expenses->filter(function ($expense) use ($m) {
            return \Carbon\Carbon::parse($expense->expense_date)->month == $m;
        });
        $expensesByMonth[$monthName] = $monthExpenses;
    }

    $total = $expenses->sum('amount');

    $pdf = Pdf::loadView('superadmin.expenses.pdf', [
        'expensesByMonth' => $expensesByMonth,
        'total' => $total,
        'selectedMonth' => $selectedMonth,
    ]);

    return $pdf->download('monthly_expenses_' . $year . '.pdf');
}

}
