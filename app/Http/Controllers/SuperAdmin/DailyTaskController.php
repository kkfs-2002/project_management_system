<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\Profile;
use App\Models\Attendance;  // ← ADD THIS
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DailyTaskController extends Controller
{
    // ==================== SUPER ADMIN METHODS ====================
    
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $employeeId = $request->get('employee_id');
        $status = $request->get('status');

        $query = DailyTask::with(['profile', 'assignedBy']);

        if ($date) {
            $query->whereDate('task_date', $date);
        }

        if ($employeeId) {
            $query->where('profile_id', $employeeId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('task_date', 'desc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        $employees = Profile::whereIn('role', ['Senior Developer', 'Junior Developer', 'Intern/Trainee', 'Marketing Manager', 'Project Manager'])->get();

        return view('superadmin.daily.index', compact('tasks', 'employees', 'date', 'employeeId', 'status'));
    }

    public function create()
    {
        $allRoles = Profile::select('role')->distinct()->get();
        logger('All roles in database: ' . $allRoles->pluck('role'));
        
        $employees = Profile::whereIn('role', [
            'Super Admin',
            'Admin', 
            'Developer',
            'Senior Developer', 
            'Junior Developer', 
            'Intern/Trainee', 
            'Marketing Manager', 
            'Project Manager'
        ])->get();
        
        return view('superadmin.daily.create', compact('employees'));
    }

   
    public function updateProgress(Request $request, DailyTask $task)
    {
        $validated = $request->validate([
            'completed_count' => 'required|integer|min:0|max:'.$task->target_count,
            'actual_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        $validated['status'] = $validated['completed_count'] >= $task->target_count ? 'completed' : 'in_progress';
        
        if ($validated['completed_count'] >= $task->target_count) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return back()->with('success', 'Task progress updated!');
    }

    public function verifyTask(DailyTask $task)
    {
        $task->update(['status' => 'verified']);

        return back()->with('success', 'Task verified successfully!');
    }

    public function destroy(DailyTask $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function show($id)
    {
        $task = DailyTask::with(['profile', 'assignedBy'])->findOrFail($id);
        return view('superadmin.daily.show', compact('task'));
    }

    // ==================== DEVELOPER METHODS ====================
    
    public function developerIndex(Request $request)
    {
        // ===== GET AUTHENTICATED USER AND ATTENDANCE =====
        $user = Auth::user();
        $profile = $user ? $user->profile : null;
        
        // Get today's attendance for the logged-in developer
        $todayAttendance = null;
        if ($profile) {
            $todayAttendance = Attendance::where('profile_id', $profile->id)
                ->whereDate('date', Carbon::today())
                ->first();
        }
        
        // ===== EXISTING FILTER LOGIC =====
        $date = $request->get('date', date('Y-m-d'));
        $employeeId = $request->get('employee_id');
        $taskType = $request->get('task_type');
        $priority = $request->get('priority');
        $status = $request->get('status');

        $query = DailyTask::with(['profile', 'assignedBy']);

        // Add this filter to show only developer-related tasks
        $query->whereIn('task_type', ['Senior Developer', 'Junior Developer', 'Intern/Trainee']);

        if ($date) {
            $query->whereDate('task_date', $date);
        }

        if ($employeeId) {
            $query->where('profile_id', $employeeId);
        }

        if ($taskType) {
            $query->where('task_type', $taskType);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('task_date', 'desc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        $employees = Profile::whereIn('job_title', ['Senior Developer', 'Junior Developer', 'Intern/Trainee'])
                           ->orderBy('full_name')
                           ->get();

        return view('developer.daily-tasks.index', compact(
            'tasks', 
            'employees', 
            'date', 
            'employeeId', 
            'taskType', 
            'priority', 
            'status',
            'todayAttendance',
            'user'
        ));
    }
    
 public function developerCreate() 
{
    $allRoles = Profile::select('role')->distinct()->get();
    logger('All roles in database: ' . $allRoles->pluck('role'));
    
    $employees = Profile::whereIn('role', [
        'Super Admin',
        'Admin', 
        'Developer',
        'Senior Developer', 
        'Junior Developer', 
        'Intern/Trainee', 
        'Marketing Manager', 
        'Project Manager'
    ])->get();
    
    // ❌ WRONG: return view('daily-tasks.create', compact('employees'));
    // ✅ CORRECT: 
    return view('developer.daily-tasks.create', compact('employees'));
}

    public function developerstore(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'task_date' => 'required|date',
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type' => 'required|in:Senior Developer,Junior Developer,Intern/Trainee,Marketing Manager,Project Manager',
            'target_count' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
            'working_days' => 'nullable|string'
        ]);

        // Calculate estimated time from start and end times
        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('H:i', $validated['end_time']);
        $estimatedMinutes = $start->diffInMinutes($end);
        
        // Convert minutes to hours:minutes format
        $hours = floor($estimatedMinutes / 60);
        $minutes = $estimatedMinutes % 60;
        $validated['estimated_time'] = sprintf('%02d:%02d', $hours, $minutes);

        if (Auth::check()) {
            $validated['assigned_by'] = Auth::id();
        } else {
            $validated['assigned_by'] = $validated['profile_id'];
        }

        $validated['completed_count'] = 0;
        $validated['status'] = 'pending';

        if (!Schema::hasColumn('daily_tasks', 'working_days')) {
            unset($validated['working_days']);
        }

        DailyTask::create($validated);

        $action = $request->get('action');
        if ($action === 'save_and_new') {
            return redirect()->route('developer.daily-tasks.create')->with('success', 'Daily task assigned successfully!');
        }

        return redirect()->route('developer.daily-tasks.index')->with('success', 'Daily task assigned successfully!');
    }

    public function developerupdateProgress(Request $request, DailyTask $task)
    {
        $validated = $request->validate([
            'completed_count' => 'required|integer|min:0|max:'.$task->target_count,
            'actual_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        $validated['status'] = $validated['completed_count'] >= $task->target_count ? 'completed' : 'in_progress';
        
        if ($validated['completed_count'] >= $task->target_count) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return back()->with('success', 'Task progress updated!');
    }

    public function developerverifyTask(DailyTask $task)
    {
        $task->update(['status' => 'verified']);

        return back()->with('success', 'Task verified successfully!');
    }

    public function developerdestroy(DailyTask $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function developershow($id)
    {
        $task = DailyTask::with(['profile', 'assignedBy'])->findOrFail($id);
        return view('developer.daily_tasks.show', compact('task'));
    }

    // ==================== PROJECT MANAGER METHODS ====================
    
    public function projectManagerindex(Request $request)
    {
        // ===== GET AUTHENTICATED USER AND ATTENDANCE =====
        $user = Auth::user();
        $profile = $user ? $user->profile : null;
        
        // Get today's attendance for the logged-in project manager
        $todayAttendance = null;
        if ($profile) {
            $todayAttendance = Attendance::where('profile_id', $profile->id)
                ->whereDate('date', Carbon::today())
                ->first();
        }
        
        // ===== EXISTING FILTER LOGIC =====
        $date = $request->get('date', date('Y-m-d'));
        $employeeId = $request->get('employee_id');
        $status = $request->get('status');
        $taskType = $request->get('task_type');
        $priority = $request->get('priority');

        $query = DailyTask::with(['profile', 'assignedBy']);

        $query->whereIn('task_type', ['Project Manager', 'Senior Developer', 'Junior Developer', 'Intern/Trainee']);

        if ($date) {
            $query->whereDate('task_date', $date);
        }

        if ($employeeId) {
            $query->where('profile_id', $employeeId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($taskType) {
            $query->where('task_type', $taskType);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        $tasks = $query->orderBy('task_date', 'desc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        $employees = Profile::whereIn('role', [
                        'Project Manager', 
                        'Senior Developer', 
                        'Junior Developer', 
                        'Intern/Trainee',
                        'Developer',
                        'Admin',
                        'Super Admin'
                    ])
                    ->orWhereIn('job_title', [
                        'Project Manager',
                        'Senior Developer', 
                        'Junior Developer', 
                        'Intern/Trainee'
                    ])
                    ->orderBy('full_name')
                    ->get();

        logger('Employees for Dropdown: ' . $employees->count());
        foreach($employees as $emp) {
            logger('Employee: ' . $emp->id . ' | Name: ' . $emp->full_name . ' | Role: ' . $emp->role . ' | Job Title: ' . $emp->job_title);
        }

        return view('projectmanager.daily-tasks.index', compact(
            'tasks', 
            'employees', 
            'date', 
            'employeeId', 
            'status',
            'taskType',
            'priority',
            'todayAttendance',
            'user'
        ));
    }
    
    public function projectManagercreate()
    {
        $allRoles = Profile::select('role')->distinct()->get();
        logger('All roles in database: ' . $allRoles->pluck('role'));
        
        $employees = Profile::whereIn('role', [
            'Super Admin',
            'Admin', 
            'Developer',
            'Senior Developer', 
            'Junior Developer', 
            'Intern/Trainee', 
            'Marketing Manager', 
            'Project Manager'
        ])->get();
        
        return view('projectmanager.daily-tasks.create', compact('employees'));
    }

    public function projectManagerstore(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'task_date' => 'required|date',
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type' => 'required|in:Senior Developer,Junior Developer,Intern/Trainee,Marketing Manager,Project Manager',
            'target_count' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
            'working_days' => 'nullable|string'
        ]);

        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('H:i', $validated['end_time']);
        $estimatedMinutes = $start->diffInMinutes($end);
        
        $hours = floor($estimatedMinutes / 60);
        $minutes = $estimatedMinutes % 60;
        $validated['estimated_time'] = sprintf('%02d:%02d', $hours, $minutes);

        if (Auth::check()) {
            $validated['assigned_by'] = Auth::id();
        } else {
            $validated['assigned_by'] = $validated['profile_id'];
        }

        $validated['completed_count'] = 0;
        $validated['status'] = 'pending';

        if (!Schema::hasColumn('daily_tasks', 'working_days')) {
            unset($validated['working_days']);
        }

        DailyTask::create($validated);

        $action = $request->get('action');
        if ($action === 'save_and_new') {
            return redirect()->route('projectmanager.daily-tasks.create')->with('success', 'Daily task assigned successfully!');
        }

        return redirect()->route('projectmanager.daily-tasks.index')->with('success', 'Daily task assigned successfully!');
    }

    public function projectManagerupdateProgress(Request $request, DailyTask $task)
    {
        $validated = $request->validate([
            'completed_count' => 'required|integer|min:0|max:'.$task->target_count,
            'actual_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        $validated['status'] = $validated['completed_count'] >= $task->target_count ? 'completed' : 'in_progress';
        
        if ($validated['completed_count'] >= $task->target_count) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return back()->with('success', 'Task progress updated!');
    }

    public function projectManagerverifyTask(DailyTask $task)
    {
        $task->update(['status' => 'verified']);

        return back()->with('success', 'Task verified successfully!');
    }

    public function projectManagerdestroy(DailyTask $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function projectManagershow($id)
    {
        $task = DailyTask::with(['profile', 'assignedBy'])->findOrFail($id);
        return view('projectmanager.daily-tasks.show', compact('task'));
    }

    // ==================== MARKETING METHODS ====================
    
    public function marketingIndex(Request $request)
    {
        // ===== GET AUTHENTICATED USER AND ATTENDANCE =====
        $user = Auth::user();
        $profile = $user ? $user->profile : null;
        
        // Get today's attendance for the logged-in marketing user
        $todayAttendance = null;
        if ($profile) {
            $todayAttendance = Attendance::where('profile_id', $profile->id)
                ->whereDate('date', Carbon::today())
                ->first();
        }
        
        // ===== EXISTING FILTER LOGIC =====
        $date = $request->get('date', date('Y-m-d'));
        $employeeId = $request->get('employee_id');
        $taskType = $request->get('task_type');
        $priority = $request->get('priority');
        $status = $request->get('status');

        $query = DailyTask::with(['profile', 'assignedBy']);

        $currentUserId = auth()->id();
        $currentProfile = Profile::where('id', $currentUserId)->first();
        
        if ($currentProfile) {
            $query->where('profile_id', $currentProfile->id);
            $query->where('task_type', 'Marketing Manager');
        } else {
            $query->where('task_type', 'Marketing Manager');
        }

        if ($date) {
            $query->whereDate('task_date', $date);
        }

        if ($taskType) {
            $query->where('task_type', $taskType);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('task_date', 'desc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        $employees = Profile::where('role', 'Marketing Manager')->get();

        return view('marketing.daily-tasks.index', compact(
            'tasks', 
            'employees', 
            'date', 
            'employeeId', 
            'taskType', 
            'priority', 
            'status',
            'todayAttendance',
            'user'
        ));
    }

    public function marketingcreate()
    {
        $allRoles = Profile::select('role')->distinct()->get();
        logger('All roles in database: ' . $allRoles->pluck('role'));
        
        $employees = Profile::whereIn('role', [
            'Super Admin',
            'Admin', 
            'Developer',
            'Senior Developer', 
            'Junior Developer', 
            'Intern/Trainee', 
            'Marketing Manager', 
            'Project Manager'
        ])->get();
        
        return view('marketing.daily-tasks.create', compact('employees'));
    }

    public function MarketingStore(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'task_date' => 'required|date',
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type' => 'required|in:Senior Developer,Junior Developer,Intern/Trainee,Marketing Manager,Project Manager',
            'target_count' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
            'working_days' => 'nullable|string'
        ]);

        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('H:i', $validated['end_time']);
        $estimatedMinutes = $start->diffInMinutes($end);
        
        $hours = floor($estimatedMinutes / 60);
        $minutes = $estimatedMinutes % 60;
        $validated['estimated_time'] = sprintf('%02d:%02d', $hours, $minutes);

        if (Auth::check()) {
            $validated['assigned_by'] = Auth::id();
        } else {
            $validated['assigned_by'] = $validated['profile_id'];
        }

        $validated['completed_count'] = 0;
        $validated['status'] = 'pending';

        if (!Schema::hasColumn('daily_tasks', 'working_days')) {
            unset($validated['working_days']);
        }

        DailyTask::create($validated);

        $action = $request->get('action');
        if ($action === 'save_and_new') {
            return redirect()->route('marketing.daily-tasks.create')->with('success', 'Daily task assigned successfully!');
        }

        return redirect()->route('marketing.daily-tasks.index')->with('success', 'Daily task assigned successfully!');
    }

    public function marketingupdateProgress(Request $request, DailyTask $task)
    {
        $validated = $request->validate([
            'completed_count' => 'required|integer|min:0|max:'.$task->target_count,
            'actual_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string'
        ]);

        $validated['status'] = $validated['completed_count'] >= $task->target_count ? 'completed' : 'in_progress';
        
        if ($validated['completed_count'] >= $task->target_count) {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return back()->with('success', 'Task progress updated!');
    }

    public function marketingverifyTask(DailyTask $task)
    {
        $task->update(['status' => 'verified']);

        return back()->with('success', 'Task verified successfully!');
    }

    public function marketingdestroy(DailyTask $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function marketingshow($id)
    {
        $task = DailyTask::with(['profile', 'assignedBy'])->findOrFail($id);
        return view('marketing.daily-tasks.show', compact('task'));
    }

    // ==================== COMMON EMPLOYEE METHOD ====================
    
    public function employeeTasks(Request $request)
    {
        $employeeId = Auth::id();
        $date = $request->get('date', date('Y-m-d'));

        $tasks = DailyTask::where('profile_id', $employeeId)
                         ->whereDate('task_date', $date)
                         ->orderBy('priority', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('employee.tasks.index', compact('tasks', 'date'));
    }
}