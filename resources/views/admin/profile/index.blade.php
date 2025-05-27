<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - All Profiles</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .dashboard-header {
      padding: 60px 0;
      background-color: #e9ecef;
      text-align: center;
    }
    .table-container {
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 1000px;
      margin: 40px auto 60px;
      overflow-x: auto;
    }
    table img {
      border-radius: 5px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
            Profile
          </a>
          <ul class="dropdown-menu" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="{{ route('profile.create') }}">Create Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">View Profiles</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<header class="dashboard-header">
  <h1>All Profiles</h1>
</header>

<!-- Filter Form -->
<div class="container mb-4">
  <form action="{{ route('profile.index') }}" method="GET" class="row g-3 justify-content-center">
    <div class="col-auto">
      <select name="category" class="form-select">
        <option value="">All Categories</option>
        <option value="web developer" {{ request('category') == 'web developer' ? 'selected' : '' }}>Web Developer</option>
        <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
        <option value="pm" {{ request('category') == 'pm' ? 'selected' : '' }}>Project Manager</option>
        <option value="qa" {{ request('category') == 'qa' ? 'selected' : '' }}>QA</option>
        <option value="ba" {{ request('category') == 'ba' ? 'selected' : '' }}>BA</option>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-secondary">Filter</button>
    </div>
  </form>
</div>

<!-- Table Container -->
<div class="table-container">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Full Name</th>
        <th>NIC</th>
        <th>Category</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Password</th>
        <th>Username</th>
        <th>Profile Picture</th>
      </tr>
    </thead>
    <tbody>
      @forelse($profiles as $profile)
        <tr>
          <td>{{ $profile->full_name }}</td>
          <td>{{ $profile->nic }}</td>
          <td>{{ $profile->category }}</td>
          <td>{{ $profile->phone }}</td>
          <td>{{ $profile->email }}</td>
          <td>{{ $profile->password }}</td>
          <td>{{ $profile->username }}</td>
          <td>
            @if($profile->profile_picture)
              <img src="{{ asset('uploads/' . $profile->profile_picture) }}" width="50" height="50" alt="Profile Pic">
            @else
              <span class="text-muted">No Image</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center">No profiles found for this category.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
