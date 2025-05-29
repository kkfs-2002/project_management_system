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
      color: #FFD700 !important; /* Gold */
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
          <a class="nav-link" href="{{ url('/superdash') }}">
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
            <li><a class="dropdown-item" href="#">Attendance Tracker</a></li>
            <li><a class="dropdown-item" href="#">Leave & Presence Report</a></li>
            <li><a class="dropdown-item" href="#">Monthly Working Hour Summary</a></li>
          </ul>
        </li>

        <!-- Projects -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-folder-open me-1"></i> Projects
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsDropdown">
            <li><a class="dropdown-item" href="#">Add Project</a></li>
            <li><a class="dropdown-item" href="#">Project List</a></li>
            <li><a class="dropdown-item" href="#">Project Status Update</a></li>
            <li><a class="dropdown-item" href="#">Assigned Employees</a></li>
            <li><a class="dropdown-item" href="#">Hosting & Domain Details</a></li>
            <li><a class="dropdown-item" href="#">Upcoming Deadlines</a></li>
          </ul>
        </li>

        <!-- Finance -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-money-bill-wave me-1"></i> Finance
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="financeDropdown">
            <li><a class="dropdown-item" href="#">Add Financial Entry</a></li>
            <li><a class="dropdown-item" href="#">View All Transactions</a></li>
            <li><a class="dropdown-item" href="#">Monthly Sheets</a></li>
            <li><a class="dropdown-item" href="#">Expense Tracker</a></li>
            <li><a class="dropdown-item" href="#">Developer Salary View</a></li>
            <li><a class="dropdown-item" href="#">Profit/Loss Summary</a></li>
          </ul>
        </li>

        <!-- Payments & Documents -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="paymentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-file-invoice-dollar me-1"></i> Payments & Docs
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="paymentsDropdown">
            <li><a class="dropdown-item" href="#">Generate Invoice</a></li>
            <li><a class="dropdown-item" href="#">Client Payment Status</a></li>
            <li><a class="dropdown-item" href="#">Expense List</a></li>
            <li><a class="dropdown-item" href="#">Upload Documents</a></li>
            <li><a class="dropdown-item" href="#">View Contracts</a></li>
            <li><a class="dropdown-item" href="#">Hosting & Domain Credentials</a></li>
          </ul>
        </li>

        <!-- Admin Tools -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminToolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs me-1"></i> Admin Tools
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminToolsDropdown">
            <li><a class="dropdown-item" href="#">Admin Profile</a></li>
            <li><a class="dropdown-item" href="#">Roles & Permissions</a></li>
            <li><a class="dropdown-item" href="#">Notification Center</a></li>
            <li><a class="dropdown-item" href="#">Activity Logs</a></li>
            <li><a class="dropdown-item" href="#">Change Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
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

</body>
</html>
