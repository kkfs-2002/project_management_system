<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignedTask;
use App\Models\Profile;

class SuperAdminAssignTaskController extends Controller
{
    public function create()
    {
        $projectManagers = Profile::where('role', 'Project Manager')->get();
        $developers = Profile::where('role', 'Developer')->get();

        return view('superadmin.assign_task.create', compact('projectManagers', 'developers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_manager_id' => 'required|exists:profiles,id',
            'developer_id' => 'required|exists:profiles,id',
            'project_name' => 'required|string|max:255',
            'task_description' => 'required|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        AssignedTask::create([
            'project_manager_id' => $request->project_manager_id,
            'developer_id' => $request->developer_id,
            'project_name' => $request->project_name,
            'task_description' => $request->task_description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => 'Pending',
            'date' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Task assigned successfully!');
    }
}
