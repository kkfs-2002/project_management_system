<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ProjectController extends Controller
{
    public function index(Request $request)
{
    $month = $request->input('month', Carbon::now()->format('Y-m'));

    $projects = Project::when($month, function ($query, $month) {
        $query->whereMonth('start_date', Carbon::parse($month)->month)
              ->whereYear('start_date', Carbon::parse($month)->year);
    })->get();

    return view('superadmin.project.index', compact('projects', 'month'));
}

public function create()
{
    return view('superadmin.project.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string',
        'start_date' => 'required|date'
    ]);

    Project::create($request->only('name', 'type', 'start_date'));

    return redirect()->route('superadmin.project.index')->with('success', 'Project added.');
}


}
