<?php

namespace App\Http\Controllers\SuperAdmin;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                $start = Carbon::parse($month.'-01')->startOfMonth();
                $end = (clone $start)->endOfMonth();

                /* 4.  fetch this employee’s attendance for the month  */
$records = Attendance::where('profile_id', $employeeId)
          ->whereDate('date', '>=', $start)   // use DATE comparison
          ->whereDate('date', '<=', $end)
          ->get();

/* 4-b. index rows by pure date → total hours */
$hoursByDate = $records
    ->groupBy(fn ($row) => Carbon::parse($row->date)->format('Y-m-d'))
    ->map(fn ($rows)    => (float) $rows->sum('total_hours'));

/* 5. KPIs (leave as-is) */
$daysPresent = $records->count();
$totalHours  = round($records->sum('total_hours'), 2);

/* 6.  build dailyHours for every day of the month */
$dailyHours = collect();
for ($d = (clone $start); $d <= $end; $d->addDay()) {
    $date = $d->format('Y-m-d');
    $dailyHours->put($date, $hoursByDate[$date] ?? 0.0);   // always a float
}

            }
        }

        // Month list
        $first = Project::min('start_date') ?? now()->format('Y-m-01');
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
        $employee   = Profile::findOrFail($request->employee_id);
        $month      = Carbon::parse($request->month)->format('F Y');
        $daysPresent= $request->days_present;
        $totalHours = $request->total_hours;
        $dailyHours = json_decode($request->daily_hours, true);

        $pdf = Pdf::loadView(
            'superadmin.employee.attendance.single-pdf',
            compact('employee','month','daysPresent','totalHours','dailyHours')
        );

        return $pdf->download(
            Str::slug($employee->full_name).'_'.$request->month.'_attendance.pdf'
        );
    }
}


