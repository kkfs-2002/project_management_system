<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Create a new controller instance and apply middleware.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->category) {
                case 'superadmin':
                    return redirect('/superadmin/dashboard');
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'web developer':
                    return redirect('/developer/dashboard');
                case 'marketing':
                    return redirect('/marketing/dashboard');
                case 'pm':
                    return redirect('/pm/dashboard');
                case 'qa':
                    return redirect('/qa/dashboard');
                case 'ba':
                    return redirect('/ba/dashboard');
                default:
                    return redirect('/login')->with('error', 'Invalid role.');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
}
