<?php

namespace App\Http\Controllers\SuperAdmin;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Profile;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;



class SuperAdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $dates = collect(CarbonPeriod::create($start, $end))->map(fn($date) => $date->format('Y-m-d'));

        $employees = Profile::all();

        // Get all attendance records for the selected month
        $attendance = Attendance::whereBetween('date', [$start, $end])->get();

        // Group attendance by date and count
        $dailyCount = $dates->mapWithKeys(function ($date) use ($attendance) {
            $count = $attendance->filter(function ($att) use ($date) {
                return Carbon::parse($att->date)->format('Y-m-d') === $date;
            })->count();

            return [$date => $count];
        });

        // Calculate total hours per employee
        $employeeProgress = $employees->map(function ($emp) use ($attendance) {
            $records = $attendance->where('profile_id', $emp->id);
            $totalHours = $records->sum('total_hours');

            return [
                'name' => $emp->full_name,
                'hours' => round($totalHours, 2)
            ];
        });

        return view('superadmin.employee.attendance.index', compact('month', 'dailyCount', 'employeeProgress', 'dates'));
    }

    public function downloadPdf(Request $request)
    {
        $data = [
            'month' => $request->input('month'),
            'dailyCount' => json_decode($request->input('dailyCount'), true),
            'employeeProgress' => json_decode($request->input('employeeProgress'), true)
        ];

        $pdf = Pdf::loadView('superadmin.employee.attendance.pdf', $data);
        return $pdf->download('attendance-summary.pdf');
    }
}

