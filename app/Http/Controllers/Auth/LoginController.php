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
            return back()->withErrors(['email' => 'Email not found.']);
        }

        // Use plain password match if you're not hashing
        if ($user->password !== $request->password) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        // Store user info in session
        session([
            'user_id' => $user->id,
            'category' => $user->category,
            'name' => $user->full_name,
        ]);

        // Redirect based on category
        switch ($user->category) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'web developer':
                return redirect()->route('developer.dashboard');
            case 'marketing':
                return redirect()->route('marketing.dashboard');
            case 'pm':
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
