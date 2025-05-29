<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard(){
        return view('layouts.admin');
    }
public function create()
{
    return view('admin.profile.create');
}

public function store(Request $request)
{
    $data = $request->all();
    $data['password'] =$request->password;

    // Handle file uploads
    foreach (['profile_photo', 'resume', 'offer_letter', 'id_copy', 'signed_contract', 'certificates'] as $field) {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)->store('uploads', 'public');
        }
    }

    Profile::create($data);

    return redirect()->back()->with('success', 'Profile created successfully!');
}

public function index(Request $request)
{
  
    $role = $request->get('role');

    $profiles = Profile::when($role, function($query, $role) {
        return $query->where('role', $role);
    })->get();

    $roles = Profile::select('role')->distinct()->pluck('role');

    return view('admin.profile.index', compact('profiles', 'roles'));


    $profiles = Profile::all();
    return view('admin.profile.index', compact('profiles'));
}

public function show($id)
{
    $profile = Profile::findOrFail($id);
    return view('admin.profile.show', compact('profile'));
}

    
}
