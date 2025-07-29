<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\AssignedTask;
use App\Models\Profile;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // SUPER ADMIN

    // Show the task creation form
    public function create()
    {
        $developers      = Profile::where('role', 'Developer')->get();
        $projectManagers = Profile::where('role', 'Project Manager')->get();
        $projects        = Project::all();

        return view('superadmin.tasks.create', compact('developers', 'projectManagers', 'projects'));
    }

    // Store new task
    public function store(Request $request)
    {
        $request->validate([
            'project_id'          => 'required|exists:projects,id',
            'developer_id'        => 'required|exists:profiles,id',
            'project_manager_id'  => 'required|exists:profiles,id',
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'start_date'          => 'required|date',
            'deadline'            => 'required|date|after_or_equal:start_date',
        ]);

        $dev = Profile::find($request->developer_id);
        $pm  = Profile::find($request->project_manager_id);

        AssignedTask::create([
            'project_id'           => $request->project_id,
            'developer_id'         => $dev->id,
            'project_manager_id'   => $pm->id,
            'developer_name'       => $dev->full_name,
            'project_manager_name' => $pm->full_name,
            'title'                => $request->title,
            'description'          => $request->description,
            'start_date'           => $request->start_date,
            'deadline'             => $request->deadline,
        ]);

        return back()->with('success', 'Task assigned successfully.');
    }

    // Task list visible to Super Admin
    public function superadminIndex(Request $request)
    {
        $query = AssignedTask::query();

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by month
        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('deadline', $year)
                ->whereMonth('deadline', $month);
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['Pending', 'Completed', 'Forwarded'])) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('id', 'asc')->get();

        // Pass projects to the view for the filter dropdown
        $projects = Project::all();

        return view('superadmin.tasks.index', compact('tasks', 'projects'));
    }

// Developer task list (only forwarded tasks)
public function developerIndex(Request $request)
{
    $query = AssignedTask::query();
    $query->whereIn('status', ['Forwarded', 'Completed']);

    if ($request->filled('project_id')) {
        $query->where('project_id', $request->project_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('month')) {
        [$year, $month] = explode('-', $request->month);
        $query->whereYear('deadline', $year)
              ->whereMonth('deadline', $month);
    }

    $tasks = $query->orderBy('id', 'asc')->get();
    $projects = Project::all();

    return view('developer.tasks.index', compact('tasks', 'projects'));
}


// Developer marks task as completed
public function markAsCompleted($id)
{
    $task = AssignedTask::findOrFail($id);

    if ($task->status === 'Forwarded') {
        $task->status = 'Completed';
        $task->completed_at = now();
        $task->save();
    }

    return back()->with('success', 'Task marked as completed.');
}


    //Project Manager
    public function projectList()
    {
        $projects = Project::all(); 
        return view('projectmanager.projects.index', compact('projects'));
    }

    public function tasksByProject(Project $project, Request $request)
    {
        $query = $project->tasks()->with(['developer']); 

        if ($request->status) {
            $query->where('status', $request->status);
        }
            if ($request->filled('month')) {
        [$year, $month] = explode('-', $request->month);
        $query->whereYear('deadline', $year)
              ->whereMonth('deadline', $month);
    }

        $tasks = $query->get();
        return view('projectmanager.tasks.index', compact('project', 'tasks'));
    }

    public function forwardToDeveloper($taskId)
    {
        $task = AssignedTask::findOrFail($taskId);
        $task->status = 'Forwarded';
        $task->save();

        return back()->with('success', 'Task forwarded to developer.');
    }
    // Show project selection view for Project Manager
    public function projectManagerIndex()
    {
        $today = Carbon::today();

        // Show only projects that are active (deadline not passed or null)
        $projects = Project::where(function ($query) use ($today) {
            $query->whereNull('deadline') // Projects without deadline
                  ->orWhereDate('deadline', '>=', $today); // Not expired
        })->get();

        return view('projectmanager.projects.index', compact('projects'));
    }
}
