<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AssignedTask;
use App\Models\Attendance;
use App\Models\Salary; // Add this line
use Carbon\Carbon;

class DeveloperController extends Controller
{
    public function dashboard()
    {
        // Get authenticated developer
        $dev = Auth::user(); // Assuming Auth::user() returns the Profile
        
        if (!$dev) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Task statistics
        $forwardedTasks = AssignedTask::where('status', 'Forwarded')->count();
        $completedTasks = AssignedTask::where('status', 'Completed')->count();

        // Get today's attendance for the authenticated developer
        $todayAttendance = Attendance::where('profile_id', $dev->id)
            ->whereDate('date', Carbon::today())
            ->first();

        // Salary details - ADD THIS SECTION
        $salaryDetails = Salary::where('profile_id', $dev->id)
            ->orderBy('salary_month', 'desc')
            ->take(6)
            ->get();

        $totalSalary = Salary::where('profile_id', $dev->id)
            ->where('status', 'paid')
            ->sum('amount');

        $currentMonthSalary = Salary::where('profile_id', $dev->id)
            ->whereYear('salary_month', Carbon::now()->year)
            ->whereMonth('salary_month', Carbon::now()->month)
            ->first();

        $pendingSalary = Salary::where('profile_id', $dev->id)
            ->where('status', 'pending')
            ->sum('amount');

        return view('developer.dashboard', compact(
            'dev',
            'forwardedTasks', 
            'completedTasks',
            'todayAttendance',
            'salaryDetails',      // ADD THIS
            'totalSalary',        // ADD THIS
            'currentMonthSalary', // ADD THIS
            'pendingSalary'       // ADD THIS
        ));
    }

    // ADD THESE NEW METHODS FOR SALARY
    public function salaryHistory(Request $request)
    {
        // Get authenticated developer
        $dev = Auth::user();
        
        if (!$dev) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get salary history with pagination
        $salaries = Salary::where('profile_id', $dev->id)
            ->orderBy('salary_month', 'desc')
            ->paginate(12);

        // Summary statistics
        $totalPaid = Salary::where('profile_id', $dev->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalPending = Salary::where('profile_id', $dev->id)
            ->where('status', 'pending')
            ->sum('amount');

        $yearlySummary = Salary::where('profile_id', $dev->id)
            ->where('status', 'paid')
            ->selectRaw('YEAR(salary_month) as year, SUM(amount) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return view('developer.salary-history', compact(
            'dev',
            'salaries',
            'totalPaid',
            'totalPending',
            'yearlySummary'
        ));
    }

    public function salarySlip($id)
    {
        // Get authenticated developer
        $dev = Auth::user();
        
        if (!$dev) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get the specific salary record
        $salary = Salary::where('id', $id)
            ->where('profile_id', $dev->id)
            ->firstOrFail();

        // Calculate allowances and deductions if needed
        $basicSalary = $salary->amount;
        $allowances = $basicSalary * 0.10; // 10% allowance example
        $deductions = $basicSalary * 0.05; // 5% deduction example
        $netSalary = $basicSalary + $allowances - $deductions;

        return view('developer.salary-slip', compact(
            'dev',
            'salary',
            'basicSalary',
            'allowances',
            'deductions',
            'netSalary'
        ));
    }
}