<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Profile;

class AttendanceController extends Controller
{
//View page
    public function index(Request $request)
   {
    $date = $request->get('date', date('Y-m-d'));
    $department = $request->get('department');

    $query = Profile::query();
    if ($department) {
        $query->where('department', $department);
    }

    $profiles = $query->get();
    $departments = Profile::select('department')->distinct()->get();

    return view('superadmin.attendance.index', compact('profiles', 'departments', 'date', 'department'));
    }
    
    //Store in the attendance database table
    public function store(Request $request)
    {
      $date = $request->input('date');
      $attendances = $request->input('attendances');

    foreach ($attendances as $profileId => $entry) {
        if (isset($entry['present'])) {
            Attendance::updateOrCreate(
                [
                    'profile_id' => $profileId,
                    'date' => $date,
                ],
                [
                    'check_in' => $entry['check_in'] ?? null,
                    'check_out' => $entry['check_out'] ?? null,
                    'total_hours' => $entry['total_hours'] ?? null,
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'Attendance marked successfully.');
}

    public function showSheet(Request $request)
{
    $query = Attendance::with('profile');

    if ($request->filled('date')) {
        $query->whereDate('date', $request->date);
    }

    if ($request->filled('month')) {
        $query->whereMonth('date', $request->month);
    }

    $attendances = $query->get();

    return view('superadmin.attendance.sheet', compact('attendances'));
}
}
