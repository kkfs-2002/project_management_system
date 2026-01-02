@extends('layouts.projectmanager')
@php
    $hideWelcome = true;
@endphp
@section('content')
<div class="container-fluid" style="margin-top: 5rem;">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1">
                        <i class="fas fa-history me-2 text-primary"></i>Attendance History
                    </h2>
                    <p class="text-muted mb-0">View your attendance records</p>
                </div>
                <a href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    <!-- Summary Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 summary-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar-check fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Days</h6>
                            <h3 class="mb-0">{{ $attendances->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 summary-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">This Month</h6>
                            <h3 class="mb-0">{{ $attendances->where('date', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 summary-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Avg Hours</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalMinutes = 0;
                                    $completeDays = 0;
                                    foreach($attendances as $att) {
                                        if($att->check_in && $att->check_out) {
                                            $totalMinutes += \Carbon\Carbon::parse($att->check_in)->diffInMinutes(\Carbon\Carbon::parse($att->check_out));
                                            $completeDays++;
                                        }
                                    }
                                    $avgHours = $completeDays > 0 ? number_format($totalMinutes / $completeDays / 60, 1) : 0;
                                @endphp
                                {{ $avgHours }}h
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 summary-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Hours</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalHours = floor($totalMinutes / 60);
                                @endphp
                                {{ $totalHours }}h
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Attendance Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-2 mb-md-0">
                    <i class="fas fa-list me-2"></i>Attendance Records
                </h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 attendance-table">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="py-3">Day</th>
                            <th class="py-3">Check In</th>
                            <th class="py-3">Check Out</th>
                            <th class="py-3">Total Hours</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td data-label="Date" class="px-4 py-3">
                                <strong>{{ $attendance->date->format('M d, Y') }}</strong>
                            </td>
                            <td data-label="Day" class="py-3">
                                <span class="badge bg-light text-dark">
                                    {{ $attendance->date->format('l') }}
                                </span>
                            </td>
                            <td data-label="Check In" class="py-3">
                                @if($attendance->check_in)
                                    <span class="text-success">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td data-label="Check Out" class="py-3">
                                @if($attendance->check_out)
                                    <span class="text-danger">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td data-label="Total Hours" class="py-3">
                                @if($attendance->check_in && $attendance->check_out)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                        $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                        $diff = $checkIn->diff($checkOut);
                                    @endphp
                                    <span class="badge bg-info">
                                        {{ $diff->h }}h {{ $diff->i }}m
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td data-label="Status" class="py-3 text-center">
                                @if($attendance->check_in && $attendance->check_out)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Complete
                                    </span>
                                @elseif($attendance->check_in)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>In Progress
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-minus-circle me-1"></i>Incomplete
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="text-muted small mb-2 mb-md-0">
                        Showing {{ $attendances->firstItem() ?? 0 }} to {{ $attendances->lastItem() ?? 0 }}
                        of {{ $attendances->total() }} records
                    </div>
                    <div>
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No Attendance Records Found</h5>
                <p class="text-muted">Start tracking your attendance from the dashboard.</p>
                <a href="{{ route('projectmanager.dashboard', $pm->id ?? 1) }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Go to Dashboard
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer class="footer mt-auto">
  <div class="container">
    <div class="row">
      <!-- Company Info -->
      <div class="col-lg-4 col-md-6 col-12 mb-4">
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
      <div class="col-lg-2 col-md-6 col-6 mb-4">
        <h5>Quick Links</h5>
        <ul class="footer-links">
          <li><a href="{{ route('superadmin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
          <li><a href="{{ route('superadmin.employee.index') }}"><i class="fas fa-tasks"></i> Tasks</a></li>
          <li><a href="{{ route('projectmanager.daily-tasks.index') }}"><i class="fas fa-clipboard-check"></i> Day Updates Tasks</a></li>
        </ul>
      </div>
      
      <!-- Services -->
      <div class="col-lg-2 col-md-6 col-6 mb-4">
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
      <div class="col-lg-4 col-md-6 col-12 mb-4">
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

@push('styles')
<style>
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

/* Ensure Bootstrap .mt-3 is properly defined/enforced */
.mt-3 {
    margin-top: 1rem !important;
}

/* Mobile Responsiveness for Attendance History */
@media (max-width: 768px) {
    /* Header adjustments */
    .d-flex.justify-content-between.flex-wrap {
        gap: 1rem;
    }
    h2 {
        font-size: 1.5rem;
    }

    /* Summary cards */
    .summary-card .card-body {
        padding: 1rem;
    }
    .summary-card .d-flex.align-items-center {
        gap: 0.75rem;
    }
    .summary-card h6 {
        font-size: 0.875rem;
    }
    .summary-card h3 {
        font-size: 1.5rem;
    }
    .rounded-circle.p-3 {
        padding: 1.5rem !important;
    }
    .fa-2x {
        font-size: 1.5rem;
    }

    /* Table responsiveness */
    .attendance-table {
        border: 0;
    }
    .attendance-table thead {
        display: none;
    }
    .attendance-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        background-color: #fff;
    }
    .attendance-table td {
        display: block;
        text-align: right;
        padding: 0.5rem 0;
        border: none;
        position: relative;
        padding-left: 50%;
    }
    .attendance-table td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 45%;
        padding-right: 1rem;
        white-space: nowrap;
        font-weight: bold;
        text-align: left;
        color: #6c757d;
    }
    .attendance-table .px-4 {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .attendance-table .text-center {
        text-align: right;
    }
    .attendance-table .badge {
        display: inline-block;
        white-space: nowrap;
    }

    /* Pagination and footer */
    .card-footer .d-flex.flex-wrap {
        gap: 1rem;
    }
    .pagination {
        justify-content: center;
    }

    /* Print button */
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    h2 {
        font-size: 1.25rem;
    }
    .summary-card h3 {
        font-size: 1.25rem;
    }
    .attendance-table td {
        padding: 0.375rem 0;
        font-size: 0.875rem;
    }
    .attendance-table td:before {
        font-size: 0.875rem;
    }
}

/* Print styles (unchanged) */
@media print {
    .btn, .pagination, .navbar, .card-header button, .card-header a {
        display: none !important;
    }
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
@endsection