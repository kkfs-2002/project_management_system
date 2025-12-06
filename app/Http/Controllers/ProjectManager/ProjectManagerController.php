<?php
namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTask;
use App\Models\Profile;
use App\Models\Attendance;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectManagerController extends Controller
{
    public function dashboard($pmId)
    {
        // Get the authenticated project manager
        $pm = Auth::user(); // or Profile::findOrFail($pmId);
        
        if (!$pm) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        // Get today's attendance for the logged-in user
        $todayAttendance = Attendance::where('profile_id', $pm->id)
            ->whereDate('date', Carbon::today())
            ->first();
        
        // Get recent tasks (last 6 tasks)
        $recentTasks = DailyTask::with('profile')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Get task statistics
        $totalTasks = DailyTask::count();
        $completedTasks = DailyTask::where('status', 'completed')->count();
        $inProgressTasks = DailyTask::where('status', 'in progress')->count();
        $pendingTasks = DailyTask::where('status', 'pending')->count();
        
        // Get tasks for the table (if needed)
        $tasks = DailyTask::with(['profile', 'assignedBy'])
            ->orderBy('task_date', 'desc')
            ->orderBy('priority', 'desc')
            ->paginate(20);
        
        // Get employees for filters
        $employees = Profile::where(function($query) {
            $query->whereIn('role', [
                'Senior Developer', 
                'Junior Developer', 
                'Developer',
                'Intern/Trainee', 
                'Marketing Manager', 
                'Project Manager',
                'Admin',
                'Super Admin'
            ])
            ->orWhereIn('job_title', [
                'Senior Developer', 
                'Junior Developer', 
                'Intern/Trainee', 
                'Marketing Manager', 
                'Project Manager'
            ]);
        })
        ->orderBy('full_name')
        ->get();
        
        // Filter parameters (if applicable)
        $date = request()->get('date', date('Y-m-d'));
        $employeeId = request()->get('employee_id');
        $status = request()->get('status');
        $taskType = request()->get('task_type');
        $priority = request()->get('priority');

        // SALARY SECTION - FIXED
        $salaryDetails = Salary::where('profile_id', $pm->id)
            ->orderBy('salary_month', 'desc')
            ->take(6)
            ->get();

        // FIX: Get current month salary amount (float) instead of model instance
        $currentMonthSalary = Salary::where('profile_id', $pm->id)
            ->whereYear('salary_month', Carbon::now()->year)
            ->whereMonth('salary_month', Carbon::now()->month)
            ->first();

        $currentSalaryAmount = $currentMonthSalary ? (float) $currentMonthSalary->amount : 0;

        // Get last payment
        $lastPaymentRecord = Salary::where('profile_id', $pm->id)
            ->where('status', 'paid')
            ->latest('updated_at')
            ->first();

        $lastPaymentAmount = $lastPaymentRecord ? (float) $lastPaymentRecord->amount : 0;
        $lastPaymentDate = $lastPaymentRecord ? $lastPaymentRecord->updated_at : null;

        // Get pending amount
        $pendingAmount = (float) Salary::where('profile_id', $pm->id)
            ->where('status', 'pending')
            ->sum('amount');

        // Salary chart data
        $salaryChartData = [
            'months' => $salaryDetails->pluck('salary_month')->map(function($date) {
                return Carbon::parse($date)->format('M Y');
            })->reverse(),
            'amounts' => $salaryDetails->pluck('amount')->reverse(),
            'status' => [
                $salaryDetails->where('status', 'paid')->count(),
                $salaryDetails->where('status', 'pending')->count()
            ]
        ];

        // Calculate total net salary
        $totalNetSalary = (float) $salaryDetails->sum('amount');

        return view('projectmanager.dashboard', compact(
            'pm',
            'todayAttendance',
            'recentTasks',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'pendingTasks',
            'tasks',
            'employees',
            'date',
            'employeeId',
            'status',
            'taskType',
            'priority',
            // Salary variables - FIXED
            'salaryDetails',
            'currentMonthSalary',  // Keep as object for details if needed
            'currentSalaryAmount', // Use this for displaying amount
            'lastPaymentRecord',   // Keep as object
            'lastPaymentAmount',   // Use this for displaying amount
            'lastPaymentDate',
            'pendingAmount',
            'salaryChartData',
            'totalNetSalary'
        ));
    }

    // ADD THESE NEW METHODS FOR SALARY
    public function salaryHistory(Request $request)
    {
        // Get authenticated project manager
        $pm = Auth::user();
        
        if (!$pm) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get salary history with pagination
        $salaries = Salary::where('profile_id', $pm->id)
            ->orderBy('salary_month', 'desc')
            ->paginate(12);

        // Summary statistics
        $totalPaid = (float) Salary::where('profile_id', $pm->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalPending = (float) Salary::where('profile_id', $pm->id)
            ->where('status', 'pending')
            ->sum('amount');

        $monthlySummary = Salary::where('profile_id', $pm->id)
            ->where('status', 'paid')
            ->selectRaw('YEAR(salary_month) as year, MONTH(salary_month) as month, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('projectmanager.salary-history', compact(
            'pm',
            'salaries',
            'totalPaid',
            'totalPending',
            'monthlySummary'
        ));
    }

    public function downloadPayslip($salaryId)
    {
        // Get authenticated project manager
        $pm = Auth::user();
        
        if (!$pm) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Get the specific salary record
        $salary = Salary::where('id', $salaryId)
            ->where('profile_id', $pm->id)
            ->firstOrFail();

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('projectmanager.salary-payslip', [
            'salary' => $salary,
            'pm' => $pm
        ]);

        return $pdf->download('salary-slip-' . $salary->id . '.pdf');
    }

    // New method for salary statistics
    public function salaryStatistics()
    {
        $pm = Auth::user();
        
        if (!$pm) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Yearly statistics
        $yearlyStats = Salary::where('profile_id', $pm->id)
            ->selectRaw('YEAR(salary_month) as year, 
                        COUNT(*) as count, 
                        SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as paid_total,
                        SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as pending_total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Monthly breakdown for current year
        $currentYear = Carbon::now()->year;
        $monthlyBreakdown = Salary::where('profile_id', $pm->id)
            ->whereYear('salary_month', $currentYear)
            ->selectRaw('MONTHNAME(salary_month) as month, 
                        MONTH(salary_month) as month_num,
                        SUM(amount) as total_amount,
                        status')
            ->groupBy('month', 'month_num', 'status')
            ->orderBy('month_num')
            ->get();

        return view('projectmanager.salary-statistics', compact(
            'pm',
            'yearlyStats',
            'monthlyBreakdown',
            'currentYear'
        ));
    }
}