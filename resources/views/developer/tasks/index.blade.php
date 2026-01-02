<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Developer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        /* Your existing header and footer styles remain unchanged */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #000000;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, .2);
            z-index: 1050;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-toggle {
            color: #fff;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .dropdown-toggle:hover {
            color: #FFD700 !important;
        }
        .dropdown-menu {
            background-color: #111;
            border: none;
        }
        .dropdown-item {
            color: #f1f1f1;
            padding: 10px 20px;
            font-size: .95rem;
        }
        .dropdown-item:hover {
            background-color: #222;
            color: #FFD700;
        }

        /* Footer */
        .footer {
            background: #000000 url('{{ asset("images/fo.jpg") }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 50px 0 20px;
            position: relative;
            margin-top: 60px;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 0;
        }

        .footer > * {
            position: relative;
            z-index: 1;
        }

        .footer a {
            color: #00c6ff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #ffdd00;
        }

        .footer h5 {
            color: #A7C7E7;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .footer p {
            color: #b0b0b0;
            line-height: 1.6;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .footer-links a:hover {
            color: #A7C7E7;
            transform: translateX(5px);
        }
        
        .footer-links a i {
            margin-right: 8px;
            font-size: 0.9rem;
        }
        
        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .contact-info li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .contact-info i {
            color: #A7C7E7;
            margin-right: 10px;
            margin-top: 3px;
            font-size: 1rem;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #A7C7E7;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(167, 199, 231, 0.3);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
        }
        
        .footer-bottom p {
            margin: 0;
            color: #888;
            font-size: 0.9rem;
        }
        
        .company-logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        /* =========== NEW PROFESSIONAL STYLES =========== */
        
        /* Main Content Container */
        .main-content {
            min-height: calc(100vh - 300px);
            padding: 120px 0 40px;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #eef2f7;
            transition: all 0.3s ease;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .dashboard-card .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .dashboard-card .card-icon.task {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .dashboard-card .card-icon.completed {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .dashboard-card .card-icon.pending {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .dashboard-card h4 {
            color: #1a1a2e;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .dashboard-card p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* Enhanced Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            color: white;
        }

        .filter-section h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-section h5 i {
            color: #FFD700;
        }

        .filter-section .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .filter-section .form-select,
        .filter-section .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .filter-section .form-select:focus,
        .filter-section .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #FFD700;
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            color: white;
        }

        .filter-section option {
            background: #020d1fff;
            color: white;
        }

        /* Enhanced Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            border: none;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #010e21ff 0%, #00c6ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 198, 255, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1ba87e 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        /* Enhanced Table */
        .task-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .task-table thead {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
        }

        .task-table th {
            padding: 18px 20px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            position: relative;
        }

        .task-table th:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .task-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .task-table tbody tr:last-child {
            border-bottom: none;
        }

        .task-table tbody tr:hover {
            background: linear-gradient(90deg, rgba(0, 198, 255, 0.05) 0%, rgba(255, 215, 0, 0.05) 100%);
            transform: translateY(-1px);
        }

        .task-table td {
            padding: 16px 20px;
            vertical-align: middle;
            border: none;
        }

        /* Enhanced Badges */
        .badge {
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 20px;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            min-width: 100px;
            justify-content: center;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            color: white;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%) !important;
            color: white;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #FFD700 0%, #ffb347 100%) !important;
            color: #212529;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eef2f7;
        }

        .page-header h1 {
            color: #020d1fff;
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #020d1fff 0%, #00c6ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Success Alert */
        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
            border: none;
            border-left: 4px solid #28a745;
            color: #155724;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .alert-success i {
            color: #28a745;
            font-size: 1.2rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #00c6ff;
        }

        .form-select, .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: #00c6ff;
            box-shadow: 0 0 0 0.3rem rgba(0, 198, 255, 0.15);
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #e0e0e0;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h5 {
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        /* Status Indicators */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-forwarded {
            background: rgba(0, 198, 255, 0.1);
            color: #00c6ff;
        }

        /* Date Display */
        .date-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 12px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .date-display i {
            color: #FFD700;
        }
    </style>
</head>
<body>
<!-- Your existing header remains unchanged -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('layouts.developer', $dev->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="Dev" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ $dev->full_name ?? 'Developer' }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#devNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="devNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer.dashboard', $developer->id ?? 1) }}">
                        <i class="fa fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer.tasks.index', $dev->id ?? 1) }}">
                        <i class="fa fa-tasks me-1"></i> My Tasks
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tasksDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-target me-1"></i> Day Updates Tasks 
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('developer.daily-tasks.index') }}">Daily Tasks</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="devDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-1"></i> {{ $dev->full_name ?? 'Account' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="devDropdown">
                        <li>
                            <form method="POST" action="{{ route('developer.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content - Professional Design -->
<div class="main-content">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Task Management Dashboard</h1>
            <p>Manage and track your assigned development tasks efficiently</p>
            <div class="date-display">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->format('F d, Y - h:i A') }}</span>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon task">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h4>{{ $tasks->count() }}</h4>
                    <p>Total Tasks Assigned</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon completed">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>{{ $tasks->where('status', 'Completed')->count() }}</h4>
                    <p>Completed Tasks</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>{{ $tasks->where('status', 'Forwarded')->count() }}</h4>
                    <p>Pending Tasks</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-section">
            <h5><i class="fas fa-filter"></i> Filter Tasks</h5>
            <form method="GET" action="{{ route('developer.tasks.index') }}">
                <div class="row g-4 align-items-end">
                    <div class="col-md-3">
                        <label for="project_id" class="form-label">
                            <i class="fas fa-project-diagram"></i> Project
                        </label>
                        <select name="project_id" id="project_id" class="form-select">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-tags"></i> Status
                        </label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="month" class="form-label">
                            <i class="fas fa-calendar"></i> Month
                        </label>
                        <input type="month" name="month" id="month" value="{{ request('month') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-1"></i> Apply Filters
                            </button>
                            <a href="{{ route('developer.tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Task Table -->
        <div class="table-responsive">
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Task Title</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $task->project->name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $task->title }}</div>
                                @if($task->description)
                                    <small class="text-muted">{{ Str::limit($task->description, 60) }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-play text-success"></i>
                                    <span>{{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-flag text-danger"></i>
                                    <span>{{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td>
                                @if($task->status === 'Completed')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Completed
                                    </span>
                                @elseif($task->status === 'Forwarded')
                                    <span class="badge bg-info">
                                        <i class="fas fa-forward me-1"></i> Forwarded
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i> {{ $task->status }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($task->status === 'Forwarded')
                                    <form action="{{ route('developer.tasks.complete', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check me-1"></i> Mark Complete
                                        </button>
                                    </form>
                                @else
                                    <span class="status-indicator status-completed">
                                        <i class="fas fa-check"></i> Completed
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-tasks"></i>
                                    <h5>No tasks found</h5>
                                    <p>No tasks match your current filter criteria</p>
                                    <a href="{{ route('developer.tasks.index') }}" class="btn btn-primary">
                                        <i class="fas fa-redo me-1"></i> Reset Filters
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Task Summary -->
        @if($tasks->count() > 0)
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Task Distribution</h5>
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <span>Completed Tasks</span>
                        </div>
                        <span class="fw-bold">{{ $tasks->where('status', 'Completed')->count() }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ ($tasks->where('status', 'Completed')->count() / $tasks->count()) * 100 }}%"></div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <span>Forwarded Tasks</span>
                        </div>
                        <span class="fw-bold">{{ $tasks->where('status', 'Forwarded')->count() }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: {{ ($tasks->where('status', 'Forwarded')->count() / $tasks->count()) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5 class="mb-3"><i class="fas fa-lightbulb me-2"></i>Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('developer.daily-tasks.index') }}" class="btn btn-outline-primary text-start">
                            <i class="fas fa-calendar-day me-2"></i> View Daily Tasks
                        </a>
                        <button class="btn btn-outline-success text-start" onclick="markAllCompleted()">
                            <i class="fas fa-check-double me-2"></i> Mark All as Complete
                        </button>
                        <a href="#" class="btn btn-outline-info text-start">
                            <i class="fas fa-download me-2"></i> Export Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Your existing footer remains unchanged -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>NET IT TECHNOLOGY</h5>
        <p>
          Leading provider of cutting-edge software solutions and digital transformation services. 
          We empower businesses to thrive in the digital age.
        </p>
        <div class="social-links">
          <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
        </div>
      </div>
      
      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="footer-links">
          <li><a href="{{ route('superadmin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
          <li><a href="{{ route('superadmin.employee.index') }}"><i class="fas fa-users"></i> Employees</a></li>
          <li><a href="{{ route('superadmin.tasks.index') }}"><i class="fas fa-tasks"></i> Tasks</a></li>
          <li><a href="{{ route('superadmin.project.transactions') }}"><i class="fas fa-chart-line"></i> Finance</a></li>
          <li><a href="{{ route('superadmin.clients.index') }}"><i class="fas fa-bullhorn"></i> Marketing</a></li>
        </ul>
      </div>
      
      <!-- Services -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5>Our Services</h5>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-code"></i> Web Development</a></li>
          <li><a href="#"><i class="fas fa-mobile-alt"></i> Mobile Apps</a></li>
          <li><a href="#"><i class="fas fa-cloud"></i> Cloud Solutions</a></li>
          <li><a href="#"><i class="fas fa-chart-bar"></i> Data Analytics</a></li>
          <li><a href="#"><i class="fas fa-shield-alt"></i> Cybersecurity</a></li>
        </ul>
      </div>
      
      <!-- Contact Info -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5>Contact Us</h5>
        <ul class="contact-info">
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <strong>Head Office</strong><br>
              10/20, Kandy Road, Ampitiya, Kandy<br>
              Sri Lanka
            </div>
          </li>
          <li>
            <i class="fas fa-phone"></i>
            <div>
              <strong>Phone</strong><br>
              +94 76 151 7778
            </div>
          </li>
          <li>
            <i class="fas fa-envelope"></i>
            <div>
              <strong>Email</strong><br>
              info@netittechnology.com
            </div>
          </li>
          <li>
            <i class="fas fa-clock"></i>
            <div>
              <strong>Business Hours</strong><br>
              Mon - Fri: 9:00 AM - 5:00 PM
            </div>
          </li>
        </ul>
      </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2025 NetIT Technology. All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-submit form on month change
    document.getElementById('month')?.addEventListener('change', function() {
        this.closest('form').submit();
    });

    // Mark all tasks as completed (demo function)
    function markAllCompleted() {
        if (confirm('Are you sure you want to mark all pending tasks as completed?')) {
            alert('This feature would mark all forwarded tasks as completed in a real application.');
        }
    }

    // Add hover effects to table rows
    document.querySelectorAll('.task-table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
</script>
</body>
</html>