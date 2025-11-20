<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DailyTaskController extends Controller
{
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

 // DailyTaskController.php - create method එක

public function create()
{
    // All roles බලන්න තියෙන්නේ කොහොමද කියලා
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
   public function store(Request $request)
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

    // Handle authentication
    if (Auth::check()) {
        $validated['assigned_by'] = Auth::id();
    } else {
        $validated['assigned_by'] = $validated['profile_id'];
    }

    $validated['completed_count'] = 0;
    $validated['status'] = 'pending';

    // Remove working_days temporarily if column doesn't exist
    if (!Schema::hasColumn('daily_tasks', 'working_days')) {
        unset($validated['working_days']);
    }

    DailyTask::create($validated);

    $action = $request->get('action');
    if ($action === 'save_and_new') {
        return redirect()->route('superadmin.daily-tasks.create')->with('success', 'Daily task assigned successfully!');
    }

    return redirect()->route('superadmin.daily-tasks.index')->with('success', 'Daily task assigned successfully!');
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

    // Employee's view of their tasks
    public function employeeTasks(Request $request)
    {
        $employeeId = session('employee_id'); // From your login system
        $date = $request->get('date', date('Y-m-d'));

        $tasks = DailyTask::where('profile_id', $employeeId)
                         ->whereDate('task_date', $date)
                         ->orderBy('priority', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('employee.tasks.index', compact('tasks', 'date'));
    }
    
    public function show($id)
    {
        $task = DailyTask::with(['profile', 'assignedBy'])->findOrFail($id);
        return view('superadmin.daily.show', compact('task'));
    }
    
}