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

    /* .navbar-custom {
      background-color: #000000;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 6px #000000;
      z-index: 1050;
    } */

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
   .footer {
    background: #000000 url('{{ asset("images/ma.jpg") }}') no-repeat center center;
    background-size: cover; /* make image cover entire footer */
    color: #fff;
    padding: 50px 0 20px;
    margin-top: auto;
    position: relative;
}

.footer::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7); /* dark overlay for text readability */
    z-index: 0;
}

.footer > * {
    position: relative;
    z-index: 1; /* make text and links appear above overlay */
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
    /* HERO SECTION BASE */
.netit-hero {
    position: relative;
    height: 90vh;
   background: url('{{ asset("images/ma.jpg") }}') center/cover no-repeat;

    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0;
    margin: 0;
}

/* DARK OVERLAY */
.netit-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.55);
}

/* CONTENT */
.netit-content {
    position: relative;
    z-index: 2;
    max-width: 750px;
    padding: 20px;
    color: white;
}

/* TITLE */
.netit-title {
    font-size: 3.8rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* SUBTEXT */
.netit-subtext {
    font-size: 1.2rem;
    font-weight: 300;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* BUTTON */
.netit-btn {
    background: #ffffff;
    padding: 12px 28px;
    border-radius: 40px;
    font-size: 1.1rem;
    color: #000;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s ease-in-out;
}

.netit-btn:hover {
    background: #A7C7E7;
    color: #000;
    transform: translateY(-3px);
}
.netit-marketing-icon {
    font-size: 60px;
    color: #ffffffff;
    margin-top: 20px;
}
.netit-title {
    font-family: 'Monotype Corsiva', cursive;
    font-size: 48px; /* adjust size if needed */
    color: #ffffffff;     /* text color */
    font-weight: 20px; /* Monotype Corsiva usually looks better without bold */
}
.netit-subtext {
    font-family: 'Times New Roman', serif;
    font-size: 30px;       /* adjust as needed */
    color: #ffffffff;           /* text color */
    line-height: 1.6;      /* readability */
    margin-top: 12px;
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
<div class="container-fluid p-0">

<!-- HERO SECTION -->
<section class="netit-hero">
    <div class="netit-overlay"></div>

    <div class="netit-content">

        <!-- 🔥 Logo Above Title -->
    <i class="fas fa-user-tie netit-marketing-icon"></i>


     <h1 class="netit-title">Marketing Manager Dashboard</h1>

<p class="netit-subtext">
    Welcome to the Marketing Manager Dashboard. 
    Manage campaigns, track performance, and discover actionable insights to grow your business.
</p>
    </div>
</section>




</div>
</div>
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
<!-- Salary Section - Only show on dashboard -->
@if(request()->routeIs('marketing.dashboard'))
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>My Salary Details
                </h5>
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
                                        <td class="fw-bold text-success">Rs. {{ number_format($salary->amount, 2) }}</td>
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
                                            <button class="btn btn-sm btn-outline-success view-salary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#marketingSalaryModal"
                                                    data-salary='@json($salary)'>
                                                <i class="fas fa-file-invoice-dollar"></i> Details
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
                    <a href="mailto:accounts@netit.lk?subject=Salary Inquiry" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-envelope me-1"></i> Contact Accounts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Marketing Salary Modal -->
<div class="modal fade" id="marketingSalaryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Salary Slip Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="salary-details-content">
                    <!-- Content will be loaded by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="printSalarySlip()">
                    <i class="fas fa-print me-1"></i> Print Slip
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-salary');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const salary = JSON.parse(this.dataset.salary);
            const content = `
                <div class="salary-slip">
                    <div class="text-center mb-4">
                        <h4 class="text-success">NET IT TECHNOLOGY</h4>
                        <p class="text-muted mb-0">Salary Slip</p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Employee:</strong> Marketing Manager</p>
                            <p><strong>Month:</strong> ${new Date(salary.salary_month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</p>
                            <p><strong>Payment Status:</strong> 
                                ${salary.status === 'paid' 
                                    ? '<span class="badge bg-success">Paid</span>' 
                                    : '<span class="badge bg-warning">Pending</span>'}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Method:</strong> ${salary.payment_method ? salary.payment_method.replace('_', ' ').toUpperCase() : 'N/A'}</p>
                            <p><strong>Processed Date:</strong> ${salary.updated_at ? new Date(salary.updated_at).toLocaleDateString() : 'N/A'}</p>
                            <p><strong>Record ID:</strong> ${salary.id}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="salary-breakdown">
                        <h6 class="mb-3">Salary Breakdown</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Basic Salary</strong></td>
                                        <td class="text-end">Rs. ${Number(salary.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Allowances</strong></td>
                                        <td class="text-end">Rs. 0.00</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Deductions</strong></td>
                                        <td class="text-end">Rs. 0.00</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Net Salary</strong></td>
                                        <td class="text-end fw-bold">Rs. ${Number(salary.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    ${salary.notes ? `
                        <div class="notes-section mt-3">
                            <h6>Notes</h6>
                            <div class="alert alert-info">
                                ${salary.notes}
                            </div>
                        </div>
                    ` : ''}
                    
                    <div class="signature-section mt-4 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <p class="border-top pt-2">Employee Signature</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="border-top pt-2">Authorized Signature</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('salary-details-content').innerHTML = content;
        });
    });
});

function printSalarySlip() {
    const content = document.getElementById('salary-details-content').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Salary Slip</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .salary-slip { max-width: 800px; margin: 0 auto; }
                .table { width: 100%; border-collapse: collapse; }
                .table th, .table td { border: 1px solid #ddd; padding: 8px; }
                .text-end { text-align: right; }
                .text-center { text-align: center; }
                .border-top { border-top: 1px solid #000; }
                .fw-bold { font-weight: bold; }
                .alert-info { background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 10px; border-radius: 4px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            ${content}
            <div class="no-print text-center mt-4">
                <button onclick="window.print()" class="btn btn-success">Print</button>
                <button onclick="window.close()" class="btn btn-secondary">Close</button>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
@endif

<!-- Footer Section -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-lg-4 col-md-6 mb-4 mt-4">
        
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
              +94 76 151 7778
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
        <div class="col-md-6">
          
        </div>
      </div>
    </div>
  </div>
</footer>


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