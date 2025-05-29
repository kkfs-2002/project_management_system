<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - All Profiles</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f4f6f9;
    }

    .dashboard-header {
      padding: 60px 0;
      background-color: #e9ecef;
      text-align: center;
    }

    .filter-form {
      margin-top: 20px;
    }

    .table-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
      max-width: 95%;
      margin: 30px auto;
      overflow-x: auto;
    }

    table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
    }

    thead {
      background-color: #d4af37; 
      color: white;
    }

    th, td {
      text-align: center;
      vertical-align: middle;
      padding: 12px;
    }

    tbody tr {
      transition: background 0.2s ease-in-out;
    }

    tbody tr:hover {
      background-color: #f1f3f5;
    }

    .profile-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
  <div class="container filter-form mb-4">
    <form action="{{ route('profile.index') }}" method="GET" class="row g-3 justify-content-center">
      <div class="col-auto">
        <select name="category" class="form-select">
          <option value="">All Categories</option>
          <option value="superadmin" {{ request('category') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
          <option value="admin" {{ request('category') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="web developer" {{ request('category') == 'web developer' ? 'selected' : '' }}>Web Developer</option>
          <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
          <option value="pm" {{ request('category') == 'pm' ? 'selected' : '' }}>Project Manager</option>
          <option value="qa" {{ request('category') == 'qa' ? 'selected' : '' }}>QA</option>
          <option value="ba" {{ request('category') == 'ba' ? 'selected' : '' }}>BA</option>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
    </form>
  </div>

  <!-- Table Container -->
  <div class="table-container">
    <table class="table table-bordered">
      <thead>
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
              <img src="{{ asset('uploads/' . $profile->profile_picture) }}" class="profile-img" alt="Profile Picture">
            @else
              <span class="text-muted">No Image</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted">No profiles found for this category.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
