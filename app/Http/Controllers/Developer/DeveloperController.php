<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AssignedTask;
use App\Models\Attendance;
use Carbon\Carbon;

class DeveloperController extends Controller
{
    public function dashboard()
    {
        // Get authenticated developer
        $dev = Auth::user(); // Assuming Auth::user() returns the Profile
        
        if (!$dev) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Task statistics
        $forwardedTasks = AssignedTask::where('status', 'Forwarded')->count();
        $completedTasks = AssignedTask::where('status', 'Completed')->count();

        // Get today's attendance for the authenticated developer
        $todayAttendance = Attendance::where('profile_id', $dev->id)
            ->whereDate('date', Carbon::today())
            ->first();

        return view('developer.dashboard', compact(
            'dev',
            'forwardedTasks', 
            'completedTasks',
            'todayAttendance'
        ));
    }
}