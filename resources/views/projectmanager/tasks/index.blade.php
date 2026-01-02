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
            padding-top: 80px; /* Account for fixed navbar */
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
        .dropdown-item:hover {
            background-color: #222;
            color: #FFD700;
        }
        /* Task Table Styles */
        .task-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        .task-table th, .task-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .task-table th {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
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
        .badge.bg-info { background-color: #00c6ff; }
        .badge.bg-warning { background-color: #FFD700; color: #212529; }
        
        .btn-forward {
            padding: 6px 14px;
            font-size: 14px;
            cursor: pointer;
            background-color: #FFD700;
            border: none;
            border-radius: 4px;
            color: #212529;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-forward:hover {
            background-color: #020d1fff;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
        }
        
        .alert-success {
            color: #155724;
            background: #d4edda;
            padding: 12px 20px;
            border-left: 4px solid #28a745;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: 500;
        }
        .btn-primary {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #010e21ff 0%, #00c6ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 198, 255, 0.3);
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        h3 {
            color: #020d1fff;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #FFD700;
        }
        h3 strong {
            color: #00c6ff;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-select, .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }
        .form-select:focus, .form-control:focus {
            border-color: #00c6ff;
            box-shadow: 0 0 0 0.2rem rgba(0, 198, 255, 0.25);
        }
        .text-muted {
            color: #888 !important;
        }
        /* Footer */
        .footer {
            background: #000000 url('{{ asset("images/fo.jpg") }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 50px 0 20px;
            position: relative;
            margin-top: 60px;
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
    <!-- Mobile and Responsive Styles -->
    <style>
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            body {
                padding-top: 70px; /* Adjust for mobile navbar height */
            }
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

            /* Main content */
            .container {
                padding: 1rem;
            }

            h3 {
                font-size: 1.5rem;
                text-align: center;
            }

            /* Filter form */
            .row.g-2 > .col-md-3 {
                margin-bottom: 1rem;
            }
            .form-control, .form-select {
                font-size: 0.875rem;
            }
            .align-self-end {
                margin-top: 1rem;
            }
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            /* Tasks table */
            .task-table {
                border: 0;
                font-size: 0.875rem;
            }
            .task-table thead {
                display: none;
            }
            .task-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
                padding: 1rem;
                background-color: #fff;
            }
            .task-table td {
                display: block;
                text-align: right;
                padding: 0.5rem 0;
                border: none;
                position: relative;
                padding-left: 50%;
            }
            .task-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-right: 1rem;
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
                color: #6c757d;
            }
            .task-table .fw-bold {
                font-weight: bold;
            }
            .task-table .text-muted {
                font-size: 0.75rem;
            }
            .task-table .badge {
                display: inline-block;
                white-space: nowrap;
                font-size: 0.75rem;
            }
            .task-table .btn-forward {
                width: 100%;
                margin-top: 0.5rem;
            }

            /* Footer */
            .footer {
                padding: 2rem 0 1rem;
                margin-top: 2rem;
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
            .footer-links li,
            .contact-info li {
                margin-bottom: 0.75rem;
            }
            .social-links {
                justify-content: center;
                gap: 10px;
            }
            .social-links a {
                width: 35px;
                height: 35px;
            }
            .footer-bottom {
                margin-top: 2rem;
                padding-top: 1rem;
            }
            .footer-bottom p {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            body {
                font-size: 0.875rem;
                padding-top: 60px;
            }
            .container {
                padding: 0.5rem;
            }
            h3 {
                font-size: 1.25rem;
            }
            .task-table {
                font-size: 0.8rem;
            }
            .task-table td {
                padding: 0.375rem 0;
            }
            .task-table td:before {
                font-size: 0.8rem;
                width: 40%;
            }
            .footer {
                padding: 1.5rem 0 0.5rem;
            }
            .footer h5 {
                font-size: 0.95rem;
            }
            .footer p,
            .footer-links a,
            .contact-info div {
                font-size: 0.8rem;
            }
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
<div class="container mt-4">
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
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
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
                <td data-label="Title">{{ $task->title }}</td>
                <td data-label="Description">{{ $task->description }}</td>
                <td data-label="Developer">{{ $task->developer_name }}</td>
                <td data-label="Start Date">{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                <td data-label="Deadline">{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}</td>
                <td data-label="Status">
                    <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'Forwarded' ? 'info' : 'warning') }}">
                        {{ $task->status }}
                    </span>
                </td>
                <td data-label="Action">
                    @if($task->status === 'Pending')
                        <form method="POST" action="{{ route('projectmanager.tasks.forward', $task->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-forward">
                                Forward to Developer
                            </button>
                        </form>
                    @else
                        <span class="text-muted">Already Forwarded</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No tasks found for this project.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<!-- Footer Section -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-lg-4 col-md-6 col-12 mb-4">
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
      <div class="col-lg-2 col-md-6 col-12 mb-4">
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
      <div class="col-lg-2 col-md-6 col-12 mb-4">
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
      <div class="col-lg-4 col-md-6 col-12 mb-4">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>