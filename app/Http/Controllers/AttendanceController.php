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
     * Check in attendance
     */
   public function checkIn(Request $request)
{
    try {
        \Log::info('CheckIn Debug - Auth Check: ' . (Auth::check() ? 'TRUE' : 'FALSE'));
        \Log::info('CheckIn Debug - User: ' . json_encode(Auth::user()));
        \Log::info('CheckIn Debug - Session ID: ' . session()->getId());
        
        $user = Auth::user();
        
        if (!$user) {
            \Log::warning('CheckIn - User is null, redirecting to login');
            return redirect()->route('login');
        }
        
        $profile = $this->getAuthenticatedProfile();
        if (!$profile) {
            return redirect()->back()->with('attendance_error', 'Profile not found! Please contact administrator.');
        }
        
        $today = Carbon::today();
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
                'check_in' => Carbon::now()
            ]
        );
        
        return redirect()->back()->with('attendance_message',
            'Successfully checked in at ' . Carbon::now()->format('h:i A'));
    } catch (\Exception $e) {
        \Log::error('Check-in error: ' . $e->getMessage()); // Log for debugging
        return redirect()->back()->with('attendance_error',
            'Error checking in: ' . $e->getMessage());
    }
}

    /**
     * Check out attendance
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

            $today = Carbon::today();

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
            $attendance->check_out = Carbon::now();
            
            // Calculate total hours
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);
            $attendance->total_hours = $checkIn->diffInHours($checkOut, true);
            
            $attendance->save();

            // Format message with total hours
            $diff = $checkIn->diff($checkOut);
            $message = 'Successfully checked out at ' . Carbon::now()->format('h:i A') . 
                       '. Total hours: ' . $diff->h . 'h ' . $diff->i . 'm';

            return redirect()->back()->with('attendance_message', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('attendance_error', 
                'Error checking out: ' . $e->getMessage());
        }
    }

    /**
     * Get attendance history for authenticated user
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
}