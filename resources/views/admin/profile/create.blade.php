<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Create Profile</title>
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

    .form-container {
      background: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 40px auto 60px;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Dashboard</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <!-- Centered Dropdown -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="profileDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
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
    <h1>Create Profile</h1>
  </header>

  <!-- Form Container -->
  <div class="form-container">
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required />
      </div>

      <div class="mb-3">
        <label for="nic" class="form-label">NIC</label>
        <input type="text" class="form-control" id="nic" name="nic" placeholder="Enter NIC" required />
      </div>

      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" id="category" name="category" required>
          <option value="" selected disabled>Select category</option>
          <option value="superadmin">Super Admin</option>
          <option value="admin">Admin</option>
          <option value="web developer">Web Developer</option>
          <option value="marketing">Marketing</option>
          <option value="pm">Project Manager</option>
          <option value="qa">QA</option>
          <option value="ba">BA</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required />
      </div>

      <div class="mb-4">
        <label for="profile_picture" class="form-label">Profile Picture (optional)</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" />
      </div>

      <button type="submit" class="btn btn-secondary w-100">Create Profile</button>
    </form>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>