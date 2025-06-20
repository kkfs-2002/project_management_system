<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /* ---------- SUPER ADMIN ---------- */

    // show form
    public function create()
    {
        $developers       = Profile::where('role', 'Developer')->get();
        $projectManagers  = Profile::where('role', 'Project Manager')->get();

        return view('superadmin/tasks/create', compact('developers', 'projectManagers'));
    }

    // store new task
    public function store(Request $request)
    {
        $request->validate([
            'developer_id'        => 'required|exists:profiles,id',
            'project_manager_id'  => 'required|exists:profiles,id',
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'deadline'            => 'required|date|after:yesterday',
        ]);

        $dev = Profile::find($request->developer_id);
        $pm  = Profile::find($request->project_manager_id);

        Task::create([
            'developer_id'        => $dev->id,
            'project_manager_id'  => $pm->id,
            'developer_name'      => $dev->full_name,
            'project_manager_name'=> $pm->full_name,
            'title'               => $request->title,
            'description'         => $request->description,
            'deadline'            => $request->deadline,
        ]);

        return back()->with('success', 'Task assigned successfully.');
    }

    // master list visible to Super Admin
    public function superadminIndex()
    {
        $tasks = Task::latest()->get();
        return view('superadmin/tasks/index', compact('tasks'));
    }

    /* ---------- PROJECT MANAGER ---------- */

    public function projectManagerIndex($pmId)
    {
        $pm    = Profile::findOrFail($pmId);           // FYI: could be username instead
        $tasks = Task::where('project_manager_id', $pmId)->latest()->get();
        $tasks = Task::latest()->get();

        return view('projectmanager/tasks/index', compact( 'tasks'));
    }

    // Forward to dev
    public function forwardToDeveloper($id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status'           => 'Forwarded',
            'pm_forwarded_at'  => Carbon::now(),
        ]);

        return back()->with('success', 'Task forwarded to developer.');
    }

    /* ---------- DEVELOPER ---------- */

    public function developerIndex($devId)
    {
        $dev   = Profile::findOrFail($devId);
        $tasks = Task::where('developer_id', $devId)->latest()->get();
        $tasks = Task::latest()->get();

        return view('developer/tasks/index', compact('dev', 'tasks'));
    }

    // mark as complete
    public function complete($id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status'       => 'Completed',
            'completed_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Great! Task marked as complete.');
    }
}
