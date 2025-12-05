<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Get the authenticated user's profile
     */
    private function getAuthenticatedProfile()
    {
        $user = Auth::user();  // Now returns Profile directly

        if (!$user) {
            // Fallback to session (for legacy/transition)
            $role = session('role');
            if (!$role) return null;
            return Profile::where('employee_id', session('employee_id'))->first();
        }

        return $user;  // Direct return since user == profile
    }

    

    /**
     * Check in attendance (General - works for all roles)
     */
    public function checkIn(Request $request)
    {
        try {
            \Log::info('CheckIn Debug - Auth Check: ' . (Auth::check() ? 'TRUE' : 'FALSE'));
            \Log::info('CheckIn Debug - User: ' . json_encode(Auth::user()));
             
            $user = Auth::user();
             
            if (!$user) {
                \Log::warning('CheckIn - User is null, redirecting to login');
                return redirect()->route('login');
            }
             
            $profile = $this->getAuthenticatedProfile();
            if (!$profile) {
                return redirect()->back()->with('attendance_error', 'Profile not found! Please contact administrator.');
            }
             
            // Determine role from profile (prioritize 'role', fallback to 'job_title')
            $userRole = $profile->role ?? $profile->job_title ?? 'Unknown';
             
            // Get timezone from request or use default
            $timezone = $request->input('timezone', 'Asia/Colombo');
            $now = Carbon::now($timezone);
            $today = Carbon::today($timezone);
             
            $existingAttendance = Attendance::where('profile_id', $profile->id)
                ->whereDate('date', $today)
                ->first();
               
            if ($existingAttendance && $existingAttendance->check_in) {
                return redirect()->back()->with('attendance_error', 'You have already checked in today!');
            }
             
            $attendance = Attendance::updateOrCreate(
                [
                    'profile_id' => $profile->id,
                    'date' => $today
                ],
                [
                    'check_in' => $now,
                    'role' => $userRole, // Save the role here
                ]
            );
             
            \Log::info('Check-in successful for profile_id: ' . $profile->id . ' with role: ' . $userRole);
             
            // Redirect to the same page - this will reload with new data
            return redirect()->back()->with('attendance_message',
                'Successfully checked in at ' . $now->format('h:i A'));
               
        } catch (\Exception $e) {
            \Log::error('Check-in error: ' . $e->getMessage());
            return redirect()->back()->with('attendance_error',
                'Error checking in: ' . $e->getMessage());
        }
    }

    /**
     * Check out attendance (General - works for all roles)
     */
    public function checkOut(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->back()->with('attendance_error', 'User not authenticated!');
            }
            
            $profile = $this->getAuthenticatedProfile();
            
            if (!$profile) {
                return redirect()->back()->with('attendance_error', 'Profile not found! Please contact administrator.');
            }
            
            // Get timezone from request or use default
            $timezone = $request->input('timezone', 'Asia/Colombo'); // Sri Lanka timezone
            $now = Carbon::now($timezone);
            $today = Carbon::today($timezone);
            
            // Find today's attendance
            $attendance = Attendance::where('profile_id', $profile->id)
                ->whereDate('date', $today)
                ->first();
            
            if (!$attendance || !$attendance->check_in) {
                return redirect()->back()->with('attendance_error', 'Please check in first!');
            }
            
            if ($attendance->check_out) {
                return redirect()->back()->with('attendance_error', 'You have already checked out today!');
            }
            
            // Update check out time
            $attendance->check_out = $now;
            
            // Calculate total hours
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);
            $attendance->total_hours = $checkIn->diffInHours($checkOut, true);
            
            $attendance->save();
            
            // Format message with total hours
            $diff = $checkIn->diff($checkOut);
            $message = 'Successfully checked out at ' . $now->format('h:i A') .
                       '. Total hours: ' . $diff->h . 'h ' . $diff->i . 'm';
            
            return redirect()->back()->with('attendance_message', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('attendance_error',
                'Error checking out: ' . $e->getMessage());
        }
    }

    /**
     * Developer Check In (Alias for checkIn)
     */
    public function developerCheckIn(Request $request)
    {
        return $this->checkIn($request);
    }

    /**
     * Developer Check Out (Alias for checkOut)
     */
    public function developerCheckOut(Request $request)
    {
        return $this->checkOut($request);
    }

    /**
     * Developer Attendance History
     */
    public function developerHistory(Request $request)
    {
        $profile = $this->getAuthenticatedProfile();
        
        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found!');
        }

        $attendances = Attendance::where('profile_id', $profile->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        $user = Auth::user();
        $dev = $profile; // Alias for view compatibility
        
        return view('developer.attendance.history', compact('attendances', 'user', 'dev'));
    }

    /**
     * Marketing Check In
     */
    public function marketingCheckIn(Request $request)
    {
        return $this->checkIn($request);
    }

    /**
     * Marketing Check Out
     */
    public function marketingCheckOut(Request $request)
    {
        return $this->checkOut($request);
    }

    /**
     * Marketing Attendance History
     */
    public function marketingHistory(Request $request)
    {
        $profile = $this->getAuthenticatedProfile();
        
        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found!');
        }

        $attendances = Attendance::where('profile_id', $profile->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        $user = Auth::user();
        $marketing = $profile; // Alias for view
        
        return view('marketing.attendance.history', compact('attendances', 'user', 'marketing'));
    }

    /**
     * Get attendance history for authenticated user (General method)
     */
    public function history(Request $request)
    {
        $profile = $this->getAuthenticatedProfile();
        
        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found!');
        }

        $attendances = Attendance::where('profile_id', $profile->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        $user = Auth::user();
        
        // Determine view based on user's role in profile
        if ($profile->role === 'Project Manager' || $profile->job_title === 'Project Manager') {
            return view('projectmanager.attendance.history', compact('attendances', 'user'));
        } elseif ($profile->role === 'Developer' || strpos($profile->job_title, 'Developer') !== false) {
            return view('developer.attendance.history', compact('attendances', 'user'));
        } elseif ($profile->role === 'Marketing' || $profile->job_title === 'Marketing Manager') {
            return view('marketing.attendance.history', compact('attendances', 'user'));
        }

        // Default view
        return view('attendance.history', compact('attendances', 'user'));
    }

    /**
     * Get today's attendance for authenticated user (API/AJAX endpoint)
     */
    public function getTodayAttendance(Request $request)
    {
        $profile = $this->getAuthenticatedProfile();
        
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $attendance = Attendance::where('profile_id', $profile->id)
            ->whereDate('date', Carbon::today())
            ->first();

        return response()->json([
            'attendance' => $attendance,
            'has_checked_in' => $attendance && $attendance->check_in ? true : false,
            'has_checked_out' => $attendance && $attendance->check_out ? true : false,
        ]);
    }

    /**
     * Admin/Manager view - See all attendance records
     */
    public function index(Request $request)
    {
        $query = Attendance::with('profile');

        // Filters
        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('profile_id')) {
            $query->where('profile_id', $request->profile_id);
        }

        if ($request->has('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->has('year')) {
            $query->whereYear('date', $request->year);
        }

        $attendances = $query->orderBy('date', 'desc')
                            ->orderBy('check_in', 'desc')
                            ->paginate(20);

        $profiles = Profile::orderBy('full_name')->get();

        return view('attendance.index', compact('attendances', 'profiles'));
    }

    /**
     * Export attendance report (CSV/Excel)
     */
    public function export(Request $request)
    {
        $profile = $this->getAuthenticatedProfile();
        
        $query = Attendance::query();

        // Only show own records
        if ($profile) {
            $query->where('profile_id', $profile->id);
        }

        if ($request->has('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $attendances = $query->with('profile')->get();

        // Return CSV
        $filename = 'attendance_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Employee', 'Check In', 'Check Out', 'Total Hours']);

            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->date->format('Y-m-d'),
                    $attendance->profile->full_name ?? 'N/A',
                    $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '-',
                    $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '-',
                    $attendance->total_hours ? number_format($attendance->total_hours, 2) . 'h' : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Superadmin - View Developer Attendance
     */
    /**
 * Superadmin - View Developer Attendance
 */
public function developer(Request $request)
{
    try {
        // Get all Developer profiles
        $developers = Profile::where('role', 'Developer')
            ->orWhere('job_title', 'like', '%Developer%')
            ->orWhere('job_title', 'like', '%dev%')
            ->orderBy('full_name')
            ->get();

        // Get attendance data with filters
        $query = Attendance::with('profile')
            ->whereHas('profile', function ($q) {
                $q->where('role', 'Developer')
                  ->orWhere('job_title', 'like', '%Developer%')
                  ->orWhere('job_title', 'like', '%dev%');
            });

        // Apply date filters
        if ($request->has('month') && $request->month) {
            $query->whereMonth('date', $request->month);
        }
        
        if ($request->has('year') && $request->year) {
            $query->whereYear('date', $request->year);
        }
        
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->has('profile_id') && $request->profile_id) {
            $query->where('profile_id', $request->profile_id);
        }

        $attendances = $query->orderBy('date', 'desc')
                            ->orderBy('check_in', 'desc')
                            ->paginate(20);

        return view('superadmin.attendance.developer', compact(
            'attendances', 
            'developers'
        ));
    } catch (\Exception $e) {
        \Log::error('Error in developer attendance view: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error loading attendance data: ' . $e->getMessage());
    }
}
   
    /**
     * Superadmin - View Project Manager Attendance
     */
    /**
 * Superadmin - View Project Manager Attendance
 */
