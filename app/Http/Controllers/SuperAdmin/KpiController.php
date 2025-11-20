<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeKpi;
use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KpiController extends Controller
{
    public function index()
    {
        $kpis = EmployeeKpi::with('profile')
                          ->orderBy('is_active', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->get();

        $employees = Profile::whereIn('role', ['Developer', 'Designer', 'Tester', 'Intern'])
                           ->where('employee_status', 'active')
                           ->get();

        return view('superadmin.kpi.index', compact('kpis', 'employees'));
    }

    public function create()
    {
        $employees = Profile::whereIn('role', ['Developer', 'Designer', 'Tester', 'Intern'])
                           ->where('employee_status', 'active')
                           ->orderBy('full_name')
                           ->get();

        if ($employees->isEmpty()) {
            return redirect()->route('superadmin.kpi.index')
                             ->with('warning', 'No active employees found. Please add employees first.');
        }

        return view('superadmin.kpi.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'kpi_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'measurement_unit' => 'required|string|max:50',
            'daily_target' => 'required|numeric|min:0.01',
            'weekly_target' => 'required|numeric|min:0.01',
            'monthly_target' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $validated['is_active'] = true;
        $validated['current_achievement'] = 0;

        EmployeeKpi::create($validated);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_new') {
            return redirect()->route('superadmin.kpi.create')
                             ->with('success', 'KPI set successfully! Set another KPI.');
        }

        return redirect()->route('superadmin.kpi.index')->with('success', 'KPI set successfully!');
    }

    public function updateAchievement(Request $request, EmployeeKpi $kpi)
    {
        $validated = $request->validate([
            'current_achievement' => 'required|numeric|min:0'
        ]);

        $kpi->update($validated);

        return back()->with('success', 'Achievement updated successfully!');
    }

    public function destroy(EmployeeKpi $kpi)
    {
        $kpi->update(['is_active' => false]);

        return back()->with('success', 'KPI deactivated successfully!');
    }

    public function activate(EmployeeKpi $kpi)
    {
        $kpi->update(['is_active' => true]);

        return back()->with('success', 'KPI activated successfully!');
    }

    public function forceDelete(EmployeeKpi $kpi)
    {
        $kpi->delete();

        return back()->with('success', 'KPI permanently deleted!');
    }
}