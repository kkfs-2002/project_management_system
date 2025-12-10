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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .main-content {
            flex: 1;
            padding-top: 100px;
            padding-bottom: 40px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .welcome-card h1 {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .welcome-card p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .date-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .date-info span {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        #currentTime {
            color: #FFD700;
            font-size: 2rem !important;
            margin-top: 5px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #020d1fff 0%, #010e21ff 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px 30px;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: #FFD700;
        }

        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }

        .bg-primary {
            background-color: #00c6ff !important;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .project-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 200px;
        }

        .project-card:hover {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            border-color: #00c6ff;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 10px;
            width: fit-content;
        }

        .status-active {
            background: rgba(0, 198, 255, 0.1);
            color: #00c6ff;
            border: 1px solid rgba(0, 198, 255, 0.3);
        }

        .project-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .project-description {
            flex-grow: 1;
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .date-info-project {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .date-info-project > div span {
            display: block;
            color: #888;
            margin-bottom: 3px;
        }

        .date-info-project .date {
            font-weight: 600;
            color: #020d1fff;
        }

        .btn-view-tasks {
            background-color: #0b0c21ff;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-view-tasks:hover {
            background-color: #0c2b30ff;
            color: #fff;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state i {
            color: #d0d0d0;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #888;
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

        @media (max-width: 768px) {
            .projects-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .welcome-card h1 {
                font-size: 1.6rem;
            }

            .welcome-card {
                padding: 25px;
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

<main class="main-content">
    <div class="container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Welcome back, Project Manager!</h1>
                    <p>Manage your projects efficiently and track progress in real-time.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="date-info">
                        <span id="currentDate"></span>
                        <div id="currentTime" class="fw-bold"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        <div class="card border-0 shadow-lg">
            <div class="card-header border-0 py-4">
                <h3 class="card-title mb-0">
                    <i class="fas fa-folder-open me-3"></i>
                    Available Projects
                    <span class="badge bg-primary ms-2">0</span>
                </h3>
            </div>
            <div class="card-body">
                @if(count($projects ?? []))
                    <div class="projects-grid">
                        @foreach($projects as $project)
                            <div class="project-card">
                                <div class="status-badge status-active">
                                    <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i>
                                    Active
                                </div>
                                
                                <h5 class="project-title">
                                    <i class="fas fa-project-diagram"></i>
                                    {{ $project->name }}
                                </h5>
                                
                                <p class="project-description">
                                    {{ $project->description ?? 'No description available' }}
                                </p>
                                
                                <div class="date-info-project">
                                    <div>
                                        <span>Start Date</span>
                                        <div class="date">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                    <div>
                                        <span>Deadline</span>
                                        <div class="date">{{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('projectmanager.projects.tasks', $project->id) }}" class="btn-view-tasks">
                                    <i class="fas fa-eye me-2"></i>View Tasks
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">No Projects Available</h4>
                        <p class="text-muted">There are no projects assigned to you at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Update date and time
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
</body>
</html>