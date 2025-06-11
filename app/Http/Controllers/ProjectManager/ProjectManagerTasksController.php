<?php

namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignedTask;
use Carbon\Carbon;

class ProjectManagerTasksController extends Controller
{
    public function index()
    {
        $pmId = session('user_id'); 

        $tasks = AssignedTask::with('developer') 
                    ->where('project_manager_id', $pmId)
                    ->orderBy('date', 'desc')
                    ->get();

        return view('projectmanager.tasks.index', compact('tasks'));
    }

    public function forward(AssignedTask $task)
    {
        $task->update([
            'status' => 'Forwarded',
        ]);

        return redirect()->back()->with('success', 'Task forwarded to developer!');
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
            'date' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->back()->with('success', 'Task assigned successfully!');
    }
}
