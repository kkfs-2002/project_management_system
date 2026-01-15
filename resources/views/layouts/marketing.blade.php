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
      background-color: #000000;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 6px #000000;
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
    
    /* ================= REMINDER ALERTS STYLES ================= */
    .reminder-alerts-section {
        margin-bottom: 25px;
    }
    
    .reminder-alert-card {
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        border-left: 8px solid;
        display: flex;
        align-items: center;
        transition: all 0.4s ease;
        animation: slideInUp 0.5s ease-out;
        backdrop-filter: blur(10px);
    }
    
    @keyframes slideInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .reminder-alert-card.hidden {
        display: none !important;
    }
    
    .reminder-alert-icon {
        font-size: 32px;
        margin-right: 20px;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
    }
    
    .reminder-content {
        flex: 1;
    }
    
    .reminder-content h4 {
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .reminder-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        font-size: 12px;
        font-weight: bold;
        margin-left: 8px;
    }
    
    .reminder-week-badge {
        margin-top: 8px;
        padding: 5px 12px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Week Specific Styles */
    .reminder-week-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-left-color: #667eea;
    }
    
    .reminder-week-2 {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-left-color: #11998e;
    }
    
    .reminder-week-3 {
        background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%);
        border-left-color: #ff9966;
    }
    
    .reminder-week-4 {
        background: linear-gradient(135deg, #ff5e62 0%, #dc3545 100%);
        border-left-color: #ff5e62;
    }
    
    .reminder-overdue {
        background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
        border-left-color: #a71d2a;
        animation: pulseWarning 2s infinite;
    }
    
    @keyframes pulseWarning {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    
    .alert-controls {
        display: flex;
        gap: 10px;
        margin-left: 15px;
    }
    
    .alert-dismiss-btn,
    .alert-snooze-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .alert-dismiss-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: rotate(90deg);
    }
    
    .alert-snooze-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }
    
    .view-reminders-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-left: 10px;
    }
    
    .view-reminders-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-1px);
    }
    
    /* Auto-Removal Panel */
    .auto-removal-panel {
        background: #1e3c72;
        color: white;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
        border-left: 4px solid #3498db;
    }
    
    .auto-removal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .auto-removal-toggle {
        background: #2a5298;
        border: none;
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .auto-removal-toggle.on {
        background: #28a745;
    }
    
    .demo-controls {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .demo-btn {
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
    }
    
    .demo-btn.add {
        background: #3498db;
        color: white;
    }
    
    .demo-btn.remove {
        background: #e74c3c;
        color: white;
    }
    
    .demo-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    /* Notification Styles */
    .reminder-notification {
        position: fixed;
        top: 80px;
        right: 20px;
        padding: 15px 20px;
        color: white;
        border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        z-index: 9999;
        animation: slideInRight 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 12px;
        max-width: 350px;
    }
    
    .reminder-notification.success {
        background: #28a745;
    }
    
    .reminder-notification.warning {
        background: #ffc107;
        color: #000;
    }
    
    .reminder-notification.info {
        background: #17a2b8;
    }
    
    .reminder-notification.error {
        background: #dc3545;
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    @media (max-width: 768px) {
        .reminder-alert-card {
            flex-direction: column;
            text-align: center;
            padding: 15px;
        }
        
        .reminder-alert-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .alert-controls {
            margin-left: 0;
            margin-top: 15px;
            width: 100%;
            justify-content: center;
        }
        
        .auto-removal-header {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
        
        .demo-controls {
            flex-direction: column;
        }
    }
    /* ================= END REMINDER ALERTS STYLES ================= */
    
    /* Attendance Card Styles */
    .attendance-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 30px;
    }
    .attendance-status {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .time-display {
        font-size: 2rem;
        font-weight: bold;
        margin: 15px 0;
    }
    .btn-attendance {
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-check-in {
        background-color: #10b981;
        border: none;
    }
    .btn-check-in:hover:not(:disabled) {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
    }
    .btn-check-out {
        background-color: #ef4444;
        border: none;
    }
    .btn-check-out:hover:not(:disabled) {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
    }
    .btn-attendance:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .attendance-info {
        background-color: rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
    /* Dashboard Stats */
    .dashboard-stats {
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 4px solid;
    }
    .stat-total { border-left-color: #007bff; }
    .stat-active { border-left-color: #28a745; }
    .stat-inactive { border-left-color: #6c757d; }
    .stat-reminders { border-left-color: #ffc107; }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
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
/* Blue themed attendance card */
.attendance-card {
    background: linear-gradient(135deg, #000015ff, #040441ff); /* deep blue gradient */
    color: white !important;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
}
/* Titles, text, icons all turn white */
.attendance-card h3,
.attendance-card p,
.attendance-card .h5,
.attendance-card strong,
.attendance-card i {
    color: white !important;
}
/* Time + Date display */
.time-display,
.attendance-status {
    font-size: 20px;
    font-weight: 600;
    color: #e8f1ff !important;
}
/* Alerts */
.attendance-card .alert {
    background: rgba(255,255,255,0.15);
    border: none;
    color: #ffffff !important;
}
/* Buttons */
.btn-check-in {
    background-color: #28a745 !important;
    border: none;
    color: white;
}
.btn-check-out {
    background-color: #dc3545 !important;
    border: none;
    color: white;
}
/* History button */
.btn-light.btn-sm {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white !important;
}
/* Image animation stays same */
.attendance-illustration {
    width: 100%;
    max-width: 580px;
    opacity: 0;
    transform: translateX(-40px) translateY(0) scale(1);
    animation: fadeSlideFloat 2s ease-out forwards, floatAnim 3s ease-in-out 2s infinite;
}
@keyframes fadeSlideFloat {
    to {
        opacity: 1;
        transform: translateX(0) translateY(0) scale(1);
    }
}
@keyframes floatAnim {
    0% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-10px) scale(1.03); }
    100% { transform: translateY(0) scale(1); }
}
/* ============================
   SALARY SECTION - BLUE THEME
   ============================ */
/* Main Card */
.salary-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    background: #f8faff;
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.10);
}
/* Header */
.salary-card .card-header {
    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    color: #fff !important;
    border-bottom: none;
    padding: 18px 22px;
}
/* Table Styling */
.salary-card table {
    border-radius: 10px;
    overflow: hidden;
}
.salary-card thead {
    background: #e3eefd !important;
}
.salary-card tbody tr:hover {
    background: rgba(30, 60, 114, 0.08);
}
/* Amount */
.text-salary {
    color: #0d6efd !important;
    font-weight: 600;
}
/* Badges */
.badge.bg-success {
    background-color: #03072bff !important;
}
.badge.bg-warning {
    background-color: #f1c40f !important;
    color: black !important;
}
.badge.bg-info {
    background-color: #3498db !important;
}
/* Summary Cards */
.summary-card {
    border-radius: 14px;
    background: linear-gradient(135deg, #eef5ff, #d6e4ff);
    border: none;
    box-shadow: 0 4px 14px rgba(0,0,0,0.1);
}
.summary-card h4 {
    font-weight: bold;
}
/* Footer */
.salary-card .card-footer {
    background: #f0f4ff !important;
    border-top: none;
}
/* Contact Button */
.btn-outline-success {
    color: #1e3c72 !important;
    border-color: #1e3c72 !important;
}
.btn-outline-success:hover {
    background: #1e3c72 !important;
    color: #fff !important;
}
/* Details Button */
.btn-outline-success.view-salary {
    border-color: #2a5298 !important;
    color: #2a5298 !important;
}
.btn-outline-success.view-salary:hover {
    background: #2a5298 !important;
    color: white !important;
}
/* Modal Header */
#marketingSalaryModal .modal-header {
    background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
    color: white !important;
}
/* Print button */
#marketingSalaryModal .btn-success {
    background: #1e3c72 !important;
    border: none;
}
#marketingSalaryModal .btn-success:hover {
    background: #2a5298 !important;
}
  /* Footer */
    .footer {
      background: #000000 ; 
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
    
    /* Additional Styles for Projects Section */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .bg-info-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .no-projects-illustration {
        opacity: 0.5;
    }
    /* Project Details Modal Styles */
    #projectDetailsContent .project-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    #projectDetailsContent .detail-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    #projectDetailsContent .detail-item:last-child {
        border-bottom: none;
    }
    #projectDetailsContent .call-timeline {
        position: relative;
        padding-left: 30px;
    }
    #projectDetailsContent .call-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #007bff;
    }
    #projectDetailsContent .timeline-item {
        position: relative;
        margin-bottom: 15px;
    }
    #projectDetailsContent .timeline-item::before {
        content: '';
        position: absolute;
        left: -25px;
        top: 8px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
        border: 2px solid white;
    }
    /* Reminder Alert Styles */
    .reminder-item {
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 4px solid #ffc107;
        background: #fff8e1;
    }
    .reminder-item.passed {
        border-left-color: #dc3545;
        background: #f8d7da;
    }
    .reminder-item.today {
        border-left-color: #ffc107;
        background: #fff3cd;
    }
    .reminder-item.upcoming {
        border-left-color: #17a2b8;
        background: #d1ecf1;
    }
    /* Edit Button Styles */
    .btn-group .btn {
        margin-right: 5px;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #000;
    }
  </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('marketing.dashboard') }}">
      <img src="{{ asset('NetIT logo.png') }}" alt="Marketing Manager" />
      <span>Welcome, {{ $marketing->full_name ?? 'Marketing Manager' }}</span>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-chart-line me-1"></i> Reports
          </a>
          <ul class="dropdown-menu" aria-labelledby="reportDropdown">
            <li><a class="dropdown-item" href="{{ route('marketing.clients.report') }}">📅 Monthly Client Report</a></li>
            <li><a class="dropdown-item" href="{{ route('marketing.clients.summary') }}">📊 Client Summary Chart</a></li>
          </ul>
        </li>
        <!-- Day Updates Tasks -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="tasksDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-target me-1"></i> Day Updates Tasks
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('marketing.daily-tasks.index') }}">Daily Tasks</a></li>
            </ul>
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
<div style="margin-top: 40px;">
    @yield('content')
