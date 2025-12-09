<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Developer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
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
        
        /* Attendance Card Styles */
        .attendance-card {
          background: linear-gradient(135deg, #000000 0%, #888888 100%);

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
        .btn-check-in:hover:not(:disabled) {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-check-out {
            background-color: #ef4444;
            border: none;
        }
        .btn-check-out:hover:not(:disabled) {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        }
        .btn-attendance:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .attendance-info {
            background-color: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }
        
        /* Task Card Styles */
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
        /* Image animation stays same */
.attendance-illustration {
    width: 90%;
    max-width: 380px;
    opacity: 0;
    transform: translateX(-40px) translateY(0) scale(1);
    animation: fadeSlideFloat 2s ease-out forwards, floatAnim 3s ease-in-out 2s infinite;
}

@keyframes fadeSlideFloat {
    to {
        opacity: 1;
        transform: translateX(0) translateY(0) scale(1);
    }
}

@keyframes floatAnim {
    0% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-10px) scale(1.03); }
    100% { transform: translateY(0) scale(1); }
}
/* Footer */
    .footer {
      background: #000000 url('{{ asset("images/fo.jpg") }}') no-repeat center center;
      background-size: cover;
      color: #fff;
      padding: 50px 0 20px;
      position: relative;
      margin-top: auto;
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

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('developer.dashboard', $dev->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="Dev" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ $dev->full_name ?? 'Developer' }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#devNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="devNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer.dashboard', $dev->id ?? 1) }}">
                        <i class="fa fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer.tasks.index') }}">
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

<!-- Main Content Area -->
<div class="mt-3">
    @yield('content')

    <!-- Welcome Section - Only show on dashboard -->
    @if(!isset($hideWelcome) || $hideWelcome === false)
    <div class="mb-5 position-relative">
        <img src="{{ asset('images/de.jpg') }}" class="img-fluid w-100" style="max-height:650px; object-fit: cover; filter: brightness(0.5);" alt="Company Background">
       <div class="position-absolute top-50 start-50 translate-middle bg-opacity-75 p-4 rounded shadow" style="max-width: 700px;">

    <!-- MAIN TITLE -->
    <h3 id="typingText" class="fw-bold mb-2 text-white">
        Developer Dashboard
    </h3>

    <!-- DESCRIPTION TEXT -->
    <p class="mb-0 text-white">
      Track tasks, monitor progress, and manage your team's workflow seamlessly. 
        Your Developer Dashboard keeps everything organized in one place
  </p>

</div>

    </div>

     <!-- Attendance Section -->
    @if(request()->routeIs('developer.dashboard'))
     <div class="row mb-5 mt-5 d-flex align-items-center justify-content-center">
          <!-- LEFT SIDE IMAGE WITH ANIMATION -->
    <div class="col-lg-5 text-center">
        <img src="/images/de.png" 
             class="img-fluid attendance-illustration"
             alt="Attendance Illustration">
    </div>

 
        <div class="col-lg-6 mx-auto">
            <div class="attendance-card">
                <div class="text-center">
                    <h3 class="mb-3">
                        <i class="fas fa-clock me-2"></i>My Attendance
                    </h3>
                  
                    
                    <div class="time-display" id="currentTime">
                        Loading...
                    </div>
                    
                    <div class="attendance-status mb-3" id="currentDate">
                        Loading...
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
                        @if(isset($todayAttendance) && $todayAttendance->check_in && $todayAttendance->check_out)
                            <!-- Both completed -->
                            <div class="alert alert-light" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                You have completed your attendance for today!
                            </div>
                        @else
                            <!-- Show both buttons side by side -->
                            <div class="d-flex gap-3 justify-content-center">
                                <!-- Check In Button -->
                                <form action="{{ route('developer.attendance.checkin') }}" method="POST" id="checkin-form" onsubmit="showLoader(event, 'Checking in...')">
                                    @csrf
                                    <input type="hidden" name="timezone" id="timezone-input">
                                    <button type="submit" class="btn btn-attendance btn-check-in text-white" id="checkin-btn"
                                        @if(isset($todayAttendance) && $todayAttendance->check_in) disabled @endif>
                                        <i class="fas fa-sign-in-alt me-2"></i>Check In
                                    </button>
                                </form>
                                
                                <!-- Check Out Button -->
                                <form action="{{ route('developer.attendance.checkout') }}" method="POST" id="checkout-form" onsubmit="showLoader(event, 'Checking out...')">
                                    @csrf
                                    <input type="hidden" name="timezone" id="timezone-input-out">
                                    <button type="submit" class="btn btn-attendance btn-check-out text-white" id="checkout-btn"
                                        @if(!isset($todayAttendance) || !$todayAttendance->check_in) disabled @endif>
                                        <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('developer.attendance.history') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-history me-2"></i>View Attendance History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Dashboard Statistics (Optional - Add if needed) -->
    @if(isset($totalTasks))
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
    @endif

    <!-- Recent Tasks Section (Optional - Add if needed) -->
    @if(isset($recentTasks) && $recentTasks->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary">
                    <i class="fas fa-clock me-2"></i>Recent Daily Tasks
                </h4>
            </div>
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
                    <a href="{{ route('developer.daily-tasks.index') }}" class="btn btn-outline-primary">
                        View All My Tasks <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
    @else
        @if(isset($recentTasks))
        <div class="text-center py-5">
            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No daily tasks found</h5>
            <p class="text-muted">Get started by creating your first daily task.</p>
        </div>
        @endif
    @endif
    @endif
</div>
<!-- Salary Section - Only show on developer dashboard -->
@if(request()->routeIs('developer.dashboard'))
<div class="row mb-4">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0">
         <div class="card-header" style="background: linear-gradient(135deg, #000000 0%, #4f4f4f 100%); color: white;">
    <h5 class="mb-0">
        <i class="fas fa-money-bill-wave me-2"></i>My Salary Details
    </h5>
</div>

            </div>
            <div class="card-body">
                @if(isset($salaryDetails) && $salaryDetails->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Paid Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryDetails as $salary)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($salary->salary_month)->format('F Y') }}</td>
                                        <td class="fw-bold text-primary">Rs. {{ number_format($salary->amount, 2) }}</td>
                                        <td>
                                            @if($salary->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salary->payment_method)
                                                <span class="badge bg-info">
                                                    {{ ucfirst(str_replace('_', ' ', $salary->payment_method)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salary->status == 'paid' && $salary->updated_at)
                                                {{ \Carbon\Carbon::parse($salary->updated_at)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary view-salary-details" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#salaryModal"
                                                    data-month="{{ \Carbon\Carbon::parse($salary->salary_month)->format('F Y') }}"
                                                    data-amount="Rs. {{ number_format($salary->amount, 2) }}"
                                                    data-status="{{ $salary->status }}"
                                                    data-method="{{ $salary->payment_method ? ucfirst(str_replace('_', ' ', $salary->payment_method)) : 'Not specified' }}"
                                                    data-paiddate="{{ $salary->status == 'paid' && $salary->updated_at ? \Carbon\Carbon::parse($salary->updated_at)->format('d M Y') : 'Not paid yet' }}"
                                                    data-notes="{{ $salary->notes ?? 'No additional notes' }}">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Salary Summary -->
                    @if(isset($salarySummary))
                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">This Month</h6>
                                    <h4 class="text-primary mb-0">
                                        Rs. {{ number_format($salarySummary['current_month'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Last Month</h6>
                                    <h4 class="text-success mb-0">
                                        Rs. {{ number_format($salarySummary['last_month'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Year Total</h6>
                                    <h4 class="text-info mb-0">
                                        Rs. {{ number_format($salarySummary['year_total'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Pending</h6>
                                    <h4 class="text-warning mb-0">
                                        Rs. {{ number_format($salarySummary['pending'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No salary records available</h5>
                        <p class="text-muted">Your salary information will be visible here once processed by accounts department.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Salary information is confidential and secure
                    </small>
                    <a href="mailto:accounts@netit.lk?subject=Developer Salary Inquiry" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-envelope me-1"></i> Contact Accounts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Developer Salary Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Salary Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Month:</strong></p>
                        <p><strong>Amount:</strong></p>
                        <p><strong>Status:</strong></p>
                        <p><strong>Payment Method:</strong></p>
                        <p><strong>Paid Date:</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p id="modal-month"></p>
                        <p id="modal-amount" class="fw-bold text-primary"></p>
                        <p id="modal-status"></p>
                        <p id="modal-method"></p>
                        <p id="modal-paiddate"></p>
                    </div>
                </div>
                <hr>
                <div>
                    <p><strong>Notes:</strong></p>
                    <p id="modal-notes" class="text-muted"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printSalaryDetails()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Footer Section -->
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-salary-details');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('modal-month').textContent = this.dataset.month;
            document.getElementById('modal-amount').textContent = this.dataset.amount;
            document.getElementById('modal-status').innerHTML = this.dataset.status === 'paid' 
                ? '<span class="badge bg-success">Paid</span>' 
                : '<span class="badge bg-warning">Pending</span>';
            document.getElementById('modal-method').textContent = this.dataset.method;
            document.getElementById('modal-paiddate').textContent = this.dataset.paiddate;
            document.getElementById('modal-notes').textContent = this.dataset.notes;
        });
    });
});

function printSalaryDetails() {
    const month = document.getElementById('modal-month').textContent;
    const amount = document.getElementById('modal-amount').textContent;
    const status = document.getElementById('modal-status').innerHTML;
    const method = document.getElementById('modal-method').textContent;
    const paiddate = document.getElementById('modal-paiddate').textContent;
    const notes = document.getElementById('modal-notes').textContent;
    
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Salary Slip - Developer</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .salary-slip { max-width: 800px; margin: 0 auto; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .fw-bold { font-weight: bold; }
                .border-bottom { border-bottom: 1px solid #000; padding-bottom: 10px; }
                .mt-4 { margin-top: 20px; }
                .pt-4 { padding-top: 20px; }
                .badge { padding: 3px 8px; border-radius: 4px; font-size: 12px; }
                .bg-success { background-color: #28a745; color: white; }
                .bg-warning { background-color: #ffc107; color: black; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="salary-slip">
                <div class="text-center border-bottom">
                    <h3 class="text-primary">NET IT TECHNOLOGY</h3>
                    <p class="text-muted">Developer Salary Slip</p>
                </div>
                
                <div class="mt-4">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Month:</strong> ${month}</p>
                            <p><strong>Amount:</strong> ${amount}</p>
                            <p><strong>Status:</strong> ${status}</p>
                        </div>
                        <div class="col-6 text-right">
                            <p><strong>Payment Method:</strong> ${method}</p>
                            <p><strong>Paid Date:</strong> ${paiddate}</p>
                            <p><strong>Printed Date:</strong> ${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-top">
                        <p><strong>Notes:</strong></p>
                        <p class="text-muted">${notes}</p>
                    </div>
                    
                    <div class="mt-4 pt-4 border-top">
                        <div class="row">
                            <div class="col-6 text-center">
                                <p class="border-top pt-2 mt-4">Developer Signature</p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="border-top pt-2 mt-4">Accounts Department</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="no-print text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary">Print</button>
                <button onclick="window.close()" class="btn btn-secondary">Close</button>
            </div>
        </body>
        </html>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
}
</script>
@endif
<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Get user's timezone
const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

// Set timezone in hidden inputs
document.addEventListener('DOMContentLoaded', function() {
    const timezoneInputCheckin = document.getElementById('timezone-input');
    const timezoneInputCheckout = document.getElementById('timezone-input-out');
    
    if (timezoneInputCheckin) {
        timezoneInputCheckin.value = userTimezone;
    }
    if (timezoneInputCheckout) {
        timezoneInputCheckout.value = userTimezone;
    }
});

// Real-time clock update with user's local time
function updateTime() {
    const now = new Date();
    
    // Update time display
    const timeString = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });
    
    // Update date display
    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateString = now.toLocaleDateString('en-US', dateOptions);
    
    const timeElement = document.getElementById('currentTime');
    const dateElement = document.getElementById('currentDate');
    
    if (timeElement) {
        timeElement.textContent = timeString;
    }
    if (dateElement) {
        dateElement.textContent = dateString;
    }
}

// Update time every second
setInterval(updateTime, 1000);
updateTime();

// Typing Script
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

// Loading indicator for form submission
function showLoader(event, message) {
    const button = event.target.querySelector('button[type="submit"]');
    if (button) {
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + message;
        button.disabled = true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    typeWriter("Welcome to NetIT Technology....!", "typingText");
});
</script>

@yield('scripts')
</body>
</html>