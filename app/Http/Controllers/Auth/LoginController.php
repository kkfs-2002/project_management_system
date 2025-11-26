<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'password' => 'required',
        ]);

        // Find by email
        $user = Profile::where('email', $request->email)->first();

        if (!$user || $user->password !== $request->password) {  // Plain text comparison
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }

        // Log in via Laravel Auth (sets session/cookies)
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Store extras in session if needed (e.g., for quick access)
        session([
            'employee_id' => $user->employee_id,
            'role' => $user->role,
            'name' => $user->full_name,
        ]);

        // Redirect based on role
        return match ($user->role) {  // PHP 8+ match for cleaner switch
            'Super Admin' => redirect()->route('superadmin.dashboard'),
            'Admin' => redirect()->route('layouts.admin'),
            'Developer' => redirect()->route('layouts.developer'),
            'Marketing Manager' => redirect()->route('marketing.dashboard'),
            'Project Manager' => redirect()->route('layouts.projectmanager'),
            default => redirect()->route('home'),
        };
    }
}