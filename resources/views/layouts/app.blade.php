<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Super Admin Dashboard')</title>

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
      padding: 10px 15px;
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
       margin-left: 10px;
       margin-right: 10px;
    }

    .navbar-brand span {
     color: #d1d1d1;
     font-weight: 600;
     font-size: 1.1rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/superdash') }}">
      <img src="{{ asset('NetIT logo.png') }}" alt="Super Admin" />
      <span>Welcome, Super Admin</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#superNav" aria-controls="superNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="superNav">
      <ul class="navbar-nav ms-auto align-items-center">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
            <i class="fas fa-home me-1"></i> Dashboard
          </a>
        </li>

        <!-- Employees -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="employeesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-users me-1"></i> Employees
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="employeesDropdown">
            <li><a class="dropdown-item" href="{{ route('superadmin.employee.create') }}">Add Employee</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.employee.index') }}">Employee List</a></li>
            
          </ul>
        </li>
        
        <!--Mark attendance-->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="employeesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-clipboard-check me-1"></i> Attendance
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="employeesDropdown">
            <li><a class="dropdown-item" href="{{ route('attendance.index') }}">Mark attendance</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.attendance.employee.month') }}">Attendance Tracker</a></li>
          </ul>
        </li>



                <!-- Tasks -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-folder-open me-1"></i> Tasks
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsDropdown">
            <li><a class="dropdown-item" href="{{ route('superadmin.tasks.create') }}">Create Task</a></li>
                        <li><a class="dropdown-item" href="{{ route('superadmin.tasks.index') }}">View Task</a></li>

          </ul>
        </li>

        <!-- Finance -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-money-bill-wave me-1"></i> Accounts
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="financeDropdown">
            <li><a class="dropdown-item" href="{{ route('superadmin.project.index') }}">Add Financial Entry</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.project.transactions') }}">View All Transactions</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.expenses.index') }}">Expense Tracker</a></li>
          
            <li><a class="dropdown-item" href="{{ route('superadmin.salary.index') }}">Employee Salary View</a></li>


         
          </ul>
        </li>


 <!-- Marketing -->
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="marketingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-bullhorn me-1"></i> Marketing
  </a>
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="marketingDropdown">
    <li><a class="dropdown-item" href="{{ route('superadmin.clients.index') }}">Client List</a></li>
  </ul>
</li>


        <!-- Admin Tools -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminToolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs me-1"></i> Admin Tools
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminToolsDropdown">

            <li><a class="dropdown-item" href="{{ route('superadmin.password.editSelf') }}">Change My Password</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.password.list') }}">Change Employee Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container-fluid" style="padding-top: 100px;">
  @yield('content')
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel"><i class="fas fa-sign-out-alt me-2"></i>Confirm Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">Are you sure you want to log out?</p>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST">
         @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
