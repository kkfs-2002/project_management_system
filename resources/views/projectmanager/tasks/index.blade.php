<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Manager Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: rgba(0, 0, 0, .75);
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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <!-- Left: Logo + Welcome -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('layouts.projectmanager', $pm->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="PM" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ 'Project Manager' }}</span>
        </a>

        <!-- Toggler for Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pmNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="pmNavbar">
            <!-- Center Navigation -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}">
                        <i class="fa fa-home me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projectmanager.tasks.index', $pm->id ?? 1) }}">
                        <i class="fa fa-tasks me-1"></i> Tasks
                    </a>
                </li>
            </ul>

            <!-- Right-Aligned: Account Dropdown -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pmDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-1"></i> {{ 'Account' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="pmDropdown">
                        <li>
                            <form method="POST" action="{{ route('projectmanager.logout') }}">
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

<!-- Main Content Area -->
<div class="container mt-4" style="padding-top:100px;">
    @yield('content')

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

<style>
    .task-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .task-table th, .task-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    .task-table th {
        background-color: #e6f2fa;
        color: rgba(0, 0, 0, 0.75);
        text-transform: uppercase;
        font-weight: 600;
    }
    .task-table tbody tr:hover {
        background-color: #f1faff;
    }
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.375rem;
        color: #fff;
        display: inline-block;
        text-align: center;
        min-width: 80px;
    }
    .badge.bg-success { background-color: #28a745; }
    .badge.bg-info { background-color: #17a2b8; }
    .badge.bg-warning { background-color: #ffc107; color: #212529; }
    .btn-forward {
        padding: 5px 12px;
        font-size: 14px;
        cursor: pointer;
        background-color: #ffc107; 
        border: none;
        border-radius: 4px;
        color: #212529;
        transition: background-color 0.3s ease;
    }
    .btn-forward:hover { background-color: #e0a800; color: #fff; }
    .alert-success {
        color: green;
        background: #e6ffed;
        padding: 10px;
        border-left: 4px solid green;
        margin-bottom: 15px;
        border-radius: 4px;
    }
</style>

<div class="container">
    <h3>Tasks for Project: <strong>{{ $project->name }}</strong></h3>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">-- All --</option>
                    <option value="Pending"   {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="month" class="form-label">Filter by Deadline Month</label>
                <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
            </div>

            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ route('projectmanager.projects.tasks', $project->id) }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Tasks Table -->
    <table class="task-table">
        <thead>
            <tr>
                
                <th>Title</th>
                <th>Description</th>
                <th>Developer</th>
                <th>Start Date</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
            <tr>
                
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->developer_name }}</td>
                <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                <td>
                    <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                        {{ $task->status }}
                    </span>
                </td>
                <td>
                    @if($task->status === 'Pending')
                        <form method="POST" action="{{ route('projectmanager.tasks.forward', $task->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-forward" >
                                Forward to Developer
                            </button>
                        </form>
                    @else
                        <span class="text-muted">Already Forwarded</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No tasks found for this project.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

