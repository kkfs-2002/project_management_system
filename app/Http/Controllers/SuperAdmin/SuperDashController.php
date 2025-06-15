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
    public function dashboard()
    {
    $timelineProjects = Project::whereNotNull('deadline')->get()->map(function ($project) {
        $start = Carbon::parse($project->start_date);
        $end = Carbon::parse($project->deadline);
        $today = Carbon::today();


        $totalDays = $start->diffInDays($end);
        $daysPassed = $start->diffInDays($today);
        $daysRemaining = $today->diffInDays($end, false);

        // Visual status color
        if ($today->gt($end)) {
            $status = 'Overdue';
            $color = 'danger'; 
        } elseif ($daysRemaining <= 5) {
            $status = 'Near Deadline';
            $color = 'warning'; 
        } else {
            $status = 'On Track';
            $color = 'success'; 
        }

        return [
            'name' => $project->name,
            'start_date' => $start->format('Y-m-d'),
            'deadline' => $end->format('Y-m-d'),
            'days_passed' => $daysPassed,
            'total_days' => $totalDays,
            'days_remaining' => $daysRemaining,
            'status' => $status,
            'color' => $color,
        ];
    });

    return view('superadmin.superdash', compact('timelineProjects'));
}

}
