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

    public function developerIndex()
    {
        $projects = Project::all();
        return view('developer.projects.index', compact('projects'));
    }

    // Show all projects (no filtering) to developer
    public function developerProjectList()
    {
        $projects = Project::all();
        return view('developer.projects.index', compact('projects'));
    }

    // Show tasks of selected project, but only tasks assigned to this developer
    public function developerTasksByProject(Project $project, Request $request)
    {
        $developerId = session('developer_id'); // Make sure developer_id is stored in session on login

        $tasks = $project->tasks()
            ->where('developer_id', $developerId)
            ->get();

        return view('developer.tasks.index', compact('project', 'tasks'));
    }

    // Developer marks a task as completed
    public function markTaskCompleted($taskId)
    {
        $task = AssignedTask::findOrFail($taskId);

        $task->status = 'Completed';
        $task->developer_completed_at = now(); // if you have this column
        $task->save();

        return back()->with('success', 'Task marked as completed.');
    }

    //Project Manager
    public function projectList()
    {
        $projects = Project::all(); // Or filter by assigned project manager if needed
        return view('projectmanager.projects.index', compact('projects'));
    }

    public function tasksByProject(Project $project, Request $request)
    {
        $query = $project->tasks()->with(['developer']); // assuming a relationship

        if ($request->status) {
            $query->where('status', $request->status);
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
        $projects = Project::all(); // or filter by authenticated PM if needed
        return view('projectmanager.projects.index', compact('projects'));
    }
}
