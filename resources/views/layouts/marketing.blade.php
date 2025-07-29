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
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/marketing-dashboard') }}">
      <img src="{{ asset('NetIT logo.png') }}" alt="Marketing Manager" />
      <span>Welcome, Marketing Manager</span>
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
        <li class="nav-item">
    <a class="nav-link" href="{{ route('marketing.clients.report') }}">
        <i class="fas fa-chart-bar"></i> Report
    </a>
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
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
