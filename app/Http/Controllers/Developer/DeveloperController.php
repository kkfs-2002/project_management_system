<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\AssignedTask;

class DeveloperController extends Controller
{
public function dashboard()
{
    $forwardedTasks = AssignedTask::where('status', 'Forwarded')->count();
    $completedTasks = AssignedTask::where('status', 'Completed')->count();

    return view('developer.dashboard', compact( 'forwardedTasks', 'completedTasks'));
}

}

