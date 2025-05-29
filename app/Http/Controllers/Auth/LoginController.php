<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = Profile::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid Username.']);
        }

        // Use plain password match if you're not hashing
        if ($user->password !== $request->password) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        // Store user info in session
        session([
            'employee_id' => $user->employee_id,
            'role' => $user->role,
            'name' => $user->full_name,
        ]);

        // Redirect based on category
        switch ($user->role) {
            case 'Super Admin':
                return redirect()->route('superadmin.dashboard');
            case 'Admin':
                return redirect()->route('layouts.admin');
            case 'Developer':
                return redirect()->route('developer.dashboard');
            case 'Marketing Manager':
                return redirect()->route('marketing.dashboard');
            case 'Project Manager':
                return redirect()->route('pm.dashboard');
            case 'qa':
                return redirect()->route('qa.dashboard');
            case 'ba':
                return redirect()->route('ba.dashboard');
            default:
                return redirect()->route('home');
        }
    }
}
