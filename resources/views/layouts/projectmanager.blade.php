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
        .task-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            margin-bottom: 20px;
            border: none;
        }
        .task-card:hover {
            transform: translateY(-2px);
        }
        .priority-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75em;
            font-weight: 600;
        }
        .priority-low { background-color: #6c757d; color: white; }
        .priority-medium { background-color: #17a2b8; color: white; }
        .priority-high { background-color: #ffc107; color: black; }
        .priority-urgent { background-color: #dc3545; color: white; }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75em;
            font-weight: 600;
        }
        .status-pending { 
            background-color: #e2e3e5; 
            color: #383d41; 
            border: 1px solid #d6d8db;
        }
        .status-in-progress { 
            background-color: #cce7ff; 
            color: #004085; 
            border: 1px solid #b3d7ff;
        }
        .status-completed { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb;
        }
        .dashboard-stats {
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }
        .stat-total { border-left-color: #007bff; }
        .stat-completed { border-left-color: #28a745; }
        .stat-in-progress { border-left-color: #17a2b8; }
        .stat-pending { border-left-color: #6c757d; }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .progress {
            height: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="PM" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ 'Project Manager' }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pmNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="pmNavbar">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tasksDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-target me-1"></i> Day Updates Tasks
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('projectmanager.daily-tasks.index', $pm->id ?? 1) }}">Daily Tasks</a></li>      
                    </ul>
                </li>
            </ul>
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
    
    <!-- Welcome Section -->
    @if(!isset($hideWelcome) || $hideWelcome === false)
    <div class="mb-5 position-relative">
        <img src="{{ asset('images/company-bg.jpeg') }}" class="img-fluid w-100" style="max-height:350px; object-fit: cover; filter: brightness(0.5);" alt="Company Background">
        <div class="position-absolute top-50 start-50 translate-middle bg-white bg-opacity-75 p-4 rounded shadow" style="max-width: 700px;">
            <h3 id="typingText" class="fw-bold mb-2 text-primary"></h3>
            <p class="mb-0 text-dark">We specialize in delivering cutting-edge software and digital solutions that drive results. From enterprise web apps to mobile platforms, we empower businesses to scale and succeed.</p>
        </div>
    </div>

    <!-- Dashboard Statistics -->
    <div class="dashboard-stats">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-total">
                    <p class="stat-number text-primary">{{ $totalTasks ?? 0 }}</p>
                    <p class="stat-label">Total Tasks</p>
                    <i class="fas fa-tasks fa-2x text-primary"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-completed">
                    <p class="stat-number text-success">{{ $completedTasks ?? 0 }}</p>
                    <p class="stat-label">Completed</p>
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-in-progress">
                    <p class="stat-number text-info">{{ $inProgressTasks ?? 0 }}</p>
                    <p class="stat-label">In Progress</p>
                    <i class="fas fa-spinner fa-2x text-info"></i>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-pending">
                    <p class="stat-number text-secondary">{{ $pendingTasks ?? 0 }}</p>
                    <p class="stat-label">Pending</p>
                    <i class="fas fa-clock fa-2x text-secondary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">
                    <i class="fas fa-clock me-2"></i>Recent Daily Tasks
                </h4>
                
            </div>
            

            @if(isset($recentTasks) && $recentTasks->count() > 0)
                <div class="row">
                    @foreach($recentTasks as $task)
                        <div class="col-md-6 col-lg-4">
                            <div class="card task-card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate">{{ $task->task_name }}</h6>
                                    <div class="d-flex gap-1">
                                        <span class="priority-badge priority-{{ $task->priority }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($task->status)) }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $task->profile->full_name ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($task->task_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            @if($task->start_time && $task->end_time)
                                                {{ \Carbon\Carbon::parse($task->start_time)->format('h:i A') }} - 
                                                {{ \Carbon\Carbon::parse($task->end_time)->format('h:i A') }}
                                            @else
                                                Time not set
                                            @endif
                                        </small>
                                    </div>
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">
                                            {{ Str::limit($task->description, 100) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Progress Bar -->
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span>Progress</span>
                                            <span>{{ $task->completed_count }}/{{ $task->target_count }}</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar 
                                                @if($task->completion_percentage >= 100) bg-success
                                                @elseif($task->completion_percentage > 0) bg-info
                                                @else bg-secondary @endif" 
                                                role="progressbar" 
                                                style="width: {{ min($task->completion_percentage, 100) }}%"
                                                aria-valuenow="{{ $task->completion_percentage }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted d-block text-center mt-1">
                                            {{ number_format(min($task->completion_percentage, 100), 1) }}%
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Created: {{ $task->created_at->diffForHumans() }}
                                        </small>
                                        <!-- Removed edit button to avoid route error -->
                                        <span class="badge bg-light text-dark">
                                            ID: {{ $task->id }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($recentTasks->count() >= 6)
                    <div class="text-center mt-4">
                        <a href="{{ route('projectmanager.daily-tasks.index', $pm->id ?? 1) }}" class="btn btn-outline-primary">
                            View All My Tasks <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No daily tasks found</h5>
                    <p class="text-muted">Get started by creating your first daily task.</p>
                   
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Typing Script -->
<script>
    function typeWriter(text, elementId, speed = 50) {
        let i = 0;
        const element = document.getElementById(elementId);
        if (!element) return;
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        typeWriter("Welcome to NetIT Technology....!", "typingText");
    });
</script>

@yield('scripts')
</body>
</html>