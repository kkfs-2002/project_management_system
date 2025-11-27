<?php
namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTask;
use App\Models\Profile;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectManagerController extends Controller
{
    public function dashboard($pmId)
    {
        // Get the authenticated project manager
        $pm = Auth::user(); // or Profile::findOrFail($pmId);
        
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
            'priority'
        ));
    }
}