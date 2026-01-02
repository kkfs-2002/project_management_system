@extends('layouts.app')

@section('title', 'Project Manager Attendance')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4" style="margin-top: 125px;">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Project Managers
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projectManagers->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Present Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    use App\Models\Attendance;
                                    $presentToday = Attendance::whereHas('profile', function($q) {
                                            $q->where('role', 'Project Manager')
                                              ->orWhere('job_title', 'Project Manager');
                                        })
                                        ->whereDate('date', \Carbon\Carbon::today())
                                        ->whereNotNull('check_in')
                                        ->count();
                                @endphp
                                {{ $presentToday }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                On Duty Now
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $onDuty = Attendance::whereHas('profile', function($q) {
                                            $q->where('role', 'Project Manager')
                                              ->orWhere('job_title', 'Project Manager');
                                        })
                                        ->whereDate('date', \Carbon\Carbon::today())
                                        ->whereNotNull('check_in')
                                        ->whereNull('check_out')
                                        ->count();
                                @endphp
                                {{ $onDuty }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Absent Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $projectManagers->count() - $presentToday }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>
                            Project Manager Attendance Records
                        </h5>
                        <div class="d-flex gap-2">
                            <!-- Export Button -->
                            <a href="{{ route('superadmin.attendance.export') }}?type=projectmanager" 
                               class="btn btn-sm btn-success">
                                <i class="fas fa-file-export me-1"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('attendance.projectmanager') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted">Project Manager</label>
                                    <select name="profile_id" class="form-select form-select-sm">
                                        <option value="">All Project Managers</option>
                                        @foreach($projectManagers as $pm)
                                            <option value="{{ $pm->id }}" {{ request('profile_id') == $pm->id ? 'selected' : '' }}>
                                                {{ $pm->full_name }} ({{ $pm->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Date</label>
                                    <input type="date" name="date" class="form-control form-control-sm" 
                                           value="{{ request('date') }}">
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Month</label>
                                    <select name="month" class="form-select form-select-sm">
                                        <option value="">All Months</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted">Year</label>
                                    <select name="year" class="form-select form-select-sm">
                                        <option value="">All Years</option>
                                        @for($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-filter me-1"></i> Apply Filters
                                    </button>
                                    
                                    <a href="{{ route('attendance.projectmanager') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Attendance Table -->
                    @if($attendances->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list fa-4x text-muted mb-4 opacity-25"></i>
                                <h4 class="text-muted mb-3">No Attendance Records</h4>
                                <p class="text-muted mb-4">No project managers have recorded attendance for the selected filters</p>
                                <a href="{{ route('attendance.projectmanager') }}" class="btn btn-primary">
                                    <i class="fas fa-redo me-2"></i> Clear Filters
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="attendanceTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder">
                                            #
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Project Manager
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Date
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Check In
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Check Out
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Hours
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">
                                            Status
                                        </th>
                                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                  @foreach($attendances as $index => $attendance)
<tr class="border-bottom" data-attendance-id="{{ $attendance->id }}">
    <td class="ps-4">
        <span class="text-sm fw-semibold">
            {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $index + 1 }}
        </span>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <div class="avatar-wrapper">
                    <img src="{{ $attendance->profile->profile_picture ?? asset('assets/img/default-avatar.png') }}" 
                         class="avatar rounded-circle" 
                         alt="{{ $attendance->profile->full_name ?? 'N/A' }}">
                </div>
            </div>
            <div>
                <h6 class="mb-0 text-sm fw-semibold">{{ $attendance->profile->full_name ?? 'N/A' }}</h6>
                <p class="text-xs text-muted mb-0">
                    <i class="fas fa-id-card me-1"></i>
                    {{ $attendance->profile->employee_id ?? 'N/A' }}
                </p>
            </div>
        </div>
    </td>
    <td>
        <div class="text-sm">
            <div class="fw-semibold">{{ $attendance->date->format('d M Y') }}</div>
            <div class="text-muted">{{ $attendance->date->format('l') }}</div>
        </div>
    </td>
    <td>
        @if($attendance->check_in)
            <div class="text-sm">
                <div class="fw-semibold text-dark">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                </div>
                <div class="text-xs">
                    <span class="badge bg-success-light text-success">Recorded</span>
                </div>
            </div>
        @else
            <span class="badge bg-warning-light text-warning">
                <i class="fas fa-times me-1"></i> Not Checked In
            </span>
        @endif
    </td>
    <td class="check-out-cell">
        @if($attendance->check_out)
            <div class="text-sm">
                <div class="fw-semibold text-dark">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') }}
                </div>
                <div class="text-xs">
                    <span class="badge bg-success-light text-success">Recorded</span>
                </div>
            </div>
        @else
            @if($attendance->check_in)
                <span class="badge bg-info-light text-info">
                    <i class="fas fa-clock me-1"></i> Still Working
                </span>
            @else
                <span class="badge bg-secondary-light text-secondary">
                    <i class="fas fa-user-slash me-1"></i> Not Checked In
                </span>
            @endif
        @endif
    </td>
    <td class="hours-cell">
        @if($attendance->total_hours)
            <div class="text-center">
                <span class="fw-bold text-dark">{{ number_format($attendance->total_hours, 2) }}</span>
                <div class="text-xs text-muted">hours</div>
            </div>
        @elseif($attendance->check_in && !$attendance->check_out)
            <span class="badge bg-warning-light text-warning">
                <i class="fas fa-clock me-1"></i> In Progress
            </span>
        @else
            <span class="text-muted fst-italic">-</span>
        @endif
    </td>
    <td class="status-cell">
        @if($attendance->check_in && $attendance->check_out)
            <span class="badge bg-success text-white">
                <i class="fas fa-check-circle me-1"></i> Completed
            </span>
        @elseif($attendance->check_in && !$attendance->check_out)
            <span class="badge bg-warning text-dark">
                <i class="fas fa-clock me-1"></i> On Duty
            </span>
        @else
            <span class="badge bg-danger text-white">
                <i class="fas fa-user-slash me-1"></i> Absent
            </span>
        @endif
    </td>
    <td class="text-end pe-4">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-primary rounded-start"
                    onclick="viewAttendanceDetails({{ $attendance->id }})"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
            @if($attendance->check_in && !$attendance->check_out)
                <button type="button" 
                        class="btn btn-sm btn-outline-warning mark-checkout-btn"
                        onclick="markAsCheckedOut({{ $attendance->id }}, this)"
                        data-attendance-id="{{ $attendance->id }}"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Mark Check Out">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            @endif
        </div>
    </td>
</tr>
@endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($attendances->hasPages())
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-sm text-muted">
                                    Showing <span class="fw-semibold">{{ $attendances->firstItem() }}</span> to 
                                    <span class="fw-semibold">{{ $attendances->lastItem() }}</span> of 
                                    <span class="fw-semibold">{{ $attendances->total() }}</span> records
                                </div>
                                <div>
                                    {{ $attendances->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Attendance Details -->
<div class="modal fade" id="attendanceDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Attendance Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="attendanceDetailsContent">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewAttendanceDetails(id) {
    console.log('Loading attendance details for ID:', id);
   
    const modalContent = document.getElementById('attendanceDetailsContent');
    modalContent.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading attendance details...</p>
        </div>`;
   
    // Show modal first
    const modal = new bootstrap.Modal(document.getElementById('attendanceDetailsModal'));
    modal.show();
   
    // Fetch data
    fetch(`/superadmin/attendance/${id}/details`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            console.log('API Response:', result);
           
            if (!result.success) {
                throw new Error(result.message || 'Failed to load details');
            }
           
            const data = result.data;
           
            const modalContentHTML = `
                <div class="attendance-details">
                    <!-- Header -->
                    <div class="bg-light p-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar-lg">
                                    <img src="${data.profile_picture}"
                                         class="rounded-circle border border-3 border-primary"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col">
                                <h4 class="mb-1">${data.full_name}</h4>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-id-card me-1"></i>${data.employee_id}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-briefcase me-1"></i>${data.role}
                                </p>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-${data.overall_status === 'Completed' ? 'success' : data.overall_status === 'Checked In' ? 'warning' : 'danger'} fs-6 p-2">
                                    ${data.overall_status}
                                </span>
                            </div>
                        </div>
                    </div>
                   
                    <!-- Date Info -->
                    <div class="p-4 border-bottom">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-calendar me-2"></i>Date
                                </h6>
                                <h4 class="mb-0">${data.date_formatted}</h4>
                                <p class="text-muted mb-0">${data.day}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-2"></i>Working Hours
                                </h6>
                                <h4 class="mb-0 text-primary">${data.total_hours}</h4>
                            </div>
                        </div>
                    </div>
                   
                    <!-- Time Details -->
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-sign-in-alt me-2"></i>Check In
                                        </h6>
                                        <div class="display-4 fw-bold ${data.check_in_status === 'Late' ? 'text-warning' : 'text-success'} mb-2">
                                            ${data.check_in_time}
                                        </div>
                                        ${data.check_in_full ? `<p class="text-muted small">${data.check_in_full}</p>` : ''}
                                       
                                        ${data.check_in_status ? `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_in_status === 'Late' ? 'warning' : 'success'}">
                                                    <i class="fas fa-${data.check_in_status === 'Late' ? 'exclamation-triangle' : 'check-circle'} me-1"></i>
                                                    ${data.check_in_status}
                                                </span>
                                            </div>
                                        ` : `
                                            <div class="mt-3">
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Not Checked In
                                                </span>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-sign-out-alt me-2"></i>Check Out
                                        </h6>
                                        <div class="display-4 fw-bold ${data.check_out_status === 'Early Leave' ? 'text-warning' : 'text-success'} mb-2">
                                            ${data.check_out_time}
                                        </div>
                                        ${data.check_out_full ? `<p class="text-muted small">${data.check_out_full}</p>` : ''}
                                       
                                        ${data.check_out_status ? `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_out_status === 'Early Leave' ? 'warning' : 'success'}">
                                                    <i class="fas fa-${data.check_out_status === 'Early Leave' ? 'exclamation-triangle' : 'check-circle'} me-1"></i>
                                                    ${data.check_out_status}
                                                </span>
                                            </div>
                                        ` : `
                                            <div class="mt-3">
                                                <span class="badge bg-${data.check_in_time !== 'Not Checked In' ? 'warning' : 'danger'}">
                                                    <i class="fas fa-${data.check_in_time !== 'Not Checked In' ? 'clock' : 'user-slash'} me-1"></i>
                                                    ${data.check_in_time !== 'Not Checked In' ? 'Still Working' : 'Not Checked In'}
                                                </span>
                                            </div>
                                        `}
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <!-- Summary -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert ${data.overall_status === 'Completed' ? 'alert-success' : data.overall_status === 'Checked In' ? 'alert-warning' : 'alert-danger'}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-${data.overall_status === 'Completed' ? 'check-circle' : data.overall_status === 'Checked In' ? 'clock' : 'exclamation-triangle'} fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="alert-heading">${data.overall_status}</h5>
                                            <p class="mb-0">
                                                ${data.full_name} ${data.overall_status === 'Completed' ?
                                                    'has completed their working day.' :
                                                    data.overall_status === 'Checked In' ?
                                                    'is currently working.' :
                                                    'was absent today.'}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!-- Footer -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary" onclick="printAttendanceDetails(${data.attendance_id})">
                            <i class="fas fa-print me-2"></i> Print
                        </button>
                    </div>
                </div>`;
           
            document.getElementById('attendanceDetailsContent').innerHTML = modalContentHTML;
           
        })
        .catch(error => {
            console.error('Error loading attendance details:', error);
            document.getElementById('attendanceDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="alert alert-danger mx-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3 text-danger"></i>
                        <h5 class="alert-heading">Error Loading Details</h5>
                        <p class="mb-3">${error.message || 'Please try again later'}</p>
                        <button type="button" class="btn btn-primary" onclick="viewAttendanceDetails(${id})">
                            <i class="fas fa-redo me-2"></i> Retry
                        </button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                    </div>
                </div>`;
        });
}
function printAttendanceDetails(id) {
    // Simple print functionality
    const printContent = document.getElementById('attendanceDetailsContent').innerHTML;
    const originalContent = document.body.innerHTML;
   
    document.body.innerHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Attendance Details</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                @media print {
                    body { padding: 20px; }
                    .no-print { display: none !important; }
                }
                .print-header {
                    border-bottom: 2px solid #333;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                }
                .print-footer {
                    border-top: 1px solid #ccc;
                    margin-top: 30px;
                    padding-top: 10px;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="print-header">
                    <h3>Attendance Details</h3>
                    <p class="text-muted">Printed on ${new Date().toLocaleDateString()} at ${new Date().toLocaleTimeString()}</p>
                </div>
                ${printContent}
                <div class="print-footer text-center">
                    © ${new Date().getFullYear()} - Attendance Management System
                </div>
            </div>
        </body>
        </html>
    `;
   
    window.print();
    document.body.innerHTML = originalContent;
    location.reload(); // Reload to restore original state
}
function markAsCheckedOut(id, button) {
    console.log('Mark checkout clicked for ID:', id);  // Debug log

    if (confirm('Are you sure you want to mark this project manager as checked out?')) {
        // Show loading on button
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        button.disabled = true;

        // Get CSRF (fallback to meta if needed)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch(`/superadmin/attendance/${id}/checkout`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({})  // Empty body if no extra data
        })
        .then(response => {
            console.log('Response status:', response.status);  // Debug
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Success data:', data);  // Debug
            if (data.success) {
                showToast('success', data.message);  // Your toast function
                updateAttendanceRow(id, data.data);  // Update UI without reload
            } else {
                showToast('error', data.message || 'Unknown error');
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);  // Debug
            showToast('error', 'Network error: ' + error.message);
            button.innerHTML = originalHTML;
            button.disabled = false;
        });
    }
}
// Function to update the table row without page reload
function updateAttendanceRow(id, data) {
    const row = document.querySelector(`tr[data-attendance-id="${id}"]`);
    if (!row) {
        console.log('Row not found for ID:', id);
        // Fallback: reload the page
        setTimeout(() => {
            location.reload();
        }, 1500);
        return;
    }
   
    console.log('Updating row for ID:', id, 'with data:', data);
   
    // Update check-out cell
    const checkOutCell = row.querySelector('.check-out-cell');
    if (checkOutCell) {
        const checkOutTime = data.check_out_time || new Date().toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
       
        checkOutCell.innerHTML = `
            <div class="text-sm">
                <div class="fw-semibold text-dark">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    ${checkOutTime}
                </div>
                <div class="text-xs">
                    <span class="badge bg-success-light text-success">Recorded</span>
                </div>
            </div>
        `;
    }
   
    // Update hours cell
    const hoursCell = row.querySelector('.hours-cell');
    if (hoursCell) {
        const totalHours = data.total_hours || '0.00';
        hoursCell.innerHTML = `
            <div class="text-center">
                <span class="fw-bold text-dark">${parseFloat(totalHours).toFixed(2)}</span>
                <div class="text-xs text-muted">hours</div>
            </div>
        `;
    }
   
    // Update status cell
    const statusCell = row.querySelector('.status-cell');
    if (statusCell) {
        statusCell.innerHTML = `
            <span class="badge bg-success text-white">
                <i class="fas fa-check-circle me-1"></i> Completed
            </span>
        `;
    }
   
    // Hide checkout button
    const checkoutBtn = row.querySelector('.mark-checkout-btn');
    if (checkoutBtn) checkoutBtn.remove();
}
// Toast notification function
function showToast(type, message) {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());
   
    // Create toast
    const toast = document.createElement('div');
    toast.className = `toast-notification alert alert-${type} alert-dismissible fade show`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s ease-out;
    `;
   
    toast.innerHTML = `
        <strong>${type === 'success' ? '✓ Success!' : '✗ Error!'}</strong>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
   
    document.body.appendChild(toast);
   
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}
// Add CSS for slide in animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
   
    // Auto refresh every 5 minutes
    setInterval(() => {
        if (!document.getElementById('attendanceDetailsModal').classList.contains('show')) {
            location.reload();
        }
    }, 300000);
});
</script>


</script>
@endsection

@section('styles')
<style>
/* Custom Styles for Professional UI */
:root {
    --primary: #4e73df;
    --success: #1cc88a;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --info: #36b9cc;
    --light: #f8f9fc;
    --dark: #5a5c69;
}

.container-fluid {
    padding: 1.5rem;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 0.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.card.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

/* Stat Cards */
.stat-card {
    border-left: 0.25rem solid !important;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.border-left-primary { border-color: var(--primary) !important; }
.border-left-success { border-color: var(--success) !important; }
.border-left-warning { border-color: var(--warning) !important; }
.border-left-danger { border-color: var(--danger) !important; }

/* Avatar Styling */
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.avatar-lg {
    width: 150px;
    height: 150px;
}

.avatar-wrapper {
    position: relative;
}

.avatar-wrapper::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--success);
    border: 2px solid #fff;
}

/* Table Styling */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-bottom: 2px solid #e3e6f0;
    text-transform: uppercase;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: var(--dark);
    padding: 1rem 1.25rem;
    background-color: var(--light);
}

.table tbody td {
    padding: 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #e3e6f0;
    font-size: 0.875rem;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

/* Badge Styling */
.badge {
    padding: 0.35em 0.65em;
    font-weight: 600;
    border-radius: 0.375rem;
}

.bg-success-light {
    background-color: rgba(28, 200, 138, 0.1) !important;
    color: var(--success) !important;
}

.bg-warning-light {
    background-color: rgba(246, 194, 62, 0.1) !important;
    color: #856404 !important;
}

.bg-danger-light {
    background-color: rgba(231, 74, 59, 0.1) !important;
    color: var(--danger) !important;
}

.bg-info-light {
    background-color: rgba(54, 185, 204, 0.1) !important;
    color: var(--info) !important;
}

.bg-secondary-light {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: #6c757d !important;
}

/* Button Styling */
.btn-outline-primary {
    border-width: 1px;
}

.btn-sm.rounded-circle {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

.btn-group .btn:first-child {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.btn-group .btn:last-child {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

/* Form Control Styling */
.form-control, .form-select {
    border: 1px solid #d1d3e2;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.form-control:focus, .form-select:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

/* Modal Styling */
.modal-content {
    border-radius: 0.5rem;
    border: none;
}

.modal-header {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    padding: 1.25rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

/* Empty State Styling */
.empty-state {
    padding: 3rem 1rem;
}

.empty-state i {
    opacity: 0.5;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .table-responsive {
        border: 1px solid #e3e6f0;
        border-radius: 0.375rem;
    }
    
    .avatar {
        width: 36px;
        height: 36px;
    }
    
    .row.g-3 > div {
        margin-bottom: 1rem;
    }
}
</style>
@endsection