</div>
  <!-- Attendance Section - Only show on dashboard -->
@if(request()->routeIs('marketing.dashboard'))
<div class="row mb-5 mt-5 d-flex align-items-center justify-content-center">
    <!-- LEFT SIDE IMAGE WITH ANIMATION -->
    <div class="col-lg-5 text-center">
        <img src="/images/team.png"
             class="img-fluid attendance-illustration"
             alt="Attendance Illustration">
    </div>
    <!-- RIGHT SIDE ATTENDANCE CARD WITH FORM -->
    <div class="col-lg-5">
        <div class="attendance-card shadow-lg p-4 rounded-4">
            <div class="text-center mb-3">
                <h3 class="fw-bold">
                    <i class="fas fa-clock me-2 text-primary"></i>My Attendance
                </h3>
            </div>
            <!-- Current Time -->
            <div class="time-display mb-2 text-center" id="currentTime">Loading...</div>
            <div class="attendance-status mb-3 text-center" id="currentDate">Loading...</div>
            <!-- Success / Error Alerts -->
            @if(session('attendance_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('attendance_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('attendance_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('attendance_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <!-- Attendance Details -->
            @if(isset($todayAttendance))
                <div class="attendance-info mb-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <p class="m-0"><strong>Check In:</strong></p>
                            <p class="h5">{{ $todayAttendance->check_in ? \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A') : '-' }}</p>
                        </div>
                        <div class="col-6">
                            <p class="m-0"><strong>Check Out:</strong></p>
                            <p class="h5">{{ $todayAttendance->check_out ? \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A') : '-' }}</p>
                        </div>
                    </div>
                    @if($todayAttendance->check_in && $todayAttendance->check_out)
                        <div class="text-center mt-2">
                            <p class="m-0"><strong>Total Hours:</strong></p>
                            <p class="h5">
                                @php
                                    $checkIn = \Carbon\Carbon::parse($todayAttendance->check_in);
                                    $checkOut = \Carbon\Carbon::parse($todayAttendance->check_out);
                                    $diff = $checkIn->diff($checkOut);
                                @endphp
                                {{ $diff->h }}h {{ $diff->i }}m
                            </p>
                        </div>
                    @endif
                </div>
            @endif
            <!-- Buttons -->
            <div class="text-center mt-3">
                @if(isset($todayAttendance) && $todayAttendance->check_in && $todayAttendance->check_out)
                    <div class="alert alert-light">
                        <i class="fas fa-check-circle me-2"></i>You have completed your attendance today!
                    </div>
                @else
                    <div class="d-flex gap-3 justify-content-center">
                        <!-- Check In -->
                        <form action="{{ route('marketing.attendance.checkin') }}" method="POST" id="checkin-form">
                            @csrf
                            <input type="hidden" name="timezone" id="timezone-input">
                            <button type="submit" class="btn btn-success px-4"
                                @if(isset($todayAttendance) && $todayAttendance->check_in) disabled @endif>
                                <i class="fas fa-sign-in-alt me-2"></i>Check In
                            </button>
                        </form>
                        <!-- Check Out -->
                        <form action="{{ route('marketing.attendance.checkout') }}" method="POST" id="checkout-form">
                            @csrf
                            <input type="hidden" name="timezone" id="timezone-input-out">
                            <button type="submit" class="btn btn-danger px-4"
                                @if(!isset($todayAttendance) || !$todayAttendance->check_in) disabled @endif>
                                <i class="fas fa-sign-out-alt me-2"></i>Check Out
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('marketing.attendance.history') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-history me-2"></i>View Attendance History
                </a>
            </div>
        </div>
    </div>
</div>
@endif
</div>

<!-- Reminder Alerts Section - Add this before Projects Table -->
@if(auth()->check() && auth()->user()->role === 'Marketing Manager' && request()->routeIs('marketing.dashboard'))
<div class="row mb-5 mt-5">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #020d1eff, #1a237e); border-radius: 15px 15px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-bell me-3"></i>Reminder Alerts
                    </h4>
                    <div>
                        <button class="btn btn-sm btn-outline-light" onclick="refreshReminderAlerts()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="reminder-alerts-section" id="reminderAlertsContainer">
                    <!-- Reminder alerts will be dynamically loaded here -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading reminders...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading reminder alerts...</p>
                    </div>
                </div>
                
                <!-- Auto-Removal Panel will be added by JavaScript -->
            </div>
        </div>
    </div>
</div>
@endif

<!-- Marketing Projects Table - Show only on dashboard, NOT on create/edit pages -->
@if(auth()->check() && auth()->user()->role === 'Marketing Manager' && request()->routeIs('marketing.dashboard'))
<div class="row mb-5 mt-5">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #020d1eff, #1a237e); border-radius: 15px 15px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-briefcase me-3"></i>My Marketing Projects
                        @if(isset($marketingProjects) && $marketingProjects->count() > 0)
                            <span class="badge bg-light text-dark ms-2">{{ $marketingProjects->count() }}</span>
                        @endif
                    </h4>
                    <div>
                        <a href="{{ route('marketing.projects.create') }}" class="btn btn-sm btn-outline-light me-2" title="Create New Project">
                            <i class="fas fa-plus"></i> Create
                        </a>
                        <button class="btn btn-sm btn-outline-light" id="refreshProjects">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
         
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <!-- Reminder Alert Banner -->
                @php
                    $today = now()->toDateString();
                    $passedReminders = 0;
                    $todayReminders = 0;
                    $upcomingReminders = 0;
                   
                    if(isset($marketingProjects)) {
                        foreach($marketingProjects as $project) {
                            if($project->reminder_date) {
                                $reminderDate = \Carbon\Carbon::parse($project->reminder_date)->toDateString();
                                if($reminderDate < $today) {
                                    $passedReminders++;
                                } elseif($reminderDate == $today) {
                                    $todayReminders++;
                                } else {
                                    $upcomingReminders++;
                                }
                            }
                        }
                    }
                   
                    $totalReminders = $passedReminders + $todayReminders + $upcomingReminders;
                @endphp
                @if($totalReminders > 0)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" style="border-left: 5px solid #ffc107;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bell fa-2x me-3 text-warning"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1"><i class="fas fa-calendar-day me-2"></i> Reminder Alerts</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @if($passedReminders > 0)
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $passedReminders }} Passed
                                </span>
                                @endif
                                @if($todayReminders > 0)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-bell me-1"></i> {{ $todayReminders }} Today
                                </span>
                                @endif
                                @if($upcomingReminders > 0)
                                <span class="badge bg-info">
                                    <i class="fas fa-clock me-1"></i> {{ $upcomingReminders }} Upcoming
                                </span>
                                @endif
                            </div>
                            <p class="mb-0 mt-2">
                                <button class="btn btn-sm btn-outline-warning" onclick="showReminderDetails()">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                            </p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
                @endif
                @if(isset($marketingProjects) && $marketingProjects->count() > 0)
                    <!-- Stats Summary -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-card stat-total">
                                <div class="stat-number text-primary">
                                    {{ $marketingProjects->count() }}
                                </div>
                                <div class="stat-label">Total Projects</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-card stat-active">
                                <div class="stat-number text-success">
                                    {{ $marketingProjects->where('status', 'active')->count() }}
                                </div>
                                <div class="stat-label">Active</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-card stat-inactive">
                                <div class="stat-number text-warning">
                                    {{ $marketingProjects->where('status', 'hold')->count() }}
                                </div>
                                <div class="stat-label">On Hold</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-card stat-reminders">
                                <div class="stat-number text-info">
                                    {{ $totalReminders }}
                                </div>
                                <div class="stat-label">Reminders</div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Projects Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">Client</th>
                                    <th>Contact</th>
                                    <th>Project Details</th>
                                    <th>Status</th>
                                    <th>Reminder</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($marketingProjects as $project)
                                @php
                                    $reminderStatus = '';
                                    $reminderBadge = '';
                                    $reminderText = '';
                                   
                                    if($project->reminder_date) {
                                        $reminderDate = \Carbon\Carbon::parse($project->reminder_date);
                                        $today = \Carbon\Carbon::today();
                                        if($reminderDate->lt($today)) {
                                            $reminderStatus = 'passed';
                                            $reminderBadge = 'bg-danger';
                                            $reminderText = $reminderDate->format('d M');
                                        } elseif($reminderDate->eq($today)) {
                                            $reminderStatus = 'today';
                                            $reminderBadge = 'bg-warning';
                                            $reminderText = 'Today';
                                        } else {
                                            $reminderStatus = 'upcoming';
                                            $reminderBadge = 'bg-info';
                                            $reminderText = $reminderDate->format('d M');
                                        }
                                    }
                                @endphp
                                <tr class="hover-shadow">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-3">
                                                {{ substr($project->client_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ $project->client_name }}</strong>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($project->date)->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <span>{{ $project->phone_number }}</span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-comment-alt me-1"></i>{{ $project->contact_method }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="project-info">
                                            <div class="mb-1">
                                                <span class="badge bg-info-subtle text-info me-2">{{ $project->project_type }}</span>
                                                <span class="badge bg-light text-dark">{{ $project->project_category }}</span>
                                            </div>
                                            <div class="text-success fw-bold">
                                                <i class="fas fa-money-bill-wave me-1"></i>
                                                Rs. {{ number_format($project->project_price, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($project->status === 'active')
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="fas fa-play-circle me-1"></i> Active
                                            </span>
                                        @elseif($project->status === 'hold')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                                <i class="fas fa-pause-circle me-1"></i> Hold
                                            </span>
                                        @elseif($project->status === 'completed')
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                <i class="fas fa-clock me-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->reminder_date)
                                            @if($reminderStatus === 'passed')
                                                <span class="badge {{ $reminderBadge }} rounded-pill px-3 py-2" title="Reminder passed on {{ \Carbon\Carbon::parse($project->reminder_date)->format('d M Y') }}">
                                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $reminderText }}
                                                </span>
                                            @elseif($reminderStatus === 'today')
                                                <span class="badge {{ $reminderBadge }} text-dark rounded-pill px-3 py-2" title="Reminder is today!">
                                                    <i class="fas fa-bell me-1"></i> {{ $reminderText }}
                                                </span>
                                            @else
                                                <span class="badge {{ $reminderBadge }} rounded-pill px-3 py-2" title="Reminder on {{ \Carbon\Carbon::parse($project->reminder_date)->format('d M Y') }}">
                                                    <i class="fas fa-clock me-1"></i> {{ $reminderText }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted rounded-pill px-3 py-2">
                                                <i class="fas fa-ban me-1"></i> None
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-info view-project-details"
                                                    data-project-id="{{ $project->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#projectDetailsModal"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <a href="{{ route('marketing.projects.edit', $project->id) }}" class="btn btn-sm btn-warning" title="Edit Project">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3 no-projects-illustration"></i>
                        <h5 class="text-muted">No projects yet</h5>
                        <p class="text-muted">Start by creating your first marketing project.</p>
                        <a href="{{ route('marketing.projects.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Create First Project
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Project Details Modal -->
<div class="modal fade" id="projectDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #020d1eff, #1a237e);">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Project Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-4" id="projectDetailsContent">
                    <!-- Content will be loaded by JavaScript -->
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
                <button type="button" class="btn btn-primary" id="printProjectDetails">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Reminder Details Modal -->
<div class="modal fade" id="reminderDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #ff9966, #ff5e62);">
                <h5 class="modal-title">
                    <i class="fas fa-bell me-2"></i>Reminder Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-4" id="reminderDetailsContent">
                    <!-- Content will be loaded by JavaScript -->
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
                <button type="button" class="btn btn-warning" onclick="printReminderDetails()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Salary Section - Only show on dashboard -->
@if(request()->routeIs('marketing.dashboard'))
<div class="row mb-4">
   <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background-color: #020d1eff;">
            <h5 class="mb-0">
                <i class="fas fa-money-bill-wave me-2"></i>My Salary Details
            </h5>
        </div>
            <div class="card-body">
                @if(isset($salaryDetails) && $salaryDetails->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Paid Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryDetails as $salary)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($salary->salary_month)->format('F Y') }}</td>
                                        <td class="fw-bold text-success">Rs. {{ number_format($salary->amount, 2) }}</td>
                                        <td>
                                            @if($salary->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salary->payment_method)
                                                <span class="badge bg-info">
                                                    {{ ucfirst(str_replace('_', ' ', $salary->payment_method)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salary->status == 'paid' && $salary->updated_at)
                                                {{ \Carbon\Carbon::parse($salary->updated_at)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success view-salary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#marketingSalaryModal"
                                                    data-salary='@json($salary)'>
                                                <i class="fas fa-file-invoice-dollar"></i> Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  
                    <!-- Salary Summary -->
                    @if(isset($salarySummary))
                    <div class="row mt-4">
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">This Month</h6>
                                    <h4 class="text-primary mb-0">
                                        Rs. {{ number_format($salarySummary['current_month'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Last Month</h6>
                                    <h4 class="text-success mb-0">
                                        Rs. {{ number_format($salarySummary['last_month'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Year Total</h6>
                                    <h4 class="text-info mb-0">
                                        Rs. {{ number_format($salarySummary['year_total'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-light">
                                <div class="card-body text-center py-3">
                                    <h6 class="text-muted mb-1">Pending</h6>
                                    <h4 class="text-warning mb-0">
                                        Rs. {{ number_format($salarySummary['pending'] ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                  
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No salary records available</h5>
                        <p class="text-muted">Your salary information will be visible here once processed by accounts department.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Salary information is confidential and secure
                    </small>
                    <a href="mailto:accounts@netit.lk?subject=Salary Inquiry" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-envelope me-1"></i> Contact Accounts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Marketing Salary Modal -->
<div class="modal fade" id="marketingSalaryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Salary Slip Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="salary-details-content">
                    <!-- Content will be loaded by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="printSalarySlip()">
                    <i class="fas fa-print me-1"></i> Print Slip
                </button>
            </div>
        </div>
    </div>
</div>
@endif
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
          <a href="https://www.facebook.com/share/1BqiRiXiP5/" title="Facebook"><i class="fab fa-facebook-f"></i></a>
       <a href="https://netittechnology.com/" target="_blank" title="Website">
    <i class="fas fa-globe"></i>
</a>
      
        </div>
      </div>
    
      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="footer-links">
          <li><a href="{{ route('marketing.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
          <li><a href="{{ route('marketing.clients.index') }}"><i class="fas fa-user-tie"></i> Clients</a></li>
          <li><a href="{{ route('marketing.clients.report') }}"><i class="fas fa-chart-line"></i> Reports</a></li>
          <li><a href="{{ route('marketing.daily-tasks.index') }}"><i class="fas fa-clipboard-check"></i> Day Updates Tasks</a></li>
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
    <a href="mailto:info@netittechnology.com">
        info@netittechnology.com
    </a>
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
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Get user's timezone
const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

// Reminder Alert System
let autoRemovalEnabled = false;
let reminderCounts = {
    overdue: 0,
    week1: 0,
    week2: 0,
    week3: 0,
    week4: 0
};

// Initialize reminder alerts
document.addEventListener('DOMContentLoaded', function() {
    initializeReminderAlerts();
    
    // Set timezone in hidden inputs
    const timezoneInputCheckin = document.getElementById('timezone-input');
    const timezoneInputCheckout = document.getElementById('timezone-input-out');
    
    if (timezoneInputCheckin) {
        timezoneInputCheckin.value = userTimezone;
    }
    if (timezoneInputCheckout) {
        timezoneInputCheckout.value = userTimezone;
    }
    
    // Real-time clock update with user's local time
    updateTime();
    setInterval(updateTime, 1000);
    
    // Typing Script
    typeWriter("Welcome to NetIT Technology....!", "typingText");
});

// Reminder Alert Functions
function initializeReminderAlerts() {
    // Load auto-removal setting
    const savedSetting = localStorage.getItem('autoRemovalEnabled');
    if (savedSetting === 'true') {
        autoRemovalEnabled = true;
    }
    
    // Load existing project data and create alerts
    if (typeof marketingProjectsData !== 'undefined' && marketingProjectsData.length > 0) {
        createReminderAlertsFromProjects();
    }
    
    // Setup auto-removal panel
    setTimeout(setupAutoRemovalPanel, 500);
    
    // Check auto-removal logic
    setTimeout(checkAutoRemoval, 1000);
}

function createReminderAlertsFromProjects() {
    const today = new Date();
    const projectsWithReminders = marketingProjectsData.filter(p => p.reminder_date);
    
    // Reset counts
    reminderCounts = { overdue: 0, week1: 0, week2: 0, week3: 0, week4: 0 };
    
    // Count by week
    projectsWithReminders.forEach(project => {
        const reminderDate = new Date(project.reminder_date);
        const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
        
        if (reminderDate < today) {
            reminderCounts.overdue++;
        } else if (diffDays < 7) {
            reminderCounts.week1++;
        } else if (diffDays < 14) {
            reminderCounts.week2++;
        } else if (diffDays < 21) {
            reminderCounts.week3++;
        } else {
            reminderCounts.week4++;
        }
    });
    
    // Clear existing alerts
    const container = document.getElementById('reminderAlertsContainer');
    if (!container) return;
    
    container.innerHTML = '';
    
    // Create header
    const totalAlerts = Object.values(reminderCounts).reduce((a, b) => a + b, 0);
    if (totalAlerts === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-muted">No Active Reminders</h5>
                <p class="text-muted">All your reminders are up to date!</p>
            </div>
        `;
        return;
    }
    
    // Create alerts based on counts
    if (reminderCounts.overdue > 0) {
        createReminderAlert({
            week: 'overdue',
            count: reminderCounts.overdue,
            title: 'Overdue Reminders',
            message: 'Project reminder(s) have passed their due date',
            icon: 'fas fa-exclamation-triangle',
            weekText: 'Urgent Attention Needed'
        });
    }
    
    if (reminderCounts.week1 > 0) {
        createReminderAlert({
            week: 'week-1',
            count: reminderCounts.week1,
            title: 'This Week Reminders',
            message: 'Project reminder(s) are due this week',
            icon: 'fas fa-calendar-week',
            weekText: 'Current Week'
        });
    }
    
    if (reminderCounts.week2 > 0) {
        createReminderAlert({
            week: 'week-2',
            count: reminderCounts.week2,
            title: 'Next Week Reminders',
            message: 'Project reminder(s) are due next week',
            icon: 'fas fa-calendar-alt',
            weekText: 'Next Week'
        });
    }
    
    if (reminderCounts.week3 > 0) {
        createReminderAlert({
            week: 'week-3',
            count: reminderCounts.week3,
            title: 'Week 3 Reminders',
            message: 'Project reminder(s) are due in two weeks',
            icon: 'fas fa-calendar-check',
            weekText: 'In Two Weeks'
        });
    }
    
    if (reminderCounts.week4 > 0) {
        createReminderAlert({
            week: 'week-4',
            count: reminderCounts.week4,
            title: 'Final Week Reminders',
            message: 'Project reminder(s) are due in three weeks or more',
            icon: 'fas fa-calendar-times',
            weekText: 'Final Week (3+ weeks)'
        });
    }
}

function createReminderAlert(alertData) {
    const container = document.getElementById('reminderAlertsContainer');
    if (!container) return;
    
    const alertHTML = `
        <div id="reminderAlert-${alertData.week}" 
             class="reminder-alert-card reminder-${alertData.week}">
            <div class="reminder-alert-icon">
                <i class="${alertData.icon}"></i>
            </div>
            <div class="reminder-content">
                <h4>
                    ${alertData.title}
                    <span class="reminder-count-badge">${alertData.count}</span>
                    <button onclick="showWeekReminders('${alertData.week}')" class="view-reminders-btn">
                        <i class="fas fa-eye"></i> View
                    </button>
                </h4>
                <p class="mb-1">${alertData.message}</p>
                <div class="reminder-week-badge">${alertData.weekText}</div>
            </div>
            <div class="alert-controls">
                <button onclick="snoozeReminderAlert('${alertData.week}')" class="alert-snooze-btn" title="Snooze for 24 hours">
                    <i class="fas fa-clock"></i>
                </button>
                <button onclick="dismissReminderAlert('${alertData.week}')" class="alert-dismiss-btn" title="Dismiss">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', alertHTML);
}

function setupAutoRemovalPanel() {
    const projectsCard = document.querySelector('.projects-card .card-body');
    if (!projectsCard) return;
    
    // Check if panel already exists
    if (document.getElementById('autoRemovalPanel')) return;
    
    const panelHTML = `
        <div class="auto-removal-panel mt-4" id="autoRemovalPanel">
            <div class="auto-removal-header">
                <h6 class="mb-0">
                    <i class="fas fa-robot me-2"></i> Auto-Removal Settings
                </h6>
                <button id="autoRemovalToggle" class="auto-removal-toggle">
                    <i class="fas fa-toggle-off me-1"></i>
                    <span id="toggleText">Auto-Removal: OFF</span>
                </button>
            </div>
            <p class="small mb-0">
                <i class="fas fa-info-circle me-1"></i>
                When enabled: Week 4 alerts will automatically hide Week 1 alerts
            </p>
            <div class="demo-controls">
                <button onclick="simulateAddWeek4Alert()" class="demo-btn add">
                    <i class="fas fa-plus me-1"></i> Add Week 4 Alert
                </button>
                <button onclick="simulateRemoveWeek4Alert()" class="demo-btn remove">
                    <i class="fas fa-minus me-1"></i> Remove Week 4 Alert
                </button>
            </div>
        </div>
    `;
    
    projectsCard.insertAdjacentHTML('beforeend', panelHTML);
    
    // Update toggle button state
    updateAutoRemovalToggle();
    
    // Add event listener
    document.getElementById('autoRemovalToggle').addEventListener('click', toggleAutoRemoval);
}

function toggleAutoRemoval() {
    autoRemovalEnabled = !autoRemovalEnabled;
    localStorage.setItem('autoRemovalEnabled', autoRemovalEnabled);
    updateAutoRemovalToggle();
    
    if (autoRemovalEnabled) {
        checkAutoRemoval();
        showReminderNotification('Auto-removal enabled: Week 4 alerts will hide Week 1 alerts', 'success');
    } else {
        // Show Week 1 alert if it was hidden
        const week1Alert = document.getElementById('reminderAlert-week-1');
        if (week1Alert && week1Alert.style.display === 'none') {
            week1Alert.style.display = 'flex';
            localStorage.removeItem('week1AutoHidden');
        }
        showReminderNotification('Auto-removal disabled', 'warning');
    }
}

function updateAutoRemovalToggle() {
    const toggleBtn = document.getElementById('autoRemovalToggle');
    const toggleText = document.getElementById('toggleText');
    
    if (toggleBtn && toggleText) {
        if (autoRemovalEnabled) {
            toggleBtn.innerHTML = '<i class="fas fa-toggle-on me-1"></i><span id="toggleText">Auto-Removal: ON</span>';
            toggleBtn.classList.add('on');
            toggleText.textContent = 'Auto-Removal: ON';
        } else {
            toggleBtn.innerHTML = '<i class="fas fa-toggle-off me-1"></i><span id="toggleText">Auto-Removal: OFF</span>';
            toggleBtn.classList.remove('on');
            toggleText.textContent = 'Auto-Removal: OFF';
        }
    }
}

function checkAutoRemoval() {
    if (!autoRemovalEnabled) return;
    
    const week4Alert = document.getElementById('reminderAlert-week-4');
    const week1Alert = document.getElementById('reminderAlert-week-1');
    
    // If Week 4 alert exists and Week 1 alert exists, hide Week 1
    if (week4Alert && week1Alert) {
        week1Alert.style.display = 'none';
        localStorage.setItem('week1AutoHidden', 'true');
    } else if (week1Alert && localStorage.getItem('week1AutoHidden') === 'true') {
        // If Week 4 is removed, show Week 1 again
        week1Alert.style.display = 'flex';
        localStorage.removeItem('week1AutoHidden');
    }
}

function simulateAddWeek4Alert() {
    // Check if Week 4 alert already exists
    let week4Alert = document.getElementById('reminderAlert-week-4');
    
    if (week4Alert) {
        // Update count
        reminderCounts.week4++;
        const countElement = week4Alert.querySelector('.reminder-count-badge');
        if (countElement) {
            countElement.textContent = reminderCounts.week4;
        }
    } else {
        // Create new Week 4 alert
        createReminderAlert({
            week: 'week-4',
            count: 1,
            title: 'Final Week Reminders',
            message: 'Project reminder(s) are due in three weeks or more',
            icon: 'fas fa-calendar-times',
            weekText: 'Final Week (3+ weeks)'
        });
        reminderCounts.week4 = 1;
    }
    
    // Check auto-removal
    checkAutoRemoval();
    
    showReminderNotification('Week 4 alert added successfully', 'success');
}

function simulateRemoveWeek4Alert() {
    const week4Alert = document.getElementById('reminderAlert-week-4');
    if (week4Alert) {
        week4Alert.remove();
        reminderCounts.week4 = 0;
        
        // Check if Week 1 should be shown again
        checkAutoRemoval();
        
        showReminderNotification('Week 4 alert removed', 'warning');
    } else {
        showReminderNotification('No Week 4 alert to remove', 'info');
    }
}

function dismissReminderAlert(week) {
    const alert = document.getElementById(`reminderAlert-${week}`);
    if (alert) {
        alert.classList.add('hidden');
        
        // Store dismissal in localStorage
        const dismissedAlerts = JSON.parse(localStorage.getItem('dismissedAlerts') || '[]');
        if (!dismissedAlerts.includes(week)) {
            dismissedAlerts.push(week);
            localStorage.setItem('dismissedAlerts', JSON.stringify(dismissedAlerts));
        }
        
        showReminderNotification(`Reminder for ${week} dismissed`, 'info');
    }
}

function snoozeReminderAlert(week) {
    const alert = document.getElementById(`reminderAlert-${week}`);
    if (alert) {
        alert.style.opacity = '0.5';
        
        // Store snooze in localStorage for 24 hours
        const snoozedAlerts = JSON.parse(localStorage.getItem('snoozedAlerts') || '{}');
        snoozedAlerts[week] = Date.now() + (24 * 60 * 60 * 1000);
        localStorage.setItem('snoozedAlerts', JSON.stringify(snoozedAlerts));
        
        showReminderNotification(`Reminder for ${week} snoozed for 24 hours`, 'info');
        
        // Auto remove snooze after 24 hours
        setTimeout(() => {
            if (alert) {
                alert.style.opacity = '1';
                delete snoozedAlerts[week];
                localStorage.setItem('snoozedAlerts', JSON.stringify(snoozedAlerts));
            }
        }, 24 * 60 * 60 * 1000);
    }
}

function showWeekReminders(week) {
    if (!marketingProjectsData || marketingProjectsData.length === 0) {
        showReminderNotification('No project data available', 'info');
        return;
    }
    
    const today = new Date();
    const projectsWithReminders = marketingProjectsData.filter(p => p.reminder_date);
    
    let filteredProjects = [];
    let title = '';
    
    switch(week) {
        case 'overdue':
            filteredProjects = projectsWithReminders.filter(p => new Date(p.reminder_date) < today);
            title = 'Overdue Reminders';
            break;
        case 'week-1':
            filteredProjects = projectsWithReminders.filter(p => {
                const reminderDate = new Date(p.reminder_date);
                const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
                return diffDays >= 0 && diffDays < 7;
            });
            title = 'This Week Reminders';
            break;
        case 'week-2':
            filteredProjects = projectsWithReminders.filter(p => {
                const reminderDate = new Date(p.reminder_date);
                const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
                return diffDays >= 7 && diffDays < 14;
            });
            title = 'Next Week Reminders';
            break;
        case 'week-3':
            filteredProjects = projectsWithReminders.filter(p => {
                const reminderDate = new Date(p.reminder_date);
                const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
                return diffDays >= 14 && diffDays < 21;
            });
            title = 'Week 3 Reminders';
            break;
        case 'week-4':
            filteredProjects = projectsWithReminders.filter(p => {
                const reminderDate = new Date(p.reminder_date);
                const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
                return diffDays >= 21;
            });
            title = 'Final Week Reminders';
            break;
    }
    
    if (filteredProjects.length === 0) {
        showReminderNotification('No projects found for this category', 'info');
        return;
    }
    
    // Show in modal
    const modalBody = document.getElementById('reminderDetailsContent');
    let content = `
        <h5 class="mb-3">${title} (${filteredProjects.length})</h5>
        <div class="list-group">
    `;
    
    filteredProjects.forEach(project => {
        const reminderDate = new Date(project.reminder_date);
        const isOverdue = reminderDate < today;
        
        content += `
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${project.client_name}</h6>
                    <small class="${isOverdue ? 'text-danger' : 'text-success'}">
                        ${reminderDate.toLocaleDateString()}
                    </small>
                </div>
                <p class="mb-1">${project.project_type} - ${project.project_category}</p>
                <small>Phone: ${project.phone_number}</small>
            </div>
        `;
    });
    
    content += `</div>`;
    modalBody.innerHTML = content;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('reminderDetailsModal'));
    modal.show();
}

function showReminderNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `reminder-notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 
                           type === 'warning' ? 'exclamation-triangle' : 
                           type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function refreshReminderAlerts() {
    const refreshBtn = document.querySelector('[onclick="refreshReminderAlerts()"]');
    if (refreshBtn) {
        const originalHTML = refreshBtn.innerHTML;
        refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        setTimeout(() => {
            createReminderAlertsFromProjects();
            checkAutoRemoval();
            refreshBtn.innerHTML = originalHTML;
            showReminderNotification('Reminder alerts refreshed', 'success');
        }, 1000);
    }
}

// Existing functions from your code
function updateTime() {
    const now = new Date();
    
    // Update time display
    const timeString = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });
    
    // Update date display
    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateString = now.toLocaleDateString('en-US', dateOptions);
    
    const timeElement = document.getElementById('currentTime');
    const dateElement = document.getElementById('currentDate');
    
    if (timeElement) {
        timeElement.textContent = timeString;
    }
    if (dateElement) {
        dateElement.textContent = dateString;
    }
}

function typeWriter(text, elementId, speed = 50) {
    let i = 0;
    const element = document.getElementById(elementId);
    if (!element) return;
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    type();
}

function showLoader(event, message) {
    const button = event.target.querySelector('button[type="submit"]');
    if (button) {
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + message;
        button.disabled = true;
    }
}

// Existing project functions
var marketingProjectsData = @json($marketingProjects ?? []);

document.addEventListener('DOMContentLoaded', function() {
    // Refresh projects button
    document.getElementById('refreshProjects')?.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        setTimeout(() => {
            location.reload();
        }, 500);
    });
  
    // View project details
    const viewButtons = document.querySelectorAll('.view-project-details');
  
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.dataset.projectId;
          
            // Show loading animation
            document.getElementById('projectDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading project details...</p>
                </div>
            `;
          
            // Fetch project details via AJAX
            fetch(`/marketing/projects/${projectId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        const project = data.project;
                        const reminderDate = project.reminder_date ? new Date(project.reminder_date) : null;
                        const today = new Date();
                        let reminderStatus = '';
                        let reminderBadge = '';
                        let reminderText = '';
                       
                        if(reminderDate) {
                            if(reminderDate < today) {
                                reminderStatus = 'passed';
                                reminderBadge = 'danger';
                                reminderText = 'Reminder date has passed';
                            } else if(reminderDate.toDateString() === today.toDateString()) {
                                reminderStatus = 'today';
                                reminderBadge = 'warning';
                                reminderText = 'Reminder is today!';
                            } else {
                                reminderStatus = 'upcoming';
                                reminderBadge = 'info';
                                reminderText = 'Reminder pending';
                            }
                        }
                        const content = `
                            <div class="project-header">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="mb-1">${project.client_name}</h4>
                                        <div class="d-flex align-items-center">
                                            <span class="badge ${project.status === 'active' ? 'bg-success' : project.status === 'hold' ? 'bg-warning' : project.status === 'completed' ? 'bg-primary' : 'bg-secondary'} me-2">
                                                ${project.status?.charAt(0).toUpperCase() + project.status?.slice(1)}
                                            </span>
                                            <span class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                ${new Date(project.date).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' })}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h3 class="text-success mb-0">
                                            Rs. ${Number(project.project_price).toLocaleString('en-US', {minimumFractionDigits: 2})}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <h6><i class="fas fa-user text-primary me-2"></i>Client Information</h6>
                                        <p class="mb-1"><strong>Name:</strong> ${project.client_name}</p>
                                        <p class="mb-1"><strong>Phone:</strong> ${project.phone_number}</p>
                                        <p><strong>Contact Method:</strong> ${project.contact_method}</p>
                                    </div>
                                  
                                    <div class="detail-item">
                                        <h6><i class="fas fa-project-diagram text-primary me-2"></i>Project Details</h6>
                                        <p class="mb-1"><strong>Type:</strong> ${project.project_type}</p>
                                        <p class="mb-1"><strong>Category:</strong> ${project.project_category}</p>
                                        <p><strong>Call Sequence:</strong> ${project.call_sequence}</p>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <h6><i class="fas fa-history text-primary me-2"></i>Call Timeline</h6>
                                        <div class="call-timeline mt-3">
                                            ${project.first_call_date ? `
                                                <div class="timeline-item">
                                                    <strong>1st Call:</strong><br>
                                                    <small>${new Date(project.first_call_date).toLocaleDateString()}</small>
                                                </div>
                                            ` : ''}
                                            ${project.second_call_date ? `
                                                <div class="timeline-item">
                                                    <strong>2nd Call:</strong><br>
                                                    <small>${new Date(project.second_call_date).toLocaleDateString()}</small>
                                                </div>
                                            ` : ''}
                                            ${project.third_call_date ? `
                                                <div class="timeline-item">
                                                    <strong>3rd Call:</strong><br>
                                                    <small>${new Date(project.third_call_date).toLocaleDateString()}</small>
                                                </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                   
                                    <div class="detail-item">
                                        <h6><i class="fas fa-bell text-primary me-2"></i>Reminder Information</h6>
                                        <p class="mb-1">
                                            <strong>Reminder Date:</strong>
                                            ${reminderDate ? reminderDate.toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Not set'}
                                        </p>
                                        ${reminderDate ? `
                                            <p class="mb-1">
                                                <strong>Status:</strong>
                                                <span class="badge bg-${reminderBadge}">
                                                    ${reminderText}
                                                </span>
                                            </p>
                                        ` : ''}
                                        ${reminderDate && reminderDate < today ? `
                                            <div class="alert alert-danger py-2 mt-2">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                This reminder has passed its due date. Please take action.
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                          
                            ${project.comments ? `
                                <div class="detail-item mt-3">
                                    <h6><i class="fas fa-comment-dots text-primary me-2"></i>Comments</h6>
                                    <div class="alert alert-light border">
                                        <i class="fas fa-quote-left text-muted me-2"></i>
                                        ${project.comments}
                                    </div>
                                </div>
                            ` : ''}
                          
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-user-cog me-1"></i>
                                        Assigned to: You
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Last updated: ${new Date(project.updated_at).toLocaleDateString()}
                                    </small>
                                </div>
                            </div>
                        `;
                        document.getElementById('projectDetailsContent').innerHTML = content;
                    } else {
                        document.getElementById('projectDetailsContent').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Failed to load project details. Please try again.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('projectDetailsContent').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error loading project details. Please check your connection.
                        </div>
                    `;
                });
        });
    });
  
    // Print project details
    document.getElementById('printProjectDetails')?.addEventListener('click', function() {
        const modalContent = document.getElementById('projectDetailsContent').innerHTML;
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Project Details</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                    .detail-section { margin-bottom: 20px; }
                    .detail-section h4 { color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 5px; }
                    .timeline-item { margin-left: 20px; position: relative; padding-left: 15px; }
                    .timeline-item::before { content: '•'; position: absolute; left: 0; color: #007bff; font-size: 20px; }
                    @media print {
                        .no-print { display: none; }
                        body { font-size: 12pt; }
                    }
                </style>
            </head>
            <body>
                ${modalContent}
                <div class="no-print text-center mt-4">
                    <button onclick="window.print()" class="btn btn-primary">Print</button>
                    <button onclick="window.close()" class="btn btn-secondary">Close</button>
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
    });
});

// Existing reminder details function
function showReminderDetails() {
    if (!marketingProjectsData || marketingProjectsData.length === 0) {
        showReminderNotification('No project data available.', 'info');
        return;
    }
    
    const projectsWithReminders = marketingProjectsData.filter(p => p.reminder_date);
    
    if (projectsWithReminders.length === 0) {
        showReminderNotification('No projects with reminders found.', 'info');
        return;
    }
    
    // Sort by reminder date
    projectsWithReminders.sort((a, b) => new Date(a.reminder_date) - new Date(b.reminder_date));
    
    const today = new Date();
    
    let modalContent = `
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-bell"></i> All Reminders (${projectsWithReminders.length})
            </h2>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <div style="padding: 20px; max-height: 400px; overflow-y: auto;">
            <div style="display: grid; gap: 12px;">
    `;
    
    projectsWithReminders.forEach(project => {
        const reminderDate = new Date(project.reminder_date);
        const isOverdue = reminderDate < today;
        const isToday = reminderDate.toDateString() === today.toDateString();
        
        let weekClass = '';
        let borderColor = '#6c757d';
        
        if (isOverdue) {
            weekClass = 'Overdue';
            borderColor = '#dc3545';
        } else {
            const diffDays = Math.ceil((reminderDate - today) / (1000 * 60 * 60 * 24));
            if (diffDays < 7) {
                weekClass = 'Week 1';
                borderColor = '#2575fc';
            } else if (diffDays < 14) {
                weekClass = 'Week 2';
                borderColor = '#38ef7d';
            } else if (diffDays < 21) {
                weekClass = 'Week 3';
                borderColor = '#ff9966';
            } else {
                weekClass = 'Week 4';
                borderColor = '#ff5e62';
            }
        }
        
        modalContent += `
            <div style="padding: 12px; border-radius: 8px; background: #f8f9fa; border-left: 4px solid ${borderColor};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <strong style="color: #333;">${project.client_name}</strong>
                            <span style="font-size: 11px; padding: 2px 8px; border-radius: 10px; background: ${borderColor}; color: white;">
                                ${weekClass}
                            </span>
                            ${isToday ? '<span style="font-size: 11px; padding: 2px 8px; border-radius: 10px; background: #ffc107; color: #000;"><i class="fas fa-bell"></i> Today</span>' : ''}
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; font-size: 12px; color: #666;">
                            <div><i class="fas fa-project-diagram"></i> ${project.project_type.replace(/_/g, ' ')}</div>
                            <div><i class="fas fa-calendar-day"></i> ${reminderDate.toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})}</div>
                            <div><i class="fas fa-user-tie"></i> ${project.marketing_manager?.user?.name || project.marketing_manager?.full_name || 'N/A'}</div>
                            <div><i class="fas fa-phone"></i> ${project.phone_number}</div>
                        </div>
                    </div>
                    <button onclick="viewProject(${project.id}); closeModal();" 
                            style="padding: 6px 12px; background: ${borderColor}; color: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer; margin-left: 10px;">
                        View
                    </button>
                </div>
            </div>
        `;
    });
    
    modalContent += `
            </div>
        </div>
    `;
    
    document.getElementById('modalBody').innerHTML = modalContent;
    document.getElementById('projectModal').classList.add('active');
}

// Existing salary modal functions
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-salary');
  
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const salary = JSON.parse(this.dataset.salary);
            const content = `
                <div class="salary-slip">
                    <div class="text-center mb-4">
                        <h4 class="text-success">NET IT TECHNOLOGY</h4>
                        <p class="text-muted mb-0">Salary Slip</p>
                    </div>
                  
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Employee:</strong> Marketing Manager</p>
                            <p><strong>Month:</strong> ${new Date(salary.salary_month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</p>
                            <p><strong>Payment Status:</strong>
                                ${salary.status === 'paid'
                                    ? '<span class="badge bg-success">Paid</span>'
                                    : '<span class="badge bg-warning">Pending</span>'}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Method:</strong> ${salary.payment_method ? salary.payment_method.replace('_', ' ').toUpperCase() : 'N/A'}</p>
                            <p><strong>Processed Date:</strong> ${salary.updated_at ? new Date(salary.updated_at).toLocaleDateString() : 'N/A'}</p>
                            <p><strong>Record ID:</strong> ${salary.id}</p>
                        </div>
                    </div>
                  
                    <hr>
                  
                    <div class="salary-breakdown">
                        <h6 class="mb-3">Salary Breakdown</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Basic Salary</strong></td>
                                        <td class="text-end">Rs. ${Number(salary.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Allowances</strong></td>
                                        <td class="text-end">Rs. 0.00</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Deductions</strong></td>
                                        <td class="text-end">Rs. 0.00</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Net Salary</strong></td>
                                        <td class="text-end fw-bold">Rs. ${Number(salary.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                    ${salary.notes ? `
                        <div class="notes-section mt-3">
                            <h6>Notes</h6>
                            <div class="alert alert-info">
                                ${salary.notes}
                            </div>
                        </div>
                    ` : ''}
                  
                    <div class="signature-section mt-4 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <p class="border-top pt-2">Employee Signature</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="border-top pt-2">Authorized Signature</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
          
            document.getElementById('salary-details-content').innerHTML = content;
        });
    });
});

function printSalarySlip() {
    const content = document.getElementById('salary-details-content').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Salary Slip</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .salary-slip { max-width: 800px; margin: 0 auto; }
                .table { width: 100%; border-collapse: collapse; }
                .table th, .table td { border: 1px solid #ddd; padding: 8px; }
                .text-end { text-align: right; }
                .text-center { text-align: center; }
                .border-top { border-top: 1px solid #000; }
                .fw-bold { font-weight: bold; }
                .alert-info { background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 10px; border-radius: 4px; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            ${content}
            <div class="no-print text-center mt-4">
                <button onclick="window.print()" class="btn btn-success">Print</button>
                <button onclick="window.close()" class="btn btn-secondary">Close</button>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}

function printReminderDetails() {
    const modalContent = document.getElementById('reminderDetailsContent').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reminder Details</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                .reminder-section { margin-bottom: 20px; padding: 15px; border-radius: 5px; }
                .reminder-section.passed { background: #f8d7da; border-left: 4px solid #dc3545; }
                .reminder-section.today { background: #fff3cd; border-left: 4px solid #ffc107; }
                .reminder-section.upcoming { background: #d1ecf1; border-left: 4px solid #17a2b8; }
                @media print {
                    .no-print { display: none; }
                    body { font-size: 11pt; }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h2>Reminder Details Report</h2>
                <p>Generated on ${new Date().toLocaleDateString()}</p>
            </div>
            ${modalContent}
            <div class="no-print text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary">Print</button>
                <button onclick="window.close()" class="btn btn-secondary">Close</button>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
@yield('scripts')
</body>
</html>