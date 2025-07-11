<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    // Show all expenses with optional month filter
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->has('month') && $request->month) {
            $month = Carbon::parse($request->month);
            $query->whereYear('expense_date', $month->year)
                  ->whereMonth('expense_date', $month->month);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $total = $expenses->sum('amount');

        return view('superadmin.expenses.index', compact('expenses', 'total'));
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
}
