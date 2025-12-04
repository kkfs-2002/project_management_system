<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Super Admin Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
   <!-- Add Chart.js CDN HERE -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow-x: hidden; /* Prevent horizontal scroll */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    .navbar-custom {
      background-color: #000000;
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
    
    /* Main content container fixes */
    .main-content-wrapper {
      width: 100%;
      max-width: 100%;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      flex: 1;
    }
    
    /* Footer Styles */
    .footer {
      background: #000000;
      color: #fff;
      padding: 50px 0 20px;
      margin-top: auto;
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
    
    /* Quick contact form */
    .newsletter-form {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }
    
    .newsletter-form input {
      flex: 1;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }
    
    .newsletter-form input::placeholder {
      color: #b0b0b0;
    }
    
    .newsletter-form button {
      background: #A7C7E7;
      color: #000;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
    }
    
    .newsletter-form button:hover {
      background: #8ab3e0;
      transform: translateY(-2px);
    }
    
    /* Mobile-specific adjustments for stacking brand and toggler */
    @media (max-width: 991.98px) {
      .navbar-custom .container-fluid {
        flex-direction: column;
        align-items: flex-start;
      }
      .navbar-custom .navbar-brand {
        margin-bottom: 0;
        order: 1;
      }
      .navbar-custom .navbar-toggler {
        order: 2;
        margin-bottom: 0.125rem;
      }
      .navbar-custom .navbar-collapse {
        order: 3;
        width: 100%;
      }
      /* Add left padding to mobile menu items for indentation */
      .navbar-custom .navbar-collapse .navbar-nav {
        padding-left: 1rem;
        width: 100%;
      }
      .navbar-custom .navbar-collapse .navbar-nav .nav-item {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
      }
      .navbar-custom .navbar-collapse .navbar-nav .nav-link,
      .navbar-custom .navbar-collapse .navbar-nav .dropdown-toggle {
        padding-left: 0.5rem;
        border-left: 3px solid transparent;
        transition: border-left-color 0.2s ease;
      }
      .navbar-custom .navbar-collapse .navbar-nav .nav-link:hover,
      .navbar-custom .navbar-collapse .navbar-nav .dropdown-toggle:hover {
        border-left-color: #A7C7E7;
      }
      
      /* Footer mobile adjustments */
      .footer {
        padding: 30px 0 20px;
      }
      
      .footer .col-md-3 {
        margin-bottom: 30px;
      }
      
      .newsletter-form {
        flex-direction: column;
      }
    }
    
    @media (max-width: 768px) {
      .social-links {
        justify-content: center;
      }
      
      .footer h5 {
        font-size: 1rem;
      }
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
            <li><a class="dropdown-item" href="{{ route('superadmin.employee.view') }}">Employee Daily updates</a></li>
          </ul>
        </li>
       
        <!--Mark attendance-->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="attendanceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-clipboard-check me-1"></i> View Attendance
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="attendanceDropdown">
            <li><a class="dropdown-item" href="{{ route('attendance.developer') }}">Developer Attendance view</a></li>
           <li><a class="dropdown-item" href="{{ route('attendance.projectmanager') }}">Project Managers Attendance view</a></li>
           <li><a class="dropdown-item" href="{{ route('attendance.marketingmanager') }}">Marketing Manager Attendance view</a></li>
          </ul>
        </li>
                <!-- Tasks -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-folder-open me-1"></i> Projects
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsDropdown">
                <li><a class="dropdown-item" href="{{ route('superadmin.tasks.add') }}">Add New Projects</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.tasks.create') }}">Assigned projects</a></li>
                        <li><a class="dropdown-item" href="{{ route('superadmin.tasks.index') }}">View projects</a></li>
                    
          </ul>
        </li>
        <!-- Finance -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-money-bill-wave me-1"></i> Accounts
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="financeDropdown">
            <li><a class="dropdown-item" href="{{ route('superadmin.project.index') }}">New Projects Financial Entry</a></li>
            <li><a class="dropdown-item" href="{{ route('superadmin.project.transactions') }}">View All Transactions</a></li>
             <li><a class="dropdown-item" href="{{ route('superadmin.project.monthly-profit') }}">Monthly-Profit</a></li>
              <li><a class="dropdown-item" href="{{ route('superadmin.project.yearly-profit') }}">Yearly-profit/a></li>
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
<div class="main-content-wrapper">
  @yield('content')
</div>

<!-- Footer Section -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-lg-4 col-md-6 mb-4">
        <img src="{{ asset('NetIT logo.png') }}" alt="NetIT Technology" class="company-logo">
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
              +94 76 151 7778
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
        <div class="col-md-6">
          
        </div>
      </div>
    </div>
  </div>
</footer>

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

<!-- Footer JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Newsletter form submission
  const newsletterForm = document.querySelector('.newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const email = this.querySelector('input[type="email"]').value;
      
      // Simulate form submission
      const button = this.querySelector('button');
      const originalText = button.innerHTML;
      
      button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      button.disabled = true;
      
      setTimeout(() => {
        alert('Thank you for subscribing to our newsletter!');
        this.reset();
        button.innerHTML = originalText;
        button.disabled = false;
      }, 1500);
    });
  }
  
  // Smooth scroll for footer links
  document.querySelectorAll('.footer-links a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
  
  // Social media links handler
  document.querySelectorAll('.social-links a').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const platform = this.title.toLowerCase();
      alert(`Redirecting to our ${platform} page...`);
      // In real implementation, you would use: window.open(this.href, '_blank');
    });
  });
});
</script>
</body>
</html>