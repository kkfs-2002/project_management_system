<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Profile;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::with('profile');

        // Filter by month if provided
        if ($request->has('month') && $request->month) {
            $month = Carbon::parse($request->month); // from input type="month"
            $query->whereYear('salary_month', $month->year)
                  ->whereMonth('salary_month', $month->month);
        }

        $salaries = $query->orderBy('salary_month', 'desc')->get();
        $total = $salaries->sum('amount');

        return view('superadmin.salaries.index', compact('salaries', 'total'));
    }

    public function create()
    {
        $profiles = Profile::all();
        return view('superadmin.salaries.create', compact('profiles'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'profile_id' => 'required|exists:profiles,id',
        'amount' => 'required|numeric|min:0',
        'salary_month' => 'required|date',
        'status' => 'required|in:pending,paid',
        'payment_method' => 'nullable|in:bank_transfer,cash,cheque,online',
        'notes' => 'nullable|string|max:500',
    ]);

    Salary::create([
        'profile_id' => $validated['profile_id'],
        'amount' => $validated['amount'],
        'salary_month' => $validated['salary_month'],
        'status' => $validated['status'],
        'payment_method' => $validated['payment_method'] ?? null,
        'notes' => $validated['notes'] ?? null,
    ]);

    $statusMessage = $validated['status'] == 'paid' ? 'paid successfully' : 'recorded as pending';
    
    return redirect()->route('superadmin.salary.index')
                     ->with('success', "Salary {$statusMessage}.");
}
     public function show($id)
{
    // Remove 'profile.department' from with() clause - load only profile
    $salary = Salary::with('profile')->findOrFail($id);
    
    // Add department information manually if needed
    $salary->profile->department_name = $this->getDepartmentName($salary->profile);
    
    return view('superadmin.salary.show', compact('salary'));
}

private function getDepartmentName($profile)
{
    // Check if profile has department_id
    if (isset($profile->department_id)) {
        return 'Department ' . $profile->department_id;
    }
    
    // Check if profile has department column
    if (isset($profile->department)) {
        return $profile->department;
    }
    
    return 'N/A';
}
    // SalaryController.php ඇතුලත
public function destroy($id)
{
    try {
        $salary = Salary::findOrFail($id);
        $salary->delete();
        
        return redirect()->route('superadmin.salary.index')
                         ->with('success', 'Salary record deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('superadmin.salary.index')
                         ->with('error', 'Error deleting salary record: ' . $e->getMessage());
    }
}
// SalaryController.php ඇතුලත

/**
 * Show the form for editing the specified salary.
 */
public function edit($id)
{
    // Find the salary record with profile
    $salary = Salary::with('profile')->findOrFail($id);
    
    // Get all profiles for dropdown
    $profiles = Profile::all();
    
    return view('superadmin.salary.edit', compact('salary', 'profiles'));
}

/**
 * Update the specified salary in storage.
 */
public function update(Request $request, $id)
{
    // Find the salary record
    $salary = Salary::findOrFail($id);
    
    // Validate the request
    $validated = $request->validate([
        'profile_id' => 'required|exists:profiles,id',
        'amount' => 'required|numeric|min:0',
        'salary_month' => 'required|date',
        'status' => 'required|in:pending,paid',
        'payment_method' => 'nullable|in:bank_transfer,cash,cheque,online',
        'notes' => 'nullable|string|max:500',
    ]);
    
    // Update the salary record
    $salary->update([
        'profile_id' => $validated['profile_id'],
        'amount' => $validated['amount'],
        'salary_month' => $validated['salary_month'],
        'status' => $validated['status'],
        'payment_method' => $validated['payment_method'] ?? null,
        'notes' => $validated['notes'] ?? null,
    ]);
    
    return redirect()->route('superadmin.salary.show', $salary->id)
                     ->with('success', 'Salary record updated successfully.');
}
}
