<?php

namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignedTask;
use App\Models\Profile;

class ProjectManagerController extends Controller
{
public function dashboard()
{
    $totalTasks = AssignedTask::count();
    $forwardedTasks = AssignedTask::where('status', 'Forwarded')->count();
    $completedTasks = AssignedTask::where('status', 'Completed')->count();

    return view('projectmanager.dashboard', compact('totalTasks', 'forwardedTasks', 'completedTasks'));
}

}
