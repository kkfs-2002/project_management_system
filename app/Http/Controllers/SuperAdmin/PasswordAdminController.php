<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class PasswordAdminController extends Controller
{
    public function editSelf()
    {
        return view('superadmin.password.edit-self');
    }

public function updateSelf(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed',
    ]);

    /* ⿡ pull the value you stored in LoginController */
    $empCode = session('employee_id');      // ←  your key name

    if (!$empCode) {
        return back()->withErrors(['error' => 'User not logged in.']);
    }

    /* ⿢ find the profile by employee_id, not id */
    $user = Profile::where('employee_id', $empCode)->first();

    if (!$user) {
        return back()->withErrors(['error' => 'Profile not found.']);
    }

    /* ⿣ update password */
    $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Your password has been updated.');
}

    public function editOther(Profile $profile)
    {
        return view('superadmin.password.edit-other', compact('profile'));
    }

    public function updateOther(Request $request, Profile $profile)
    {
        

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $profile->password = Hash::make($request->password);
        $profile->save();

        return back()->with('success', 'Password updated for ' . $profile->full_name);
    }

    public function listEmployees()
{
   
    $employees = Profile::orderBy('full_name')->get();
    return view('superadmin.password.list', compact('employees'));
}

}



