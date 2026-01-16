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
      /* Image animation stays same */
.attendance-illustration {
    width: 100%;
    max-width: 580px;
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
.stat-number {
    font-size: 3.5rem; /* increase size */
    font-weight: bold;
    margin-bottom: 0;
}
    .task-card {
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .task-card.active {
        background-color: #000917ff; /* Dark Blue */
        color: white;
    }
        /* Attendance Card Styles */
        .attendance-card {
            background: #000826ff;
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
     
 .task-card {
    background-color: white; /* default color */
    transition: background-color 0.3s, color 0.3s, background-image 0.3s;
    cursor: pointer; /* hand pointer on hover */
    position: relative; /* needed for overlay */
    color: black; /* default text color */
}
/* Hover effect: show background image and change text color */
.task-card:hover {
    background-image: url(''); /* your image path */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: white; /* text turns white */
}
/* Optional semi-transparent overlay for readability */
.task-card:hover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4); /* overlay */
    border-radius: 0.25rem;
    z-index: 0;
}
/* Ensure card content stays above overlay */
.task-card:hover > * {
    position: relative;
    z-index: 1;
}
/* Make badges visible on hover */
.task-card:hover .priority-badge,
.task-card:hover .status-badge {
    color: white;
    border-color: white;
}
  .stat-card {
    background: white; /* or your background image if used */
    border-radius: 10px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(193, 187, 187, 0.1);
    border-left: 4px solid;
    color: white; /* Make all text inside white */
}
.stat-card .stat-number,
.stat-card .stat-label {
    color: white; /* ensures numbers and labels are white */
}
/* Optional: override icon colors */
.stat-card i {
    color: white !important;
}
 /* Footer */
    .footer {
      background: #000000;
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
    .stat-card {
    position: relative;
    padding: 20px;
    border-radius: 12px;
    color: white; /* text color */
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
/* Optional: Overlay for better text visibility */
.stat-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(216, 208, 208, 0.4); /* semi-transparent overlay */
    z-index: 0;
}
.stat-card p,
.stat-card i {
    position: relative;
    z-index: 1; /* bring text/icons above overlay */
}
/* Specific backgrounds for each type */
.stat-total {
    background-image: url('/images/po2.avif');
}
.stat-completed {
    background-image: url('/images/po2.avif');
}
.stat-in-progress {
    background-image: url('/images/po2.avif');
}
.stat-pending {
    background-image: url('/images/po2.avif');
}
.custom-badge {
    color: #000000; /* Black color */
    font-weight: bold; /* Bold text */
}
.custom-text {
    color: #6c757d; /* Gray color */
    font-weight: bold; /* Bold text */
    font-size: 1.1rem; /* Slightly bigger text */
}
    </style>
    <!-- Mobile-Specific Styles -->
    <style>
        /* Mobile Responsiveness (≤576px for xs, ≤768px for sm) */
        @media (max-width: 768px) {
            /* Navbar adjustments */
            .navbar-brand span {
                font-size: 0.9rem;
            }
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .navbar-collapse {
                background-color: #000000;
                margin-top: 0.5rem;
                padding: 1rem;
                border-radius: 0.375rem;
            }

            /* Welcome section */
            .welcome-overlay {
                max-width: 90vw !important;
                padding: 1.5rem !important;
                text-align: center;
            }
            #typingText {
                font-size: 1.5rem;
            }
            .welcome-overlay p {
                font-size: 0.95rem;
            }

            /* Attendance section */
            .attendance-illustration {
                margin-bottom: 2rem;
                transform: translateX(0) !important;
                animation: fadeSlideFloat 1.5s ease-out forwards;
            }
            .attendance-card {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }
            .time-display {
                font-size: 1.5rem;
            }
            .btn-attendance {
                padding: 10px 20px;
                font-size: 1rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }
            .d-flex.gap-3.justify-content-center {
                flex-direction: column;
            }

            /* Stats cards */
            .stat-card {
                margin-bottom: 1rem;
                padding: 1.5rem;
                min-height: auto;
            }
            .stat-number {
                font-size: 2rem;
            }
            .stat-label {
                font-size: 0.9rem;
            }

            /* Recent tasks */
            .task-card .card-header h6 {
                font-size: 1rem;
                white-space: normal;
            }
            .task-card .card-body {
                padding: 1rem;
            }
            .custom-text {
                font-size: 0.85rem;
            }
            .progress {
                height: 0.5rem;
            }

            /* Salary section */
            .salary-quick-stats .col-md-4 {
                margin-bottom: 1rem;
            }
            .salary-table th,
            .salary-table td {
                padding: 0.5rem;
                font-size: 0.8rem;
                white-space: nowrap;
            }
            .salary-table .btn-group {
                flex-direction: column;
            }
            .salary-table .btn-group .btn {
                margin-bottom: 0.25rem;
                width: 100%;
            }

            /* Footer */
            .footer {
                padding: 2rem 0 1rem;
            }
            .footer h5 {
                font-size: 1rem;
                margin-bottom: 1rem;
            }
            .footer p,
            .footer-links a,
            .contact-info div {
                font-size: 0.85rem;
            }
            .social-links {
                justify-content: center;
            }
            .footer-bottom {
                margin-top: 2rem;
                padding-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            /* Extra small screens */
            body {
                font-size: 0.875rem;
            }
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            #typingText {
                font-size: 1.25rem;
            }
            .stat-number {
                font-size: 1.75rem;
            }
            .btn-attendance {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
            .salary-table {
                font-size: 0.75rem;
            }
            .footer-links li,
            .contact-info li {
                margin-bottom: 0.75rem;
            }
        }

        /* Table responsiveness for salary */
        .salary-table {
            border-collapse: collapse;
        }
        .salary-table thead {
            display: none;
        }
        @media (max-width: 768px) {
            .salary-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
                padding: 1rem;
                background: white;
            }
            .salary-table td {
                display: block;
                text-align: right;
                padding: 0.5rem 0;
                border: none;
                position: relative;
                padding-left: 50%;
            }
            .salary-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-right: 1rem;
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
            }
            .salary-table .btn-group {
                text-align: center;
            }
        }
        