/**
 * Superadmin - View Project Manager Attendance
 */
public function projectmanager(Request $request)
{
    try {
        // Get all Project Manager profiles
        $projectManagers = Profile::where('role', 'Project Manager')
            ->orWhere('job_title', 'Project Manager')
            ->orderBy('full_name')
            ->get();

        // Get attendance data with filters
        $query = Attendance::with('profile')
            ->whereHas('profile', function ($q) {
                $q->where('role', 'Project Manager')
                  ->orWhere('job_title', 'Project Manager');
            });

        // Apply date filters
        if ($request->has('month') && $request->month) {
            $query->whereMonth('date', $request->month);
        }
        
        if ($request->has('year') && $request->year) {
            $query->whereYear('date', $request->year);
        }
        
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->has('profile_id') && $request->profile_id) {
            $query->where('profile_id', $request->profile_id);
        }

        $attendances = $query->orderBy('date', 'desc')
                            ->orderBy('check_in', 'desc')
                            ->paginate(20);

        return view('superadmin.attendance.projectmanager', compact(
            'attendances', 
            'projectManagers'
        ));
    } catch (\Exception $e) {
        \Log::error('Error in projectmanager attendance view: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error loading attendance data: ' . $e->getMessage());
    }
}

    /**
 * Superadmin - View Marketing Manager Attendance
 */
