<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Profile;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::with('profile');

        // Filter by month if provided
        if ($request->has('month') && $request->month) {
            $month = Carbon::parse($request->month); // from input type="month"
            $query->whereYear('salary_month', $month->year)
                  ->whereMonth('salary_month', $month->month);
        }

        $salaries = $query->orderBy('salary_month', 'desc')->get();
        $total = $salaries->sum('amount');

        return view('superadmin.salaries.index', compact('salaries', 'total'));
    }

    public function create()
    {
        $profiles = Profile::all();
        return view('superadmin.salaries.create', compact('profiles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'amount' => 'required|numeric|min:0',
            'salary_month' => 'required|date', // full date like 2025-07-14
        ]);

        Salary::create([
            'profile_id' => $validated['profile_id'],
            'amount' => $validated['amount'],
            'salary_month' => $validated['salary_month'], // Save full date
            'status' => 'Paid',
        ]);

        return redirect()->route('superadmin.salary.index')->with('success', 'Salary added successfully.');
    }
}
