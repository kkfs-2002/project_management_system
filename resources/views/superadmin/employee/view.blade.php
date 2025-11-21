@extends('layouts.app')

@section('title', 'Daily Tasks Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>Daily Tasks Management
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Employee Summary Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users me-2"></i>Employee Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
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
                                <div class="col-xl-3 col-md-6 mb-3">
                                    <div class="card border shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <span class="text-white fw-bold fs-5">{{ substr($stat['employee']->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $stat['employee']->full_name }}</h6>
                                                    <small class="text-muted">{{ $stat['employee']->employee_id }}</small>
                                                </div>
                                            </div>
                                            
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="border-end">
                                                        <div class="h5 mb-1 fw-bold text-primary">{{ $stat['total_tasks'] }}</div>
                                                        <small class="text-muted">Total</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="border-end">
                                                        <div class="h5 mb-1 fw-bold text-success">{{ $stat['completed_tasks'] }}</div>
                                                        <small class="text-muted">Done</small>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="h5 mb-1 fw-bold text-warning">{{ $stat['in_progress_tasks'] + $stat['pending_tasks'] }}</div>
                                                    <small class="text-muted">Pending</small>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-muted">Completion Rate</small>
                                                    <small class="fw-bold">{{ $stat['completion_rate'] }}%</small>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: {{ $stat['completion_rate'] }}%" 
                                                         aria-valuenow="{{ $stat['completion_rate'] }}" 
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Tasks</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tasks->total() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Completed Tasks</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $tasks->where('status', 'completed')->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                In Progress</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $tasks->where('status', 'in_progress')->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pending Verification</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $tasks->where('status', 'completed')->where('verified', false)->count() }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>Filter Tasks
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Date</label>
                                    <input type="date" name="date" value="{{ $date ?? today()->format('Y-m-d') }}" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Employee</label>
                                    <select name="employee_id" class="form-select">
                                        <option value="">All Employees</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}" {{ ($employeeId ?? '') == $emp->id ? 'selected' : '' }}>
                                                {{ $emp->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Task Type</label>
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
                                    <label class="form-label fw-bold">Priority</label>
                                    <select name="priority" class="form-select">
                                        <option value="">All Priorities</option>
                                        <option value="low" {{ ($priority ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ ($priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ ($priority ?? '') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ ($priority ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ ($status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ ($status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="verified" {{ ($status ?? '') == 'verified' ? 'selected' : '' }}>Verified</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="btn-group w-100">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('superadmin.daily-tasks.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-redo me-1"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tasks Table -->
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Task List
                            </h5>
                            <div class="text-muted small">
                                Showing {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Task Date</th>
                                            <th>Task Name</th>
                                            <th>Description</th>
                                            <th>Task Type</th>
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
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <span class="text-white fw-bold">{{ substr($task->profile->full_name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $task->profile->full_name }}</div>
                                                        <small class="text-muted">{{ $task->profile->employee_id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $task->task_date->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $task->task_date->format('D') }}</small>
                                            </td>
                                            <td class="fw-bold">{{ Str::limit($task->task_name, 25) }}</td>
                                            <td>
                                                @if($task->description)
                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" 
                                                        data-bs-target="#descriptionModal{{ $task->id }}" title="View Description">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    <i class="fas fa-tag me-1"></i>{{ ucfirst($task->task_type) }}
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
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        @php
                                                            $progress = $task->target_count > 0 ? ($task->completed_count / $task->target_count) * 100 : 0;
                                                            $progressColor = $progress >= 100 ? 'bg-success' : ($progress >= 50 ? 'bg-primary' : 'bg-warning');
                                                        @endphp
                                                        <div class="progress-bar {{ $progressColor }}" role="progressbar" 
                                                             style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" 
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="fw-bold">{{ $task->completed_count }}/{{ $task->target_count }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $priorityColors = [
                                                        'low' => 'secondary',
                                                        'medium' => 'info',
                                                        'high' => 'warning', 
                                                        'urgent' => 'danger'
                                                    ];
                                                    $priorityIcons = [
                                                        'low' => 'arrow-down',
                                                        'medium' => 'minus',
                                                        'high' => 'arrow-up', 
                                                        'urgent' => 'exclamation-triangle'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $priorityColors[$task->priority] }} d-flex align-items-center">
                                                    <i class="fas fa-{{ $priorityIcons[$task->priority] }} me-1"></i>
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
                                                    $statusIcons = [
                                                        'pending' => 'clock',
                                                        'in_progress' => 'spinner',
                                                        'completed' => 'check-circle',
                                                        'verified' => 'check-double'
                                                    ];
                                                    // Determine current status
                                                    $currentStatus = $task->status;
                                                    $isVerified = $task->verified ?? false;
                                                    
                                                    if ($isVerified && $currentStatus === 'completed') {
                                                        $currentStatus = 'verified';
                                                    }
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$currentStatus] }} d-flex align-items-center">
                                                    <i class="fas fa-{{ $statusIcons[$currentStatus] }} me-1"></i>
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
                                                                        <h6 class="text-primary mb-3">Basic Information</h6>
                                                                        <table class="table table-sm table-borderless">
                                                                            <tr>
                                                                                <td class="fw-bold" width="40%">Task Name:</td>
                                                                                <td>{{ $task->task_name }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="fw-bold">Employee:</td>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                                            <span class="text-white fw-bold">{{ substr($task->profile->full_name, 0, 1) }}</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="fw-bold">{{ $task->profile->full_name }}</div>
                                                                                            <small class="text-muted">{{ $task->profile->employee_id }}</small>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
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
                                                                                        <i class="fas fa-{{ $priorityIcons[$task->priority] }} me-1"></i>
                                                                                        {{ ucfirst($task->priority) }}
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <h6 class="text-primary mb-3">Progress Information</h6>
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
                                                                                <td class="fw-bold">Progress:</td>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                                            @php
                                                                                                $progress = $task->target_count > 0 ? ($task->completed_count / $task->target_count) * 100 : 0;
                                                                                                $progressColor = $progress >= 100 ? 'bg-success' : ($progress >= 50 ? 'bg-primary' : 'bg-warning');
                                                                                            @endphp
                                                                                            <div class="progress-bar {{ $progressColor }}" role="progressbar" 
                                                                                                 style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" 
                                                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                                                        </div>
                                                                                        <small class="fw-bold">{{ number_format($progress, 1) }}%</small>
                                                                                    </div>
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
                                                                                        <i class="fas fa-{{ $statusIcons[$currentStatus] }} me-1"></i>
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
                                                            <form action="{{ route('superadmin.daily-tasks.update-progress', $task->id) }}" method="POST">
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
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <h5>No tasks found</h5>
                                                    <p>Try adjusting your filters or create a new task.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $tasks->links() }}
                                </div>
                                <div class="text-muted small">
                                    Showing {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}
.avatar-lg {
    width: 48px;
    height: 48px;
    font-size: 18px;
}
.progress {
    border-radius: 10px;
}
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
</style>

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
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection