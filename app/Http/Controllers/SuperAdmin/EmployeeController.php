<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Models\Profile;
use App\Models\DailyTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('superadmin.employee.create');
    }
    
    public function store(Request $request)
    {
        try {
            // Validate inputs
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'employee_id' => 'required|string|max:100|unique:profiles,employee_id',
                'nic' => 'required|string|max:50',
                'dob' => 'required|date',
                'gender' => 'required|string|max:20',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:profiles,email',
                'address' => 'required|string',
                'emergency_contact_name' => 'required|string|max:255',
                'emergency_contact_phone' => 'required|string|max:20',
                'department' => 'required|string|max:100',
                'job_title' => 'required|string|max:100',
                'employment_type' => 'required|string|max:100',
                'date_of_joining' => 'required|date',
                'employee_status' => 'required|string|max:50',
                'supervisor' => 'required|string|max:255',
                'work_location' => 'required|string|max:255',
                'username' => 'required|string|max:50|unique:profiles,username',
                'role' => 'required|string|max:50',
                'password' => 'required|string|min:6',
                'basic_salary' => 'required|numeric',
                'bank_account_number' => 'required|string|max:50',
                'bank_name' => 'required|string|max:100',
                'epf_etf_number' => 'nullable|string|max:50',
                'tax_code' => 'nullable|string|max:50',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'offer_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'id_copy' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
                'signed_contract' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'certificates' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            ]);

            // Handle file uploads
            $files = ['profile_photo', 'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates'];
            foreach ($files as $fileField) {
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $filename = time().'_'.Str::random(6).'_'.$file->getClientOriginalName();
                    $path = $file->storeAs('uploads/employees', $filename, 'public');
                    $validated[$fileField] = $path;
                } else {
                    $validated[$fileField] = null;
                }
            }

            // Save the data (password will be plain text)
            $profile = Profile::create($validated);

            if ($profile) {
                return redirect()->back()->with('success', 'Employee added successfully!');
            }
            
            return redirect()->back()->withErrors(['error' => 'Failed to create employee'])->withInput();
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function index(Request $request)
{
    $jobTitle = $request->query('job_title');
    
    // Get all unique job titles for the dropdown
    $jobTitles = Profile::select('job_title')->distinct()->pluck('job_title');

    // Filter employees if job_title is selected
    $employees = Profile::when($jobTitle, function ($query, $jobTitle) {
        return $query->where('job_title', $jobTitle);
    })->orderBy('full_name')->paginate(10);

    return view('superadmin.employee.index', compact('employees', 'jobTitles', 'jobTitle'));
}


public function show($id)
{
    $employee = Profile::findOrFail($id);
    return view('superadmin.employee.show', compact('employee'));
}

public function edit($id)
{
    $employee = Profile::findOrFail($id);
    return view('superadmin.employee.edit', compact('employee'));
}

public function update(Request $request, $id)
{
    $employee = Profile::findOrFail($id);

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'employee_id' => "required|string|max:100|unique:profiles,employee_id,$id",
        'email' => "required|email|max:255|unique:profiles,email,$id",
        'phone' => 'required|string|max:20',
        'department' => 'required|string|max:100',
        'job_title' => 'required|string|max:100',
        
    ]);

    $employee->update($validated);

    return redirect()->route('superadmin.employee.index')->with('success', 'Employee updated successfully!');
}

public function destroy($id)
{
    $employee = Profile::findOrFail($id);

    // Delete files if exists
    $files = ['profile_photo', 'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates'];
    foreach ($files as $fileField) {
        if ($employee->$fileField) {
            Storage::disk('public')->delete($employee->$fileField);
        }
    }

    $employee->delete();

    return redirect()->route('superadmin.employee.index')->with('success', 'Employee deleted successfully!');
}


public function view(Request $request)
{
    $date = $request->get('date', date('Y-m-d'));
    $employeeId = $request->get('employee_id');
    $status = $request->get('status');
    $taskType = $request->get('task_type');
    $priority = $request->get('priority');

    $query = DailyTask::with(['profile', 'assignedBy']);

    if ($date) {
        $query->whereDate('task_date', $date);
    }

    if ($employeeId) {
        $query->where('profile_id', $employeeId);
    }

    if ($status) {
        $query->where('status', $status);
    }

    if ($taskType) {
        $query->where('task_type', $taskType);
    }

    if ($priority) {
        $query->where('priority', $priority);
    }

    $tasks = $query->orderBy('task_date', 'desc')
                  ->orderBy('priority', 'desc')
                  ->paginate(20);

    // Get employees - filter by both role and job_title to catch all relevant employees
    $employees = Profile::where(function($query) {
        $query->whereIn('role', [
                'Senior Developer', 
                'Junior Developer', 
                'Developer', // Add this to catch employee #2
                'Intern/Trainee', 
                'Marketing Manager', 
                'Project Manager',
                'Admin', // Add this to catch employee #2
                'Super Admin' // Add this to catch employee #1
            ])
            ->orWhereIn('job_title', [
                'Senior Developer', 
                'Junior Developer', 
                'Intern/Trainee', 
                'Marketing Manager', 
                'Project Manager'
            ]);
    })
    ->orderBy('full_name')
    ->get();

    return view('superadmin.employee.view', compact(
        'tasks', 
        'employees', 
        'date', 
        'employeeId', 
        'status',
        'taskType',
        'priority'
    ));
}
}

