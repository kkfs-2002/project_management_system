<?php

namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTask;
use App\Models\Profile;

class ProjectManagerController extends Controller
{
    public function dashboard($pmId)
    {
        // Get recent tasks (last 6 tasks)
        $recentTasks = DailyTask::with('profile')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get task statistics
        $totalTasks = DailyTask::count();
        $completedTasks = DailyTask::where('status', 'completed')->count();
        $inProgressTasks = DailyTask::where('status', 'in progress')->count();
        $pendingTasks = DailyTask::where('status', 'pending')->count();

        return view('projectmanager.dashboard', compact(
            'recentTasks',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'pendingTasks'
        ));
    }
}