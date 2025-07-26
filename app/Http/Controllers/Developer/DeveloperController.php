<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\AssignedTask;

class DeveloperController extends Controller
{
public function dashboard($id)
{
    $developer = Profile::findOrFail($id);

    $totalTasks = AssignedTask::where('developer_id', $id)->count();
    $completedTasks = AssignedTask::where('developer_id', $id)->where('status', 'Completed')->count();
    $pendingTasks = AssignedTask::where('developer_id', $id)->where('status', 'Pending')->count();

    return view('developer.dashboard', compact('developer', 'totalTasks', 'completedTasks', 'pendingTasks'));
}

}
