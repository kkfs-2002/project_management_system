<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'employee_id' => 'required|string|unique:employees',
            'nic' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required',
            'profile_photo' => 'nullable|image',

            'phone' => 'required|string',
            'email' => 'required|email|unique:employees',
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',

            'department' => 'required|string',
            'job_title' => 'required|string',
            'employment_type' => 'required|string',
            'date_of_joining' => 'required|date',
            'employee_status' => 'required|string',
            'supervisor' => 'required|string',
            'work_location' => 'required|string',

            'username' => 'required|string|unique:employees',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
            'permissions' => 'nullable|array',

            'basic_salary' => 'required|numeric',
            'bank_account_number' => 'required|string',
            'bank_name' => 'required|string',
            'epf_etf_number' => 'nullable|string',
            'tax_code' => 'nullable|string',

            'resume' => 'nullable|file',
            'offer_letter' => 'nullable|file',
            'id_copy' => 'nullable|file',
            'signed_contract' => 'nullable|file',
            'certificates' => 'nullable|file',
        ]);

        // Handle file uploads
        $fileFields = ['profile_photo', 'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('uploads', 'public');
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['permissions'] = json_encode($request->permissions);

        Employee::create($validated);

        return redirect()->back()->with('success', 'Employee added successfully.');
    }
}

