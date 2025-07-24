<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperDashController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Protect this route for authenticated users
    }
    
//Ongoing project
public function dashboard(Request $request)
{
    $type = $request->query('type');
    $sort = $request->query('sort', 'asc'); 

    $projectsQuery = Project::whereNotNull('deadline');

    if ($type) {
        $projectsQuery->where('type', $type);
    }

    // Sort by deadline
    $projects = $projectsQuery->orderBy('deadline', $sort)->get();

    $projectTypes = Project::select('type')->distinct()->pluck('type');

    $timelineProjects = $projects->map(function ($project) {
        $start = Carbon::parse($project->start_date);
        $end = Carbon::parse($project->deadline);
        $today = Carbon::today();

        $totalDays = $start->diffInDays($end);
        $daysPassed = $start->diffInDays($today);
        $daysRemaining = $today->diffInDays($end, false);

        $completion = min(100, round(($daysPassed / max(1, $totalDays)) * 100));
        $color = $completion >= 80 ? 'success' : ($completion >= 50 ? 'warning' : 'danger');

        return [
            'name' => $project->name,
            'type' => $project->type,
            'start_date' => $start->format('Y-m-d'),
            'deadline' => $end->format('Y-m-d'),
            'completion' => $completion,
            'color' => $color,
            'days_remaining' => $daysRemaining,
        ];
    });

    $employeeCount = \App\Models\Profile::count();
    $projectCount = \App\Models\Project::count();
    

     return view('superadmin.superdash', compact('timelineProjects', 'projectTypes', 'employeeCount', 'projectCount'));



    
}
}

