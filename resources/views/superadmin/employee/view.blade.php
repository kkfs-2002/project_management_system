@extends('layouts.app')

@section('title', 'Daily Tasks Management')

@section('content')
<style>
    :root {
        --primary: #2c5aa0;
        --primary-light: #e8eff7;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --light: #f8f9fa;
        --dark: #343a40;
        --border: #dee2e6;
        --shadow: 0 4px 12px rgba(0,0,0,0.08);
        --radius: 12px;
    }
    
    .tasks-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, #1e3d72 100%);
        border-radius: var(--radius);
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        margin-top: 50px;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(60px, -60px);
    }
    
    .page-title {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }
    
    .page-title i {
        font-size: 40px;
        background: rgba(255,255,255,0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    .page-title h1 {
        margin: 0;
        font-weight: 700;
        font-size: 32px;
    }
    
    .page-title p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 16px;
    }
    
    /* Summary Cards */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .summary-card {
        background: white;
        border-radius: var(--radius);
        padding: 25px;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary);
        transition: all 0.3s ease;
        
    }
    
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .summary-card.total { border-left-color: var(--primary); }
    .summary-card.completed { border-left-color: var(--success); }
    .summary-card.progress { border-left-color: var(--warning); }
    .summary-card.pending { border-left-color: var(--info); }
    
    .summary-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .summary-text h3 {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .summary-text .number {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    
    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .summary-card.total .summary-icon { background: var(--primary-light); color: var(--primary); }
    .summary-card.completed .summary-icon { background: #e8f5e8; color: var(--success); }
    .summary-card.progress .summary-icon { background: #fff8e1; color: var(--warning); }
    .summary-card.pending .summary-icon { background: #e3f2fd; color: var(--info); }
    
    /* Employee Summary Section */
    .section-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .section-header {
        background: var(--primary-light);
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
    }
    
    .section-header h2 {
        margin: 0;
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .employee-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
        padding: 25px;
    }
    
    .employee-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        transition: all 0.3s ease;
    }
    
    .employee-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .employee-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .employee-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
    }
    
    .employee-info h4 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: var(--dark);
    }
    
    .employee-info .employee-id {
        color: var(--secondary);
        font-size: 13px;
    }
    
    .employee-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        text-align: center;
        margin-bottom: 15px;
        padding: 15px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }
    
    .stat-item .number {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-item.total .number { color: var(--primary); }
    .stat-item.completed .number { color: var(--success); }
    .stat-item.pending .number { color: var(--warning); }
    
    .stat-item .label {
        font-size: 12px;
        color: var(--secondary);
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .progress-section {
        margin-top: 10px;
    }
    
    .progress-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .progress-label span {
        font-size: 13px;
        font-weight: 600;
    }
    
    .progress-bar-container {
        height: 8px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--success), #4cd964);
        border-radius: 10px;
        transition: width 0.5s ease;
    }
    
    /* Filters Section */
    .filters-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .filters-form {
        padding: 25px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background: #1e3d72;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: white;
    }
    
    .btn-outline {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    .btn-outline:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--primary);
    }
    
    /* Tasks Table */
    .table-container {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: var(--light);
        border-bottom: 1px solid var(--border);
    }
    
    .table-header h2 {
        margin: 0;
        color: var(--dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-info {
        color: var(--secondary);
        font-size: 14px;
        font-weight: 500;
    }
    
    .tasks-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tasks-table thead {
        background: var(--light);
    }
    
    .tasks-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 2px solid var(--border);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .tasks-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .tasks-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .tasks-table tbody tr:hover {
        background: var(--primary-light);
    }
    
    .employee-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .employee-avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    .employee-details h6 {
        margin: 0;
        font-weight: 600;
        color: var(--dark);
    }
    
    .employee-details small {
        color: var(--secondary);
        font-size: 12px;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge-type { background: #e3f2fd; color: #1565c0; }
    .badge-priority-low { background: #e8f5e8; color: #2e7d32; }
    .badge-priority-medium { background: #fff8e1; color: #f57f17; }
    .badge-priority-high { background: #ffebee; color: #c62828; }
    .badge-priority-urgent { background: #fce4ec; color: #ad1457; }
    .badge-status-pending { background: #fff3cd; color: #856404; }
    .badge-status-in_progress { background: #cce7ff; color: #004085; }
    .badge-status-completed { background: #d4edda; color: #155724; }
    .badge-status-verified { background: #d1ecf1; color: #0c5460; }
    
    .progress-cell {
        min-width: 120px;
    }
    
    .progress-display {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .progress-bar-sm {
        flex: 1;
        height: 8px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }
    
    .progress-text {
        font-size: 12px;
        font-weight: 600;
        min-width: 40px;
        text-align: right;
    }
    
    .action-buttons {
        display: flex;
        gap: 6px;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 12px;
    }
    
    .btn-view { background: var(--info); color: white; }
    .btn-edit { background: var(--warning); color: white; }
    .btn-verify { background: var(--success); color: white; }
    .btn-disabled { background: var(--secondary); color: white; opacity: 0.6; }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    /* Modal Forms - Fixed Size */
    .modal-content {
        border-radius: var(--radius);
        border: none;
        box-shadow: 0 10px 50px rgba(0,0,0,0.2);
    }
    
    .modal-header {
        background: var(--primary);
        color: white;
        border-radius: var(--radius) var(--radius) 0 0;
        padding: 20px 25px;
        border-bottom: none;
    }
    
    .modal-title {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-close-white {
        filter: invert(1);
    }
    
    .modal-body {
        padding: 25px;
        max-height: 60vh;
        overflow-y: auto;
    }
    
    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid var(--border);
        background: var(--light);
        border-radius: 0 0 var(--radius) var(--radius);
    }
    
    /* Fixed Form Sizes */
    .progress-form {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .progress-form .row {
        margin-bottom: 20px;
    }
    
    .progress-form .form-group {
        margin-bottom: 20px;
    }
    
    .progress-form label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
        display: block;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .details-section {
        margin-bottom: 25px;
    }
    
    .details-section h6 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--primary-light);
    }
    
    .details-table {
        width: 100%;
    }
    
    .details-table td {
        padding: 8px 0;
        vertical-align: top;
    }
    
    .details-table .label {
        font-weight: 600;
        color: var(--dark);
        width: 40%;
        padding-right: 15px;
    }
    
    .details-table .value {
        color: var(--secondary);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--secondary);
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .empty-state h5 {
        margin-bottom: 10px;
        color: var(--dark);
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: var(--light);
        border-top: 1px solid var(--border);
    }
    
    .pagination-info {
        color: var(--secondary);
        font-size: 14px;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .page-title {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            justify-content: stretch;
        }
        
        .form-actions .btn {
            flex: 1;
            justify-content: center;
        }
        
        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .pagination-container {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .employee-grid {
            grid-template-columns: 1fr;
        }
        
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="tasks-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-tasks"></i>
            <div>
                <h1>Daily Tasks Management</h1>
                <p>Monitor and manage employee daily tasks efficiently</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card total">
            <div class="summary-content">
                <div class="summary-text">
                    <h3>Total Tasks</h3>
                    <p class="number">{{ $tasks->total() }}</p>
                </div>
                <div class="summary-icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>
        
        <div class="summary-card completed">
            <div class="summary-content">
                <div class="summary-text">
                    <h3>Completed Tasks</h3>
                    <p class="number">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
                <div class="summary-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="summary-card progress">
            <div class="summary-content">
                <div class="summary-text">
                    <h3>In Progress</h3>
                    <p class="number">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="summary-icon">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>
        
        <div class="summary-card pending">
            <div class="summary-content">
                <div class="summary-text">
                    <h3>Pending Verification</h3>
                    <p class="number">{{ $tasks->where('status', 'completed')->where('verified', false)->count() }}</p>
                </div>
                <div class="summary-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Summary Section -->
    <div class="section-card">
        <div class="section-header">
            <h2><i class="fas fa-users"></i> Employee Summary</h2>
        </div>
        <div class="employee-grid">
            @php
                $employeeStats = [];
                foreach($employees as $employee) {
                    $employeeTasks = $tasks->where('profile_id', $employee->id);
                    $completedTasks = $employeeTasks->where('status', 'completed')->count();
                    $inProgressTasks = $employeeTasks->where('status', 'in_progress')->count();
                    $pendingTasks = $employeeTasks->where('status', 'pending')->count();
                    $totalTasks = $employeeTasks->count();
                    
                    $employeeStats[] = [
                        'employee' => $employee,
                        'total_tasks' => $totalTasks,
                        'completed_tasks' => $completedTasks,
                        'in_progress_tasks' => $inProgressTasks,
                        'pending_tasks' => $pendingTasks,
                        'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0
                    ];
                }
            @endphp
            
            @foreach($employeeStats as $stat)
            <div class="employee-card">
                <div class="employee-header">
                    <div class="employee-avatar">
                        {{ substr($stat['employee']->full_name, 0, 1) }}
                    </div>
                    <div class="employee-info">
                        <h4>{{ $stat['employee']->full_name }}</h4>
                        <div class="employee-id">{{ $stat['employee']->employee_id }}</div>
                    </div>
                </div>
                
                <div class="employee-stats">
                    <div class="stat-item total">
                        <div class="number">{{ $stat['total_tasks'] }}</div>
                        <div class="label">Total</div>
                    </div>
                    <div class="stat-item completed">
                        <div class="number">{{ $stat['completed_tasks'] }}</div>
                        <div class="label">Done</div>
                    </div>
                    <div class="stat-item pending">
                        <div class="number">{{ $stat['in_progress_tasks'] + $stat['pending_tasks'] }}</div>
                        <div class="label">Pending</div>
                    </div>
                </div>
                
                <div class="progress-section">
                    <div class="progress-label">
                        <span>Completion Rate</span>
                        <span>{{ $stat['completion_rate'] }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ $stat['completion_rate'] }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-card">
        <div class="section-header">
            <h2><i class="fas fa-filter"></i> Filter Tasks</h2>
        </div>
        <div class="filters-form">
            <form method="GET">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" value="{{ $date ?? today()->format('Y-m-d') }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Employee</label>
                        <select name="employee_id" class="form-control">
                            <option value="">All Employees</option>
                            @if(isset($employees) && $employees->count() > 0)
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ (request('employee_id') == $emp->id || ($employeeId ?? '') == $emp->id) ? 'selected' : '' }}>
                                        {{ $emp->full_name }} 
                                        @if($emp->employee_id)
                                            ({{ $emp->employee_id }})
                                        @endif
                                    </option>
                                @endforeach
                            @else
                                <option value="">No employees available</option>
                            @endif
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Task Type</label>
                        <select name="task_type" class="form-control">
                            <option value="">All Types</option>
                            <option value="Senior Developer" {{ ($taskType ?? '') == 'Senior Developer' ? 'selected' : '' }}>Senior Developer</option>
                            <option value="Junior Developer" {{ ($taskType ?? '') == 'Junior Developer' ? 'selected' : '' }}>Junior Developer</option>
                            <option value="Intern/Trainee" {{ ($taskType ?? '') == 'Intern/Trainee' ? 'selected' : '' }}>Intern/Trainee</option>
                            <option value="Marketing Manager" {{ ($taskType ?? '') == 'Marketing Manager' ? 'selected' : '' }}>Marketing Manager</option>
                            <option value="Project Manager" {{ ($taskType ?? '') == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Priority</label>
                        <select name="priority" class="form-control">
                            <option value="">All Priorities</option>
                            <option value="low" {{ ($priority ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ ($priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ ($priority ?? '') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ ($priority ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ ($status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ ($status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="verified" {{ ($status ?? '') == 'verified' ? 'selected' : '' }}>Verified</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('superadmin.employee.view') }}" class="btn btn-outline">
                        <i class="fas fa-redo"></i> Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="table-container">
        <div class="table-header">
            <h2><i class="fas fa-list"></i> Task List</h2>
            <div class="table-info">
                Showing {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Task Date</th>
                        <th>Task Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Time</th>
                        <th>Progress</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>
                            <div class="employee-cell">
                                <div class="employee-avatar-sm">
                                    {{ substr($task->profile->full_name, 0, 1) }}
                                </div>
                                <div class="employee-details">
                                    <h6>{{ $task->profile->full_name }}</h6>
                                    <small>{{ $task->profile->employee_id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-bold">{{ $task->task_date->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $task->task_date->format('D') }}</small>
                            </div>
                        </td>
                        <td class="fw-bold">{{ Str::limit($task->task_name, 25) }}</td>
                        <td>
                            @if($task->description)
                            <button class="btn-action btn-view" data-bs-toggle="modal" 
                                    data-bs-target="#descriptionModal{{ $task->id }}" title="View Description">
                                <i class="fas fa-eye"></i>
                            </button>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-type">
                                <i class="fas fa-tag"></i>
                                {{ ucfirst($task->task_type) }}
                            </span>
                        </td>
                        <td>
                            <div class="small">
                                @if($task->start_time)
                                    <div><i class="fas fa-play text-success me-1"></i>{{ $task->start_time->format('H:i') }}</div>
                                @else
                                    <div class="text-muted">Not started</div>
                                @endif
                                
                                @if($task->end_time)
                                    <div><i class="fas fa-stop text-danger me-1"></i>{{ $task->end_time->format('H:i') }}</div>
                                @else
                                    <div class="text-muted">Not completed</div>
                                @endif
                            </div>
                        </td>
                        <td class="progress-cell">
                            @php
                                $progress = $task->target_count > 0 ? ($task->completed_count / $task->target_count) * 100 : 0;
                                $progressColor = $progress >= 100 ? 'background: var(--success);' : ($progress >= 50 ? 'background: var(--primary);' : 'background: var(--warning);');
                            @endphp
                            <div class="progress-display">
                                <div class="progress-bar-sm">
                                    <div class="progress-fill" style="width: {{ $progress }}%; {{ $progressColor }}"></div>
                                </div>
                                <div class="progress-text">{{ $task->completed_count }}/{{ $task->target_count }}</div>
                            </div>
                        </td>
                        <td>
                            @php
                                $priorityClasses = [
                                    'low' => 'badge-priority-low',
                                    'medium' => 'badge-priority-medium', 
                                    'high' => 'badge-priority-high',
                                    'urgent' => 'badge-priority-urgent'
                                ];
                                $priorityIcons = [
                                    'low' => 'arrow-down',
                                    'medium' => 'minus',
                                    'high' => 'arrow-up',
                                    'urgent' => 'exclamation-triangle'
                                ];
                            @endphp
                            <span class="badge {{ $priorityClasses[$task->priority] }}">
                                <i class="fas fa-{{ $priorityIcons[$task->priority] }}"></i>
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'badge-status-pending',
                                    'in_progress' => 'badge-status-in_progress',
                                    'completed' => 'badge-status-completed',
                                    'verified' => 'badge-status-verified'
                                ];
                                $statusIcons = [
                                    'pending' => 'clock',
                                    'in_progress' => 'spinner',
                                    'completed' => 'check-circle',
                                    'verified' => 'check-double'
                                ];
                                $statusText = [
                                    'pending' => 'Pending',
                                    'in_progress' => 'In Progress',
                                    'completed' => 'Completed',
                                    'verified' => 'Verified'
                                ];
                                
                                $currentStatus = $task->status;
                                $isVerified = $task->verified ?? false;
                                
                                if ($isVerified && $currentStatus === 'completed') {
                                    $currentStatus = 'verified';
                                }
                            @endphp
                            <span class="badge {{ $statusClasses[$currentStatus] }}">
                                <i class="fas fa-{{ $statusIcons[$currentStatus] }}"></i>
                                {{ $statusText[$currentStatus] }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- View Details Button -->
                                <button class="btn-action btn-view" data-bs-toggle="modal" 
                                        data-bs-target="#detailsModal{{ $task->id }}" title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                
                                <!-- Edit Progress Button -->
                                <button class="btn-action btn-edit" data-bs-toggle="modal" 
                                        data-bs-target="#progressModal{{ $task->id }}" title="Update Progress">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                @if($task->status == 'completed' && !($task->verified ?? false))
                                <button class="btn-action btn-verify" onclick="verifyTask({{ $task->id }})" title="Verify Task">
                                    <i class="fas fa-check-double"></i>
                                </button>
                                @endif

                                @if($task->status == 'completed' && ($task->verified ?? false))
                                <button class="btn-action btn-disabled" title="Verified" disabled>
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                @endif
                            </div>

                            <!-- Task Details Modal -->
                            <div class="modal fade" id="detailsModal{{ $task->id }}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-info-circle"></i>Task Details
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="details-grid">
                                                <div class="details-section">
                                                    <h6>Basic Information</h6>
                                                    <table class="details-table">
                                                        <tr>
                                                            <td class="label">Task Name:</td>
                                                            <td class="value">{{ $task->task_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Employee:</td>
                                                            <td class="value">
                                                                <div class="employee-cell">
                                                                    <div class="employee-avatar-sm">
                                                                        {{ substr($task->profile->full_name, 0, 1) }}
                                                                    </div>
                                                                    <div class="employee-details">
                                                                        <h6>{{ $task->profile->full_name }}</h6>
                                                                        <small>{{ $task->profile->employee_id }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Task Date:</td>
                                                            <td class="value">{{ $task->task_date->format('M d, Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Task Type:</td>
                                                            <td class="value">
                                                                <span class="badge badge-type">{{ ucfirst($task->task_type) }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Priority:</td>
                                                            <td class="value">
                                                                <span class="badge {{ $priorityClasses[$task->priority] }}">
                                                                    {{ ucfirst($task->priority) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                
                                                <div class="details-section">
                                                    <h6>Progress Information</h6>
                                                    <table class="details-table">
                                                        <tr>
                                                            <td class="label">Target Count:</td>
                                                            <td class="value">{{ $task->target_count }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Completed Count:</td>
                                                            <td class="value">
                                                                <span class="fw-bold {{ $task->completed_count >= $task->target_count ? 'text-success' : 'text-warning' }}">
                                                                    {{ $task->completed_count }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Progress:</td>
                                                            <td class="value">
                                                                <div class="progress-display">
                                                                    <div class="progress-bar-sm">
                                                                        <div class="progress-fill" style="width: {{ $progress }}%; {{ $progressColor }}"></div>
                                                                    </div>
                                                                    <div class="progress-text">{{ number_format($progress, 1) }}%</div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Status:</td>
                                                            <td class="value">
                                                                <span class="badge {{ $statusClasses[$currentStatus] }}">
                                                                    {{ $statusText[$currentStatus] }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Verified:</td>
                                                            <td class="value">
                                                                @if($task->verified ?? false)
                                                                    <span class="badge badge-status-completed">Yes</span>
                                                                @else
                                                                    <span class="badge badge-status-pending">No</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Start Time:</td>
                                                            <td class="value">
                                                                @if($task->start_time)
                                                                    {{ $task->start_time->format('h:i A') }}
                                                                @else
                                                                    <span class="text-muted">Not started</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">End Time:</td>
                                                            <td class="value">
                                                                @if($task->end_time)
                                                                    {{ $task->end_time->format('h:i A') }}
                                                                @else
                                                                    <span class="text-muted">Not completed</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            @if($task->description)
                                            <div class="details-section">
                                                <h6>Description</h6>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $task->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($task->notes)
                                            <div class="details-section">
                                                <h6>Additional Notes</h6>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $task->notes }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#progressModal{{ $task->id }}">
                                                <i class="fas fa-edit"></i>Update Progress
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Only Modal -->
                            @if($task->description)
                            <div class="modal fade" id="descriptionModal{{ $task->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-file-alt"></i>Task Description
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">{{ $task->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Progress Update Modal - Fixed Size -->
                            <div class="modal fade" id="progressModal{{ $task->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('superadmin.daily-tasks.update-progress', $task->id) }}" method="POST" class="progress-form">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-edit"></i>Update Task Progress
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Completed Count</label>
                                                            <input type="number" name="completed_count" 
                                                                   value="{{ $task->completed_count }}" 
                                                                   min="0" max="{{ $task->target_count }}"
                                                                   class="form-control" required>
                                                            <small class="text-muted">Target: {{ $task->target_count }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Start Time</label>
                                                            <input type="time" name="start_time" 
                                                                   value="{{ $task->start_time ? $task->start_time->format('H:i') : '' }}"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>End Time</label>
                                                            <input type="time" name="end_time" 
                                                                   value="{{ $task->end_time ? $task->end_time->format('H:i') : '' }}"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Actual Time (HH:MM)</label>
                                                    <input type="time" name="actual_time" 
                                                           value="{{ $task->actual_time ? $task->actual_time->format('H:i') : '' }}"
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Notes</label>
                                                    <textarea name="notes" class="form-control" rows="3" 
                                                              placeholder="Add any additional notes or comments...">{{ $task->notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Task</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h5>No tasks found</h5>
                                <p>Try adjusting your filters or create a new task.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
            </div>
            <div>
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function verifyTask(taskId) {
    if (confirm('Are you sure you want to verify this task?')) {
        fetch(`/superadmin/daily-tasks/${taskId}/verify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error verifying task');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Error verifying task');
        });
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection