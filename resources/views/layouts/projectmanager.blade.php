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
            background-color: rgba(0, 0, 0, .75);
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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container-fluid">
        <!-- Left: Logo and Welcome -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('layouts.projectmanager', $pm->id ?? 1) }}">
            <img src="{{ asset('NetIT logo.png') }}" alt="PM" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
            <span>Welcome, {{ $pm->full_name ?? 'Project Manager' }}</span>
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pmNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links and logout -->
        <div class="collapse navbar-collapse" id="pmNavbar">
            <!-- Centered Links -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tasksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-tasks me-1"></i> Tasks
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="tasksDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('projectmanager.tasks.index', $pm->id ?? 1) }}">All Tasks</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Right-aligned Logout Dropdown -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pmDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-1"></i> {{ $pm->full_name ?? 'Account' }}
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

<!-- Main content -->
<div class="container mt-4" style="padding-top:100px;">
    @yield('content')
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
