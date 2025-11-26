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
        .attendance-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .attendance-status {
            font-size: 1.2rem;
            font-weight: 600;
        }
        .time-display {
            font-size: 2rem;
            font-weight: bold;
            margin: 15px 0;
        }
        .btn-attendance {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-check-in {
            background-color: #10b981;
            border: none;
        }
        .btn-check-in:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-check-out {
            background-color: #ef4444;
            border: none;
        }
        .btn-check-out:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        }
        .attendance-info {
            background-color: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
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

<div class="container mt-4" style="padding-top:100px;">
    @yield('content')
    
    <!-- Attendance Section -->
    <div class="row mb-4">
        <div class="col-lg-6 mx-auto">
            <div class="attendance-card">
                <div class="text-center">
                    <h3 class="mb-3">
                        <i class="fas fa-clock me-2"></i>My Attendance
                    </h3>
                    
                    <div class="time-display" id="currentTime">
                        {{ now()->format('h:i:s A') }}
                    </div>
                    
                    <div class="attendance-status mb-3">
                        {{ now()->format('l, F d, Y') }}
                    </div>

                    @if(session('attendance_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('attendance_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('attendance_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('attendance_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($todayAttendance))
                        <div class="attendance-info">
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Check In:</strong></p>
                                    <p class="h5">{{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : '-' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Check Out:</strong></p>
                                    <p class="h5">{{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : '-' }}</p>
                                </div>
                            </div>
                            @if($todayAttendance->check_in && $todayAttendance->check_out)
                                <div class="mt-2">
                                    <p class="mb-1"><strong>Total Hours:</strong></p>
                                    <p class="h5">
                                        @php
                                            $checkIn = \Carbon\Carbon::parse($todayAttendance->check_in);
                                            $checkOut = \Carbon\Carbon::parse($todayAttendance->check_out);
                                            $diff = $checkIn->diff($checkOut);
                                        @endphp
                                        {{ $diff->h }}h {{ $diff->i }}m
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-4">
                        @if(!isset($todayAttendance) || !$todayAttendance->check_in)
                            <form action="{{ route('projectmanager.attendance.checkin') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-attendance btn-check-in text-white">
                                    <i class="fas fa-sign-in-alt me-2"></i>Check In
                                </button>
                            </form>
                        @elseif($todayAttendance->check_in && !$todayAttendance->check_out)
                            <form action="{{ route('projectmanager.attendance.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-attendance btn-check-out text-white">
                                    <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                </button>
                            </form>
                        @else
                            <div class="alert alert-light" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                You have completed your attendance for today!
                            </div>
                        @endif
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('projectmanager.attendance.history') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-history me-2"></i>View Attendance History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>Daily Tasks Management
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="date" name="date" value="{{ $date ?? today()->format('Y-m-d') }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Employee</label>
                                <select name="employee_id" class="form-select">
                                    <option value="">All Employees</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ ($employeeId ?? '') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->full_name }} - {{ $emp->job_title }} ({{ $emp->role }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Task Type</label>
                                <select name="task_type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="Senior Developer" {{ ($taskType ?? '') == 'Senior Developer' ? 'selected' : '' }}>Senior Developer</option>
                                    <option value="Junior Developer" {{ ($taskType ?? '') == 'Junior Developer' ? 'selected' : '' }}>Junior Developer</option>
                                    <option value="Intern/Trainee" {{ ($taskType ?? '') == 'Intern/Trainee' ? 'selected' : '' }}>Intern/Trainee</option>
                                    <option value="Marketing Manager" {{ ($taskType ?? '') == 'Marketing Manager' ? 'selected' : '' }}>Marketing Manager</option>
                                    <option value="Project Manager" {{ ($taskType ?? '') == 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="">All Priorities</option>
                                    <option value="low" {{ ($priority ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ ($priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ ($priority ?? '') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ ($priority ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <a href="{{ route('developer.daily-tasks.index') }}" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>
                        <!-- Tasks Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Task Date</th>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                        <th>Task Type</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $task->profile->full_name }}</div>
                                            <small class="text-muted">{{ $task->profile->employee_id }}</small>
                                        </td>
                                        <td>{{ $task->task_date->format('Y-m-d') }}</td>
                                        <td>{{ $task->task_name }}</td>
                                        <td>
                                            @if($task->description)
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                    data-bs-target="#descriptionModal{{ $task->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">{{ ucfirst($task->task_type) }}</span>
                                        </td>
                                        <td>
                                            @if($task->start_time)
                                                {{ $task->start_time->format('H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($task->end_time)
                                                {{ $task->end_time->format('H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $priorityColors = [
                                                    'low' => 'secondary',
                                                    'medium' => 'info',
                                                    'high' => 'warning',
                                                    'urgent' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $priorityColors[$task->priority] }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'secondary',
                                                    'in_progress' => 'primary',
                                                    'completed' => 'success',
                                                    'verified' => 'success'
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
                                            <span class="badge bg-{{ $statusColors[$currentStatus] }}">
                                                {{ $statusText[$currentStatus] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" data-bs-toggle="modal"
                                                        data-bs-target="#detailsModal{{ $task->id }}" title="View Details">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                               
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#progressModal{{ $task->id }}" title="Update Progress">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                               
                                                @if($task->status == 'completed' && !($task->verified ?? false))
                                                <button class="btn btn-outline-success" onclick="verifyTask({{ $task->id }})" title="Verify Task">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                                @endif
                                                @if($task->status == 'completed' && ($task->verified ?? false))
                                                <button class="btn btn-success" title="Verified" disabled>
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                                @endif
                                               
                                                <button class="btn btn-outline-danger" onclick="deleteTask({{ $task->id }})" title="Delete Task">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <!-- Modals remain the same as in your original code -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $tasks->links() }}
                        <div class="mt-3">
                            <a href="{{ route('projectmanager.daily-tasks.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Daily Task Update
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time clock update
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: true 
    });
    document.getElementById('currentTime').textContent = timeString;
}

// Update time every second
setInterval(updateTime, 1000);
updateTime();

function verifyTask(taskId) {
    if (confirm('Are you sure you want to verify this task?')) {
        fetch(`/developer/daily-tasks/${taskId}/verify`, {
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

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        fetch(`/developer/daily-tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error deleting task');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Error deleting task');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>