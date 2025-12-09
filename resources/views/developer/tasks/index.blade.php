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
        <!-- Left: Logo and Welcome -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('layouts.developer', $dev->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="Dev" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ $dev->full_name ?? 'Developer' }}</span>
        </a>

        <!-- Navbar toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#devNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center: Navigation Links -->
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

            <!-- Right: User Dropdown with Logout -->
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

<!-- Main content -->
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
</style>

<div class="container">
    <h3>Tasks</h3>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('developer.tasks.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <label for="project_id" class="form-label">Filter by Project</label>
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
                <label for="status" class="form-label">Filter by Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Forwarded" {{ request('status') == 'Forwarded' ? 'selected' : '' }}>Forwarded</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="month" class="form-label">Filter by Month</label>
                <input type="month" name="month" id="month" value="{{ request('month') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('developer.tasks.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Task Table -->
    <table class="task-table">
        <thead>
            <tr>
                
                <th>Project</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    
                    <td>{{ $task->project->name ?? 'N/A' }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td>
                        @if($task->status === 'Forwarded')
                            <form action="{{ route('developer.tasks.complete', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Mark as Completed
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Already Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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