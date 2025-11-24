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
                                                // Determine current status
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
                                                <!-- View Details Button -->
                                                <button class="btn btn-outline-info" data-bs-toggle="modal" 
                                                        data-bs-target="#detailsModal{{ $task->id }}" title="View Details">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                
                                                <!-- Edit Progress Button -->
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

                                            <!-- Task Details Modal -->
                                            <div class="modal fade" id="detailsModal{{ $task->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-info-circle me-2"></i>Task Details
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary">Basic Information</h6>
                                                                    <table class="table table-sm table-borderless">
                                                                        <tr>
                                                                            <td class="fw-bold" width="40%">Task Name:</td>
                                                                            <td>{{ $task->task_name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Employee:</td>
                                                                            <td>{{ $task->profile->full_name }} ({{ $task->profile->employee_id }})</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Task Date:</td>
                                                                            <td>{{ $task->task_date->format('M d, Y') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Task Type:</td>
                                                                            <td>
                                                                                <span class="badge bg-info text-dark">{{ ucfirst($task->task_type) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Priority:</td>
                                                                            <td>
                                                                                <span class="badge bg-{{ $priorityColors[$task->priority] }}">
                                                                                    {{ ucfirst($task->priority) }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary">Progress Information</h6>
                                                                    <table class="table table-sm table-borderless">
                                                                        <tr>
                                                                            <td class="fw-bold" width="40%">Target Count:</td>
                                                                            <td>{{ $task->target_count }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Completed Count:</td>
                                                                            <td>
                                                                                <span class="fw-bold {{ $task->completed_count >= $task->target_count ? 'text-success' : 'text-warning' }}">
                                                                                    {{ $task->completed_count }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Status:</td>
                                                                            <td>
                                                                                @php
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
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Verified:</td>
                                                                            <td>
                                                                                @if($task->verified ?? false)
                                                                                    <span class="badge bg-success">Yes</span>
                                                                                @else
                                                                                    <span class="badge bg-secondary">No</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">Start Time:</td>
                                                                            <td>
                                                                                @if($task->start_time)
                                                                                    {{ $task->start_time->format('h:i A') }}
                                                                                @else
                                                                                    <span class="text-muted">Not started</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="fw-bold">End Time:</td>
                                                                            <td>
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
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <h6 class="text-primary">Description</h6>
                                                                    <div class="card bg-light">
                                                                        <div class="card-body">
                                                                            <p class="mb-0">{{ $task->description }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            
                                                            @if($task->notes)
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <h6 class="text-primary">Additional Notes</h6>
                                                                    <div class="card bg-light">
                                                                        <div class="card-body">
                                                                            <p class="mb-0">{{ $task->notes }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#progressModal{{ $task->id }}">
                                                                <i class="fas fa-edit me-1"></i>Update Progress
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
                                                        <div class="modal-header bg-info text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-file-alt me-2"></i>Task Description
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-0">{{ $task->description }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Progress Update Modal -->
                                            <div class="modal fade" id="progressModal{{ $task->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('developer.daily-tasks.update-progress', $task->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title">
                                                                    <i class="fas fa-edit me-2"></i>Update Task - {{ $task->task_name }}
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="fw-bold">Completed Count</label>
                                                                            <input type="number" name="completed_count" 
                                                                                   value="{{ $task->completed_count }}" 
                                                                                   min="0" max="{{ $task->target_count }}"
                                                                                   class="form-control" required>
                                                                            <small class="text-muted">Target: {{ $task->target_count }}</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="fw-bold">Status</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="fw-bold">Start Time</label>
                                                                            <input type="time" name="start_time" 
                                                                                   value="{{ $task->start_time ? $task->start_time->format('H:i') : '' }}"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="fw-bold">End Time</label>
                                                                            <input type="time" name="end_time" 
                                                                                   value="{{ $task->end_time ? $task->end_time->format('H:i') : '' }}"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Actual Time (HH:MM)</label>
                                                                    <input type="time" name="actual_time" 
                                                                           value="{{ $task->actual_time ? $task->actual_time->format('H:i') : '' }}"
                                                                           class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Notes</label>
                                                                    <textarea name="notes" class="form-control" rows="3" 
                                                                              placeholder="Add any additional notes or comments...">{{ $task->notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update Task</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>