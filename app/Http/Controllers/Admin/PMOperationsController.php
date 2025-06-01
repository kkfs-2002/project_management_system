<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\DeveloperLog;
use App\Models\AssignedTask;

class PMOperationsController extends Controller
{

    public function showLogForm()
    {
        $developers = Profile::where('role', 'Developer')->get();
        $projectManagers = Profile::where('role', 'Project Manager')->get();
        return view('admin.operations.logbook', compact('developers', 'projectManagers'));
    }

    public function storeLog(Request $request)
    {
        DeveloperLog::create([
            'developer_id' => $request->developer_id,
            'project_manager_id' => $request->project_manager_id,
            'date' => $request->date,
            'project_name' => $request->project_name,
            'task_summary' => $request->task_summary,
            'time_spent' => $request->time_spent,
            'task_status' => $request->task_status,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Log saved successfully.');
    }

    public function showAssignForm()
    {
        $developers = Profile::where('role', 'Developer')->get();
        $projectManagers = Profile::where('role', 'Project Manager')->get();
        return view('admin.operations.assign_task', compact('developers', 'projectManagers'));
    }

    public function assignTask(Request $request)
    {
        AssignedTask::create([
            'developer_id' => $request->developer_id,
            'project_manager_id' => $request->project_manager_id,
            'date' => $request->date,
            'task_description' => $request->task_description,
            'project_name' => $request->project_name,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ]);

        return back()->with('success', 'Task assigned successfully.');
    }

    
}
