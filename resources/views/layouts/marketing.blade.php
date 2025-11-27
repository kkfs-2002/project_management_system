<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Marketing Dashboard')</title>

  <!-- Bootstrap and Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-custom {
      background-color: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      z-index: 1050;
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link,
    .navbar-custom .dropdown-toggle {
      color: #fff;
      font-weight: 500;
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .dropdown-toggle:hover,
    .navbar-custom .dropdown-item:hover {
      color:#A7C7E7; 
    }

    .dropdown-menu {
      background-color: #111;
      border: none;
    }

    .dropdown-item {
      color: #f1f1f1;
      padding: 10px 20px;
      font-size: 0.95rem;
      transition: background 0.2s ease;
    }

    .dropdown-divider {
      border-color: rgba(255, 255, 255, 0.1);
    }

    .navbar-brand img {
      border-radius: 50%;
      width: 40px;
      height: 40px;
      object-fit: cover;
      margin-right: 10px;
    }

    .badge-custom {
      background-color: #dc3545;
      font-size: 0.7rem;
    }

    .navbar-nav > li.nav-item {
       margin-left: 15px;
       margin-right: 15px;
    }

    .navbar-brand span {
     color: #d1d1d1;
     font-weight: 600;
     font-size: 1.1rem;
    }

    /* Attendance Card Styles */
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

    /* Dashboard Stats */
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
    .stat-active { border-left-color: #28a745; }
    .stat-inactive { border-left-color: #6c757d; }
    .stat-reminders { border-left-color: #ffc107; }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('marketing.dashboard') }}">
      <img src="{{ asset('NetIT logo.png') }}" alt="Marketing Manager" />
      <span>Welcome, {{ $marketing->full_name ?? 'Marketing Manager' }}</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#marketingNav" aria-controls="marketingNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="marketingNav">
      <ul class="navbar-nav ms-auto align-items-center">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('marketing.dashboard') }}">
            <i class="fas fa-home me-1"></i> Dashboard
          </a>
        </li>

        <!-- Clients -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="clientsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-tie me-1"></i> Clients
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="clientsDropdown">
            <li><a class="dropdown-item" href="{{ route('marketing.clients.create') }}">Add Client</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.index') }}">View Clients</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.reminders') }}">Reminders by Date</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.status', 'active') }}">Active Clients</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.status', 'inactive') }}">Inactive Clients</a></li>
          </ul>
        </li>

        <!-- Reports -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-chart-line me-1"></i> Reports
          </a>
          <ul class="dropdown-menu" aria-labelledby="reportDropdown">
            <li><a class="dropdown-item" href="{{ route('marketing.clients.report') }}">📅 Monthly Client Report</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.summary') }}">📊 Client Summary Chart</a></li>
          </ul>
        </li>

        <!-- Day Updates Tasks -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="tasksDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-target me-1"></i> Day Updates Tasks 
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('marketing.daily-tasks.index') }}">Daily Tasks</a></li>
            </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link btn btn-link text-danger" style="background: none; border: none; padding: 0;">
                  <i class="fas fa-sign-out-alt me-1"></i> Logout
              </button>
          </form>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container-fluid" style="padding-top: 100px;">
  @yield('content')

  <!-- Attendance Section - Only show on dashboard -->
  @if(request()->routeIs('marketing.dashboard'))
  <div class="row mb-4">
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
                              <form action="{{ route('marketing.attendance.checkin') }}" method="POST" id="checkin-form" onsubmit="showLoader(event, 'Checking in...')">
                                  @csrf
                                  <input type="hidden" name="timezone" id="timezone-input">
                                  <button type="submit" class="btn btn-attendance btn-check-in text-white" id="checkin-btn"
                                      @if(isset($todayAttendance) && $todayAttendance->check_in) disabled @endif>
                                      <i class="fas fa-sign-in-alt me-2"></i>Check In
                                  </button>
                              </form>
                              
                              <!-- Check Out Button -->
                              <form action="{{ route('marketing.attendance.checkout') }}" method="POST" id="checkout-form" onsubmit="showLoader(event, 'Checking out...')">
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
                      <a href="{{ route('marketing.attendance.history') }}" class="btn btn-light btn-sm">
                          <i class="fas fa-history me-2"></i>View Attendance History
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  

  @endif
  
</div>

<!-- JS -->
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