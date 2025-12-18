<?php
namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Models\MarketingProject;
use App\Models\Profile;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MarketingProjectController extends Controller
{
    // Show the add marketing project form
    public function create()
    {
        $managers = Profile::where('role', 'Marketing Manager')->with('user')->get();
        return view('superadmin.clients.add', compact('managers'));
    }
   
    // Store new marketing project
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date' => 'required|date',
            'project_type' => 'required|string',
            'project_category' => 'required|string',
            'contact_method' => 'required|string',
            'call_sequence' => 'required|string|in:1st,2nd,3rd',
            'first_call_date' => 'nullable|date',
            'second_call_date' => 'nullable|date',
            'third_call_date' => 'nullable|date',
            'reminder_date' => 'nullable|date|after_or_equal:date',
            'comments' => 'required|string',
            'project_price' => 'required|numeric|min:0',
            'marketing_manager_id' => 'required|string|exists:profiles,employee_id',
        ]);

        // 🔴 CHECK DUPLICATE PHONE NUMBER WITH DIFFERENT MANAGER
        $existing = MarketingProject::where('phone_number', $validated['phone_number'])
            ->where('marketing_manager_id', '!=', $validated['marketing_manager_id'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This phone number was already added under another marketing manager.');
        }

        MarketingProject::create($validated);

        return redirect()->route('superadmin.clients.add')
            ->with('success', 'Marketing project added successfully!');
    }

    // Check for duplicate phone number with different manager
    public function checkPhone(Request $request)
    {
        $phone = $request->query('phone');
        $managerId = $request->query('manager_id');

        $existing = MarketingProject::where('phone_number', $phone)->first();
        if ($existing && $existing->marketing_manager_id != $managerId) {
            return response()->json([
                'exists' => true, 
                'existing_manager_id' => $existing->marketing_manager_id
            ]);
        }
        return response()->json(['exists' => false]);
    }
    
    // List all marketing projects with filters
    public function index(Request $request)
    {
        $managers = Profile::where('role', 'Marketing Manager')->with('user')->get();
        
        $query = MarketingProject::with('marketingManager.user');
        
        // Filter by marketing manager
        if ($request->filled('manager')) {
            $query->where('marketing_manager_id', $request->manager);
        }
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Filter by project type
        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        $projects = $query->orderBy('created_at', 'desc')->get();
        return view('superadmin.marketing.projects.index', compact('projects', 'managers'));
    }
    
    // Show edit form
    public function edit($id)
    {
        $project = MarketingProject::findOrFail($id);
        $managers = Profile::where('role', 'Marketing Manager')->with('user')->get();
        
        return view('superadmin.marketing.projects.edit', compact('project', 'managers'));
    }
    
    // Update project
    public function update(Request $request, $id)
    {
        $project = MarketingProject::findOrFail($id);
        
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date' => 'required|date',
            'project_type' => 'required|string',
            'project_category' => 'required|string',
            'contact_method' => 'required|string',
            'call_sequence' => 'required|string|in:1st,2nd,3rd',
            'first_call_date' => 'nullable|date',
            'second_call_date' => 'nullable|date',
            'third_call_date' => 'nullable|date',
            'reminder_date' => 'nullable|date|after_or_equal:date',
            'comments' => 'required|string',
            'project_price' => 'required|numeric|min:0',
            'marketing_manager_id' => 'required|string|exists:profiles,employee_id',
            'status' => 'required|in:pending,in_progress,completed,hold,cancelled',
        ]);
        
        // Check duplicate phone number for different manager (excluding current project)
        $existing = MarketingProject::where('phone_number', $validated['phone_number'])
            ->where('marketing_manager_id', '!=', $validated['marketing_manager_id'])
            ->where('id', '!=', $id)
            ->first();
        
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This phone number was already added under another marketing manager.');
        }
        
        $project->update($validated);
        
        return redirect()->route('superadmin.marketing.projects.index')
            ->with('success', 'Project updated successfully!');
    }
    
    // Delete project
    public function destroy($id)
    {
        $project = MarketingProject::findOrFail($id);
        $project->delete();
        
        return redirect()->route('superadmin.marketing.projects.index')
            ->with('success', 'Project deleted successfully!');
    }
    
    // Update project status
    public function updateStatus(Request $request, $id)
    {
        $project = MarketingProject::findOrFail($id);
        
        // Check if project is within 30 days
        $createdDate = Carbon::parse($project->created_at);
        $currentDate = Carbon::now();
        $daysDifference = $createdDate->diffInDays($currentDate);
        if ($daysDifference > 30) {
            return redirect()->route('superadmin.marketing.projects.index')
                ->with('error', 'Status can only be changed within 30 days of project creation.');
        }
        $request->validate([
            'status' => 'required|in:hold,completed'
        ]);
        $project->status = $request->status;
        $project->save();
        return redirect()->route('superadmin.marketing.projects.index')
            ->with('success', 'Project status updated successfully!');
    }
}