.stat-card {
    background: linear-gradient(135deg, #1e293b, #0f172a); /* Dark gradient background */
    color: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 150px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
}

.stat-label {
    font-size: 1rem;
    margin-bottom: 10px;
}
/* Welcome Section Background */
.welcome-wrapper {
    min-height: 250px;
    margin-top: 66px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    padding: 40px 20px;
}

/* Glass Card */
.welcome-card {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px 50px;
    max-width: 700px;
    color: #ffffff;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    animation: fadeUp 0.8s ease-in-out;
}

/* Title */
.welcome-card h2 {
    font-size: 2.5rem;
    letter-spacing: 0.5px;
}

/* Description */
.welcome-text {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
}

/* Animation */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-card {
        padding: 30px 25px;
    }

    .welcome-card h2 {
        font-size: 2rem;
    }
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="PM" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, Project Manager</span>
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
                        <i class="fa fa-user me-1"></i> Account
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
<div class="mt-3">
    @yield('content')
   
   
   
<!-- Welcome Section -->
@if(!isset($hideWelcome) || $hideWelcome === false)
<div class="welcome-wrapper d-flex align-items-center justify-content-center mb-5">
    <div class="welcome-card text-center">
        <span class="badge bg-primary mb-3 px-3 py-2">Welcome Back</span>

        <!-- MAIN TITLE -->
        <h2 id="typingText" class="fw-bold mb-3">
            Project Manager Dashboard
        </h2>

        <!-- DESCRIPTION -->
        <p class="welcome-text">
            Track tasks, monitor progress, and manage your team efficiently.
            Stay focused and deliver projects on time with ease.
        </p>
    </div>
</div>




    <!-- Attendance Section -->
    @if(\Route::currentRouteName() === 'projectmanager.dashboard')
   <div class="row mb-5 mt-5 d-flex align-items-center justify-content-center">
            <!-- LEFT SIDE IMAGE WITH ANIMATION -->
    <div class="col-lg-5 text-center">
        <img src="/images/team.png"
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
                                <form action="{{ route('projectmanager.attendance.checkin') }}" method="POST" id="checkin-form">
                                    @csrf
                                    <input type="hidden" name="timezone" id="timezone-input">
                                    <button type="submit" class="btn btn-attendance btn-check-in text-white"
                                        @if(isset($todayAttendance) && $todayAttendance->check_in) disabled @endif>
                                        <i class="fas fa-sign-in-alt me-2"></i>Check In
                                    </button>
                                </form>
                            
                                <!-- Check Out Button -->
                                <form action="{{ route('projectmanager.attendance.checkout') }}" method="POST" id="checkout-form">
                                    @csrf
                                    <input type="hidden" name="timezone" id="timezone-input-out">
                                    <button type="submit" class="btn btn-attendance btn-check-out text-white"
                                        @if(!isset($todayAttendance) || !$todayAttendance->check_in) disabled @endif>
                                        <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                    </button>
                                </form>
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
    @endif
   
<!-- Dashboard Statistics -->
<div class="dashboard-stats">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-total text-center">
                <p class="stat-number" style="color: #000000 !important;">{{ $totalTasks ?? 0 }}</p>
                <p class="stat-label">Total Tasks</p>
                <i class="fas fa-tasks fa-2x text-primary"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-completed text-center">
                <p class="stat-number" style="color: #000000 !important;">{{ $completedTasks ?? 0 }}</p>
                <p class="stat-label">Completed</p>
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-in-progress text-center">
                <p class="stat-number" style="color: #000000 !important;">{{ $inProgressTasks ?? 0 }}</p>
                <p class="stat-label">In Progress</p>
                <i class="fas fa-spinner fa-2x text-info"></i>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card stat-pending text-center">
                <p class="stat-number" style="color: #000000 !important;">{{ $pendingTasks ?? 0 }}</p>
                <p class="stat-label">Pending</p>
                <i class="fas fa-clock fa-2x text-secondary"></i>
            </div>
        </div>
    </div>
</div>

    <!-- Recent Tasks Section -->
 <div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-center mb-4">
       <h4 style="color: #000917ff; font-size: 2rem; font-weight: bold;">
<i class="fas fa-clock me-2"></i>Recent Daily Tasks
</h4>
        </div>
    </div>
</div>
            @if(isset($recentTasks) && $recentTasks->count() > 0)
                <div class="row">
                    @foreach($recentTasks as $task)
                        <div class="col-md-6 col-lg-4">
                            <div class="card task-card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                  <h6 class="mb-0 text-truncate" style="color: black; font-weight: bold;">
    {{ $task->task_name }}
</h6>
                                    <div class="d-flex gap-1">
                                        <span class="priority-badge priority-{{ $task->priority }} custom-badge">
    {{ ucfirst($task->priority) }}
</span>
<span class="status-badge status-{{ str_replace(' ', '-', strtolower($task->status)) }} custom-badge">
    {{ ucfirst($task->status) }}
</span>
                                    </div>
                            </div>
                          <div class="card-body">
    <div class="mb-2">
        <small class="text-muted custom-text">
            <i class="fas fa-user me-1"></i>
            {{ $task->profile->full_name ?? 'N/A' }}
        </small>
    </div>
    <div class="mb-2">
        <small class="text-muted custom-text">
            <i class="fas fa-calendar me-1"></i>
            {{ \Carbon\Carbon::parse($task->task_date)->format('M d, Y') }}
        </small>
    </div>
    <div class="mb-2">
        <small class="text-muted custom-text">
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
        <p class="card-text custom-text mb-2">
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
                        <a href="{{ route('projectmanager.daily-tasks.index', $pm->id ?? 1) }}" class="btn btn-outline-primary">
                            View All My Daily Tasks <i class="fas fa-arrow-right ms-1"></i>
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
<!-- Salary Section - Only show on dashboard -->
@if(request()->routeIs('projectmanager.dashboard'))
<div class="row mb-4 mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header" style="background-color: #021128ff; color: white;">
    <h5 class="mb-0">
        <i class="fas fa-money-bill-wave me-2"></i>My Salary Details
    </h5>
</div>
            <div class="card-body">
                @if(isset($salaryDetails) && $salaryDetails->count() > 0)
                    <div class="row salary-quick-stats">
                        <!-- Quick Stats -->
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Current Salary</h6>
                                    <h3 class="text-info mb-0">
                                        Rs. {{ number_format($currentSalary ?? 0, 2) }}
                                    </h3>
                                    <small class="text-muted">per month</small>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Last Payment</h6>
                                    <h4 class="text-success mb-0">
                                        Rs. {{ number_format($lastPayment ?? 0, 2) }}
                                    </h4>
                                    <small class="text-muted">
                                        {{ $lastPaymentDate ? \Carbon\Carbon::parse($lastPaymentDate)->format('d M Y') : 'N/A' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2">Pending</h6>
                                    <h4 class="text-warning mb-0">
                                        Rs. {{ number_format($pendingAmount ?? 0, 2) }}
                                    </h4>
                                    <small class="text-muted">to be processed</small>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <!-- Salary Table -->
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-striped salary-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Month</th>
                                    <th>Basic Salary</th>
                                    <th>Allowances</th>
                                    <th>Deductions</th>
                                    <th>Net Salary</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryDetails as $index => $salary)
                                    @php
                                        // Calculate allowances and deductions (you can modify this based on your logic)
                                        $allowances = $salary->amount * 0.1; // 10% allowance example
                                        $deductions = $salary->amount * 0.05; // 5% deduction example
                                        $netSalary = $salary->amount + $allowances - $deductions;
                                    @endphp
                                    <tr>
                                        <td data-label="#">{{ $index + 1 }}</td>
                                        <td data-label="Month">
                                            <strong>{{ \Carbon\Carbon::parse($salary->salary_month)->format('M Y') }}</strong><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($salary->salary_month)->format('F') }}</small>
                                        </td>
                                        <td data-label="Basic Salary">Rs. {{ number_format($salary->amount, 2) }}</td>
                                        <td data-label="Allowances" class="text-success">+ Rs. {{ number_format($allowances, 2) }}</td>
                                        <td data-label="Deductions" class="text-danger">- Rs. {{ number_format($deductions, 2) }}</td>
                                        <td data-label="Net Salary" class="fw-bold text-primary">Rs. {{ number_format($netSalary, 2) }}</td>
                                        <td data-label="Status">
                                            @if($salary->status == 'paid')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Paid
                                                </span>
                                                @if($salary->updated_at)
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($salary->updated_at)->format('d/m') }}
                                                    </small>
                                                @endif
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Action">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info view-slip"
                                                        data-salary-id="{{ $salary->id }}">
                                                    <i class="fas fa-file-invoice"></i>
                                                </button>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-outline-success download-payslip"
                                                   data-month="{{ $salary->salary_month }}">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if(isset($totalNetSalary))
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total Net Salary:</td>
                                        <td class="fw-bold text-success">Rs. {{ number_format($totalNetSalary, 2) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                  
                  
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-money-bill-wave fa-4x text-info opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-3">No salary records available</h5>
                        <p class="text-muted mb-4">Salary information will be displayed here once processed.</p>
                        <button class="btn btn-outline-info" onclick="requestSalaryInfo()">
                            <i class="fas fa-paper-plane me-2"></i> Request Salary Information
                        </button>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-light">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <small class="text-muted">
                                Salary payments are processed between 1st - 5th of each month.
                                Contact accounts@netit.lk for queries.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-info" onclick="exportSalaryData()">
                                <i class="fas fa-file-export me-1"></i> Export
                            </button>
                            <button class="btn btn-sm btn-info" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
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
          <a href="https://www.facebook.com/share/1BqiRiXiP5/" title="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="https://netittechnology.com/" target="_blank" title="Website">
    <i class="fas fa-globe"></i>
</a>
        </div>
      </div>
      
      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="footer-links">
          <li><a href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}">
                        <i class="fa fa-home me-1"></i> Dashboard</a></li>
          <li><a href="{{ route('projectmanager.tasks.index', $pm->id ?? 1) }}">
                        <i class="fa fa-tasks me-1"></i>Tasks</a></li>
          <li><a href="{{ route('projectmanager.daily-tasks.index') }}"><i class="fas fa-clipboard-check"></i> Day Updates Tasks</a></li>
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
    <a href="mailto:info@netittechnology.com">
        info@netittechnology.com
    </a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize salary charts
document.addEventListener('DOMContentLoaded', function() {
    // View salary slip
    const viewButtons = document.querySelectorAll('.view-slip');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const salaryId = this.dataset.salaryId;
            viewSalarySlip(salaryId);
        });
    });
   
    // Download payslip
    const downloadButtons = document.querySelectorAll('.download-payslip');
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const month = this.dataset.month;
            downloadPayslip(month);
        });
    });
   
    // Initialize charts if data exists
    @if(isset($salaryChartData))
    initCharts(@json($salaryChartData));
    @endif
});
function viewSalarySlip(salaryId) {
    // You can implement AJAX call to fetch and display salary slip
    alert('Viewing salary slip #' + salaryId + '\nThis would open a detailed view in a modal.');
    // Example AJAX implementation:
    /*
    fetch(`/api/salary-slip/${salaryId}`)
        .then(response => response.json())
        .then(data => {
            // Display in modal
        });
    */
}
function downloadPayslip(month) {
    alert('Downloading payslip for ' + month);
    // Implement download functionality
}
function requestSalaryInfo() {
    const subject = encodeURIComponent('Salary Information Request - Project Manager');
    const body = encodeURIComponent(`Dear Accounts Department,\n\nI would like to request information about my salary details.\n\nThank you,\nProject Manager`);
    window.location.href = `mailto:accounts@netit.lk?subject=${subject}&body=${body}`;
}
function exportSalaryData() {
    alert('Exporting salary data...');
    // Implement export functionality (CSV, PDF, etc.)
}
function initCharts(chartData) {
    // Salary Trend Chart
    const ctx1 = document.getElementById('salaryChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: chartData.months || [],
            datasets: [{
                label: 'Net Salary',
                data: chartData.amounts || [],
                borderColor: '#36a2eb',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
   
    // Payment Status Chart
    const ctx2 = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending'],
            datasets: [{
                data: chartData.status || [70, 30],
                backgroundColor: ['#4bc0c0', '#ffcd56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
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
document.addEventListener('DOMContentLoaded', () => {
    typeWriter("Welcome to NetIT Technology....!", "typingText");
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const taskCards = document.querySelectorAll('.task-card');
        taskCards.forEach(card => {
            card.addEventListener('click', function () {
                // Remove active class from all cards
                taskCards.forEach(c => c.classList.remove('active'));
                // Add active class to clicked card
                this.classList.add('active');
            });
        });
    });
</script>
@yield('scripts')
</body>
</html>