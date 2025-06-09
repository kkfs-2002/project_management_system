<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignedTask;

class DeveloperTasksController extends Controller
{
    public function index()
    {
        $developerId = session('user_id'); // you should store developer id in session after login

        $tasks = AssignedTask::where('developer_id', $developerId)
                    ->where('status', 'Forwarded')
                    ->orderBy('date', 'desc')
                    ->get();

        return view('developer.tasks.index', compact('tasks'));
    }
}
