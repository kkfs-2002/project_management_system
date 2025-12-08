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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Project;

class SuperAdminAttendanceController extends Controller
{
    public function employeeMonth(Request $request)
    {
        $employeeId = $request->integer('employee_id');
        $month = $request->input('month', now()->format('Y-m'));
        $employees = Profile::orderBy('full_name')->get();
        $employee = null;
        $daysPresent = 0;
        $totalHours = 0;
        $dailyHours = collect();
        $allMonths = collect();

        if ($employeeId) {
            $employee = Profile::find($employeeId);
            if ($employee) {
                $start = Carbon::parse($month . '-01')->startOfMonth();
                $end = (clone $start)->endOfMonth();

                /* Fetch this employee's attendance for the month */
                $records = Attendance::where('profile_id', $employeeId)
                    ->whereDate('date', '>=', $start)   // Use DATE comparison
                    ->whereDate('date', '<=', $end)
                    ->get();

                /* Index rows by pure date → total hours per day */
                $hoursByDate = $records
                    ->groupBy(fn($row) => Carbon::parse($row->date)->format('Y-m-d'))
                    ->map(fn($rows) => (float) $rows->sum('total_hours'));

                /* KPIs (updated: daysPresent counts unique days with attendance) */
                $daysPresent = $hoursByDate->filter(fn($hours) => $hours > 0)->count();
                $totalHours = round($records->sum('total_hours'), 2);

                /* Build dailyHours for every day of the month */
                $dailyHours = collect();
                for ($d = (clone $start); $d <= $end; $d->addDay()) {
                    $date = $d->format('Y-m-d');
                    $dailyHours->put($date, $hoursByDate->get($date, 0.0));   // Always a float
                }
            }
        }

        // Month list (updated: from earliest attendance date if available, fallback to project start)
        $earliestAttendance = Attendance::min('date');
        $first = $earliestAttendance ? Carbon::parse($earliestAttendance)->format('Y-m-01') : (Project::min('start_date') ?? now()->format('Y-m-01'));
        $run = Carbon::parse($first)->startOfMonth();
        while ($run <= now()) {
            $allMonths->push([
                'value' => $run->format('Y-m'),
                'label' => $run->format('F Y'),
            ]);
            $run->addMonth();
        }

        return view('superadmin.employee.attendance.employee-select', compact(
            'employees', 'employee', 'month',
            'daysPresent', 'totalHours', 'dailyHours', 'allMonths'
        ));
    }

    public function employeeMonthPdf(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:profiles,id',
            'month' => 'required|date_format:Y-m',
            'days_present' => 'required|integer|min:0',
            'total_hours' => 'required|numeric|min:0',
            'daily_hours' => 'required|json',
        ]);

        $employee = Profile::findOrFail($request->employee_id);
        $month = Carbon::parse($request->month)->format('F Y');
        $daysPresent = $request->days_present;
        $totalHours = $request->total_hours;
        $dailyHours = collect(json_decode($request->daily_hours, true));

        $pdf = Pdf::loadView(
            'superadmin.employee.attendance.single-pdf',
            compact('employee', 'month', 'daysPresent', 'totalHours', 'dailyHours')
        );

        return $pdf->download(
            Str::slug($employee->full_name) . '_' . $request->month . '_attendance.pdf'
        );
    }

   public function markAsCheckedOut(Request $request, $id)
    {
        // Basic auth guard (uncomment/adjust based on your roles)
        // if (!Auth::user() || !Auth::user()->hasRole('superadmin')) {  // Assuming Spatie or similar roles
        //     return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        // }

        try {
            $attendance = Attendance::findOrFail($id);

            // Check if already checked out
            if ($attendance->check_out) {
                return response()->json([
                    'success' => false,
                    'message' => 'Already checked out.'
                ], 400);
            }

            // Check if checked in
            if (!$attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot check out without checking in first.'
                ], 400);
            }

            // Mark as checked out with current time (use timezone if needed)
            $attendance->check_out = Carbon::now();
            $attendance->save();

            // Calculate total hours (handles fractional minutes)
            $totalHours = $attendance->check_out->diffInHours($attendance->check_in, false) +
                          ($attendance->check_out->diffInMinutes($attendance->check_in, false) % 60) / 60;

            $attendance->total_hours = round($totalHours, 2);
            $attendance->save();

            // Log the action (optional, for auditing)
            \Log::info("Checkout marked for attendance {$id} by user " . Auth::id());

            // Response for JS update
            $checkOutTime = $attendance->check_out->format('h:i A');
            $totalHoursFormatted = number_format($attendance->total_hours, 2);

            return response()->json([
                'success' => true,
                'message' => 'Check out marked successfully.',
                'data' => [
                    'check_out_time' => $checkOutTime,
                    'total_hours' => $totalHoursFormatted,
                    'status' => 'Completed'
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Checkout error for ID {$id}: " . $e->getMessage());  // Log for debugging
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark check out: ' . $e->getMessage()
            ], 500);
        }
    }
}