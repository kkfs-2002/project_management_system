<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('layouts.admin');
    }

    public function create()
    {
        return view('admin.profile.create');
    }

   public function store(Request $request)
    {
        // Validate inputs (adjust rules as needed)
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


        // Save the data
        Profile::create($validated);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    //view part of profile
    public function index(Request $request)
    {
        $role = $request->get('role');

        $profiles = Profile::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->get();

        $roles = Profile::select('role')->distinct()->pluck('role');

        return view('admin.profile.index', compact('profiles', 'roles'));


        $profiles = Profile::all();
        return view('admin.profile.index', compact('profiles'));
    }

    //full View of profile 
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        return view('admin.profile.show', compact('profile'));
    }
}
