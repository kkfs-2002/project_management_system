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
   
    <!-- Tasks Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header" style="background-color: #020d1fff; color: white;">
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
                                <button type="submit" class="btn w-100" style="background-color: #010e21ff; color: white;">
    Filter
</button>

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