public function marketingmanager(Request $request)
{
    // Get marketing manager profiles (based on role or job_title)
    $marketingManagerProfiles = Profile::where('role', 'Marketing')
        ->orWhere('job_title', 'Marketing Manager')
        ->orWhere('job_title', 'like', '%Marketing%')
        ->get();
    
    // Get marketing manager profile IDs
    $marketingManagerIds = $marketingManagerProfiles->pluck('id')->toArray();
    
    // Start query
    $query = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->with('profile')
        ->orderBy('date', 'desc');
    
    // Apply date filter if provided
    if ($request->has('date') && !empty($request->date)) {
        $query->whereDate('date', $request->date);
    } else {
        // Default to today's date
        $query->whereDate('date', Carbon::today());
    }
    
    // Get paginated results
    $attendances = $query->paginate(20);
    
    // Calculate statistics for today
    $today = $request->has('date') ? Carbon::parse($request->date) : Carbon::today();
    
    $totalPresentToday = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->whereDate('date', $today)
        ->whereNotNull('check_in')
        ->count();
    
    $lateArrivals = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->whereDate('date', $today)
        ->whereNotNull('check_in')
        ->whereRaw('HOUR(check_in) >= 9')
        ->whereRaw('MINUTE(check_in) > 0')
        ->count();
    
    $earlyLeaves = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->whereDate('date', $today)
        ->whereNotNull('check_out')
        ->whereRaw('HOUR(check_out) < 17')
        ->count();
    
    $averageHours = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->whereDate('date', $today)
        ->whereNotNull('total_hours')
        ->avg('total_hours') ?? 0;
    
    return view('superadmin.attendance.marketingmanager', compact(
        'attendances',
        'marketingManagerProfiles',
        'totalPresentToday',
        'lateArrivals',
        'earlyLeaves',
        'averageHours'
    ));
}

/**
 * Get attendance details (for modal)
 */
/**
 * Get attendance details (for modal) - UPDATED
 */
