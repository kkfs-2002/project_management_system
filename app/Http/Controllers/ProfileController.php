<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'nic' => 'required|unique:profiles',
            'category' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:profiles',
            'password' => 'required',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Define username prefixes based on category
        $usernamePrefix = [
            'web developer' => 'web',
            'marketing' => 'mkt',
            'pm' => 'pm',
            'qa' => 'qa',
            'ba' => 'ba'
        ];

        $prefix = $usernamePrefix[$request->category] ?? 'user';

        // Get the last username with the same prefix
        $lastUser = Profile::where('username', 'like', $prefix . '%')
                        ->orderBy('username', 'desc')
                        ->first();

        if ($lastUser) {
            $lastNumber = (int) substr($lastUser->username, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format username to have 3 digits (e.g., web001)
        $username = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Handle profile picture upload
        $filename = null;
        if ($request->hasFile('profile_picture')) {
            $filename = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $request->file('profile_picture')->move(public_path('uploads'), $filename);
        }

        // Create the profile
        Profile::create([
            'full_name' => $request->full_name,
            'nic' => $request->nic,
            'category' => $request->category,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password, 
            'username' => $username,
            'profile_picture' => $filename,
        ]);

        return redirect()->route('profile.index');
    }

   public function index(Request $request)
{
    // Start a query builder for Profile model
    $query = Profile::query();

    // If a category is selected and not empty, filter profiles by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Get the filtered or all profiles
    $profiles = $query->get();

    // Pass profiles and the selected category back to the view (optional for keeping filter selected)
    return view('admin.profile.index', [
        'profiles' => $profiles,
        'selectedCategory' => $request->category ?? '',
    ]);
}

    
}
