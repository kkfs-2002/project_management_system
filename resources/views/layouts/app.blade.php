<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Super Admin Dashboard') - Project Management System</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <!-- Add this in <head> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Add this in <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Optional: Your custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand img {
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <!-- Brand / Logo -->
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/superdash') }}">
      <img src="{{ asset('images/superadmin.jpg') }}" alt="Super Admin"
           style="width:40px; height:40px; border-radius:50%; margin-right:10px;">
      <span>Super Admin</span>
    </a>

    <!-- Mobile toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSuperDash"
      aria-controls="navbarSuperDash" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar items -->
    <div class="collapse navbar-collapse" id="navbarSuperDash">
      <ul class="navbar-nav ms-auto align-items-center">

        <!-- Notification Icon -->
        <li class="nav-item me-3 position-relative">
          <a class="nav-link position-relative" href="#" title="Notifications">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                 class="bi bi-bell" viewBox="0 0 16 16">
              <path d="M8 16a2 2 0 0 0 1.985-1.75H6.015A2 2 0 0 0 8 16zm.104-14.25A5.002 5.002 0 0 0 3 7c0 1.098-.347 2.17-1 3v1h12v-1c-.653-.83-1-1.9-1-3a5.002 5.002 0 0 0-4.896-4.25zM7 1a7 7 0 0 1 7 7c0 1.192.584 2.433 1.41 3.3a.5.5 0 0 1-.392.7H1.982a.5.5 0 0 1-.392-.7C2.416 10.433 3 9.192 3 8a7 7 0 0 1 7-7z"/>
            </svg>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              3
              <span class="visually-hidden">unread notifications</span>
            </span>
          </a>
        </li>

                    <!-- Customer dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="customerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-2"></i> Customer
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerDropdown">
                <li><a class="dropdown-item" href="{{ url('/customer/profile') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ url('/customer/orders') }}">Orders</a></li>
                <li><a class="dropdown-item" href="{{ url('/customer/history') }}">History</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ url('/customer/support') }}">Support</a></li>
            </ul>
            </li>

            <!-- Marketing dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="marketingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bullhorn me-2"></i> Marketing
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="marketingDropdown">
                <li><a class="dropdown-item" href="{{ url('/marketing/campaigns') }}">Campaigns</a></li>
                <li><a class="dropdown-item" href="{{ url('/marketing/analytics') }}">Analytics</a></li>
                <li><a class="dropdown-item" href="{{ url('/marketing/leads') }}">Leads</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ url('/marketing/reports') }}">Reports</a></li>
            </ul>
            </li>

            <!-- Account dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-cog me-2"></i> Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                <li><a class="dropdown-item" href="{{ url('/account/profile') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ url('/account/settings') }}">Settings</a></li>
                <li><a class="dropdown-item" href="{{ url('/account/billing') }}">Billing</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ url('/account/logout') }}">Logout</a></li>
            </ul>
            </li>

            <!-- Develop dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="developDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-code me-2"></i> Develop
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="developDropdown">
                <li><a class="dropdown-item" href="{{ url('/employees/create') }}">Add Employee</a></li>
                <li><a class="dropdown-item" href="{{ url('/develop/settings') }}">Manage Employees</a></li>
                <li><a class="dropdown-item" href="{{ url('/develop/logs') }}">Roles & Permissions</a></li>
                <li><a class="dropdown-item" href="{{ url('/develop/logs') }}">Activity Logs</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ url('/develop/logs') }}">Employee Details</a></li>
            </ul>
            </li>

            </nav>

<!-- Main Content -->
<div class="container my-4">
    @yield('content')
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