public function getAttendanceDetails($id)
{
    try {
        $attendance = Attendance::with('profile')->find($id);
        
        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance record not found'
            ], 404);
        }
        
        $checkIn = $attendance->check_in ? Carbon::parse($attendance->check_in) : null;
        $checkOut = $attendance->check_out ? Carbon::parse($attendance->check_out) : null;
        
        // Calculate status
        $checkInStatus = null;
        if ($checkIn) {
            $checkInHour = $checkIn->format('H');
            $checkInStatus = $checkInHour < 9 ? 'On Time' : 'Late';
        }
        
        $checkOutStatus = null;
        if ($checkOut) {
            $checkOutHour = $checkOut->format('H');
            $checkOutStatus = $checkOutHour >= 17 ? 'Full Day' : 'Early Leave';
        }
        
        $overallStatus = 'Absent';
        if ($attendance->check_in && $attendance->check_out) {
            $overallStatus = 'Completed';
        } elseif ($attendance->check_in && !$attendance->check_out) {
            $overallStatus = 'Checked In';
        }
        
        $totalHours = 'N/A';
        if ($attendance->total_hours) {
            $totalHours = number_format($attendance->total_hours, 2) . ' hours';
        } elseif ($attendance->check_in && $attendance->check_out) {
            $diff = $checkIn->diff($checkOut);
            $totalHours = $diff->h . 'h ' . $diff->i . 'm';
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'full_name' => $attendance->profile->full_name ?? 'N/A',
                'employee_id' => $attendance->profile->employee_id ?? 'N/A',
                'profile_picture' => $attendance->profile->profile_picture ?? asset('assets/img/default-avatar.png'),
                'role' => $attendance->profile->job_title ?? $attendance->profile->role ?? 'N/A',
                'date' => $attendance->date->format('Y-m-d'),
                'date_formatted' => $attendance->date->format('d M Y'),
                'day' => $attendance->date->format('l'),
                'check_in_time' => $checkIn ? $checkIn->format('h:i A') : 'Not Checked In',
                'check_in_full' => $checkIn ? $checkIn->format('Y-m-d h:i A') : null,
                'check_out_time' => $checkOut ? $checkOut->format('h:i A') : 'Not Checked Out',
                'check_out_full' => $checkOut ? $checkOut->format('Y-m-d h:i A') : null,
                'check_in_status' => $checkInStatus,
                'check_out_status' => $checkOutStatus,
                'total_hours' => $totalHours,
                'overall_status' => $overallStatus,
                'attendance_id' => $attendance->id,
                'profile_id' => $attendance->profile_id,
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in getAttendanceDetails: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error loading attendance details',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Export marketing manager attendance
 */
public function exportMarketingAttendance(Request $request)
{
    // Get marketing manager profile IDs
    $marketingManagerIds = Profile::where('role', 'Marketing')
        ->orWhere('job_title', 'Marketing Manager')
        ->orWhere('job_title', 'like', '%Marketing%')
        ->pluck('id')
        ->toArray();
    
    $query = Attendance::whereIn('profile_id', $marketingManagerIds)
        ->with('profile');
    
    if ($request->has('date') && !empty($request->date)) {
        $query->whereDate('date', $request->date);
    }
    
    $attendances = $query->orderBy('date', 'desc')->get();
    
    $filename = 'marketing_attendance_' . ($request->date ?? Carbon::today()->format('Y-m-d')) . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];
    
    $callback = function() use ($attendances) {
        $file = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($file, "\xEF\xBB\xBF");
        
        fputcsv($file, ['Date', 'Employee ID', 'Name', 'Check In', 'Check Out', 'Total Hours', 'Status']);
        
        foreach ($attendances as $attendance) {
            $status = 'Absent';
            if ($attendance->check_in && $attendance->check_out) {
                $status = 'Completed';
            } elseif ($attendance->check_in && !$attendance->check_out) {
                $status = 'Checked In';
            }
            
            fputcsv($file, [
                Carbon::parse($attendance->date)->format('Y-m-d'),
                $attendance->profile->employee_id ?? 'N/A',
                $attendance->profile->full_name ?? 'N/A',
                $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '-',
                $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '-',
                $attendance->total_hours ? number_format($attendance->total_hours, 2) : '-',
                $status
            ]);
        }
        
        fclose($file);
    };
    
    return response()->stream($callback, 200, $headers);
}

/**
 * Mark attendance as checked out (for supervisors)
 */
public function markAsCheckedOut(Request $request, $id)
{
    try {
        $attendance = Attendance::findOrFail($id);
        
        // Validation checks
        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Project manager has already checked out!'
            ], 400);
        }
        
        if (!$attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Project manager has not checked in yet!'
            ], 400);
        }
        
        // Set check out time
        $checkOutTime = Carbon::now();
        $attendance->check_out = $checkOutTime;
        
        // Calculate total hours
        $checkIn = Carbon::parse($attendance->check_in);
        $totalHours = $checkIn->diffInHours($checkOutTime, true);
        $attendance->total_hours = round($totalHours, 2);
        
        $attendance->save();
        
        // Log the action
        \Log::info('Project Manager attendance marked as checked out', [
            'attendance_id' => $attendance->id,
            'profile_id' => $attendance->profile_id,
            'marked_by' => Auth::id()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully marked as checked out!',
            'data' => [
                'check_out_time' => $checkOutTime->format('h:i A'),
                'total_hours' => $attendance->total_hours
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error marking project manager check out: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}
}